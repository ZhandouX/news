{{-- GEAR BUBBLE --}}
<div class="gear-bubble-wrapper">
    <!-- ICON BUBBLE GEAR -->
    <div class="gear-bubble" id="gearBubble">
        <i class="fa fa-gear icon-xl spinner-border"></i>
    </div>

    <!-- POPUP CARD -->
    <div class="gear-popup shadow" id="gearPopup">
        <div class="popup-header text-center">
            <p class="mb-1 fw-bold">ACTIONS</p>
            <button type="button" class="btn-close text-danger" id="closeGearPopup" aria-label="Close"></button>
        </div>

        <div class="popup-body">
            {{-- THEME SWITCHER --}}
            <div class="popup-item d-flex align-items-center justify-content-between">
                <span class="popup-label"><i class="fa fa-leaf text-primary me-2"></i>Pilih Tema</span>
                <div class="theme-options d-flex align-items-center gap-2">
                    <!-- DARK -->
                    <button type="button" class="theme-btn dark-btn" title="Dark Mode"
                        onclick="window.themeManager.setTheme('dark')"></button>
                        
                    <!-- LIGHT -->
                    <button type="button" class="theme-btn light-btn" title="Light Mode"
                        onclick="window.themeManager.setTheme('light')"></button>

                    <!-- GRADIENT -->
                    <button type="button" class="theme-btn gradient-btn" title="Gradient Mode"
                        onclick="window.themeManager.setTheme('gradient')"></button>

                    <!-- PURPLE -->
                    <!-- <button type="button" class="theme-btn purple-btn" title="Purple Mode"
                        onclick="window.themeManager.setTheme('purple')"></button> -->
                </div>
            </div>

            {{-- TAMBAH BERITA --}}
            <a href="{{ route('super-admin.news.create') }}" class="popup-item d-flex align-items-center">
                <span class="popup-label"><i class="fa fa-plus text-primary me-2"></i>Tambah Berita</span>
            </a>

            {{-- REKAP BERITA --}}
            <a href="#" class="popup-item d-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#navrekapModal">
                <span class="popup-label"><i class="fa fa-file-pdf-o text-primary me-2"></i>Rekap Berita</span>
            </a>

            {{-- LIHAT BERITA --}}
            <a href="{{ route('super-admin.news.index') }}" class="popup-item d-flex align-items-center">
                <span class="popup-label"><i class="fa fa-list text-primary me-2"></i>Lihat Berita</span>
            </a>
        </div>
    </div>
</div>

{{-- MODAL REKAP BERITA --}}
<div class="modal fade" id="navrekapModal" tabindex="-1" aria-labelledby="navrekapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="navrekapModalLabel">
                    <i class="mdi mdi-newspaper-variant-multiple icon-sm"></i><strong> ~ REKAP BERITA</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark-grey">
                <ul class="list-group">
                    <li class="list-group-item text-center bg-dark-grey">
                        <a href="#" class="btn btn-sm btn-warning text-white btn-lg fw-bold w-100 mb-2"
                            data-bs-toggle="collapse" data-bs-target="#rekapBulanan"><i class="fa fa-calendar"></i>
                            Rekap Bulanan</a>
                        <div id="rekapBulanan" class="collapse mt-2">
                            <a href="{{ route('super-admin.rekap.bulanan.kantor') }}"
                                class="btn btn-sm btn-outline-primary w-100 mb-2">
                                Unit Utama
                            </a>
                            <a href="{{ route('super-admin.rekap.bulanan.sumber') }}"
                                class="btn btn-sm btn-outline-primary w-100 mb-2">
                                Kantor Sumber Berita
                            </a>
                            <a href="{{ route('super-admin.rekap.bulanan') }}"
                                class="btn btn-sm btn-outline-danger w-100">
                                Semua Berita / Bulan
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item text-center bg-dark-grey">
                        <a href="#" class="btn btn-sm btn-warning text-white btn-lg fw-bold w-100 mb-2"
                            data-bs-toggle="collapse" data-bs-target="#rekapTahunan"><i class="fa fa-calendar-o"></i>
                            Rekap Tahunan</a>
                        <div id="rekapTahunan" class="collapse mt-2">
                            <a href="{{ route('super-admin.rekap.tahunan.kantor') }}"
                                class="btn btn-sm btn-outline-primary w-100 mb-2">
                                Unit Utama
                            </a>
                            <a href="{{ route('super-admin.rekap.tahunan.sumber') }}"
                                class="btn btn-sm btn-outline-primary w-100 mb-2">
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

<!-- JS SPINNER ACTIONS -->
<script>
    const gearBubble = document.getElementById('gearBubble');
    const gearPopup = document.getElementById('gearPopup');
    const closeBtn = document.getElementById('closeGearPopup');

    // Toggle popup
    gearBubble.addEventListener('click', () => {
        gearPopup.style.display = gearPopup.style.display === 'flex' ? 'none' : 'flex';
    });

    // Close popup
    closeBtn.addEventListener('click', () => {
        gearPopup.style.display = 'none';
    });

    // Tutup popup kalau klik di luar
    document.addEventListener('click', function (event) {
        if (!gearPopup.contains(event.target) && !gearBubble.contains(event.target)) {
            gearPopup.style.display = 'none';
        }
    });
</script>