<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\Persona;
use App\Models\Cargo;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:ver-socio|crear-socio|editar-socio|borrar-socio', ['only'=>['index']]);
        $this->middleware('permission:crear-socio', ['only'=>['create','store']]);
        $this->middleware('permission:editar-socio', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-socio', ['only'=>['destroy']]);
    }
    public function index()
    {
        // $socios = Socio::with('persona')->find(1);
        // $socios = Socio::join('persona', 'socio.id_persona', '=', 'persona.id')
        //                 ->join('cargo', 'socio.id_cargo', '=', 'cargo.id')
        //                 ->select('persona.nombre_pers','persona.apellido_pers', 'persona.correo_pers', 'cargo.nombre_carg', 'socio.fecha_ingreso_soc', 'socio.id','estado_soc')
        //                 ->get();

        $socios = Socio::select("id","id_persona", "id_cargo", "fecha_ingreso_soc")->where("estado_soc", 1)
                        ->with("cargo:id,nombre_carg")
                        ->with("persona:id,nombre_pers,apellido_pers,ci_pers,correo_pers")
                        ->get();
        // return $socios;
        return view('socio.index', compact('socios'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas = Persona::all();
        $cargos = Cargo::all();

        return view('socio.crear', compact('personas', 'cargos'));
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
            'id_cargo' => 'required|int|min:1',
            'id_persona' => 'required|int|min:1',
            'fecha_ingreso_soc' => 'date|required',
        ]);
        $persona = $request->id_persona;

        $filtro = Socio::where('id_persona', $persona)->first();
        // return $filtro;
        if(isset($filtro)){
            return redirect()->route('socio.create')->with('message', 'Esta persona ya se encuentra registrada');
        }else{
            $inputs = $request->all();
            $socio = Socio::create($inputs);
            if($socio){
                return redirect()->route('socio.index');
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
        // return view("persona.ver", compact('persona'));
        $socio = Socio::select("id","id_persona", "id_cargo", "fecha_ingreso_soc")
        ->where("estado_soc", 1)
        ->where("id", $id)
        ->with("cargo:id,nombre_carg")
        ->with("persona:id,nombre_pers,apellido_pers,ci_pers,correo_pers")
        ->first();

        $pagos = Pago::select('id_articulo', DB::raw('SUM(monto_pago) as total_pago'))
                ->where('id_socio', $id)
                ->groupBy('id_articulo')
                ->with(['articulo:id,id_gestion', 'articulo.gestion:id,numero_gest,anio_gest'])
                ->havingRaw('SUM(monto_pago) >= 500')
                ->get();

        // return $pagos;
        return view('socio.ver',['socio' => $socio, 'pagos' => $pagos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $socio = Socio::find($id);
        $persona = Persona::pluck('name')->all();
        $socioPersona = $socio->persona->pluck('id','id_persona')->all();
        return view('usuarios.editar',compact('user','roles','socioPersona'));
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

    public function buscarSocio(Request $request){

        if(empty($request->input("buscarSocio"))){
            $input = $request->input("searchTerm");
        }else{
            $input = $request->input("buscarSocio");
        }
        


        $socios = Socio::select("id","id_persona")->where("estado_soc", 1)
        ->whereHas("persona", function ($query) use ($input) {
            // buscamos al socio por => CI, NOMBRE, APELLIDO
            $query->where('ci_pers', 'LIKE', $input.'%')
            ->orWhere('nombre_pers', 'LIKE', '%' . $input . '%')
            ->orWhere('apellido_pers', 'LIKE', '%' . $input . '%');
        })
        ->with(["persona:id,nombre_pers,apellido_pers,ci_pers"])
        ->limit(10)
        ->get();

        return response()->json($socios, 200);
    }
}
