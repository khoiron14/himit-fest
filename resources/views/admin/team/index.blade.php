@extends('layouts.dashboard')

@push('title')
<h2>Daftar Tim</h2>
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
        <th>Email</th>
        <th>Nama Ketua</th>
        <th>Nama Tim</th>
        <th>Institusi</th>
        <th>Identitas</th>
        <th>Lomba</th>
        <th>Verifikasi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($profiles as $profile)
      <tr>
        <td>{{ $profile->email }}</td>
        <td>{{ $profile->leader_name }}</td>
        <td>{{ $profile->team_name }}</td>
        <td>{{ $profile->institution }}</td>
        <td>
          @if ($profile->identity_url != null)
              <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showIdentity">Lihat</button>
  
              <div class="modal fade" id="showIdentity" tabindex="-1" aria-labelledby="showIdentity" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="showIdentity">Foto KTM / Kartu Pelajar Ketua</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <img src="{{ $profile->identity_url }}" class="rounded mx-auto d-block" alt="Foto KTM / Kartu Pelajar Ketua" width="350">
                    </div>
                  </div>
                </div>
              </div>
          @endif
        </td>
        <td>{{ $profile->competition?->value ?? 'Belum Memilih' }}</td>
        <td>
          @if ($profile->type != null)
              @if ($profile->type == App\Enums\ProfileType::College)
                <span class="text-success">Mahasiswa</span>
              @else
                <span class="text-success">Siswa</span>
              @endif
          @else
          <div class="btn-group" role="group" aria-label="Verification">
            <a href="{{ route('team.verif.college', $profile) }}" class="btn btn-sm btn-primary" onclick="event.preventDefault(); document.getElementById('college-form').submit();">Mahasiswa</a>
            <a href="{{ route('team.verif.general', $profile) }}" class="btn btn-sm btn-secondary" onclick="event.preventDefault(); document.getElementById('general-form').submit();">Siswa</a>
          </div>
          <form id="college-form" action="{{ route('team.verif.college', $profile) }}" method="POST" class="d-none">
            @csrf
          </form>
          <form id="general-form" action="{{ route('team.verif.general', $profile) }}" method="POST" class="d-none">
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