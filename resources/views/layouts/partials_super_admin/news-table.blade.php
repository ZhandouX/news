<div class="row flex-grow">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title card-title-dash"><i
                                class="mdi mdi-newspaper-variant-multiple-outline icon-smd"></i> Kelola Berita</h4>

                        {{-- LINE TITLE ANIMATION --}}
                        <div class="loading-animation-news-management mb-2">
                            <div class="news-management"></div>
                        </div>

                        <p class="card-subtitle card-subtitle-dash">
                            Total Berita : <span class="totals">{{ $news->total() }}</span>
                        </p>
                    </div>
                    <div>
                        <!-- NEWS BUTTON REKAP -->
                        <a href="#" class="btn btn-danger btn-lg text-white mb-0 me-0" data-bs-toggle="modal"
                            data-bs-target="#rekapModal">
                            <i class="mdi mdi-file-document"></i> Rekap Berita
                        </a>

                        <!-- REKAP MODAL -->
                        <div class="modal fade" id="rekapModal" tabindex="-1" aria-labelledby="rekapModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="rekapModalLabel"><i
                                                class="mdi mdi-newspaper-variant-multiple icon-sm"></i> ~ REKAP BERITA
                                        </h5>
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

                                                    {{-- SUB-DROPDOWN (MONTHLY) --}}
                                                    <a href="{{ route('super-admin.rekap.bulanan.kantor') }}"
                                                        class="btn btn-sm btn-outline-primary w-100 mb-2">
                                                        Unit Utama
                                                    </a>
                                                    <a href="{{ route('super-admin.rekap.bulanan.sumber') }}"
                                                        class="btn btn-sm btn-outline-primary w-100">
                                                        Kantor Sumber Berita
                                                    </a>
                                                    <a href="{{ route('super-admin.rekap.bulanan') }}"
                                                        class="btn btn-sm btn-outline-danger w-100">
                                                        Semua Berita / Bulan
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="list-group-item text-center bg-dark-grey">
                                                <a href="#"
                                                    class="btn btn-sm btn-warning text-white btn-lg fw-bold w-100 mb-2"
                                                    data-bs-toggle="collapse" data-bs-target="#rekapTahunan"><i
                                                        class="fa fa-calendar-o"></i> Rekap Tahunan
                                                </a>
                                                <div id="rekapTahunan" class="collapse mt-2">

                                                    {{-- SUB-DROPDOWN (YEARLY) --}}
                                                    <a href="{{ route('super-admin.rekap.tahunan.kantor') }}"
                                                        class="btn btn-sm btn-outline-primary w-100 mb-2">
                                                        Unit Utama
                                                    </a>
                                                    <a href="{{ route('super-admin.rekap.tahunan.sumber') }}"
                                                        class="btn btn-sm btn-outline-primary w-100">
                                                        Kantor Sumber Berita
                                                    </a>
                                                    <a href="{{ route('super-admin.rekap.tahunan') }}"
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

                <div class="table-responsive mt-1">
                    @php
                        $rowNumber = ($news->currentPage() - 1) * $news->perPage();
                    @endphp

                    @forelse($groupedPageNews as $month => $sumberGroup)
                        @php
                            // Mengubah key bulan menjadi format Y-m
                            $monthKey = \Carbon\Carbon::parse($month . '-01')->format('Y-m');

                            // Hitung total berita dalam bulan ini dari semua sumber
                            $totalBeritaBulan = collect($newsPerMonth[$monthKey] ?? [])->sum('count');
                        @endphp

                        <div class="card mb-3 border-dark">
                            <div class="card-header bg-dark text-white text-center">
                                <h5 class="mb-0">
                                    {{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}
                                    <span class="badge bg-warning text-dark ms-2">
                                        {{ $totalBeritaBulan }} Berita
                                    </span>
                                </h5>
                            </div>

                            <div class="card-body p-0">
                                <div class="accordion" id="accordionMonth-{{ $month }}">
                                    @foreach($sumberGroup as $sumber => $newsItems)
                                        @php
                                            $collapseId = 'collapse-' . $month . '-' . Str::slug($sumber);

                                            // Ambil total berita per sumber pada bulan ini
                                            $totalBySumber = collect($newsPerMonth[$monthKey] ?? [])->firstWhere('sumber', $sumber);
                                        @endphp

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-{{ $collapseId }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                                    aria-expanded="false" aria-controls="{{ $collapseId }}">
                                                    <div class="d-flex justify-content-between w-100">
                                                        <span><i class="mdi mdi-newspaper"></i>
                                                            {{ $sumber ?? 'Tidak Diketahui' }}</span>
                                                        <span class="badge bg-primary">
                                                            {{ $totalBySumber['count'] ?? 0 }} Berita
                                                        </span>
                                                    </div>
                                                </button>
                                            </h2>

                                            <div id="{{ $collapseId }}" class="accordion-collapse collapse"
                                                aria-labelledby="heading-{{ $collapseId }}"
                                                data-bs-parent="#accordionMonth-{{ $month }}">
                                                <div class="accordion-body p-0">
                                                    <table class="table table-striped mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Berita</th>
                                                                <th>Kantor Sumber</th>
                                                                <th>Unit Utama</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($newsItems as $item)
                                                                <tr>
                                                                    <td class="text-center">{{ ++$rowNumber }}</td>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            @if($item->cover_image)
                                                                                <img src="{{ Storage::url($item->cover_image) }}"
                                                                                    alt="cover" width="60" class="me-2 rounded">
                                                                            @else
                                                                                <span class="badge bg-secondary">Tidak ada foto</span>
                                                                            @endif
                                                                            <div>
                                                                                <h6>{{ Str::limit($item->title, 30) }}</h6>
                                                                                <p class="text-muted">
                                                                                    <span
                                                                                        class="badge badge-info">{{ $item->category }}</span>
                                                                                    {{ $item->formatted_news_date }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <h6>{{ $item->sumber }}</h6>
                                                                        <!-- <p class="text-muted">Created
                                                                        {{ Str::limit($item->formatted_created_at, 20) }}
                                                                    </p> -->
                                                                    </td>
                                                                    <td>{{ Str::limit($item->office, 20) }}</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button
                                                                                class="btn btn-warning dropdown-toggle toggle-dark btn-sm"
                                                                                type="button" data-bs-toggle="dropdown">
                                                                                Aksi
                                                                            </button>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('super-admin.news.show', $item) }}">
                                                                                    <i class="mdi mdi-eye"></i> Lihat
                                                                                </a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('super-admin.news.edit', $item) }}">
                                                                                    <i class="mdi mdi-pencil"></i> Edit
                                                                                </a>
                                                                                <form
                                                                                    action="{{ route('super-admin.news.destroy', $item) }}"
                                                                                    method="POST"
                                                                                    onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="dropdown-item text-danger">
                                                                                        <i class="mdi mdi-delete"></i> Hapus
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning text-center">Tidak ada data berita</div>
                    @endforelse
                </div>


                {{-- PAGINATION PERIODE --}}
                <div class="d-flex justify-content-center mt-3">
                    <ul class="pagination">
                        @for ($periode = 1; $periode <= $totalPeriods; $periode++)
                            @php
                                $periodeStart = Carbon\Carbon::create($startDate->year, ($periode - 1) * 6 + 1, 1);
                                $periodeEnd = (clone $periodeStart)->addMonths(5)->endOfMonth();
                            @endphp

                            <li class="page-item {{ $periode == $currentPage ? 'active' : '' }}">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['periode' => $periode]) }}">
                                    {{ $periodeStart->translatedFormat('M') }} - {{ $periodeEnd->translatedFormat('M Y') }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>