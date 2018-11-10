@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Import surveys</div>

                    <div class="card-body">
                        @if (session('import-status'))
                            <div class="alert alert-success">
                                {{ session('import-status') }}
                            </div>
                        @endif
                        {{ Form::open(['url' => route('import.store'), 'files' => true]) }}
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Survey file</label>

                            <div class="col-md-6">
                                {{ Form::file('survey-data', ['class' => 'form-control'.($errors->has('survey-data') ? ' is-invalid' : ''), 'required' => 'required']) }}

                                @if ($errors->has('survey-data'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('survey-data') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        {{ Form::close()  }}
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Import programs and faculties</div>

                    <div class="card-body">
                        @if (session('program-import-status'))
                            <div class="alert alert-success">
                                {{ session('program-import-status') }}
                            </div>
                        @endif
                        {{ Form::open(['url' => action('Import\ProgramController@import'), 'files' => true]) }}
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Data file</label>

                            <div class="col-md-6">
                                {{ Form::file('program-data', ['class' => 'form-control'.($errors->has('program-data') ? ' is-invalid' : ''), 'required' => 'required']) }}

                                @if ($errors->has('program-data'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('program-data') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        {{ Form::close()  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
