<?php

function logic_account_edit() {
	$username = params('username', null);
	$email = params('email', null);
	$password = params('password', null);

	if (! $user = auth_is()) {
		flash('error', i18n_text('need_auth'));

		redirect('/login');
	}

	$username = trim($username);
	$email = trim($email);
	$password = trim($password);

	/** validate username */
	$uregex = '/^[_\w\d\x{4e00}-\x{9fa5}]{1,20}$/iu';
	if (! preg_match($uregex, $username)) {
		flash('error', i18n_text('username_format_error'));

		redirect('/account/edit');
	}

	if (empty_or_null($username) || empty_or_null($email)) {
		flash('error', i18n_text('field_empty'));
		redirect('/account/edit');
	}

	if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
		flash('error', i18n_text('email_format_error'));

		redirect('/account/edit');
	}

	if ($password !== "") {
		if (strlen($password) < 6) {
			flash('error', i18n_text('password_min_error'));
			redirect('/account/edit');
		}

		if (strlen($password) > 25) {
			flash('error', i18n_text('password_max_error'));
			redirect('/account/edit');
		}

		if (preg_match('/\s/', $password)) {
			flash('error', i18n_text('password_whitespace'));
			redirect('/account/edit');
		}

		if (preg_match('/^[0-9]+$/', $password)) {
			flash('error', i18n_text('password_number_only'));
			redirect('/account/edit');
		}
	}

	$user = ORM::for_table('t_users')->where('id', $user)->find_one();

	if (! $user) {
		error(404, i18n_text('user_not_exists'));

		redirect('/');
	}

	if ($user->fakename === $username) {
		if ($user->email === $email) {
			if ($password === "") {
				flash('ok', i18n_text('save_succ'));

				redirect('/');
			}
		}
	}

	$user->fakename = $username;
	
	if ($user->email !== $email) {
		$guest = ORM::for_table('t_users')->where('email', $email)->find_one();
		if ($guest) {
			flash('error', i18n_text('email_exists'));

			redirect('/account/edit');
		}

		$user->email = $email;
	}

	if ($password !== "") {
		$user->password = hashpass($password);
	}

	$user->save();

	flash('ok' ,i18n_text('save_succ'));

	redirect('/account/edit');
}
