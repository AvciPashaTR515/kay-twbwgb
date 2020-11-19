<?php

/**
 * @param null $url
 * @return string
 */
function site_url($url = null)
{
    return 'http://localhost/uyelik/' . $url;
}

/**
 * @param $name
 * @return string
 */
function post($name)
{
    if (isset($_POST[$name]))
        return htmlspecialchars(trim($_POST[$name]));
}

/**
 * @param $name
 * @return string
 */
function get($name)
{
    if (isset($_GET[$name]))
        return htmlspecialchars(trim($_GET[$name]));
}

/**
 * @param $name
 * @return mixed
 */
function session($name)
{
    if (isset($_SESSION[$name]))
        return $_SESSION[$name];
}

/**
 * @param null $id
 * @return array|mixed
 */
function questions($id = null)
{
    $questions = [
        1 => 'İlk arabanızın markası neydi?',
        2 => 'İlk köpeğinizin adı neydi?',
        3 => 'İlk okul öğretmeninizin adı nedir?',
        4 => 'İlk öğrendiğiniz kod hangisiydi?'
    ];
    return $id ? $questions[$id] : $questions;
}