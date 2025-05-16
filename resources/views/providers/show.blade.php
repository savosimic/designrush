@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $provider->name }}</h1>

        <div class="provider-show">
            @if($provider->logo)
                <img
                    src="{{ $provider->logo }}"
                    alt="{{ $provider->name }}"
                    loading="lazy"
                    class="show-logo">
            @endif
            …
        </div>

        <p><strong>Category:</strong> {{ $provider->category->name }}</p>

        <p>{{ $provider->description }}</p>

        <a href="{{ route('providers.index') }}">← Back to list</a>
    </div>
@endsection
