<?php

function api_rate() {
  $type = params('type');

  $data = array(
    'error_code' => '',
    'error_msg' => '',
    'response_code' => '',
    'response_body'=> ''
  );
  scope('data', $data);

  if (empty_or_null($type)) {
    $data['error_code'] = 'INVALID_REQUEST';
    $data['error_msg'] = 'Invalid params';

    json_out($data);
  }

  $cb = __FUNCTION__ . '_t_' . $type;
  if (! function_exists($cb)) {
    $data['error_code'] = 'INVALID_REQUEST';
    $data['error_msg'] = 'Invalid request';

    json_out($data);
  } else {
    call_user_func($cb);
  }
}

function api_rate_t_all() {
  $nuid = params('nuid', null);
  $suid = params('suid', null);

  $data = scope('data');

  if (! $nuid || ! $suid) {
    $data['error_code'] = 303;
    $data['error_msg'] = 'UNAUTHORIZED USER';

    return json_out($data);
  } elseif (! ($user = auth_is($nuid, $suid))){
    $data['error_code'] = 303;
    $data['error_msg'] = 'UNAUTHORIZED USER';

    return json_out($data);
  }

  $m = params('m', null);
  $a = params('a', null);

  if (empty_or_null($a) || empty_or_null($m)) {
    $data['error_code'] = 303;
    $data['error_msg'] = 'Invalid params'; 

    return json_out($data);
  }

  if (! in_array($a, array('1','-1'))) {
    $data['error_code'] = 303;
    $data['error_msg'] = 'Invalid params'; 

    return json_out($data);
  }

  $how = ORM::for_table('t_memory')->where('id', $m)->find_one();
  if (! $how) {
    $data['error_code'] = 303;
    $data['error_msg'] = 'Invalid request';

    return json_out($data);
  } else {
    if ($how->uid === $user) {
      $data['error_code'] = 304;
      $data['error_msg'] = 'You can rate for yourself';

      return json_out($data);
    }
  }

  $rate = ORM::for_table('t_vote')->where('uid', $user)->where('mid', $m)->find_one();
  if ($rate) {
    $now = time();
    $diff = $now - $rate->updated;
    if ($diff < 60*10) {
      /* Please vote at 10m later*/
      $data['error_code'] = 300;
      $data['error_msg'] = i18n_text('vote_wait');

      return json_out($data);
    }

    $ratevote = $rate->vote;
    if ($a === $ratevote) {		/** cancel rate */
      $rate->vote = null;
      $data['response_body'] = -1;
  } else {
    $rate->vote = $a;
    $data['response_body'] = 1;
  }
  $rate->updated = time();
  $rate->save();

  $data['response_code'] = 201;

  return json_out($data);
}

$rate = ORM::for_table('t_vote')->create();
$rate->uid = $user;
$rate->mid = $m;
$rate->vote = $a;
$rate->updated = time();

$rate->save();

$data['response_body'] = 1;
$data['response_code'] = 200;

return json_out($data);
}
