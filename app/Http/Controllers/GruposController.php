<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupos;
use App\Models\Users;
use App\Models\UsuarioGrupo;



class GruposController extends Controller
{
    /**
     * Mostrar lista de grupos
     */
    public function index(Request $request)
    {
        $paginaActual = $request->input('pagina', 1);
        $elementosPorPagina = $request->input('per_page', 10);

        $query = Grupos::query();
        $totalElementos = $query->count();
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);

        $grupos = $query
            ->withCount('usuarios')
            ->skip(($paginaActual - 1) * $elementosPorPagina)
            ->take($elementosPorPagina)
            ->get();

        return view('grupos.grupos', [
            'grupos' => $grupos,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $totalPaginas,
            'elementosPorPagina' => $elementosPorPagina,
            'usuarioAutenticado' => auth()->user()
        ]);
    }

    /**
     * Almacenar un nuevo grupo
     */
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
            'Duracion' => 'required|integer',
        ]);

        Grupos::create($validatedData);

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo creado exitosamente');
    }

    /**
     * Eliminar un grupo
     */
    public function destroy($IdGrupo)
    {
        // Eliminar primero las relaciones en Usuario_Grupo
        UsuarioGrupo::where('IdGrupo', $IdGrupo)->delete();

        // Luego eliminar el grupo
        Grupos::findOrFail($IdGrupo)->delete();

        return back()->with('success', 'Grupo eliminado correctamente');
    }

    /**
     * Mostrar miembros de un grupo
     */
    public function showMiembros($IdGrupo)
{
    $grupo = Grupos::with(['usuarios' => function ($query) {
        $query->withPivot('Rol', 'FechaAsignacion');
    }])->findOrFail($IdGrupo);

    // Corregir la siguiente línea para especificar la tabla Grupos
    $usuariosDisponibles = Users::whereDoesntHave('grupos', function ($query) use ($IdGrupo) {
        $query->where('Grupos.IdGrupo', $IdGrupo); // Especificar la tabla Grupos
    })->get();

    return view('grupos.miembros', [
        'grupo' => $grupo,
        'miembros' => $grupo->usuarios,
        'usuariosDisponibles' => $usuariosDisponibles
    ]);
}


    /**
     * Asignar usuario a grupo
     */
    public function asignarUsuario(Request $request, $IdGrupo)
    {
        $validatedData = $request->validate([
            'DocumentoId' => 'required|string|max:20|exists:Usuarios,DocumentoId',
            'Rol' => 'required|in:Estudiante,invitado,egresado,Profesor'
        ]);

        // Usando la relación muchos-a-muchos
        $grupo = Grupos::findOrFail($IdGrupo);
        $grupo->usuarios()->attach($validatedData['DocumentoId'], [
            'Rol' => $validatedData['Rol'],
            'FechaAsignacion' => now()
        ]);

        return redirect()->route('grupos.miembros', $IdGrupo)
            ->with('success', 'Usuario asignado al grupo correctamente');
    }

    /**
     * Remover usuario de grupo
     */
    public function removerUsuario($IdGrupo, $DocumentoId)
    {
        $grupo = Grupos::findOrFail($IdGrupo);
        $grupo->usuarios()->detach($DocumentoId);

        return back()->with('success', 'Usuario removido del grupo correctamente');
    }
}
