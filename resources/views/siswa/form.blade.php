<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">{{ $siswa->exists ? 'Edit Siswa' : 'Tambah Siswa' }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        {{-- NIS --}}
        <div class="mb-3">
            <label for="NIS" class="form-label">NIS</label>
            <input type="text" name="NIS" id="NIS" class="form-control" value="{{ old('NIS', $siswa->NIS) }}" {{ $siswa->exists ? 'readonly' : '' }}>
        </div>

        {{-- NISN --}}
        <div class="mb-3">
            <label for="NISN" class="form-label">NISN</label>
            <input type="text" name="NISN" id="NISN" class="form-control" value="{{ old('NISN', $siswa->NISN) }}">
        </div>

        {{-- NIK --}}
        <div class="mb-3">
            <label for="NIK" class="form-label">NIK</label>
            <input type="text" name="NIK" id="NIK" class="form-control" value="{{ old('NIK', $siswa->NIK) }}">
        </div>

        {{-- Nama Siswa --}}
        <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" value="{{ old('nama_siswa', $siswa->nama_siswa) }}">
        </div>

        {{-- Tempat Lahir --}}
        <div class="mb-3">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
        </div>

        {{-- Tanggal Lahir --}}
        <div class="mb-3">
            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" value="{{ old('tgl_lahir', $siswa->tgl_lahir) }}">
        </div>

        {{-- Foto --}}
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control">
            @if ($siswa->foto)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto" class="img-thumbnail" width="100" height="100" style="object-fit: cover;">
                </div>
            @endif
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</div>
