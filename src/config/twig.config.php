<?php

$loader = new Twig_Loader_Filesystem(BASEPATH . '/templates');
$twig = new Twig_Environment($loader, array(
	'cache' => BASEPATH . '/data/cache/twig',
	'debug' => config('dispatch.debug'),
));

$twig->addExtension(new Twig_Extensions_Extension_I18n());

function twig($tpl, $locals) {
	global $twig;

	return $twig->render($tpl, $locals);
}
