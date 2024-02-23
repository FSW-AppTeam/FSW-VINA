@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                @livewire('survey-student-details', compact('surveystudent'))
            </div>
            <div class="col-md-5">
                <h4>Related survey</h4> {{$surveystudent->survey}}
            </div>
        </div>
    </div>
@endsection
