# Guía de Contribución

Gracias por tu interés en contribuir a este proyecto. Esta guía te ayudará a hacer contribuciones de manera efectiva.

## Cómo Contribuir

### 1. Fork del Repositorio

1. Haz clic en el botón "Fork" en la parte superior derecha de GitHub
2. Clona tu fork localmente:
   ```bash
   git clone git@github.com:TU-USUARIO/plugins-wordpress-multisite.git
   cd plugins-wordpress-multisite
   ```

### 2. Configurar el Repositorio Original

```bash
# Agregar el repositorio original como "upstream"
git remote add upstream git@github.com:wilderwil/plugins-wordpress-multisite.git

# Verificar
git remote -v
```

### 3. Crear una Branch para tu Contribución

```bash
# Actualizar tu fork
git checkout develop
git pull upstream develop

# Crear nueva branch
git checkout -b feature/nombre-descriptivo
```

### 4. Hacer tus Cambios

- Edita los archivos necesarios
- Asegúrate de seguir las buenas prácticas del proyecto
- Prueba tus cambios localmente

### 5. Commit de tus Cambios

```bash
# Añadir archivos
git add .

# Hacer commit con mensaje descriptivo
git commit -m "Descripción clara de los cambios"
```

**Formato de mensajes de commit:**
- `feat:` Nueva funcionalidad
- `fix:` Corrección de bugs
- `docs:` Cambios en documentación
- `refactor:` Refactorización de código
- `test:` Añadir o modificar tests
- `chore:` Tareas de mantenimiento

Ejemplos:
```
feat: Agregar opción de backup incremental
fix: Corregir error en rollback de staging
docs: Actualizar guía de instalación en README
```

### 6. Push y Pull Request

```bash
# Push a tu fork
git push origin feature/nombre-descriptivo
```

Luego en GitHub:
1. Ve a tu fork
2. Haz clic en "Compare & pull request"
3. Asegúrate de que el PR apunte a la branch `develop` (no `master`)
4. Completa la descripción del PR con:
   - ¿Qué cambia este PR?
   - ¿Por qué es necesario?
   - ¿Cómo se puede probar?

## Workflow de Branches

```
master/main    → Código en producción (protegida)
├── staging    → Código en servidor staging (protegida)
└── develop    → Desarrollo activo (base para PRs)
    └── feature/* → Features en desarrollo
```

**Importante:**
- Los PRs deben apuntar a `develop`
- Solo los maintainers hacen merge a `staging` y `master`

## Estándares de Código

### Scripts Bash
- Usar `#!/bin/bash` al inicio
- Comentar secciones complejas
- Validar inputs del usuario
- Manejar errores apropiadamente

### PHP (Plugins WordPress)
- Seguir WordPress Coding Standards
- Usar nombres de funciones con prefijo único
- Sanitizar y validar inputs
- Escapar outputs

### Documentación
- Archivos `.md` en español
- Incluir ejemplos de uso
- Actualizar README si es necesario

## Testing

Antes de enviar un PR, verifica:

1. Los scripts funcionan correctamente
2. No rompes funcionalidad existente
3. La documentación está actualizada
4. No incluyes archivos sensibles (contraseñas, claves)

## Reportar Bugs

Si encuentras un bug:

1. Ve a [Issues](https://github.com/wilderwil/plugins-wordpress-multisite/issues)
2. Haz clic en "New Issue"
3. Incluye:
   - Descripción clara del problema
   - Pasos para reproducirlo
   - Comportamiento esperado vs actual
   - Versión del sistema operativo
   - Capturas de pantalla si aplica

## Proponer Nuevas Funcionalidades

Para proponer una nueva funcionalidad:

1. Abre un Issue primero para discutir la idea
2. Espera feedback antes de implementar
3. Esto evita trabajo innecesario si la funcionalidad no encaja con el proyecto

## Código de Conducta

- Sé respetuoso y profesional
- Acepta críticas constructivas
- Enfócate en lo mejor para el proyecto
- Ayuda a otros contribuidores

## Mantener tu Fork Actualizado

```bash
# Actualizar develop desde upstream
git checkout develop
git pull upstream develop
git push origin develop

# Actualizar tu feature branch
git checkout feature/tu-branch
git merge develop
```

## Preguntas

Si tienes preguntas:
- Abre un Issue con la etiqueta "question"
- Revisa Issues cerrados por si ya fue respondida
- Consulta la documentación en README.md

## Licencia

Al contribuir, aceptas que tus contribuciones se licencien bajo la misma licencia del proyecto.
