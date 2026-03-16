# Diagrama de Actividades: HU-INS-010 (Perfil Personal)

**Historia de Usuario:** HU-INS-010
**Rol:** Instructor
**Acción:** Ver y editar mi información de perfil personal dentro del sistema.
**Propósito:** Mantener mis datos actualizados y gestionar la seguridad de mi cuenta.

**Casos de Uso:**
1. **Visualización:** `/profile/show` muestra datos base y rol Asignado (Instructor).
2. **Edición:** Formulario precargado con nombre y correo.
3. **Edición exitosa:** Datos válidos muestran "profile-updated".
4. **Campo vacío:** Error de validación "Nombre es obligatorio".
5. **Formato inválido:** Error si el correo no tiene sintaxis válida.
6. **Email duplicado:** Error si ya está en otro registro.
7. **Cambio contraseña:** Confirmación de actuales y nuevas muestran "password-updated".
8. **Eliminación propia:** Al confirmar, elimina registro, cierra sesión y redirige al index.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor se encuentra en el gestor de perfiles;

fork
  :Accede a Mostrar Perfil (/profile/show);
  :El sistema despliega los datos: \nnombre, email, foto y rol Instructor;
fork again
  :Accede al formato de Edición (/profile);
  :Diligencia los datos del formulario \ny hace clic en Guardar cambios;
  
  :¿El nombre está vacío?;
  if () then (Sí)
    :Mostrar error: "Nombre obligatorio";
    kill
  else (No)
    :¿El email tiene formato inválido?;
    if () then (Sí)
      :Mostrar error de sintaxis de email;
      kill
    else (No)
      :¿El email está registrado a nombre de otro usuario?;
      if () then (Sí)
        :Mostrar error: "Email en uso por otro";
        kill
      else (No)
        :Actualizar perfil;
        :Mostrar mensaje "profile-updated";
        stop
      endif
    endif
  endif
fork again
  :Accede al bloque Eliminar cuenta en /profile;
  :Hace clic en Confirmar;
  
  :¿El instructor valida su identidad \ncon la contraseña personal?;
  if () then (No)
    :Cancelar operación;
  else (Sí)
    :El sistema elimina su registro permanentemente;
    :Su sesión actual expira (Logout);
    :Es redirigido a la pantalla web inicial;
    stop
  endif
end fork

stop
@enduml
```
