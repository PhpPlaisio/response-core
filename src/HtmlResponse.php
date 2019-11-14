<?php
declare(strict_types=1);

namespace Plaisio\Response;

use Plaisio\Helper\Html;
use SetBased\Helper\Cast;

/**
 * An HTTP response sending HTML code (either a complete document or snippet) to the user agent.
 */
class HtmlResponse extends BaseResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string $content The content of the response.
   * @param int    $status  The status code of the response.
   */
  public function __construct(string $content = '', int $status = 200)
  {
    parent::__construct($content, $status);

    $this->headers->set('Content-Type', 'text/html; charset='.Html::$encoding);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the content of the response.
   *
   * @param string $content The content.
   *
   * @return BaseResponse
   */
  public function setContent(string $content): BaseResponse
  {
    $this->content = $content;

    $this->headers->set('Content-Length', Cast::toOptString(strlen($content)));

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
