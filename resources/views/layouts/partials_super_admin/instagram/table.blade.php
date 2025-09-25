<div class="row flex-grow">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title card-title-dash">
                            <i class="mdi mdi-instagram icon-smd"> Kelola Konten Instagram</i>
                        </h4>

                        {{-- ANIMASI UNDERLINE TITLE --}}
                        <div class="instagram-create mb-2"></div>

                        <p class="card-subtitle card-subtitle-dash">
                            Total Konten : <span class="totals">{{ $instagrams->total() }}</span>
                        </p>
                    </div>

                    <div>
                        <a class="btn btn-primary btn-sm" href="{{ route('super-admin.instagram.create') }}">
                            <i class="mdi mdi-plus-circle-outline"></i> Tambah konten
                        </a>
                    </div>
                </div>

                {{-- TABEL INSTAGRAM --}}
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
                            @forelse($instagrams as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration + ($instagrams->currentPage() - 1) * $instagrams->perPage() }}
                                    </td>
                                    <td>
                                        <h6>{{ Str::limit($item->title, 40) }}</h6>
                                    </td>
                                    <td>
                                        <a href="{{ $item->link }}" target="_blank" class="text-info">
                                            {{ Str::limit($item->link, 50) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-outline-info">{{ $item->formatted_instagram_date }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $item->formatted_created }}</small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0"
                                                type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"> Aksi
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                <h6 class="dropdown-header">Aksi</h6>
                                                <a class="dropdown-item" href="{{ route('super-admin.instagram.show', $item) }}">Lihat</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('super-admin.instagram.edit', $item) }}">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('super-admin.instagram.destroy', $item) }}"
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
                                        <td colspan="6" class="text-center">Tidak ada konten Instagram</td>
                                    </tr>
                                @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- INFO ITEM --}}
                <div class="text-center text-muted mt-2">
                    Menampilkan {{ $instagrams->firstItem() ?? 0 }} - {{ $instagrams->lastItem() ?? 0 }} dari {{ $instagrams->total() }} konten
                </div>

                {{-- CUSTOM PAGINATION --}}
                <div class="d-flex justify-content-center mt-2">
                    {{ $instagrams->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>