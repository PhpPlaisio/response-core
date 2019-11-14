<?php
declare(strict_types=1);

namespace Plaisio\Response;

use Plaisio\Helper\Url;

/**
 * Redirects the user agent to a specified URL with status code 3xx.
 */
abstract class RedirectResponse extends BaseResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string $url           The URL to redirect the user agent.
   * @param bool   $forceRelative If set the URL will be validated to be a relative URL, if not so the URL will
   *                              be replaced with '/'.
   * @param int    $statusCode    The HTTP status code. See <https://tools.ietf.org/html/rfc7231#page-54> for details
   *                              about HTTP status codes.
   *
   * @since 1.0.0
   * @api
   */
  public function __construct(string $url, bool $forceRelative, int $statusCode)
  {
    parent::__construct('', $statusCode);

    if ($forceRelative && !Url::isRelative($url))
    {
      $url = '/';
    }

    $this->headers->set('Location', $url);

    self::clearOutput();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
