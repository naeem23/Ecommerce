@extends('layouts.frontend.app')

@section('title', 'Index')

@section('content')
    
    <p>{{ Auth::user()->name }}</p>

@endsection