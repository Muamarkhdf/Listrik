<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Manajemen Pelanggan</h1>
                <a href="<?= base_url('admin/pelanggan_add') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pelanggan
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <form class="row g-2 align-items-end" method="get" action="">
                <div class="col-md-4">
                    <label for="search" class="form-label mb-1">Cari Nama/Alamat/User</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label mb-1">Urutkan Berdasarkan</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="nama" <?= ($sort ?? '') === 'nama' ? 'selected' : '' ?>>Nama</option>
                        <option value="alamat" <?= ($sort ?? '') === 'alamat' ? 'selected' : '' ?>>Alamat</option>
                        <option value="daya" <?= ($sort ?? '') === 'daya' ? 'selected' : '' ?>>Daya</option>
                        <option value="tarif_per_kwh" <?= ($sort ?? '') === 'tarif_per_kwh' ? 'selected' : '' ?>>Tarif per kWh</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="order" class="form-label mb-1">Arah</label>
                    <select name="order" id="order" class="form-select">
                        <option value="asc" <?= ($order ?? '') === 'asc' ? 'selected' : '' ?>>Naik (A-Z/0-9)</option>
                        <option value="desc" <?= ($order ?? '') === 'desc' ? 'selected' : '' ?>>Turun (Z-A/9-0)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter</button>
                </div>
                <div class="col-md-1">
                    <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users"></i> Daftar Pelanggan
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($pelanggan): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Daya</th>
                                        <th>Tarif per kWh</th>
                                        <th>Username</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($pelanggan as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $p->nama ?></td>
                                            <td><?= $p->alamat ?></td>
                                            <td><?= $p->daya ?> VA</td>
                                            <td>Rp <?= number_format($p->tarif_per_kwh, 0, ',', '.') ?></td>
                                            <td><?= $p->username ?: '-' ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/pelanggan_edit/'.$p->pelanggan_id) ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/pelanggan_delete/'.$p->pelanggan_id) ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">Belum ada data pelanggan</h5>
                            <p class="text-muted">Silakan tambah pelanggan terlebih dahulu</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 