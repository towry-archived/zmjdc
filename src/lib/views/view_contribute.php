<?php

function view_contribute($userid=null) {
  if (!is_null($userid)) {
    if (!is_numeric($userid)) {
      error(404, 'Page not found');
    }

    $user = ORM::for_table('t_users')->where('id', $userid)->find_one();
    if (! $user) {
      error(404, 'Page not found');
    }

    if (! $user->fakename) {
      $title = i18n_text('text_user') . $user->id . i18n_text('de_contrib');
    } else {
      $title = $user->fakename . i18n_text('de_contrib');
    }

    $user = $user->id;
  } elseif (! $user = auth_is()) {
    flash('error', i18n_text('need_auth'));

    redirect('/login');
  }

  $sql = "SELECT m.id, m.how, m.updated, w.word, m.uid\n"
  . "FROM t_memory m\n"
  . "join\n"
  . "(select w.id, w.word from t_words w) as w on w.id = m.wid\n"
  . "WHERE m.uid = :uid\n"
  . "LIMIT 0 , 30";

  $sqldata = ORM::for_table('t_memory')->raw_query($sql, array('uid' => $user))->find_many();
  $count = ORM::for_table('t_memory')->where('uid', $user)->count();

  if (! isset($title)) {
    $title = i18n_text('contrib');
  }

  $data = array('data' => $sqldata,
  'title' => $title,
  'count' => $count
);

render('contribute', $data);
}
