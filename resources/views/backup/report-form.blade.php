@extends('layouts.super_admin')

@section('title', 'Rekap Berita Bulanan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rekap Berita Bulanan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.news.generate-report') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="month">Bulan <span class="text-danger">*</span></label>
                            <select class="form-control @error('month') is-invalid @enderror" 
                                    id="month" name="month" required>
                                <option value="">Pilih Bulan</option>
                                <option value="1" {{ old('month') == '1' ? 'selected' : '' }}>Januari</option>
                                <option value="2" {{ old('month') == '2' ? 'selected' : '' }}>Februari</option>
                                <option value="3" {{ old('month') == '3' ? 'selected' : '' }}>Maret</option>
                                <option value="4" {{ old('month') == '4' ? 'selected' : '' }}>April</option>
                                <option value="5" {{ old('month') == '5' ? 'selected' : '' }}>Mei</option>
                                <option value="6" {{ old('month') == '6' ? 'selected' : '' }}>Juni</option>
                                <option value="7" {{ old('month') == '7' ? 'selected' : '' }}>Juli</option>
                                <option value="8" {{ old('month') == '8' ? 'selected' : '' }}>Agustus</option>
                                <option value="9" {{ old('month') == '9' ? 'selected' : '' }}>September</option>
                                <option value="10" {{ old('month') == '10' ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ old('month') == '11' ? 'selected' : '' }}>November</option>
                                <option value="12" {{ old('month') == '12' ? 'selected' : '' }}>Desember</option>
                            </select>
                            @error('month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="year">Tahun <span class="text-danger">*</span></label>
                            <select class="form-control @error('year') is-invalid @enderror" 
                                    id="year" name="year" required>
                                <option value="">Pilih Tahun</option>
                                @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ old('year', date('Y')) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-chart-bar"></i> Buat Rekap Berita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Set default month to current month if not set
        if (!$('#month').val()) {
            $('#month').val({{ date('n') }});
        }
    });
</script>
@endpush