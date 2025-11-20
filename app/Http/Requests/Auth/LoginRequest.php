<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Siempre devuelve true porque cualquier persona puede intentar iniciar sesión
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //las reglas de validación del login
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    //autentica al usuario con los datos del formulario
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited(); //verifica que el usuario no haya excedido el límite de intentos

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) { //intenta iniciar sesión con email y contraseña y si falla entonces...
            RateLimiter::hit($this->throttleKey()); //incrementa el contador de intentos

            throw ValidationException::withMessages([ //lanza ValidationException
                'password' => 'El email o la contraseña no son correctos',
            ]);
        }

        //verifica si el usuario está desactivado y si lo está entonces hace logout y lanza el error
        if (is_null(Auth::user()->rol_id)) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Usuario desactivado',
            ]);
        }

        RateLimiter::clear($this->throttleKey()); //limpia el contador de intentos
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        //Protege contra demasiados intentos de inicio de sesión por ejemplo contra fuerza bruta
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 4)) { 
            return;
        }

        event(new Lockout($this));
        //si falla más de 4 veces entonces sale este mensaje
        throw ValidationException::withMessages([
            'email' => 'Has intentado iniciar sesión demasiadas veces',
        ]);
    }

    /**
     * Genera una clave única para el sistema de intentos de inicio de sesión para limitar, sabe diferenciar intentos distintos de sesión por la IP
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
