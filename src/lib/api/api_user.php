<?php

const INVALID_PARAMS = 0;
const INVALID_REQUEST = 1;

function api_user() {
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

function api_user_t_isauth() {
	$nuid = params('nuid', null);
	$suid = params('suid', null);

	if (! $nuid || ! $suid) {
		$auth = false;
	} elseif (auth_is($nuid, $suid)){
		$auth = true;
	} else {
		$auth = false;
	}

	$data = scope('data');

	$data['response_code'] = 200;
	$data['response_body'] = $auth;

	json_out($data);
	return;
}

function api_user_t_userid() {
	$nuid = params('nuid', null);
	$suid = params('suid', null);

	$data = scope('data');

	if (! $nuid || ! $suid) {
		$data['error_code'] = 303;
		$data['error_msg'] = 'UNAUTHORIZED USER';
	} elseif ($user = auth_is($nuid, $suid)){
		$data['response_code'] = 200;
		$data['response_body'] = $user;
	} else {
		$data['error_code'] = 303;
		$data['error_msg'] = 'UNAUTHORIZED USER';
	}

	json_out($data);
}
