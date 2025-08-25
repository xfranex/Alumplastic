<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Horario::class);
        $laboral = Horario::where('tipo', 'laboral')->select('id', 'tipo', 'hora_mañana', 'hora_tarde', 'mensaje_laboral', 'activo')->first();
        $vacaciones = Horario::where('tipo', 'vacaciones')->select('id', 'tipo', 'mensaje_vacaciones', 'activo')->first();
        return view('admin.horarios.index', ['laboral' => $laboral, 'vacaciones' => $vacaciones]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        $this->authorize('update', Horario::class);
        if($horario->tipo === 'laboral') {
            return view('admin.horarios.editLaboral', ['horario'=> $horario]);
        }
        if($horario->tipo === 'vacaciones') {
            $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
            return view('admin.horarios.editVacaciones', ['horario'=> $horario, 'meses' => $meses]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $horario)
    {
        $this->authorize('update', Horario::class);
        if($horario->tipo === 'laboral') {
            
        }
        
        if($horario->tipo === 'vacaciones') {
            $request->validate([
                'dia_inicio' => 'required|integer|between:1,31',
                'mes_inicio' => 'required',
                'dia_fin' => 'required|integer|between:1,31',
                'mes_fin' => 'required',
            ],[
                'dia_inicio.required' => 'El día de inicio es obligatorio',
                'dia_inicio.between' => 'El día de inicio tiene que estar entre 1 y 31',
                'mes_inicio.required' => 'El mes de inicio es obligatorio',
                'dia_fin.required' => 'El día de fin es obligatorio',
                'dia_fin.between'=> 'El día de fin tiene que estar entre 1 y 31',
                'mes_fin.required'=> 'El mes de fin es obligatorio',
            ]);
            
            $mensaje = "Estamos de vacaciones del " . $request->dia_inicio . ' de ' . $request->mes_inicio . ' al ' . $request->dia_fin . ' de ' . $request->mes_fin;
            $horario->mensaje_vacaciones = $mensaje;
            $horario->save();
            return redirect()->route('horarios.index')->with('successHorarioUpdate','Vacaciones editadas correctamente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        $this->authorize('delete', Horario::class);
        Horario::query()->update(['activo' => 0]);
        $horario->refresh();
        $horario->activo = 1;
        $horario->save();
        return redirect()->route('horarios.index')->with('successHorarioDelete', 'Horario activado');
    }
}
