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
                                    @can('crear-cobranza')
                                        <a class="btn btn-small btn-primary" href="{{route('cobranza.create')}}"><i class="fas fa-plus"></i></a>
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
                                        <th class="text-white">CARGO</th>
                                        <th class="text-white">ARTICULO</th>
                                        <th class="text-white">TIPO ARTICULO</th>
                                        <th class="text-white">TIPO COBRANZA</th>
                                        <th class="text-white">MONTO</th>

                                        <th class="text-white">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody id="resultadoBusquedaPersona">
                                    {{-- @php
                                        print_r($cobranzas);
                                    @endphp --}}
                                    @foreach ($cobranzas as $cobranza)
                                    <tr>
                                        <td style="display: none">{{$cobranza->id}}</td>
                                        <td>{{$cobranza->nombre_pers}}</td>
                                        <td>{{$cobranza->apellido_pers}}</td>
                                        <td>{{$cobranza->nombre_carg}}</td>
                                        <td>{{$cobranza->nombre_art}}</td>
                                        <td>{{$cobranza->nombre_tipoart}}</td>
                                        <td>{{$cobranza->nombre_tc}}</td>
                                        <td>{{$cobranza->monto_art}}</td>

                                        <td class="text-center">
                                            @can('editar-persona')
                                                <a class="btn btn-sm btn-warning" href="{{ route('persona.edit', $cobranza->id)}}"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('borrar-persona')
                                                @if ($cobranza->estado_cobranza == 1)
                                                <a class='btn btn-sm btn-danger' href="{{route('persona.updateState', $cobranza->id)}}" onclick="return confirmDelete(event, this)"><i class='fas fa-trash-alt'></i></a>
                                                @else
                                                <a class='btn btn-sm btn-primary' href="{{route('persona.updateState', $cobranza->id)}}" onclick="return confirmReset(event, this)"><i class="fas fa-history"></i></a>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <span id="global" data-url="{{ URL::to('/') }}" data-CSRF="{{ csrf_token() }}"></span>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $cobranzas->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
{{-- <script src="{{ asset('assets/js/persona/index.js')}}"></script> --}}
@endsection
