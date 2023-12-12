@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Usuarios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <a class="btn btn-warning" href="{{route('usuarios.create')}}">Nuevo</a>
                            <table class="table table-responsive table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <tr>
                                        <th style="display: none">ID</th>
                                        <th style="color: white">NOMBRE</th>
                                        <th style="color: white">EMAIL</th>
                                        <th style="color: white">ROL</th>
                                        <th style="color: white">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td style="display: none">{{$usuario->id}}</td>
                                        <td>{{$usuario->persona->nombre_pers}} {{$usuario->persona->apellido_pers}}</td>
                                        <td>{{$usuario->email}}</td>
                                        <td>
                                            @if (!empty($usuario->roles))
                                                @foreach ($usuario->getRoleNames() as $rol)
                                                    <h5><span class="badge badge-dark">{{$rol}}</span></h5>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('usuarios.edit', $usuario->id)}}">Editar</a>

                                            {!! Form::open(['method'=> 'DELETE', 'route'=>['usuarios.destroy',$usuario->id], 'style'=>'display:inline']) !!}
                                                {!! Form::submit('Borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $usuarios->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

