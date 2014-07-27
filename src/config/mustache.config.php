<?php

/*=>--------------------------------------------
 *	Mustache config
 *----------------------------------------------*/
config(array(
	'mustache.templates' => BASEPATH . '/templates',
	'mustache.partials' => BASEPATH . 'templates/partials',
	'mustache.layout' => 'layouts/layout',
	'mustache.cache' => BASEPATH . '/data/cache/mustache',
));

config('mustache.helpers', array(
	'__' => function ($text) {
		return i18n_text($text);
	},
	'current' => function ($text) {
		$path = path();

		if (rtrim($path, '/') === rtrim($text, '/')) {
			return 'current';
		} else {
			return false;
		}
	},
	'htmlclass' => function () {
		if (auth_is()) {
			$logged = 'logged';
		} else {
			$logged = '';
		}

		$path = path();
		if ($path == '' || $path == '/') {
			$pathClass = 'home';
		} else {
			$pathArray = explode('/', $path);
			$pathClass = $pathArray[1] or '';
		}

		return trim($logged . ' ' . $pathClass);
	},
	'logged' => auth_is(),
	'csrf_token' => csrf_token(),
    'timefy' => function ($time, Mustache_LambdaHelper $helper) {
        $time = $helper->render($time);
        $time+=0;

        return date("Y/m/d", $time);
    }, 
    'vote_up' => function ($uid, $vuid, $vote, Mustache_LambdaHelper $helper) {
        $vuid = $helper->render($vuid);
        $vote = $helper->render($vote);

        if ($vuid === $uid && $vote === '1') return 'active';
        else return '';
    },
    'vote_down' => function ($uid, $vuid, $vote, Mustache_LambdaHelper $helper) {
        $vuid = $helper->render($vuid);
        $vote = $helper->render($vote);
        
        if ($vuid === $uid && $vote === '-1') return 'active';
        else return '';
    }
));
