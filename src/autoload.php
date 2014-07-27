<?php
/** Setup the environment before autoload */
defined('__DIR__') ?: define('__DIR__', dirname(__FILE__));
define('BASEPATH', __DIR__);
define('LIBPATH', __DIR__ . '/lib');


/** Loads third-party library */
require_once BASEPATH . '/vendor/autoload.php';

/** Loads second-party library */
require_once LIBPATH . '/dispatch/dispatch/dispatch.php';
require_once LIBPATH . '/dispatch/dispatch-extras/dispatch-extras.php';

/** Loads functions */
require_once LIBPATH . '/functions/i18n.php';
require_once LIBPATH . '/functions/common.php';
require_once LIBPATH . '/functions/security.php';

/** Loads configure */
require_once __DIR__ . '/configure.php';

/** Loads routes */
require_once __DIR__ . '/route.php';
