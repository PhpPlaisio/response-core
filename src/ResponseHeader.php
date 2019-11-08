<?php
declare(strict_types=1);

namespace SetBased\Abc\Response;

use DateTimeInterface;
use SetBased\Abc\Helper\Cast;

/**
 * All headers for an HTTP response.
 */
class ResponseHeader
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Uppercase characters.
   */
  private const UPPER = '_ABCDEFGHIJKLMNOPQRSTUVWXYZ';

  /**
   * Lowercase characters.
   */
  private const LOWER = '-abcdefghijklmnopqrstuvwxyz';

  /**
   * The headers. The key is the normalized value of the header name.
   *
   * @var array
   */
  private $headers = [];

  /**
   * The map from the normalized value of the header name to the original header name.
   *
   * @var array
   */
  private $names = [];

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   */
  public function __construct()
  {
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the normalized value of a key..
   *
   * @param string $key The key.
   *
   * @return string
   */
  private static function normalKey(string $key): string
  {
    return strtr($key, self::UPPER, self::LOWER);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Removes a header.
   *
   * @param string $name The name of the header.
   *
   * @return $this
   */
  public function remove(string $name): self
  {
    $key = self::normalKey($name);
    unset($this->headers[$key]);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sends the headers.
   *
   * @return $this
   */
  public function send(): self
  {
    foreach ($this->headers as $key => $value)
    {
      header(sprintf("%s: %s", $this->names[$key], $value), true);
    }

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets a header field.
   *
   * @param string      $name  The name of the header field.
   * @param string|null $value The value of the header field.
   *
   * @return $this
   */
  public function set(string $name, ?string $value): self
  {
    $key = self::normalKey($name);

    if ($value===null || $value==='')
    {
      unset($this->headers[$key]);
    }
    else
    {
      $this->headers[$key] = $value;
      $this->names[$key]   = $name;
    }

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets a header field with datetime value as defined by (RFC 7231)[https://tools.ietf.org/html/rfc7231].
   *
   * @param string                            $name  The name of the header field.
   * @param DateTimeInterface|string|int|null $value The value of the header field.
   *
   * @return $this
   */
  public function setTimestamp(string $name, $value): self
  {
    if ($value===null)
    {
      return $this->set($name, null);
    }

    if ($value instanceof \DateTime)
    {
      $date = \DateTimeImmutable::createFromMutable($value);
    }
    elseif (is_string($value))
    {
      $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $value);
    }
    elseif (is_int($value))
    {
      $date = \DateTimeImmutable::createFromFormat('U', Cast::toManString($value));
    }
    else
    {
      $date = $value;
    }

    $date = $date->setTimezone(new \DateTimeZone('UTC'));

    return $this->set($name, $date->format('D, d M Y H:i:s').' GMT');
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
