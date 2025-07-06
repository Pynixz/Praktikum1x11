<?= $this->include('template/header'); ?>

<h2><?= esc($title); ?></h2>



<div class="row mb-3">
    <div class="col-md-6">
        <form method="GET" action="<?= base_url('admin/artikel'); ?>" class="form-inline">
            <input type="text" name="q" value="<?= esc($q); ?>" placeholder="Cari judul artikel" class="form-control mr-2">

            <select name="kategori_id" class="form-control mr-2">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= esc($k['id_kategori']); ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                        <?= esc($k['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Cari" class="btn btn-primary">
        </form>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?= base_url('admin/artikel/add'); ?>" class="btn btn-success">Tambah Artikel</a>
    </div>
</div>

<!-- Tabel Artikel -->
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($artikel)): ?>
            <?php $no = 1; ?>
            <?php foreach ($artikel as $item): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <b><?= esc($item['judul']); ?></b>
                        <p><small><?= esc(substr($item['isi'], 0, 50)); ?>...</small></p>
                    </td>
                    <td><?= esc($item['nama_kategori']); ?></td>
                    <td><?= $item['status'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>
                    <td>
                        <a class="btn btn-sm btn-info" href="<?= base_url('admin/artikel/edit/' . $item['id']); ?>">Ubah</a>
                        <a class="btn btn-sm btn-danger" href="<?= base_url('admin/artikel/delete/' . $item['id']); ?>" onclick="return confirm('Yakin menghapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Tidak ada data artikel.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination jika diperlukan -->
<?php if (isset($pager) && $pager->getPageCount() > 1): ?>
    <nav>
        <?= $pager->links(); ?>
    </nav>
<?php endif; ?>

<!-- Tidak perlu JavaScript untuk tabel statis -->

<?= $this->include('template/footer'); ?>
