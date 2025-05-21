<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupos;
use App\Models\Users;
use App\Models\UsuarioGrupo;

class GruposController extends Controller
{
    public function index(Request $request)
    {
        $paginaActual = $request->input('pagina', 1);
        $elementosPorPagina = $request->input('per_page', 10);
        $busqueda = $request->input('search');

        $query = Grupos::query();

        if ($busqueda) {
            $query->where('IdGrupo', 'like', "%$busqueda%")
                  ->orWhere('NombreProfesor', 'like', "%$busqueda%")
                  ->orWhere('NombreCurso', 'like', "%$busqueda%");
        }

        $totalElementos = $query->count();
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);

        $grupos = $query->withCount('usuarios')
                       ->orderBy('IdGrupo')
                       ->skip(($paginaActual - 1) * $elementosPorPagina)
                       ->take($elementosPorPagina)
                       ->get();

        return view('grupos.grupos', [
            'grupos' => $grupos,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $totalPaginas,
            'elementosPorPagina' => $elementosPorPagina,
            'usuarioAutenticado' => auth()->user(),
            'search' => $busqueda
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'IdGrupo' => 'required|integer|unique:grupos,IdGrupo',
            'NombreProfesor' => 'required|string|max:45',
            'NombreCurso' => 'nullable|string|max:45',
            'FechaInicial' => 'nullable|date',
            'FechaFinal' => 'nullable|date|after_or_equal:FechaInicial',
            'HoraInicial' => 'nullable|date_format:H:i',
            'HoraFinal' => 'nullable|date_format:H:i|after:HoraInicial',
            'DiaSemana' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'SalaMovil' => 'required|string|max:45',
            'Duracion' => 'required|integer|min:1'
        ]);

        Grupos::create($validatedData);

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo creado exitosamente');
    }

    public function destroy($IdGrupo)
    {
        UsuarioGrupo::where('IdGrupo', $IdGrupo)->delete();
        Grupos::findOrFail($IdGrupo)->delete();

        return back()->with('success', 'Grupo eliminado correctamente');
    }

    public function showMiembros($IdGrupo)
    {
        $grupo = Grupos::with(['usuarios' => function($query) {
            $query->withPivot('Rol', 'FechaAsignacion');
        }])->findOrFail($IdGrupo);

        $usuariosDisponibles = Users::whereDoesntHave('grupos', function($query) use ($IdGrupo) {
            $query->where('Grupos.IdGrupo', $IdGrupo);
        })->get();

        return view('grupos.miembros', [
            'grupo' => $grupo,
            'miembros' => $grupo->usuarios,
            'usuariosDisponibles' => $usuariosDisponibles
        ]);
    }

    public function asignarUsuario(Request $request, $IdGrupo)
    {
        $validatedData = $request->validate([
            'DocumentoId' => [
                'required',
                'string',
                'max:20',
                'exists:Usuarios,DocumentoId',
                function ($attribute, $value, $fail) use ($IdGrupo) {
                    if (UsuarioGrupo::where('IdGrupo', $IdGrupo)
                        ->where('DocumentoId', $value)
                        ->exists()) {
                        $fail('El usuario ya está asignado a este grupo');
                    }
                }
            ],
            'Rol' => 'required|in:Estudiante,Invitado,Egresado,Profesor',
            'FechaAsignacion' => 'required|date'
        ]);

        $grupo = Grupos::findOrFail($IdGrupo);

        $grupo->usuarios()->attach($validatedData['DocumentoId'], [
            'Rol' => $validatedData['Rol'],
            'FechaAsignacion' => $validatedData['FechaAsignacion']
        ]);

        return redirect()->route('grupos.miembros', $IdGrupo)
            ->with('success', 'Usuario asignado al grupo correctamente');
    }

    public function removerUsuario($IdGrupo, $DocumentoId)
    {
        $grupo = Grupos::findOrFail($IdGrupo);
        $grupo->usuarios()->detach($DocumentoId);

        return back()->with('success', 'Usuario removido del grupo correctamente');
    }

    public function getUsuariosDisponibles($IdGrupo)
    {
        $usuarios = Users::whereDoesntHave('grupos', function($query) use ($IdGrupo) {
            $query->where('Grupos.IdGrupo', $IdGrupo);
        })->get(['DocumentoId', 'Nombre', 'Apellido']);

        return response()->json($usuarios);
    }

    public function buscarUsuario($cedula)
{
    $usuario = Users::where('DocumentoId', 'like', "%$cedula%")
        ->whereDoesntHave('grupos', function($query) {
            $query->where('Grupos.IdGrupo', request()->route('IdGrupo'));
        })
        ->first();

    if ($usuario) {
        return response()->json([
            'success' => true,
            'usuario' => $usuario
        ]);
    }

    return response()->json(['success' => false]);
}
}