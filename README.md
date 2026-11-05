# Plataforma para aprender habilidades

Proyecto del Grupo 2 – SENA, Técnico en Programación de Software (ficha 3171240).
Institución Educativa Benedikta Zur Nieden.

Aprendiz: **Ashlee Alejandra Ramírez Castro**

Plataforma web donde un **administrador** crea cursos organizados en **módulos** y **lecciones con video**, los **estudiantes** se registran, se inscriben en los cursos, desarrollan las lecciones, las marcan como completadas y consultan su **porcentaje de avance**.

## Tecnologías

- PHP 8.3+ con **Laravel 13**
- **Filament 5** (paneles de administración, profesor y estudiante)
- **MySQL** 8 (también funciona con MariaDB)

## Requisitos

- PHP 8.3 o superior con las extensiones `pdo_mysql`, `mbstring`, `fileinfo` e `intl`
- [Composer](https://getcomposer.org/)
- MySQL en ejecución

No hace falta Node.js ni npm.

## Instalación y ejecución

```bash
# 1. Clonar el repositorio
git clone <url-del-repositorio>
cd ashleeproyecto

# 2. Instalar dependencias de PHP
composer install

# 3. Crear el archivo de configuración y la llave de la aplicación
cp .env.example .env
php artisan key:generate
```

4. Crear la base de datos vacía en MySQL:

```sql
CREATE DATABASE habilidades CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

5. Revisar en `.env` los datos de conexión (usuario y contraseña de MySQL):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=habilidades
DB_USERNAME=root
DB_PASSWORD=
```

6. Crear las tablas con los datos de prueba, enlazar la carpeta de archivos y arrancar el servidor:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Abrir <http://127.0.0.1:8000>.

> **Alternativa:** en lugar de `php artisan migrate --seed` se puede importar el script SQL incluido:
> `mysql -u root -p habilidades < database/habilidades.sql`

Para volver a dejar la base como al inicio (borra todo y carga los datos de prueba otra vez):

```bash
php artisan migrate:fresh --seed
```

## Paneles por rol

| Rol | Dirección | Qué puede hacer |
|---|---|---|
| Administrador | `/admin` | Ver el resumen y las gráficas de la plataforma. Crear, consultar, editar y eliminar cursos, módulos, lecciones y temáticas. Crear las cuentas de profesores y estudiantes. Ver el progreso de los inscritos. |
| Profesor | `/profesor` | Ver el resumen y las gráficas de sus cursos. Gestionar sus propios cursos, módulos y lecciones, y ver el progreso de sus estudiantes. Su cuenta la crea el administrador. |
| Estudiante | `/estudiante` | Registrarse, ver el catálogo (buscar y filtrar por temática), ver la vista previa de un curso, inscribirse, desarrollar las lecciones, marcarlas como completadas y ver su progreso. Desde el inicio puede continuar en la siguiente lección pendiente. |

Los cursos nuevos quedan en **borrador**: los estudiantes no los ven hasta que el administrador o el profesor los **publican**, y solo se pueden publicar si tienen al menos una lección. Si un curso vuelve a borrador, los estudiantes ya inscritos conservan su acceso.

Cada usuario solo puede entrar al panel de su rol. En los tres paneles, **Mi perfil** permite cambiar nombre, correo y contraseña.

## Usuarios de prueba

La contraseña de todos es **`password`**.

| Rol | Correo | Datos |
|---|---|---|
| Administrador | `admin@plataforma.com` | |
| Profesor | `profesor@plataforma.com` | Carlos Pérez |
| Estudiante | `laura@plataforma.com` | Inscrita en los 2 cursos; 2 de 4 lecciones de Excel completadas (50 %) |
| Estudiante | `andres@plataforma.com` | Inscrito en Excel básico, sin avance |
| Estudiante | `sofia@plataforma.com` | Sin inscripciones |

Cursos de prueba:

- **Excel básico** (Ofimática): módulos *Fórmulas* y *Gráficos*, 4 lecciones con video.
- **Programación con Python** (Programación): módulos *Fundamentos* y *Estructuras de control*, 4 lecciones con video.
- **Diseño con Canva** (Diseño gráfico): en **borrador**, con un módulo y sin lecciones todavía.

Los videos son tutoriales públicos de YouTube y se reproducen dentro de la plataforma.

## Base de datos

| Tabla | Descripción | Relaciones |
|---|---|---|
| `roles` | admin, profesor, estudiante | |
| `users` | Cuenta de acceso: nombre, correo y contraseña | `role_id` → `roles` |
| `profesores` | Identificación, edad y materia | `user_id` → `users` (único) |
| `estudiantes` | Identificación y edad | `user_id` → `users` (único) |
| `tematicas` | Ofimática, Programación, Diseño gráfico, Idiomas… | |
| `cursos` | Nombre, descripción, duración, portada y estado (publicado o borrador) | `profesor_id` → `profesores`, `tematica_id` → `tematicas` |
| `modulos` | Módulos de un curso, en orden | `curso_id` → `cursos` |
| `lecciones` | Contenido y video (enlace o archivo) | `modulo_id` → `modulos` |
| `clases` | Inscripciones (estudiante ↔ curso) | `estudiante_id`, `curso_id` (únicos juntos) |
| `progreso` | Lecciones completadas por cada estudiante | `estudiante_id`, `leccion_id` (únicos juntos) |

La temática se guarda una sola vez en `tematicas`. El nombre y el correo se guardan solo en `users`; `estudiantes` y `profesores` los toman de ahí por su `user_id`, así no hay datos repetidos.

El porcentaje de avance se calcula como *lecciones completadas del curso ÷ total de lecciones del curso × 100*.

## Recorrido de la sustentación

1. Entrar a `/admin` como administrador → **Cursos → Crear**. Después, en **Módulos y lecciones**, agregar un módulo con una lección y su video.
2. Entrar a `/estudiante` → **Registrarse** con un estudiante nuevo.
3. En **Catálogo**, pulsar **Inscribirme** en el curso creado. Aparece en **Mis cursos**.
4. **Ver contenido** → abrir la lección, reproducir el video y pulsar **Marcar como completada**.
5. El avance aparece en **Mi progreso** (estudiante) y en **Estudiantes inscritos y progreso** (admin, al editar el curso).
6. En MySQL, revisar las tablas `users`, `estudiantes`, `cursos`, `modulos`, `lecciones`, `clases` y `progreso`.

## Evidencias del plan de mejoramiento

En la carpeta [`docs/`](docs):

- [`Evidencias_Plan_Mejoramiento_Grupo2.pdf`](docs/Evidencias_Plan_Mejoramiento_Grupo2.pdf): diagrama relacional, normalización, mapa de navegación por rol, tabla de 40 pruebas y capturas de pantalla.
- [`evidencias.html`](docs/evidencias.html): el mismo documento en HTML (se abre en el navegador).
- [`capturas/`](docs/capturas): capturas de pantalla de cada panel.
- [`database/habilidades.sql`](database/habilidades.sql): script SQL con la estructura y los datos de prueba.
