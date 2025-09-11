<?php

namespace Tests\Feature;

use App\Models\USUARIOS;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;



class UserTest extends TestCase
{
    use RefreshDatabase;
    
    //Acceso correcto
    public function test_login_correcto()
    {
        $password = "123";
        $instructor = USUARIOS::factory()->create([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 1,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make($password),
            'idUsuarios' => 12345678
        ]);

        $loginBien = $this->post(route('login.instructor'), [
            'numeroDocumento' => $instructor->idUsuarios,
            'clave' => $password
        ]);

        $loginBien->assertRedirect('instructor');

        $this->assertAuthenticatedAs($instructor);
    }

    //Contraseña incorrecta

    public function test_contraseña_incorrecta (){
        $password = "1234";
        $NPassword = "12345";
        $instructor = USUARIOS::factory()->create([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 1,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make($password),
            'idUsuarios' => 12345678
        ]);

        $loginMal = $this->post(route('login.instructor'), [
            'numeroDocumento' => $instructor->idUsuarios,
            'clave' => $NPassword
        ]);

        $loginMal->assertRedirect(route('vista.instructor'));
    }
    
    //Usuario no encontrado
    public function test_usuario_no_encontrado () {
        $password = '1234';
        $NDocumento = 12345679;
        //No existe ningun usuario

        $loginMal = $this-> post(route('login.instructor'),[
            'numeroDocumento' => $NDocumento,
            'clave'=> $password
        ]);

        $loginMal -> assertRedirect(route('vista.instructor'));
    }

    
}
