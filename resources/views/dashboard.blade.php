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
    <h2 class="display-8 pb-3">Your Statistics</h2>
    <div class="row justify-content-center">
        @php $columns = config('columns.columns'); @endphp
        @foreach($columns as $key => $label)
            <div class="col-6 col-md-4 col-lg-2 mb-4"> <!-- Adjust sizes here -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalTally->$key }}</h5>
                        <p class="card-text">{{ $label['label'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
