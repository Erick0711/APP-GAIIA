<?php

namespace App\Http\Controllers;

use App\Models\CuentaSocio;
use Illuminate\Http\Request;

class CuentaSocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function obtenerCuentaSocio(Request $request){
        $id_socio = $request->input('idSocio');
        $id_cuenta = $request->input('idCuentaBancaria');

        $total_cuenta = CuentaSocio::select('id','monto')
                        ->where('id_cuenta_bancaria', $id_cuenta)
                        ->where('id_socio', $id_socio)
                        ->where('estado', 1)
                        ->first();
        if(isset($total_cuenta) && !empty($total_cuenta)){
            return response()->json($total_cuenta, 200);
        }else{
            return response()->json("vacio", 200);
        }
    }
    public function obtenerMontoSocio(Request $request){
        $idCuentaSocio = CuentaSocio::select('monto')->where('estado', 1)->first();
        return response()->json($idCuentaSocio, 200);
    }
}
