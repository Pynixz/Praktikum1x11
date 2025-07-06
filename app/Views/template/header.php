<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title> <?= $title; ?> </title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
  </head>
  <body>
    <div id="container">
      <header>
        <h1>Layout Sederhana</h1>
      </header>
      <nav>
        <?php
        $currentUri = uri_string();
        $isHome = ($currentUri == '' || $currentUri == '/');
        $isAdmin = (strpos($currentUri, 'admin') !== false);
        $isArtikel = (strpos($currentUri, 'artikel') !== false && strpos($currentUri, 'admin') === false);
        $isAbout = (strpos($currentUri, 'about') !== false);
        $isContact = (strpos($currentUri, 'contact') !== false);
        $isFaqs = (strpos($currentUri, 'faqs') !== false);
        $isTos = (strpos($currentUri, 'tos') !== false);
        ?>

        <a href="<?= base_url('/');?>" <?= $isHome ? 'class="active"' : '' ?>>Home</a>
        <a href="<?= base_url('/admin/artikel'); ?>" <?= $isAdmin ? 'class="active"' : '' ?>>Dashboard Admin</a>
        <a href="<?= base_url('/artikel');?>" <?= $isArtikel ? 'class="active"' : '' ?>>Artikel</a>
        <a href="<?= base_url('/about');?>" <?= $isAbout ? 'class="active"' : '' ?>>About</a>
        <a href="<?= base_url('/contact');?>" <?= $isContact ? 'class="active"' : '' ?>>Contact</a>
        <a href="<?= base_url('/faqs');?>" <?= $isFaqs ? 'class="active"' : '' ?>>FAQs</a>
        <a href="<?= base_url('/tos');?>" <?= $isTos ? 'class="active"' : '' ?>>TOS</a>

        <?php if (session()->get('logged_in')) : ?>
          <a href="<?= base_url('/user/logout'); ?>" class="logout-btn">Logout</a>
        <?php else: ?>
          <a href="<?= base_url('/user/login'); ?>" class="login-btn">Login</a>
        <?php endif; ?>
      </nav>
      <section id="wrapper">
        <section id="main">
