@extends('layouts.dashboard')

@push('title')
<h2>Profile</h2>
@endpush

@section('content')
@if ($announceMessage != null)
<div class="alert {{ $announceMessage['status'] == 'pass' ? 'alert-success' : 'alert-warning' }}" role="alert">
  {{ $announceMessage['message'] }}
</div>
@endif

<form action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="row mb-3">
    <div class="col-md-6">
      <label for="leader_name" class="col-form-label text-md-end">Nama Ketua</label>

      <input id="leader_name" type="text" class="form-control @error('leader_name') is-invalid @enderror"
        name="leader_name" value="{{ old('leader_name', $profile->leader_name ?? '') }}" required
        placeholder="Isi Nama Ketua">

      @error('leader_name')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="col-md-6">
      <label for="team_name" class="col-form-label text-md-end">Nama Tim</label>

      <input id="team_name" type="text" class="form-control @error('team_name') is-invalid @enderror" name="team_name"
        value="{{ old('team_name', $profile->team_name ?? '') }}" required placeholder="Isi Nama Tim">

      @error('team_name')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-6">
      <label for="institution" class="col-form-label text-md-end">Nama Kampus / Sekolah</label>

      <input id="institution" type="text" class="form-control @error('institution') is-invalid @enderror"
        name="institution" value="{{ old('institution', $profile->institution ?? '') }}" required
        placeholder="Isi Nama Kampus / Sekolah">

      @error('institution')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="col-md-6">
      <label for="identity" class="col-form-label text-md-end">
        <span>Foto KTM / Kartu Pelajar Ketua</span>
        @if ($profile?->identity)
        <a class="ms-2" data-bs-toggle="modal" data-bs-target="#showIdentity">Lihat</a>
        @endif
      </label>

      <input type="file" class="form-control @error('identity') is-invalid @enderror" id="identity" name="identity">

      @error('identity')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror

      @if ($profile?->identity)
      <div class="modal fade" id="showIdentity" tabindex="-1" aria-labelledby="showIdentity" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="showIdentity">Foto KTM / Kartu Pelajar Ketua</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <img src="{{ $profile->identity->url }}" class="rounded mx-auto d-block" alt="Foto KTM / Kartu Pelajar Ketua" width="350">
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-6">
      <div class="mb-2"><strong>Catatan :</strong> Anda harus melengkapi semua isian agar bisa diverifikasi oleh admin!
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
  </div>
</form>
@endsection