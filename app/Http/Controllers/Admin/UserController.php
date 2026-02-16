<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Aplicar búsqueda si se proporciona
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(5)->withQueryString();
        $roles = ['administrador', 'trabajador', 'instructor'];

        return view('admin.users.index', compact('users', 'roles'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:administrador,trabajador,instructor'],
        ];

        // Validar campos básicos primero
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:administrador,trabajador,instructor'],
        ]);

        $profilePhotoPath = null;

        // Manejar la subida de la foto de perfil usando $_FILES directamente (sin fileinfo)
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profile_photo'];
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $tmpName = $file['tmp_name'];
            $maxSizeBytes = 2048 * 1024; // 2MB en bytes

            // Obtener extensión del nombre del archivo
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validar extensión
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withErrors(['profile_photo' => 'El archivo debe ser una imagen (jpeg, jpg, png o gif).'])
                    ->withInput();
            }

            // Validar tamaño
            if ($fileSize > $maxSizeBytes) {
                return redirect()->back()
                    ->withErrors(['profile_photo' => 'El archivo no debe exceder 2MB.'])
                    ->withInput();
            }

            // Generar nombre único para el archivo
            $newFileName = 'profile-photos/' . uniqid() . '_' . time() . '.' . $extension;
            $destinationPath = storage_path('app/public/' . $newFileName);

            // Crear directorio si no existe
            $directory = dirname($destinationPath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Mover el archivo subido
            if (move_uploaded_file($tmpName, $destinationPath)) {
                $profilePhotoPath = $newFileName;
            } else {
                return redirect()->back()
                    ->withErrors(['profile_photo' => 'Error al subir el archivo.'])
                    ->withInput();
            }
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'profile_photo' => $profilePhotoPath,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with([
            'assignedTasks' => function ($query) {
                $query->with('createdBy')->orderBy('created_at', 'desc');
            },
            'createdTasks' => function ($query) {
                $query->with('assignedTo')->orderBy('created_at', 'desc');
            },
            'reportedIncidents' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = ['administrador', 'trabajador', 'instructor'];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'role' => ['required', 'string', 'in:administrador,trabajador,instructor'],
        ];

        // Validar campos básicos primero
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'role' => ['required', 'string', 'in:administrador,trabajador,instructor'],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Manejar la actualización de la foto de perfil usando $_FILES directamente (sin fileinfo)
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profile_photo'];
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $tmpName = $file['tmp_name'];
            $maxSizeBytes = 2048 * 1024; // 2MB en bytes

            // Obtener extensión del nombre del archivo
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validar extensión
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withErrors(['profile_photo' => 'El archivo debe ser una imagen (jpeg, jpg, png o gif).'])
                    ->withInput();
            }

            // Validar tamaño
            if ($fileSize > $maxSizeBytes) {
                return redirect()->back()
                    ->withErrors(['profile_photo' => 'El archivo no debe exceder 2MB.'])
                    ->withInput();
            }

            // Eliminar la foto anterior si existe (sin usar Storage que requiere fileinfo)
            if ($user->profile_photo) {
                $oldPhotoPath = storage_path('app/public/' . $user->profile_photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            // Generar nombre único para el archivo
            $newFileName = 'profile-photos/' . uniqid() . '_' . time() . '.' . $extension;
            $destinationPath = storage_path('app/public/' . $newFileName);

            // Crear directorio si no existe
            $directory = dirname($destinationPath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Mover el archivo subido
            if (move_uploaded_file($tmpName, $destinationPath)) {
                $updateData['profile_photo'] = $newFileName;
            } else {
                return redirect()->back()
                    ->withErrors(['profile_photo' => 'Error al subir el archivo.'])
                    ->withInput();
            }
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Eliminar la foto de perfil si existe (sin usar Storage que requiere fileinfo)
        if ($user->profile_photo) {
            $photoPath = storage_path('app/public/' . $user->profile_photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}