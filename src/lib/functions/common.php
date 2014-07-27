<?php

if (! function_exists('empty_or_null')) {
	
    function empty_or_null($val) {
            return (is_null($val) || trim($val) === '');
    }
}

if (! function_exists('json_data_template')) {

    function json_data_template() {
        return array(
            'error_code' => '',
            'error_msg' => '',
            'response_code' => '',
            'response_body' => ''
        );
    }
}

if (! function_exists('_p')) {

    function _p($v, $default = null) {
        extract(context());

        return isset($$v) ? $$v : $default;
    }
}

if (! function_exists('_v')) {

    function _v($v, $k, $d = null) {
        if (is_object($v)) {
            return empty($v->$k) ? $d : $v->$k;
        } elseif (is_array($v)) {
            return empty($v[$k]) ? $d : $v[$k];
        }
    }
}

if (! function_exists('timefy')) {

    function timefy($t) {
        $t += 0;

        return date("Y/m/d", $t);
    }
}

/*
 * Tests whether a data is set and 
 * not empty
 */
if (! function_exists('fulfilled')) {

    function fulfilled($d) {
        extract(context());

        return isset($$d) && !empty($$d);
    }
}


if (! function_exists('navigator')) {

  function navigator($count, $per = null, $current = null) {
    if ($count < $per) return;
    
    $html = '<ul class="pagination pagination-lg">' . "\n";
    $nav_total = ceil($count / $per);
    $index = 0;
    $start = 0;

    while ($index < $nav_total) {
      $start = $index * $per;
      if ($start === $current) {
        $html .= '<li class="current"><a href="?start=' . $start . '">' . ($index+1) . '</a></li>' . "\n";
      } else {
        $html .= '<li><a href="?start=' . $start . '">' . ($index+1) . '</a></li>' . "\n";
      }
      $index += 1;
    }

    $html .= '</ul>' . "\n";
    
    return $html;
  }
}

if (! function_exists('asset_prefix')) {

  function asset_prefix() {
    $version = config('app.version');

    if ($version) {
      return "/" . $version;
    } else {
      return "";
    }
  }
}
