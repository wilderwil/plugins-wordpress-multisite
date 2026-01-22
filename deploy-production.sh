#!/bin/bash

# ============================================
# SCRIPT DE DEPLOYMENT A PRODUCCIÓN
# ============================================

set -e  # Salir si hay algún error

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
MAGENTA='\033[0;35m'
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

echo -e "\n${MAGENTA}╔════════════════════════════════════════╗${NC}"
echo -e "${MAGENTA}║   DEPLOYMENT A PRODUCCIÓN              ║${NC}"
echo -e "${MAGENTA}║   ⚠️  PRECAUCIÓN ⚠️                     ║${NC}"
echo -e "${MAGENTA}╚════════════════════════════════════════╝${NC}\n"

# Verificar que estamos en la rama correcta
CURRENT_BRANCH=$(git branch --show-current)
echo -e "${YELLOW}Rama actual: $CURRENT_BRANCH${NC}"

if [ "$CURRENT_BRANCH" != "main" ] && [ "$CURRENT_BRANCH" != "master" ]; then
    echo -e "${RED}✗ ADVERTENCIA: No estás en la rama main/master${NC}"
    read -p "¿Estás seguro de deployar desde '$CURRENT_BRANCH' a PRODUCCIÓN? (y/n) " -n 1 -r
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
    echo -e "${RED}No se puede deployar a producción con cambios sin commitear${NC}"
    exit 1
fi

# Confirmación adicional para producción
echo -e "\n${YELLOW}Plugins a deployar:${NC} $CUSTOM_PLUGINS"
echo -e "${YELLOW}Servidor:${NC} $PROD_HOST"
echo -e "${YELLOW}Último commit:${NC} $(git log -1 --oneline)"
echo ""
read -p "¿CONFIRMAS el deployment a PRODUCCIÓN? (escribe 'SI' en mayúsculas): " CONFIRM

if [ "$CONFIRM" != "SI" ]; then
    echo -e "${RED}Deployment cancelado${NC}"
    exit 1
fi

# Crear backup en servidor de producción
if [ "$BACKUP_ENABLED" = true ]; then
    echo -e "\n${YELLOW}Creando backup en producción...${NC}"
    BACKUP_DATE=$(date +%Y%m%d_%H%M%S)

    ssh -p $PROD_PORT $PROD_USER@$PROD_HOST "
        mkdir -p ~/backups/wordpress-plugins
        for plugin in $CUSTOM_PLUGINS; do
            if [ -d '$PROD_PATH/\$plugin' ]; then
                tar -czf ~/backups/wordpress-plugins/\${plugin}_${BACKUP_DATE}.tar.gz -C '$PROD_PATH' \$plugin
                echo '✓ Backup de \$plugin creado'
            fi
        done

        # Limpiar backups antiguos
        find ~/backups/wordpress-plugins -name '*.tar.gz' -mtime +$BACKUP_KEEP_DAYS -delete
    "
    echo -e "${GREEN}✓ Backup completado${NC}"
    echo -e "${BLUE}Ruta de backup: ~/backups/wordpress-plugins/*_${BACKUP_DATE}.tar.gz${NC}"
fi

# Deployment de cada plugin
echo -e "\n${YELLOW}Iniciando deployment a PRODUCCIÓN...${NC}\n"

for plugin in $CUSTOM_PLUGINS; do
    if [ -d "wp-content/plugins/$plugin" ]; then
        echo -e "${BLUE}Deploying plugin: $plugin${NC}"

        rsync $RSYNC_OPTIONS \
            -e "ssh -p $PROD_PORT" \
            "wp-content/plugins/$plugin/" \
            "$PROD_USER@$PROD_HOST:$PROD_PATH/$plugin/"

        echo -e "${GREEN}✓ $plugin deployed${NC}\n"
    else
        echo -e "${YELLOW}⚠ Plugin no encontrado: $plugin${NC}\n"
    fi
done

# Limpiar cache de WordPress
echo -e "\n${YELLOW}Limpiando cache...${NC}"
ssh -p $PROD_PORT $PROD_USER@$PROD_HOST "
    # Limpiar cache de objeto si existe
    if [ -d '$PROD_PATH/../../cache' ]; then
        rm -rf $PROD_PATH/../../cache/*
        echo '✓ Cache limpiado'
    fi
"

# Crear tag de versión
echo -e "\n${YELLOW}¿Deseas crear un tag de versión en Git? (recomendado)${NC}"
read -p "Versión (ej: v1.0.0) o Enter para omitir: " VERSION

if [ -n "$VERSION" ]; then
    git tag -a "$VERSION" -m "Deployment a producción - $VERSION"
    echo -e "${GREEN}✓ Tag $VERSION creado${NC}"
    echo -e "${YELLOW}Recuerda hacer: git push origin $VERSION${NC}"
fi

echo -e "\n${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║   DEPLOYMENT COMPLETADO                ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"

echo -e "\n${BLUE}Servidor:${NC} $PROD_HOST"
echo -e "${BLUE}Plugins desplegados:${NC} $CUSTOM_PLUGINS"
echo -e "${BLUE}Hora:${NC} $(date '+%Y-%m-%d %H:%M:%S')"
echo -e "${BLUE}Commit:${NC} $(git log -1 --oneline)"

# Notificación Slack (opcional)
if [ -n "$SLACK_WEBHOOK" ]; then
    curl -X POST -H 'Content-type: application/json' \
        --data "{\"text\":\"🚀 Deployment a PRODUCCIÓN completado\n• Plugins: $CUSTOM_PLUGINS\n• Por: $(git config user.name)\n• Commit: $(git log -1 --oneline)\"}" \
        $SLACK_WEBHOOK 2>/dev/null || true
fi

echo -e "\n${GREEN}✓ Verifica el funcionamiento en:${NC} https://$PROD_HOST"
