@extends('layouts.app_admin')

@section('title', 'Edit Berita')

@section('content')
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet"> -->

    @include('layouts.partials_admin.news-edit')
@endsection

@push('scripts')
    <script src="https://cdn.tailwindcss.com"></script>
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

            // Jika sudah ada gambar lama, tampilkan tombol close
            if (previewImg.src && previewImg.src.trim() !== '') {
                previewImg.style.display = 'block';
                previewClose.classList.remove('d-none');
                dropZone.classList.add('has-preview');
            }

            // Validasi file
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

            // Tampilkan preview
            function showPreview(file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                    previewClose.classList.remove('d-none');
                    dropZone.classList.add('has-preview');
                };
                reader.readAsDataURL(file);
            }

            // Reset preview
            function resetPreview() {
                previewImg.src = '';
                previewImg.style.display = 'none';
                previewClose.classList.add('d-none');
                dropZone.classList.remove('has-preview');
                coverInput.value = '';
            }

            // Event: Input file change
            coverInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    if (validateFile(file)) {
                        showPreview(file);
                    } else {
                        resetPreview();
                    }
                } else {
                    resetPreview();
                }
            });

            // Event: Drag & Drop
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
                    if (validateFile(file)) {
                        showPreview(file);
                    } else {
                        resetPreview();
                    }
                }
            });

            // Event: Tombol Close
            previewClose.addEventListener('click', resetPreview);

            const officeSelect = document.getElementById('office');
            const officeOtherGroup = document.getElementById('office-other-group');
            const officeOtherInput = document.getElementById('office_other');
            const sumberSelect = document.getElementById('sumber');
            const sumberOtherGroup = document.getElementById('sumber-other-group');
            const sumberOtherInput = document.getElementById('sumber_other');

            function toggleOfficeOther() {
                if (officeSelect.value === 'Other') {
                    officeOtherGroup.classList.remove('hidden');
                    officeOtherInput.setAttribute('required', true);
                } else {
                    officeOtherGroup.classList.add('hidden');
                    officeOtherInput.removeAttribute('required');
                    officeOtherInput.value = '';
                }
            }

            function toggleSumberOther() {
                if (sumberSelect.value === 'Other') {
                    sumberOtherGroup.classList.remove('hidden');
                    sumberOtherInput.setAttribute('required', true);
                } else {
                    sumberOtherGroup.classList.add('hidden');
                    sumberOtherInput.removeAttribute('required');
                    sumberOtherInput.value = '';
                }
            }

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

            toggleOfficeOther();
            toggleSumberOther();

            officeSelect.addEventListener('change', toggleOfficeOther);
            sumberSelect.addEventListener('change', toggleSumberOther);
        });
    </script>
    <script src="{{ asset('assets/js/ck-editor.js') }}"></script>
@endpush
