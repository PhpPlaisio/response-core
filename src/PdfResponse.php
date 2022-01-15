<?php
declare(strict_types=1);

namespace Plaisio\Response;

use Plaisio\Response\Helper\HeaderHelper;
use SetBased\Helper\Cast;

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
   *
   * @throws \Exception
   * @api
   *
   * @since 1.0.0
   */
  public function __construct(string $pdf,
                              ?string $filename,
                              string $disposition = 'attachment')
  {
    parent::__construct($pdf);

    $this->headers->set('Content-Type', 'application/pdf')
                  ->set('Content-Length', Cast::toOptString(strlen($pdf)))
                  ->set('Content-Disposition', HeaderHelper::contentDisposition($disposition, $filename))
                  ->set('Cache-Control', HeaderHelper::cacheControl(false, false))
                  ->setTimestamp('Last-Modified', new \DateTimeImmutable());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
