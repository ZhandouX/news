<div class="row flex-grow">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title card-title-dash">
                            <i class="mdi mdi-youtube icon-smd"></i> Kelola Konten Youtube
                        </h4>

                        {{-- LOADING ANIMATION --}}
                        <div class="loading-animation-youtube-management mb-2"></div>

                        <p class="card-subtitle card-subtitle-dash">
                            Total Konten : <span class="totals">{{ $youtubes->total() }}</span>
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('super-admin.youtube.create') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus-circle-outline"></i> Tambah Konten
                        </a>
                    </div>
                </div>

                <!-- Tabel Youtube -->
                <div class="table-responsive mt-1">
                    <table class="table select-table table-bordered-vertical">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Konten</th>
                                <th>Link</th>
                                <th>Tanggal Konten</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($youtubes as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration + ($youtubes->currentPage() - 1) * $youtubes->perPage() }}
                                    </td>
                                    <td>
                                        <h6>{{ Str::limit($item->title, 40) }}</h6>
                                    </td>
                                    <td>
                                        <a href="{{ $item->link }}" target="_blank" class="text-primary">
                                            {{ Str::limit($item->link, 50) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->formatted_youtube_date }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $item->formatted_created }}</small>
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
                                                    href="{{ route('super-admin.youtube.show', $item) }}">Lihat</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                    href="{{ route('super-admin.youtube.edit', $item) }}">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('super-admin.youtube.destroy', $item) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus konten ini?')">
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
                                    <td colspan="6" class="text-center">Tidak ada data konten Youtube</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Info item -->
                <div class="text-center text-muted mt-2">
                    Menampilkan {{ $youtubes->firstItem() ?? 0 }} - {{ $youtubes->lastItem() ?? 0 }} dari
                    {{ $youtubes->total() }}
                    konten
                </div>

                <!-- Custom Pagination -->
                <div class="d-flex justify-content-center mt-2">
                    {{ $youtubes->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>