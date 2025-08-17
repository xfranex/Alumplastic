<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laboral = Horario::where('tipo', 'laboral')->select('id', 'tipo', 'hora_mañana', 'hora_tarde', 'mensaje_laboral', 'activo')->first();
        $vacaciones = Horario::where('tipo', 'vacaciones')->select('id', 'tipo', 'mensaje_vacaciones', 'activo')->first();
        return view('admin.horarios.index', ['laboral' => $laboral, 'vacaciones' => $vacaciones]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $horario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        Horario::query()->update(['activo' => 0]);
        $horario->refresh();
        $horario->activo = 1;
        $horario->save();
        return redirect()->route('horarios.index')->with('successHorarioDelete', 'Horario activado');
    }
}
