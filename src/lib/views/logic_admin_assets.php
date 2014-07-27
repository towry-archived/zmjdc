<?php

function logic_admin_assets($file) {
    if (! $user = auth_is()) error(404, 'Page not found');

    $admin = session('admin');
    $admin_id = session('admin_id');
    
    if (! $admin) error(404, 'Page not found1');

    if ($admin_id !== $user) error(404, "Page not found");
    
    $file = preg_replace('/\.jsr$/', '.js', $file);
    $f = BASEPATH . '/assets/admin/' . $file;

    if (! file_exists($f)) {
        error(404, 'Page not found');
    }

    $content = @file_get_contents($f);
    if (! $content) {
        error(404, 'Page not found');
    }

    header('Content-Type: application/javascript');

    echo $content;
}
