@extends('layouts.dashboard')

@push('title')
<h2>Dashboard</h2>
@endpush

@section('content')

<form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('dashboard.change_step') }}" method="POST" onSubmit="return confirm('Apakah anda yakin?')">
  @csrf
  <div class="col-12">
    <select class="form-select @error('step') is-invalid @enderror" aria-label="Pilih Tahap" name="step">
      <option value="{{ App\Enums\StepStatus::Step1->value }}" @selected($step->status == App\Enums\StepStatus::Step1)>Tahap 1</option>
      <option value="{{ App\Enums\StepStatus::Step2->value }}" @selected($step->status == App\Enums\StepStatus::Step2)>Tahap 2</option>
      <option value="{{ App\Enums\StepStatus::Step3->value }}" @selected($step->status == App\Enums\StepStatus::Step3)>Tahap 3</option>
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
</form>
@endsection