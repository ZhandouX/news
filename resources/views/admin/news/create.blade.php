@extends('layouts.app_admin')

@section('title', 'Tambah Berita Baru')

@section('content')
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet"> -->

    @include('layouts.partials_admin.news-create')
@endsection

@push('scripts')
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // =========================
            // IMAGE PREVIEW + VALIDASI + DRAG & DROP
            // =========================
            const dropZone = document.getElementById('drop-zone');
            const coverInput = document.getElementById('cover_image');
            const previewImg = document.getElementById('preview-img');
            const previewClose = document.getElementById('preview-close');
            const placeholder = dropZone.querySelector('.drop-zone-placeholder');

            function validateFile(file) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxSize = 10 * 1024 * 1024; // 10MB

                if (!allowedTypes.includes(file.type)) {
                    alert('Hanya file JPG, PNG, atau GIF yang diperbolehkan!');
                    return false;
                }

                if (file.size > maxSize) {
                    alert('Ukuran file maksimal 10MB!');
                    return false;
                }

                return true;
            }

            function showPreview(file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('d-none');
                    previewClose.classList.remove('d-none');
                    dropZone.classList.add('has-preview');
                };
                reader.readAsDataURL(file);
            }

            function resetPreview() {
                previewImg.src = '';
                previewImg.classList.add('d-none');
                previewClose.classList.add('d-none');
                dropZone.classList.remove('has-preview');
                coverInput.value = '';
            }

            function handleFile(file) {
                if (validateFile(file)) {
                    showPreview(file);
                } else {
                    resetPreview();
                }
            }

            // EVENT: INPUT FILE CHANGE
            coverInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    handleFile(this.files[0]);
                } else {
                    resetPreview();
                }
            });

            // EVENT: DRAG & DROP
            dropZone.addEventListener('dragover', function (e) {
                e.preventDefault();
                dropZone.classList.add('dragover');
            });

            dropZone.addEventListener('dragleave', function () {
                dropZone.classList.remove('dragover');
            });

            dropZone.addEventListener('drop', function (e) {
                e.preventDefault();
                dropZone.classList.remove('dragover');

                if (e.dataTransfer.files.length > 0) {
                    const file = e.dataTransfer.files[0];
                    coverInput.files = e.dataTransfer.files; // sinkronkan ke input
                    handleFile(file);
                }
            });

            // EVENT: TOMBOL HAPUS
            previewClose.addEventListener('click', resetPreview);

            // =========================
            // AUTO RESIZE TEXTAREA
            // =========================
            const content = document.getElementById('content');
            if (content) {
                content.addEventListener('input', function () {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            }

            // =========================
            // TOGGLE INPUT OFFICE (OTHER/LAINNYA)
            // =========================
            const officeSelect = document.getElementById('office');
            const officeOtherGroup = document.getElementById('office-other-group');
            const officeOtherInput = document.getElementById('office_other');

            function toggleOfficeOther() {
                if (officeSelect.value === 'Other' || officeSelect.value === 'Lainnya') {
                    officeOtherGroup.classList.remove('hidden');
                    officeOtherInput.setAttribute('required', true);
                } else {
                    officeOtherGroup.classList.add('hidden');
                    officeOtherInput.removeAttribute('required');
                    officeOtherInput.value = '';
                }
            }

            if (officeSelect && officeOtherGroup) {
                toggleOfficeOther(); // jalankan saat page load
                officeSelect.addEventListener('change', toggleOfficeOther);
            }

            // =========================
            // TOGGLE INPUT SUMBER (OTHER/LAINNYA)
            // =========================
            const sumberSelect = document.getElementById('sumber');
            const sumberOtherGroup = document.getElementById('sumber-other-group');
            const sumberOtherInput = document.getElementById('sumber_other');

            function toggleSumberOther() {
                if (sumberSelect.value === 'Other' || sumberSelect.value === 'Lainnya') {
                    sumberOtherGroup.classList.remove('hidden');
                    sumberOtherInput.setAttribute('required', true);
                } else {
                    sumberOtherGroup.classList.add('hidden');
                    sumberOtherInput.removeAttribute('required');
                    sumberOtherInput.value = '';
                }
            }

            if (sumberSelect && sumberOtherGroup) {
                toggleSumberOther(); // jalankan saat page load
                sumberSelect.addEventListener('change', toggleSumberOther);
            }
        });
    </script>
@endpush