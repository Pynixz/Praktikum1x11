<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
  <h1><?= esc($title ?? 'Beranda'); ?></h1>
  <hr>
  <p><?= esc($content ?? 'Selamat datang di halaman utama.'); ?></p>
<?= $this->endSection() ?>
