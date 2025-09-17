<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex justify-content-between align-items-start">
                <div>
                    <h4 class="card-title card-title-dash"><i class="mdi mdi-table-cog icon-smd"></i> Rekap Berita / Bulan</h4>
                    <p class="card-subtitle card-subtitle-dash">Total Berita : <span class="totals">{{ $news->total() }}</span></p>
                </div>
                <div>
                    {{-- BUTTON NEWS REKAP ~ FILTER --}}
                    <a href="#" class="btn btn-success text-white fw-bold btn-lg me-0" data-bs-toggle="modal"
                        data-bs-target="#rekapModal">
                        <i class="mdi mdi-file-document"></i> Rekap ~ Filter
                    </a>

                    {{-- MODAL NEWS REKAP --}}
                    <div class="modal fade" id="rekapModal" tabindex="-1" aria-labelledby="rekapModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="rekapModalLabel">
                                        <i class="mdi mdi-newspaper-variant-multiple icon-sm"></i> ~ REKAP BERITA
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body bg-dark-grey">
                                    <ul class="list-group">
                                        <li class="list-group-item text-center bg-dark-grey">
                                            <a href="#" class="btn btn-sm btn-warning text-white btn-lg fw-bold w-100 mb-2" data-bs-toggle="collapse"
                                                data-bs-target="#rekapBulanan">
                                                <i class="fa fa-calendar"></i> Rekap Bulanan
                                            </a>
                                            <div id="rekapBulanan" class="collapse mt-2">
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
                                            <a href="#" class="btn btn-sm btn-warning text-white btn-lg fw-bold w-100 mb-2" data-bs-toggle="collapse"
                                                data-bs-target="#rekapTahunan">
                                                <i class="fa fa-calendar-o"></i> Rekap Tahunan
                                            </a>
                                            <div id="rekapTahunan" class="collapse mt-2">
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

            {{-- TABLE REPORT (MONTHLY) --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Jumlah Berita</th>
                            <th>Berita Terbaru</th>
                            <th>Rekap Berita</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newsPerMonth as $monthKey => $data)
                            @php
                                // Parse bulan & tahun sekali saja
                                $dateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $monthKey . '-01');
                                $monthName = $dateObj->translatedFormat('F');
                                $year = $dateObj->year;
                                $month = $dateObj->format('m');
                                // Ambil berita terbaru di bulan tsb
                                $latestNewsDate = \App\Models\News::whereMonth('news_date', $month)
                                    ->whereYear('news_date', $year)
                                    ->latest('news_date')
                                    ->value('news_date');
                            @endphp
                            <tr>
                                <td class="py-1">{{ $monthName }}</td>
                                <td>{{ $year }}</td>
                                <td>{{ $data['count'] }}</td>
                                <td>
                                    {{ $latestNewsDate ? \Carbon\Carbon::parse($latestNewsDate)->translatedFormat('d F Y') : '-' }}
                                </td>
                                <!-- <td>
                                    <div class="progress">
                                        <div class="progress-bar 
                                            @if($data['progress'] >= 75) bg-success
                                            @elseif($data['progress'] >= 40) bg-warning
                                            @else bg-danger
                                            @endif"
                                            role="progressbar" style="width: {{ $data['progress'] }}%"
                                            aria-valuenow="{{ $data['progress'] }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </td> -->
                                <td>
                                    <a href="{{ route('super-admin.news.monthly-report-pdf', [
                                            'year' => $year,
                                            'month' => $month
                                        ]) }}" class="btn btn-outline-danger btn-lg mb-0 me-0" alt="Bulan Ini">
                                        <i class="mdi mdi-file-pdf-box"></i> Export PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>