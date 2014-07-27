<?php

function logic_ignore_it() {
	$w = params('w', null);

	if (! $user = auth_is()) {
		flash('error', i18n_text('need_auth'));

		redirect('/login');
	}

	if (! is_numeric($w)) {
		flash('error', i18n_text('bad_request'));

		redirect('/');
	}

	$word = ORM::for_table('t_words')->where('id', $w)->find_one();

	if (! $word) {
		flash('error', i18n_text('bad_request'));

		redirect('/');
	}

	$ignore = ORM::for_table('t_ignore')->where('wid', $w)->where('uid', $user)->find_one();

	if ($ignore) {
		flash('error', i18n_text('double_ignore'));

		redirect('/');
	}

	$ignore = ORM::for_table('t_ignore')->create();
	$ignore->uid = $user;
	$ignore->wid = $w;
	$ignore->updated = time();
	$ignore->save();

	flash('ok', i18n_text('op_succ'));

	redirect('/');
}
