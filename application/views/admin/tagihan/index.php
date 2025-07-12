<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Manajemen Tagihan</h1>
                <a href="<?= base_url('admin/penggunaan') ?>" class="btn btn-info">
                    <i class="fas fa-chart-line"></i> Lihat Penggunaan
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-invoice"></i> Daftar Tagihan Listrik
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($tagihan): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggan</th>
                                        <th>Bulan/Tahun</th>
                                        <th>Total kWh</th>
                                        <th>Tarif/kWh</th>
                                        <th>Perhitungan</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($tagihan as $t): ?>
                                        <?php $penggunaan = $this->Tagihan_model->get_penggunaan_for_tagihan($t->penggunaan_id); ?>
                                        <?php $total_kwh = $penggunaan ? ($penggunaan->meter_akhir - $penggunaan->meter_awal) : $t->total_kwh; ?>
                                        <?php $tarif = $penggunaan ? $penggunaan->tarif_per_kwh : ($t->total_tagihan / max($t->total_kwh,1)); ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= $t->nama_pelanggan ?></strong><br>
                                                <small class="text-muted"><?= $t->alamat ?></small>
                                            </td>
                                            <td><?= date('F Y', mktime(0, 0, 0, $t->bulan, 1, $t->tahun)) ?></td>
                                            <td><?= number_format($total_kwh, 2) ?> kWh</td>
                                            <td>Rp <?= number_format($tarif, 0, ',', '.') ?></td>
                                            <td><?= number_format($total_kwh, 2) ?> kWh × Rp <?= number_format($tarif, 0, ',', '.') ?> = <strong>Rp <?= number_format($total_kwh * $tarif, 0, ',', '.') ?></strong></td>
                                            <td><strong>Rp <?= number_format($total_kwh * $tarif, 0, ',', '.') ?></strong></td>
                                            <td>
                                                <span class="badge bg-<?= $t->status == 'Lunas' ? 'success' : 'warning' ?>">
                                                    <?= $t->status ?>
                                                </span>
                                            </td>
                                            <td><?= date('d/m/Y H:i', strtotime($t->created_at)) ?></td>
                                            <td>
                                                <?php if($t->status == 'Belum Lunas'): ?>
                                                    <a href="<?= base_url('admin/tagihan_status/'.$t->tagihan_id.'/Lunas') ?>" 
                                                       class="btn btn-sm btn-success" title="Set Lunas"
                                                       onclick="return confirm('Set tagihan ini sebagai Lunas?')">
                                                        <i class="fas fa-check"></i> Lunas
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('admin/tagihan_status/'.$t->tagihan_id.'/Belum Lunas') ?>" 
                                                       class="btn btn-sm btn-warning" title="Set Belum Lunas"
                                                       onclick="return confirm('Set tagihan ini sebagai Belum Lunas?')">
                                                        <i class="fas fa-times"></i> Belum Lunas
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?= base_url('admin/tagihan_delete/'.$t->tagihan_id) ?>" 
                                                   class="btn btn-sm btn-danger" title="Hapus"
                                                   onclick="return confirm('Yakin ingin menghapus tagihan ini?')">
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
                            <i class="fas fa-file-invoice text-muted" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">Belum ada data tagihan</h5>
                            <p class="text-muted">Silakan generate tagihan dari data penggunaan terlebih dahulu</p>
                            <a href="<?= base_url('admin/penggunaan') ?>" class="btn btn-primary">
                                <i class="fas fa-chart-line"></i> Lihat Penggunaan
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 