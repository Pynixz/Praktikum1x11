<?= $this->include("template/header") ?>
<article class="entry">
<h2><?= $artikel["judul"] ?? $artikel["title"] ?? 'Untitled' ?></h2>
<?php if (!empty($artikel['gambar'])): ?>
<img src="<?= base_url("/gambar/" . $artikel["gambar"]) ?>" alt="<?= $artikel["judul"] ?? $artikel["title"] ?>" style="max-width: 100%; height: auto; margin: 15px 0;">
<?php elseif (!empty($artikel['image'])): ?>
<img src="<?= base_url("/image/" . $artikel["image"]) ?>" alt="<?= $artikel["slug"] ?>" style="max-width: 100%; height: auto; margin: 15px 0;">
<?php endif; ?>
<p><?= $artikel["isi"] ?? $artikel["content"] ?? 'Konten tidak tersedia.' ?></p>
</article>
<?= $this->include("template/footer") ?>
