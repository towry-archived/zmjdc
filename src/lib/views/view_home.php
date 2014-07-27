<?php

function view_home() {
  $data = array(
    'title' => i18n_text('home')
  );

  $rawsql = "SELECT * FROM `t_words` w ORDER BY w.updated desc LIMIT 0, 20";

  $sqlres = ORM::for_table('t_words')->raw_query($rawsql)->find_many();

  $data['data'] = $sqlres;

  render('index', $data);
}
