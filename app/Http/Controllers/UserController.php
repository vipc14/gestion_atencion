<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AttentionExecutive;
use App\Models\AttentionChannel;
use App\Models\CustomerRecord;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function create() {
        $roles = Role::all();
        $channels = AttentionChannel::all();
        return view('users.create', compact('roles', 'channels'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'attention_queue_id' => [
                Rule::requiredIf($request->role === 'usuario de acceso'),
                'nullable',
                'exists:attention_queues,id'
            ],
        ]);

        $user = DB::transaction(function () use ($request) {
            $executive = null;
            if ($request->role === 'usuario de acceso') {
                $executive = AttentionExecutive::create([
                    'name' => $request->name,
                    'attention_queue_id' => $request->attention_queue_id,
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'attention_executive_id' => $executive?->id,
            ]);

            $user->assignRole($request->role);
            return $user;
        });

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $usuario) {
        $roles = Role::all();
        $channels = AttentionChannel::all();
        $usuario->load('attentionExecutive.attentionQueue.attentionChannel');
        return view('users.edit', compact('usuario', 'roles', 'channels'));
    }

    public function update(Request $request, User $usuario) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'attention_queue_id' => [
                Rule::requiredIf($request->role === 'usuario de acceso'),
                'nullable',
                'exists:attention_queues,id'
            ],
        ]);

        DB::transaction(function () use ($request, $usuario) {
            $executiveToModify = $usuario->attentionExecutive;
            $newExecutiveId = $usuario->attention_executive_id;

            // CASO 1: El rol cambia y DEJA de ser agente.
            if ($request->role !== 'usuario de acceso' && $usuario->hasRole('usuario de acceso')) {
                // Primero, desvinculamos al usuario de su perfil de ejecutivo.
                $usuario->attention_executive_id = null;
                $usuario->save(); // Guardamos este cambio inmediatamente.
                $newExecutiveId = null;

                // Ahora que el usuario está desvinculado, podemos eliminar el perfil de ejecutivo.
                if ($executiveToModify) {
                    CustomerRecord::where('attention_executive_id', $executiveToModify->id)
                        ->update(['attention_executive_id' => null]);
                    $executiveToModify->delete();
                }
            } 
            // CASO 2: El rol ES o se convierte en agente.
            elseif ($request->role === 'usuario de acceso') {
                $executive = AttentionExecutive::updateOrCreate(
                    ['id' => $usuario->attention_executive_id],
                    ['name' => $request->name, 'attention_queue_id' => $request->attention_queue_id]
                );
                $newExecutiveId = $executive->id;
            }
            
            // Actualizamos los datos principales del usuario
            $usuario->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'attention_executive_id' => $newExecutiveId,
            ]);

            if ($request->filled('password')) {
                $usuario->update(['password' => Hash::make($request->password)]);
            }

            // Sincronizamos el rol al final
            $usuario->syncRoles($request->role);
        });

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        DB::transaction(function () use ($usuario) {
            $executive = $usuario->attentionExecutive;

            // 1. Eliminar el usuario primero. Esto rompe la restricción de la llave foránea
            // desde la tabla 'users' a 'attention_executives' de la forma más directa.
            $usuario->delete();

            // 2. Si el usuario tenía un perfil de ejecutivo asociado,
            // ahora que el usuario ya no existe, podemos eliminarlo de forma segura.
            if ($executive) {
                // Desvincular cualquier registro de cliente que aún apunte al ejecutivo
                CustomerRecord::where('attention_executive_id', $executive->id)
                    ->update(['attention_executive_id' => null]);
                
                // Ahora sí, eliminar el perfil de ejecutivo.
                $executive->delete();
            }
        });

        return redirect()->route('usuarios.index')->with('success', 'Usuario y su perfil de ejecutivo han sido eliminados.');
    }
}
