#!/bin/bash

# ============================================
# SCRIPT DE ROLLBACK
# ============================================

set -e

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Cargar configuración
if [ -f "deploy-config.local.sh" ]; then
    source deploy-config.local.sh
else
    echo -e "${RED}✗ Error: No se encuentra deploy-config.local.sh${NC}"
    exit 1
fi

echo -e "\n${YELLOW}╔════════════════════════════════════════╗${NC}"
echo -e "${YELLOW}║   ROLLBACK DE PLUGINS                  ║${NC}"
echo -e "${YELLOW}╚════════════════════════════════════════╝${NC}\n"

# Seleccionar ambiente
echo "Selecciona el ambiente:"
echo "1) Staging"
echo "2) Producción"
read -p "Opción (1 o 2): " ENV_OPTION

if [ "$ENV_OPTION" = "1" ]; then
    SERVER_USER=$STAGING_USER
    SERVER_HOST=$STAGING_HOST
    SERVER_PATH=$STAGING_PATH
    SERVER_PORT=$STAGING_PORT
    ENV_NAME="STAGING"
elif [ "$ENV_OPTION" = "2" ]; then
    SERVER_USER=$PROD_USER
    SERVER_HOST=$PROD_HOST
    SERVER_PATH=$PROD_PATH
    SERVER_PORT=$PROD_PORT
    ENV_NAME="PRODUCCIÓN"
else
    echo -e "${RED}Opción inválida${NC}"
    exit 1
fi

echo -e "\n${YELLOW}Buscando backups en $ENV_NAME...${NC}\n"

# Listar backups disponibles
BACKUPS=$(ssh -p $SERVER_PORT $SERVER_USER@$SERVER_HOST "
    if [ -d ~/backups/wordpress-plugins ]; then
        ls -1t ~/backups/wordpress-plugins/*.tar.gz 2>/dev/null || echo 'NO_BACKUPS'
    else
        echo 'NO_BACKUPS'
    fi
")

if [ "$BACKUPS" = "NO_BACKUPS" ] || [ -z "$BACKUPS" ]; then
    echo -e "${RED}No se encontraron backups${NC}"
    exit 1
fi

echo -e "${BLUE}Backups disponibles:${NC}\n"
echo "$BACKUPS" | nl -w2 -s') '

echo ""
read -p "Selecciona el número del backup a restaurar: " BACKUP_NUM

SELECTED_BACKUP=$(echo "$BACKUPS" | sed -n "${BACKUP_NUM}p")

if [ -z "$SELECTED_BACKUP" ]; then
    echo -e "${RED}Selección inválida${NC}"
    exit 1
fi

echo -e "\n${YELLOW}Backup seleccionado:${NC} $SELECTED_BACKUP"
read -p "¿Confirmas el rollback en $ENV_NAME? (y/n): " -n 1 -r
echo

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${RED}Rollback cancelado${NC}"
    exit 1
fi

# Ejecutar rollback
echo -e "\n${YELLOW}Ejecutando rollback...${NC}"

ssh -p $SERVER_PORT $SERVER_USER@$SERVER_HOST "
    cd '$SERVER_PATH'

    # Extraer nombre del plugin del archivo de backup
    BACKUP_FILE='$SELECTED_BACKUP'
    PLUGIN_NAME=\$(basename \$BACKUP_FILE | sed 's/_[0-9]*\.tar\.gz//')

    echo 'Restaurando plugin: '\$PLUGIN_NAME

    # Crear backup del estado actual antes de rollback
    if [ -d \$PLUGIN_NAME ]; then
        tar -czf ~/backups/wordpress-plugins/\${PLUGIN_NAME}_before_rollback_\$(date +%Y%m%d_%H%M%S).tar.gz \$PLUGIN_NAME
    fi

    # Eliminar plugin actual
    rm -rf \$PLUGIN_NAME

    # Restaurar desde backup
    tar -xzf \$BACKUP_FILE -C .

    echo '✓ Rollback completado para '\$PLUGIN_NAME
"

echo -e "\n${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║   ROLLBACK COMPLETADO                  ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}\n"

echo -e "${YELLOW}Verifica el funcionamiento del sitio${NC}"
