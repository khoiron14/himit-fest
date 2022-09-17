@extends('layouts.dashboard')

@push('title')
<h2>Kompetisi</h2>
@endpush

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready( function () {
  $('#table').DataTable();
} );
</script>
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
<form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('submission.store', $profile) }}" method="POST" enctype="multipart/form-data">
  @csrf
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
<div class="table-responsive">
  <table id="table" class="table table-striped">
    <thead>
      <tr>
        <th>No.</th>
        <th>Tahap</th>
        <th>File</th>
        <th>Status</th>
        <th>Tanggal Upload</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($submissions as $submission)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          @switch($submission->step)
            @case(App\Enums\StepStatus::Step1)
              Tahap 1
              @break
            @case(App\Enums\StepStatus::Step2)
              Tahap 2
              @break
            @case(App\Enums\StepStatus::Step3)
              Tahap 3
              @break
          @endswitch
        </td>
        <td>
          <a class="btn btn-sm btn-primary" href="{{ $submission->file_url ?? '' }}" download>Download</a>
        </td>
        <td>{{ $submission->status }}</td>
        <td>{{ $submission->file->updated_at->format('d F Y H:s') }}</td>
        <td>
          @if ($profile->allow_upload && $profile->pending_submission && App\Models\Step::first()->status == $submission->step)
              <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showUpdate-{{ $loop->iteration }}">Ubah</button>

              <div class="modal fade" id="showUpdate-{{ $loop->iteration }}" tabindex="-1" aria-labelledby="showUpdate-{{ $loop->iteration }}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="showUpdate-{{ $loop->iteration }}">Ubah Berkas</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('submission.update', [$profile, $submission]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                    </div>
                  </div>
                </div>
              </div>
          @else
              Upload ditutup
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif
@endsection