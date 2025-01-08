@extends('layouts.app')

@section('content')
<div class="container text-center">
    @php 
        $columns = config('columns.columns'); 

        // Your dates in d-m-Y format
        $date1 = $user['created_at'] ?? "2024-01-01 00:00:00";
        $date2 = date('d-m-Y');

        // Convert strings to DateTime objects
        $dateTime1 = DateTime::createFromFormat('Y-m-d H:i:s', $date1);
        $dateTime2 = DateTime::createFromFormat('d-m-Y', $date2);

        // Calculate the difference
        $difference = $dateTime1->diff($dateTime2)->days + 1;
        
    @endphp 
    <h2 class="display-8 pb-3 m-3">Your Statistics (Day: {{$difference}})</h2>
    <div class="row justify-content-center">
        @foreach($columns as $key => $label)
        <div class="col-6 col-md-4 col-lg-2 mb-4"> <!-- Adjust sizes here -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $todaysTally[$key] }} / {{ $thisYearsTotal[$key] }}</h5>
                    <p class="card-text">{{ $label['label'] }}
                        <br>
                        <b>Last year: </b> {{ $lastYearsTotal[$key] }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-6 col-md-4 col-lg-2 mb-4"> <!-- Adjust sizes here -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> {{ $user->presents }} / {{ $user->total }} </h5>
                    <p class="card-text"> Attendance </p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4"> <!-- Adjust sizes here -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> {{ $difference }} </h5>
                    <p class="card-text"> Days Since Joined </p>
                </div>
            </div>
        </div>
    </div>
    @php
        $name = $totalTally['name'] ?? 'N/A';
        $message = "TOT School Report for: Day ". $difference ."\n"."Date: ".date('d/m/Y')."\nName: ".$name."\n";
        foreach($columns as $key => $label) {
            $today = $todaysTally[$key] ?? 'N/A';
            $total = $thisYearsTotal[$key] ?? 'N/A';
            $lastyear = $lastYearsTotal[$key] ?? 'N/A';
            $message .= "- " . $label['label'] . ": " . $today . " / " . $total . " / " . $lastyear . "\n";
        }
        $message = urlencode($message); // Use rawurlencode to ensure proper encoding of spaces and symbols
    @endphp

    <div class="text-center mt-4 pb-4 border-bottom"> <!-- Center the button and add some top margin -->
        <a href="https://wa.me/?text={{ $message }}" class="btn btn-success" target="_blank">Share on WhatsApp</a>
        <a href="{{ route('attendance.mark') }}" class="btn btn-info" target="_blank">Open Today's Zoom Lecture</a>
    </div>
    <h2 class="display-8 m-3 pb-3">Analysis Reports</h2>
    <div class="row justify-content-center">
        <div class="col-6 col-md-4 col-lg-2 mb-4"> <!-- Adjust sizes here -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ($totalTally['calls'] != 0) ? 
                        round($totalTally['leads']/$totalTally['calls']*100) : 0 }}%</h5>
                    <p class="card-text">Call Conversion</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4"> <!-- Adjust sizes here -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ($totalTally['leads'] != 0) ?
                        round($totalTally['meetings']/$totalTally['leads']*100) : 0 }}%</h5>
                    <p class="card-text">Lead Conversion</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4"> <!-- Adjust sizes here -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ($totalTally['meetings'] != 0) ?
                        round($totalTally['policies']/$totalTally['meetings']*100) : 0 }}%</h5>
                    <p class="card-text">Closing Rate</p>
                </div>
            </div>
        </div>
    </div>
    <select id="modeSelector" class="form-control mb-3">
        <option value="Weekly">Weekly</option>
        <option value="Monthly">Monthly</option>
        <option value="Quarterly">Quarterly</option>
    </select>
    <div class="row justify-content-center">
        @php
            $columns = config('columns.columns');
        @endphp
        @foreach($columns as $key => $value)
        <div class="col-12 col-md-6 col-lg-6">  <!-- Adjust sizes here -->
            <div class="card mt-4">
                <div class="card-body">
                    <canvas id="graph_{{$key}}"></canvas>
                </div>
            </div>
            <!--h6 class="display-8 pt-1">{{ $value['label'] }}</h6-->
        </div>
        @endforeach
    </div>
</div>
<script>
const modeSelector = document.getElementById('modeSelector');

let allcharts = [];

let xValues = @json($weeks);
let yValues = @json($weeklySums);

document.addEventListener('DOMContentLoaded', drawGraphs);
modeSelector.addEventListener('change', drawGraphs);

function generateColors(n) {
    const predefinedColors = [
        'rgba(255, 99, 132, 0.6)',   // Red
        'rgba(54, 162, 235, 0.6)',   // Blue
        'rgba(255, 206, 86, 0.6)',   // Yellow
        'rgba(75, 192, 192, 0.6)',   // Green
        'rgba(153, 102, 255, 0.6)',  // Purple
        'rgba(255, 159, 64, 0.6)',   // Orange
        'rgba(199, 199, 199, 0.6)',  // Grey
    ];

    const colors = [];

    for (let i = 0; i < n; i++) {
        colors.push(predefinedColors[i % predefinedColors.length]);
    }

    return colors;
}

function generateBorderColors(n) {
    const predefinedColors = [
        'rgba(255, 99, 132, 1)',   // Red
        'rgba(54, 162, 235, 1)',   // Blue
        'rgba(255, 206, 86, 1)',   // Yellow
        'rgba(75, 192, 192, 1)',   // Green
        'rgba(153, 102, 255, 1)',  // Purple
        'rgba(255, 159, 64, 1)',   // Orange
        'rgba(159, 159, 159, 1)',  // Grey
    ];

    const colors = [];

    for (let i = 0; i < n; i++) {
        colors.push(predefinedColors[i % predefinedColors.length]);
    }

    return colors;
}

function drawGraphs() {
    const mode = modeSelector.value;

    // Destroy all charts
    allcharts.forEach(chart => {
        chart.destroy();
    });

    allcharts = [];

    // Fetch data based on mode
    if (mode === 'Weekly') {
        xValues = @json($weeks);
        yValues = @json($weeklySums);
    } else if (mode === 'Monthly') {
        xValues = @json($monthLabels);
        yValues = @json($monthlySums);
    } else if (mode === 'Quarterly') {
        xValues = @json($quarterLabels);
        yValues = @json($quarterlySums);
    }

    @foreach($columns as $key => $value)
        (function() {
            const dataPoints = yValues['{{$key}}'];
            const backgroundColors = generateColors(dataPoints.length);
            const borderColors = generateBorderColors(dataPoints.length);

            const ctx = document.getElementById('graph_{{$key}}').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: mode + ' {{$value['label']}}',
                        data: dataPoints,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1,
                    }],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
            allcharts.push(chart);
        })();
    @endforeach
}
</script>

@endsection
