<?php
/**
 * Extra utilities for Dispatch Micro-Framework
 *
 * @author Jesus A. Domingo <jesus.domingo@gmail.com>
 * @license MIT
 */

function info($message, $target = null) {
  if (! class_exists('ORM')) {
    return;
  }

  if (is_null($target)) {
    $target = 'system';
  }

  $log = ORM::for_table('logs')->create();

  $log->ctype = 'info';
  $log->target = 'admin';
  $log->msg = $message;
  $log->updated = time();

  $log->save();

  return $log->id();
}

/**
 * Wrapper to error_log(). If dispatch.extras.debug_log is specified,
 * all debug() calls will output to that file. If not, output will be
 * sent tot he SAPI logger.
 *
 * @param string $message string to sent to the logger.
 *
 * @return void
 */
function debug($message) {

  static $logger = null;

  // if logger's ready, use it
  if ($logger) {
    $logger($message);
    return;
  }

  // see if a log file was setup
  $log_file = config('dispatch.extras.debug_log');

  if ($log_file && file_exists($log_file)) {

    // if log file was specified, use it
    $logger = function ($m) use ($log_file) {
      error_log($m, 3, $log_file);
    };

  } else {

    // no log file, so out to console or SAPI if not in cli mode
    if (PHP_SAPI === 'cli')
      $logger = function ($m) { echo "DEBUG: {$m}\n"; };
    else
      $logger = function ($m) { error_log($m, 4); };
  }

  $logger($message);
}

/**
 * Enable caching function if we have APC
 */
if (extension_loaded('apc')) {

  /**
   * Stores the value returned by $func into apc against $key if $func is passed,
   * for $ttl seconds. If $func is not passed, the value mapped to $key is returned.
   *
   * @param string $key cache entry to fetch or store into
   * @param callable $func function whose return value is stored against $key
   * @param int $ttl optional, time-to-live for $key, in seconds
   *
   * @return mixed data cached against $key
   */
  function cache($key, $func, $ttl = 0) {

    if (($data = apc_fetch($key)) === false) {
      $data = call_user_func($func);
      if ($data !== null)
        apc_add($key, $data, $ttl);
    }

    return $data;
  }

  /**
   * Invalidates a key or list of keys from the cache.
   *
   * @param string $v,... key or keys to invalidate from the cache.
   *
   * @return void
   */
  function cache_invalidate() {
    foreach (func_get_args() as $key)
      apc_delete($key);
  }

} else {

  function cache() {
    error(500, 'Extension [apc.so] is required by cache()');
  }

  function cache_invalidate() {
    error(500, 'Extension [apc.so] is required by cache_invalidate()');
  }
}

/**
 * Enable encryption/decription tools if we have mcrypt
 */
if (extension_loaded('mcrypt')) {

  /**
   * Cookie-safe and URL-safe version of base64_encode()
   *
   * @param string $str string to encode
   *
   * @return string encoded string
   */
  function to_b64($str) {
    return strtr(base64_encode($str), '+/', '-_');
  }

  /**
   * Decodes a to_b64() encoded string.
   *
   * @param string $str encoded string
   *
   * @return string decoded string
   */
  function from_b64($str) {
    return base64_decode(strtr($str, '-_', '+/'));
  }

  /**
   * Encryption function that uses the mcrypt extension.
   *
   * @param string $decoded string to encrypt
   * @param int $algo one of the MCRYPT_ciphername constants
   * @param int $mode one of the MCRYPT_MODE_modename constants
   *
   * @return string encrypted string + iv code
   */
  function encrypt($decoded, $algo = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC) {

    if (($secret = config('dispatch.extras.crypt_key')) == null)
      error(500, "config('dispatch.extras.crypt_key') is not set.");

    $secret  = mb_substr($secret, 0, mcrypt_get_key_size($algo, $mode));
    $iv_size = mcrypt_get_iv_size($algo, $mode);
    $iv_code = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
    $encrypted = to_b64(mcrypt_encrypt($algo, $secret, $decoded, $mode, $iv_code));

    return sprintf('%s|%s', $encrypted, to_b64($iv_code));
  }

  /**
   * Decrypts a string encrypted by encrypt().
   *
   * @param string $encoded encrypted string
   * @param int $algo one of the MCRYPT_ciphername constants
   * @param int $mode one of the MCRYPT_MODE_modename constants
   *
   * @return string decrypted string
   */
  function decrypt($encoded, $algo = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC) {

    if (($secret = config('dispatch.extras.crypt_key')) == null)
      error(500, "config('dispatch.extras.crypt_key') is not set.");

    $secret  = mb_substr($secret, 0, mcrypt_get_key_size($algo, $mode));
    list($enc_str, $iv_code) = explode('|', $encoded);
    $enc_str = from_b64($enc_str);
    $iv_code = from_b64($iv_code);
    $enc_str = mcrypt_decrypt($algo, $secret, $enc_str, $mode, $iv_code);

    return rtrim($enc_str, "\0");
  }

} else {

  function encrypt() {
    error(500, 'Extension [mcrypt.so] is required by encrypt()');
  }

  function decrypt() {
    error(500, 'Extension [mcrypt.so] is required by decrypt()');
  }
}
?>
