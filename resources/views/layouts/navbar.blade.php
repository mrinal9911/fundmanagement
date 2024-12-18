<nav>
    <div style="display: flex; align-items: center;">
        <!-- Logo Image -->
        <img src="{{ asset('keymonlogo.png') }}" alt="Logo" style="height: 50px; width: auto; margin-right: 10px;">
        <!-- <img src="{{ asset('image.png') }}" alt="Logo" style="height: 50px; width: auto; margin-right: 10px;"> -->
        <h1>Keymon Gullak</h1>
    </div>
    <div class="nav-links">
        @auth
        <!-- Links visible only to authenticated users -->
        <a href="{{ url('/') }}" class="nav-link">Home</a>
        <a href="{{ url('add-user') }}" class="nav-link">Add User</a>
        <a href="{{ url('add-fund') }}" class="nav-link">Add Fund</a>
        <a href="{{ url('loan') }}" class="nav-link">Loan</a>
        <a href="{{ url('ledger') }}" class="nav-link">Ledger</a>
        <a href="{{ url('fd') }}" class="nav-link">Fix Deposit</a>
        <!-- Logout -->
        <form action="{{ url('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="nav-link login-btn">
                Logout
            </button>
        </form>
        @else
        <!-- Links visible to guests (not authenticated users) -->
        <a href="{{ url('/') }}" class="nav-link">Home</a>
        <a href="{{ url('loan') }}" class="nav-link">Loan</a>
        <a href="{{ url('ledger') }}" class="nav-link">Ledger</a>
        <a href="{{ url('login') }}" class="nav-link login-btn">Login</a>
        @endauth
    </div>
</nav>