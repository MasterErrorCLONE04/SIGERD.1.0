# Diagrama de Actividades: HU-INS-012 (Ayuda y Soporte)

**Historia de Usuario:** HU-INS-012
**Rol:** Instructor
**Acción:** Acceder a la sección de ayuda y soporte del sistema.
**Propósito:** Consultar preguntas frecuentes, contactar soporte técnico y descargar documentación.

**Casos de Uso:**
1. **Acceso:** Mostrar FAQ en `/support`.
2. **Visualizar FAQ:** Inicialmente todas las tarjetas van colapsadas.
3. **Expandir/Colapsar:** Acordeón de respuestas (una a la vez).
4. **Contacto:** Permite comunicarse con el área técnica.
5. **Descarga:** Otorga el manual de la herramienta.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor presiona en el menú "Soporte";
:El sistema redirige a vista respectiva en /support;

:Sistema carga preguntas frecuentes (FAQ) pertinentes al rol;
:Abre la vista con los títulos en lista (respuestas ocultas);

fork
  :Instructor pulsa sobre el texto \no ícono desplegable de una Pregunta;
  
  :¿La tarjeta sobre la que presionó \nya despliega su respuesta?;
  if () then (Sí)
    :Ocultar detalle de respuesta / \nColapsar elemento;
  else (No)
    :Desplegar texto de ayuda (Expandir elemento);
    :Forzar colapso de las otras respuestas \nque estuviesen abiertas en pantalla;
  endif
fork again
  :Instructor interactúa con el botón \n"Contactar Soporte Técnico";
  :Sistema carga panel, correo por defecto \no ticket de atención técnica;
fork again
  :Instructor pulsa en "Descargar PDF" / "Manual";
  :Servidor otorga enlace de archivo físico;
  :Descargar "manual_instructor.pdf" \nal dispositivo;
end fork

stop
@enduml
```
