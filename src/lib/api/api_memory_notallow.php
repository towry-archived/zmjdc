<?php

function api_memory_notallow() {
  if (! $user = auth_is()) {
    error(404, 'Page not found');
  }

  $admin = session('admin');
  $admin_id = session('admin_id');
  if (! $admin) {
    error(404, 'Page not found');
  }
  if ($admin_id !== $user) {
    error(404, 'Page not found');
  }

  $m = params('m', null);
  $data = json_data_template();

  function error_request() {
    $data['error_code'] = 303;
    $data['error_msg'] = 'Wrong request';

    json_out($data);
  }

  if (empty_or_null($m)) error_request();

  $m = ORM::for_table('t_memory')->where('id', $m)->find_one();
  if (! $m) error_request();

  $uid = $m->uid;

  $m->status = -1;
  $m->save();

  if ($uid !== '0') {
    $points = ORM::for_table('t_karma')->where('uid', $uid)->find_one();
    if (! $points) {
      $points = ORM::for_table('t_karma')->create();
    }
    $point = $points->points;
    $point = intval($point) - 1;

    $points->uid = $uid;
    $points->points = $point;
    $points->save();
  }

  $data['response_code'] = 200;
  $data['response_body'] = 'Success';

  json_out($data);
}
