#!/bin/bash
set -Eeuo pipefail

APP_DIR="/home/adminvolta/web/sga.ueavolta.edu.ec/public_html/sga-av"
PHP_BIN="php8.4"
COMPOSER_BIN="composer"
NPM_BIN="npm"
BRANCH="main"

cd "$APP_DIR"

echo "🚀 Iniciando despliegue..."

PREVIOUS_COMMIT="$(git rev-parse HEAD)"
APP_WAS_DOWN=0

cleanup() {
  if [ "$APP_WAS_DOWN" -eq 0 ]; then
    echo "🔓 Saliendo de modo mantenimiento..."
    $PHP_BIN artisan up || true
  fi
}

rollback() {
  echo "❌ Error detectado. Iniciando rollback básico..."

  echo "↩️ Volviendo al commit anterior: $PREVIOUS_COMMIT"
  git reset --hard "$PREVIOUS_COMMIT"

  echo "🧹 Limpiando cachés..."
  $PHP_BIN artisan optimize:clear || true

  echo "📦 Restaurando dependencias PHP..."
  $COMPOSER_BIN install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true

  echo "🛣️ Regenerando Wayfinder..."
  $PHP_BIN artisan wayfinder:generate --with-form || true

  echo "🎨 Recompilando assets..."
  $NPM_BIN ci || true
  $NPM_BIN run build || true

  echo "⚡ Recacheando Laravel..."
  $PHP_BIN artisan config:cache || true
  $PHP_BIN artisan route:cache || true
  $PHP_BIN artisan view:cache || true

  echo "🔁 Reiniciando colas..."
  $PHP_BIN artisan queue:restart || true

  echo "🔓 Levantando aplicación..."
  $PHP_BIN artisan up || true

  echo "🛑 Rollback terminado. Revisa logs para ver la causa original."
}

on_error() {
  rollback
  exit 1
}

trap on_error ERR
trap cleanup EXIT

if $PHP_BIN artisan about >/dev/null 2>&1; then
  :
else
  echo "No se pudo ejecutar artisan con $PHP_BIN"
  exit 1
fi

if $PHP_BIN artisan is-down >/dev/null 2>&1; then
  APP_WAS_DOWN=1
fi

echo "🚧 Poniendo la aplicación en modo mantenimiento..."
$PHP_BIN artisan down || true

echo "📥 Actualizando código desde Git..."
git fetch origin
git checkout "$BRANCH"
git pull origin "$BRANCH"

echo "📦 Instalando dependencias PHP..."
export COMPOSER_ALLOW_SUPERUSER=1
$COMPOSER_BIN install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "🧹 Limpiando cachés anteriores..."
$PHP_BIN artisan optimize:clear

echo "🗄️ Ejecutando migraciones..."
$PHP_BIN artisan migrate --force

echo "🛣️ Generando rutas/types para frontend..."
$PHP_BIN artisan wayfinder:generate --with-form

echo "🎨 Instalando dependencias JS..."
$NPM_BIN ci

echo "🏗️ Compilando assets..."
$NPM_BIN run build

echo "⚡ Cacheando Laravel..."
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

echo "🔁 Reiniciando colas..."
$PHP_BIN artisan queue:restart || true

echo "✅ Despliegue completado con éxito."
$PHP_BIN artisan up