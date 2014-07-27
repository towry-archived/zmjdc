<?php

function logic_rate() {
  error(404, 'Page not found');

  if (! $user = auth_is()) {
    flash('error', i18n_text('need_auth'));

    redirect('/login');
  }

  $a = params('a', null);
  $m = params('m', null);

  /** validate input */
  if (empty_or_null($a) || empty_or_null($m)) {
    flash('error', i18n_text('bad_request'));

    redirect('/');
  }

  $a = intval($a);
  if (! in_array($a, array(1,-1))) {
    flash('error', i18n_text('bad_request'));

    redirect('/');
  }

  $how = ORM::for_table('t_memory')->where('id', $m)->find_one();
  if (! $how) {
    flash('error', i18n_text('empty_content'));

    redirect('/');
  }

  if ($how->uid === $user) {
    flash('error', 'You can not rate for yourself');
    redirect('/');
  }

  $rate = ORM::for_table('t_vote')->where('uid', $user)->where('mid', $m)->find_one();
  if ($rate) {
    flash('error', i18n_text('double_rate'));

    redirect('/');
  }

  $rate = ORM::for_table('t_vote')->create();
  $rate->uid = $user;
  $rate->mid = $m;
  $rate->vote = $a;
  $rate->updated = time();

  $rate->save();

  if (!$rate->id) {
    flash('error', i18n_text('op_fail'));
  } else {	
    flash('ok', i18n_text('op_succ'));
  }

  redirect('/');
  }
