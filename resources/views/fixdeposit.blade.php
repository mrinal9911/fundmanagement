@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<title>Fix Deposit</title>
<style>
    body {
        background-color: #f8f9fa;
        /* Light background color for the body */
    }

    .form-container {
        max-width: 400px;
        /* Set a maximum width for the form */
        margin: 50px auto;
        /* Center the form on the page */
        padding: 20px;
        /* Padding around the form */
        background-color: white;
        /* White background for the form */
        border-radius: 8px;
        /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
    }

    h2 {
        text-align: center;
        /* Center the heading */
        margin-bottom: 20px;
        /* Space below the heading */
        color: #007bff;
        /* Heading color */
    }

    .form-label {
        font-weight: bold;
        /* Bold labels */
        color: #333;
        /* Darker label color */
    }

    .form-control {
        border: 1px solid #ced4da;
        /* Light border */
        border-radius: 4px;
        /* Rounded input fields */
        padding: 10px;
        /* Padding inside input fields */
        width: 100%;
        /* Full width */
        box-sizing: border-box;
        /* Ensure padding is included in width */
    }

    .form-control:focus {
        border-color: #007bff;
        /* Change border color on focus */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        /* Focus shadow effect */
    }

    .btn-primary {
        width: 100%;
        /* Full width button */
        padding: 10px;
        /* Padding for the button */
        border-radius: 4px;
        /* Rounded button */
    }

    .btn-back,
    .btn-home {
        width: 100%;
        /* Full width button */
        padding: 10px;
        /* Padding for the button */
        border-radius: 4px;
        /* Rounded button */
        background-color: #6c757d;
        /* Secondary button color */
        color: white;
        /* Text color */
        border: none;
        /* No border */
        margin-bottom: 10px;
        /* Space below the button */
    }

    .btn-home {
        background-color: #007bff;
        /* Primary button color */
    }
</style>
<!-- Page title and balance information -->
<div class="btn-container" data-balance="{{ $currentBalance['balance'] }}">
    <h2>Balance Left: ₹{{ number_format($currentBalance['balance'], 2) }}</h2>
</div>

<div class="form-container">
    <h2>Fix Deposit Fund</h2>
    <form action="{{ url('postfd') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Enter Date</label>
            <input type="date" name="date" value="{{ old('date') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Enter Account No:</label>
            <input type="text" name="accountNo" id="amount" value="{{ old('accountNo') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Enter Amount :</label>
            <input type="text" name="amount" id="amount" value="{{ old('amt') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
    <button class="btn-home" onclick="window.location.href='{{ url('/') }}';">Home</button>
</div>

@endsection