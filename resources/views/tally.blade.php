@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2 p-5">
        @if ($submitted == true )
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Data submitted for today.
            </h2>
        @else
        <h2>Form for {{date('d-m-y')}}</h2>
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
        @endif
    </div>
</div>
@endsection
