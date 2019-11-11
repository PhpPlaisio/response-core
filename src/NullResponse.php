<?php
declare(strict_types=1);

namespace SetBased\Abc\Response;

/**
 * An HTTP response sending nothing (no body, no headers).
 *
 * Use this response when a response to the user agent has been sent already.
 */
class NullResponse implements Response
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sends nothing (no body, no headers).
   *
   * @return $this
   */
  public function send(): Response
  {
    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
