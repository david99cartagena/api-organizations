#!/bin/bash
set -e

echo "Esperando a que MySQL esté listo..."
until mysql -h db -uroot -pmiPasswordSegura -e "SELECT 1" &> /dev/null; do
  echo -n "."
  sleep 2
done

echo "MySQL listo, ejecutando Laravel..."
exec "$@"
