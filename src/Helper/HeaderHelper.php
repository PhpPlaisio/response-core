<?php
declare(strict_types=1);

namespace Plaisio\Response\Helper;

use Plaisio\Helper\Html;

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
      $filename = mb_ereg_replace('/[/\\\\]/', '_', $filename);
      $value    = sprintf("%s; filename*=%s''%s", $disposition, Html::$encoding, rawurlencode($filename));
    }
    else
    {
      $value = $disposition;
    }

    return $value;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the value for a HTTP Cache-Control field.
   *
   * @param bool $isStatic True if and only if the URL always serves the same content.
   * @param bool $isPublic True if and only if the content is public.
   *
   * @return string|null
   */
  public static function cacheControl(bool $isStatic, bool $isPublic): ?string
  {
    if ($isStatic)
    {
      if ($isPublic)
      {
        $value = 'public, store, cache';
      }
      else
      {
        $value = 'private, store, cache';
      }
    }
    else
    {
      $value = 'no-cache, no-store, must-revalidate';
    }

    return $value;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
