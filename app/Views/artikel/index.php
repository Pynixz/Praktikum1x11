<?= $this->include('template/header'); ?>

<script>
function toggleReadMore(articleId) {
    const shortText = document.getElementById('short-text-' + articleId);
    const fullText = document.getElementById('full-text-' + articleId);
    const readMoreBtn = document.getElementById('read-more-' + articleId);
    const readLessBtn = document.getElementById('read-less-' + articleId);

    if (fullText.style.display === 'none' || fullText.style.display === '') {
        // Show full text
        shortText.style.display = 'none';
        fullText.style.display = 'block';
        readMoreBtn.style.display = 'none';
        readLessBtn.style.display = 'inline';
    } else {
        // Show short text
        shortText.style.display = 'block';
        fullText.style.display = 'none';
        readMoreBtn.style.display = 'inline';
        readLessBtn.style.display = 'none';
    }
}
</script>

<?php if ($artikel): foreach ($artikel as $index => $row): ?>
<article class="entry">
<h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
<p class="kategori-info">Kategori: <span class="kategori-badge"><?= $row['nama_kategori'] ?? 'Tidak ada kategori' ?></span></p>
<?php if (!empty($row['gambar'])): ?>
<img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= $row['judul']; ?>" class="artikel-image">
<?php endif; ?>

<div class="artikel-content">
    <?php
    $fullText = $row['isi'];
    $shortText = substr($fullText, 0, 200);
    $needsReadMore = strlen($fullText) > 200;
    ?>

    <?php if ($needsReadMore): ?>
        <div id="short-text-<?= $index ?>" class="text-content">
            <p><?= $shortText ?>...</p>
        </div>
        <div id="full-text-<?= $index ?>" class="text-content" style="display: none;">
            <p><?= nl2br(htmlspecialchars($fullText)) ?></p>
        </div>

        <div class="read-more-controls">
            <button id="read-more-<?= $index ?>" class="read-more-btn" onclick="toggleReadMore(<?= $index ?>)">
                📖 Baca Selengkapnya
            </button>
            <button id="read-less-<?= $index ?>" class="read-less-btn" onclick="toggleReadMore(<?= $index ?>)" style="display: none;">
                📚 Sembunyikan
            </button>
        </div>
    <?php else: ?>
        <div class="text-content">
            <p><?= nl2br(htmlspecialchars($fullText)) ?></p>
        </div>
    <?php endif; ?>
</div>
</article>
<hr class="divider" />
<?php endforeach; else: ?>
<article class="entry">
<h2>Belum ada data.</h2>
</article>
<?php endif; ?>
<?= $this->include('template/footer'); ?>