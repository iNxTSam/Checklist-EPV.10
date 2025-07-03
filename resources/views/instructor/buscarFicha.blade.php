<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentación Certificación CEET</title>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        header {
            background-color: white;
            padding: 20px;
        }
        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            background-color: rgb(14, 168, 19); 
            padding: 10px;
        }
        .logo img {
            width: 60px;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin: 20px 0;
        }
        input[type="text"] {
            width: 60%;
            padding: 10px;
            font-size: 16px;
        }
        .btn {
            background-color: rgb(14, 168, 19); 
            color: white;
            padding: 10px 25px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            margin: 10px;
            cursor: pointer;
        }
        .btn.cancel {
            background-color: transparent;
            color:rgb(64, 90, 116);
            text-decoration: underline;
        }
        .abajo {
            background-color: rgb(14, 168, 19); 
            color: white;
            padding: 20px;
            font-size: 14px;
            text-align: center;
            margin-top: 30px; 
        }
        .abajo {
            margin: 4px 0;
        }
    
    
    </style>
</head>
<body>

    <header>
        <div class="logo">
        <img src="{{ asset('img/icono.png') }}" alt="Logo SENA">

        <h1>DOCUMENTACIÓN CERTIFICACIÓN CEET</h1>

    </header>
</div>

    <div class="container">
        <h2>Documentación Certificación - Etapa productiva</h2>
        <p>Respetado(a) Usuario(a): La Plataforma ha sido desarrollada por el Grupo de Investigación GICS CEET, para la gestión de la documentación al momento de certificarse.</p>

        <form action="/instructor" method="get">
            <div class="form-group">
                <label for="ficha">Ingrese el número de ficha (Sólo números)</label><br><br>
                <input type="text" id="ficha" name="ficha" placeholder="Nº Ficha" required>
            </div>
            <button type="submit" class="btn">Aceptar</button><br>
            <button type="button" class="btn cancel">Cancelar</button>
        </form>
    </div>

        <div class="abajo">
            <p>Servicio Nacional de Aprendizaje SENA - CENTRO DE ELECTRICIDAD, ELECTRÓNICA Y TELECOMUNICACIONES - Regional Distrito Capital</p>
            <p>Subdirección: Lina Samaris Silva Beltrán</p>
            <p>Coordinación: Mauricio Coronado - Germán Alarcón - Yaqueline Chavarro - Edgar Hincapié - Oscar Pulido - Oscar Galvis - Luis Antonio Ayala</p>
            <p>Dirección: Cra 30 No. 17B-25 Sur. Bogotá - Teléfono: 5461500 Ext: 14915</p>
            <p>Conmutador Nacional (57 1) 5461500</p>
            <p>Atención telefónica: lunes a viernes 7:00 a.m. a 7:00 p.m. - sábados 8:00 a.m. a 1:00 p.m.</p>
            <p>Atención al ciudadano: Bogotá (57 1) 5925555. Línea gratuita y resto del país: 018000 910270</p>
        </div>
</body>
</html>
