<?php

namespace Tests\Feature;

use App\Models\Cuenta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CuentaTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_vista_inicial_tiene_los_dos_enlaces_solicitados(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Crear una cuenta')
            ->assertSee('Ver cuentas');
    }

    public function test_el_formulario_de_creacion_esta_disponible(): void
    {
        $this->get('/cuentas/crear')
            ->assertOk()
            ->assertSee('Registrar cuenta')
            ->assertSee('name="fecha_registro"', false);
    }

    public function test_los_datos_invalidos_no_crean_una_cuenta(): void
    {
        $this->from('/cuentas/crear')->post('/cuentas', [
            'nombre' => '',
            'email' => 'correo-invalido',
            'password' => '123',
            'password_confirmation' => '456',
            'telefono' => 'teléfono inválido',
            'fecha_registro' => now()->addDay()->toDateString(),
        ])->assertRedirect('/cuentas/crear')
            ->assertSessionHasErrors(['nombre', 'email', 'password', 'telefono', 'fecha_registro']);

        $this->assertDatabaseCount('cuentas', 0);
    }

    public function test_una_cuenta_valida_se_almacena_con_la_contrasena_protegida(): void
    {
        $respuesta = $this->post('/cuentas', [
            'nombre' => 'Isabela Ruiz',
            'email' => 'isabela@example.com',
            'password' => 'ClaveSegura2026',
            'password_confirmation' => 'ClaveSegura2026',
            'telefono' => '+57 300 123 4567',
            'fecha_registro' => '2026-08-31',
        ]);

        $respuesta->assertRedirect('/cuentas/crear')
            ->assertSessionHas('success', 'Elemento creado satisfactoriamente');

        $cuenta = Cuenta::query()->firstOrFail();

        $this->assertSame('Isabela Ruiz', $cuenta->nombre);
        $this->assertTrue(Hash::check('ClaveSegura2026', $cuenta->password_hash));
        $this->assertNotSame('ClaveSegura2026', $cuenta->password_hash);
    }

    public function test_el_listado_muestra_id_y_nombre_con_enlace_al_detalle(): void
    {
        $cuenta = Cuenta::query()->create([
            'nombre' => 'Ana Torres',
            'email' => 'ana@example.com',
            'password_hash' => Hash::make('ClaveSegura2026'),
            'telefono' => '3001234567',
            'fecha_registro' => '2026-08-30',
        ]);

        $this->get('/cuentas')
            ->assertOk()
            ->assertSee((string) $cuenta->id)
            ->assertSee('Ana Torres')
            ->assertSee(route('cuentas.show', $cuenta), false);
    }

    public function test_el_detalle_muestra_todos_los_atributos_sin_exponer_el_hash(): void
    {
        $cuenta = Cuenta::query()->create([
            'nombre' => 'Carlos Díaz',
            'email' => 'carlos@example.com',
            'password_hash' => Hash::make('ClaveSegura2026'),
            'telefono' => '3109876543',
            'fecha_registro' => '2026-08-29',
        ]);

        $this->get(route('cuentas.show', $cuenta))
            ->assertOk()
            ->assertSee('Carlos Díaz')
            ->assertSee('carlos@example.com')
            ->assertSee('3109876543')
            ->assertSee('29/08/2026')
            ->assertSee('Almacenada de forma segura')
            ->assertDontSee($cuenta->password_hash);
    }

    public function test_una_cuenta_se_puede_eliminar_y_se_redirige_al_listado(): void
    {
        $cuenta = Cuenta::query()->create([
            'nombre' => 'Laura Gómez',
            'email' => 'laura@example.com',
            'password_hash' => Hash::make('ClaveSegura2026'),
            'telefono' => '3155555555',
            'fecha_registro' => '2026-08-28',
        ]);

        $this->delete(route('cuentas.destroy', $cuenta))
            ->assertRedirect('/cuentas')
            ->assertSessionHas('success', 'Elemento eliminado satisfactoriamente');

        $this->assertDatabaseMissing('cuentas', ['id' => $cuenta->id]);
    }
}
