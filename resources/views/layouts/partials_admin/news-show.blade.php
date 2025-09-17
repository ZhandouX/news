<div class="content-wrapper">
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold"><i class="mdi mdi-information icon-smd"></i><strong> Informasi Berita</strong></h3>

                        {{-- Loading Bar Animasi --}}
                        <div class="loading-bar-wrapper mb-2">
                            <div class="loading-bar"></div>
                        </div>

                    </div>
                    <div>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-light btn-lg mb-0 me-0">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title">{{ $news->title }}</h4>
                            <hr class="w-100">
                            <p class="card-description mb-0">
                                <span class="badge badge-primary">{{ $news->category }}</span>
                                <span class="text-muted ml-2">{{ $news->formatted_news_date }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Konten Utama --}}
                        <div class="col-lg-8">
                            {{-- Cover Image --}}
                            @if($news->cover_image)
                                <div class="mb-4">
                                    <img src="{{ Storage::url($news->cover_image) }}" alt="Cover Image"
                                        class="img-fluid rounded shadow-sm w-100"
                                        style="max-height: 400px; object-fit: cover;">
                                </div>
                            @endif

                            {{-- Content --}}
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="mdi mdi-newspaper-variant-multiple-outline"></i>
                                        Isi Berita</h5>
                                    <hr class="w-100">
                                    <div class="news-content">
                                        {!! nl2br(e($news->content)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sidebar --}}
                        <div class="col-lg-4">
                            {{-- Informasi Berita --}}
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="mdi mdi-information-outline"></i>
                                        Informasi
                                    </h5>

                                    <div class="line-info-wrapper mb-2">
                                        <div class="line-info"></div>
                                    </div>

                                    <div class="info-list">
                                        <dl>
                                            <div class="info-item">
                                                <dt>Kategori</dt>
                                                <dd><span
                                                        class="badge badge-outline-danger">{{ $news->category }}</span>
                                                </dd>
                                            </div>
                                            <div class="info-item">
                                                <dt>Tanggal Berita</dt>
                                                <dd>{{ $news->formatted_news_date }}</dd>
                                            </div>
                                            <div class="info-item">
                                                <dt>Unit Utama</dt>
                                                <dd>{{ $news->office }}</dd>
                                            </div>
                                            <div class="info-item">
                                                <dt>Sumber</dt>
                                                <dd>{{ $news->sumber }}</dd>
                                            </div>
                                            <div class="info-item">
                                                <dt>Link Sumber</dt>
                                                <dd>
                                                    @if($news->link_sumber)
                                                        <a href="{{ $news->link_sumber }}"
                                                            target="_blank">{{ $news->link_sumber }}</a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </dd>
                                            </div>
                                            <div class="info-item">
                                                <dt>Link Berita</dt>
                                                <dd>
                                                    @if($news->link_berita)
                                                        <a href="{{ $news->link_berita }}"
                                                            target="_blank">{{ $news->link_berita }}</a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </dd>
                                            </div>
                                            <div class="info-item">
                                                <dt>Dibuat</dt>
                                                <dd>{{ $news->formatted_created_at }}</dd>
                                            </div>
                                            <div class="info-item">
                                                <dt>Diperbarui</dt>
                                                <dd>{{ $news->updated_at->format('d M Y, H:i') }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            {{-- AKSI --}}
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="mdi mdi-cog-outline text-warning"></i>
                                        Aksi
                                    </h5>
                                    <hr class="w-100">
                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ route('admin.news.edit', $news) }}"
                                            class="btn btn-warning btn-lg text-white w-100">
                                            <i class="mdi mdi-pencil"></i> Edit Berita
                                        </a>

                                        <form action="{{ route('admin.news.destroy', $news) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-lg text-white w-100">
                                                <i class="mdi mdi-delete"></i> Hapus Berita
                                            </button>
                                        </form>

                                        <hr class="my-2 w-100">

                                        <a href="{{ route('admin.news.index') }}"
                                            class="btn btn-outline-info btn-lg w-100">
                                            <i class="mdi mdi-view-list"></i> Lihat Semua Berita
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Statistics Card --}}
                            <!-- <div class="card mt-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="mdi mdi-chart-line text-success"></i>
                                        Statistik
                                    </h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex flex-column align-items-center">
                                                <h4 class="mb-0 text-primary">-</h4>
                                                <small class="text-muted">Views</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex flex-column align-items-center">
                                                <h4 class="mb-0 text-success">-</h4>
                                                <small class="text-muted">Shares</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>