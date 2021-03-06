<?php
declare(strict_types=1);

namespace Plaisio\Response\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\Response\InternalServerErrorResponse;

/**
 * Test cases for class InternalServerErrorResponse.
 */
class InternalServerErrorResponseTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  public function test1()
  {
    $response = new InternalServerErrorResponse();

    self::assertSame('', $response->getContent());
    self::assertSame(500, $response->getStatus());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
