<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:ver-cargo|crear-cargo|editar-cargo|borrar-cargo')->only('index');
        $this->middleware('permission:crear-cargo', ['only'=>['create','store']]);
        $this->middleware('permission:editar-cargo', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-cargo', ['only'=>['destroy']]);
    }
    
    public function index()
    {
        $cargos = Cargo::all();
        return view('cargo.index', compact('cargos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cargo.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre_carg' => 'required|string|min:3',
        ]);
        $cargo = $request->nombre_carg;

        $filtro = Cargo::where('nombre_carg', $cargo)->first();
        if(isset($filtro)){
            return redirect()->route('cargo.create')->with('message', 'Esta persona ya se encuentra registrada');
        }else{
            $inputs = $request->all();
            $cargo = Cargo::create($inputs);
            if($cargo){
                return redirect()->route('cargo.index');
            }
        }
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
        $cargo = Cargo::find($id);
        return view('cargo.editar', compact('cargo'));
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
        $this->validate($request, [
            'nombre_carg' => 'required|string|min:3',
        ]);

        $cargo = Cargo::find($id);
        $input = $request->all();
        $cargo->update($input);
        if($cargo){
            return redirect()->route('cargo.index');
        }else{
            return redirect()->route('cargo.edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $persona = Cargo::where('id', $id)->update(['estado_carg' =>  0]);
        if($persona){
            return redirect()->route('cargo.index');
        }else{
            return redirect()->route('cargo.index');
        }
    }
}
