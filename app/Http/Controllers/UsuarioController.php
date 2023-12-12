<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Persona;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:ver-usuario|crear-usuario|editar-usuario|borrar-usuario', ['only'=>['index']]);
        $this->middleware('permission:crear-usuario', ['only'=>['create','store']]);
        $this->middleware('permission:editar-usuario', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-usuario', ['only'=>['destroy']]);
    }

    public function index()
    {
        // $usuarios = User::join('persona', 'persona.id', '=', 'users.id_persona')
        //                     ->select('persona.nombre_pers','persona.apellido_pers','users.*')
        //                     ->paginate(5);
        $usuarios = User::with('persona:id,nombre_pers,apellido_pers')->select("id","id_persona","email","avatar_url")->paginate(5);

        return view('usuarios.index', compact('usuarios'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas = Persona::select('id','nombre_pers','apellido_pers','ci_pers')->get();
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.crear', compact('roles', 'personas'));
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
            'id_persona' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('usuarios.index')->with('message');
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
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('usuarios.editar',compact('user','roles','userRole'));
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
        // TODO => HUBO UN ERROR AL NO COLOCAR UNA COMA EN EL EMAIL ES DECIR ESTABA ASI email' => 'required|email|unique:users,email'.$id,
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index');
    }

    public function editProfile(Request $request, $id)
    {
        $file = $request->file('photo');
        $id = $request->id;
        $nombreFoto = $file ? $file->getClientOriginalName() : null;

        $this->validate($request, [
            'nombre_pers' => 'required',
            'apellido_pers' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user = User::find($id);
        $id_persona = $user->id_persona;
        $persona = Persona::find($id_persona);
        $persona->nombre_pers = $request->nombre_pers;
        $persona->apellido_pers = $request->apellido_pers;
        $persona->save();

        $user->email = $request->email;

        if (!empty($nombreFoto) && is_uploaded_file($file->getPathname())) {
            $foto_date = date('d-m-Y-H')."-".$nombreFoto;
            $file->storeAs('public/img', $foto_date);
            $user->avatar_url = $foto_date;
        }
        $user->save();
    }

    public function obtenerUsuario(Request $request)
    {
        // response()->json($request);
        $id = $request->id;


        $usuario = User::with(["persona" => function ($query) use ($id) {
            $query->where("id", $id)->select("id", "nombre_pers", "apellido_pers", "ci_pers");
        }])
        ->select("id", "id_persona", "email", "avatar_url")
        ->first();
        // $usuario = User::join('persona', 'persona.id', '=', 'users.id_persona')
        //                     ->select('users.id','persona.nombre_pers','persona.apellido_pers','users.email', 'users.avatar_url')
        //                     ->where('users.id_persona', $id)
        //                     ->first();

                // $usuario = User::with("persona:id,nombre_pers,apellido_pers")
        //                 ->select("id", "id_persona", "email", "avatar_url")
        //                 ->where('id_persona', $id)
        //                 ->first();

        // $usuarios = User::with('persona:id,nombre_pers,apellido_pers')->select("id","id_persona","email","avatar_url")->paginate(5);


        return response()->json($usuario);
    }
}
