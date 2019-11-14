<?php
declare(strict_types=1);

namespace Plaisio\Response;

/**
 * Response for an internal server error 500 (Internal Server Error).
 */
class InternalServerErrorResponse extends ServerErrorResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   */
  public function __construct()
  {
    parent::__construct(self::STATUS_CODE_INTERNAL_SERVER_ERROR);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
