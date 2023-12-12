<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\CuentaBancaria;
use App\Models\CuentaContable;
use Illuminate\Http\Request;
use App\Models\Deuda;
use App\Models\Gestion;
use App\Models\Pago;
use App\Models\TipoPago;
use Symfony\Component\Console\Input\Input;

class DeudaController extends Controller
{
    

    public function index(){

        $deudores = Deuda::select('id', 'id_socio', 'id_articulo', 'id_gestion')
                            ->where("estado_deuda", 1)
                            ->with([
                                'socio:id,id_persona,id_cargo',
                                'socio.persona:id,nombre_pers,apellido_pers,ci_pers',
                                'articulo:id,nombre_art,monto_art',
                                'gestion:id,anio_gest'
                            ])
                            ->paginate(10);

        $cuenta_contable = CuentaContable::select("id", "nombre_cuenta")->where("estado_cuenta", 1)->get();
        $cuenta_bancaria = CuentaBancaria::select("id", "numero_cuenta","nombre_cuenta")->where("estado_cuenta", 1)->get();
        $gestiones = Gestion::select("id", "anio_gest")->where("estado_gest", 1)->orderBy('id','desc')->get();
        $tipo_pagos = TipoPago::select("id", "nombre_tpago")->where("estado_tpago", 1)->get();

        $dato = [
            'deudores' => $deudores,
            "cuentas_contable" => $cuenta_contable,
            "cuentas_bancarias" => $cuenta_bancaria,
            "gestiones" => $gestiones,
            "tipo_pagos" => $tipo_pagos
        ];
            // return $deudores;
        return view('deuda.index')->with($dato);
    }
    // $socios = Socio::select("id","id_persona", "id_cargo", "fecha_ingreso_soc")->where("estado_soc", 1)
    // ->with("cargo:id,nombre_carg")
    // ->with("persona:id,nombre_pers,apellido_pers,ci_pers,correo_pers")
    // ->get();

    public function buscarDeuda(Request $request){
        $input = $request->input("buscarDeuda");


        $socios = Deuda::select('id', 'id_socio', 'id_articulo', 'id_gestion')
                    ->where("estado_deuda", 1)
                    ->whereHas("socio.persona", function ($query) use ($input) {
                        // Buscamos al socio por CI, NOMBRE, APELLIDO
                        $query->where('ci_pers', 'LIKE', $input.'%')
                            ->orWhere('nombre_pers', 'LIKE', '%' . $input . '%')
                            ->orWhere('apellido_pers', 'LIKE', '%' . $input . '%');
                    })
                    ->with([
                        'socio:id,id_persona,id_cargo',
                        'socio.persona:id,nombre_pers,apellido_pers,ci_pers',
                        'articulo:id,nombre_art,monto_art',
                        'gestion:id,anio_gest'
                    ])
                    ->limit(10)
                    ->get();

        return response()->json($socios, 200);
    }

    public function buscarDeudaSocio(Request $request){
        $id_socio = $request->idSocio;

        if (!empty($id_socio)) {
            $deudas = Deuda::select("id", "id_socio", "id_articulo", "id_gestion")
                ->where("id_socio", $id_socio)
                ->where("estado_deuda", 1)
                ->with([
                    'socio' => function ($query) {
                        $query->select('id', 'id_persona', 'id_cargo');
                    },
                    'socio.persona:id,nombre_pers,apellido_pers,ci_pers'
                ])
                ->with("articulo:id,nombre_art,monto_art")
                ->with("gestion:id,anio_gest")
                ->get();
        
            foreach ($deudas as $deuda) {
        
                $pago_deuda = Pago::selectRaw('SUM(monto_pago) as total_pago')
                    ->where('id_deuda', $deuda->id)
                    ->where('estado_pag', 1)
                    ->groupBy('id_deuda')
                    ->first();
        
                // No es necesario verificar count() en $pago_deuda, ya que es un objeto
        
                if ($pago_deuda) {
                    $monto_restante = $deuda->articulo->monto_art - $pago_deuda->total_pago;
                } else {
                    $monto_restante = $deuda->articulo->monto_art;
                }
        
                // Actualizamos el monto restante en el objeto $deuda actual
                $deuda->articulo->monto_art = $monto_restante;
            }
        
            if ($deudas->count() > 0) {
                $data = [
                    "deudas" => $deudas,
                    "message" => "success"
                ];
                return response()->json($data, 200);
            } else {
                $message = "empty";
                return response()->json($message, 200);
            }
        }
        
    }
    
    public function pagarDeuda(Request $request){

        // $date = Carbon::now();
        $deudas = json_decode($request->input('id_deuda'), true);
        $cuenta_bancaria = $request->id_cuenta_bancaria;
        $tipo_pago = $request->id_tipoPago;
        $observacionDeuda = $request->observacionDeuda;
        $fechaPagoDeuda = $request->fechaPagoDeuda;
        $id_user = $request->id_user;

        // if(!isset($observacionDeuda) || empty($observacionDeuda)){
        //     $observacionDeuda = null;
        // }

        foreach($deudas as $deuda){
            $dato_deuda = Deuda::select("id","id_socio","id_articulo","id_gestion")
                        ->where("estado_deuda", 1)
                        ->where("id", $deuda)
                        ->with("articulo:id,monto_art")
                        ->first();
            
            if($dato_deuda->count() > 0){
                $estado_deuda = Deuda::where("id", $deuda)->where("estado_deuda", 1)->update(["estado_deuda" => 0]);
                if($estado_deuda){
                    // foreach($dato_deuda as $dato){
                    $pagoDeuda = Pago::create([
                        "id_socio" => $dato_deuda->id_socio,
                        "id_gestion" => $dato_deuda->id_gestion,
                        "id_articulo" => $dato_deuda->id_articulo,
                        "id_cuenta_bancaria" => $cuenta_bancaria,
                        "monto_pago" => $dato_deuda->articulo->monto_art,
                        "id_tipopago" => $tipo_pago,
                        "observacion" => $observacionDeuda,
                        "fecha_pago" => $fechaPagoDeuda,
                        "id_deuda" => $deuda,
                        "id_usuario" => $id_user
                    ]);
                    if($pagoDeuda->save()){
                        $message = "success";
                    }else{
                        $message = "error";
                        break;
                    }
                }
            }
        }

        return response()->json(['message' => $message], 200);
    }

    public function create(){
        $cuenta_contable = CuentaContable::select("id", "nombre_cuenta")->where("estado_cuenta", 1)->get();
        $cuenta_bancaria = CuentaBancaria::select("id", "numero_cuenta","nombre_cuenta")->where("estado_cuenta", 1)->get();
        $gestiones = Gestion::select("id", "anio_gest")->where("estado_gest", 1)->orderBy('id','desc')->get();
        $tipo_pagos = TipoPago::select("id", "nombre_tpago")->where("estado_tpago", 1)->get();
        $articulos = Articulo::select("id", "nombre_art", "monto_art")->where("estado_art", 1)->get();
        $dato = [
            "cuentas_contable" => $cuenta_contable,
            "cuentas_bancarias" => $cuenta_bancaria,
            "gestiones" => $gestiones,
            "tipo_pagos" => $tipo_pagos,
            "articulos" => $articulos
        ];
            // return $deudores;
        return view('deuda.crear')->with($dato);
    }

    public function prueba(Request $request){
        $searchTerm = $request->input('searchTerm');
        return response()->json($searchTerm);
    }
    
    public function store(Request $request)
    {
        $input = $request->input();
        return response()->json($request, 200);
    }
}
