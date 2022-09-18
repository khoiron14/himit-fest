<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
    @admin
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" 
          href="{{ route('dashboard') }}">
          <span data-feather="home" class="align-text-bottom"></span>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('team*') ? 'active' : '' }}" 
          href="{{ route('team.index') }}">
          <span data-feather="users" class="align-text-bottom"></span>
          Daftar Tim
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
      <span>Pengumpulan</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ request()->is('dashboard/'.App\Enums\CompetitionType::WebDesign->value.'*') ? 'active' : '' }}" 
          href="{{ route('admin.submission.index', [App\Enums\CompetitionType::WebDesign, App\Models\Step::first()->status]) }}">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Web Design
        </a>
        <a class="nav-link {{ request()->is('dashboard/'.App\Enums\CompetitionType::BTIK->value.'*') ? 'active' : '' }}" 
          href="{{ route('admin.submission.index', [App\Enums\CompetitionType::BTIK, App\Models\Step::first()->status]) }}">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Bisnis TIK
        </a>
        <a class="nav-link {{ request()->is('dashboard/'.App\Enums\CompetitionType::UIUX->value.'*') ? 'active' : '' }}" 
          href="{{ route('admin.submission.index', [App\Enums\CompetitionType::UIUX, App\Models\Step::first()->status]) }}">
          <span data-feather="file-text" class="align-text-bottom"></span>
          UIUX
        </a>
      </li>
    </ul>
    @else
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}" 
          href="{{ route('profile.index') }}">
          <span data-feather="user" class="align-text-bottom"></span>
          Profile
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('competition*') ? 'active' : '' }}" 
          href="{{ route('competition.index') }}">
          <span data-feather="wind" class="align-text-bottom"></span>
          Kompetisi
        </a>
      </li>
      @php
          $sub1 = App\Models\Submission::where('profile_id', auth()->user()->profile->id)->where('step', App\Enums\StepStatus::Step1)->first();
      @endphp
      @if ($sub1 && ($sub1->status == App\Enums\SubmissionStatus::Pass) && (App\Models\Step::first()->status != App\Enums\StepStatus::Step1))
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('payment*') ? 'active' : '' }}" 
          href="{{ route('payment.index') }}">
          <span data-feather="tag" class="align-text-bottom"></span>
          Pembayaran
        </a>
      </li>
      @endif
    </ul>
    @endadmin

    <ul class="nav flex-column">
      <li class="nav-item d-md-none">
        <a class="nav-link" href="{{ route('logout') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <span data-feather="log-out" class="align-text-bottom"></span>
          Sign out
        </a>
      </li>
    </ul>
  </div>
</nav>