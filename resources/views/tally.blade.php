@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2 p-5">
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
    </div>
</div>
@endsection
