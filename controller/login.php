<?php

if (session('login')) header('Location:' . site_url());

if (post('submit')) {

    $username = post('username');
    $password = post('password');

    if (!$username){
        $error = 'Lütfen kullanıcı adınızı yazın.';
    } elseif (!$password){
        $error = 'Lütfen şifrenizi yazın.';
    } else {

        $info = User::getUserInfo($username, $password);
        if ($info){

            User::Login($info);
            header('Location:' . site_url());

        } else {
            $error = 'Giriş yaparken sorun yaşadınız. Lütfen bilgilerinizi kontrol edin.';
        }

    }

}

require realpath('.') . '/view/login.php';