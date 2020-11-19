<?php

$uri = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$activationCode = end($uri);
if ($activationCode) {

    $query = $db->prepare('SELECT * FROM users WHERE user_token = :token');
    $query->execute([
        'token' => $activationCode
    ]);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($row) {

        $activate = User::setActivationCode($row['user_id'], 1);
        if ($activate){
            $row['user_activation'] = 1;
            User::Login($row);
            header('Location:' . site_url('?msg=activation_success'));
        } else {
            die('HESABINIZ AKTİF HALE GELEMEDİ!');
        }

    } else {
        header('Location:' . site_url());
    }

} else {
    header('Location:' . site_url());
}