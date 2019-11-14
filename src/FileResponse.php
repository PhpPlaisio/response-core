<?php
declare(strict_types=1);

namespace Plaisio\Response;

use Plaisio\Response\Helper\HeaderHelper;
use SetBased\Exception\FallenException;
use SetBased\Helper\Cast;

/**
 * An HTTP response sending a file to the user agent.
 */
class FileResponse extends BaseResponse
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The information of the file.
   *
   * @var \SplFileInfo
   */
  private $file;

  /**
   * The name under which the file must be send.
   *
   * @var string
   */
  private $filename;

  /**
   * If and only if true the file will removed after sending the data.
   *
   * @var bool
   */
  private $remove = false;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param             $file
   * @param string|null $filename
   * @param string|null $mimeType    The mime type of the file.
   * @param string      $disposition Either 'inline' or 'attachment'.
   * @param bool        $isStatic    True if and only if the URL always serves the same content.
   * @param bool        $isPublic    True if and only if the content is public.
   *
   * @api
   * @since 1.0.0
   */
  public function __construct($file,
                              ?string $filename,
                              ?string $mimeType = null,
                              string $disposition = 'attachment',
                              bool $isStatic = false,
                              bool $isPublic = false)
  {
    parent::__construct('', 200);

    switch (true)
    {
      case $file instanceof \SplFileInfo:
        $this->file = $file;
        break;

      case is_string($file) && $file!=='':
        $this->file = new \SplFileInfo($file);
        break;

      default:
        throw new FallenException('file', gettype($file));
    }

    $this->filename = $filename ?? $this->file->getBasename();

    $this->headers->set('Content-Type', $mimeType)
                  ->set('Content-Length', Cast::toOptString($this->file->getSize()))
                  ->set('Content-Disposition', HeaderHelper::contentDisposition($disposition, $this->filename))
                  ->set('Cache-Control', HeaderHelper::cacheControl($isStatic, $isPublic))
                  ->setTimestamp('Last-Modified', $this->file->getMTime());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Set the option for removing the file after sending the the user agent.
   *
   * @param bool $remove If and onl if true the file will e removed after sending.
   *
   * @return $this
   */
  public function remove($remove = true): self
  {
    $this->remove = $remove;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sends the file tot the user agent.
   */
  public function sendContent(): void
  {
    $out  = fopen('php://output', 'wb');
    $file = fopen($this->file->getPathname(), 'rb');

    stream_copy_to_stream($file, $out);

    fclose($out);
    fclose($file);

    if ($this->remove)
    {
      @unlink($this->file->getPathname());
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
