<?php

function view_account_edit() {
  if (! $user = auth_is()) {
    flash('error', i18n_text('need_auth'));

    redirect('/login');
  }

  $rawsql = "select u.id, u.name, u.fakename, u.email\n"
  . " from t_users u where u.id = :uid";

  $user = ORM::for_table('t_users')->raw_query($rawsql, array('uid'=>$user))->find_one();

  if (! $user) {
    error(404, 'Page not found');
  }

  $data = array();
  $data['user'] = $user;
  $data['title'] = i18n_text('edit_account');

  render('edit_account', $data);
}
