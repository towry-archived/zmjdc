<?php

function view_ignored($userid = null) {
  if (!is_null($userid)) {
    if (!is_numeric($userid)) {
      error(404, 'Page not found');
    }

    $user = ORM::for_table('t_users')->where('id', $userid)->find_one();
    if (! $user) {
      error(404, 'Page not found');
    }

    $user = $user->id;
  } elseif (! $user = auth_is()) {
    flash('error', i18n_text('need_auth'));

    redirect('/login');
  }

  $rawsql = "SELECT * \n"
  . "FROM t_words w\n"
  . "JOIN (\n"
  . "\n"
  . "SELECT i.wid, i.uid\n"
  . "FROM t_ignore i where i.uid = :uid group by i.wid\n"
  . ") AS i ON i.wid = w.id\n"
  . "LIMIT 0 , 30\n"
  . "";

  $count = ORM::for_table('t_ignore')->distinct()->select('wid')->where('uid', $user)->count();
  $sqldata = ORM::for_table('t_words')->raw_query($rawsql, array('uid' => $user))->find_many();

  $data = array('data' => $sqldata, 'title' => i18n_text('already_memory'), 'count' => $count);

  render('ignored', $data);
}
