@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Your SurveyAnswerss</h3>
                @livewire('survey-answers-table')
            </div>
        </div>
    </div>
@endsection
