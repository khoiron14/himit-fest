@extends('layouts.dashboard')

@push('title')
<h2>Daftar Pembayaran</h2>
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

<div class="table-responsive">
  <table id="table" class="table table-striped">
    <thead>
      <tr>
        <th>No.</th>
        <th>Email</th>
        <th>Nama Ketua</th>
        <th>Nama Tim</th>
        <th>Nama Pembayar</th>
        <th>Bukti Pembayaran</th>
        <th>Waktu Upload</th>
        <th>Verifikasi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($payments as $payment)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $payment->profile->email }}</td>
        <td>{{ $payment->profile->leader_name }}</td>
        <td>{{ $payment->profile->team_name }}</td>
        <td>{{ $payment->name }}</td>
        <td>
          @if ($payment->file_url != null)
              <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showPayment-{{ $loop->iteration }}">Lihat</button>
  
              <div class="modal fade" id="showPayment-{{ $loop->iteration }}" tabindex="-1" aria-labelledby="showPayment-{{ $loop->iteration }}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="showPayment-{{ $loop->iteration }}">Bukti Pembayaran</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <img src="{{ $payment->file_url }}" class="rounded mx-auto d-block" alt="Bukti Pembayaran" width="350">
                    </div>
                  </div>
                </div>
              </div>
          @endif
        </td>
        <td>{{ $payment->file?->updated_at->format('d F Y H:s') }}</td>
        <td>
          @if ($payment->status != App\Enums\PaymentStatus::Pending)
              @if ($payment->status == App\Enums\PaymentStatus::Accept)
                <span class="text-success">Diterima</span>
              @else
                <span class="text-danger">Ditolak</span>
              @endif
          @else
          <div class="btn-group" role="group" aria-label="Verification">
            <a href="{{ route('admin.payment.accept', $payment) }}" class="btn btn-sm btn-success" onclick="event.preventDefault(); document.getElementById('accept-form').submit();">Terima</a>
            <a href="{{ route('admin.payment.reject', $payment) }}" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('reject-form').submit();">Tolak</a>
          </div>
          <form id="accept-form" action="{{ route('admin.payment.accept', $payment)}}" method="POST" class="d-none">
            @csrf
          </form>
          <form id="reject-form" action="{{ route('admin.payment.reject', $payment) }}" method="POST" class="d-none">
            @csrf
          </form>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection