<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuentaEgreso;

class CuentaEgresoController extends Controller
{
    protected function guardarGasto(Request $request){

        $id_articulo =  $request->articulo;
        $id_cuenta_bancaria =  $request->cuentaBancaria;
        $monto =  $request->montoPago;
        $fecha = $request->fechaPago;
        $observacion = $request->observacionPago;
        $id_user = $request->userId;
        $id_gestion = $request->gestion;
        $id_tipo_pago = $request->tipoPago;
        $nro_recibo = $request->reciboPago;
        $nro_recibo_tesorera = $request->reciboTesoreraPago;

        $gasto = CuentaEgreso::create([
            "id_articulo" => $id_articulo,
            "id_cuenta_bancaria" => $id_cuenta_bancaria,
            "id_gestion" => $id_gestion,
            "id_tipopago" => $id_tipo_pago,
            "monto_gasto" => $monto,
            "nro_recibo" => $nro_recibo,
            "nro_recibo_tesorera" => $nro_recibo_tesorera,
            "observacion" => $observacion,
            "fecha_gasto" => $fecha,
            "id_usuario" => $id_user
        ]);
        if($gasto->save()){
            return response()->json("success", 200);
        }else{
            return response()->json("error", 200);
        }
    }
}
