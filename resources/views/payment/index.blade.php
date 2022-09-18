@extends('layouts.dashboard')

@push('title')
<h2>Pembayaran</h2>
@endpush

@section('content')
<div class="alert alert-info" role="alert">
  @if (($payment != null) && ($payment?->file_url != null))
    @switch($payment->status)
      @case(App\Enums\PaymentStatus::Pending)
        Silahkan tunggu pembayaran diverifikasi oleh admin. @break
      @case(App\Enums\PaymentStatus::Accept)
        Pembayaran diterima oleh admin. @break
      @case(App\Enums\PaymentStatus::Reject)
        Pembayaran ditolak oleh admin. @break
    @endswitch
  @else
    Silahkan lakukan pembayaran untuk lanjut ke tahap berikutnya.
  @endif
</div>

<form action="{{ route('payment.store') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="row mb-3">
    <div class="col-md-6">
      <label for="name" class="col-form-label text-md-end">Nama Pembayar</label>

      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
        name="name" value="{{ old('name', $payment->name ?? '') }}" required
        placeholder="Isi Nama Pembayar">

      @error('name')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="col-md-6">
      <label for="file" class="col-form-label text-md-end">
        <span>Foto Bukti Pembayaran</span>
        @if ($payment?->file_url)
        <a class="ms-2" data-bs-toggle="modal" data-bs-target="#showPayment">Lihat</a>
        @endif
      </label>

      <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".jpg,.jpeg,.png">

      @error('file')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror

      @if ($payment?->file_url)
      <div class="modal fade" id="showPayment" tabindex="-1" aria-labelledby="showPayment" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="showPayment">Foto Bukti Pembayaran</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <img src="{{ $payment->file_url }}" class="rounded mx-auto d-block" alt="Foto Bukti Pembayaran" width="350">
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