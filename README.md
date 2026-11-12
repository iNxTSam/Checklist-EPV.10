# Checklist EPV.10

Aplicación para gestionar las evidencias de la **etapa productiva (EPV)** del SENA. Los aprendices cargan sus documentos y los instructores los revisan por ficha.

## Funcionalidades

- **Aprendiz:** inicia sesión y sube los documentos de su etapa productiva.
- **Instructor:** busca la ficha, revisa el avance del aprendiz y registra la revisión.
- Roles diferenciados para aprendiz e instructor.
- Modelo de datos para fichas, instructores asignados, evidencias y rutas de gestión.

## Stack

- PHP 8.2+ y Laravel 12
- SQLite por defecto (configurable a MySQL o PostgreSQL)
- Blade, Tailwind CSS 4 y Vite

## Instalación

```bash
git clone https://github.com/iNxTSam/Checklist-EPV.10.git
cd Checklist-EPV.10
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Si usas SQLite, crea el archivo de base de datos y migra:

```bash
# Windows (PowerShell)
New-Item database/database.sqlite

# Linux / macOS
touch database/database.sqlite

php artisan migrate
npm run build
php artisan serve
```

La aplicación queda disponible en `http://127.0.0.1:8000`.

Para MySQL o PostgreSQL, cambia `DB_CONNECTION` y las credenciales en `.env` antes de migrar.

## Estructura

- `app/Http/Controllers`: `AprendizController`, `InstructorController`, `AuthPersonalizadoController` y `Navegacion`.
- `app/Models`: `Ficha`, `InstructorFicha`, `EtapaProductiva`, `DescripcionEvidencias`, `GestionRutas`, `USUARIOS` y `Rol`.
- `database/migrations`: usuarios, fichas, instructores por ficha, evidencias y rutas de gestión.
- `resources/views`: vistas de aprendiz, instructor y layouts.

## Contexto

Proyecto académico del SENA. Repositorio: [github.com/iNxTSam](https://github.com/iNxTSam).
