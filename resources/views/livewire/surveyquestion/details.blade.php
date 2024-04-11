@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                @livewire('survey-question-details', compact('surveyquestion'))
            </div>
            <div class="col-md-5">
                
            </div>
        </div>
    </div>
@endsection
