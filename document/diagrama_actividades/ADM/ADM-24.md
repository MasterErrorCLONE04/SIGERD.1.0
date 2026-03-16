# Diagrama de Actividades: HU-ADM-024 (Perfil Personal)

**Historia de Usuario:** HU-ADM-024
**Rol:** Administrador
**Acción:** Ver y editar mi información de perfil personal dentro del sistema.
**Propósito:** Mantener mis datos actualizados y gestionar la seguridad de mi cuenta.

**Casos de Uso:**
1. **Visualización:** Muestra nombre, email, rol y foto en `/profile/show`.
2. **Edición:** Modifica nombre o email con éxito en `/profile`.
3. **Email duplicado:** Error de validación si el nuevo correo pertenece a alguien más.
4. **Eliminación propia:** Elimina registro y cierra la sesión redirigiendo al home.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador se encuentra en el sistema;

fork
  :Accede a /profile/show;
  :El sistema consulta los datos y foto de perfil;
  :Mostrar vista del perfil actual del administrador;
fork again
  :Accede a la opción de editar perfil (/profile);
  :Modifica nombre o email y envía el formulario;
  
  :¿El nuevo email ya está registrado por \notro usuario?;
  if () then (Sí)
    :Mostrar error de validación;
  else (No)
    :Actualizar información del perfil;
    :Mostrar mensaje de éxito;
  endif
fork again
  :Administrador accede a la zona de \neliminación de cuenta (/profile);
  :Hace clic en "Eliminar cuenta";
  
  :¿Administrador confirma la acción \ningresando clave u ok?;
  if () then (No)
    :Cancelar eliminación;
  else (Sí)
    :Eliminar registro del administrador;
    :Cerrar la sesión actual;
    :Redirigir a la página de inicio pública;
  endif
end fork

stop
@enduml
```
