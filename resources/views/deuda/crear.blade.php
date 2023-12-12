@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading font-italic">Crear Deuda</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <h1></h1>
            <div class="col-lg-12">
                <div class="card bg-primary-fondo">
                    <div class="card-body mx-auto w-100">
                        <form id="formularioNuevaDeuda">
                            <div class="row mx-auto">
                                <div class="col-md-12">
                                    <label for="">Buscar Socio: </label>
                                    <select name="socio" id="socioNuevaDeuda" class="form-control select2"  data-placeholder="Buscar..." required>
                                    </select>
                                </div>
                                {{-- <div class="col-md-12">
                                    <input type="text" id="montoTotalDeuda" class="form-control form-control-sm">
                                </div> --}}
                                <div class="col-md-6 mt-2">
                                    <label for="">Nro de Partida:*</label>
                                    <select name="articulo"  class="form-control select2" data-placeholder="Seleccionar" required>
                                        <option value=""></option>
                                        @foreach ($articulos as $articulo)
                                            <option value="{{$articulo->id}}">{{$articulo->nombre_art}} - {{$articulo->monto_art}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                <div class="col-md-6 mt-2">
                                    <label for="">Fecha Pago:*</label>
                                    <input type="date" name="fechaPagoDeuda" class="form-control" placeholder="Fecha Pago">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Tipo pago:*</label>
                                    <select name="tipoPago" class="form-control select2" data-placeholder="Seleccionar" required>
                                        <option value=""></option>
                                        @foreach ($tipo_pagos as $tipo_pago)
                                            <option value="{{$tipo_pago->id}}">{{$tipo_pago->nombre_tpago}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                <div class="col-md-6 mt-3">
                                    <label for="">Cuenta Bancaria:*</label>
                                    {{-- <input type="text" id="cuentaBancariaDeuda" class="form-control form-control-sm" required> --}}
                                    <select name="cuentaBancaria" class="form-control" required>
                                        <option value="0" selected>Seleccionar</option>
                                        @foreach ($cuentas_bancarias as $cuenta_bancaria)
                                            <option value="{{$cuenta_bancaria->id}}">{{$cuenta_bancaria->nombre_cuenta." - ". $cuenta_bancaria->numero_cuenta}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label for="">Observación:*</label>
                                    <textarea name="observacion" class="form-control h-50"></textarea>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/deuda/create.js') }}" type="module"></script>
@endsection