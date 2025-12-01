@extends('layouts.app')

@section('title', 'Page Not Found - D&D Character Creator')

@section('content')
<div class="max-w-2xl mx-auto text-center py-16">
    <div class="mb-8">
        <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
    <p class="text-gray-600 mb-8">
        The page you're looking for seems to have wandered off into the Shadowfell.
        Perhaps it failed its saving throw.
    </p>

    <div class="flex justify-center space-x-4">
        <a href="{{ route('home') }}"
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Return Home
        </a>
        <a href="{{ route('characters.index') }}"
           class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
            View Characters
        </a>
    </div>
</div>
@endsection
