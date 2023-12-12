@extends('layouts.app')


@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading font-italic">Deuda Socio</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-primary-fondo">
                    <div class="card-body mx-auto w-100">
                        <div class="row flex justify-content-between">
                            {{-- <div class="col-md-7">
                                @can('crear-persona')
                                    <a class="btn btn-small btn-primary" href="{{route('persona.create')}}"><i class="fas fa-plus"></i></a>
                                @endcan
                            </div> --}}
                            <div class="col-md-1">
                                <a href="{{ route('deuda.create') }}" class="btn btn-success" id="nuevaDeuda"><i class="fas fa-plus"></i></a>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text btn-success border-0" id="basic-addon1"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="search" id="buscarDeuda" class="form-control" placeholder="Buscar deuda" aria-label="Deuda" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <table class="table table-sm table-bordered table-responsive-sm table-striped mt-2">
                            <thead class="text-center bg-primary-gaia-rgba text-white">
                                <tr>
                                    <th class="text-white">SOCIO</th>
                                    <th class="text-white">CI</th>
                                    <th class="text-white">NRO DE PARTIDA</th>
                                    <th class="text-white">MONTO</th>
                                    <th class="text-white">GESTION</th>
                                    <th class="text-white">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="resultadoBusquedaDeuda" class="text-center align-middle">
                                @foreach ($deudores as $deudor)
                                <tr>
                                    {{-- <td style="display: none">{{$deudor->id}}</td> --}}
                                    <td class="align-middle">{{$deudor->socio->persona->nombre_pers}} {{$deudor->socio->persona->apellido_pers}}</td>
                                    <td  class="align-middle">{{$deudor->socio->persona->ci_pers}}</td>
                                    <td  class="align-middle">{{$deudor->articulo->nombre_art}}</td>
                                    <td  class="align-middle">{{$deudor->articulo->monto_art}}</td>
                                    <td  class="align-middle">{{$deudor->gestion->anio_gest}}</td>

                                    <td class="text-center align-middle">
                                            <button class="btn btn-xs btn-success pagarDeuda" data-socio="{{$deudor->socio->id}}"><i class="fas fa-dollar-sign"></i></button>
                                            {{-- <a class='btn btn-sm btn-danger' href="{{route('persona.updateState', $deudor->id)}}" onclick="return confirmDelete(event, this)"><i class='fas fa-trash-alt'></i></a> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            {{-- <span id="global" data-url="{{ URL::to('/') }}" data-CSRF="{{ csrf_token() }}"></span> --}}
                        </table>
                        <div class="pagination justify-content-end">
                            {!! $deudores->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('deuda.modal.registrar')

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/deuda/index.js') }}" type="module"></script>
@endsection