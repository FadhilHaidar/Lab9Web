<?php

function base_url($path = '') {
    $protocol = 'http';
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $protocol = 'https';
    }

    $host = $_SERVER['HTTP_HOST'];
    $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    if ($script === '/' || $script === '\\') {
        $script = '';
    }

    $base = $protocol . '://' . $host . $script;

    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function asset($path) {
    return base_url('assets/' . ltrim($path, '/'));
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: ' . base_url('index.php?page=auth/login'));
        exit;
    }
}

function flash_get() {
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

function flash_set($type, $msg) {
    $_SESSION['flash'] = array(
        'type' => $type,
        'msg'  => $msg
    );
}
