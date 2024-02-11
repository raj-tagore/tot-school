@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2 class="display-8 pb-3">Leaderboards</h2>
    <div class="row border-bottom mb-5">
        <div class="col-lg-4">
            <h5>Top 5 Users by Calls</h5>
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Total Calls</th>
                    </tr>
                </thead>
                <tbody>
                    @php $topCalls = $allUsers->sortByDesc('calls'); @endphp
                    @foreach($topCalls->take(5) as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->calls }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="col-lg-4">
            <h5>Top 5 Users by Meetings</h5>
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Meetings</th>
                    </tr>
                </thead>
                <tbody>
                    @php $topCalls = $allUsers->sortByDesc('meetings'); @endphp
                    @foreach($topCalls->take(5) as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->meetings }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="col-lg-4">
            <h5>Top 5 Users by Premium</h5>
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Premium</th>
                    </tr>
                </thead>
                <tbody> 
                    @php $topCalls = $allUsers->sortByDesc('premium'); @endphp
                    @foreach($topCalls->take(5) as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->premium }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
    </div>
    @php 
        $columns = config('columns.columns'); 

        // Your dates in d-m-Y format
        $date1 = $totalTally['created_at'] ?? "2024-01-01 00:00:00";
        $date2 = date('d-m-Y');

        // Convert strings to DateTime objects
        $dateTime1 = DateTime::createFromFormat('Y-m-d H:i:s', $date1);
        $dateTime2 = DateTime::createFromFormat('d-m-Y', $date2);

        // Calculate the difference
        $difference = $dateTime1->diff($dateTime2)->days + 1;
        
    @endphp
    <h2 class="display-8 pb-3">Your Statistics (Day: {{$difference}})</h2>
    <div class="row justify-content-center">
        @foreach($columns as $key => $label)
            <div class="col-6 col-md-4 col-lg-2 mb-4"> <!-- Adjust sizes here -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $todaysTally[$key] }} / {{ $totalTally[$key] }}</h5>
                        <p class="card-text">{{ $label['label'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-6 col-md-4 col-lg-2 mb-4"> <!-- Adjust sizes here -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> {{ $count }} / {{ $difference }} </h5>
                    <p class="card-text"> Attendance </p>
                </div>
            </div>
        </div>
    </div>
    @php
        $name = $allUsers->firstWhere('user_id', $totalTally['user_id'])->name ?? 'Enter name here';
        $message = "TOT School Report for: Day ". $difference ."\n"."Date: ".date('d/m/Y')."\nName: ".$name."\n";
        foreach($columns as $key => $label) {
            $today = $todaysTally[$key] ?? 'N/A';
            $total = $totalTally[$key] ?? 'N/A';
            $message .= "- " . $label['label'] . ": " . $today . " / " . $total . "\n";
        }
        $message = urlencode($message); // Use rawurlencode to ensure proper encoding of spaces and symbols
    @endphp

    <div class="text-center mt-4"> <!-- Center the button and add some top margin -->
        <a href="https://wa.me/?text={{ $message }}" class="btn btn-success" target="_blank">Share on WhatsApp</a>
    </div>
</div>
@endsection
