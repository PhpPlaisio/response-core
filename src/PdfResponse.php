<?php
declare(strict_types=1);

namespace SetBased\Abc\Response;

use DateTimeImmutable;
use SetBased\Abc\Helper\Cast;
use SetBased\Abc\Response\Helper\HeaderHelper;

/**
 * An HTTP response sending a dynamically generated PDF document to the user agent.
 */
class PdfResponse extends BaseResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string      $pdf         The PDF document.
   * @param string|null $filename    The filename of the PDF document.
   * @param string      $disposition Either 'inline' or 'attachment'.
   * @param bool        $isPublic    True if and only if the content is public.
   *
   * @throws \Exception
   * @api
   *
   * @since 1.0.0
   */
  public function __construct(string $pdf,
                              ?string $filename,
                              string $disposition = 'attachment',
                              bool $isPublic = false)
  {
    parent::__construct($pdf, 200);

    $this->headers->set('Content-Type', 'application/pdf')
                  ->set('Content-Length', Cast::toOptString(strlen($pdf)))
                  ->set('Content-Disposition', HeaderHelper::contentDisposition($disposition, $filename))
                  ->set('Cache-Control', HeaderHelper::cacheControl(false, $isPublic))
                  ->setTimestamp('Last-Modified', new DateTimeImmutable());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
