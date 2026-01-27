# Guía de Pull Requests en GitHub

## ¿Qué es un Pull Request?

Un Pull Request (PR) es una solicitud para revisar y aprobar cambios antes de fusionar una branch con otra.

## Flujo Visual

```
┌─────────┐
│ develop │
└────┬────┘
     │ git push
     ▼
┌─────────────┐      ┌──────────────┐
│   GitHub    │──────▶│ Pull Request │
│  (develop)  │      │ develop → staging
└─────────────┘      └──────┬───────┘
                            │
                     ┌──────▼───────┐
                     │   Revisar    │
                     │   Comentar   │
                     │   Aprobar    │
                     └──────┬───────┘
                            │
                     ┌──────▼───────┐
                     │    Merge     │
                     └──────┬───────┘
                            ▼
                     ┌─────────┐
                     │ staging │
                     └─────────┘
```

## Ventajas de los Pull Requests

### 1. Revisión de Código
- Otros desarrolladores pueden ver tus cambios
- Detectar errores antes de producción
- Aprender de otros revisando su código

### 2. Discusión y Colaboración
- Comentar líneas específicas de código
- Sugerir mejoras
- Explicar decisiones técnicas

### 3. Historial y Documentación
- Queda registro de quién aprobó qué
- Se puede ver por qué se hicieron cambios
- Fácil de rastrear problemas

### 4. Control de Calidad
- Tests automáticos antes de merge
- Revisión obligatoria
- Protección de branches importantes

### 5. Integración Continua
- Ejecutar tests automáticamente
- Validar que el código compila
- Verificar estándares de código

## Cómo Crear un Pull Request

### Método 1: Desde la Web de GitHub

#### Paso 1: Ir al repositorio
```
https://github.com/tu-usuario/tu-repositorio
```

#### Paso 2: Click en "Pull requests"
- Busca la pestaña en la parte superior
- Al lado de "Issues" y "Actions"

#### Paso 3: Click en "New pull request"
- Botón verde en la esquina superior derecha

#### Paso 4: Seleccionar branches
```
base: master    ←    compare: staging
  (destino)            (origen)
```

- **base:** Branch donde quieres integrar los cambios
- **compare:** Branch que contiene tus cambios

#### Paso 5: Revisar cambios
GitHub te mostrará:
- ✅ Commits incluidos
- 📄 Archivos modificados
- 🔍 Diff (diferencias) línea por línea
- ⚠️ Conflictos (si los hay)

#### Paso 6: Crear el PR
- Click en "Create pull request"
- Llenar título descriptivo
- Agregar descripción detallada
- Click en "Create pull request" (botón verde)

### Método 2: Desde la Terminal (GitHub CLI)

```bash
# Instalar GitHub CLI primero
# Windows: https://cli.github.com/
# Mac: brew install gh
# Linux: https://github.com/cli/cli/blob/trunk/docs/install_linux.md

# Autenticarse
gh auth login

# Crear PR
gh pr create --base master --head staging --title "Actualizar master" --body "Descripción del PR"

# O de forma interactiva
gh pr create
```

### Método 3: Desde git push

```bash
# Cuando haces push de una nueva branch
git push origin feature/nueva-funcionalidad

# Git te da un link como este:
remote: Create a pull request for 'feature/nueva-funcionalidad' on GitHub by visiting:
remote:      https://github.com/usuario/repo/pull/new/feature/nueva-funcionalidad

# Solo copia y pega ese link en tu navegador
```

## Anatomía de un Pull Request

### Título
```
[tipo]: Descripción breve (50 caracteres máximo)

Ejemplos:
feat: Agregar autenticación con Google
fix: Corregir error en cálculo de impuestos
docs: Actualizar README con ejemplos
refactor: Reorganizar estructura de archivos
```

### Descripción

Usa el template que está en `.github/PULL_REQUEST_TEMPLATE.md`:

```markdown
## Descripción

Explicación clara de qué cambia este PR y por qué es necesario.

## Tipo de cambio

- [ ] Bug fix
- [x] Nueva funcionalidad
- [ ] Mejora de funcionalidad existente
- [ ] Refactorización
- [ ] Documentación

## ¿Cómo se puede probar?

1. Paso 1
2. Paso 2
3. Paso 3

## Checklist

- [x] He probado los cambios localmente
- [x] He actualizado la documentación
- [x] Mi código sigue las convenciones del proyecto
- [ ] He agregado tests

## Screenshots (si aplica)

[Agrega capturas de pantalla si ayudan]

## Notas adicionales

[Información relevante para los revisores]
```

## Revisar un Pull Request

### Como Revisor

#### 1. Ve a la pestaña "Pull requests"
- Busca el PR que quieres revisar

#### 2. Click en el PR
- Lee el título y descripción
- Revisa el contexto

#### 3. Ve a "Files changed"
- Verás todos los archivos modificados
- Las líneas en verde son agregadas (+)
- Las líneas en rojo son eliminadas (-)

#### 4. Agregar comentarios
- Pasa el mouse sobre una línea de código
- Aparece un botón "+" azul
- Click y escribe tu comentario
- Puedes hacer:
  - **Comment:** Solo comentario
  - **Suggest:** Sugerir cambio específico
  - **Start a review:** Agregar a tu revisión

#### 5. Finalizar revisión
- Click en "Review changes" (arriba a la derecha)
- Selecciona:
  - **Comment:** Solo comentar sin aprobar/rechazar
  - **Approve:** Aprobar el PR
  - **Request changes:** Solicitar cambios antes de aprobar
- Escribe comentario general (opcional)
- Click en "Submit review"

### Como Autor

#### Responder a comentarios
- Lee todos los comentarios
- Responde explicando o agradeciendo
- Si haces cambios, commitea y push
- Los nuevos commits se agregan automáticamente al PR

#### Resolver conversaciones
- Cuando atiendas un comentario, marca "Resolve conversation"
- Ayuda a trackear qué ya se revisó

#### Actualizar el PR
```bash
# Hacer cambios en tu branch local
git add .
git commit -m "fix: Atender comentarios de revisión"
git push origin tu-branch

# Los cambios aparecen automáticamente en el PR
```

## Aprobar y Hacer Merge

### Opciones de Merge

#### 1. Merge commit (por defecto)
```
Crea un commit de merge en la branch destino
Mantiene todo el historial
```

#### 2. Squash and merge
```
Combina todos los commits en uno solo
Limpia el historial
Útil para features con muchos commits pequeños
```

#### 3. Rebase and merge
```
Aplica los commits uno por uno sin crear merge commit
Historial lineal y limpio
```

### Después del Merge

1. El PR se marca como "Merged" (morado)
2. La branch original puede eliminarse
3. Los cambios ya están en la branch destino
4. Actualiza tu local:
   ```bash
   git checkout master
   git pull origin master
   ```

## Buenas Prácticas

### 1. PRs Pequeños
- ✅ 1 feature = 1 PR
- ✅ Menos de 400 líneas de código
- ❌ No mezclar múltiples features
- ❌ No incluir cambios no relacionados

### 2. Descripción Clara
- ✅ Explicar el "por qué", no solo el "qué"
- ✅ Incluir contexto y decisiones técnicas
- ✅ Agregar screenshots o GIFs si hay cambios visuales
- ✅ Referenciar issues relacionados (#123)

### 3. Self-Review
- ✅ Revisa tu propio PR antes de pedir revisión
- ✅ Agrega comentarios en código complejo
- ✅ Verifica que no incluiste archivos sensibles
- ✅ Confirma que los tests pasan

### 4. Revisión Constructiva
- ✅ Sé específico en tus comentarios
- ✅ Sugiere soluciones, no solo problemas
- ✅ Pregunta en lugar de ordenar
- ✅ Reconoce el buen código

### 5. Responder Rápidamente
- ✅ Responde a comentarios en 24 horas
- ✅ Si no puedes revisar, asigna a otro
- ✅ Marca conversaciones como resueltas
- ✅ Haz merge cuando esté aprobado

## Ejemplo Completo: Ciclo de PR

```bash
# 1. CREAR FEATURE
git checkout develop
git pull origin develop
git checkout -b feature/login-google

# 2. DESARROLLAR
# ... hacer cambios ...
git add .
git commit -m "feat: Agregar login con Google"

# 3. PUSH A GITHUB
git push origin feature/login-google

# 4. CREAR PR EN GITHUB
# - Ir a GitHub
# - Click en "Pull requests" → "New pull request"
# - base: develop  ←  compare: feature/login-google
# - "Create pull request"
# - Llenar título y descripción
# - "Create pull request"

# 5. REVISIÓN
# - Alguien revisa el código
# - Deja comentarios
# - Solicita cambios

# 6. ATENDER COMENTARIOS
# ... hacer cambios ...
git add .
git commit -m "fix: Atender comentarios de revisión"
git push origin feature/login-google

# 7. APROBACIÓN
# - El revisor aprueba
# - Todos los checks pasan ✅

# 8. MERGE
# - Click en "Merge pull request"
# - Confirmar merge
# - Opcionalmente: Eliminar branch

# 9. ACTUALIZAR LOCAL
git checkout develop
git pull origin develop
git branch -d feature/login-google

# 10. CONTINUAR FLUJO
# Si funciona en develop → PR a staging
# Si funciona en staging → PR a master
```

## Protección de Branches con PRs

### Configurar Branch Protection Rules

En GitHub:
1. Settings → Branches → Add rule
2. Branch name pattern: `master`
3. Activar:
   - ✅ Require pull request before merging
   - ✅ Require approvals (1 o más)
   - ✅ Dismiss stale approvals
   - ✅ Require status checks to pass
   - ✅ Require branches to be up to date

Con esto:
- ❌ No se puede hacer push directo a master
- ✅ Obligatorio crear PR
- ✅ Requiere aprobación de al menos 1 persona
- ✅ Los tests deben pasar

## Comandos Útiles

```bash
# Ver PRs abiertos (requiere gh CLI)
gh pr list

# Ver un PR específico
gh pr view 123

# Checkout de un PR localmente
gh pr checkout 123

# Aprobar un PR
gh pr review 123 --approve

# Hacer merge de un PR
gh pr merge 123

# Cerrar un PR sin hacer merge
gh pr close 123

# Ver diferencias entre branches
git diff master..staging

# Ver commits únicos en una branch
git log master..staging --oneline

# Ver archivos modificados
git diff --name-only master..staging
```

## Recursos Adicionales

- **Documentación GitHub:** https://docs.github.com/en/pull-requests
- **GitHub CLI:** https://cli.github.com/
- **Git Book:** https://git-scm.com/book/en/v2/GitHub-Contributing-to-a-Project
- **Conventional Commits:** https://www.conventionalcommits.org/

## Troubleshooting

### Conflictos en el PR

Si hay conflictos:

```bash
# 1. Actualizar tu branch local
git checkout feature/tu-branch
git pull origin feature/tu-branch

# 2. Traer cambios de la branch destino
git pull origin master

# 3. Resolver conflictos manualmente
# - Abre los archivos con conflictos
# - Busca los marcadores <<<<<<, =======, >>>>>>>
# - Edita y resuelve

# 4. Commit y push
git add .
git commit -m "fix: Resolver conflictos con master"
git push origin feature/tu-branch

# El PR se actualiza automáticamente
```

### PR con muchos commits

Si tu PR tiene demasiados commits pequeños:

```bash
# Opción 1: Squash al hacer merge (desde GitHub)
# - Click en "Squash and merge" en lugar de "Merge"

# Opción 2: Squash antes de crear PR
git rebase -i HEAD~5  # Squash últimos 5 commits
# Marca commits como 'squash' excepto el primero
git push origin feature/tu-branch --force
```

### Actualizar PR con cambios de master

```bash
# Si master avanzó y quieres los últimos cambios
git checkout feature/tu-branch
git pull origin feature/tu-branch
git merge master
git push origin feature/tu-branch
```

---

## 📝 Resumen

**Pull Requests son:**
- ✅ Una forma de revisar código antes de integrarlo
- ✅ Herramienta de colaboración y discusión
- ✅ Documentación de por qué se hicieron cambios
- ✅ Control de calidad antes de producción

**Flujo básico:**
1. Crear branch → Hacer cambios → Push
2. Crear PR en GitHub
3. Revisar y comentar
4. Aprobar
5. Hacer merge
6. Actualizar local

**¡Ahora estás listo para usar Pull Requests como un profesional!** 🚀
