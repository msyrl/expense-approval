<li class="nav-item">
    <form action="{{ route('logout') }}" method="GET" autocomplete="off" onsubmit="return confirm('Are you sure want to logout?')">
        @csrf
        <input type="submit" class="d-none" id="submit-logout">
    </form>
    <a href="#" class="nav-link" onclick="document.getElementById('submit-logout').click()">
        <i class="fas fa-sign-out-alt nav-icon"></i>
        <p>Sign Out</p>
    </a>
</li>
