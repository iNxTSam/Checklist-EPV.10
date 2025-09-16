<?php

namespace Tests\Feature;

use App\Models\DescripcionEvidencias;
use App\Models\Ficha;
use App\Models\GestionRutas;
use App\Models\USUARIOS;
use Hash;
use HashContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class AprendizTest extends TestCase
{
    use RefreshDatabase;

    // Pruebas de inicio de sesion
    public function test_login_correcto()
    {
        $password = '123';
        $aprendiz = USUARIOS::factory()->create([
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

        $inicioBien = $this->post(route('login.aprendiz'), [
            'numeroDocumento' => $aprendiz->idUsuarios,
            'clave' => $password
        ]);

        $inicioBien->assertStatus(302);
        $inicioBien->assertRedirect('aprendiz');

    }

    public function test_contraseña_incorrecta()
    {
        $nPassword = '1223';
        $password = '123';

        $aprendiz = USUARIOS::factory()->create([
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
            'numeroDocumento' => $aprendiz->idUsuarios,
            'clave' => $nPassword
        ]);

        $contraseñaMal->assertStatus(302);
        $contraseñaMal->assertRedirect(route('vista.aprendiz'));
    }

    public function test_logeo_con_rol_instructor()
    {
        $password = '123';

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

        $inicioMal = $this->post(route('login.aprendiz'), [
            'numeroDocumento' => $instructor->idUsuarios,
            'clave' => $password
        ]);

        $inicioMal->assertStatus(302);
        $inicioMal->assertRedirect(route('vista.aprendiz'));
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
        $aprendiz = USUARIOS::factory()->create([
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

    public function test_carga_de_modulo_sin_archivos_cargados()
    {

        $password = '123';

        $ficha = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);

        $aprendiz = USUARIOS::factory()->create([
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

        $this->actingAs($aprendiz);

        $response = $this->get(route('aprendiz.inicio'));

        $response->assertStatus(200);
        $response->assertViewHas('documentos', function ($doc) {
            return collect($doc)->every(function ($doc) {
                return $doc['estado'] === 'Pendiente' && !$doc['exists'];
            });
        });
    }

    public function test_carga_de_modulo_con_archivos_cargados()
    {
        $password = '123';

        $ficha = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);

        $aprendiz = USUARIOS::factory()->create([
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
            'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva' => 'path/doc.pdf',
            'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena' => 'path/doc.pdf',
            'pazYSalvoAcademicoAdministrativo' => 'path/doc.pdf',
            'fotocopiaDocumentoDeIdentidad' => 'path/doc.pdf',
            'certificadoAprobacionEmpresaTerminacionEtapaProductiva' => 'path/doc.pdf',
            'certificadoAsistenciaPruebaSaberTTIcfes' => 'path/doc.pdf',
            'formatoEntregaDeDocumentos' => 'path/doc.pdf'

        ]);

        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'pazYSalvoAcademicoAdministrativo',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'fotocopiaDocumentoDeIdentidad',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'certificadoAprobacionEmpresaTerminacionEtapaProductiva',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'certificadoAsistenciaPruebaSaberTTIcfes',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'formatoEntregaDeDocumentos',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        $this->actingAs($aprendiz);

        $response = $this->get(route('aprendiz.inicio'));

        $response->assertViewHas('documentos', function ($doc) {
            return collect($doc)->every(function ($doc) {
                return $doc['estado'] === 'Pendiente' && $doc['exists'];
            });
        });

    }
    public function test_carga_de_modulo_con_algunos_archivos_cargados()
    {
        $password = '123';

        $ficha = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);

        $aprendiz = USUARIOS::factory()->create([
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
            'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva' => 'path/doc.pdf',
            'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena' => 'path/doc.pdf',
            'pazYSalvoAcademicoAdministrativo' => 'path/doc.pdf',
            'fotocopiaDocumentoDeIdentidad' => 'path/doc.pdf',
            'certificadoAprobacionEmpresaTerminacionEtapaProductiva' => 'path/doc.pdf',

        ]);

        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'comprobanteInscripcionEnElAplicativoAgenciaPublicaDelEmpleoSena',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'pazYSalvoAcademicoAdministrativo',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'fotocopiaDocumentoDeIdentidad',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);
        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'certificadoAprobacionEmpresaTerminacionEtapaProductiva',
            'estado' => 'Pendiente',
            'comentario' => '',
        ]);


        $this->actingAs($aprendiz);

        $response = $this->get(route('aprendiz.inicio'));

        $response->assertViewHas('documentos', function ($doc) {
            return collect($doc)->every(function ($doc) {
                return $doc['estado'] === 'Pendiente' && $doc['exists'] || !$doc['exists'];
            });
        });

    }

    public function test_muestra_documentos_aprobados_si_existe_comentario_aprobado()
    {
        $aprendiz = USUARIOS::factory()->create([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(123),
            'idUsuarios' => 12345678
        ]);

        GestionRutas::factory()->create([
            'idGestionRutas' => $aprendiz->idUsuarios,
            'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva' => 'path/doc.pdf'
        ]);

        DescripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva',
            'estado' => 'Aprobado',
            'comentario' => 'Todo bien'
        ]);

        $this->actingAs($aprendiz);

        $response = $this->get(route('aprendiz.inicio'));

        $response->assertStatus(200);
        $response->assertViewHas('documentos', function ($docs) {
            $doc = collect($docs)->firstWhere('field', 'formatoPlaneacionSeguimientoYEvaluacionEtapaProductiva');
            return $doc['approved'] === true 
                && $doc['estado'] === 'Aprobado'
                && $doc['comment'] === 'Todo bien'
                && $doc['ruta'] !== null;
        });
    }
    public function muestra_documentos_rechazados_con_comentario()
    {
        $aprendiz = USUARIOS::factory()->create([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(123),
            'idUsuarios' => 12345678
        ]);

        GestionRutas::factory()->create([
            'idGestionRutas' => $aprendiz->idUsuarios,
            'fotocopiaDocumentoDeIdentidad' => 'path/cedula.pdf'
        ]);

        DescripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'fotocopiaDocumentoDeIdentidad',
            'estado' => 'Rechazado',
            'comentario' => 'Documento borroso'
        ]);

        $this->actingAs($aprendiz);

        $response = $this->get(route('aprendiz.inicio'));

        $response->assertStatus(200);
        $response->assertViewHas('documentos', function ($docs) {
            $doc = collect($docs)->firstWhere('field', 'fotocopiaDocumentoDeIdentidad');
            return $doc['rejected'] === true 
                && $doc['estado'] === 'Rechazado'
                && $doc['comment'] === 'Documento borroso';
        });
    }

    public function test_permite_subir_documento_pdf_valido()
    {
        Storage::fake('public');
        $usuario = USUARIOS::factory()->create(['Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(123),
            'idUsuarios' => 12345678
        ]);
        $this->actingAs($usuario);

        $file = UploadedFile::fake()->create('prueba.pdf', 100, 'application/pdf');

        $response = $this->post(route('aprendiz.subir'), [
            'fotocopiaDocumentoDeIdentidad' => $file,
        ]);

        // Se guarda en storage
        Storage::disk('public');
        Storage::assertExists('documents/12345678_fotocopiaDocumentoDeIdentidad.pdf');

        // Base de datos
        $this->assertDatabaseHas('GestionRutas', [
            'idGestionRutas' => 12345678,
            'fotocopiaDocumentoDeIdentidad' => 'documents/12345678_fotocopiaDocumentoDeIdentidad.pdf'
        ]);

        $this->assertDatabaseHas('descripcionEvidencias', [
            'idUsuario' => 12345678,
            'nombreDocumento' => 'fotocopiaDocumentoDeIdentidad',
            'estado' => 'Pendiente'
        ]);

        $response->assertRedirect(route('aprendiz.inicio'));
        $response->assertSessionHas('success', 'Documentos enviados correctamente');
    }

    public function test_rechaza_archivo_no_pdf()
    {
        Storage::fake('public');
        $usuario = USUARIOS::factory()->create(['Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(123),
            'idUsuarios' => 12345678
        ]);
        $this->actingAs($usuario);

        $file = UploadedFile::fake()->create('prueba.jpg', 100, 'image/jpeg');

        $response = $this->post(route('aprendiz.subir'), [
            'fotocopiaDocumentoDeIdentidad' => $file,
        ]);

        $response->assertRedirect(route('aprendiz.inicio'));
        $response->assertSessionHas('msg', 'Por favor asegurese que los archivos estan en PDF y pesan menos de 5 MB');

        Storage::disk('public');
        Storage::assertMissing('documents/12345678_fotocopiaDocumentoDeIdentidad.pdf');
        $this->assertDatabaseMissing('gestionRutas', [
            'idGestionRutas' => 2,
        ]);
    }

    public function test_rechaza_archivo_mayor_a_5mb()
    {
        Storage::fake('public');
        $usuario = USUARIOS::factory()->create(['Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(123),
            'idUsuarios' => 12345678
        ]);
        $this->actingAs($usuario);

        $file = UploadedFile::fake()->create('prueba.pdf', 6000, 'application/pdf');

        $response = $this->post(route('aprendiz.subir'), [
            'fotocopiaDocumentoDeIdentidad' => $file,
        ]);

        $response->assertRedirect(route('aprendiz.inicio'));
        $response->assertSessionHas('msg', 'Por favor asegurese que los archivos estan en PDF y pesan menos de 5 MB');

        Storage::disk('public');
        Storage::assertMissing('documents/12345678_fotocopiaDocumentoDeIdentidad.pdf');
        $this->assertDatabaseMissing('gestionRutas', [
            'idGestionRutas' => 2,
        ]);
    }

    public function test_permite_subir_varios_documentos_validos()
    {
        Storage::fake('public');
        $usuario = USUARIOS::factory()->create(['Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(123),
            'idUsuarios' => 12345678
        ]);
        $this->actingAs($usuario);

        $file1 = UploadedFile::fake()->create('prueba1.pdf', 100, 'application/pdf');
        $file2 = UploadedFile::fake()->create('prueba2.pdf', 150, 'application/pdf');

        $response = $this->post(route('aprendiz.subir'), [
            'fotocopiaDocumentoDeIdentidad' => $file1,
            'pazYSalvoAcademicoAdministrativo' => $file2,
        ]);

        // Se guarda en storage
        Storage::disk('public');
        Storage::assertExists('documents/12345678_fotocopiaDocumentoDeIdentidad.pdf');

        Storage::disk('public');
        Storage::assertExists('documents/12345678_pazYSalvoAcademicoAdministrativo.pdf');

        // Base de datos
        $this->assertDatabaseHas('GestionRutas', [
            'idGestionRutas' => 12345678,
            'fotocopiaDocumentoDeIdentidad' => 'documents/12345678_fotocopiaDocumentoDeIdentidad.pdf',
            'pazYSalvoAcademicoAdministrativo' => 'documents/12345678_pazYSalvoAcademicoAdministrativo.pdf'
        ]);

        $this->assertDatabaseHas('descripcionEvidencias', [
            'idUsuario' => 12345678,
            'nombreDocumento' => 'fotocopiaDocumentoDeIdentidad',
            'estado' => 'Pendiente'
        ]);

        $this->assertDatabaseHas('descripcionEvidencias', [
            'idUsuario' => 12345678,
            'nombreDocumento' => 'pazYSalvoAcademicoAdministrativo',
            'estado' => 'Pendiente'
        ]);

        $response->assertRedirect(route('aprendiz.inicio'));
        $response->assertSessionHas('success', 'Documentos enviados correctamente');
    }

}
