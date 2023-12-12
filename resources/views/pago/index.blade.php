@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Pago</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-end">
                                <div class="col-md-4">
                                    <div id="containerSocio" class="input-group mb-3 d-none">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text btn-primary" id="basic-addon1"><i class="fas fa-search text-white"></i></span>
                                        </div>
                                        <input type="search" class="form-control" placeholder="Buscar socio" id="buscarSocio">
                                    </div>
                                </div>
                                <div id="containerTableSocio" class="col-md-12 d-none">
                                    <table class="table table-sm table-bordered table-hover">
                                        <thead class="bg-primary-gaia-rgba text-white">
                                            <tr class="text-center">
                                                <td>NOMBRE SOCIO</td>
                                                <td>CI</td>
                                                <td>OPCIONES</td>
                                            </tr>
                                        </thead>
                                        <tbody id="resultadoSocio"></tbody>
                                    </table>
                                </div>
                            </div>
                        <form id="formularioPago" autocomplete="off">
                            @error('cuentaBancaria')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                {{-- campo del socio ide --}}
                                <input type="number" min="1"  id="idSocio" name="idSocio" class="d-none">

                                <div class="col-md-4">
                                    <label for="CuentaContable">Cuenta Contable</label>
                                    <select name="cuentaContable" id="cuentaContable" class="select2 form-control" data-placeholder="Seleccionar Cuenta" required>
                                        <option value=""></option>
                                        @foreach ($cuentas_contable as $cuenta_contable)
                                            <option value="{{$cuenta_contable->id}}">{{$cuenta_contable->nombre_cuenta}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="Articulo">Nro de partida:*</label>
                                    <select name="articulo" id="articulo" class="form-control select2" data-placeholder="Seleccionar Articulo" required>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="Articulo">Monto Pago</label>
                                    <input type="text" class="form-control" name="montoPago" id="montoPago" required>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <label for="">Recibo:*</label>   
                                    <input type="number" name="reciboPago" id="reciboPago" class="form-control" required>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <label for="">Fecha</label>   
                                    <input type="date" name="fechaPago" id="fechaPago" class="form-control" required>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <label for="">Recibo Tesorera:*</label>   
                                    <input type="number" name="reciboTesoreraPago" id="reciboTesoreraPago" class="form-control" required>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <label for="cuentaBancaria">Cuenta Bancaria</label>
                                    <select name="cuentaBancaria" id="cuentaBancaria" class="form-control" required>
                                        <option value="0" selected>Seleccionar</option>
                                        @foreach ($cuentas_bancarias as $cuenta_bancaria)
                                            <option value="{{$cuenta_bancaria->id}}">{{$cuenta_bancaria->nombre_cuenta." - ". $cuenta_bancaria->numero_cuenta}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md-4 mt-4">
                                    <label for="Monto">Monto</label>
                                    <input type="number" class="form-control" name="montoPago" id="montoPago" min="1" required>
                                </div> --}}
                                <div class="col-md-3 mt-4">
                                    <label for="Monto">Gestion</label>
                                    <select name="gestion" id="gestion" class="form-control select2" data-placeholder="Seleccionar" required>
                                        <option value=""></option>
                                        @foreach ($gestiones as $gestion)
                                            <option value="{{$gestion->id}}">{{$gestion->anio_gest}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mt-4">
                                    <label for="Monto">Tipo pago</label>
                                    <select name="tipoPago" id="tipoPago" class="form-control select2" data-placeholder="Seleccionar" required>
                                        <option value=""></option>
                                        @foreach ($tipo_pagos as $tipo_pago)
                                            <option value="{{$tipo_pago->id}}">{{$tipo_pago->nombre_tpago}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md-2 mt-4">
                                    <label for="Monto">Saldo a favor</label>
                                    <select name="cuentaSocio" id="cuentaSocio" class="form-control select2" data-placeholder="Seleccionar">
                                        <option value=""></option>
                                    </select>
                                </div> --}}

                                <div class="col-md-12 mt-4">
                                    <label for="Observación">Observación</label>
                                    <textarea class="form-control h-100" name="observacionPago" id="observacionPago"></textarea>
                                </div>
                                <div class="col-md-2 mt-5">
                                    <button type="submit" class="btn btn-sm bt-block btn-success">Guardar Pago</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
@include("deuda.modal.registrar");

@endsection
@section('scripts')
    <script src="{{ asset('assets/js/pago/index.js')}}" type="module"></script>
@endsection
