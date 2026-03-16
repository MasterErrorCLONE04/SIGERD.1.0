# Diagrama de Actividades: HU-TRB-011 (Perfil Personal)

**Historia de Usuario:** HU-TRB-011
**Rol:** Trabajador
**Acción:** Ver y editar mi información de perfil personal dentro del sistema.
**Propósito:** Mantener mis datos actualizados y gestionar la seguridad de mi cuenta.

**Casos de Uso:**
1. **Visualización:** `/profile/show` muestra datos: nombre, email, foto y rol Trabajador.
2. **Edición Datos:** Carga datos previos en el formulario. 
3. **Edición Exitosa:** Al guardar datos válidos, muestra "profile-updated".
4. **Validaciones de Error:** Error si envía el nombre en blanco; error de sintaxis al evaluar el email; error `duplicado` si el correo le pertenece a otro usuario de la plataforma.
5. **Cambio contraseña:** Confirmación de actuales y nuevas muestran validación `password-updated`.
6. **Eliminación propia:** Al confirmar decisión y clave, borra archivo propio de BD, rompe sesión y expulsa a index.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador navega hacia opciones de Perfil;

fork
  :Entra a Visualizar Perfil (/profile/show);
  :El sistema extrae datos básicos y \nsu nivel de jerarquía (Trabajador);
  :Se despliega dashboard estático de usuario;
fork again
  :Ingresa a la sección Editar Información (/profile);
  :Cambia texto en campos de \nNombre o Email y presiona Guardar;
  
  :¿El campo Nombre ha sido borrado (vacío)?;
  if () then (Sí)
    :Lanzar warning: "Obligatoriedad de nombre";
    kill
  else (No)
    :¿La estructura en el campo Email es incorrecta?;
    if () then (Sí)
      :Lanzar warning formato inválido;
      kill
    else (No)
      :¿El sistema detectó otro registro \ncon esa misma dirección de correo (Email duplicado)?;
      if () then (Sí)
        :Denegar actualización: "Email en uso por otro usuario";
        kill
      else (No)
        :Realizar los commits de la actualización sobre su data;
        :Generar notificación al usuario de "profile-updated";
        stop
      endif
    endif
  endif
fork again
  :Accede a zona de purga (Eliminar cuenta en /profile);
  :Presiona Eliminar;
  
  :¿Valida correctamente la acción insertando \nsu Clave vigente de seguridad antes del submit?;
  if () then (No)
    :Retener al usuario, Cancelar purga;
  else (Sí)
    :Extirpar todo el nodo del perfil trabajador desde BD;
    :Anular su token interno de Sesión activa;
    :Redirigir forzosamente fuera del área privada \nhacia URL base / pública;
    stop
  endif
end fork

stop
@enduml
```
