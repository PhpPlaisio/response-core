<?php
declare(strict_types=1);

namespace SetBased\Abc\Response\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\Response\SeeOtherResponse;

/**
 * Test cases for class SeeOtherResponse.
 */
class SeeOtherResponseTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test status code.
   */
  public function test1(): void
  {
    $response = new SeeOtherResponse('/');

    self::assertSame('', $response->getContent());
    self::assertSame(303, $response->getStatus());
    self::assertSame('/', $response->headers->get('location'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with absolute url and force relative flag.
   */
  public function testUrlAbsoluteUrl1(): void
  {
    $response = new SeeOtherResponse('https:/www.setbased.nl');
    self::assertSame('/', $response->headers->get('location'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with absolute url and without force relative flag.
   */
  public function testUrlAbsoluteUrl2(): void
  {
    $response = new SeeOtherResponse('https:/www.setbased.nl', false);
    self::assertSame('https:/www.setbased.nl', $response->headers->get('location'));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
