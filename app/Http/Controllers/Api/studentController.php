<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    // Obtener todos los students
    public function index(){
        $students = Student::all();

        if($students->isEmpty()){
            $data = [
                'message' => 'No hay estudiantes',
                'status' => 200
            ];
            return response()->json($data, 404);
        }

        return response()->json($students, 200);
    }

    // Crear un nuevo student
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French',
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language
        ]);
        if(!$student){
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 400
            ];
            return response()->json($data, 500);
        }

        $data = [
            'student' => $student,
            'message' => 'Estudiante creado correctamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    // Obtener un student específico
    public function show($id)
    {
        $student = Student::find($id);

        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'student' => $student,
            'message' => 'Estudiante encontrado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Borrar un student específico
    public function destroy($id)
    {
        $student = Student::find($id);

        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $student->delete();

        $data = [
            'message' => 'Estudiante eliminado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Actualizar un student específico
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:student,email,' . $id,
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French',
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // $student->update($request->all());
        
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;
        $student->save();

        $data = [
            'student' => $student,
            'message' => 'Estudiante actualizado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
        
    }

    // Actualizar parcialmente un student específico
    public function updatePartial(Request $request, $id)
    {
        $student = Student::find($id);

        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:student,email,' . $id,
            'phone' => 'digits:10',
            'language' => 'in:English,Spanish,French',
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if($request->has('name')){
            $student->name = $request->name;
        }
        
        if($request->has('email')){
            $student->email = $request->email;
        }

        if($request->has('phone')){
            $student->phone = $request->phone;
        }

        if($request->has('language')){
            $student->language = $request->language;
        }

        $student->save();

        $data = [
            'student' => $student,
            'message' => 'Estudiante actualizado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
