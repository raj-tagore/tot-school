@extends('layouts.app')

@section('content')
<div class="container text-center">
    @php
        $columns = config('columns.columns');
    @endphp
        
    <h2 class="display-8 pb-3">Leaderboards</h2>
    <!--p> Stats only displayed for the last 90 days.</p-->
    <div class="row border-bottom mb-5">

    @foreach($columns as $key => $values)

        <div class="col-lg-6 mb-5">
            <h5>Top 5 Users by {{ $values['label'] }}</h5>
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Total {{ $values['label'] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $allUsers = $allUsers->sortByDesc($key);
                    @endphp

                    @foreach($allUsers->take(5) as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->user->name }}</td>
                            <td>{{ $user[$key] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a class="btn border" href="/leaderboard/{{$key}}">View All</a>
        </div>

    @endforeach
     
    </div>
</div>
@endsection