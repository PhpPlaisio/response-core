<?php
declare(strict_types=1);

namespace SetBased\Abc\Response;

use SetBased\Abc\Helper\Cast;
use SetBased\Abc\Helper\Html;

/**
 * An HTTP response sending a dynamically generated JSON data to the user agent.
 */
class JsonResponse extends BaseResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param mixed       $data     The data.
   * @param bool        $isJson   If true the data is already formatted als a JSON string.
   * @param string|null $callback The JSONP callback.
   *
   * @api
   *
   * @since 1.0.0
   */
  public function __construct($data, bool $isJson = false, ?string $callback = null)
  {
    parent::__construct($this->create($data, $isJson, $callback), 200);

    $type = sprintf('%s; charset=%s',
                    ($callback===null) ? 'application/json' : 'application/javascript',
                    Html::$encoding);
    $this->headers->set('Content-Length', Cast::toOptString($this->content))
                  ->set('Content-Type', $type);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates the proper content for this response.
   *
   * @param mixed       $data     The data.
   * @param bool        $isJson   If true the data is already formatted als a JSON string.
   * @param string|null $callback The JSONP callback.
   *
   * @return string
   */
  private function create($data, bool $isJson, ?string $callback): string
  {
    if (!$isJson)
    {
      $json = json_encode($data, JSON_ERROR_STATE_MISMATCH);
      if ($json===false)
      {
        throw new \InvalidArgumentException(sprintf('Cannot convert data to JSON: %s', json_last_error_msg()));
      }
    }
    else
    {
      if (!is_string($data))
      {
        throw new \InvalidArgumentException('Expecting a string');
      }

      $json = $data;
    }

    if ($callback===null)
    {

      return $json;
    }

    if (!\JsonpCallbackValidator::validate($callback))
    {
      throw new \InvalidArgumentException('Callback not valid');
    }

    return sprintf('%s(%s);', $callback, $json);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
