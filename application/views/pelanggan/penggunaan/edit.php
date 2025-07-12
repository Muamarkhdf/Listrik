<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit Penggunaan Listrik</h1>
                <a href="<?= base_url('pelanggan/penggunaan') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Form Edit Penggunaan
                    </h5>
                </div>
                <div class="card-body">
                    <?= form_open('pelanggan/penggunaan_edit/'.$penggunaan->penggunaan_id) ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                                <select name="bulan" id="bulan" class="form-control <?= form_error('bulan') ? 'is-invalid' : '' ?>" required>
                                    <option value="">Pilih Bulan</option>
                                    <option value="1" <?= set_select('bulan', '1', $penggunaan->bulan == 1) ?>>Januari</option>
                                    <option value="2" <?= set_select('bulan', '2', $penggunaan->bulan == 2) ?>>Februari</option>
                                    <option value="3" <?= set_select('bulan', '3', $penggunaan->bulan == 3) ?>>Maret</option>
                                    <option value="4" <?= set_select('bulan', '4', $penggunaan->bulan == 4) ?>>April</option>
                                    <option value="5" <?= set_select('bulan', '5', $penggunaan->bulan == 5) ?>>Mei</option>
                                    <option value="6" <?= set_select('bulan', '6', $penggunaan->bulan == 6) ?>>Juni</option>
                                    <option value="7" <?= set_select('bulan', '7', $penggunaan->bulan == 7) ?>>Juli</option>
                                    <option value="8" <?= set_select('bulan', '8', $penggunaan->bulan == 8) ?>>Agustus</option>
                                    <option value="9" <?= set_select('bulan', '9', $penggunaan->bulan == 9) ?>>September</option>
                                    <option value="10" <?= set_select('bulan', '10', $penggunaan->bulan == 10) ?>>Oktober</option>
                                    <option value="11" <?= set_select('bulan', '11', $penggunaan->bulan == 11) ?>>November</option>
                                    <option value="12" <?= set_select('bulan', '12', $penggunaan->bulan == 12) ?>>Desember</option>
                                </select>
                                <?= form_error('bulan', '<div class="invalid-feedback">', '</div>') ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                                <input type="number" name="tahun" id="tahun" class="form-control <?= form_error('tahun') ? 'is-invalid' : '' ?>" 
                                       placeholder="2024" min="2000" max="2030" value="<?= set_value('tahun', $penggunaan->tahun) ?>" required>
                                <?= form_error('tahun', '<div class="invalid-feedback">', '</div>') ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="meter_awal" class="form-label">Meter Awal (kWh) <span class="text-danger">*</span></label>
                                <input type="number" name="meter_awal" id="meter_awal" class="form-control <?= form_error('meter_awal') ? 'is-invalid' : '' ?>" 
                                       placeholder="0.00" step="0.01" min="0" value="<?= set_value('meter_awal', $penggunaan->meter_awal) ?>" required>
                                <?= form_error('meter_awal', '<div class="invalid-feedback">', '</div>') ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="meter_akhir" class="form-label">Meter Akhir (kWh) <span class="text-danger">*</span></label>
                                <input type="number" name="meter_akhir" id="meter_akhir" class="form-control <?= form_error('meter_akhir') ? 'is-invalid' : '' ?>" 
                                       placeholder="0.00" step="0.01" min="0" value="<?= set_value('meter_akhir', $penggunaan->meter_akhir) ?>" required>
                                <?= form_error('meter_akhir', '<div class="invalid-feedback">', '</div>') ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Informasi:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Meter Akhir harus lebih besar atau sama dengan Meter Awal</li>
                                        <li>Total penggunaan = Meter Akhir - Meter Awal</li>
                                        <li>Data penggunaan per bulan dan tahun harus unik</li>
                                        <li>Total penggunaan saat ini: <strong><?= number_format($penggunaan->meter_akhir - $penggunaan->meter_awal, 2) ?> kWh</strong></li>
                                        <li>Tarif Anda: <strong>Rp <?= number_format($pelanggan->tarif_per_kwh, 0, ',', '.') ?> per kWh</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Penggunaan
                                </button>
                                <a href="<?= base_url('pelanggan/penggunaan') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user"></i> Informasi Pelanggan
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama:</strong></td>
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
                    <hr>
                    <h6>Langkah Pengisian:</h6>
                    <ol>
                        <li>Pilih bulan dan tahun penggunaan</li>
                        <li>Masukkan meter awal (angka di meteran sebelumnya)</li>
                        <li>Masukkan meter akhir (angka di meteran saat ini)</li>
                        <li>Klik Update untuk menyimpan perubahan</li>
                    </ol>
                    <hr>
                    <h6>Catatan Penting:</h6>
                    <ul>
                        <li>Meter akhir harus ≥ meter awal</li>
                        <li>Satu bulan hanya bisa satu data</li>
                        <li>Setelah update, admin akan generate ulang tagihan jika perlu</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validasi meter akhir harus lebih besar dari meter awal
document.getElementById('meter_akhir').addEventListener('input', function() {
    var meterAwal = parseFloat(document.getElementById('meter_awal').value) || 0;
    var meterAkhir = parseFloat(this.value) || 0;
    
    if (meterAkhir < meterAwal) {
        this.setCustomValidity('Meter akhir harus lebih besar atau sama dengan meter awal');
    } else {
        this.setCustomValidity('');
    }
});

// Auto-calculate total usage and estimated bill
function calculateTotal() {
    var meterAwal = parseFloat(document.getElementById('meter_awal').value) || 0;
    var meterAkhir = parseFloat(document.getElementById('meter_akhir').value) || 0;
    var total = meterAkhir - meterAwal;
    var tarif = <?= $pelanggan->tarif_per_kwh ?>;
    
    if (total >= 0) {
        var estimasiTagihan = total * tarif;
        console.log('Total penggunaan: ' + total + ' kWh');
        console.log('Estimasi tagihan: Rp ' + estimasiTagihan.toLocaleString('id-ID'));
    }
}

document.getElementById('meter_awal').addEventListener('input', calculateTotal);
document.getElementById('meter_akhir').addEventListener('input', calculateTotal);
</script> 