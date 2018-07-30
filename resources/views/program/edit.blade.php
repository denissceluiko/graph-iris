@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Rediģēt studiju programmu</div>

                    <div class="card-body">
                        {{ Form::model($program, ['route' => ['program.update', $program], 'method' => 'patch']) }}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Prorgrammas kods</label>
                            <div class="col-md-6">
                                {{ $program->id }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Prorgrammas nosaukums</label>

                            <div class="col-md-6">
                                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Saglabāt
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
