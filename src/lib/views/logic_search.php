<?php

function logic_search() {
    $w = params('s');
    if (empty_or_null($w)) {
        redirect('/');
    }

    $url = '/word/' . $w;
    redirect($url);
}
