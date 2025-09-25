<div class="col-lg-12 dark-theme news-create-card">
    <div class="card-container">
        <div class="header-create-card">
            <h4 class="title">
                <i class="mdi mdi-pencil icon-smd"></i>
                Edit Konten Facebook
            </h4>
            <a href="{{ route('super-admin.facebook.index') }}" class="btn btn-danger">
                <i class="mdi mdi-arrow-left"></i> Batal
            </a>
        </div>

        {{-- ANIMASI TITLE --}}
        <div>
            <div class="edit-title-animation mb-2"></div>
        </div>

        <hr class="w-100">

        <form action="{{ route('super-admin.facebook.update', $facebook->id) }}" method="POST"
            enctype="multipart/form-data" class="form-news-create-card">
            @csrf
            @method('PUT')

            <div class="form-container">
                {{-- ========= LEFT COLUMN ========= --}}
                <div class="left-column">
                    {{-- JUDUL KONTEN --}}
                    <div class="form-group">
                        <label for="title">Judul Konten <span class="text-red">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $facebook->title) }}"
                            class="@error('title') error @enderror" placeholder="Masukkan judul konten" required>
                        @error('title')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- LINK KONTEN --}}
                    <div class="form-group">
                        <label for="link">Link Konten <span class="text-red">*</span></label>
                        <div class="input-with-icon">
                            <i class="mdi mdi-link"></i>
                            <input type="url" id="link" name="link" value="{{ old('link', $facebook->link) }}"
                                class="@error('link') error @enderror" placeholder="https://facebook.com/watch?v=xxxx"
                                required>
                        </div>
                        @error('link')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ========= RIGHT COLUMN ========= --}}
                <div class="right-column">
                    {{-- TANGGAL KONTEN --}}
                    <div class="form-group">
                        <label for="content_date">Tanggal Konten <span class="text-red">*</span></label>
                        <div class="input-with-icon">
                            <i class="mdi mdi-calendar"></i>
                            <input type="date" id="content_date" name="content_date"
                                value="{{ old('content_date', $facebook->content_date->format('Y-m-d')) }}"
                                class="@error('content_date') error @enderror" required>
                        </div>
                        @error('content_date')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="mdi mdi-content-save"></i> Update Konten
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('assets/css/news-create.css') }}">