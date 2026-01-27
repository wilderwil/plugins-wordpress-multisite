# WordPress Multisitio - Sistema de Deployment con Git

Sistema de control de versiones y deployment automatizado para plugins personalizados de WordPress Multisitio con integración a GitHub.

## 🚀 Características

- Control de versiones con Git + GitHub
- Deployment automatizado a staging y producción
- Backups automáticos antes de cada deployment
- Sistema de rollback rápido
- Workflow profesional: Local → GitHub → Staging → Producción
- Colaboración mediante Pull Requests
- Sistema de Issues para bugs y features

## 📋 Requisitos

- Git instalado localmente
- Cuenta en GitHub
- Acceso SSH configurado para GitHub
- Acceso SSH a servidores staging y producción
- rsync (viene incluido en Linux/Mac, en Windows usar Git Bash o WSL)

## ⚙️ Configuración Inicial

### 1. Clonar el Repositorio

```bash
# Clonar desde GitHub
git clone git@github.com:wilderwil/plugins-wordpress-multisite.git
cd plugins-wordpress-multisite

# O si ya existe localmente, conectar con GitHub
git remote add origin git@github.com:wilderwil/plugins-wordpress-multisite.git
git branch -M master
git push -u origin master
```

### 1.1 Configurar Git (si es primera vez)

```bash
# Configurar usuario
git config user.name "Tu Nombre"
git config user.email "tu@email.com"
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
# Asegurarte de estar actualizado
git checkout develop
git pull origin develop

# Crear branch de feature
git checkout -b feature/nueva-funcionalidad

# Trabajar en tus cambios
# ... editar archivos ...

# Commit
git add .
git commit -m "feat: Descripción de los cambios"

# Push feature a GitHub (opcional, para respaldo)
git push origin feature/nueva-funcionalidad

# Merge a develop
git checkout develop
git merge feature/nueva-funcionalidad

# Push develop actualizado a GitHub
git push origin develop

# Eliminar branch de feature (opcional)
git branch -d feature/nueva-funcionalidad
git push origin --delete feature/nueva-funcionalidad
```

### 2. Deployment a Staging

```bash
# Actualizar staging
git checkout staging
git pull origin staging

# Merge develop a staging
git merge develop

# Push staging a GitHub
git push origin staging

# Deploy a servidor staging
./deploy-staging.sh

# Verificar en: https://staging.tudominio.com
```

### 3. Deployment a Producción

```bash
# Actualizar master
git checkout master
git pull origin master

# Merge staging a master
git merge staging

# Push master a GitHub
git push origin master

# Crear tag de versión (recomendado)
git tag -a v1.0.0 -m "Versión 1.0.0 - Descripción"
git push origin v1.0.0

# Deploy a producción
./deploy-production.sh

# El script te pedirá confirmación
```

### 4. Rollback en Caso de Error

```bash
# Ejecutar script de rollback
./rollback.sh

# Seleccionar ambiente (staging o producción)
# Seleccionar backup a restaurar
```

## 👥 Colaboración con GitHub

### Recibir Contribuciones de Otros

Los colaboradores pueden contribuir mediante Pull Requests:

1. **Ellos hacen Fork** del repositorio
2. **Clonan su fork** y crean una branch desde `develop`
3. **Hacen cambios** y push a su fork
4. **Crean Pull Request** hacia tu branch `develop`
5. **Tú revisas** el código en GitHub
6. **Apruebas y haces merge** si todo está correcto

### Actualizar tu Local después de un PR

```bash
# Cuando apruebes un PR en GitHub
git checkout develop
git pull origin develop

# Continuar con el flujo normal (staging → producción)
```

### Trabajar con Colaboradores Directos

Si agregas colaboradores con acceso de escritura:

```bash
# Ellos clonan el repo
git clone git@github.com:wilderwil/plugins-wordpress-multisite.git

# Trabajan igual que tú
git checkout develop
git pull origin develop
git checkout -b feature/nueva-funcionalidad
# ... hacer cambios ...
git commit -m "feat: Nueva funcionalidad"
git push origin feature/nueva-funcionalidad

# Merge a develop
git checkout develop
git merge feature/nueva-funcionalidad
git push origin develop
```

### Issues y Seguimiento

- **Reportar bugs**: https://github.com/wilderwil/plugins-wordpress-multisite/issues
- **Proponer features**: Crear un Issue con la etiqueta "enhancement"
- **Discusiones**: Usar la sección de Discussions si está habilitada

Para más detalles sobre cómo contribuir, consulta [CONTRIBUTING.md](CONTRIBUTING.md)

## 📁 Estructura de Archivos

```
proyecto/
├── .git/                          # Repositorio Git
├── .github/                       # Configuración de GitHub
│   ├── PULL_REQUEST_TEMPLATE.md  # Template para PRs
│   └── ISSUE_TEMPLATE/           # Templates para Issues
├── .gitignore                     # Archivos ignorados por Git
├── CONTRIBUTING.md                # Guía de contribución
├── LICENSE                        # Licencia del proyecto
├── deploy-config.sh               # Plantilla de configuración
├── deploy-config.local.sh         # Tu configuración (NO se sube a Git)
├── deploy-staging.sh              # Script deployment staging
├── deploy-production.sh           # Script deployment producción
├── rollback.sh                    # Script de rollback
├── README.md                      # Esta documentación
├── QUICKSTART.md                  # Guía rápida de inicio
└── wp-content/
    └── plugins/
        ├── mi-plugin-1/           # Tu plugin personalizado
        └── mi-plugin-2/           # Otro plugin personalizado
```

## 🔧 Comandos Útiles

### Git Local

```bash
# Ver estado actual
git status

# Ver historial de commits
git log --oneline

# Ver diferencias
git diff

# Ver branches
git branch -a
```

### Git + GitHub

```bash
# Sincronizar con GitHub
git pull origin develop
git push origin develop

# Crear tag de versión
git tag -a v1.0.0 -m "Versión 1.0.0"
git push origin v1.0.0

# Ver tags
git tag -l

# Ver info de remotos
git remote -v

# Actualizar todas las branches desde GitHub
git fetch origin

# Ver diferencias con GitHub
git diff origin/develop
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
4. **Sincroniza con GitHub regularmente** (`git pull` antes de empezar, `git push` después de commits)
5. **Verifica el sitio después de cada deployment**
6. **Mantén backups antes de deployments importantes**
7. **Usa tags para versiones importantes**
8. **No subas `deploy-config.local.sh` al repositorio**
9. **Revisa Pull Requests cuidadosamente antes de aprobar**
10. **Usa branches de feature para desarrollos nuevos**

## 🎯 Mensajes de Commit

Usa mensajes claros y descriptivos con prefijos:

```bash
# Bueno ✓
git commit -m "feat: Añadir validación de formulario de contacto"
git commit -m "fix: Corregir error en cálculo de precios"
git commit -m "style: Actualizar estilos del menú principal"
git commit -m "docs: Actualizar documentación de API"
git commit -m "refactor: Reorganizar estructura de archivos"

# Malo ✗
git commit -m "fix"
git commit -m "cambios"
git commit -m "update"
```

**Prefijos recomendados:**
- `feat:` Nueva funcionalidad
- `fix:` Corrección de bugs
- `docs:` Cambios en documentación
- `style:` Cambios de estilo/formato
- `refactor:` Refactorización de código
- `test:` Añadir o modificar tests
- `chore:` Tareas de mantenimiento

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

### Reportar Problemas

Abre un Issue en GitHub: https://github.com/wilderwil/plugins-wordpress-multisite/issues

Incluye:
1. El comando que ejecutaste
2. El error completo que recibiste
3. El contenido de `deploy-config.local.sh` (sin contraseñas)
4. Tu sistema operativo y versión de Git

### Contribuir

Lee [CONTRIBUTING.md](CONTRIBUTING.md) para saber cómo contribuir al proyecto.

### Enlaces Útiles

- **Repositorio**: https://github.com/wilderwil/plugins-wordpress-multisite
- **Issues**: https://github.com/wilderwil/plugins-wordpress-multisite/issues
- **Pull Requests**: https://github.com/wilderwil/plugins-wordpress-multisite/pulls

## 📝 Changelog

### v1.1.0
- Integración con GitHub
- Documentación de colaboración
- Templates para Issues y PRs
- Licencia MIT

### v1.0.0
- Sistema inicial de deployment
- Scripts para staging y producción
- Sistema de backups automáticos
- Script de rollback

## 🎯 Ejemplo Completo: Ciclo de Desarrollo

### Caso Real: Crear un nuevo plugin

```bash
# ====================================
# 1. PREPARAR AMBIENTE DE DESARROLLO
# ====================================
git checkout develop
git pull origin develop
git checkout -b feature/hello-plugin

# ====================================
# 2. DESARROLLAR Y CREAR ARCHIVOS
# ====================================
# Crear tu plugin en: wp-content/plugins/hello-ztgroup/
# - hello-ztgroup.php (archivo principal)
# - README.md (documentación)
# ... editar archivos ...

# Ver cambios
git status
git diff

# ====================================
# 3. COMMIT Y PUSH A GITHUB
# ====================================
git add wp-content/plugins/hello-ztgroup/
git commit -m "$(cat <<'EOF'
feat: Agregar plugin Hello ZTGroup de ejemplo

- Crear plugin básico de WordPress
- Incluye mensaje en dashboard y página de admin
- Hooks de activación/desactivación

Co-Authored-By: Claude Sonnet 4.5 <noreply@anthropic.com>
EOF
)"

# Subir feature branch a GitHub (opcional, para backup)
git push origin feature/hello-plugin

# ====================================
# 4. INTEGRAR A DEVELOP
# ====================================
git checkout develop
git merge feature/hello-plugin
git push origin develop

# ====================================
# 5. PASAR A STAGING (PRUEBAS)
# ====================================
git checkout staging
git pull origin staging
git merge develop
git push origin staging

# Actualizar deploy-config.local.sh con el nuevo plugin
# CUSTOM_PLUGINS="hello-ztgroup"

# Deploy a servidor staging
./deploy-staging.sh

# ⚠️ IMPORTANTE: Probar en staging
# Verificar en: https://staging.tudominio.com/wp-admin
# - Activar el plugin
# - Probar todas las funcionalidades
# - Verificar que no hay errores

# ====================================
# 6. PASAR A PRODUCCIÓN
# ====================================
git checkout master
git pull origin master
git merge staging
git push origin master

# Crear tag de versión
git tag -a v1.0.0 -m "Versión 1.0.0 - Plugin Hello ZTGroup inicial"
git push origin v1.0.0

# Deploy a producción (requiere confirmación)
./deploy-production.sh

# ⚠️ IMPORTANTE: Verificar en producción
# https://tudominio.com/wp-admin

# ====================================
# 7. LIMPIEZA Y CONTINUAR
# ====================================
# Eliminar feature branch (ya no es necesaria)
git branch -d feature/hello-plugin
git push origin --delete feature/hello-plugin

# Volver a develop para próxima funcionalidad
git checkout develop

# Ver estado final
git log --oneline --graph --all -10
git tag -l
```

### Resumen Visual del Flujo

```
develop (actualizado)
   ↓
feature/hello-plugin (crear branch)
   ↓
[Desarrollar código]
   ↓
commit + push a GitHub
   ↓
merge → develop → push
   ↓
merge → staging → push
   ↓
./deploy-staging.sh (probar)
   ↓
merge → master → push
   ↓
tag v1.0.0 → push
   ↓
./deploy-production.sh (deploy)
   ↓
Eliminar feature branch
   ↓
Volver a develop (listo para próxima feature)
```

### Tips Importantes

1. **Siempre sincroniza antes de empezar:**
   ```bash
   git checkout develop
   git pull origin develop
   ```

2. **Usa mensajes de commit descriptivos:**
   - ✅ `feat: Agregar validación de email en formulario`
   - ❌ `cambios` o `update`

3. **Prueba en staging antes de producción:**
   - No saltes el paso de staging
   - Verifica que todo funcione correctamente

4. **Usa tags para versiones importantes:**
   ```bash
   git tag -a v1.0.0 -m "Descripción de la versión"
   git push origin v1.0.0
   ```

5. **Limpia branches cuando termines:**
   ```bash
   git branch -d feature/nombre
   git push origin --delete feature/nombre
   ```

6. **Verifica el estado frecuentemente:**
   ```bash
   git status
   git log --oneline --graph --all -5
   ```

## 📄 Licencia

MIT License - Ver [LICENSE](LICENSE) para más detalles.
