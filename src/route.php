<?php

on('GET', '/test', 'logic_test');

on('GET', '/', 'view_home');

on('GET', '/login', 'view_login');
on('POST', '/login', 'logic_login');

on('GET', '/signup', function () {
  redirect('/signup/forbidden');
});

on('GET', '/signup/forbidden', function () {
  render('signup_forbidden', array('title' => i18n_text('signup_forbidden')));
});

on('POST', '/signup', 'logic_signup');

on('GET', '/logout', 'logic_logout');

on('GET', '/misc/captcha', 'logic_captcha_code');

on('GET', '/account', 'view_account');
on('GET', '/mine', 'view_mine');
on('GET', '/user/:userid', 'view_user');
on('GET', '/account/edit', 'view_account_edit');
on('POST', '/account/edit', 'logic_account_edit');

on('GET', '/add', 'view_add');
on('POST', '/add', 'logic_add');

on('GET', '/word/:word', 'view_word');

on('GET', '/rate', 'logic_rate');

on('GET', '/search', 'logic_search');

on('GET', '/ignore/it', 'logic_ignore_it');

on('GET', '/ignored', 'view_ignored');
on('GET', '/user/:userid/ignored', 'view_ignored');

on('GET', '/contribute', 'view_contribute');
on('GET', '/user/:userid/contribute', 'view_contribute');

on('GET', '/memory/it', 'logic_memory_it');

on('GET', '/admin/assets/:file', 'logic_admin_assets');

/** apis */
on('*', '/api/user', 'api_user', true);
on('*', '/api/rate', 'api_rate', true);
on('*', '/api/ignore', 'api_ignore', true);

on('*', '/api/memory/allow', 'api_memory_allow', true);
on('*', '/api/memory/notallow', 'api_memory_notallow', true);
