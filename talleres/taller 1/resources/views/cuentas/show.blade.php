@extends('layouts.app')

@section('title', $cuenta->nombre)

@section('content')
    <section class="panel detail-panel">
        <div class="section-heading section-heading-row">
            <div>
                <p class="eyebrow">Actividad 5</p>
                <h1>{{ $cuenta->nombre }}</h1>
                <p>Información completa de la cuenta seleccionada.</p>
            </div>
            <a class="button button-ghost" href="{{ route('cuentas.index') }}">Volver al listado</a>
        </div>

        <dl class="detail-grid">
            <div><dt>Id</dt><dd>{{ $cuenta->id }}</dd></div>
            <div><dt>Nombre</dt><dd>{{ $cuenta->nombre }}</dd></div>
            <div><dt>Correo electrónico</dt><dd>{{ $cuenta->email }}</dd></div>
            <div><dt>Contraseña</dt><dd>Almacenada de forma segura</dd></div>
            <div><dt>Teléfono</dt><dd>{{ $cuenta->telefono }}</dd></div>
            <div><dt>Fecha de registro</dt><dd>{{ $cuenta->fecha_registro->format('d/m/Y') }}</dd></div>
        </dl>

        <form method="POST" action="{{ route('cuentas.destroy', $cuenta) }}" onsubmit="return confirm('¿Desea eliminar esta cuenta?')">
            @csrf
            @method('DELETE')
            <button class="button button-danger" type="submit">Eliminar cuenta</button>
        </form>
    </section>
@endsection
