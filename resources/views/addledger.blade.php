<!DOCTYPE html>
<html lang="en">
{{$currentBalance}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Ledger Entry</title>
    <style>
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        .form-container .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Add Ledger Entry</h2>

        <form action="{{ url('add-ledger') }}" method="POST">
            @csrf

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" class="form-control" required>

            <label for="type">Type:</label>
            <select id="type" name="type" class="form-control" required>
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>
            </select>

            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" class="form-control" required>

            <label for="balance">Balance:</label>
            <input type="number" id="balance" name="balance" class="form-control" required readonly>

            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control"></textarea>

            <button type="submit" class="btn">Add Ledger</button>
        </form>
    </div>

    <script>
        // Function to update the balance based on type and amount
        function updateBalance() {
            const type = document.getElementById('type').value;
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            let newBalance = $currentBalance;

            if (type === 'credit') {
                newBalance += amount;
            } else if (type === 'debit') {
                newBalance -= amount;
            }

            document.getElementById('balance').value = newBalance.toFixed(2); // Show balance with two decimal points
        }

        // Event listeners for real-time balance calculation
        document.getElementById('amount').addEventListener('input', updateBalance);
        document.getElementById('type').addEventListener('change', updateBalance);
    </script>

</body>

</html>