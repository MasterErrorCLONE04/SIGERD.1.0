# Diagrama de Actividades: HU-TRB-009 (Registrar Evidencia Final)

**Historia de Usuario:** HU-TRB-009
**Rol:** Trabajador
**Acción:** Registrar imágenes del trabajo completado y describir la intervención.
**Propósito:** Documentar el resultado y enviar la tarea a revisión del administrador.

**Casos de Uso:**
1. **Formulario hábil:** Solo es visible para adjuntar fotos finales y memoria descriptiva si la carga actual del trabajo está **En Progreso**.
2. **Bloqueo de formulario:** Si el trabajo pasa a **Realizada**, se inhabilita nuevas ediciones.
3. **Subida exitosa:** Transiciona la tarea a culminada (por revisión) -> "Realizada", emite aviso al administrador.
4. **Notificación admin:** Ping automático: "El trabajador envió la tarea para su revisión".
5. **Acumulativas:** Si se añaden nuevas evidencias (ej. por rechazo administrativo previo que lo vuelve "en progreso"), las fotos no se borran, sino que se suman en la galería.
6. **Validaciones de archivo:** Errores frente a excesos de la cuota 2MB o ficheros corruptos/no soportados.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador visualiza el detalle de su Tarea actual;

:¿El estado técnico de la tarea es En progreso?;
if () then (Sí)
  :Mostrar bloque formulario "Evidencia Final" \n(con campos de carga fotográfica \ne input de Descripción de Intervención);
  :El operario sube archivos, digita lo que hizo \ny presiona "Finalizar Tarea";
  
  :¿Sus archivos adjuntos infringen las reglas \nde peso (2MB) y tipo (imágenes)?;
  if () then (Sí)
    :Retornar mensajes visuales sobre la regla violada;
  else (No)
    :¿Ya existían fotos finales anteriores en el directorio?;
    if () then (Sí)
      :Acumular y preservar las nuevas imágenes junto \na las fotografías residuales previas;
    else (No)
    endif
    
    :Registrar la conclusión escrita y material visual;
    :Forzar la transición de estado la Tarea \nhacia la estapa "Realizada" (bajo revisión);
    
    :Disparar notification automática al Administrador: \n"Trabajador completó y entregó tarea";
    :Dirigir al operario al dashboard confirmando \nque el acta fue entregada exitosamente;
  endif
else (No)
  :No mostrar formulario para adjuntar imágenes \nfinales ni input de descripción;
  :Desplegar mensaje disuasivo o de read-only;
endif

stop
@enduml
```
