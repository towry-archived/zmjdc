<?php

function view_login() {
  if (auth_is()) {
    redirect('/');
  }

  $data['title'] = i18n_text('login');

  $error = params('error', null);
  $need_captcha = session('need_captcha');

  if ($error || $need_captcha) {
    session('need_captcha', true);
    $data['need_captcha'] = true;
  }

  render('login', $data);
}
