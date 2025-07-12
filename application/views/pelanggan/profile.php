<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Profil Pelanggan</h1>
        </div>
    </div>

    <?php if($pelanggan): ?>
        <div class="row">
            <div class="col-lg-8">
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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-circle"></i> Informasi Akun
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="120"><strong>Username:</strong></td>
                                <td><?= $user['username'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nama:</strong></td>
                                <td><?= $user['nama'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Role:</strong></td>
                                <td>
                                    <span class="badge bg-success"><?= ucfirst($user['role']) ?></span>
                                </td>
                            </tr>
                        </table>
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