@echo off
chcp 65001 > nul
echo.
echo  Silvina Jorge Viajes - Configuracion inicial
echo  =============================================
echo.

echo  [1/5] Construyendo imagen Docker...
docker-compose build
if %errorlevel% neq 0 ( echo ERROR al construir Docker & pause & exit /b 1 )

echo.
echo  [2/5] Instalando CodeIgniter 4 (requiere internet)...
docker-compose run --rm app bash -c "composer create-project codeigniter4/appstarter /tmp/ci4 --no-interaction --quiet && cp -rn /tmp/ci4/. /var/www/html/ && rm -rf /tmp/ci4 && chown -R www-data:www-data /var/www/html/writable /var/www/html/public/uploads"
if %errorlevel% neq 0 ( echo ERROR al instalar CI4 & pause & exit /b 1 )

echo.
echo  [3/5] Configurando entorno...
if not exist .env copy env.template .env

echo.
echo  [4/5] Iniciando servicios...
docker-compose up -d
echo  Esperando base de datos...
timeout /t 20 /nobreak > nul

echo.
echo  [5/5] Migraciones e importacion de datos...
docker-compose exec app php spark migrate --all
docker-compose exec app php spark db:seed MainSeeder

echo.
echo  =============================================
echo   Listo!
echo.
echo   Sitio:       http://localhost:8092
echo   Admin:       http://localhost:8092/login
echo   phpMyAdmin:  http://localhost:8093
echo.
echo   Usuario admin:    admin / admin123
echo   Usuario operador: operador / operador123
echo  =============================================
echo.
pause
