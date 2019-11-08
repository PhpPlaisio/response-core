<?php
declare(strict_types=1);

namespace SetBased\Abc\Response;

/**
 * Response for a client or server error.
 */
abstract class ErrorResponse extends BaseResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param int $statusCode The HTTP status code. See <https://tools.ietf.org/html/rfc7231> for details about HTTP
   *                        status codes.
   *
   * @since 1.0.0
   * @api
   */
  public function __construct(int $statusCode)
  {
    parent::__construct('', $statusCode);

    self::clearOutput();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
