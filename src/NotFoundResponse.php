<?php
declare(strict_types=1);

namespace SetBased\Abc\Response;

/**
 * Response for bad request 404 (Not Found).
 */
class NotFoundResponse extends ClientErrorResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   */
  public function __construct()
  {
    parent::__construct(self::STATUS_CODE_NOT_FOUND);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
