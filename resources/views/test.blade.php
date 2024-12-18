@extends('layouts.app')

@section('title', 'Fix Deposit')

@section('content')
<title>Fix Deposit</title>
<style>
    .container {
        background: rgb(238, 0, 0);
        height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: row;
        /* Arrange children horizontally */
        justify-content: space-between;
        /* Ensure equal spacing between the two boxes */
        padding: 20px;
        /* Add padding around the container */
    }

    .box1,
    .box2 {
        background: pink;
        height: 100%;
        width: 48%;
        /* Make each box slightly smaller to avoid any overlap */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Add some shadow for depth */
    }

    .box2 {
        background: black;
        color: white;
        /* Change text color to white for contrast */
    }

    .form-label {
        font-weight: bold;
        color: #333;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 10px;
        width: 100%;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
    }

    .btn-danger {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
    }

    h2 {
        text-align: center;
        color: #007bff;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #fff;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }
</style>

<div class="container">
    <!-- Left Side: Fix Deposit Form -->
    <div class="box1">
        <h2>Fix Deposit Fund</h2>
        <form action="{{ url('postfd') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Enter Date</label>
                <input type="date" name="date" value="{{ old('date') }}" class="form-control">
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
                <thead class="table-primary">
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
                        <td>{{ $fd['accountNo'] }}</td>
                        <td>₹{{ number_format($fd['amount'], 2) }}</td>
                        <td>
                            <form action="{{ url('releasefd', $fd['id']) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                                    Release FD
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p style="text-align: center; margin-top: 20px;">No Fixed Deposits found.</p>
        @endif
    </div>
</div>

@endsection