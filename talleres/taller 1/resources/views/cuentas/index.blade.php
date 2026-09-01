@extends('layouts.app')

@section('title', 'Listado de cuentas')

@section('content')
    <section class="panel">
        <div class="section-heading section-heading-row">
            <div>
                <p class="eyebrow">Actividad 4</p>
                <h1>Cuentas registradas</h1>
                <p>Seleccione un identificador para consultar la información completa.</p>
            </div>
            <a class="button button-primary" href="{{ route('cuentas.create') }}">Nueva cuenta</a>
        </div>

        @if ($cuentas->isEmpty())
            <div class="empty-state">
                <h2>No hay cuentas registradas</h2>
                <p>Cree la primera cuenta para verla en este listado.</p>
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cuentas as $cuenta)
                            <tr>
                                <td><a class="id-link" href="{{ route('cuentas.show', $cuenta) }}">{{ $cuenta->id }}</a></td>
                                <td>{{ $cuenta->nombre }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
