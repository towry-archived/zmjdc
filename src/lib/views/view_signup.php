<?php

function view_signup() {
  render('signup', array('title' => i18n_text('signup'),
    'need_captcha' => true));
}
