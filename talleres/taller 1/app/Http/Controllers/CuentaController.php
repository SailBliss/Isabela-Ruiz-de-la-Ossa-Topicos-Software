<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CuentaController extends Controller
{
    public function inicio(): View
    {
        return view('cuentas.inicio');
    }

    public function index(): View
    {
        $cuentas = Cuenta::query()
            ->select(['id', 'nombre'])
            ->orderBy('nombre')
            ->get();

        return view('cuentas.index', compact('cuentas'));
    }

    public function create(): View
    {
        return view('cuentas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:cuentas,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telefono' => ['required', 'string', 'max:30', 'regex:/^[0-9+()\-\s]+$/'],
            'fecha_registro' => ['required', 'date', 'before_or_equal:today'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'email.unique' => 'Ya existe una cuenta con este correo electrónico.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'Ingrese un número de teléfono válido.',
            'fecha_registro.required' => 'La fecha de registro es obligatoria.',
            'fecha_registro.before_or_equal' => 'La fecha de registro no puede ser futura.',
        ]);

        Cuenta::create([
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'password_hash' => Hash::make($datos['password']),
            'telefono' => $datos['telefono'],
            'fecha_registro' => $datos['fecha_registro'],
        ]);

        return redirect()
            ->route('cuentas.create')
            ->with('success', 'Elemento creado satisfactoriamente');
    }

    public function show(Cuenta $cuenta): View
    {
        return view('cuentas.show', compact('cuenta'));
    }

    public function destroy(Cuenta $cuenta): RedirectResponse
    {
        $cuenta->delete();

        return redirect()
            ->route('cuentas.index')
            ->with('success', 'Elemento eliminado satisfactoriamente');
    }
}
