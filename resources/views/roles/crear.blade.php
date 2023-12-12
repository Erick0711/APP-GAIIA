@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear Rol</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
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

                            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">ROL</label>
                                            {!! Form::text('name', null, ['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">PERMISOS</label>
                                            @foreach ($permisos as $permiso)
                                            <br>
                                                <label for="">
                                                    {!! Form::checkbox('permission[]', $permiso->id , false, ['class'=>'name'])!!}
                                                    {{$permiso->name}}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
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
