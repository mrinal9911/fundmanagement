<!DOCTYPE html>
<html lang="en">

@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Home</title>
    <style>
        /* Styling the navigation bar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #333;
        }

        nav h1 {
            color: white;
            margin: 0;
        }

        .nav-links {
            display: flex;
            gap: 10px;
            margin-left: auto;
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

        .nav-link:hover {
            background-color: #0056b3;
        }

        /* General table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        thead {
            background-color: #4CAF50;
            color: white;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Button styling */
        .action-btn {

            background-color: #f39c12;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            transition-duration: 0.4s;
            border-radius: 4px;
            margin-right: 5px;
        }

        .action-btn:hover {
            background-color: #45a049;
        }

        .repay-btn {
            background-color: #f39c12;
        }

        .repay-btn:hover {
            background-color: #e67e22;
        }

        .provide-btn {
            background-color: #4CAF50;
        }

        .provide-btn:hover {
            background-color: #2980b9;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            text-align: center;
        }

        .close-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>

</head>

<body>



    <!-- Page title and balance information -->
    <div class="btn-container" data-balance="{{ $currentBalance['balance'] ?? 0 }}">
        <h2>Balance Left: ₹{{ number_format($currentBalance['balance'] ?? 0, 2) }}</h2>
        <h2>Outstanding Loan Amount: ₹{{ number_format($outstandingLoanAmt ?? 0, 2) }}</h2>
    </div>

    <!-- Loan Details Table -->
    <table>
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Name</th>
                <th>Loan Amount</th>
                <th>Paid Amount</th>
                <th>Outstanding Loan Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loanDetails as $loanDetail)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $loanDetail['name'] }}</td>
                <td>₹{{ number_format($loanDetail['loan_amt']) }}</td>
                <td>₹{{ number_format($loanDetail['paid_amt'], 2) }}</td>
                <td>₹{{ number_format($loanDetail['loan_amt']-$loanDetail['paid_amt'], 2) }}</td>
                <td>
                    <!-- Action buttons for each row -->
                    <a href="/loan/{{ $loanDetail['id'] }}" class="action-btn">View Loan Details</a>

                    <!-- Show "Provide Loan" button only for logged-in users -->
                    @auth
                    <button class="action-btn provide-btn" onclick="openModal({{ $loanDetail['id'] }})">Provide Loan</button>
                    @endauth
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal for entering loan amount -->
    <div id="loanModal" class="modal">
        <div class="modal-content">
            <h3>Enter Loan Amount</h3>
            <form id="loanForm" method="POST" action="{{ route('provideLoan') }}" onsubmit="return submitLoanForm()">
                @csrf
                <input type="hidden" name="user_id" id="loan_id">
                <input type="number" name="loan_amt" id="loan_amt" placeholder="Enter amount" required>
                <br><br>
                <input type="date" name="loan_date" placeholder="Enter Deposit Date" required max="{{ date('Y-m-d') }}">
                <br><br>
                <button type=" submit" class="action-btn">Submit</button>
                <button type="button" class="close-btn" onclick="closeModal()">Close</button>
            </form>
        </div>
    </div>

    <script>
        const balanceLeft = parseFloat(document.querySelector('.btn-container').dataset.balance);

        // Open modal and set loan_id in form
        function openModal(loanId) {
            document.getElementById('loan_id').value = loanId;
            document.getElementById('loanModal').style.display = 'flex';
        }

        // Close modal
        function closeModal() {
            document.getElementById('loanModal').style.display = 'none';
        }

        // Validate the loan amount before submission
        function submitLoanForm() {
            const loanAmt = parseFloat(document.getElementById('loan_amt').value);
            if (loanAmt > balanceLeft) {
                alert('Entered loan amount exceeds the balance left. Please enter a valid amount.');
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>

</body>
@endsection

</html>