<?php
declare(strict_types=1);

namespace Plaisio\Response\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\Response\MovedPermanentlyResponse;

/**
 * Test cases for class MovedPermanentlyResponse.
 */
class MovedPermanentlyResponseTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test status code.
   */
  public function test1(): void
  {
    $response = new MovedPermanentlyResponse('/');

    self::assertSame('', $response->getContent());
    self::assertSame(301, $response->getStatus());
    self::assertSame('/', $response->headers->get('location'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with absolute url and force relative flag.
   */
  public function testUrlAbsoluteUrl1(): void
  {
    $response = new MovedPermanentlyResponse('https://www.setbased.nl');
    self::assertSame('/', $response->headers->get('location'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with absolute url and without force relative flag.
   */
  public function testUrlAbsoluteUrl2(): void
  {
    $response = new MovedPermanentlyResponse('https://www.setbased.nl', false);
    self::assertSame('https://www.setbased.nl', $response->headers->get('location'));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
