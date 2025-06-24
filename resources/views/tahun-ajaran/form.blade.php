<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">
            {{ $tahunAjaran->exists ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        {{-- ID Tahun Ajaran (read only if editing) --}}
        <div class="mb-3">
            <label for="id_ta" class="form-label">ID Tahun Ajaran</label>
            <input type="text" id="id_ta" name="id_ta" class="form-control" 
                value="{{ old('id_ta', $tahunAjaran->id_ta ?? $nextId ?? '') }}"
                {{ $tahunAjaran->exists ? 'readonly' : '' }}>
            @error('id_ta')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
        <label for="semester" class="form-label">Semester</label>
        <select name="semester" id="semester" class="form-select">
            <option value="">-- Pilih Semester --</option>
            <option value="1" {{ old('semester', $tahunAjaran->semester) == '1' ? 'selected' : '' }}>1</option>
            <option value="2" {{ old('semester', $tahunAjaran->semester) == '2' ? 'selected' : '' }}>2</option>
        </select>
        @error('semester')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
        </div>

       {{-- Tahun Ajaran --}}
        <div class="mb-3">
            <label for="tahun_ajaran" class="form-label">Tahun Ajaran (contoh: 2023/2024)</label>
            <input type="text" name="tahun_ajaran" class="form-control" required
                value="{{ old('tahun_ajaran', isset($tahunAjaran->tahun_mulai) ? $tahunAjaran->tahun_mulai . '/' . ($tahunAjaran->tahun_mulai + 1) : '') }}">
        </div>


        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">Status</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="status_aktif" value="1"
                        {{ old('status', $tahunAjaran->status) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="status_aktif">Aktif</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="status_tidak_aktif" value="0"
                        {{ old('status', $tahunAjaran->status) == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="status_tidak_aktif">Tidak Aktif</label>
                </div>
            </div>
            @error('status')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">
            {{ $tahunAjaran->exists ? 'Update' : 'Simpan' }}
        </button>
    </div>
</div>
