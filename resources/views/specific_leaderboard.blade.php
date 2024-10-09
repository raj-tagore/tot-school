@extends('layouts.app')

@section('content')
<div class="container text-center">
    @php
        $columns = config('columns.columns');
    @endphp
        
    <h2 class="display-8 pb-3">{{ $columns[$key]['label'] }} - Leaderboards</h2>
    <!--p> Stats only displayed for the last 90 days.</p-->
    <div class="row border-bottom mb-5">
        <div class="mb-5">
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Total {{ $columns[$key]['label'] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $allUsers = $allUsers->sortByDesc($key);
                    @endphp

                    @foreach($allUsers as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->user->name }}</td>
                            <td>{{ $user[$key] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection