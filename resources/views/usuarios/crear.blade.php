@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear Usuario</h3>
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

                            {!! Form::open(['route' => 'usuarios.store', 'method' => 'POST']) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">Persona</label>
                                            <select class="form-control select2" name="id_persona" id="id_persona" class="select2" data-placeholder="Seleccionar">
                                                <option></option>
                                                @foreach ($personas as $persona)
                                                    <option value="{{$persona->id}}">{{$persona->nombre_pers}} {{$persona->apellido_pers}} - {{$persona->ci_pers}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">NOMBRE</label>
                                            {!! Form::text('name', null, ['class'=>'form-control'])!!}
                                        </div>
                                    </div> --}}
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="email">EMAIL</label>
                                            {!! Form::text('email', null, ['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="password">CONTRASEÑA</label>
                                            {!! Form::password('password', ['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            {!! Form::text('name', null, ['class'=>'form-control'])!!}
                                        </div>
                                    </div> --}}
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="confirm-password">CONFIRMAR CONTRASEÑA</label>
                                            {!! Form::password('confirm-password', ['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="roles">ROLES</label>
                                            {!! Form::select('roles[]', $roles,[], ['class'=>'form-control'])!!}
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
