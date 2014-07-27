<?php

/*=>--------------------------------------------
 * Enable debug mode
 *---------------------------------------------*/
config('dispatch.debug', true);

/*=>--------------------------------------------
 * The current version
 *---------------------------------------------*/

config('app.version', 'v2');


/*=>--------------------------------------------
 * 	Database config
 *	This must comes first
 *----------------------------------------------*/
include_once __DIR__ . '/config/database.config.php';


/*=>---------------------------------------------
 * 	ACL
 *----------------------------------------------*/
include_once __DIR__ . '/config/acl.config.php';


/*=>---------------------------------------------
 *  Templates
 *---------------------------------------------*/
config('dispatch.templates', BASEPATH . '/templates');
config('dispatch.layout', '/layouts/layout');


/*=>--------------------------------------------
 *	Controller config
 *---------------------------------------------*/
config('dispatch.views', array(
	'path' => __DIR__ . '/lib/views'
));
config('dispatch.api', array(
	'path' => __DIR__ . '/lib/api'
));


/*=>--------------------------------------------
 *	i18n
 *---------------------------------------------*/
config('dispatch.i18n', array(
	'lang' => 'en',
	'path' => BASEPATH . '/i18n'
));
config('dispatch.lang', 'zh-cn');


/*=>---------------------------------------------
 * 	Cookies
 *-----------------------------------------------*/
config('dispatch.flash_cookie', 'nfm_');
