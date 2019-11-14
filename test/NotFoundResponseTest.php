<?php
declare(strict_types=1);

namespace Plaisio\Response\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\Response\NotFoundResponse;

/**
 * Test cases for class NotFoundResponse.
 */
class NotFoundResponseTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  public function test1()
  {
    $response = new NotFoundResponse();

    self::assertSame('', $response->getContent());
    self::assertSame(404, $response->getStatus());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
