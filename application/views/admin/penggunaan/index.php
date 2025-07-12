<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Manajemen Penggunaan</h1>
                <a href="<?= base_url('admin/penggunaan_add') ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Penggunaan
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <form class="row g-2 align-items-end" method="get" action="">
                <div class="col-md-4">
                    <label for="search" class="form-label mb-1">Cari Nama/Bulan/Tahun</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label mb-1">Urutkan Berdasarkan</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="nama_pelanggan" <?= ($sort ?? '') === 'nama_pelanggan' ? 'selected' : '' ?>>Nama Pelanggan</option>
                        <option value="bulan" <?= ($sort ?? '') === 'bulan' ? 'selected' : '' ?>>Bulan</option>
                        <option value="tahun" <?= ($sort ?? '') === 'tahun' ? 'selected' : '' ?>>Tahun</option>
                        <option value="meter_awal" <?= ($sort ?? '') === 'meter_awal' ? 'selected' : '' ?>>Meter Awal</option>
                        <option value="meter_akhir" <?= ($sort ?? '') === 'meter_akhir' ? 'selected' : '' ?>>Meter Akhir</option>
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
                    <a href="<?= base_url('admin/penggunaan') ?>" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line"></i> Daftar Penggunaan Listrik
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($penggunaan): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggan</th>
                                        <th>Bulan/Tahun</th>
                                        <th>Meter Awal</th>
                                        <th>Meter Akhir</th>
                                        <th>Total kWh</th>
                                        <th>Status Tagihan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($penggunaan as $p): ?>
                                        <?php 
                                        // Check if tagihan exists for this penggunaan
                                        $tagihan_exists = $this->Tagihan_model->tagihan_exists($p->penggunaan_id);
                                        $tagihan = $tagihan_exists ? $this->Tagihan_model->get_tagihan_by_penggunaan($p->penggunaan_id) : null;
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $p->nama_pelanggan ?></td>
                                            <td><?= date('F Y', mktime(0, 0, 0, $p->bulan, 1, $p->tahun)) ?></td>
                                            <td><?= number_format($p->meter_awal, 2) ?></td>
                                            <td><?= number_format($p->meter_akhir, 2) ?></td>
                                            <td><?= number_format($p->meter_akhir - $p->meter_awal, 2) ?></td>
                                            <td>
                                                <?php 
                                                $tagihan = $this->Tagihan_model->get_tagihan_by_penggunaan($p->penggunaan_id);
                                                ?>
                                                <?php if($tagihan): ?>
                                                    <span class="badge bg-<?= $tagihan->status == 'Lunas' ? 'success' : 'warning' ?>">
                                                        <?= $tagihan->status ?>
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">
                                                        Rp <?= number_format($tagihan->total_tagihan, 0, ',', '.') ?>
                                                    </small>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Belum Ada Tagihan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/penggunaan_edit/'.$p->penggunaan_id) ?>" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/penggunaan_delete/'.$p->penggunaan_id) ?>" 
                                                   class="btn btn-sm btn-danger" title="Hapus"
                                                   onclick="return confirm('Yakin ingin menghapus data penggunaan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <?php if(!$tagihan_exists): ?>
                                                    <a href="<?= base_url('admin/generate_tagihan/'.$p->penggunaan_id) ?>" 
                                                       class="btn btn-sm btn-info" title="Generate Tagihan">
                                                        <i class="fas fa-file-invoice"></i> Generate
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('admin/tagihan') ?>" 
                                                       class="btn btn-sm btn-success" title="Lihat Tagihan">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line text-muted" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">Belum ada data penggunaan</h5>
                            <p class="text-muted">Silakan tambah data penggunaan terlebih dahulu</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 