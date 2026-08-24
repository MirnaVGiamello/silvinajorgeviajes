# Silvina Jorge Viajes — Sitio web y panel de promociones

Sitio de venta y promoción de turismo, con panel de administración para cargar
promociones sin tocar código.

Stack: PHP 8.2 (CodeIgniter 4) + MySQL 8, corriendo con Docker para desarrollo.
Pensado para desplegarse en hosting compartido (ver [DEPLOY.md](DEPLOY.md)).

## Requisitos

- Docker Desktop

## Levantar el proyecto (desarrollo)

Primera vez:

```
setup.bat
```

Esto construye la imagen, instala CodeIgniter 4, levanta los contenedores y corre las
migraciones + carga de datos iniciales.

Las próximas veces, para volver a levantar todo:

```
iniciar.bat
```

- Sitio:      http://localhost:8092
- Admin:      http://localhost:8092/login
- phpMyAdmin: http://localhost:8093

### Usuarios de prueba

| Usuario  | Contraseña   | Perfil |
|---|---|---|
| admin    | admin123     | Administrador (usuarios, configuración del sitio y promociones) |
| operador | operador123  | Operador (solo puede cargar/editar promociones) |

**Cambiar estas contraseñas antes de pasar a producción.**

## Logo / estética

El sitio usa una paleta y tipografías (Playfair Display + Sacramento) inspiradas en
el logo de referencia (globo terráqueo, palmera, ícono de avión, "Sueña · Explora ·
Descubre"), pero el logo en sí **no está incluido como imagen** — el encabezado y el
pie de página muestran el nombre "Silvina Jorge Viajes" con tipografía en vez del
isotipo ilustrado.

Si tenés el archivo real del logo (PNG o SVG con fondo transparente), colocalo en
`public/assets/img/logo.png` y avisá para reemplazar el texto por la imagen en
[app/Views/layout.php](app/Views/layout.php) y [app/Views/admin/layout.php](app/Views/admin/layout.php).

## Estructura

- `app/Controllers` — `Home`, `Promociones`, `Nosotros`, `Contacto` (sitio público) y
  `Admin\*` (panel).
- `app/Controllers/Admin/Promociones.php` — ABM de promociones con imagen de portada
  y galería (accesible a admin y operador).
- `app/Controllers/Admin/Usuarios.php`, `Admin/Configuracion.php` — solo admin.
- `app/Models` — `Promocion`, `PromocionImagen`, `Usuario`, `Configuracion`.
- `app/Database/Migrations` — estructura de la base de datos.
- `app/Database/Seeds/MainSeeder.php` — usuarios de prueba, configuración inicial y
  una promoción de ejemplo.
- `app/Views` — vistas públicas (mobile-first) y vistas del panel (`admin/`).
- `public/uploads/promociones/{id}/` — imágenes subidas desde el panel (no se borran
  al actualizar el código, ver DEPLOY.md).

## Módulos

- **Sitio público**: inicio con promociones destacadas, listado de promociones con
  filtro por destino/categoría, detalle de cada promoción con galería y botón de
  WhatsApp, "Nosotros" y "Contacto" (con los datos cargados en Configuración).
- **Panel**: ABM de promociones (admin y operador), usuarios y configuración del
  sitio (solo admin).

## Comandos útiles dentro del contenedor

```
docker compose exec app php spark migrate --all
docker compose exec app php spark db:seed MainSeeder
docker compose exec app php spark routes
```
