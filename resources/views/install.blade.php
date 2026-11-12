@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{langDatabase('app.install_question_set')}}</div>
                    <div class="card-body">{{langDatabase('app.install_question_set_instruction')}}
                        @if (session('status'))
                            <div class="alert alert-success mt-3" role="status">{{ session('status') }}</div>
                        @endif
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form method="POST" action="{{ route('install') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <select id="questionsSet" class="basic-single-select form-select"
                                                    aria-label="Default select example"
                                                    name="questionsSet"
                                                    required>
                                                <option value="" disabled selected>@langDatabase('app.select_questions_set')</option>
                                                @foreach($options as $key => $row)
                                                    <option value="{{$key}}"  {{old('questionsSet')==$key?'selected="selected"':''}}> {{$row}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-outline-info btn-sm">
                                                {{ langDatabase('app.install_question_set') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @can('administrate')
                            <div class="card mt-4">
                                <div class="card-header">{{langDatabase('app.delete_survey')}}</div>
                                <div class="card-body">{{langDatabase('app.delete_survey_instruction')}}
                                    <form id="deleteSurveyForm" method="POST" action="{{ route('install-questions.delete') }}">
                                        @csrf
                                        <div class="row g-2">
                                            <div class="col-md-8">
                                                <select id="surveyToDelete" class="form-select" name="survey_id" required>
                                                    <option value="" selected disabled>Select a survey</option>
                                                    @foreach($surveys as $survey)
                                                        <option value="{{ $survey->id }}">{{ $survey->survey_code }}</option>
                                                    @endforeach
                                                    <option value="all">All surveys</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button type="button" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal" data-bs-target="#deleteSurveyConfirmation"
                                                        @disabled($surveys->isEmpty())>
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="modal fade" id="deleteSurveyConfirmation" tabindex="-1"
                                         aria-labelledby="deleteSurveyConfirmationLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteSurveyConfirmationLabel">Confirm survey deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure? The selected survey(s) and all their participant, answer, and friend data will be permanently deleted. The shared question set will remain.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" form="deleteSurveyForm" class="btn btn-danger">Accept</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
