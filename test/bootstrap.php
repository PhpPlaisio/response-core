<?php
declare(strict_types=1);

use Plaisio\Response\BaseResponse;

mb_internal_encoding('UTF-8');
error_reporting(E_ALL);
date_default_timezone_set('Europe/Amsterdam');

BaseResponse::$skipClearOutput = true;

require __DIR__.'/../vendor/autoload.php';
