<?php

  /**
  * secure hashing of passwords using bcrypt, needs PHP 5.3+
  * see http://codahale.com/how-to-safely-store-a-password/
  *
  * salt for bcrypt needs to be 22 base64 characters (but just 
  * [./0-9A-Za-z]), see http://php.net/crypt
  * just an example; please use something more secure/random than 
  * sha1(microtime) :)
  *
  * 2a is the bcrypt algorithm selector, see http://php.net/crypt
  * 12 is the workload factor (around 300ms on my Core i7 machine), 
  * see http://php.net/crypt
  */
  if (! function_exists('hashpass')) {
    function hashpass($password) {
      if (! isset($password) || empty_or_null($password)) {
        throw new \RuntimeException('Error: Invalid parameter paased.');
      }

      $salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);

      $hash = crypt($password, '$2a$12$' . $salt);

      return $hash;
    }
  }

  /**
  * Check if password is matching
  */
  if (! function_exists('passmatch')) {
    function passmatch($password, $hashed) {
      if (! isset($password) || empty_or_null($password)) {
        throw new \RuntimeException('Error: Invalid parameter paased.');
      }

      $hash = crypt($password, $hashed);

      if ($hashed === $hash) {
        return true;
      } else {
        return false;
      }
    }
  }

  /**
  * Check if user is logged
  *
  * If the user is logged, return the userid from cookie,
  * or just return false.
  */
  if (! function_exists('auth_is')) {
    function auth_is($uid = null, $authc = null) {
      if (is_null($uid)) {
        $userid = cookie('nuid_');
      } else {
        $userid = $uid;
      }

      if (is_null($authc)) {
        $authCookie = cookie('suid_');
      } else {
        $authCookie = $authc;
      }

      if (! $userid || ! $authCookie) return false;

      $authKey = session('authKey');

      if (! $authKey) {
        $user = ORM::for_table('t_users')->where('id', $userid)->find_one();
        if (! $user) return false;
        $authKey = $user->authKey;
      }

      $hashed = md5($userid . $authKey);
      $hashed = substr($hashed, 0, 28);

      if ($hashed === $authCookie) {
        return $userid;
      } else {
        return false;
      }
    }
  }


  if (! function_exists('auth_out')) {
    function auth_out() {
      cookie('nuid_', null);
      cookie('suid_', null);

      session('auth?', false);
      session('authKey', null);
    }
  }


  if (! function_exists('auth_in')) {
    function auth_in($uid, $user = null) {
      cookie('nuid_', $uid, 60*60*24*7);

      $authKey = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);
      $authCookie = md5($uid . $authKey);
      $authCookie = substr($authCookie, 0, 28);

      if (is_null($user)) {
        $user = ORM::for_table('t_users')->where('id', $uid)->find_one();

        if (! $user) {
          return false;
        }
      }

      $user->authKey = $authKey;
      $user->save();

      if ($user->id === '1' && $user->acl === '9999') {
        session('admin', true);
        session('admin_id', $user->id);

        cookie('suid_', $authCookie, 60*60*24);
      } else {
        cookie('suid_', $authCookie, 60*60*24*7);
      }

      session('authKey', $authKey);
    }
  }


  /** csrf */
  if (! function_exists('csrf_check')) {
    function csrf_check($tok) {
      $token = session('csrf_token');
      if ($token !== $tok) {
        return false;
      } else {
        return true;
      }
    }
  }

  if (! function_exists('csrf_token')) {
    function csrf_token() {
      $token = session('csrf_token');
      if (empty_or_null($token)) {
        $token = md5(uniqid(rand(), true));
        session('csrf_token', $token);
      }

      return $token;
    }
  }

  if (! function_exists('captcha_check')) {
    function captcha_check($captcha) {
      $capt = session('captcha_code');
      return strtolower($capt) === strtolower($captcha);
    }
  }
