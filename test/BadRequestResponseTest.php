<?php
declare(strict_types=1);

namespace Plaisio\Response\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\Response\BadRequestResponse;

/**
 * Test cases for class BadRequestResponse.
 */
class BadRequestResponseTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  public function test1()
  {
    $response = new BadRequestResponse();

    self::assertSame('', $response->getContent());
    self::assertSame(400, $response->getStatus());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
