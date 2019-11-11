<?php
declare(strict_types=1);

namespace SetBased\Abc\Response;

use SetBased\Abc\Helper\Cast;
use SetBased\Abc\Response\Helper\HeaderHelper;

/**
 * An HTTP response sending a BLOB to the user agent.
 */
class BlobResponse extends BaseResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param array  $blob        The details of the BLOB.
   * @param string $disposition Either 'inline' or 'attachment'.
   * @param bool   $isStatic    True if and only if the URL always serves the same content.
   * @param bool   $isPublic    True if and only if the content is public.
   *
   * @api
   * @since 1.0.0
   */
  public function __construct(array $blob, string $disposition, bool $isStatic = false, bool $isPublic = false)
  {
    parent::__construct($blob['blb_data'], 200);

    $this->headers->set('Content-Disposition', HeaderHelper::contentDisposition($disposition, $blob['blb_filename']))
                  ->set('Content-Type', $blob['blb_mime_type'])
                  ->set('Content-Length', Cast::toOptString($blob['blb_size']))
                  ->setTimestamp('Last-Modified', $blob['blb_timestamp']);

    if ($isStatic)
    {
      if ($isPublic)
      {
        $this->headers->set('Cache-Control', 'public, store, cache');
      }
      else
      {
        $this->headers->set('Cache-Control', 'private, store, cache');
      }
    }
    else
    {
      $this->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
