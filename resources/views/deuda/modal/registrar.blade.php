<div class="modal" id="registrarDeuda" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button  id="cerrarModalSocio" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h5 class="modal-title text-center" id="socioDeuda"></h5>
            {{-- <label class="btn btn-sm btn-danger text-center">Socio con deuda</label> --}}
            <div class="modal-body">
                <div class="row mx-auto">
                    <div class="col-md-12">
                        <table class="table table-sm table-bordered">
                            <thead class="table-dark table-sm text-center">
                                <tr>
                                    <th>ARTICULO</th>
                                    <th>MONTO</th>
                                    <th>GESTION</th>
                                    <th>OPCION</th>
                                </tr>
                            </thead>
                            <tbody id="deudaSocio"></tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <input type="text" id="montoTotalDeuda" class="form-control form-control-sm" disabled>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="">Fecha Pago:*</label>
                        <input type="date" id="fechaPagoDeuda" class="form-control" placeholder="Fecha Pago">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="">Tipo pago:*</label>
                        <select id="tipoPagoDeuda" class="form-control" required>
                            <option value="0" selected>Seleccionar</option>
                            @foreach ($tipo_pagos as $tipo_pago)
                                <option value="{{$tipo_pago->id}}">{{$tipo_pago->nombre_tpago}}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-md-12 mt-3">
                        <label for="">Cuenta Bancaria:*</label>
                        {{-- <input type="text" id="cuentaBancariaDeuda" class="form-control form-control-sm" required> --}}
                        <select id="cuentaBancariaDeuda" class="form-control" required>
                            <option value="0" selected>Seleccionar</option>
                            @foreach ($cuentas_bancarias as $cuenta_bancaria)
                                <option value="{{$cuenta_bancaria->id}}">{{$cuenta_bancaria->nombre_cuenta." - ". $cuenta_bancaria->numero_cuenta}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-4">
                        <label for="">Observación:*</label>
                        <textarea class="form-control h-50"  id="observacionDeuda"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" id="pagarDeuda" value="Pagara Deuda" />
            </div>
        </div>
    </div>
</div>
