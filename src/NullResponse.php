<?php
declare(strict_types=1);

namespace Plaisio\Response;

/**
 * An HTTP response sending nothing (no body, no headers).
 *
 * Use this response when a response to the user agent has been sent already.
 */
class NullResponse implements Response
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Return an empty string.
   *
   * @return string
   */
  public function getContent(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Return an empty array.
   *
   * @return array
   */
  public function getHeaders(): array
  {
    return [];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns 0.
   *
   * @return int
   */
  public function getStatus(): int
  {
    return 0;
  }

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
