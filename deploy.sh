#!/bin/bash
set -e

echo "🚀 Iniciando despliegue..."

# Entrar en modo mantenimiento
echo "🚧 Poniendo la aplicación en modo mantenimiento..."
php artisan down || true

# Traer los últimos cambios
echo "📥 Trayendo cambios de Git..."
git pull origin main

# Instalar dependencias de PHP
echo "📦 Instalando dependencias de PHP (Composer)..."
export COMPOSER_ALLOW_SUPERUSER=1
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Ejecutar migraciones
echo "🗄️ Ejecutando migraciones de base de datos..."
php artisan migrate --force

# Instalar dependencias de JS y compilar
echo "🎨 Compilando assets (NPM)..."
npm install
php artisan wayfinder:generate
npm run build

# Limpiar y optimizar cachés
echo "⚡ Optimizando cachés..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Salir del modo mantenimiento
echo "✅ Despliegue completado con éxito!"
php artisan up

echo "🌟 La aplicación está en línea."
