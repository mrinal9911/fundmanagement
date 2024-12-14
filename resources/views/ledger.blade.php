<!DOCTYPE html>
<html lang="en">
@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledger</title>
    <style>
        /* Navbar styles */
        nav {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #333;
        }

        nav h1 {
            color: white;
            margin: 0;
            font-size: 1.5em;
        }

        .nav-links {
            margin-left: auto;
            display: flex;
            gap: 10px;
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

        /* Body and heading styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0 20px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }

        /* Button container */
        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Balance heading */
        .btn-container h2 {
            margin: 0;
            font-size: 1.2em;
        }

        /* General button styles */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #218838;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        /* Highlight rows based on type */
        .credit {
            background-color: #d4edda;
            color: #155724;
        }

        .debit {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Make the balance column bold */
        td:last-child {
            font-weight: bold;
            color: black;
        }

        /* Responsive layout */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                text-align: center;
            }

            .btn-container {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            th,
            td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>

    <h2>Ledger</h2>

    <!-- Balance and Add Ledger Button -->
    <div class="btn-container">
        <h2>Balance Left: ₹{{ number_format($currentBalance['balance'], 2) }}</h2>
        <!-- <a href="{{ url('add-ledger') }}" class="btn">Add Ledger</a> -->
    </div>

    <table>
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Date</th>
                <th>Description</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            @php
            $rowClass = $transaction['type'] === 'Credit' ? 'credit' : 'debit';
            @endphp
            <tr class="{{ $rowClass }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaction['date'] }}</td>
                <td>{{ $transaction['description'] }}</td>
                <td>{{ ucfirst($transaction['type']) }}</td>
                <td>₹{{ number_format($transaction['amount']) }}</td>
                <td>₹{{ number_format($transaction['balance'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
@endsection

</html>