@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                @livewire('user-details', compact('user'))
            </div>
            <div class="col-md-5">
                <h4>Related role</h4> {{$user->role}}
            </div>
        </div>
    </div>
@endsection
