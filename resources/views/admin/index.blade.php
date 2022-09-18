@extends('layouts.dashboard')

@push('title')
<h2>Dashboard</h2>
@endpush

@section('content')

<form class="row row-cols-lg-auto g-3 align-items-center mb-3" action="{{ route('dashboard.change_step') }}" method="POST"
  onSubmit="return confirm('Apakah anda yakin?')">
  @csrf
  <div class="col-12">
    <select class="form-select @error('step') is-invalid @enderror" aria-label="Pilih Tahap" name="step">
      <option value="{{ App\Enums\StepStatus::Step1->value }}" @selected($step->status ==
        App\Enums\StepStatus::Step1)>Tahap 1</option>
      <option value="{{ App\Enums\StepStatus::Step2->value }}" @selected($step->status ==
        App\Enums\StepStatus::Step2)>Tahap 2</option>
      <option value="{{ App\Enums\StepStatus::Step3->value }}" @selected($step->status ==
        App\Enums\StepStatus::Step3)>Tahap 3</option>
      <option value="{{ App\Enums\StepStatus::End->value }}" @selected($step->status ==
        App\Enums\StepStatus::End)>Selesai</option>
    </select>
    @error('step')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>

  @if (!($step->status == App\Enums\StepStatus::End))
  <div class="col-12">
    <strong>Catatan : </strong> Harap umumkan peserta lolos sebelum mengganti tahap.
  </div>
  @endif
</form>

@if (!($step->status == App\Enums\StepStatus::End))
<a href="{{ route('admin.announce') }}" class="btn btn-secondary" onclick="
  event.preventDefault(); 
  if (!confirm('Apakah anda yakin?')) {return false};
  document.getElementById('announce-form').submit();">
  Umumkan Peserta Lolos
  @switch($step->status)
    @case(App\Enums\StepStatus::Step1)
      Tahap 1
      @break
    @case(App\Enums\StepStatus::Step2)
      Tahap 2
      @break
    @case(App\Enums\StepStatus::Step2)
      Tahap 3
      @break
  @endswitch
</a>

<form id="announce-form" action="{{ route('admin.announce') }}" method="POST" class="d-none">
  @csrf
</form>

<div class="mt-2">
  <strong>Catatan : </strong> Pengumuman akan benar-benar diumumkan ke peserta ketika tahap sudah diganti ke tahap berikutnya.
</div>
@endif

@endsection