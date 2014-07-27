<?php

function api_ignore() {
	$type = params('type');

	$data = array(
		'error_code' => '',
		'error_msg' => '',
		'response_code' => '',
		'response_body'=> ''
	);
	scope('data', $data);

	if (empty_or_null($type)) {
		$data['error_code'] = INVALID_REQUEST;
		$data['error_msg'] = 'Invalid params';

		json_out($data);
	}

	$cb = __FUNCTION__ . '_t_' . $type;
	if (! function_exists($cb)) {
		$data['error_code'] = INVALID_REQUEST;
		$data['error_msg'] = 'Invalid request';

		json_out($data);
	} else {
		call_user_func($cb);
	}
}

function api_ignore_t_ignore() {
	$data = scope('data');

	$nuid = params('nuid', null);
	$suid = params('suid', null);
	$w = params('w', null);

	if (! $nuid || ! $suid) {
		$data['error_code'] = 303;
		$data['error_msg'] = 'UNAUTHORIZED USER';

		return json_out($data);
	} elseif (! ($user = auth_is($nuid, $suid))){
		$data['error_code'] = 303;
		$data['error_msg'] = 'UNAUTHORIZED USER';

		return json_out($data);
	}

	if (! is_numeric($w) || is_null($w)) {
		$data['error_code'] = 303;
		$data['error_msg'] = 'Invalid params';

		return json_out($data);
	}

	$word = ORM::for_table('t_words')->where('id', $w)->find_one();

	if (! $word) {
		$data['error_code'] = 303;
		$data['error_msg'] = 'Invalid params';

		return json_out($data);
	}

	$ignore = ORM::for_table('t_ignore')->where('wid', $w)->where('uid', $user)->find_one();

	if ($ignore) {
		$data['error_code'] = 303;
		$data['error_msg'] = i18n_text('double_ignore');

		return json_out($data);
	}

	$ignore = ORM::for_table('t_ignore')->create();
	$ignore->uid = $user;
	$ignore->wid = $w;
	$ignore->updated = time();
	$ignore->save();

	$data['response_body'] = 1;
	$data['response_code'] = 200;

	return json_out($data);
}
