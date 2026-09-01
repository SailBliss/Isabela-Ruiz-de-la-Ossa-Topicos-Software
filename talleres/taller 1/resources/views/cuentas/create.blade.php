@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
    <section class="panel form-panel">
        <div class="section-heading">
            <p class="eyebrow">Nueva cuenta</p>
            <h1>Registrar cuenta</h1>
            <p>Complete todos los campos para guardar una cuenta.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <strong>Revise la información ingresada.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cuentas.store') }}" class="form-grid">
            @csrf

            <label class="field field-wide">
                <span>Nombre</span>
                <input type="text" name="nombre" value="{{ old('nombre') }}" maxlength="120" required autofocus>
            </label>

            <label class="field field-wide">
                <span>Correo electrónico</span>
                <input type="email" name="email" value="{{ old('email') }}" maxlength="255" required>
            </label>

            <label class="field">
                <span>Contraseña</span>
                <input type="password" name="password" minlength="8" required>
            </label>

            <label class="field">
                <span>Confirmar contraseña</span>
                <input type="password" name="password_confirmation" minlength="8" required>
            </label>

            <label class="field">
                <span>Teléfono</span>
                <input type="tel" name="telefono" value="{{ old('telefono') }}" maxlength="30" required>
            </label>

            <label class="field">
                <span>Fecha de registro</span>
                <input type="date" name="fecha_registro" value="{{ old('fecha_registro', now()->toDateString()) }}" max="{{ now()->toDateString() }}" required>
            </label>

            <div class="form-actions field-wide">
                <button class="button button-primary" type="submit">Guardar cuenta</button>
                <a class="button button-ghost" href="{{ route('inicio') }}">Cancelar</a>
            </div>
        </form>
    </section>
@endsection
