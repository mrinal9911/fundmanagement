<!-- resources/views/layouts/navbar.blade.php -->
<nav>
    <h1>Keymon Gullak</h1>
    <div class="nav-links">
        <a href="{{ url('add-user') }}" class="nav-link">Add User</a>
        <a href="{{ url('add-fund') }}" class="nav-link">Add Fund</a>
        <a href="{{ url('loan') }}" class="nav-link">Loan</a>
        <a href="{{ url('ledger') }}" class="nav-link">Ledger</a>
        <a href="{{ url('fd') }}" class="nav-link">Fix Deposit</a>
        <a href="{{ url('login') }}" class="nav-link login-btn">Login</a>
    </div>
</nav>