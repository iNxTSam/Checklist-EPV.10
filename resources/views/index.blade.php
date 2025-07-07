  @extends('layouts.header')
  @section ('title', 'Portal CEET')
  @section('content')
  @include('layouts.header')



@include('layouts.slider')
      <p><span class="Estilo102" style="font-size:16px"><strong> Respetado(a) Usuario(a):</strong><span
        class="Estilo102" style="font-size:16px"> El Portal de Plataformas CEET, ha sido diseñado y desarrollado por
        el Grupo de Investigación GICS del Centro de Electricidad Electrónica y Telecomunicaciones, para permitir el
        acceso a las diferentes plataformas diseñadas y desarrolladas por el CEET para la gestión de la información
        propia.</span></span></p>
      <table id="table" class="table nueva_tabla table-resposive table-hover table-bordered">
      <thead bgcolor="#04324C">
        <tr>
        <th width="28%" style="color:#ffffff">Plataforma</th>
        <th width="38%" style="color:#ffffff">Enlace</th>
        <th width="34%" style="color:#ffffff">Descripción</th>
        </tr>
      </thead>
      <tbody>
        <tr>
        <td><img src="{{'img/icono_instructor.png'}}" width="35" height="35"> Talento Humano CEET </td>
        <td><a href="https://www.gics-sennova.com/talento_humano_ceet/"
          style="color:#006666">https://www.gics-sennova.com/talento_humano_ceet/ </a></td>
        <td>Plataforma desarrollada para la actualización de datos personales y académicos de todos los
          colaboradores CEET. Así mismo, la administración de credenciales de acceso a todas las plataforma
          desarrolladas por GICS-CEET. </td>
        </tr>
        <tr>
        <td><img src="{{'img/icono_ambiente.png'}}" width="35" height="35"> Distribución de Ambientes CEET</td>
        <td><a href="/gestion_ambientes_ceet/"
          style="color:#006666">https://www.gics-sennova.com/gestion_ambientes_ceet/</a></td>
        <td>Consulta de la distribución de Ambientes y Fichas de cada trimestre de todas las áreas del CEET. </td>
        </tr>
        <tr>
        <td><img src="{{'img/icono_estadistica.jpg'}}" width="35" height="35"> Novedades CEET </td>
        <td><a href="https://www.gics-sennova.com/deserciones/"
          style="color:#006666">https://www.gics-sennova.com/novedades/</a></td>
        <td>Plataforma desarrollada para la Gestión de Novedades del CEET, como son Alertas Rutas de Deserción,
          Deserciones y Planes de Mejoramiento CEET. </td>
        </tr>
        <tr>
        <td><img src="{{'img/iconitook.jpg'}}" width="35" height="35"> Consulta Valoraciones CEET </td>
        <td><a href="https://www.gics-sennova.com/consulta_valoracion_ceet/"
          style="color:#006666">https://www.gics-sennova.com/consulta_valoracion_ceet/</a></td>
        <td>Plataforma desarrollada para que los Instructores consulten los resultados de la Valoración de
          Instructores de todas las áreas del CEET. </td>
        </tr>
        <tr>
        <td><img src="{{'img/icono_formulario.jpg'}}" width="35" height="35"> Valoración de Instructores CEET </td>
        <td><a href="https://www.gics-sennova.com/valoracion_ceet/"
          style="color:#006666">https://www.gics-sennova.com/valoracion_ceet/</a></td>
        <td>Plataforma desarrollada para la Valoración de Instructores por parte de los aprendices. Esta plataforma
          se habilitará únicamente al finalizar cada trimestre de formación y es administrada por Bienestar al
          Aprendiz CEET.</td>
        </tr>
        <tr>
        <td><img src="{{'img/icono_aprendiz.png'}}" width="35" height="35">Etapa Productiva CEET - Aprendices</td>
        <td><a href="https://www.gics-sennova.com/etapa_productiva_ceet/"
          style="color:#006666">https://www.gics-sennova.com/etapa_productiva_ceet/</a></td>
        <td>Plataforma desarrollada para la gestión de <em><strong>Paz y Salvos CEET</strong></em> y gestión de
          <em><strong>Alternativa de Etapa Productiva</strong></em>. Está habilitada los 365 días del año.</td>
        </tr>




        <tr>
        <td><img src="{{'img/icono_manual.png'}}" width="35" height="35">Votaciones Elección representantes
          Aprendices CEET </td>
        <td><a href="https://www.gics-sennova.com/votaciones_ceet_2024/"
          style="color:#006666">https://www.gics-sennova.com/votaciones_ceet_2024/</a></td>
        <td>Plataforma desarrollada para la Elección de Representantes de Aprendices de todas las jornadas del CEET.
          Estará disponible únicamente al inicio de cada año y está administrada por Bienestar al Aprendiz CEET.
        </td>
        </tr>
        <tr>
        <td><img src="{{'img/icono_usuarios.jpg'}}" width="35" height="35"> Reconocimiento de Fichas CEET </td>
        <td><a href="https://www.gics-sennova.com/reconocimiento_fichas_ceet/"
          style="color:#006666">https://www.gics-sennova.com/reconocimiento_fichas_ceet/</a></td>
        <td>Plataforma desarrollada para la Actualización y Reconocimiento de Fichas y Grupos del CEET. Estará
          disponible los 365 días del año y cada instructor mantendrá actualizada la información de los grupos que
          orienta, así como la información de sus voceros. Está administrada por Bienestar al Aprendiz CEET. </td>
        </tr>
        <tr>
        <td><img src="{{'img/icono_instructor.png'}}" width="35" height="35"> Solicitud de Paz y Salvos CEET -
          Contratistas CEET </td>
        <td><a href="https://www.gics-sennova.com/pazysalvos_ceet_contratistas/"
          style="color:#006666">https://www.gics-sennova.com/pazysalvos_ceet_contratistas/</a></td>
        <td>Plataforma desarrollada para la Gestión de Paz y Salvos CEET. Está habilitada los 365 días del año y
          aplica para Contratistas del CEET cuya vigencia de contrato ha terminado.</td>
        </tr>
        <!--<tr>
    <td><img src="../talento_humano_ceet/icono_instructor.png" width="35" height="35"> Reporte de Instructores y Fichas CEET </td>
    <td><a href="https://www.gics-sennova.com/fichas_instructores/" style="color:#006666">https://www.gics-sennova.com/fichas_instructores/</a></td>
    <td>Plataforma desarrollada para generar el reporte de Fichas e Instructores que han realizado el Reconocimiento de Fichas del presente trimestre.</td>
    </tr>-->

        <tr>
        <td><img src="{{'img/icono_credenciales.jpg'}}" width="35" height="35"> Carnetización CEET</td>
        <td><a href="https://www.gics-sennova.com/carnetizacion_ceet/"
          style="color:#006666">https://www.gics-sennova.com/carnetizacion_ceet/</a></td>
        <td>Plataforma desarrollada para generar los carnets digitales de la Comunidad CEET. Por medio de mensaje de
          correo electrónico, se informará a los aprendices de cada ficha, que podrán ingresar a descargar su
          carnet. </td>
        </tr>

        <tr>
        <td><img src="{{'img/icono_instructor.png'}}" width="35" height="35"> Solicitud Certificaciones
          (Contratistas)</td>
        <td><a href="https://www.gics-sennova.com/certificaciones_gaaics/" style="color:#006666"
          target="_blank">https://www.gics-sennova.com/certificaciones_gaaics/</a></td>
        <td>Plataforma desarrollada para que los contratistas del CEET, realicen la solicitud de sus certificaciones
          laborales. </td>
        </tr>


        <tr>
        <td><img src="{{'img/icono_herramientas.jpg'}}" width="35" height="35"> Herramientas y Equipos CEET</td>
        <td><a href="https://www.gics-sennova.com/herramientas_equipos_ceet/"
          style="color:#006666">https://www.gics-sennova.com/herramientas_equipos_ceet/</a></td>
        <td>Plataforma desarrollada para la gestión de inventario y préstamo de herramientas y equipos para
          préstamos del CEET.</td>
        </tr>

        <tr>
        <td><img src="{{'img/icono_formulario.jpg'}}" width="35" height="35"> Planillas CEET</td>
        <td><a href="https://www.gics-sennova.com/planillas_ceet/"
          style="color:#006666">https://www.gics-sennova.com/planillas_ceet/</a></td>
        <td>Plataforma desarrollada para la entrega de Planillas a las Coordinaciones Académicas al final de cada
          trimestre académico del CEET</td>
        </tr>

        <tr>
        <td><img src="{{'img/iconoempresa.jpg'}}" width="35" height="35"> Formación Complementaria CEET</td>
        <td><a href="https://www.gics-sennova.com/complementaria_ceet/"
          style="color:#006666">https://www.gics-sennova.com/complementaria_ceet/</a></td>
        <td>Plataforma desarrollada para la gestión de la Formación Complementaria en el CEET</td>
        </tr>

        <tr>
        <td><img src="{{'img/documentos.png'}}" width="35" height="35"> Documentación certificación Etapa productiva
        </td>
        <td><a href="/sample" style="color:#006666">https://www.gics-sennova.com/sample</a></td>
        <td>Plataforma desarrollada para la gestión de documentos y certificación al finaliza Etapa Productiva</td>
        </tr>



      </tbody>
      </table>
      @include('layouts.footer')
@endsection