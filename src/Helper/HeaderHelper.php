<?php
declare(strict_types=1);

namespace SetBased\Abc\Response\Helper;

use SetBased\Abc\Helper\Html;

/**
 * Utility functions for HTTP headers.
 */
class HeaderHelper
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the value for a HTTP Content-Disposition field.
   *
   * @param string      $disposition Either 'inline' or 'attachment'.
   * @param string|null $filename    The filename.
   *
   * @return string
   */
  public static function contentDisposition(string $disposition, ?string $filename): string
  {
    if (!in_array($disposition, ['attachment', 'inline']))
    {
      throw new \InvalidArgumentException('Illegal disposition');
    }

    if ($filename!==null && $filename!=='')
    {
      if (strpbrk($filename, "\\/*'%")!==false)
      {
        throw new \InvalidArgumentException('Illegal filename');
      }

      $value = sprintf("%s; filename*=%s''%s", $disposition, Html::$encoding, rawurlencode($filename));
    }
    else
    {
      $value = $disposition;
    }

    return $value;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
