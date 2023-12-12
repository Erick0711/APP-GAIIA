<?php

namespace App\Http\Controllers;

use App\Models\Cobranza;
use Illuminate\Http\Request;

class CobranzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cobranzas = Cobranza::join("socio", "cobranza.id_socio", "=", "socio.id")
                            ->join('tipo_cobranza', "cobranza.id_tipocobranza", "=", "tipo_cobranza.id")
                            ->join("persona", "socio.id_persona", "=", "persona.id")
                            ->join("cargo", "socio.id_cargo", "=", "cargo.id")
                            ->join("articulo", "cobranza.id_articulo", "=", "articulo.id")
                            ->join("tipo_articulo", "articulo.id_tipoart", "=", "tipo_articulo.id")
                            ->select("persona.nombre_pers", "persona.apellido_pers", "cargo.nombre_carg", "articulo.nombre_art","articulo.monto_art","articulo.monto_art","tipo_articulo.nombre_tipoart","tipo_cobranza.nombre_tc","socio.fecha_ingreso_soc", "socio.id", "estado_cobranza")
                            ->paginate(5);
        // $cobranzas = Cobranza::paginate(5);
        return view("cobranza.index", compact('cobranzas'));
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
     * @param  \App\Models\Cobranza  $cobranza
     * @return \Illuminate\Http\Response
     */
    public function show(Cobranza $cobranza)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cobranza  $cobranza
     * @return \Illuminate\Http\Response
     */
    public function edit(Cobranza $cobranza)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cobranza  $cobranza
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cobranza $cobranza)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cobranza  $cobranza
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cobranza $cobranza)
    {
        //
    }
}
