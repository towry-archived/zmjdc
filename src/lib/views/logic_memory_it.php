<?php

function logic_memory_it() {
	$m = params('m', null);

	if (! $user = auth_is()) {
		flash('error', i18n_text('need_auth'));

		redirect('/login');
	}

	if (! is_numeric($m)) {
		flash('error', i18n_text('bad_request'));

		redirect('/');
	}

	$memory = ORM::for_table('t_memory')->where('id', $m)->find_one();

	if (! $memory) {
		flash('error', i18n_text('bad_request'));

		redirect('/');
	}

	$mit = ORM::for_table('t_mlist')->where('mid', $m)->where('uid', $user)->find_one();

	if ($mit) {
		flash('error', i18n_text('double_ignore'));

		redirect('/');
	}

	$mit = ORM::for_table('t_mlist')->create();
	$mit->mid = $m;
	$mit->uid = $user;
	$mit->updated = time();
	$mit->save();

	flash('ok', i18n_text('op_succ'));

	redirect('/');
}
