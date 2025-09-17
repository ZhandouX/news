{{-- resources/views/layouts/partials_user/search-news.blade.php --}}
<div class="news-search-container">
    <form id="newsSearchForm" method="GET" action="{{ route('news.index') }}" class="space-y-2">
        {{-- Compact search bar utama --}}
        <div class="flex flex-wrap items-center gap-2 rounded-lg px-2 py-1 news-search-form">
            <i class="fas fa-search text-gray-500"></i>
            <input 
                type="text" 
                id="search" 
                name="search" 
                placeholder="Cari berita..." 
                value="{{ request('search') }}" 
                class="search-input text-sm flex-1 min-w-[150px]"
            >
            
            {{-- Tombol submit --}}
            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                <i class="fas fa-search"></i>
            </button>
            
            {{-- Reset / refresh --}}
            <a href="{{ route('news.index') }}" class="bg-gray-300 px-3 py-1 rounded-lg text-sm">
                <i class="fas fa-sync-alt"></i>
            </a>

            {{-- Toggle filter lanjutan --}}
            <button type="button" 
                    id="toggleFilters" 
                    class="text-blue-600 text-sm flex items-center focus:outline-none ml-auto">
                <i class="fas fa-filter mr-1"></i> Filter Lanjutan
            </button>
        </div>

        {{-- Collapsible filter lanjutan --}}
        <div id="advancedFilters" class="hidden grid grid-cols-1 md:grid-cols-3 gap-2 mt-2">
            {{-- Dropdown Kategori --}}
            <select id="category" name="category" class="border rounded-lg text-sm px-2 py-1">
                <option value="">Kategori</option>
                <option value="Politik" {{ request('category') == 'Politik' ? 'selected' : '' }}>Politik</option>
                <option value="Ekonomi & Bisnis" {{ request('category') == 'Ekonomi & Bisnis' ? 'selected' : '' }}>Ekonomi & Bisnis</option>
                <option value="Hukum & Kriminal" {{ request('category') == 'Hukum & Kriminal' ? 'selected' : '' }}>Hukum & Kriminal</option>
                <option value="Olahraga" {{ request('category') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                <option value="Teknologi" {{ request('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                <option value="Hiburan" {{ request('category') == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                <option value="Pendidikan" {{ request('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                <option value="Kesehatan" {{ request('category') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                <option value="Lingkungan" {{ request('category') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                <option value="Internasional" {{ request('category') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                <option value="Gaya Hidup" {{ request('category') == 'Gaya Hidup' ? 'selected' : '' }}>Gaya Hidup</option>
                <option value="Opini & Editorial" {{ request('category') == 'Opini & Editorial' ? 'selected' : '' }}>Opini & Editorial</option>
            </select>

            {{-- Dropdown Tahun --}}
            <select id="year" name="year" class="border rounded-lg text-sm px-2 py-1">
                <option value="">Tahun</option>
                @for($y = date('Y'); $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            {{-- Dropdown Bulan --}}
            <select id="month" name="month" class="border rounded-lg text-sm px-2 py-1">
                <option value="">Bulan</option>
                <option value="01" {{ request('month') == '01' ? 'selected' : '' }}>Jan</option>
                <option value="02" {{ request('month') == '02' ? 'selected' : '' }}>Feb</option>
                <option value="03" {{ request('month') == '03' ? 'selected' : '' }}>Mar</option>
                <option value="04" {{ request('month') == '04' ? 'selected' : '' }}>Apr</option>
                <option value="05" {{ request('month') == '05' ? 'selected' : '' }}>Mei</option>
                <option value="06" {{ request('month') == '06' ? 'selected' : '' }}>Jun</option>
                <option value="07" {{ request('month') == '07' ? 'selected' : '' }}>Jul</option>
                <option value="08" {{ request('month') == '08' ? 'selected' : '' }}>Agu</option>
                <option value="09" {{ request('month') == '09' ? 'selected' : '' }}>Sep</option>
                <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Okt</option>
                <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>Nov</option>
                <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Des</option>
            </select>
        </div>
    </form>

    {{-- Filter aktif tampil di bawah --}}
    @if(request()->hasAny(['search', 'category', 'year', 'month']))
        <div class="mt-2 text-sm">
            <span class="font-semibold">Filter Aktif:</span>
            @if(request('search'))
                <span class="bg-gray-200 px-2 py-1 rounded ml-1">
                    "{{ request('search') }}"
                    <a href="{{ request()->url() . '?' . http_build_query(request()->except('search')) }}" class="ml-1 text-red-500">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
            @if(request('category'))
                <span class="bg-gray-200 px-2 py-1 rounded ml-1">
                    {{ request('category') }}
                    <a href="{{ request()->url() . '?' . http_build_query(request()->except('category')) }}" class="ml-1 text-red-500">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
            @if(request('year'))
                <span class="bg-gray-200 px-2 py-1 rounded ml-1">
                    {{ request('year') }}
                    <a href="{{ request()->url() . '?' . http_build_query(request()->except('year')) }}" class="ml-1 text-red-500">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
            @if(request('month'))
                <span class="bg-gray-200 px-2 py-1 rounded ml-1">
                    {{ date('F', mktime(0, 0, 0, request('month'), 1)) }}
                    <a href="{{ request()->url() . '?' . http_build_query(request()->except('month')) }}" class="ml-1 text-red-500">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
        </div>
    @endif
</div>

{{-- Script toggle filter --}}
<script>
    document.getElementById('toggleFilters').addEventListener('click', function () {
        const filters = document.getElementById('advancedFilters');
        filters.classList.toggle('hidden');
    });
</script>
