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
     * Lista horarios según su tipo
     */
    public function index()
    {
        $this->authorize('viewAny', Horario::class); //aplicando la policy
        $laboral = Horario::where('tipo', 'laboral')->select('id', 'tipo', 'hora_mañana', 'hora_tarde', 'mensaje_laboral', 'activo')->first(); //recoge un horario de tipo laboral porque en los datos semilla solo coloco 1 y además selecciono solo lo necesario para no cargar la bbdd
        $vacaciones = Horario::where('tipo', 'vacaciones')->select('id', 'tipo', 'mensaje_vacaciones', 'activo')->first(); //recoge un horario de tipo vacaciones también los datos semilla he incluido solo 1 todo a proposito y además selecciono solo lo necesario para no cargar la bbdd
        return view('admin.horarios.index', ['laboral' => $laboral, 'vacaciones' => $vacaciones]); //retorna la vista y le pasa un horario laboral y un horario vacacional
    }

    /**
     * Formulario de edición
     */
    public function edit(Horario $horario) //recibe el horario seleccionado
    {
        $this->authorize('update', Horario::class); //aplicando la policy
        if($horario->tipo === 'laboral') { //si el horario es de tipo laboral prepara esto
            $semana = [ //un array de los días de la semana
                ['clave' => 'L', 'nombre' => 'Lunes'],
                ['clave' => 'M', 'nombre' => 'Martes'],
                ['clave' => 'X', 'nombre' => 'Miércoles'],
                ['clave' => 'J', 'nombre' => 'Jueves'],
                ['clave' => 'V', 'nombre' => 'Viernes'],
                ['clave' => 'S', 'nombre' => 'Sábados'],
                ['clave' => 'D', 'nombre' => 'Domingos'],
            ];
            return view('admin.horarios.editLaboral', ['horario'=> $horario, 'semana' => $semana]); //retorna la vista con el horario y el array de la semana para preparar la vista personalizada a este tipo de horario
        }
        
        if($horario->tipo === 'vacaciones') { //si el horario es de tipo vacaciones prepara esto
            $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']; //un array de los meses
            return view('admin.horarios.editVacaciones', ['horario'=> $horario, 'meses' => $meses]); //retorna la vista y le pasa el horario de tipo vacaciones con su array de meses para preparar la vista en concreto de este tipo de horario
        }
    }

    /**
     * Método para actualizar el horario
     */
    public function update(Request $request, Horario $horario) //recibe el horario y los parámetros
    {
        $this->authorize('update', Horario::class); //aplicando la policy
        if($horario->tipo === 'laboral') { //si es de tipo laboral
            $request->validate([
                'dias' => 'required',
                'mañana_inicio' => 'required',
                'mañana_fin' => 'required',
                'tarde_inicio' => 'required',
                'tarde_fin' => 'required',
            ],[ //todo es obligatorio
                'dias.required' => 'Debes seleccionar al menos un día',
                'mañana_inicio.required' => 'Debes establecer la hora de inicio de la mañana',
                'mañana_fin.required' => 'Debes establecer la hora de finalización de la mañana',
                'tarde_inicio.required' => 'Debes establecer la hora de inicio de la tarde',
                'tarde_fin.required' => 'Debes establecer la hora de finalización de la tarde',
            ]);//mensajes personalizados para cada caso

            $hora_mañana = $request->mañana_inicio . '-' . $request->mañana_fin; //formatea en una variable las dos horas de las mañana con un -
            $hora_tarde = $request->tarde_inicio . '-' . $request->tarde_fin; //formatea en una variable las dos horas de la tarde con un -
            $mensajeL = implode(' ', $request->dias); //convierte el array en una cadena de texto uniendo cada elemento con un espacio como el separador
            
            $horario->hora_mañana = $hora_mañana; //la variable anterior es colocada en el campo hora_mañana en la bbdd
            $horario->hora_tarde = $hora_tarde; //la variable anterior es colocada en el campo hora_tarde en la bbdd
            $horario->mensaje_laboral = $mensajeL; //la variable anterior es colocada como mensaje laboral en la bbdd
            $horario->save(); //guarda dicho horario
            return redirect()->route('horarios.index')->with('successHorarioUpdate', 'Laboral editado correctamente');//redirección a la ruta con un mensaje flash
        }
        
        if($horario->tipo === 'vacaciones') { //si es de tipo vacaciones entonces...
            $request->validate([
                'dia_inicio' => 'required|integer|between:1,31', 
                'mes_inicio' => 'required',
                'dia_fin' => 'required|integer|between:1,31',
                'mes_fin' => 'required',
            ],[//todos son requeridos y en los dos parámetros donde se tiene que recibir un día tiene que ser integer y estar comprendido entre 1 y 31
                'dia_inicio.required' => 'El día de inicio es obligatorio',
                'dia_inicio.between' => 'El día de inicio tiene que estar entre 1 y 31',
                'mes_inicio.required' => 'El mes de inicio es obligatorio',
                'dia_fin.required' => 'El día de fin es obligatorio',
                'dia_fin.between'=> 'El día de fin tiene que estar entre 1 y 31',
                'mes_fin.required'=> 'El mes de fin es obligatorio',
            ]); //mensajes personalizados
            
            $mensaje = "Estamos de vacaciones del " . $request->dia_inicio . ' de ' . $request->mes_inicio . ' al ' . $request->dia_fin . ' de ' . $request->mes_fin; //arma una frase con los parámetros
            $horario->mensaje_vacaciones = $mensaje; //guarda en el campo del mensaje de vacaciones  el mensaje armado antes
            $horario->save(); //guarda dicho horario
            return redirect()->route('horarios.index')->with('successHorarioUpdate','Vacaciones editadas correctamente'); //redirección a la ruta con un mensaje flash
        }
    }

    /**
     * Activa un horario
     */
    public function destroy(Horario $horario) //recibe un horario
    {
        $this->authorize('delete', Horario::class); //aplicando la policy
        Horario::query()->update(['activo' => 0]); //el estado de todos los horarios son false los desactiva todos
        $horario->refresh(); //refresca si no da fallo cuando se ejecute la siguiente linea porque sigue desactivado no lo sabe con esto ya si funciona
        $horario->activo = 1; //coloca el estado del horario en true (es boolean)
        $horario->save(); //guarda en la bbdd
        return redirect()->route('horarios.index')->with('successHorarioDelete', 'Horario activado'); //redirección a la ruta con mensaje flash
    }
}
