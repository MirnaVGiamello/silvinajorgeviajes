@echo off
chcp 65001 > nul
echo  Iniciando Silvina Jorge Viajes...
docker-compose up -d
echo.
echo  Sitio:      http://localhost:8092
echo  phpMyAdmin: http://localhost:8093
echo.
