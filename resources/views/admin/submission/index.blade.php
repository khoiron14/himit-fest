@extends('layouts.dashboard')

@push('title')
<h2>
  Pengumpulan
  
  @switch(request()->competitionType)
      @case(App\Enums\CompetitionType::WebDesign)
        Web Design @break
      @case(App\Enums\CompetitionType::BTIK)
        Bisnis TIK @break
      @case(App\Enums\CompetitionType::UIUX)
        UIUX @break
  @endswitch
</h2>
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

<div class="btn-group" role="group" aria-label="Toggle Step">
  <a href="{{ route('admin.submission.index', [request()->competitionType, App\Enums\StepStatus::Step1]) }}" 
    class="btn {{ request()->stepStatus == App\Enums\StepStatus::Step1 ? 'btn-primary' : 'btn-outline-primary' }}">
    Tahap 1
  </a>
  <a href="{{ route('admin.submission.index', [request()->competitionType, App\Enums\StepStatus::Step2]) }}" 
    class="btn {{ request()->stepStatus == App\Enums\StepStatus::Step2 ? 'btn-primary' : 'btn-outline-primary' }}">
    Tahap 2
  </a>
  <a href="{{ route('admin.submission.index', [request()->competitionType, App\Enums\StepStatus::Step3]) }}" 
    class="btn {{ request()->stepStatus == App\Enums\StepStatus::Step3 ? 'btn-primary' : 'btn-outline-primary' }}">
    Tahap 3
  </a>
</div>

<div class="table-responsive mt-3">
  <table id="table" class="table table-striped">
    <thead>
      <tr>
        <th>No.</th>
        <th>Email</th>
        <th>Nama Ketua</th>
        <th>Nama Tim</th>
        <th>Status</th>
        <th>Waktu Upload</th>
        <th>File</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($submissions as $submission)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $submission->profile->email }}</td>
        <td>{{ $submission->profile->leader_name }}</td>
        <td>{{ $submission->profile->team_name }}</td>
        <td>{{ $submission->status->value }}</td>
        <td>{{ $submission->file->updated_at->format('d F Y H:s') }}</td>
        <td><a class="btn btn-sm btn-primary" href="{{ $submission->file_url ?? '' }}" download>Download</a></td>
        <td>
          @if ((request()->stepStatus == App\Models\Step::first()->status) && ($submission->status == App\Enums\SubmissionStatus::Pending))
          <div class="btn-group" role="group" aria-label="Toggle Step">
            <a href="{{ route('admin.submission.pass', $submission) }}" 
              class="btn btn-sm btn-success" onclick="
                event.preventDefault(); 
                if (!confirm('Apakah anda yakin?')) {return false};
                document.getElementById('pass-form').submit();">
              Lolos
            </a>
            <a href="{{ route('admin.submission.failed', $submission) }}" 
              class="btn btn-sm btn-danger" onclick="
                event.preventDefault(); 
                if (!confirm('Apakah anda yakin?')) {return false};
                document.getElementById('failed-form').submit();">
              Tolak
            </a>
          </div>
          <form id="pass-form" action="{{ route('admin.submission.pass', $submission) }}" method="POST" class="d-none">
            @csrf
          </form>
          <form id="failed-form" action="{{ route('admin.submission.failed', $submission) }}" method="POST" class="d-none">
            @csrf
          </form>
          @else
          -
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection