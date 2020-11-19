<?php

if (session('activation') == 0 && session('login')) {

    $uri = array_filter(explode("/", $_SERVER['REQUEST_URI']));
    $send = end($uri);

    if ($send == 'send') {

        if (date('Y-m-d H:i:s') >= session('update')) {
            $send = User::resendActivation(session('id'));
            if ($send) {
                $success = 'Aktivasyon mailiniz tekrar gönderildi.';
            } else {
                $error = 'Bir sorun oluştu ve aktivasyon mailiniz gönderilemedi.';
            }
        } else {
            $error = 'Aktivasyon mailini tekrar gönderebileceğiniz tarih: ' . session('update');
        }

    }

    require realpath('.') . '/view/resend-activation.php';

} else {
    header('Location:' . site_url());
}