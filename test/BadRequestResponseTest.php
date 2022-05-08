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
  /**
   * Test content is empty.
   */
  public function testContent()
  {
    $response = new BadRequestResponse();

    self::assertSame('', $response->getContent());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test HTTP status is 400.
   */
  public function testStatus()
  {
    $response = new BadRequestResponse();

    self::assertSame(400, $response->getStatus());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
