@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Service Providers</h1>

        <form method="GET" action="{{ route('providers.index') }}">
            <label for="category">Filter by category:</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">All</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <div class="grid" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">
            @foreach($providers as $provider)
                <div style="width: 300px; border: 1px solid #ccc; padding: 10px;">
                    @if($provider->logo)
                        <img
                            src="{{ $provider->logo }}"
                            alt="{{ $provider->name }}"
                            loading="lazy"
                            style="width:100%; height:auto;">
                    @endif
                    <h3>
                        <a href="{{ route('providers.show', $provider) }}">{{ $provider->name }}</a>
                    </h3>
                    <p>{{ Str::limit($provider->description, 100) }}</p>
                    <small>Category: {{ $provider->category->name }}</small>
                </div>
            @endforeach
        </div>

        @php
            $currentPage = $providers->currentPage();
            $lastPage = $providers->lastPage();
        @endphp

        <div class="custom-pagination" style="margin-top: 2rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
            {{-- Previous --}}
            @if ($currentPage > 1)
                <a href="{{ $providers->url($currentPage - 1) }}">« Prev</a>
            @else
                <span style="opacity: 0.5;">« Prev</span>
            @endif

            {{-- Page Numbers --}}
            @for ($page = 1; $page <= $lastPage; $page++)
                @if ($page == $currentPage)
                    <span style="font-weight: bold;">{{ $page }}</span>
                @else
                    <a href="{{ $providers->url($page) }}">{{ $page }}</a>
                @endif
            @endfor

            {{-- Next --}}
            @if ($currentPage < $lastPage)
                <a href="{{ $providers->url($currentPage + 1) }}">Next »</a>
            @else
                <span style="opacity: 0.5;">Next »</span>
            @endif
        </div>


    </div>
@endsection
