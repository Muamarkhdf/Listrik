<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Dashboard Admin</h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        <div class="col">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Total Pelanggan</h5>
                            <h2 class="mb-0"><?= $total_pelanggan ?></h2>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Total Penggunaan</h5>
                            <h2 class="mb-0"><?= $total_penggunaan ?></h2>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Total Tagihan</h5>
                            <h2 class="mb-0"><?= $total_tagihan ?></h2>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tagihan Statistics -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie"></i> Status Tagihan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-success"><?= $tagihan_stats->lunas ?? 0 ?></h4>
                                <small class="text-muted">Lunas</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning"><?= $tagihan_stats->belum_lunas ?? 0 ?></h4>
                            <small class="text-muted">Belum Lunas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Selamat datang di Aplikasi Pembayaran Listrik!</strong></p>
                            <p class="mb-0">Sistem ini memungkinkan Anda untuk:</p>
                            <ul class="mb-0">
                                <li>Mengelola data pelanggan</li>
                                <li>Mencatat penggunaan listrik</li>
                                <li>Membuat dan mengelola tagihan</li>
                                <li>Memantau status pembayaran</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/pelanggan_add') ?>" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus"></i> Tambah Pelanggan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/penggunaan_add') ?>" class="btn btn-success w-100">
                                <i class="fas fa-plus"></i> Tambah Penggunaan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-info w-100">
                                <i class="fas fa-users"></i> Lihat Pelanggan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/tagihan') ?>" class="btn btn-warning w-100">
                                <i class="fas fa-file-invoice"></i> Lihat Tagihan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 