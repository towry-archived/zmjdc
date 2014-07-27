<?php

function logic_add() {
  flash('ok', i18n_text('add_succ'));
  redirect('/add');

  $word = params('word', null);
  $how = params('how', null);
  $captcha = params('captcha', null);

  $word = strtolower(trim($word));

  if (! preg_match('/^\w+$/', $word)) {
    flash('error', i18n_text('wrong_word'));

    session('how_restore', $how);

    redirect('/add?error=2014&w=' . $word);
  }

  if (! $user = auth_is()) {
    $user = 0;
  }

  if (! captcha_check($captcha)) {
    flash('error', i18n_text('wrong_captcha'));

    session('how_restore', $how); 
    redirect('/add?error=2013&w=' . $word);
  }

  $wordid = ORM::for_table('t_words')->where('word', $word)->find_one();
  if (! $wordid) {
    $wordid = ORM::for_table('t_words')->create();
    $wordid->word = $word;
    $wordid->updated = time();
    $wordid->save();
    $wordid = $wordid->id();
  } else {
    $wordid ->updated = time();
    $wordid->save();
    $wordid = $wordid->id();
  }

  $memory = ORM::for_table('t_memory')->create();
  $memory->wid = $wordid;
  $memory->uid = $user;
  $memory->how = $how;
  $memory->updated = time();

  if ($user !== 0) {
    $points = ORM::for_table('t_karma')->where('uid', $user)->find_one(); 
    if ($points && ($points->points >= 100)) {
      $memory->status = 1;
    }
  }

  $memory->save();

  flash('ok', i18n_text('add_succ'));
  redirect('/add?focus=word');
}
