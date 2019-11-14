<?php
declare(strict_types=1);

namespace Plaisio\Response;

/**
 * An HTTP response.
 */
class BaseResponse implements Response
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * HTTP Status code: 301 Moved Permanently.
   *
   * @api
   * @since 1.0.0
   */
  const STATUS_CODE_MOVED_PERMANENTLY = 301;

  /**
   * HTTP Status code: 303 See Other.
   *
   * @api
   * @since 1.0.0
   */
  const STATUS_CODE_SEE_OTHER = 303;

  /**
   * HTTP Status code: 400 Bad Request.
   *
   * @api
   * @since 1.0.0
   */
  const STATUS_CODE_BAD_REQUEST = 400;

  /**
   * HTTP Status code: 404 Not Found.
   *
   * @api
   * @since 1.0.0
   */
  const STATUS_CODE_NOT_FOUND = 404;

  /**
   * HTTP Status code: 500 Internal Server Error.
   *
   * @api
   * @since 1.0.0
   */
  const STATUS_CODE_INTERNAL_SERVER_ERROR = 500;

  /**
   * List of HTTP status codes and the corresponding texts.
   *
   * See <https://tools.ietf.org/html/rfc7231> for details about HTTP status codes.
   *
   * @var array
   *
   * @api
   * @since 1.0.0
   */
  public static $httpStatuses = [100 => 'Continue',
                                 101 => 'Switching Protocols',
                                 102 => 'Processing',
                                 118 => 'Connection timed out',
                                 200 => 'OK',
                                 201 => 'Created',
                                 202 => 'Accepted',
                                 203 => 'Non-Authoritative',
                                 204 => 'No Content',
                                 205 => 'Reset Content',
                                 206 => 'Partial Content',
                                 207 => 'Multi-Status',
                                 208 => 'Already Reported',
                                 210 => 'Content Different',
                                 226 => 'IM Used',
                                 300 => 'Multiple Choices',
                                 301 => 'Moved Permanently',
                                 302 => 'Found',
                                 303 => 'See Other',
                                 304 => 'Not Modified',
                                 305 => 'Use Proxy',
                                 306 => 'Reserved',
                                 307 => 'Temporary Redirect',
                                 308 => 'Permanent Redirect',
                                 310 => 'Too many Redirect',
                                 400 => 'Bad Request',
                                 401 => 'Unauthorized',
                                 402 => 'Payment Required',
                                 403 => 'Forbidden',
                                 404 => 'Not Found',
                                 405 => 'Method Not Allowed',
                                 406 => 'Not Acceptable',
                                 407 => 'Proxy Authentication Required',
                                 408 => 'Request Time-out',
                                 409 => 'Conflict',
                                 410 => 'Gone',
                                 411 => 'Length Required',
                                 412 => 'Precondition Failed',
                                 413 => 'Request Entity Too Large',
                                 414 => 'Request-URI Too Long',
                                 415 => 'Unsupported Media Type',
                                 416 => 'Requested range unsatisfiable',
                                 417 => 'Expectation failed',
                                 418 => 'I\'m a teapot',
                                 422 => 'Unprocessable entity',
                                 423 => 'Locked',
                                 424 => 'Method failure',
                                 425 => 'Unordered Collection',
                                 426 => 'Upgrade Required',
                                 428 => 'Precondition Required',
                                 429 => 'Too Many Requests',
                                 431 => 'Request Header Fields Too Large',
                                 449 => 'Retry With',
                                 450 => 'Blocked by Windows Parental Controls',
                                 500 => 'Internal Server Error',
                                 501 => 'Not Implemented',
                                 502 => 'Bad Gateway or Proxy Error',
                                 503 => 'Service Unavailable',
                                 504 => 'Gateway Time-out',
                                 505 => 'HTTP Version not supported',
                                 507 => 'Insufficient storage',
                                 508 => 'Loop Detected',
                                 509 => 'Bandwidth Limit Exceeded',
                                 510 => 'Not Extended',
                                 511 => 'Network Authentication Required'];

  /**
   * If set redirect, client and server errors will not clear the output buffers. This variable is intended for unit
   * testing only (otherwise PhpUnit will label unit test as risky).
   *
   * @var true|null
   */
  public static $skipClearOutput;

  /**
   * The headers of the response.
   *
   * @var ResponseHeader
   *
   * @api
   * @since 1.0.0
   */
  public $headers;

  /**
   * The content of the response.
   *
   * @var string
   *
   * @api
   * @since 1.0.0
   */
  protected $content;

  /**
   * The status code of the response.
   *
   * @var int
   *
   * @api
   * @since 1.0.0
   */
  protected $status;

  /**
   * The HTTP protocol version (i.e. 1.0 or 1.1).
   *
   * @var string
   */
  protected $version;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string $content The content of the response.
   * @param int    $status  The status code of the response.
   */
  public function __construct(string $content = '', int $status = 200)
  {
    $this->headers = new ResponseHeader();
    $this->setContent($content)
         ->setStatus($status)
         ->setVersion('1.1');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Removes all output echoed before calling this method.
   *
   * @since 1.0.0
   * @api
   */
  public static function clearOutput(): void
  {
    // Return immediately if skipClearOutput is set.
    if (self::$skipClearOutput) return;

    $level = ob_get_level();

    // The following manual level counting is to deal with zlib.output_compression set to On.
    for ($i = $level; $i>0; --$i)
    {
      if (!@ob_end_clean())
      {
        ob_clean();
      }
    }

    if ($level>0)
    {
      // Restart output buffer in order to allow modification of headers.
      ob_start();
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the content of the response.
   *
   * @return string
   */
  public function getContent(): string
  {
    return $this->content;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the status code of the response.
   *
   * @return int
   */
  public function getStatus(): int
  {
    return $this->status;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the HTTP protocol version (i.e. 1.0 or 1.1).
   *
   * @return string
   */
  public function getVersion(): string
  {
    return $this->version;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sends the response. That is, the headers and content.
   *
   * @return $this
   */
  public function send(): Response
  {
    $this->sendHeaders();
    $this->sendContent();

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the status code of the response.
   *
   * @param int $status The status code of the response.
   *
   * @return BaseResponse
   */
  public function setStatus(int $status): BaseResponse
  {
    $this->status = $status;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the HTTP protocol version.
   *
   * @param string $version The HTTP protocol version (i.e. 1.0 or 1.1).
   *
   * @return BaseResponse
   */
  public function setVersion(string $version): BaseResponse
  {
    $this->version = $version;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sends the content.
   */
  protected function sendContent(): void
  {
    echo $this->content;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sends the HTTP headers.
   */
  protected function sendHeaders(): void
  {
    if (headers_sent()) return;

    header(sprintf('HTTP/%s %s %s', $this->version, $this->status, self::$httpStatuses[$this->status] ?? '-'),
           true,
           $this->status);

    $this->headers->send();
    // xxx cookies
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the content of the response.
   *
   * @param string $content The content.
   *
   * @return BaseResponse
   */
  protected function setContent(string $content): BaseResponse
  {
    $this->content = $content;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
