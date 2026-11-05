<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Mostrar todas las habilidades
    public function index()
    {
        $skills = Skill::all();

        return view('skills.index', compact('skills'));
    }

    // Mostrar formulario para crear una habilidad
    public function create()
    {
        return view('skills.create');
    }

    // Guardar una nueva habilidad
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
        ]);

        Skill::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
        ]);

        return redirect()->route('skills.index');
    }

    // Mostrar formulario para editar una habilidad
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);

        return view('skills.edit', compact('skill'));
    }

    // Actualizar una habilidad
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
        ]);

        $skill = Skill::findOrFail($id);

        $skill->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
        ]);

        return redirect()->route('skills.index');
    }

    // Eliminar una habilidad
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);

        $skill->delete();

        return redirect()->route('skills.index');
    }
}