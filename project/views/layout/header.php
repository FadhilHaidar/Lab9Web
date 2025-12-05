<?php
// header template
?><!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Praktikum Modular - Mini App</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
<div class="container">
<a class="navbar-brand" href="<?= base_url('index.php') ?>">Praktikum</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navMain">
<ul class="navbar-nav ms-auto">
<li class="nav-item"><a class="nav-link" href="<?= base_url('index.php?page=user/list') ?>">Data Barang</a></li>
<?php if (!is_logged_in()): ?>
<li class="nav-item"><a class="nav-link" href="<?= base_url('index.php?page=auth/login') ?>">Login</a></li>
<?php else: ?>
<li class="nav-item"><a class="nav-link" href="<?= base_url('index.php?page=auth/logout') ?>">Logout (<?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?>)</a></li>
<?php endif; ?>
</ul>
</div>
</div>
</nav>
<div class="container py-4">
<?php
$flash = flash_get();
if ($flash): ?>
<div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['msg']) ?></div>
<?php endif; ?>
