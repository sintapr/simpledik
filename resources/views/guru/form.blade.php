<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">{{ $guru && $guru->exists ? 'Edit' : 'Tambah' }} Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <form method="POST" enctype="multipart/form-data"
        action="{{ $guru && $guru->exists ? route('guru.update', $guru->NIP) : route('guru.store') }}">
        @csrf
        @if($guru && $guru->exists)
            @method('PUT')
        @endif

        <div class="modal-body">
            {{-- NIP --}}
            <div class="mb-3">
                <label for="NIP" class="form-label">NIP</label>
                <input type="text" name="NIP" id="NIP"
                       class="form-control @error('NIP') is-invalid @enderror"
                       value="{{ old('NIP', $guru->NIP ?? '') }}"
                       {{ $guru && $guru->exists ? 'readonly' : '' }}>
                @error('NIP')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nama Guru --}}
            <div class="mb-3">
                <label for="nama_guru" class="form-label">Nama Guru</label>
                <input type="text" name="nama_guru" id="nama_guru"
                       class="form-control @error('nama_guru') is-invalid @enderror"
                       value="{{ old('nama_guru', $guru->nama_guru ?? '') }}">
                @error('nama_guru')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jabatan --}}
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <select name="jabatan" id="jabatan"
                        class="form-select @error('jabatan') is-invalid @enderror">
                    <option value="">-- Pilih Jabatan --</option>
                    @php $jabatanOld = old('jabatan', $guru->jabatan ?? ''); @endphp
                    <option value="kepala_sekolah" {{ $jabatanOld == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                    <option value="wali_kelas" {{ $jabatanOld == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    <option value="admin" {{ $jabatanOld == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" id="tgl_lahir"
                       class="form-control @error('tgl_lahir') is-invalid @enderror"
                       value="{{ old('tgl_lahir', isset($guru) && $guru->tgl_lahir ? $guru->tgl_lahir->format('Y-m-d') : '') }}">
                @error('tgl_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Foto --}}
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" id="foto"
                       class="form-control @error('foto') is-invalid @enderror">
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($guru && $guru->foto)
                    <img src="{{ asset('storage/' . $guru->foto) }}" width="80" class="rounded mt-2" alt="Foto Guru">
                @endif
            </div>

            {{-- Password (edit only) --}}
            {{-- @if ($guru && $guru->exists)
                <div class="mb-3">
                    <label for="PASSWORD" class="form-label">Ubah Password</label>
                    <input type="password" name="PASSWORD" id="PASSWORD"
                           class="form-control @error('PASSWORD') is-invalid @enderror"
                           placeholder="Kosongkan jika tidak ingin mengubah">
                    @error('PASSWORD')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif --}}

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="aktif" value="1"
                            {{ old('status', $guru->status ?? 1) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="aktif">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="tidakaktif" value="0"
                            {{ old('status', $guru->status ?? 1) == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidakaktif">Tidak Aktif</label>
                    </div>
                </div>
                @error('status')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> {{ $guru && $guru->exists ? 'Update' : 'Simpan' }}
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</div>
