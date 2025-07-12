<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Dashboard Pelanggan</h1>
        </div>
    </div>

    <?php if($pelanggan): ?>
        <!-- Pelanggan Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user"></i> Informasi Pelanggan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Nama:</strong></td>
                                        <td><?= $pelanggan->nama ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat:</strong></td>
                                        <td><?= $pelanggan->alamat ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Daya:</strong></td>
                                        <td><?= $pelanggan->daya ?> VA</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tarif per kWh:</strong></td>
                                        <td>Rp <?= number_format($pelanggan->tarif_per_kwh, 0, ',', '.') ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="card-title">Total Penggunaan</h5>
                                <h2 class="mb-0"><?= count($penggunaan) ?></h2>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="card-title">Total Tagihan</h5>
                                <h2 class="mb-0"><?= count($tagihan) ?></h2>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-invoice stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="card-title">Tagihan Lunas</h5>
                                <h2 class="mb-0">
                                    <?= count(array_filter($tagihan, function($t) { return $t->status == 'Lunas'; })) ?>
                                </h2>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Data -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line"></i> Penggunaan Terbaru
                        </h5>
                        <a href="<?= base_url('pelanggan/penggunaan') ?>" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if($penggunaan): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Bulan/Tahun</th>
                                            <th>Meter Awal</th>
                                            <th>Meter Akhir</th>
                                            <th>Total kWh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach(array_slice($penggunaan, 0, 5) as $p): ?>
                                            <tr>
                                                <td><?= date('F Y', mktime(0, 0, 0, $p->bulan, 1, $p->tahun)) ?></td>
                                                <td><?= number_format($p->meter_awal, 2) ?></td>
                                                <td><?= number_format($p->meter_akhir, 2) ?></td>
                                                <td><?= number_format($p->meter_akhir - $p->meter_awal, 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center mb-0">Belum ada data penggunaan</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-invoice"></i> Tagihan Terbaru
                        </h5>
                        <a href="<?= base_url('pelanggan/tagihan') ?>" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if($tagihan): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Bulan/Tahun</th>
                                            <th>Total kWh</th>
                                            <th>Total Tagihan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach(array_slice($tagihan, 0, 5) as $t): ?>
                                            <tr>
                                                <td><?= date('F Y', mktime(0, 0, 0, $t->bulan, 1, $t->tahun)) ?></td>
                                                <td><?= number_format($t->total_kwh, 2) ?></td>
                                                <td>Rp <?= number_format($t->total_tagihan, 0, ',', '.') ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $t->status == 'Lunas' ? 'success' : 'warning' ?>">
                                                        <?= $t->status ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center mb-0">Belum ada data tagihan</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="<?= base_url('pelanggan/penggunaan_add') ?>" class="btn btn-success w-100">
                                    <i class="fas fa-plus"></i> Tambah Penggunaan
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="<?= base_url('pelanggan/penggunaan') ?>" class="btn btn-info w-100">
                                    <i class="fas fa-chart-line"></i> Lihat Penggunaan
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="<?= base_url('pelanggan/tagihan') ?>" class="btn btn-warning w-100">
                                    <i class="fas fa-file-invoice"></i> Lihat Tagihan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Data Pelanggan Tidak Ditemukan</h4>
                        <p class="text-muted">Silakan hubungi administrator untuk mengatur data pelanggan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div> 