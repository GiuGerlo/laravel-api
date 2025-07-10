<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class teacherController extends Controller
{
    // Obtener todos los teachers.
    public function index()
    {
        $teachers = Teacher::all();

        if ($teachers->isEmpty()) {
            $data = [
                'message' => 'No hay profesores',
                'status' => 200
            ];
            return response()->json($data, 404);
        }

        return response()->json($teachers, 200);
    }

    // Obtener un teacher específico
    public function show($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            $data = [
                'message' => 'Profesor no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'teacher' => $teacher,
            'message' => 'Profesor encontrado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Crear un nuevo teacher.
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $teacher = Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        if (!$teacher) {
            $data = [
                'message' => 'Error al crear el profesor',
                'status' => 400
            ];
            return response()->json($data, 500);
        }

        $data = [
            'teacher' => $teacher,
            'message' => 'Profesor creado correctamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    // Borrar un teacher específico
    public function destroy($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            $data = [
                'message' => 'Profesor no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $teacher->delete();

        $data = [
            'message' => 'Profesor eliminado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Actualizar un teacher específico
    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            $data = [
                'message' => 'Profesor no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'phone' => 'required|digits:10',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->status = $request->status;
        $teacher->save();

        $data = [
            'teacher' => $teacher,
            'message' => 'Profesor actualizado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Actualizar parcialmente un teacher específico
    public function updatePartial(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            $data = [
                'message' => 'Profesor no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:teachers,email,' . $id,
            'phone' => 'digits:10',
            'status' => 'in:active,inactive',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('name')) {
            $teacher->name = $request->name;
        }

        if ($request->has('email')) {
            $teacher->email = $request->email;
        }

        if ($request->has('phone')) {
            $teacher->phone = $request->phone;
        }

        if ($request->has('status')) {
            $teacher->status = $request->status;
        }

        $teacher->save();

        $data = [
            'teacher' => $teacher,
            'message' => 'Profesor actualizado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
