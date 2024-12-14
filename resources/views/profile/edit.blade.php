@extends('layouts.sidebar')

@section('admin-content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profile') }}
    </h2>
</x-slot>

@include('profile.partials.update-profile-information-form')

@endsection