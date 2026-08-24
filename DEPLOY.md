# Cómo subir Silvina Jorge Viajes a producción (hosting compartido)

Pensado para un hosting compartido tipo Hostinger, con Gestor de archivos + phpMyAdmin
(sin SSH), igual que los demás sistemas (Cambakey, bicicletería).

La carpeta del sitio en el servidor debe tener la misma estructura que este repo:
`app/`, `public/`, `vendor/`, `writable/`, `.env`, `.htaccess`.

## Primera instalación

1. Generar localmente el paquete completo (con `vendor/` incluido, ya que el hosting
   no tiene Composer): correr `composer install --no-dev --optimize-autoloader` antes
   de armar el zip.
2. Subir todo el contenido del proyecto a `public_html/viajes/` (o el subdominio que
   corresponda), **excepto** `.git/`.
3. Renombrar `.htaccess.production` a `.htaccess` dentro de esa carpeta, y ajustar la
   ruta `/viajes/` si el subdirectorio tiene otro nombre.
4. Copiar `env.template` a `.env` y completar los datos reales del hosting:
   - `CI_ENVIRONMENT = production`
   - `app.baseURL` con la URL final (ej. `https://tusitio.com/viajes/`)
   - `database.default.*` con los datos de la base MySQL creada en el panel de Hostinger
5. Crear la base de datos MySQL desde el panel del hosting y, con phpMyAdmin, importar
   el `.sql` con la estructura (exportado desde el entorno local tras correr
   `php spark migrate --all` y `php spark db:seed MainSeeder`).
6. Dar permisos de escritura a la carpeta `writable/` (y sus subcarpetas `cache`,
   `logs`, `session`, `debugbar`) y a `public/uploads/` (ahí se guardan las fotos de
   las promociones que suba el operador).
7. Probar el login con el usuario admin y cambiar la contraseña por defecto. Cargar
   los datos reales de contacto en **Configuración del sitio** (WhatsApp, email,
   redes) — sin esos datos el sitio público no muestra el botón de WhatsApp ni la
   información de contacto.

## Actualizaciones posteriores

**Regla general: solo se actualiza la carpeta `app/`.** `vendor/` no cambia salvo que
se agregue una librería nueva. `public/` tampoco cambia salvo que se agreguen o
modifiquen archivos de `public/assets/` (CSS/JS/logo) — **nunca se toca
`public/uploads/`**, ahí viven las fotos de las promociones ya cargadas. `writable/`
y `.env` **nunca se tocan**.

1. Backup: renombrar `app` a `app_backup` (o `app_backup_FECHA`) en el Gestor de
   archivos.
2. Subir el zip con la carpeta `app/` actualizada (y `public/assets/` si cambió algo
   de diseño) y extraer.
3. Si hay una migración nueva: entrar a phpMyAdmin → pestaña **SQL** → correr el
   script indicado.
4. Probar el sitio. Si todo funciona, borrar `app_backup`; si algo se rompe, restaurar
   el backup.
