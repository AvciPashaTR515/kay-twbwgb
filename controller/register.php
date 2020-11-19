<?php

if (session('login')) header('Location:' . site_url());

if (post('submit')) {

    $data = [
        'user_name' => post('username'),
        'user_email' => post('email'),
        'user_password' => post('password'),
        'user_question' => post('question'),
        'user_answer' => post('answer')
    ];

    if (!$data['user_name']) {
        $error = 'Kullanıcı adınızı yazın.';
    } elseif (!$data['user_password']) {
        $error = 'Lütfen şifrenizi yazın.';
    } elseif (!$data['user_email']) {
        $error = 'E-posta adresinizi yazın.';
    } elseif (!$data['user_question']) {
        $error = 'Lütfen gizli sorunuzu seçin.';
    } elseif (!$data['user_answer']) {
        $error = 'Lütfen sorunuza cevap yazın.';
    } elseif (!preg_match('/^[0-9a-zA-Z]+$/', $data['user_name'])) {
        $error = 'Kullanıcı adınız sadece sayı ve harflerden oluşabilir. (Türkçe harf kullanmayın)';
    } elseif (!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Lütfen geçerli bir e-posta adresi girin.';
    } else {

        if (User::Check($data['user_name'], $data['user_email'])) {
            $error = 'Kayıt olduğunuz kullanıcı adı ya da e-posta adresi kullanılıyor. Başka bir tane deneyin.';
        } else {

            $register = User::Register($data);
            if ($register) {
                $send = User::SendActivationMail($data['user_name'], $data['user_email'], $register);
                if ($send) {
                    $success = 'Kayıt olduğunuz e-posta adresinize onay maili gönderdik, lütfen giriş yapmak için hesabınızı onaylayın.';
                } else {
                    $error = 'Bir sorun oluştu ve aktivasyon mailini gönderemedik. Bizimle iletişime geç hacı.';
                }
            } else {
                $error = 'Bir sorun oluştu ve kayıt olamadınız!';
            }

        }

    }

}

require realpath('.') . '/view/register.php';