@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Personas</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-primary-fondo">
                        <div class="card-body mx-auto">
                            <div class="row">
                                <div class="col-md-7">
                                    @can('crear-persona')
                                        <a class="btn btn-small btn-primary" href="{{route('persona.create')}}"><i class="fas fa-plus"></i></a>
                                    @endcan
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text btn-success border-0" id="basic-addon1"><i class="fas fa-search"></i></span>
                                        </div>
                                            <input type="search" id="buscadorPersonaCi" class="form-control" placeholder="CI" aria-label="CI" aria-describedby="basic-addon1">
                                        </div>
                                </div>
                            </div>
                            <table class="table table-responsive table-striped mt-2">
                                <thead class="text-center bg-primary-gaia-rgba text-white">
                                    <tr>
                                        <th style="display: none">ID</th>
                                        <th class="text-white">NOMBRE</th>
                                        <th class="text-white">APELLIDO</th>
                                        <th class="text-white">CI</th>
                                        <th class="text-white">COMPLEMENTO CI</th>
                                        <th class="text-white">TELEFONO</th>
                                        <th class="text-white">TELEFONO 2</th>
                                        <th class="text-white">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody id="resultadoBusquedaPersona">
                                    @foreach ($personas as $persona)
                                    <tr>
                                        <td style="display: none">{{$persona->id}}</td>
                                        <td>{{$persona->nombre_pers}}</td>
                                        <td>{{$persona->apellido_pers}}</td>
                                        <td>{{$persona->ci_pers}}</td>
                                        <td>{{$persona->complemento_ci_pers}}</td>
                                        <td>{{$persona->telefono_pers}}</td>
                                        <td>{{$persona->telefono2_pers}}</td>
                                        <td class="text-center">
                                            <a class='btn btn-sm btn-primary' href="{{route('persona.show', $persona->id)}}"><i class="fas fa-eye"></i></a>
                                            @can('editar-persona')
                                                <a class="btn btn-sm btn-warning" href="{{ route('persona.edit', $persona->id)}}"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('borrar-persona')
                                                @if ($persona->estado_pers == 1)
                                                <a class='btn btn-sm btn-danger' href="{{route('persona.updateState', $persona->id)}}" onclick="return confirmDelete(event, this)"><i class='fas fa-trash-alt'></i></a>
                                                @else
                                                <a class='btn btn-sm btn-primary' href="{{route('persona.updateState', $persona->id)}}" onclick="return confirmReset(event, this)"><i class="fas fa-history"></i></a>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <span id="global" data-url="{{ URL::to('/') }}" data-CSRF="{{ csrf_token() }}"></span>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $personas->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/persona/index.js')}}"></script>
@endsection
