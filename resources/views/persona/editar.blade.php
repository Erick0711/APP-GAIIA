@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header d-flex justify-content-between">
            <a class="btn btn-small btn-primary" href="{{ route('persona.index') }}"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <h3 class="mt-5 text-center page__heading">ACTUALIZAR PERSONA</h3>
                        <div class="card-body">
                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <strong>Revise los campos</strong>
                                    @foreach ($errors as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span arial-hidden>&times;</span>
                                    </button>
                                </div>
                            @endif

                            {!! Form::model($persona, ['method' => 'PUT', 'route' => ['persona.update', $persona->id]]) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="Nombre">NOMBRE:</label>
                                            {!! Form::text('nombre_pers', null, ['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="apellido">APELLIDO:</label>
                                            {!! Form::text('apellido_pers', null,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="ci">CI:</label>
                                            {!! Form::text('ci_pers', null,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="complemento">COMPLEMENTO CI:</label>
                                            {!! Form::text('complemento_ci_pers', null,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="correoPers">CORREO:</label>
                                            {!! Form::email('correo_pers', null,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="fechaNac">FECHA NACIMIENTO:</label>
                                            {!! Form::date('fecha_nac_pers', null,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="telefono">TELÉFONO:</label>
                                            {!! Form::text('telefono_pers', null,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="telefono2">TELÉFONO 2:</label>
                                            {!! Form::text('telefono2_pers', null,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
