<div class="col-lg-12 dark-theme news-create-card">
    <div class="card-container">
        <div class="header-create-card">
            <h4 class="title">
                <i class="mdi mdi-pencil icon-smd"></i>
                Edit Berita
            </h4>
            <a href="{{ route('admin.news.index') }}" class="btn btn-danger">
                <i class="mdi mdi-arrow-left"></i> Batal
            </a>
        </div>

        <div>
            <div class="edit-title-animation mb-2"></div>
        </div>

        <hr class="w-100">

        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data"
            class="form-news-create-card">
            @csrf
            @method('PUT')

            <div class="form-container">
                {{-- ========= LEFT COLUMN ========= --}}
                <div class="left-column">

                    {{-- NEWS CATEGORY --}}
                    <div class="form-group">
                        <label for="category">
                            Kategori Berita <span class="text-red">*</span>
                        </label>
                        <div class="select-wrapper">
                            <select name="category" id="category" class="@error('category') error @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category', $news->category) == $category ? 'selected' : '' }}>
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
                                    <option value="{{ $office }}" {{ old('office', $news->office) == $office ? 'selected' : '' }}>
                                        {{ $office }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-arrow"></div>
                        </div>
                        @error('office')
                            <p class="error-text">{{ $message }}</p>
                        @enderror

                        {{-- UNIT UTAMA "Other" --}}
                        <div id="office-other-group"
                            class="form-group {{ old('office', $news->office) == 'Other' ? '' : 'hidden' }}">
                            <label for="office_other" class="block text-sm font-semibold text-gray-700 mt-2">Unit Utama Lainnya <span class="text-warning">*</span></label>
                            <input type="text" id="office_other" name="office_other"
                                class="@error('office_other') error @enderror"
                                value="{{ old('office_other', $officeOther ?? '') }}">
                            @error('office_other')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- NEWS TITLE --}}
                    <div class="form-group">
                        <label for="title">Judul Berita <span class="text-red">*</span></label>
                        <input type="text" id="title" name="title" class="@error('title') error @enderror"
                            value="{{ old('title', $news->title) }}" required>
                        @error('title')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NEWS TEXT --}}
                    <div class="form-group">
                        <label for="content">Isi Berita <span class="text-red">*</span></label>
                        <textarea id="content" name="content" rows="12"
                            class="@error('content') error @enderror">{{ old('content', $news->content) }}</textarea>
                        @error('content')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ========= RIGHT COLUMN ========= --}}
                <div class="right-column">
                    {{-- SCREENSHOT IMAGE --}}
                    <div class="form-group mb-3">
                        <label for="cover_image" class="form-label fw-bold small">
                            Screenshot Berita <span class="text-red">*</span>
                        </label>

                        {{-- AREA UPLOAD + PREVIEW --}}
                        <div class="drop-zone-modern position-relative text-center p-4 rounded-3 border border-2 border-dashed"
                            id="drop-zone" style="overflow: hidden; cursor: pointer;">

                            {{-- TOMBOL CLOSE --}}
                            <button type="button" class="btn-close position-absolute top-0 end-0 m-2 z-2 d-none"
                                aria-label="Close" id="preview-close"></button>

                            {{-- PLACEHOLDER (Default State) --}}
                            <div class="drop-zone-placeholder">
                                <div class="icon-wrapper mb-2">
                                    <i class="mdi mdi-cloud-upload-outline fs-1 text-primary"></i>
                                </div>
                                <p class="mb-1 text-muted">Drag & Drop gambar di sini</p>
                                <p class="mb-0 small text-secondary">atau klik untuk memilih file</p>
                            </div>

                            {{-- GAMBAR PREVIEW --}}
                            <img id="preview-img" src="{{ $news->cover_image ? Storage::url($news->cover_image) : '' }}"
                                alt="Preview" class="preview-img rounded-3 mb-0 mt-0 {{ $news->cover_image ? '' : 'd-none' }}">

                            {{-- INPUT FILE --}}
                            <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;">
                        </div>

                        {{-- ERROR MESSAGE --}}
                        @error('cover_image')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        {{-- INFO FORMAT --}}
                        <small class="form-text text-muted mt-2 d-block">
                            Format yang diizinkan: JPG, PNG, Maksimal <strong class="text-danger">10MB</strong>.
                        </small>
                    </div>

                    {{-- NEWS DATE --}}
                    <div class="form-group">
                        <label for="news_date">Tanggal Berita <span class="text-red">*</span></label>
                        <input type="date" id="news_date" name="news_date" class="@error('news_date') error @enderror"
                            value="{{ old('news_date', \Carbon\Carbon::parse($news->news_date)->format('Y-m-d')) }}"
                            required>
                        @error('news_date')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NEWS SUMBER --}}
                    <div class="form-group">
                        <label for="sumber" class="block text-sm font-semibold text-gray-700">Sumber Berita <span
                                class="text-red">*</span></label>
                        <div class="select-wrapper">
                            <select id="sumber" name="sumber" class="@error('sumber') error @enderror" required>
                                <option value="">Pilih Sumber Berita</option>
                                @foreach($sumbers as $sumber)
                                    <option value="{{ $sumber }}" {{ old('sumber', $news->sumber) == $sumber ? 'selected' : '' }}>
                                        {{ $sumber }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-arrow"></div>
                        </div>
                        @error('sumber')
                            <p class="error-text">{{ $message }}</p>
                        @enderror

                        {{-- SUMBER "Other" --}}
                        <div id="sumber-other-group"
                            class="form-group {{ old('sumber', $news->sumber) == 'Other' ? '' : 'hidden' }}">
                            <label for="sumber_other" class="block text-sm font-semibold text-gray-700 mt-2">Sumber
                                Lainnya</label>
                            <input type="text" id="sumber_other" name="sumber_other"
                                class="@error('sumber_other') error @enderror"
                                value="{{ old('sumber_other', $sumberOther ?? '') }}">
                            @error('sumber_other')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- NEWS LINK --}}
                    <div class="form-group">
                        <label for="link_berita">Link Berita <span class="text-red">*</span></label>
                        <div class="input-with-icon">
                            <i class="mdi mdi-link"></i>
                            <input type="url" id="link_berita" name="link_berita"
                                class="@error('link_berita') error @enderror"
                                value="{{ old('link_berita', $news->link_berita) }}" placeholder="https://...">
                        </div>
                        @error('link_berita')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SUBMIT NEWS UPDATE --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="mdi mdi-content-save"></i> Update Berita
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('assets/css/news-create.css') }}">