<?php
declare(strict_types=1);

namespace SetBased\Abc\Response;

/**
 * Redirects the user agent to a specified URL with status code 303 (See Other).
 */
class SeeOtherResponse extends RedirectResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string $url           The URL to redirect the user agent.
   * @param bool   $forceRelative If set the URL will be validated to be a relative URL, if not so the URL will
   *                              be replaced with '/'.
   *
   * @since 1.0.0
   * @api
   */
  public function __construct(string $url, bool $forceRelative = true)
  {
    parent::__construct($url, $forceRelative, self::STATUS_CODE_SEE_OTHER);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
