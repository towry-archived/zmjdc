<?php

function view_add() {
    $data = array();
    $data['need_captcha'] = true;

    $w = params('w', null);

    if ($w) {
            $data['target'] = $w;
    }

    $data['title'] = i18n_text('add');

    render('add', $data);
}
