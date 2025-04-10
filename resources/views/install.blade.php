@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{langDatabase('app.install_question_set')}}</div>
                    <div class="card-body">{{langDatabase('app.install_question_set_instruction')}}
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
                                                <option value="" disabled selected>@langDatabase({{'app.select_questions_set'}})</option>
                                                @foreach($options as $key => $row)
                                                    <option value="{{$key}}"  {{old('questionsSet')==$key?'selected="selected"':''}}> {{$row}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-outline-info btn-sm">
                                                {{ langDatabase('app.install_questions_set') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()

