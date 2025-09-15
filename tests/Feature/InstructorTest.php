<?php

namespace Tests\Feature;

use App\Models\USUARIOS;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\Ficha;
use App\Models\InstructorFicha;
use App\Models\DescripcionEvidencias;
use App\Models\GestionRutas;



class InstructorTest extends TestCase
{
    use RefreshDatabase;

    
    // Pruebas de inicio de sesion
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

    public function test_contraseña_incorrecta()
    {
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

    public function test_logeo_con_rol_aprendiz (){
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

        $inicioMal = $this->post(route('login.instructor'), [
            'numeroDocumento' => $aprendiz-> idUsuarios,
            'clave' => $password
        ]);

        $inicioMal -> assertStatus(302);
        $inicioMal -> assertRedirect(route('vista.instructor')); 
    }

    //Usuario no encontrado
    public function test_usuario_no_encontrado()
    {
        $password = '1234';
        $NDocumento = 12345679;
        //No existe ningun usuario

        $loginMal = $this->post(route('login.instructor'), [
            'numeroDocumento' => $NDocumento,
            'clave' => $password
        ]);

        $loginMal->assertRedirect(route('vista.instructor'));
    }

    public function test_formulario_vacio()
    {
        $password = '1234';
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

        $inicioMal = $this->post(route('login.instructor'), [
            //campos vacios
        ]);

        $inicioMal->assertRedirect(route('vista.instructor'));
    }
    // Pruebas de la visualizacion de las fichas asignadas a instructor
    public function test_fichas_asignadas()
    {

        $ficha1 = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);
        $ficha2 = Ficha::factory()->create([
            'idFichas' => 2,
            'NumeroDeFicha' => 123245,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);


        $instructor = USUARIOS::factory()->create([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 1,
            'Fichas_idFichas' => $ficha1->idFichas,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(1234),
            'idUsuarios' => 12345678
        ]);
        $instructorFicha1 = InstructorFicha::factory()->create([
            'id' => 1,
            'idInstructor' => $instructor->idUsuarios,
            'idFicha' => $ficha1->idFichas
        ]);
        $instructorFicha2 = InstructorFicha::factory()->create([
            'id' => 2,
            'idInstructor' => $instructor->idUsuarios,
            'idFicha' => $ficha2->idFichas
        ]);

        $response = $this->actingAs($instructor)
            ->get(route('instructor.buscarFicha'));

        $response->assertStatus(200);
        $response->assertViewIs('instructor.buscarFicha');

        $fichasEnVista = $response->viewData('fichas');
        $this->assertCount(2, $fichasEnVista);


    }

    public function test_fichas_no_asignadas()
    {

        $ficha1 = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);
        $ficha2 = Ficha::factory()->create([
            'idFichas' => 2,
            'NumeroDeFicha' => 123245,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);

        $instructor = USUARIOS::factory()->create([
            'Nombres' => "Nombre ",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 1,
            'Fichas_idFichas' => $ficha1->idFichas,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(1234),
            'idUsuarios' => 12345678
        ]);

        $response = $this->actingAs($instructor)
            ->get(route('instructor.buscarFicha'));

        $response->assertStatus(200);
        $response->assertViewIs('instructor.buscarFicha');

        $fichasEnVista = $response->viewData('fichas');
        $this->assertCount(0, $fichasEnVista);

        $fichaNoAsignada1 = $fichasEnVista->pluck('idFichas')->toArray();
        $this->assertNotContains($ficha1->idFichas, $fichaNoAsignada1);
        $fichaNoAsignada2 = $fichasEnVista->pluck('idFichas')->toArray();
        $this->assertNotContains($ficha2->idFichas, $fichaNoAsignada2);
    }

    // Pruebas de la visualizacion de los aprendices de las fichas asignadas a instructor
    public function test_instructor_visualizando_ficha()
    {
        $ficha = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);
        $instructor = USUARIOS::factory()->create(
            [
                'Nombres' => "Nombre Instructor",
                'Apellidos' => "inventado",
                'Telefono' => 302312312,
                'Correo' => "aroca329@dfse.ccs",
                'Dirrecion' => "cll1 2#a",
                'TipoDeDocumentos_idTipoDeDocumentos' => 1,
                'Roles_idRoles' => 1,
                'Fichas_idFichas' => $ficha->idFichas,
                'EtapaProductvia_idEtapaProductvia' => 1,
                'Clave' => Hash::make(1234),
                'idUsuarios' => 12345678
            ]
        );
        $aprendiz = USUARIOS::factory()->create([
            'Nombres' => "Nombre Aprendiz",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => $ficha->idFichas,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(1234),
            'idUsuarios' => 123456728
        ]);

        $instructorFicha = InstructorFicha::factory()->create([
            'id' => 1,
            'idInstructor' => $instructor->idUsuarios,
            'idFicha' => $ficha->idFichas
        ]);

        $evidencia = DescripcionEvidencias::factory()->create([
            'idDescripcion' => 1,
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'hola',
            'comentario' => 'joasd',
            'estado' => 'Activo'
        ]);

        $response = $this->actingAs($instructor)->get(route('instructor.ficha.buscar', $ficha->idFichas));

        $response->assertStatus(200);
        $response->assertViewHas('fichaNumero', $ficha->NumeroDeFicha);

        $aprendicesEnVista = $response->viewData('aprendices');
        $this->assertCount(1, $aprendicesEnVista);
    }

    public function test_instructor_no_visualiza_ficha_no_asignada()
    {

        $ficha = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);

        $instructor = USUARIOS::factory()->create(
            [
                'Nombres' => "Nombre Instructor",
                'Apellidos' => "inventado",
                'Telefono' => 302312312,
                'Correo' => "aroca329@dfse.ccs",
                'Dirrecion' => "cll1 2#a",
                'TipoDeDocumentos_idTipoDeDocumentos' => 1,
                'Roles_idRoles' => 1,
                'Fichas_idFichas' => 4,
                'EtapaProductvia_idEtapaProductvia' => 1,
                'Clave' => Hash::make(1234),
                'idUsuarios' => 12345678
            ]
        );

        $response = $this->actingAs($instructor)->get(route('instructor.ficha.buscar', $ficha->idFichas));


        $response->assertRedirect(route('instructor.buscarFicha'));
        $response->assertSessionHas('mensaje', 'No tienes acceso a esta ficha');
    }
    public function test_instructor_visualizando_ficha_sin_aprendices()
    {
        $ficha = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 123245,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);

        $instructor = USUARIOS::factory()->create(
            [
                'Nombres' => "Nombre Instructor",
                'Apellidos' => "inventado",
                'Telefono' => 302312312,
                'Correo' => "aroca329@dfse.ccs",
                'Dirrecion' => "cll1 2#a",
                'TipoDeDocumentos_idTipoDeDocumentos' => 1,
                'Roles_idRoles' => 1,
                'Fichas_idFichas' => $ficha->idFichas,
                'EtapaProductvia_idEtapaProductvia' => 1,
                'Clave' => Hash::make(1234),
                'idUsuarios' => 12345678
            ]
        );


        InstructorFicha::factory()->create([
            'id' => 1,
            'idInstructor' => $instructor->idUsuarios,
            'idFicha' => $ficha->idFichas
        ]);


        $response = $this->actingAs($instructor)->get(route('instructor.ficha.buscar', $ficha->idFichas));


        $response->assertStatus(200);
        $response->assertViewIs('instructor.instructor');
        $response->assertViewHas('aprendices');

        $aprendicesEnVista = $response->viewData('aprendices');
        $this->assertCount(0, $aprendicesEnVista);
    }

    // Pruebas de visualizacion de los archivos de los aprendices
    public function test_retorna_correctamente_vista_con_aprendiz_y_documentos()
    {
        $instructor = USUARIOS::factory()->create(
            [
                'Nombres' => "Nombre Instructor",
                'Apellidos' => "inventado",
                'Telefono' => 302312312,
                'Correo' => "aroca329@dfse.ccs",
                'Dirrecion' => "cll1 2#a",
                'TipoDeDocumentos_idTipoDeDocumentos' => 1,
                'Roles_idRoles' => 1,
                'Fichas_idFichas' => 1,
                'EtapaProductvia_idEtapaProductvia' => 1,
                'Clave' => Hash::make(1234),
                'idUsuarios' => 12345678
            ]
        );

        $aprendiz = USUARIOS::factory()->create([
            'Nombres' => "Nombre Aprendiz",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(1234),
            'idUsuarios' => 123456728
        ]);
        $ruta = gestionRutas::factory()->create([
            'idGestionRutas' => $aprendiz->idUsuarios,
            'fotocopiaDocumentoDeIdentidad' => 'path/to/document.pdf',
        ]);

        descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'fotocopiaDocumentoDeIdentidad',
            'estado' => 'Aprobado',
            'comentario' => 'Documento aprobado.',
        ]);


        $response = $this->actingAs($instructor)
            ->get(route('instructor.revision', ['id' => $aprendiz->idUsuarios]));


        $response->assertStatus(200);
        $response->assertViewIs('instructor.review');
        $response->assertViewHasAll(['student', 'documents']);

        $documents = $response->viewData('documents');
        $this->assertCount(7, $documents);
        $this->assertEquals('Aprobado', $documents[3]['estado']);
        $this->assertEquals('Documento aprobado.', $documents[3]['comment']);
        $this->assertStringContainsString('storage/path/to/document.pdf', $documents[3]['file_path']);
        $this->assertTrue($documents[3]['approved']);
        $this->assertFalse($documents[3]['rejected']);
    }
    public function test_retorna_correctamente_vista_con_aprendiz_sin_documentos()
    {

        $instructor = USUARIOS::factory()->create(
            [
                'Nombres' => "Nombre Instructor",
                'Apellidos' => "inventado",
                'Telefono' => 302312312,
                'Correo' => "aroca329@dfse.ccs",
                'Dirrecion' => "cll1 2#a",
                'TipoDeDocumentos_idTipoDeDocumentos' => 1,
                'Roles_idRoles' => 1,
                'Fichas_idFichas' => 1,
                'EtapaProductvia_idEtapaProductvia' => 1,
                'Clave' => Hash::make(1234),
                'idUsuarios' => 12345678
            ]
        );

        $aprendiz = USUARIOS::factory()->create([
            'Nombres' => "Nombre Aprendiz",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => 1,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(1234),
            'idUsuarios' => 123456728
        ]);

        
        $response = $this->actingAs($instructor)
            ->get(route('instructor.revision', ['id' => $aprendiz->idUsuarios]));

        
        $response->assertStatus(200);
        $response->assertViewIs('instructor.review');

        $documents = $response->viewData('documents');

        
        foreach ($documents as $doc) {
            $this->assertEquals('Pendiente', $doc['estado']);
            $this->assertEquals('', $doc['comment']);
            $this->assertNull($doc['file_path']);
        }
    }

    // Pruebas de guardar los cambios y/o revisiones a los documentos de los aprendices

    public function test_actualiza_decripcion_de_evidencia_correctamente()
    {
        
        $ficha = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);
        $aprendiz = USUARIOS::factory()->create([
            'Nombres' => "Nombre Aprendiz",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => $ficha->idFichas,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(1234),
            'idUsuarios' => 123456728
        ]);

        $instructor = USUARIOS::factory()->create(
            [
                'Nombres' => "Nombre Instructor",
                'Apellidos' => "inventado",
                'Telefono' => 302312312,
                'Correo' => "aroca329@dfse.ccs",
                'Dirrecion' => "cll1 2#a",
                'TipoDeDocumentos_idTipoDeDocumentos' => 1,
                'Roles_idRoles' => 1,
                'Fichas_idFichas' => $ficha->idFichas,
                'EtapaProductvia_idEtapaProductvia' => 1,
                'Clave' => Hash::make(1234),
                'idUsuarios' => 12345678
            ]
        );


        // Crea una descripción de evidencia existente para que sea actualizada
        $descripcionExistente = descripcionEvidencias::factory()->create([
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'fotocopiaDocumentoDeIdentidad',
            'comentario' => 'Comentario inicial.',
            'estado' => 'Pendiente',
        ]);

        // 2. Datos para la petición
        $data = [
            'comentarios' => [
                'fotocopiaDocumentoDeIdentidad' => 'Documento aprobado, sin observaciones.'
            ],
            'estados' => [
                'fotocopiaDocumentoDeIdentidad' => 'approved'
            ]
        ];

       
        $response = $this->actingAs($instructor)
                         ->post(route('instructor.guardarRevision', ['id' => $aprendiz->idUsuarios]), $data);

        
        $response->assertStatus(302);
        $response->assertRedirect(route('instructor.ficha.buscar', $ficha->idFichas));
        $response->assertSessionHas('success', 'Revisión guardada correctamente.');

       
        $this->assertDatabaseHas('descripcionEvidencias', [
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'fotocopiaDocumentoDeIdentidad',
            'comentario' => 'Documento aprobado, sin observaciones.',
            'estado' => 'Aprobado',
        ]);
    }

    public function test_se_crea_una_nueva_descripcion_si_no_existe()
    {
        // 1. Configurar los datos de prueba
        $ficha = Ficha::factory()->create([
            'idFichas' => 1,
            'NumeroDeFicha' => 12345,
            'TipoDeJornada_idTipoDeJornada' => 1,
            'TipoDeFormacion_idTipoDeFormacion' => 1,
            'FechasFormacion_idFechasFormacion' => 1
        ]);
        $aprendiz = USUARIOS::factory()->create([
            'Nombres' => "Nombre Aprendiz",
            'Apellidos' => "inventado",
            'Telefono' => 302312312,
            'Correo' => "aroca329@dfse.ccs",
            'Dirrecion' => "cll1 2#a",
            'TipoDeDocumentos_idTipoDeDocumentos' => 1,
            'Roles_idRoles' => 2,
            'Fichas_idFichas' => $ficha->idFichas,
            'EtapaProductvia_idEtapaProductvia' => 1,
            'Clave' => Hash::make(1234),
            'idUsuarios' => 123456728
        ]);
        $instructor = USUARIOS::factory()->create(
            [
                'Nombres' => "Nombre Instructor",
                'Apellidos' => "inventado",
                'Telefono' => 302312312,
                'Correo' => "aroca329@dfse.ccs",
                'Dirrecion' => "cll1 2#a",
                'TipoDeDocumentos_idTipoDeDocumentos' => 1,
                'Roles_idRoles' => 1,
                'Fichas_idFichas' => $ficha->idFichas,
                'EtapaProductvia_idEtapaProductvia' => 1,
                'Clave' => Hash::make(1234),
                'idUsuarios' => 12345678
            ]
        );

        
        $data = [
            'comentarios' => [
                'pazYSalvoAcademicoAdministrativo' => 'Documento rechazado por estar incompleto.'
            ],
            'estados' => [
                'pazYSalvoAcademicoAdministrativo' => 'rejected'
            ]
        ];

        // 3. Simular la petición
        $response = $this->actingAs($instructor)
                         ->post(route('instructor.guardarRevision', ['id' => $aprendiz->idUsuarios]), $data);

        // 4. Afirmar la respuesta y la redirección
        $response->assertStatus(302);
        $response->assertRedirect(route('instructor.ficha.buscar', $ficha->idFichas));

        // 5. Afirmar que se creó un nuevo registro en la base de datos
        $this->assertDatabaseHas('descripcionEvidencias', [
            'idUsuario' => $aprendiz->idUsuarios,
            'nombreDocumento' => 'pazYSalvoAcademicoAdministrativo',
            'comentario' => 'Documento rechazado por estar incompleto.',
            'estado' => 'Rechazado',
        ]);
    }
}

