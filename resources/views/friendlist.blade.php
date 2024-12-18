@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

@php
// Calculate the total contribution
$totalContribution = $friendList->sum('total_contribution');
@endphp

<div style="margin-bottom: 20px; text-align: center;">
    <h2 style="font-size: 2em; color: #007bff; font-weight: bold;">Friends' Contributions</h2>
</div>

<!-- Total Contribution Section -->
<div class="contribution-box" style="
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
    Total Contribution of All Friends: ₹{{ number_format($totalContribution, 2) }}
</div>

<!-- Styled table -->
<div style="overflow-x: auto; margin-top: 20px;">
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 1em; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; border-radius: 10px; overflow: hidden;">
        <thead>
            <tr style="background-color: #007bff; color: #fff;">
                <th style="padding: 15px;">Sl No.</th>
                <th style="padding: 15px;">Name</th>
                <th style="padding: 15px;">Total Contribution</th>
                <th style="padding: 15px;">Full Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($friendList as $list)
            <tr style="transition: background-color 0.3s ease;">
                <td style="padding: 15px; border-bottom: 1px solid #ddd;">{{ $loop->iteration }}</td>
                <td style="padding: 15px; border-bottom: 1px solid #ddd;">{{ $list->name }}</td>
                <td style="padding: 15px; border-bottom: 1px solid #ddd; color: #007bff; font-weight: bold;">₹{{ number_format($list->total_contribution, 2) }}</td>
                <td style="padding: 15px; border-bottom: 1px solid #ddd;">
                    <form action="{{ url('details', $list->id) }}" method="GET">
                        <button type="submit" class="btn-info" style="
                            background-color: #007bff;
                            color: #fff;
                            border: none;
                            padding: 8px 12px;
                            border-radius: 5px;
                            font-size: 0.9em;
                            font-weight: 600;
                            cursor: pointer;
                            transition: background-color 0.3s ease;
                            ">
                            Details
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    /* Add hover effect for table rows */
    table tbody tr:hover {
        background-color: #f1f1f1;
    }

    /* Add shadow hover effect for buttons */
    .btn-info:hover {
        background-color: #0056b3;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transform: translateY(-1px);
    }
</style>

@endsection