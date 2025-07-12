<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Data Penggunaan Listrik</h1>
                <a href="<?= base_url('pelanggan/penggunaan_add') ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Penggunaan
                </a>
            </div>
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
                                        <th>Bulan/Tahun</th>
                                        <th>Meter Awal</th>
                                        <th>Meter Akhir</th>
                                        <th>Total kWh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($penggunaan as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('F Y', mktime(0, 0, 0, $p->bulan, 1, $p->tahun)) ?></td>
                                            <td><?= number_format($p->meter_awal, 2) ?></td>
                                            <td><?= number_format($p->meter_akhir, 2) ?></td>
                                            <td><?= number_format($p->meter_akhir - $p->meter_awal, 2) ?></td>
                                            <td>
                                                <a href="<?= base_url('pelanggan/penggunaan_edit/'.$p->penggunaan_id) ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('pelanggan/penggunaan_delete/'.$p->penggunaan_id) ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Yakin ingin menghapus data penggunaan ini?')">
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