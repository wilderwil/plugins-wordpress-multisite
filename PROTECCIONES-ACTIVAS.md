# Protecciones de Branches Activas

Este repositorio tiene protecciones activas en las siguientes branches:

## Branches Protegidas

### `master` (Producción)
- ❌ Push directo bloqueado
- ✅ Requiere Pull Request
- ✅ Requiere 1 aprobación mínima
- ❌ Force push bloqueado

### `staging` (Pre-producción)
- ❌ Push directo bloqueado
- ✅ Requiere Pull Request
- ✅ Requiere 1 aprobación mínima
- ❌ Force push bloqueado

## Workflow Obligatorio

```
feature → develop (✓ push directo) →
staging (via PR) →
master (via PR) →
deploy a producción
```

## Cómo Hacer Cambios

1. Trabajar en `develop` o `feature/*`
2. Hacer push de esas branches libremente
3. Para llevar cambios a `staging` o `master`: crear Pull Request
4. Aprobar y mergear el PR
5. Pull del resultado
6. Deployar

## Beneficios

✅ Previene push accidentales a producción
✅ Obliga a revisar código antes de producción
✅ Protege el historial de Git
✅ Workflow consistente y profesional

Fecha de activación: 2026-01-23
