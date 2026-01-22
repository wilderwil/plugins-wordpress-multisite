# 🚀 Guía Rápida de Inicio

## Setup en 5 Pasos

### 1️⃣ Configurar Git (2 minutos)

```bash
# Inicializar repositorio
git init

# Configurar tu identidad
git config user.name "Tu Nombre"
git config user.email "tu@email.com"

# Primer commit
git add .
git commit -m "Configuración inicial"
```

### 2️⃣ Configurar Servidores (3 minutos)

```bash
# Copiar plantilla de configuración
cp deploy-config.sh deploy-config.local.sh
```

Edita `deploy-config.local.sh`:

```bash
# STAGING
STAGING_USER="tu_usuario"
STAGING_HOST="staging.tudominio.com"
STAGING_PATH="/home/usuario/public_html/wp-content/plugins"

# PRODUCCIÓN
PROD_USER="tu_usuario"
PROD_HOST="tudominio.com"
PROD_PATH="/home/usuario/public_html/wp-content/plugins"

# Plugins personalizados (separados por espacio)
CUSTOM_PLUGINS="mi-plugin"
```

### 3️⃣ Configurar SSH (5 minutos)

```bash
# Generar clave SSH
ssh-keygen -t rsa -b 4096 -C "tu@email.com"
# Presiona Enter en todas las preguntas

# Copiar a staging
ssh-copy-id tu_usuario@staging.tudominio.com

# Copiar a producción
ssh-copy-id tu_usuario@tudominio.com

# Probar conexión
ssh tu_usuario@staging.tudominio.com "echo 'OK'"
```

### 4️⃣ Organizar Plugins (5 minutos)

```bash
# Crear estructura si no existe
mkdir -p wp-content/plugins

# Mover o crear tus plugins aquí
# wp-content/plugins/mi-plugin/
```

### 5️⃣ Dar Permisos a Scripts (1 minuto)

**Linux/Mac:**
```bash
chmod +x *.sh
```

**Windows Git Bash:**
```bash
git update-index --chmod=+x deploy-staging.sh
git update-index --chmod=+x deploy-production.sh
git update-index --chmod=+x rollback.sh
```

## ✅ Verificar Instalación

```bash
# Test 1: Verificar conexión SSH staging
ssh tu_usuario@staging.tudominio.com "echo 'Staging OK'"

# Test 2: Verificar conexión SSH producción
ssh tu_usuario@tudominio.com "echo 'Producción OK'"

# Test 3: Verificar rutas
ssh tu_usuario@staging.tudominio.com "ls -la /ruta/a/plugins"
```

## 🎯 Primer Deployment

### A Staging

```bash
# Asegurarte de tener cambios commiteados
git add .
git commit -m "Preparar para primer deployment"

# Deploy
./deploy-staging.sh
```

### A Producción

```bash
# Deploy
./deploy-production.sh

# Confirmar cuando te lo pida
```

## 📝 Workflow Diario Simplificado

```bash
# 1. Hacer cambios en tu plugin local
# ... editar archivos ...

# 2. Guardar en Git
git add .
git commit -m "Descripción de cambios"

# 3. Probar en staging
./deploy-staging.sh
# Verifica en: https://staging.tudominio.com

# 4. Si todo funciona, subir a producción
./deploy-production.sh
# Verifica en: https://tudominio.com
```

## 🆘 Si Algo Sale Mal

```bash
# Rollback rápido
./rollback.sh

# Selecciona:
# - Ambiente (staging o producción)
# - Backup más reciente (usualmente el #1)
```

## 💡 Tips

1. **Siempre prueba en staging primero**
2. **Los backups se crean automáticamente** antes de cada deployment
3. **Los backups se guardan 7 días** por defecto
4. **Usa mensajes descriptivos** en tus commits

## 🔗 Siguiente Paso

Lee el [README.md](README.md) completo para workflow avanzado y mejores prácticas.

## ❓ Preguntas Frecuentes

**¿Puedo hacer deployment de un solo plugin?**
Sí, edita `CUSTOM_PLUGINS` en `deploy-config.local.sh`

**¿Los archivos de WordPress core se suben?**
No, `.gitignore` los excluye automáticamente

**¿Se sube wp-config.php?**
No, está en `.gitignore` por seguridad

**¿Puedo deshacer un deployment?**
Sí, usa `./rollback.sh`

**¿Necesito detener el sitio durante deployment?**
No, rsync actualiza archivos sin downtime
