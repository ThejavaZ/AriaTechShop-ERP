# Scripts de Respaldo y Restauración

## Requisitos
- Windows
- El archivo `database.sqlite` debe existir en `server/database/`

## Uso

### Respaldar
1. Abre la carpeta `scripts/`
2. Doble clic en `backup.bat`
3. El archivo `.sqlite` se guardará en `scripts/backups/` con fecha y hora

### Restaurar
1. Abre la carpeta `scripts/`
2. Doble clic en `restore.bat`
3. Ingresa la ruta del archivo a restaurar
4. Ejemplo: `backups\backup_2025-01-01_10-30.sqlite`

## ⚠️ Importante
- Los archivos de respaldo no se suben al repositorio
- Guarda tus respaldos en un lugar seguro fuera del proyecto