<div class="col-lg-12 dark-theme news-create-card">
    <div class="card-container">
        <div class="header-create-card">
            <h4 class="title">
                <i class="mdi mdi-twitter icon-smd"></i>
                Tambah Konten Twitter
            </h4>
            <a href="{{ route('super-admin.twitter.index') }}">
                <i class="mdi mdi-arrow-left-bold"></i> Kembali
            </a>
        </div>

        {{-- SHIMMER-ANIMATION --}}
        <div>
            <div class="twitter-create mb-2"></div>
        </div>

        <hr class="w-100">

        <form action="{{ route('super-admin.twitter.store') }}" method="POST" enctype="multipart/form-data" class="form-news-create-card">
            @csrf
            <div class="form-container">
                {{-- KOLOM INPUT (KIRI) --}}
                <div class="left-column">
                    {{-- JUDUL KONTEN --}} 
                    <div class="form-group">
                        <label for="title">Judul Konten <span class="text-red">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="@error('title') error @enderror" placeholder="Masukkan judul konten twitter">
                        @error('title')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- LINK KONTEN --}}
                    <div class="form-group">
                        <label for="link">Link Konten <span class="text-red">*</span></label>
                        <div class="input-with-icon">
                            <i class="mdi mdi-link"></i>
                            <input type="url" name="link" id="link"
                                placeholder="https://contoh.com/konten" value="{{ old('link') }}"
                                class="@error('link') error @enderror">
                        </div>
                        @error('link')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- KOLOM INPUT (KANAN) --}}
                <div class="right-column">
                    {{-- TANGGAL KONTEN --}}
                    <div class="form-group mb-3">
                        <label for="content_date" class="form-label fw-bold small">
                            Tanggal Konten <span class="text-red">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="mdi mdi-calendar"></i>
                            <input type="date" name="content_date" id="content_date"
                            value="{{ old('content_date', date('Y-m-d')) }}" required
                            class="@error('content_date') error @enderror">
                        </div>
                        @error('content_date')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TOMBOL SUBMIT --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="mdi mdi-content-save"></i> 
                            Simpan Konten
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('assets/css/news-create.css') }}">