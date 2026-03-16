# Diagrama de Actividades: HU-ADM-012 (Eliminar Usuario)

**Historia de Usuario:** HU-ADM-012
**Rol:** Administrador
**Acción:** Eliminar un usuario del sistema de forma permanente.
**Propósito:** Revocar el acceso a usuarios que ya no pertenecen al personal.

**Casos de Uso:**
1. **Eliminación exitosa:** Confirma, elimina de base de datos y redirige mostrando mensaje.
2. **Eliminación con foto de perfil:** Si el usuario tiene foto, elimina el archivo del servidor.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador decide eliminar un usuario;
:Hace clic en "Eliminar";

:¿El administrador confirma la eliminación\nen el diálogo emergente?;
if () then (No)
  :Cancelar eliminación;
  stop
else (Sí)
  :El sistema procesa la eliminación;
  
  :¿El usuario tiene foto de perfil almacenada?;
  if () then (Sí)
    :Eliminar archivo de imagen del servidor;
  else (No)
  endif
  
  :Eliminar registro del usuario en la base de datos;
  :Redirigir al listado de usuarios;
  :Mostrar mensaje: "Usuario eliminado exitosamente";
  stop
endif

@enduml
```
