<?php

function view_user($userid) {
  if (!is_numeric($userid) || $userid === '0') {
    error(404, 'Page not found');
  }

  $userid = intval($userid);

  if ($uid = auth_is()) {
    if (intval($uid) === $userid) {
      redirect('/account');
    }
  }

  $rawsql = "select u.id, u.name, u.fakename, u.email, u.last_login, v.goodcount, m.contribcount, i.ignorecount\n"
  . " from t_users u left join (select uid, sum(vote=1) as goodcount from t_vote group by uid) as v on v.uid = u.id\n"
  . " left join (select uid, count(*) as contribcount from t_memory group by uid) as m on m.uid = u.id\n"
  . " left join (select uid, count(id) as ignorecount from t_ignore group by uid) as i on i.uid = u.id where u.id = :uid";

  $guser = ORM::for_table('t_users')->raw_query($rawsql, array('uid' => $userid))->find_one();

  if (! $guser) {
    error(404, 'Page not found');
  }

  if (is_null($guser->fakename)) {
    $fakename = i18n_text('text_user') . "$userid";
  } else {
    $fakename = $guser->fakename;
  }


  $data = array('title' => $fakename);
  $data['guser'] = $guser;

  render('user', $data);
}
