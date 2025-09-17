<div class="row flex-grow">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title card-title-dash"><i class="mdi mdi-newspaper-variant-multiple-outline icon-smd"></i> Kelola Berita</h4>

                        {{-- LOADING ANIMATION BAR --}}
                        <div class="loading-animation-news-management mb-2">
                            <div class="news-management"></div>
                        </div>

                        <p class="card-subtitle card-subtitle-dash">
                            Total Berita : <span class="totals">{{ $news->total() }}</span>
                        </p>
                    </div>
                    <div>
                        {{-- BUTTON REKAP --}}
                        <a href="#" class="btn btn-success btn-lg text-white mb-0 me-0" data-bs-toggle="modal"
                            data-bs-target="#rekapModal">
                            <i class="mdi mdi-file-document"></i> Rekap ~ Filter
                        </a>

                        {{-- MODAL REKAP --}}
                        <div class="modal fade" id="rekapModal" tabindex="-1" aria-labelledby="rekapModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rekapModalLabel">
                                            <i class="mdi mdi-newspaper-variant-multiple icon-sm"></i> ~ REKAP BERITA</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-dark-grey">
                                        <ul class="list-group">
                                            <li class="list-group-item text-center bg-dark-grey">
                                                <a href="#"
                                                    class="btn btn-sm btn-warning text-white btn-lg fw-bold w-100 mb-2"
                                                    data-bs-toggle="collapse" data-bs-target="#rekapBulanan"><i
                                                        class="fa fa-calendar"></i> Rekap Bulanan</a>
                                                <div id="rekapBulanan" class="collapse mt-2">
                                                    <a href="{{ route('admin.rekap.bulanan.kantor') }}"
                                                        class="btn btn-sm btn-outline-primary w-100 mb-2">
                                                        Unit Utama
                                                    </a>
                                                    <a href="{{ route('admin.rekap.bulanan.sumber') }}"
                                                        class="btn btn-sm btn-outline-primary w-100">
                                                        Kantor Sumber Berita
                                                    </a>
                                                    <a href="{{ route('admin.rekap.bulanan') }}"
                                                        class="btn btn-sm btn-outline-danger w-100">
                                                        Semua Berita / Bulan
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="list-group-item text-center bg-dark-grey">
                                                <a href="#"
                                                    class="btn btn-sm btn-warning text-white btn-lg fw-bold w-100 mb-2"
                                                    data-bs-toggle="collapse" data-bs-target="#rekapTahunan"><i
                                                        class="fa fa-calendar-o"></i> Rekap Tahunan</a>
                                                <div id="rekapTahunan" class="collapse mt-2">
                                                    <a href="{{ route('admin.rekap.tahunan.kantor') }}"
                                                        class="btn btn-sm btn-outline-primary w-100 mb-2">
                                                        Unit Utama
                                                    </a>
                                                    <a href="{{ route('admin.rekap.tahunan.sumber') }}"
                                                        class="btn btn-sm btn-outline-primary w-100">
                                                        Kantor Sumber Berita
                                                    </a>
                                                    <a href="{{ route('admin.rekap.tahunan') }}"
                                                        class="btn btn-sm btn-outline-danger w-100">
                                                        Semua Berita / Tahun
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Berita -->
                <div class="table-responsive mt-1">
                    <table class="table select-table table-bordered-vertical">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Berita</th>
                                <th>Kantor Sumber</th>
                                <th>Unit Utama</th>
                                <th>Progress/bulan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($news as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration + ($news->currentPage() - 1) * $news->perPage() }}
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @if($item->cover_image)
                                                <img src="{{ Storage::url($item->cover_image) }}" alt="" width="60"
                                                    class="me-2 rounded">
                                            @else
                                                <span class="badge bg-secondary">Tidak ada foto</span>
                                            @endif
                                            <div>
                                                <h6>{{ Str::limit($item->title, 30) }}</h6>
                                                <p class="text-muted"><span
                                                        class="badge badge-info">{{ $item->category }}</span>
                                                    {{ $item->formatted_news_date }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6>{{ $item->sumber }}</h6>
                                        <p class="text-muted">Created At {{ Str::limit($item->formatted_created_at, 10) }}
                                        </p>
                                    </td>
                                    <td>
                                        <h6>{{ Str::limit($item->office, 20) }}</h6>
                                    </td>
                                    <td>
                                        @php
                                            $monthKey = \Carbon\Carbon::parse($item->news_date)->format('Y-m');
                                            $monthData = $newsPerMonth[$monthKey] ?? null;
                                        @endphp

                                        @if ($monthData)
                                            <p>{{ $monthData['monthName'] }} : {{ $monthData['count'] }} Berita</p>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0"
                                                type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"> Aksi
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <h6 class="dropdown-header">Aksi</h6>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.news.show', $item) }}">Lihat</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.news.edit', $item) }}">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data berita</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Info item -->
                <div class="text-center text-muted mt-2">
                    Menampilkan {{ $news->firstItem() ?? 0 }} - {{ $news->lastItem() ?? 0 }} dari {{ $news->total() }}
                    berita
                </div>

                <!-- Custom Pagination -->
                <div class="d-flex justify-content-center mt-2">
                    {{ $news->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>