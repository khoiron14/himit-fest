<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
    <ul class="nav flex-column">

      @admin
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">
          <span data-feather="home" class="align-text-bottom"></span>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('team*') ? 'active' : '' }}" aria-current="page" href="{{ route('team.index') }}">
          <span data-feather="users" class="align-text-bottom"></span>
          Daftar Tim
        </a>
      </li>
      @else
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}" aria-current="page" href="{{ route('profile.index') }}">
          <span data-feather="user" class="align-text-bottom"></span>
          Profile
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('competition*') ? 'active' : '' }}" aria-current="page" href="{{ route('competition.index') }}">
          <span data-feather="wind" class="align-text-bottom"></span>
          Kompetisi
        </a>
      </li>
      @endadmin

      <li class="nav-item d-md-none">
        <a class="nav-link" 
          href="{{ route('logout') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        >
          <span data-feather="log-out" class="align-text-bottom"></span>
          Sign out
        </a>
      </li>
    </ul>
  </div>
</nav>