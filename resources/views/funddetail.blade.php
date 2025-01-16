<h2 style="
    font-size: 26px;
    color: #007bff;
    font-family: Arial, sans-serif;
    text-align: left;
    margin-bottom: 20px;
    font-weight: bold;
">
    Monthly Contribution Details
</h2>
<div style="
    background-color: #f7f7f7; 
    padding: 20px; 
    border-radius: 8px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    font-size: 24px; 
    font-weight: bold; 
    color: #333; 
    font-family: Arial, sans-serif;
    width: 50%;
    text-align: center;
    margin-bottom: 20px;
">
    {{$monthlyDeposit[0]['name']??"User"}}
</div>

<!-- Total Contribution Section -->
<div style="
    background-color: #eaf4ea;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-size: 22px;
    color: #2d572c;
    font-family: Arial, sans-serif;
    width: 50%;
    text-align: center;
    margin-bottom: 20px;
">
    Total Contribution: ₹{{ number_format($monthlyDeposit[0]['total_contribution']) }} <!-- Sums up the amounts -->
</div>

<!-- Monthly Contribution Section -->


<div style="padding: 0px 10px">
    <style>
        table {
            width: 50%;
            /* Set width to 50% to occupy half the screen */
            border-collapse: collapse;
            margin: 20px 0;
            /* Margin for spacing above and below */
            font-size: 18px;
            /* Font size for the text */
            text-align: left;
            /* Align text to the left */
            float: left;
            /* Align the table to the left */
        }

        th,
        td {
            padding: 12px 15px;
            /* Padding for cells */
            border: 1px solid #ddd;
            /* Border styling */
        }

        th {
            background-color: #007bff;
            /* Header background color */
            color: white;
            /* Header text color */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
            /* Even row background color */
        }

        tr:hover {
            background-color: #f1f1f1;
            /* Hover effect */
        }

        td {
            font-family: Arial, sans-serif;
            /* Font for table cells */
        }
    </style>

    <table>
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Amount</th>
                <th>Month</th>
                <th>Year</th>
                <th>Deposited On</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($monthlyDeposit as $detail)
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Serial number -->
                <td>{{ $detail->amount }}</td>
                <td>{{ \DateTime::createFromFormat('!m', $detail->month)->format('F') }}</td> <!-- Convert month number to full month name -->
                <td>{{ $detail->year }}</td>
                <td>{{ $detail->deposited_on }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>