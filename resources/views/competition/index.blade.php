@extends('layouts.dashboard')

@push('title')
<h2>Kompetisi</h2>
@endpush

@section('content')
@if ($profile == null || $profile->type == null)
<div class="alert alert-danger" role="alert">
  Akun anda belum diverifikasi oleh admin. Mohon tunggu...
</div>
@elseif ($profile->type == \App\Enums\ProfileType::College && $profile->competition == null)
<h5>Pilih Lomba</h5>
<form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('competition.add', $profile) }}" method="POST">
  @csrf
  <div class="col-12">
    <select class="form-select @error('competition') is-invalid @enderror" aria-label="Pilih Lomba" name="competition">
      <option value="{{ App\Enums\CompetitionType::BTIK->value }}">Bisnis TIK</option>
      <option value="{{ App\Enums\CompetitionType::WebDesign->value }}">Web Design</option>
    </select>
    @error('competition')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Pilih</button>
  </div>
</form>
@else
<div class="mb-3">
  Bidang Lomba : 
  @switch($profile->competition)
      @case(App\Enums\CompetitionType::WebDesign)
        <strong>Web Design</strong>
        @break
      @case(App\Enums\CompetitionType::BTIK)
        <strong>Bisnis TIK</strong>
        @break
      @case(App\Enums\CompetitionType::UIUX)
        <strong>UIUX</strong>
        @break
  @endswitch
</div>

@if ($profile->allow_upload && !$profile->pending_submission)
<form class="row row-cols-lg-auto g-3 align-items-center">
  <div class="col-12">
    <label for="submission" class="col-form-label text-md-end">
      Pengumpulan Berkas (zip/rar)
    </label>
  </div>

  <div class="col-12">
    <input type="file" class="form-control @error('submission') is-invalid @enderror" id="submission" name="submission" accept=".zip,.rar">

    @error('submission')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
@endif

@endif
@endsection