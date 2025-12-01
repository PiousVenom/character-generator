@extends('layouts.app')

@section('title', 'Server Error - D&D Character Creator')

@section('content')
<div class="max-w-2xl mx-auto text-center py-16">
    <div class="mb-8">
        <svg class="w-24 h-24 mx-auto text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
    </div>

    <h1 class="text-6xl font-bold text-gray-900 mb-4">500</h1>
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Server Error</h2>
    <p class="text-gray-600 mb-4">
        Something went wrong on our end. The server rolled a critical failure.
    </p>
    <p class="text-gray-500 mb-8">
        Our team has been notified and is working to fix the issue.
    </p>

    @if(isset($correlationId) || request()->header('X-Correlation-ID'))
        <div class="mb-8 p-4 bg-gray-100 rounded-lg inline-block">
            <p class="text-sm text-gray-600">
                <span class="font-medium">Correlation ID:</span>
                <code class="ml-2 text-gray-800">{{ $correlationId ?? request()->header('X-Correlation-ID') }}</code>
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Please include this ID when reporting the issue.
            </p>
        </div>
    @endif

    <div class="flex justify-center space-x-4">
        <a href="{{ route('home') }}"
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Return Home
        </a>
        <button onclick="window.location.reload()"
                class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Try Again
        </button>
    </div>
</div>
@endsection
