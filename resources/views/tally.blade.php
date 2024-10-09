@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2 p-5">
        @if ($submitted == true )
            <h4 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight alert alert-success">
                Data submitted for today ({{date('d/m/Y')}}). You can submit again with your correct values if you have made a mistake.
            </h4>
            <h6 class="alert alert-info">
                <b>Your current data for today is:</b> <br>
                @php 
                    $columns = config('columns.columns');
                @endphp
                @foreach($columns as $key => $label)
                    {{ $label['label'] }}: {{ $todaysTally[$key] }} <br>
                @endforeach
            </h6>
        @else   
            <h3>Form for {{date('d/m/Y')}}</h3>
        @endif
        <form method="POST" action="{{ route('log-tally') }}">
            @csrf

            @foreach(config('columns.columns') as $field => $settings)
                <div class="form-group p-2">
                    <label for="{{ $field }}">{{ $settings['label'] }}</label>
                    <input type="{{ $settings['type'] }}"
                           class="form-control"
                           id="{{ $field }}"
                           name="{{ $field }}"
                           {{ $settings['required'] ? 'required' : '' }}>
                </div>
            @endforeach

            <!-- Submit Button -->
            <div class="p-3"><button type="submit" class="btn btn-primary">Submit</button></div>
        </form>
    </div>
</div>
@endsection
