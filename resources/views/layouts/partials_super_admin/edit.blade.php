<div class="col-lg-12 dark-theme news-create-card">
    <div class="rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-2xl font-bold text-gray-800">Edit Berita</h4>
            <a href="{{ route('super-admin.news.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md shadow hover:bg-red-700 transition">
                <i class="mdi mdi-arrow-left-bold mr-2"></i> Batal
            </a>
        </div>

        <form action="{{ route('super-admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6 form-news-create-card">
            @csrf
            @method('PUT')

            <div class="md:flex md:space-x-6">
                {{-- LEFT COLUMN --}}
                <div class="md:w-2/3 space-y-4">

                    {{-- CATEGORY --}}
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700">Kategori Berita <span class="text-red-500">*</span></label>
                        <select name="category" id="category" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm @error('category') border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category', $news->category) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- UNIT UTAMA --}}
                    <div>
                        <label for="office" class="block text-sm font-semibold text-gray-700">Unit Utama <span class="text-red-500">*</span></label>
                        <select id="office" name="office" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm @error('office') border-red-500 @enderror" required>
                            <option value="">Pilih Unit Utama</option>
                            @foreach($offices as $office)
                                <option value="{{ $office }}" {{ old('office', $news->office) == $office ? 'selected' : '' }}>
                                    {{ $office }}
                                </option>
                            @endforeach
                        </select>
                        @error('office')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        {{-- UNIT UTAMA "Other" --}}
                        <div id="office-other-group" class="{{ old('office', $news->office) == 'Other' ? '' : 'hidden' }}">
                            <label for="office_other" class="block text-sm font-semibold text-gray-700 mt-2">Unit Utama Lainnya</label>
                            <input type="text" id="office_other" name="office_other" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm @error('office_other') border-red-500 @enderror" value="{{ old('office_other', $officeOther ?? '') }}">
                            @error('office_other')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- NEWS TITLE --}}
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700">Judul Berita <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm @error('title') border-red-500 @enderror" value="{{ old('title', $news->title) }}" required>
                        @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NEWS TEXT --}}
                    <div>
                        <label for="content" class="block text-sm font-semibold text-gray-700">Isi Berita</label>
                        <textarea id="content" name="content" rows="12" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm @error('content') border-red-500 @enderror">{{ old('content', $news->content) }}</textarea>
                        @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="md:w-1/3 space-y-4">

                    {{-- SCREENSHOT IMAGE --}}
                    <div>
                        <label for="cover_image" class="block text-sm font-semibold text-gray-700">Screenshot Berita</label>
                        @if($news->cover_image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($news->cover_image) }}" alt="Current Cover" class="rounded-lg shadow-sm w-full object-contain">
                                <small class="text-gray-500">Foto sampul saat ini</small>
                            </div>
                        @endif
                        <input type="file" id="cover_image" name="cover_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('cover_image') border-red-500 @enderror" accept="image/*">
                        @error('cover_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-400 text-xs mt-1">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                    </div>

                    {{-- NEWS DATE --}}
                    <div>
                        <label for="news_date" class="block text-sm font-semibold text-gray-700">Tanggal Berita <span class="text-red-500">*</span></label>
                        <input type="date" id="news_date" name="news_date" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm @error('news_date') border-red-500 @enderror" value="{{ old('news_date', \Carbon\Carbon::parse($news->news_date)->format('Y-m-d')) }}" required>
                        @error('news_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NEWS SUMBER --}}
                    <div>
                        <label for="sumber" class="block text-sm font-semibold text-gray-700">Sumber Berita <span class="text-red-500">*</span></label>
                        <select id="sumber" name="sumber" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm @error('sumber') border-red-500 @enderror" required>
                            <option value="">Pilih Sumber Berita</option>
                            @foreach($sumbers as $sumber)
                                <option value="{{ $sumber }}" {{ old('sumber', $news->sumber) == $sumber ? 'selected' : '' }}>
                                    {{ $sumber }}
                                </option>
                            @endforeach
                        </select>
                        @error('sumber')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        {{-- SUMBER "Other" --}}
                        <div id="sumber-other-group" class="{{ old('sumber', $news->sumber) == 'Other' ? '' : 'hidden' }}">
                            <label for="sumber_other" class="block text-sm font-semibold text-gray-700 mt-2">Sumber Lainnya</label>
                            <input type="text" id="sumber_other" name="sumber_other" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm @error('sumber_other') border-red-500 @enderror" value="{{ old('sumber_other', $sumberOther ?? '') }}">
                            @error('sumber_other')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- NEWS LINK --}}
                    <div>
                        <label for="link_berita" class="block text-sm font-semibold text-gray-700">Link Berita</label>
                        <input type="url" id="link_berita" name="link_berita" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm @error('link_berita') border-red-500 @enderror" value="{{ old('link_berita', $news->link_berita) }}" placeholder="https://...">
                        @error('link_berita')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SUBMIT NEWS UPDATE --}}
                    <div class="flex flex-col space-y-2">
                        <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-600 transition">
                            <i class="mdi mdi-content-save mr-2"></i> Update Berita
                        </button>
                        <a href="{{ route('super-admin.news.show', $news) }}" class="w-full px-4 py-2 border border-blue-500 text-blue-600 font-semibold rounded-lg shadow-sm hover:bg-blue-50 transition text-center">
                            <i class="mdi mdi-eye mr-2"></i> Lihat Berita
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- CSS --}}

<link rel="stylesheet" href="{{ asset('assets/css/news-create.css') }}">