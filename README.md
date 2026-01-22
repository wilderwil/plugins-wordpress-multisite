# WordPress Multisitio - Sistema de Deployment con Git

Sistema de control de versiones y deployment automatizado para plugins personalizados de WordPress Multisitio.

## 🚀 Características

- Control de versiones con Git
- Deployment automatizado a staging y producción
- Backups automáticos antes de cada deployment
- Sistema de rollback rápido
- Workflow profesional: Local → Staging → Producción

## 📋 Requisitos

- Git instalado localmente
- Acceso SSH a servidores staging y producción
- rsync (viene incluido en Linux/Mac, en Windows usar Git Bash o WSL)

## ⚙️ Configuración Inicial

### 1. Configurar Git

```bash
# Inicializar repositorio (si no existe)
git init

# Configurar usuario
git config user.name "Tu Nombre"
git config user.email "tu@email.com"

# Hacer commit inicial
git add .
git commit -m "Configuración inicial del sistema de deployment"
```

### 2. Configurar Servidores

```bash
# Copiar archivo de configuración
cp deploy-config.sh deploy-config.local.sh

# Editar deploy-config.local.sh con tus datos
```

Edita `deploy-config.local.sh` y configura:

```bash
# STAGING
STAGING_USER="tu_usuario_ssh"
STAGING_HOST="staging.tudominio.com"
STAGING_PATH="/home/usuario/public_html/wp-content/plugins"
STAGING_PORT="22"

# PRODUCCIÓN
PROD_USER="tu_usuario_ssh"
PROD_HOST="tudominio.com"
PROD_PATH="/home/usuario/public_html/wp-content/plugins"
PROD_PORT="22"

# Plugins a deployar
CUSTOM_PLUGINS="mi-plugin-1 mi-plugin-2"
```

### 3. Configurar Claves SSH (Recomendado)

Para evitar ingresar contraseña en cada deployment:

```bash
# Generar clave SSH si no tienes una
ssh-keygen -t rsa -b 4096 -C "tu@email.com"

# Copiar clave al servidor staging
ssh-copy-id -p 22 usuario@staging.tudominio.com

# Copiar clave al servidor producción
ssh-copy-id -p 22 usuario@tudominio.com
```

### 4. Dar Permisos de Ejecución a Scripts

**En Linux/Mac:**
```bash
chmod +x deploy-staging.sh
chmod +x deploy-production.sh
chmod +x rollback.sh
```

**En Windows (Git Bash):**
Los scripts deberían funcionar directamente, pero si hay problemas:
```bash
git update-index --chmod=+x deploy-staging.sh
git update-index --chmod=+x deploy-production.sh
git update-index --chmod=+x rollback.sh
```

## 🔄 Workflow Recomendado

### Estructura de Branches

```
main/master    → Código en producción
├── staging    → Código en servidor staging
└── develop    → Desarrollo activo
    └── feature/* → Features en desarrollo
```

### Crear Estructura de Branches

```bash
# Crear branch develop
git checkout -b develop

# Crear branch staging
git checkout -b staging

# Volver a main
git checkout main
```

## 📦 Uso Diario

### 1. Desarrollar Nueva Funcionalidad

```bash
# Crear branch de feature
git checkout develop
git checkout -b feature/nueva-funcionalidad

# Trabajar en tus cambios
# ... editar archivos ...

# Commit
git add .
git commit -m "Descripción de los cambios"

# Merge a develop
git checkout develop
git merge feature/nueva-funcionalidad
```

### 2. Deployment a Staging

```bash
# Merge develop a staging
git checkout staging
git merge develop

# Deploy a servidor staging
./deploy-staging.sh

# Verificar en: https://staging.tudominio.com
```

### 3. Deployment a Producción

```bash
# Merge staging a main
git checkout main
git merge staging

# Deploy a producción
./deploy-production.sh

# El script te pedirá confirmación y opcionalmente crear un tag
```

### 4. Rollback en Caso de Error

```bash
# Ejecutar script de rollback
./rollback.sh

# Seleccionar ambiente (staging o producción)
# Seleccionar backup a restaurar
```

## 📁 Estructura de Archivos

```
proyecto/
├── .git/                          # Repositorio Git
├── .gitignore                     # Archivos ignorados por Git
├── deploy-config.sh               # Plantilla de configuración
├── deploy-config.local.sh         # Tu configuración (NO se sube a Git)
├── deploy-staging.sh              # Script deployment staging
├── deploy-production.sh           # Script deployment producción
├── rollback.sh                    # Script de rollback
├── README.md                      # Esta documentación
└── wp-content/
    └── plugins/
        ├── mi-plugin-1/           # Tu plugin personalizado
        └── mi-plugin-2/           # Otro plugin personalizado
```

## 🔧 Comandos Útiles

### Git

```bash
# Ver estado actual
git status

# Ver historial de commits
git log --oneline

# Ver diferencias
git diff

# Crear tag de versión
git tag -a v1.0.0 -m "Versión 1.0.0"

# Push con tags
git push origin main --tags
```

### SSH y Rsync

```bash
# Conectar a servidor
ssh usuario@servidor.com

# Ver backups disponibles
ssh usuario@servidor.com "ls -lh ~/backups/wordpress-plugins/"

# Verificar espacio en disco
ssh usuario@servidor.com "df -h"
```

## ⚠️ Buenas Prácticas

1. **NUNCA edites directamente en producción**
2. **Siempre prueba en staging primero**
3. **Haz commits frecuentes con mensajes descriptivos**
4. **Verifica el sitio después de cada deployment**
5. **Mantén backups antes de deployments importantes**
6. **Usa tags para versiones importantes**
7. **No subas `deploy-config.local.sh` al repositorio**

## 🎯 Mensajes de Commit

Usa mensajes claros y descriptivos:

```bash
# Bueno ✓
git commit -m "Añadir validación de formulario de contacto"
git commit -m "Corregir error en cálculo de precios"
git commit -m "Actualizar estilos del menú principal"

# Malo ✗
git commit -m "fix"
git commit -m "cambios"
git commit -m "update"
```

## 🆘 Solución de Problemas

### Error: Permission denied (publickey)

```bash
# Verificar clave SSH
ssh -T usuario@servidor.com

# Si falla, copiar clave nuevamente
ssh-copy-id usuario@servidor.com
```

### Error: rsync command not found

```bash
# En Windows, asegúrate de usar Git Bash
# O instala rsync en WSL
```

### Deployment se queda congelado

```bash
# Verificar conexión SSH
ssh usuario@servidor.com "echo 'Conexión OK'"

# Revisar permisos en servidor
ssh usuario@servidor.com "ls -la /ruta/a/plugins"
```

## 📞 Soporte

Para problemas o dudas, documenta:
1. El comando que ejecutaste
2. El error completo que recibiste
3. El contenido de `deploy-config.local.sh` (sin contraseñas)

## 📝 Changelog

### v1.0.0
- Sistema inicial de deployment
- Scripts para staging y producción
- Sistema de backups automáticos
- Script de rollback
