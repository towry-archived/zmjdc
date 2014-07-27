<?php

function view_account() {
  if (! $user = auth_is()) {
    flash('error', i18n_text('need_auth'));

    redirect('/login');
  }

  $rawsql = "select u.id, u.name, u.acl, u.fakename, u.email, u.last_login, v.goodcount, m.contribcount, i.ignorecount\n"
  . " from t_users u left join (select uid, sum(vote=1) as goodcount from t_vote group by uid) as v on v.uid = u.id\n"
  . " left join (select uid, count(*) as contribcount from t_memory group by uid) as m on m.uid = u.id\n"
  . " left join (select uid, count(id) as ignorecount from t_ignore group by uid) as i on i.uid = u.id where u.id = :uid";


  $user = ORM::for_table('t_users')->raw_query($rawsql, array('uid'=>$user))->find_one();

  if (! $user) {
    error(404, 'Page not found');
  }

  /** Check if the user is admin */
  if ($user->acl === "9999" && $user->id === '1') {
    $rawsql = "select * from t_memory m where m.status IS NULL limit 0, 30";
    $data = ORM::for_table('t_memory')->raw_query($rawsql)->find_many();

    $data = array('user' => $user, 'data'=> $data, 'title' => i18n_text('account'));

    return render('admin_account', $data);
  }

  $data = array('user' => $user, 'title' => i18n_text('account'));

  render('account', $data);
}
