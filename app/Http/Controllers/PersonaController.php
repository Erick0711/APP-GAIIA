<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\alert;
use App\Traits\Alerta;
use Barryvdh\DomPDF\Facade\Pdf;

class PersonaController extends Controller
{
    use Alerta;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:ver-persona|crear-persona|editar-persona|borrar-persona')->only('index');
        $this->middleware('permission:crear-persona', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-persona', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-persona', ['only' => ['destroy']]);
    }

    public function index()
    {
        $personas = Persona::latest()->paginate(7);
        return view('persona.index', compact('personas'));
    }

    public function create()
    {
        return view('persona.crear');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre_pers' => 'required|string|min:3',
            'apellido_pers' => 'required|string|min:3',
            'ci_pers' => 'required|string|min:6|max:15',
            'complemento_ci_pers' => 'string|nullable',
            'correo_pers' => 'email',
            'fecha_nac_pers' => 'required|date',
            'telefono_pers' => 'required|string|min:7|max:15',
            'telefono2_pers' => 'string|min:7|max:15'
        ]);

        $ci = $request->ci_pers;
        $complemento_ci_pers = $request->complemento_ci_pers;

        $filtro = Persona::where('ci_pers', $ci)->where('complemento_ci_pers', $complemento_ci_pers)->first();
        if (isset($filtro)) {
            return redirect()->route('persona.create');
        } else {
            $inputs = $request->all();
            $persona = Persona::create($inputs);
            if ($persona) {
                Alert::toast('Registrado Correctamente', 'success')
                    ->position('top-end')
                    ->autoClose(2000)
                    ->timerProgressBar(['color' => '#007bff']);
                return redirect()->route('persona.index');
            }
        }
    }


    public function show($id)
    {
        $persona = Persona::where("id", $id)->first();

        // $pago_anual = 
        return view("persona.ver", compact('persona'));
    }
    public function edit($id)
    {
        $persona = Persona::find($id);
        return view('persona.editar', compact('persona'));
    }


    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'nombre_pers' => 'required|string|min:3',
            'apellido_pers' => 'required|string|min:3',
            'ci_pers' => 'required|string|min:6|max:15',
            'complemento_ci_pers' => 'string|nullable',
            'correo_pers' => 'email',
            'fecha_nac_pers' => 'required|date',
            'telefono_pers' => 'required|string|min:7|max:15',
            'telefono2_pers' => 'required|string|min:7|max:15'
        ]);

        $input = $request->all();
        $persona = Persona::find($id);
        $persona->update($input);

        if ($persona) {
            return redirect()->route('persona.index');
        } else {
            return redirect()->route('persona.edit');
        }
    }

    public function updateState($id)
    {
        $estado_pers = Persona::where('id', $id)->select('estado_pers', 'id')->first();

        try {
            if ($estado_pers['estado_pers'] == 0) {
                Persona::where('id', $id)->update(['estado_pers' => 1]);
                $this->message('Restaurado Correctamente!', 'success');
                return redirect()->route('persona.index');
            } else {
                Persona::where('id', $id)->update(['estado_pers' => 0]);
                $this->message('Eliminado Correctamente!', 'success');
                return redirect()->route('persona.index');
            }
        } catch (\Throwable $err) {
            $this->message('Algo sucedio!', 'error');
            return redirect()->route('persona.index');
        }
    }

    public function buscarPersona(Request $request)
    {
        $request->validate([
            'ci_pers' => 'required',
        ]);

        $valorCi = $request->input('ci_pers');

        $valorci = strlen($valorCi) >= 1 ? $valorCi : 0; 

        if (!$request->hasHeader('X-CSRF-TOKEN')) {
            return redirect()->route('persona.index');
        } else {
            if ($valorCi > 0) 
            {
                $personas = Persona::where('ci_pers', 'LIKE', $valorCi . '%')->limit(10)->get();
                if (filled($personas)) 
                {
                    foreach ($personas as $persona) {
                        if ($persona->estado_pers == 0) {
                            $buttonState = "<a class='btn btn-sm btn-primary' href=" . route('persona.updateState', $persona->id) . "  onclick='return confirmReset(event, this)'><i class='fas fa-history'></i></a>";
                        } else if ($persona->estado_pers == 1) {
                            $buttonState = "<a class='btn btn-sm btn-danger' href=" . route('persona.updateState', $persona->id) . " onclick='return confirmDelete(event, this)'><i class='fas fa-trash-alt'></i></a>";
                        }
                        echo "<tr>
                        <td style='display: none'>$persona->id</td>
                        <td>$persona->nombre_pers</td>
                        <td>$persona->apellido_pers</td>
                        <td>$persona->ci_pers</td>
                        <td>$persona->complemento_ci_pers</td>
                        <td>$persona->telefono_pers</td>
                        <td>$persona->telefono2_pers</td>
                        <td class='text-center'>
                            <a class='btn btn-sm btn-warning' href=" . route('persona.edit', $persona->id) . "><i class='fas fa-edit'></i></a>
                            $buttonState
                        </td>
                    </tr>";
                    }
                } else {
                    echo "<tr>
                    <td colspan='8' class='text-center'>Ningun dato encontrado</td>
                </tr>";
                }
            } else if($valorCi == 0){
                echo "<tr>
                    <td colspan='8' class='text-center'>Recarga la pagina si deseas ver nuevamente todo los registros
                    <br>
                    <a class='btn btn-sm btn-primary' href='".route('persona.index')."'><i class='fas fa-home'></i><a></td>
                </tr>";
            }
        }
    }


    // PDF PERSONA
    public function generarPersonaPDF(){
        $personas = Persona::all();
        $pdf = Pdf::loadView('persona.PDF.persona', compact('personas'));
        return $pdf->stream();
    }
}
