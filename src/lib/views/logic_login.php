<?php

  function logic_login() {
    $email = params('email', null);
    $passwd = params('passwd', null);
    $csrftok = params('csrf_', null);
    $captcha = params('captcha', null);

    if (!csrf_check($csrftok)) {
      flash('error', i18n_text('bad_request'));
      redirect('/login');
    }

    if (! empty_or_null($captcha) && ! captcha_check($captcha)) {
      flash('error', i18n_text('wrong_captcha'));
      redirect('/login?error=1025');
    }

    /** validation */
    if (empty_or_null($email) || empty_or_null($passwd)) {
      flash('error', i18n_text('field_empty'));
      $back = '/login?error=1024';

      redirect($back);
    }

    $user = ORM::for_table('t_users')->where('email', $email)->find_one();
    /** If user not exits */
    if (! $user) {
      flash('error', i18n_text('user_not_exists'));
      $back = params('redirect', '/login?error=1024');

      redirect($back);
    }

    /** If password doesn't match */
    if (!passmatch($passwd, $user->password)) {
      flash('error', i18n_text('password_error'));
      $back = params('redirect', '/login?error=1024');

      redirect($back);
    }

    /** So, the user is ok */
    auth_in($user->id, $user);
    $user->last_login = time();
    $user->save();

    flash('ok', i18n_text('login_succ'));

    redirect('/');
  }
