<?php

session_start();
date_default_timezone_set('Europe/Istanbul');

try {
    $db = new PDO('mysql:host=localhost;dbname=uyelik;charset=utf8', 'root', 'root');
} catch (PDOException $e) {
    die($e->getMessage());
}

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/classes/user.class.php';
require __DIR__ . '/helper.php';

//$email = new \SendGrid\Mail\Mail();
//$email->setFrom("tayfunerbilen@gmail.com", "Tayfun Erbilen");
//$email->setSubject("Üyelik Hakkında");
//$email->addTo("tayfun@erbilen.net", "Tayfun Erbilen Jr.");
//$email->addContent(
//    "text/html", "<strong>bu mail sendgrid ile gönderildi.</strong>"
//);
//$sendgrid = new \SendGrid('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');
//try {
//    $response = $sendgrid->send($email);
//    print $response->statusCode() . "\n";
//    print_r($response->headers());
//    print $response->body() . "\n";
//} catch (Exception $e) {
//    echo 'Caught exception: '. $e->getMessage() ."\n";
//}

$action = array_filter(explode("/", isset($_GET['action']) ? $_GET['action'] : ''));
if (!isset($action[0])) {
    $action[0] = 'index';
}
if (!file_exists('controller/' . strtolower($action[0] . '.php'))) {
    $action[0] = 'index';
}

require 'controller/' . $action[0] . '.php';