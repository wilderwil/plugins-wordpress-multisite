#!/bin/bash

# ============================================
# SCRIPT DE DEPLOYMENT A STAGING
# ============================================

set -e  # Salir si hay algún error

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Cargar configuración
if [ -f "deploy-config.local.sh" ]; then
    source deploy-config.local.sh
    echo -e "${GREEN}✓ Configuración local cargada${NC}"
else
    echo -e "${RED}✗ Error: No se encuentra deploy-config.local.sh${NC}"
    echo "Copia deploy-config.sh a deploy-config.local.sh y configúralo"
    exit 1
fi

echo -e "\n${BLUE}╔════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   DEPLOYMENT A STAGING                 ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════╝${NC}\n"

# Verificar que estamos en la rama correcta
CURRENT_BRANCH=$(git branch --show-current)
echo -e "${YELLOW}Rama actual: $CURRENT_BRANCH${NC}"

if [ "$CURRENT_BRANCH" != "staging" ] && [ "$CURRENT_BRANCH" != "develop" ]; then
    read -p "¿Estás seguro de deployar desde la rama '$CURRENT_BRANCH'? (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo -e "${RED}Deployment cancelado${NC}"
        exit 1
    fi
fi

# Verificar que no hay cambios sin commitear
if [[ -n $(git status -s) ]]; then
    echo -e "${RED}✗ Hay cambios sin commitear${NC}"
    git status -s
    read -p "¿Continuar de todas formas? (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Crear backup en servidor staging
if [ "$BACKUP_ENABLED" = true ]; then
    echo -e "\n${YELLOW}Creando backup en staging...${NC}"
    BACKUP_DATE=$(date +%Y%m%d_%H%M%S)

    ssh -p $STAGING_PORT $STAGING_USER@$STAGING_HOST "
        mkdir -p ~/backups/wordpress-plugins
        for plugin in $CUSTOM_PLUGINS; do
            if [ -d '$STAGING_PATH/\$plugin' ]; then
                tar -czf ~/backups/wordpress-plugins/\${plugin}_${BACKUP_DATE}.tar.gz -C '$STAGING_PATH' \$plugin
                echo '✓ Backup de \$plugin creado'
            fi
        done

        # Limpiar backups antiguos
        find ~/backups/wordpress-plugins -name '*.tar.gz' -mtime +$BACKUP_KEEP_DAYS -delete
    "
    echo -e "${GREEN}✓ Backup completado${NC}"
fi

# Deployment de cada plugin
echo -e "\n${YELLOW}Iniciando deployment...${NC}\n"

for plugin in $CUSTOM_PLUGINS; do
    if [ -d "wp-content/plugins/$plugin" ]; then
        echo -e "${BLUE}Deploying plugin: $plugin${NC}"

        # Crear directorio en servidor si no existe
        ssh -p $STAGING_PORT $STAGING_USER@$STAGING_HOST "mkdir -p $STAGING_PATH/$plugin"

        # Copiar archivos usando scp (alternativa a rsync para Windows)
        scp -r -P $STAGING_PORT "wp-content/plugins/$plugin/"* "$STAGING_USER@$STAGING_HOST:$STAGING_PATH/$plugin/"

        echo -e "${GREEN}✓ $plugin deployed${NC}\n"
    else
        echo -e "${YELLOW}⚠ Plugin no encontrado: $plugin${NC}\n"
    fi
done

# Limpiar cache de WordPress (opcional)
echo -e "\n${YELLOW}Limpiando cache...${NC}"
ssh -p $STAGING_PORT $STAGING_USER@$STAGING_HOST "
    # Limpiar cache de objeto si existe
    if [ -d '$STAGING_PATH/../../cache' ]; then
        rm -rf $STAGING_PATH/../../cache/*
        echo '✓ Cache limpiado'
    fi
"

echo -e "\n${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║   DEPLOYMENT COMPLETADO                ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"

echo -e "\n${BLUE}Servidor:${NC} $STAGING_HOST"
echo -e "${BLUE}Plugins desplegados:${NC} $CUSTOM_PLUGINS"
echo -e "${BLUE}Hora:${NC} $(date '+%Y-%m-%d %H:%M:%S')"

# Notificación Slack (opcional)
if [ -n "$SLACK_WEBHOOK" ]; then
    curl -X POST -H 'Content-type: application/json' \
        --data "{\"text\":\"✓ Deployment a STAGING completado\n• Plugins: $CUSTOM_PLUGINS\n• Por: $(git config user.name)\"}" \
        $SLACK_WEBHOOK 2>/dev/null || true
fi

echo -e "\n${YELLOW}Próximos pasos:${NC}"
echo "1. Verificar funcionamiento en staging"
echo "2. Ejecutar ./deploy-production.sh para pasar a producción"
