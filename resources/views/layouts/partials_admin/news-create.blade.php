<div class="col-lg-12 dark-theme news-create-card">
    <div class="card-container">
        <div class="header-create-card">
            <h4 class="title">
                <i class="mdi mdi-file-document-plus icon-smd"></i> Tambah Berita Baru
            </h4>
            <a href="{{ route('admin.news.index') }}" class="btn btn-danger">
                <i class="mdi mdi-arrow-left-bold"></i> Kembali
            </a>
        </div>
        {{-- SHIMMER-ANIMATION --}}
        <div class="shimmer-animation-news-create mb-2">
            <div class="news-create"></div>
        </div>

        <hr class="w-100">

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data"
            class="form-news-create-card">
            @csrf
            <div class="form-container">
                {{-- ========== LEFT COLUMN ========== --}}
                <div class="left-column">

                    {{-- NEWS CATEGORY --}}
                    <div class="form-group">
                        <label for="category">Kategori Berita <span class="text-red">*</span></label>
                        <div class="select-wrapper">
                            <select name="category" id="category" class="@error('category') error @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-arrow"></div>
                        </div>
                        @error('category')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- UNIT UTAMA --}}
                    <div class="form-group">
                        <label for="office">Unit Utama <span class="text-red">*</span></label>
                        <div class="select-wrapper">
                            <select id="office" name="office" class="@error('office') error @enderror" required>
                                <option value="">Pilih Unit Utama</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office }}" {{ old('office') == $office ? 'selected' : '' }}>
                                        {{ $office }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-arrow"></div>
                        </div>
                        @error('office')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- INPUT UNIT UTAMA (Other) --}}
                    <div class="form-group hidden" id="office-other-group">
                        <label for="office_other">Unit Utama Lainnya</label>
                        <input type="text" id="office_other" name="office_other" value="{{ old('office_other') }}"
                            placeholder="Masukkan nama kantor">
                        @error('office_other')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NEWS TITLE --}}
                    <div class="form-group">
                        <label for="title">Judul Berita <span class="text-red">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="@error('title') error @enderror" placeholder="Masukkan judul berita">
                        @error('title')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NEWS TEXT CONTENT --}}
                    <div class="form-group">
                        <label for="content">Isi Berita <span class="text-red">*</span></label>
                        <textarea name="content" id="content" rows="12" placeholder="Max 2 paragraf..."
                            class="@error('content') error @enderror" required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ========== RIGHT COLUMN ========== --}}
                <div class="right-column">
                    {{-- SCREENSHOT IMAGE --}}
                    <div class="form-group mb-3">
                        <label for="cover_image" class="form-label fw-bold small">
                            Screenshot Berita <span class="text-danger">*</span>
                        </label>

                        <!-- AREA UPLOAD + PREVIEW -->
                        <div class="drop-zone-modern position-relative text-center p-4 rounded-3 border border-2 border-dashed"
                            id="drop-zone" style="overflow: hidden; cursor: pointer;">

                            <!-- Tombol Close (muncul setelah upload) -->
                            <button type="button"
                                class="btn-close btn-close-white position-absolute top-0 end-0 m-2 z-2 d-none"
                                aria-label="Close" id="preview-close"></button>

                            <!-- Ikon & Teks Default -->
                            <div class="drop-zone-placeholder">
                                <div class="icon-wrapper mb-2">
                                    <i class="mdi mdi-cloud-upload-outline fs-1 text-primary"></i>
                                </div>
                                <p class="mb-1 text-muted">Drag & Drop gambar di sini</p>
                                <p class="mb-0 small text-secondary">atau klik untuk memilih file</p>
                            </div>

                            <!-- Gambar Preview (hidden by default) -->
                            <img id="preview-img" src="" alt="Preview" class="img-fluid w-100 h-auto d-none preview-img"
                                style="display: block;">

                            <!-- INPUT FILE -->
                            <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;">
                        </div>

                        <!-- Error Message -->
                        @error('cover_image')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        <!-- Info Format -->
                        <small class="form-text text-muted mt-2 d-block">
                            Ukuran maksimal <strong>10MB</strong>.
                        </small>
                    </div>

                    {{-- NEWS DATE --}}
                    <div class="form-group">
                        <label for="news_date">Tanggal Berita <span class="text-red">*</span></label>
                        <div class="input-with-icon">
                            <i class="mdi mdi-calendar"></i>
                            <input type="date" name="news_date" id="news_date"
                                value="{{ old('news_date', date('Y-m-d')) }}" required
                                class="@error('news_date') error @enderror">
                        </div>
                        @error('news_date')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NEWS LINK --}}
                    <div class="form-group">
                        <label for="link_berita">Link Berita <span class="text-red">*</span></label>
                        <div class="input-with-icon">
                            <i class="mdi mdi-link"></i>
                            <input type="url" id="link_berita" name="link_berita"
                                placeholder="https://contoh.com/artikel" value="{{ old('link_berita') }}"
                                class="@error('link_berita') error @enderror">
                        </div>
                        @error('link_berita')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NEWS SUMBER --}}
                    <div class="form-group">
                        <label for="sumber">Sumber Berita <span class="text-red">*</span></label>
                        <div class="select-wrapper">
                            <select id="sumber" name="sumber" class="@error('sumber') error @enderror" required>
                                <option value="">Pilih Sumber Berita</option>
                                @foreach($sumbers as $sumber)
                                    <option value="{{ $sumber }}" {{ old('sumber') == $sumber ? 'selected' : '' }}>
                                        {{ $sumber }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-arrow"></div>
                        </div>
                        @error('sumber')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- INPUT NEWS SUMBER (Other) --}}
                    <div class="form-group hidden" id="sumber-other-group">
                        <label for="sumber_other">Nama Sumber Lainnya</label>
                        <input type="text" id="sumber_other" name="sumber_other" value="{{ old('sumber_other') }}"
                            placeholder="Masukkan nama sumber">
                        @error('sumber_other')
                            <p class="error-text">{{ $message }}</p>
                        @enderror

                        <label for="link_sumber_other" class="mt-2">Link Sumber Lainnya</label>
                        <div class="input-with-icon">
                            <i class="mdi mdi-link"></i>
                            <input type="url" id="link_sumber_other" name="link_sumber_other"
                                value="{{ old('link_sumber_other') }}" placeholder="https://sumber-lainnya.com">
                        </div>
                        @error('link_sumber_other')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BUTTON SUBMIT --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="mdi mdi-content-save"></i> Simpan Berita
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('assets/css/news-create.css') }}">