@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Asociados</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body mx-auto">
                            <a class="btn btn-warning" href="{{route('socio.create')}}">Nuevo</a>
                            <table class="table table-responsive table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <tr>
                                        <th style="display: none">ID</th>
                                        <th style="color: white">NOMBRE</th>
                                        <th style="color: white">EMAIL</th>
                                        <th style="color: white">CARGO</th>
                                        {{-- <th style="color: white">GESTION</th> --}}
                                        <th style="color: white">FECHA INICIO</th>
                                        <th style="color: white">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($socios as $socio)
                                        <tr>
                                            <td style="display: none">{{$socio->id}}</td>
                                            <td>{{$socio->persona->nombre_pers}} {{$socio->persona->apellido}}</td>
                                            <td>{{$socio->persona->correo_pers}}</td>
                                            <td>{{$socio->cargo->nombre_carg}}</td>
                                            {{-- <td>{{$socio->anio_gest}}</td> --}}
                                            <td>{{$socio->fecha_ingreso_soc}}</td>
                                            <td class="text-center">
                                                    @can('editar-socio')
                                                    <a href="{{ route('socio.show', $socio->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                                    @endcan
                                                    @can('editar-socio')
                                                        <a href="{{ route('socio.edit', $socio->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                    @endcan
                                                    @can('borrar-socio')
                                                    {!! Form::open(['method'=> 'POST', 'route'=>['roles.destroy',$socio->id], 'style'=>'display:inline']) !!}
                                                        {!! Form::button('<i class="fas fa-trash-alt"></i>', ['class'=>'btn btn-sm btn-danger', 'type' => 'submit']) !!}
                                                    {!! Form::close() !!}
                                                    @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

