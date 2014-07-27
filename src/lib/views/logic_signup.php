<?php

  /**
  * Handle Signup
  */
  function logic_signup() {

    $email = params('email', null);
    $passwd = params('passwd', null);
    $csrftok = params('csrf_', null);

    if (!csrf_check($csrftok)) {
      flash('error', i18n_text('bad_request'));
      redirect('/login');
    }

    if (empty_or_null($email) || empty_or_null($passwd)) {
      flash('error', i18n_text('field_empty'));
      redirect('/signup?error=1024');
    }

    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
      flash('error', i18n_text('email_format_error'));

      redirect('/signup');
    }


    $user = ORM::for_table('t_users')->where('email', $email)->find_one();

    /** The user is not exists */
    if ($user == false) {
      $user = ORM::for_table('t_users')->create();

      $user->email = $email;
      $user->password = hashpass($passwd);
      $user->created = time();

      $user->save();

      flash('ok', i18n_text('signup_succ'));

      redirect('/login');
    } else {
      $back = params('redirect', '/signup');
      flash('error', i18n_text('user_exists'));

      redirect($back);
    }
  }
