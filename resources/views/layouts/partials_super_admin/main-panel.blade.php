<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview"
                                role="tab" aria-controls="overview" aria-selected="true">
                                Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#beritaPerMinggu" role="tab"
                                aria-selected="false">
                                Minggu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#beritaPerBulan" role="tab"
                                aria-selected="false">
                                Bulan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#beritaPerTahun"
                                role="tab" aria-selected="false">
                                Tahun
                            </a>
                        </li>
                        <!-- <li class="nav-item d-none d-lg-block">
                            <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                                <span class="input-group-addon input-group-prepend border-right">
                                    <span class="icon-calendar input-group-text calendar-icon"></span>
                                </span>
                                <input type="text" class="form-control">
                            </div>
                        </li> -->
                    </ul>
                    <div>
                        <div class="btn-wrapper">
                            <!-- <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                Share
                            </a> -->
                            <a href="#" class="btn btn-outline-light text-white"><i class="icon-printer"></i>
                                Print
                            </a>
                            <a href="{{ route('super-admin.news.create') }}" class="btn btn-primary text-white me-0">
                                <i class="icon-plus"></i>
                                Tambah Berita
                            </a>
                        </div>
                    </div>
                </div>

                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>