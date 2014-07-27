<?php

function i18n_text($text) {
	$lang = config('dispatch.lang');
	$langs = get_msgs($lang);

	if (array_key_exists($text, $langs[$lang])) {
		return $langs[$lang][$text];
	} else {
		return '``i18n.null``';
	}
}

function get_msgs($lang) {
	static $langs = null;

	if (!$langs || !(array_key_exists($lang, $langs))) {
		$path = config('dispatch.i18n');
		$path = $path['path'];

		$path = rtrim($path, '/') . '/' . $lang . '/messages.php';

		if (!file_exists($path)) {
			if (config('dispatch.debug')) {
				error(500, 'The i18n messages file is missing');
			} else {
				error(500, 'Internal server error');
			}
		}

		$langs[$lang] = @include($path);
		if (!is_array($langs)) {
			if (config('dispatch.debug')) {
				error(500, 'The messages file must contains array');
			} else {
				error(500, 'Internal server error');
			}
		}

	}

	return $langs;
}
