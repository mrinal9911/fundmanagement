@extends('layouts.app')

@section('title', 'Fix Deposit')

@section('content')
<title>Fix Deposit</title>

<style>
    body {
        background-color: #f4f7fc;
        font-family: 'Arial', sans-serif;
    }

    .container {
        background: rgb(238, 230, 230);
        height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 20px;
        box-sizing: border-box;
    }

    /* Styling for the left side (Form) */
    .box1 {
        background: #fff;
        height: 100%;
        width: 48%;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .box1:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    h2 {
        text-align: center;
        color: #007bff;
        font-size: 1.8rem;
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 12px;
        width: 100%;
        font-size: 1rem;
        margin-bottom: 16px;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        font-size: 1.1rem;
        background-color: #007bff;
        border: none;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        background-color: #dc3545;
        border: none;
        color: white;
        cursor: pointer;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Styling for the right side (Fixed Deposits Table) */
    .box2 {
        background: #2d2d2d;
        color: white;
        height: 100%;
        width: 48%;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        color: white;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
        padding: 12px;
    }

    .table th {
        background-color: #343a40;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #3e434a;
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #2c2f36;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #444;
    }

    /* Responsive Table */
    .table-responsive {
        margin-top: 20px;
    }

    .no-records {
        text-align: center;
        font-size: 1.2rem;
        color: #ccc;
        padding-top: 20px;
    }
</style>

<div class="btn-container">
    <h2>Balance Left: ₹{{ number_format($currentBalance['balance']??0, 2) }}</h2>
</div>

<div class="container">

    <!-- Left Side: Fix Deposit Form -->
    <div class="box1">
        <h2>Fix Deposit Fund</h2>
        <form action="{{ url('postfd') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Enter Date</label>
                <input type="date" name="date" value="{{ old('date') }}" class="form-control" max="{{ date('Y-m-d') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Enter Account No:</label>
                <input type="text" name="accountNo" value="{{ old('accountNo') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Enter Amount :</label>
                <input type="text" name="amount" value="{{ old('amount') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <!-- Right Side: Fixed Deposits List -->
    <div class="box2">
        <h2>Fixed Deposits</h2>
        @if (count($fdList) > 0)
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Account No</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fdList as $index => $fd)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $fd['date'] }}</td>
                        <td>{{ $fd['account_no'] }}</td>
                        <td>₹{{ number_format($fd['amount'], 2) }}</td>
                        <td>
                            @if($fd['is_released']==false)
                            <form action="{{ url('releasefd', $fd['id']) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">
                                    Release FD
                                </button>
                            </form>
                            @else

                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="no-records">No Fixed Deposits found.</p>
        @endif
    </div>
</div>

@endsection