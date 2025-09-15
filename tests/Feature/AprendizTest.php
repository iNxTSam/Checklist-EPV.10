<?php

namespace Tests\Feature;

use App\Models\DescripcionEvidencias;
use App\Models\Ficha;
use App\Models\GestionRutas;
use App\Models\USUARIOS;
use Hash;
use HashContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AprendizTest extends TestCase
{
    use RefreshDatabase;

    // Pruebas de inicio de sesion
    public function test_login_correcto(){
        $password ='123';
        $aprendiz = USUARIOS::factory() -> create([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make($password),
            'idUsuarios' => 12345678
        ]);

        $inicioBien = $this->post(route('login.aprendiz'),[
            'numeroDocumento' => $aprendiz->idUsuarios,
            'clave' => $password
        ]);

        $inicioBien -> assertStatus(302);
        $inicioBien -> assertRedirect('aprendiz'); 
        
    }

    public function test_contraseña_incorrecta (){
        $nPassword = '1223';
        $password = '123';

        $aprendiz = USUARIOS::factory() -> create([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make($password),
            'idUsuarios' => 12345678
        ]);

        $contraseñaMal = $this->post(route('login.aprendiz'), [
            'numeroDocumento' => $aprendiz-> idUsuarios,
            'clave' => $nPassword
        ]);

        $contraseñaMal -> assertStatus(302);
        $contraseñaMal -> assertRedirect(route('vista.aprendiz')); 
    }

    public function test_logeo_con_rol_instructor (){
        $password = '123';

        $instructor = USUARIOS::factory() -> create([
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

        $inicioMal = $this->post(route('login.aprendiz'), [
            'numeroDocumento' => $instructor-> idUsuarios,
            'clave' => $password
        ]);

        $inicioMal -> assertStatus(302);
        $inicioMal -> assertRedirect(route('vista.aprendiz')); 
    }

    public function test_usuario_no_encontrado()
    {
        $password = '1234';
        $NDocumento = 12345679;
        //No existe ningun usuario

        $inicioMal = $this->post(route('login.aprendiz'), [
            'numeroDocumento' => $NDocumento,
            'clave' => $password
        ]);

        $inicioMal->assertRedirect(route('vista.aprendiz'));
    }

    public function test_formulario_vacio()
    {
        $password = '1234';
        $aprendiz = USUARIOS::factory() -> create([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make($password),
            'idUsuarios' => 12345678
        ]);

        $inicioMal = $this->post(route('login.aprendiz'), [
            //campos vacios
        ]);

        $inicioMal->assertRedirect(route('vista.aprendiz'));
    }

    //Pruebas de modulo para subir archivos

    public function test_carga_de_modulo_sin_archivos_subidos () {
        
        $password = '123';
        
        $ficha = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);
        
        $aprendiz = USUARIOS::factory() -> create ([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make($password),
            'idUsuarios' => 12345678
        ]);

        $ruta = gestionRutas::factory()->create([
            'idGestionRutas' => $aprendiz->idUsuarios,
        ]);

        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'fotocopiaDocumentoDeIdentidad',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
    }
}
