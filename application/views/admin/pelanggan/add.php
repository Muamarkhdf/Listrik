<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Pelanggan</h5>
                </div>
                <div class="card-body">
                    <?= form_open('admin/pelanggan_add') ?>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>" value="<?= set_value('nama') ?>" required>
                            <?= form_error('nama', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control <?= form_error('alamat') ? 'is-invalid' : '' ?>" required><?= set_value('alamat') ?></textarea>
                            <?= form_error('alamat', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                        <div class="mb-3">
                            <label for="level_id" class="form-label">Level (Daya) <span class="text-danger">*</span></label>
                            <select name="level_id" id="level_id" class="form-control <?= form_error('level_id') ? 'is-invalid' : '' ?>" required>
                                <option value="">Pilih Level</option>
                                <?php foreach($levels as $level): ?>
                                    <option value="<?= $level->level_id ?>" <?= set_select('level_id', $level->level_id) ?>>Daya: <?= $level->daya ?> VA - Tarif: Rp <?= number_format($level->tarif_per_kwh, 0, ',', '.') ?>/kWh</option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('level_id', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User (Opsional)</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">-- Tidak dikaitkan user --</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?= $user->user_id ?>" <?= set_select('user_id', $user->user_id) ?>><?= $user->username ?> (<?= $user->nama ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div> 