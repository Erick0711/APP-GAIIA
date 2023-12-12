<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// AGREGAMOS ROLES PERMISOS

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Traits\Alerta;

class RolController extends Controller
{
    use Alerta;

    function __construct()
    {
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|borrar-rol', ['only'=>['index']]);
        $this->middleware('permission:crear-rol', ['only'=>['create','store']]);
        $this->middleware('permission:editar-rol', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-rol', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permisos = Permission::get();
        return view('roles.crear', compact('permisos'));
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
            'name' => 'required',
            'permission' => 'required',
        ]);
        try {
            $this->message('Rol creado exitosamente!', 'success');
            $role = Role::create(
                ['name' => $request->input('name')]
            );
            $role->syncPermissions($request->input('permission'));
    
            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            $this->message('algo sucedio!', 'error');
            return redirect()->route('roles.index');
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

    public function edit($id)
    {
        $role = Role::find($id);
        $permisos = Permission::get();
        $rolPermission = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
        ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
        ->all();
        return view('roles.editar', compact('role', 'permisos', 'rolPermission'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        try {
            if(isset($id) && !empty($id)){
                $role = Role::find($id);
                $role->name = $request->input('name');
                $role->save();
                $role->syncPermissions($request->input('permission'));
                $this->message('Actualizado Correctamente!', 'success');
                return redirect()->route('roles.index');
            }
        } catch (\Throwable $th) {
            $this->message('Algo Sucedio!', 'error');
            return redirect()->route('roles.index');
        }
    }


    public function destroy($id)
    {
        $estado_rol = Role::where('id', $id)->select('estado_roles', 'id')->first();
        // return $estado_rol['estado_roles'];
        try {
            if($estado_rol['estado_roles'] == 0){
                Role::where('id', $id)->update(['estado_roles' => 1]);
                $this->message('Restaurado Correctamente!', 'success');
                return redirect()->route('roles.index');
                
            }else{
                Role::where('id', $id)->update(['estado_roles' => 0]);
                $this->message('Eliminado Exitosamente!', 'success');
                return redirect()->route('roles.index');
            }
            
        } catch (\Throwable $err) {
                $this->message('Algo sucedio!', 'error');
                return redirect()->route('roles.index');
        }
    }
}
