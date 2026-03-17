# Diagrama de Actividades: HU-INS-007 (Reportar Nueva Falla)

**Historia de Usuario:** HU-INS-007
**Rol:** Instructor
**Acción:** Reportar una nueva falla o incidencia identificada en las instalaciones.
**Propósito:** Notificar al equipo administrativo para que sea atendida oportunamente.

**Casos de Uso:**
1. **Apertura del modal:** Desde dashboard o listado, abre el formulario.
2. **Reporte exitoso:** Crea incidente (pendiente), notifica (a admins) y redirige.
3. **Notificación admin:** Procesa el reporte y alerta a los administradores.
4. **Campos obligatorios:** Error de validación y cancelación si faltan.
5. **Fecha inválida:** Error si ingresa una fecha futura (posterior a hoy).
6. **Imágenes obligatorias:** Error "Debe subir al menos una imagen".
7. **Formato inválido:** Error si imagen no es jpeg, jpg, png, gif.
8. **Excede tamaño:** Error si una imagen es de más de 2MB.
9. **Cierre sin guardar:** Cancelar o salir del modal descarta el registro.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor hace clic en "Reportar Nueva Falla";
:El sistema abre el modal con el formulario de reporte;

:¿Instructor decide cancelar el formulario?;
if () then (Sí)
  :El sistema cierra el modal sin alterar registros;
else (No)
  :Sistema procesa la información entrante;
  
  :¿Faltan datos obligatorios requeridos (título, descripción, ubicación)?;
  if () then (Sí)
    :Mostrar errores sobre los campos de validación;
  else (No)
    :¿La fecha de reporte indicada es posterior a hoy (es futura)?;
    if () then (Sí)
      :Mostrar error de validación de fecha;
    else (No)
      :¿El instructor omitió adjuntar imágenes de la falla?;
      if () then (Sí)
        :Mostrar mensaje: "Debe subir al menos una imagen";
      else (No)
        :¿Alguna imagen tiene formato inválido o sobrepasa los 2MB?;
        if () then (Sí)
          :Mostrar los errores correspondientes a los archivos;
        else (No)
          :Guardar las imágenes e insertar registro en BD;
          :Asignar estado de incidente como "Pendiente de revisión";
          :El sistema notifica el suceso a todos los Administradores;
          :Cerrar modal y mostrar mensaje: "Reporte creado con éxito";
        endif
      endif
    endif
  endif
endif

stop
@enduml
```
