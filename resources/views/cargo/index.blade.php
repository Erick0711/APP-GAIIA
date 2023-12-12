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
                            <a class="btn btn-warning" href="{{route('cargo.create')}}">Nuevo</a>
                            <table class="table table-responsive table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <tr>
                                        <th style="display: none">ID</th>
                                        <th style="color: white">NOMBRE CARGO</th>
                                        <th style="color: white">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cargos as $cargo)
                                        <tr>
                                            <td style="display: none">{{$cargo->id}}</td>
                                            <td>{{$cargo->nombre_carg}}</td>
                                            <td class="text-center">
                                                @can('editar-cargo')
                                                    <a href="{{ route('cargo.edit', $cargo->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                @endcan
                                                @can('borrar-cargo')
                                                {!! Form::open(['method'=> 'DELETE', 'route'=>['cargo.destroy',$cargo->id], 'style'=>'display:inline']) !!}
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

