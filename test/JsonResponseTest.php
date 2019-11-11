<?php
declare(strict_types=1);

namespace SetBased\Abc\Response\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\Response\JsonResponse;

/**
 * Test cases for class JsonResponse.
 */
class JsonResponseTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with normal data.
   */
  public function testData(): void
  {
    $data = ['hello', 'world'];

    $response = new JsonResponse($data, false);
    $output   = $response->getContent();

    self::assertSame('["hello","world"]', $output);
    self::assertSame('application/json', $response->headers->get('Content-Type'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with normal data.
   */
  public function testDataP(): void
  {
    $data = ['hello', 'world'];

    $response = new JsonResponse($data, false, 'myCallback');
    $output   = $response->getContent();

    self::assertSame('myCallback(["hello","world"]);', $output);
    self::assertSame('application/javascript', $response->headers->get('Content-Type'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with JSON data.
   */
  public function testJson(): void
  {
    $data = json_encode(['hello', 'world']);

    $response = new JsonResponse($data, true);
    $output   = $response->getContent();

    self::assertSame('["hello","world"]', $output);
    self::assertSame('application/json', $response->headers->get('Content-Type'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with JSONP data.
   */
  public function testJsonp(): void
  {
    $data = json_encode(['hello', 'world']);

    $response = new JsonResponse($data, true, 'myCallback');
    $output   = $response->getContent();

    self::assertSame('myCallback(["hello","world"]);', $output);
    self::assertSame('application/javascript', $response->headers->get('Content-Type'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with illegal callback function.
   */
  public function testIllegalCallback(): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Callback not valid');
    new JsonResponse([], false, ':not-valid');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with illegal JSON.
   */
  public function testIllegalJson(): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Expecting a string');
    new JsonResponse($this, true);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with illegal data.
   */
  public function testIllegalData(): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Cannot convert data to JSON: Type is not supported');
    new JsonResponse(fopen('php://stdin', 'r'), false);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
