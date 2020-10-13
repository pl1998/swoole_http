<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/10/13
 * Time: 11:21.
 */
require 'vendor/autoload.php';

define('APP_DIR', __DIR__);
require_once __DIR__.'/helpers.php';
define('APP_CONFIG', __DIR__.'/config');

use app\ServiceQueue;

new ServiceQueue();
