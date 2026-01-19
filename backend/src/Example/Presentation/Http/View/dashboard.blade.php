@extends('core::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <p>{{ $example->id }}. {{ $example->name }}</p>
                <p>{{ $example->comment ?? '---' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
