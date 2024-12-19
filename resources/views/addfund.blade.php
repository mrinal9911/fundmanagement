@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<title>
    Add Fund
</title>

<style>
    body {
        background-color: #f8f9fa;
        /* Light background color for the body */
    }

    .nav-link {
        color: white;
        text-decoration: none;
        font-weight: bold;
        background-color: #007bff;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
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

<div class="form-container">
    <h2>Add Fund</h2>
    <form action="{{ url('datasaved') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Select Friend</label>
            <select name="userId" class="form-control" required>
                <option value="">Select Friend</option>
                @foreach ($friendList as $list)
                <option value="{{ $list->id }}" {{ old('id') == $list->id ? 'selected' : '' }}>{{ $list->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Year</label>
            <select name="year" class="form-control">
                <option value="">Select Year</option>
                @for ($year = date('Y'); $year >= 2000; $year--)
                <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Month</label>
            <select name="month" id="month" class="form-control">
                <option value="">Select Month</option>
                <option value="01" {{ old('month') == '01' ? 'selected' : '' }}>January</option>
                <option value="02" {{ old('month') == '02' ? 'selected' : '' }}>February</option>
                <option value="03" {{ old('month') == '03' ? 'selected' : '' }}>March</option>
                <option value="04" {{ old('month') == '04' ? 'selected' : '' }}>April</option>
                <option value="05" {{ old('month') == '05' ? 'selected' : '' }}>May</option>
                <option value="06" {{ old('month') == '06' ? 'selected' : '' }}>June</option>
                <option value="07" {{ old('month') == '07' ? 'selected' : '' }}>July</option>
                <option value="08" {{ old('month') == '08' ? 'selected' : '' }}>August</option>
                <option value="09" {{ old('month') == '09' ? 'selected' : '' }}>September</option>
                <option value="10" {{ old('month') == '10' ? 'selected' : '' }}>October</option>
                <option value="11" {{ old('month') == '11' ? 'selected' : '' }}>November</option>
                <option value="12" {{ old('month') == '12' ? 'selected' : '' }}>December</option>
            </select>
        </div>

        <!-- <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="text" name="amt" id="amount" value="{{ old('amt') }}" class="form-control" required>
            </div> -->

        <div class="mb-3">
            <label class="form-label">Monthly Contribution Amount</label>
            <input type="text" name="montlhlyamt" id="amount" value="{{ old('montlhlyamt') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Loan Contribution Amount</label>
            <input type="text" name="loanamt" id="amount" value="{{ old('loanamt') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" id="description" value="{{ old('description') }}" class="form-control" optional>
        </div>

        <div class="mb-3">
            <label class="form-label">Deposited On</label>
            <input type="date" name="deposited_on" value="{{ old('deposited_on') }}" class="form-control" max="{{ date('Y-m-d') }}">
        </div>

        <div class=" mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
    <button class="btn-back" onclick="window.history.back();">Go Back</button>
    <button class="btn-home" onclick="window.location.href='{{ url('/') }}';">Home</button>
</div>

<script>
    // Set the amount to 1600 when a month is selected
    document.getElementById('month').addEventListener('change', function() {
        const amountField = document.getElementById('amount');
        if (this.value) {
            amountField.value = '1600';
        } else {
            amountField.value = ''; // Clear the amount if no month is selected
        }
    });

    document.querySelector('form').addEventListener('submit', function(event) {
        const monthlyAmt = document.querySelector('input[name="montlhlyamt"]').value;
        const loanAmt = document.querySelector('input[name="loanamt"]').value;

        if (!monthlyAmt && !loanAmt) {
            alert('Either Monthly Contribution Amount or Loan Contribution Amount must be provided.');
            event.preventDefault(); // Prevent form submission
        }
    });
</script>
@endsection