@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                @livewire('survey-answers-details', compact('surveyanswers'))
            </div>
            <div class="col-md-5">
                
            </div>
        </div>
    </div>
@endsection
