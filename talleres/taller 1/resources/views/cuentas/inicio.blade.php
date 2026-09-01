@extends('layouts.app')

@section('title', 'Inicio | Gestión de cuentas')

@section('content')
    <section class="hero">
        <p class="eyebrow">Taller 01</p>
        <h1>Usuarios y autenticación</h1>
        <p>Administre la información básica de las cuentas registradas.</p>
        <div class="actions">
            <a class="button button-primary" href="{{ route('cuentas.create') }}">Crear una cuenta</a>
            <a class="button button-secondary" href="{{ route('cuentas.index') }}">Ver cuentas</a>
        </div>
    </section>
@endsection
