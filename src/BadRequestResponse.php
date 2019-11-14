<?php
declare(strict_types=1);

namespace Plaisio\Response;

/**
 * Response for bad request 400 (Bad Request).
 */
class BadRequestResponse extends ClientErrorResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   */
  public function __construct()
  {
    parent::__construct(self::STATUS_CODE_BAD_REQUEST);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
