<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Socio;
use App\Models\Articulo;
use App\Models\CuentaContable;
use App\Models\CuentaBancaria;
use App\Models\Gestion;
use App\Models\User;
use App\Models\CuentaEgreso;
use App\Models\CuentaIngreso;
use App\Models\CuentaSocio;
use App\Models\Deuda;
use App\Models\RegistroContable;
use App\Models\TipoPago;


use Illuminate\Http\Request;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuenta_contable = CuentaContable::select("id", "nombre_cuenta")->where("estado_cuenta", 1)->get();
        $cuenta_bancaria = CuentaBancaria::select("id", "numero_cuenta","nombre_cuenta")->where("estado_cuenta", 1)->get();
        $gestiones = Gestion::select("id", "anio_gest")->where("estado_gest", 1)->orderBy('id','desc')->get();
        $tipo_pagos = TipoPago::select("id", "nombre_tpago")->where("estado_tpago", 1)->get();

        $dato = [
            "cuentas_contable" => $cuenta_contable,
            "cuentas_bancarias" => $cuenta_bancaria,  
            "gestiones" => $gestiones,
            "tipo_pagos" => $tipo_pagos
        ];
        return view("pago.index")->with($dato);
    }

    protected function guardarPago(Request $request){

            $id_articulo =  $request->articulo;
            $id_cuenta_bancaria =  $request->cuentaBancaria;
            $monto =  $request->montoPago;
            $fecha = $request->fechaPago;
            $id_socio = $request->idSocio;
            $observacion = $request->observacionPago;
            $id_user = $request->userId;
            $id_gestion = $request->gestion;
            $id_tipo_pago = $request->tipoPago;
            $nro_recibo = $request->reciboPago;
            $nro_recibo_tesorera = $request->reciboTesoreraPago;
            $id_cuenta_contable = $request->cuentaContable;
            // $id_cuenta_socio = $request->cuentaSocio;

            // if(isset($id_cuenta_socio) && !empty($id_cuenta_socio)){

            // }
            $buscar_deuda = Deuda::select('id', 'id_socio', 'id_gestion', 'id_articulo')
                            ->where("id_socio", $id_socio)
                            ->where("id_articulo", $id_articulo)
                            ->where("estado_deuda", 1)
                            ->with([
                                'articulo:id,nombre_art,monto_art',
                            ])
                            ->orderBy("id", "desc")
                            ->first();

            // insertar el registro contable y verificar el conteo
            $buscar_registro_contable = RegistroContable::select('nro_registro_contable')
                                                        ->where('id_cuentabancaria', $id_cuenta_bancaria)
                                                        ->where('id_cuentacontable', $id_cuenta_contable)
                                                        ->where('id_gestion', $id_gestion)
                                                        ->where('estado', 1)
                                                        ->orderBy('id','desc')
                                                        ->first();
            // $insertar = []

            $nro_registro_contable = 1;

            if($this->is_not_empty($buscar_registro_contable))
            {
                $nro_registro_contable += $buscar_registro_contable->nro_registro_contable;
            }

            $insertar = RegistroContable::create([
                'id_cuentabancaria' => $id_cuenta_bancaria,
                'id_cuentacontable' => $id_cuenta_contable,
                'id_gestion' => $id_gestion,
                'nro_registro_contable' => $nro_registro_contable
            ]);

            if($insertar){
                $id_insert_nro = $insertar->id;
            }else{
                return;
            }
            return response()->json($insertar, 200);

            if(isset($buscar_deuda) && !empty($buscar_deuda)){

                $deuda_id = $buscar_deuda->id;
                $monto_deuda = $buscar_deuda->articulo->monto_art;

                 //  * Buscamos los pagos relacionados con la deuda y el articulo
                $buscar_pago = Pago::select('monto_pago')->where('id_deuda', $deuda_id)->where('id_articulo', $buscar_deuda->articulo->id)->get();

                // * Si encuentra un pago entonses empezamos a sumar el monto total de ese pago
                $monto_total_pago = 0;

                if($buscar_pago->count() > 0){
                    foreach($buscar_pago as $pagos){
                        $monto_total_pago += $pagos->monto_pago;
                    }
                }

                // sacamos el saldo del monto pagado y del monto de la deuda
                $saldo_pago =  (intval($monto) + intval($monto_total_pago))  - intval($monto_deuda);
                

                if($saldo_pago >= 0){
                    $deuda_pagada = Deuda::where("id",$deuda_id)->update(['estado_deuda' => 0]);
                    if($deuda_pagada){
                        // deuda pagada
                        $pago = Pago::create([
                            "id_socio" => $id_socio,
                            "id_gestion" => $id_gestion,
                            "id_articulo" => $id_articulo,
                            "id_cuenta_bancaria" => $id_cuenta_bancaria,
                            "monto_pago" => $monto,
                            "nro_recibo" => $nro_recibo,
                            "nro_recibo_tesorera" => $nro_recibo_tesorera,
                            "id_tipopago" => $id_tipo_pago,
                            "observacion" => $observacion,
                            "fecha_pago" => $fecha,
                            'id_deuda' => $buscar_deuda->id,
                            "id_usuario" => $id_user
                        ]);
                        if($saldo_pago > 0){ 
                            // verificar si en el pago queda un saldo a favor del socio
                            $id_pago_cuenta = Articulo::select('id')->where('nombre_art', 'PAGO A CUENTA')->first();
                            $cuenta_contable = CuentaSocio::create([
                                "id_socio" => $id_socio,
                                "id_cuenta_bancaria" => $id_cuenta_bancaria,
                                "id_articulo" => $id_pago_cuenta->id,
                                'id_gestion' => $id_gestion,
                                "monto" => $saldo_pago,
                            ]);
                            $cuenta_contable->save();
                        }
                        if($pago->save()){
                            return response()->json("success", 200);
                        }else{
                            return response()->json("error", 200);
                        }
                    }
                }else{
                    // si no tiene deuda entonses se procede a guardar su pago
                    if(isset($id_socio) && !empty($id_socio)){
                        $pago = Pago::create([
                            "id_socio" => $id_socio,
                            "id_gestion" => $id_gestion,
                            "id_articulo" => $id_articulo,
                            "id_cuenta_bancaria" => $id_cuenta_bancaria,
                            "monto_pago" => $monto,
                            "nro_recibo" => $nro_recibo,
                            "nro_recibo_tesorera" => $nro_recibo_tesorera,
                            "id_tipopago" => $id_tipo_pago,
                            "observacion" => $observacion,
                            "fecha_pago" => $fecha,
                            'id_deuda' => $buscar_deuda->id,
                            "id_usuario" => $id_user
                        ]);
                        if($pago->save()){
                            return response()->json("success", 200);
                        }else{
                            return response()->json("error", 200);
                        }
                    }
                }
            }else{
                // si no existe ninguna deuda entonses procedemos a guardar el pago
                if(isset($id_socio) && !empty($id_socio)){
                    $pago = Pago::create([
                        "id_socio" => $id_socio,
                        "id_gestion" => $id_gestion,
                        "id_articulo" => $id_articulo,
                        "id_cuenta_bancaria" => $id_cuenta_bancaria,
                        "monto_pago" => $monto,
                        "nro_recibo" => $nro_recibo,
                        "nro_recibo_tesorera" => $nro_recibo_tesorera,
                        "id_tipopago" => $id_tipo_pago,
                        "observacion" => $observacion,
                        "fecha_pago" => $fecha,
                        "id_usuario" => $id_user
                    ]);
                    if($pago->save()){
                        return response()->json("success", 200);
                    }else{
                        return response()->json("error", 200);
                    }
                }
            }
        }


    public function obtenerArticulo(Request $request) {
        // $request->validate([
        //     'id_cuentaContable' => 'required',
        // ]);
        if (!$request->hasHeader('X-CSRF-TOKEN')) {
        }else{
            $id = $request->input('id_cuentaContable');

            $articulos = Articulo::select("id", "nombre_art", "monto_art")->where("estado_art", 1)->where("id_cuenta_contable", $id)->get();
    
            return response()->json($articulos, 200);
        }
    
    }
    
}
