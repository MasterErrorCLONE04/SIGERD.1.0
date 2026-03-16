# Diagrama de Actividades: HU-ADM-026 (Ayuda y Soporte)

**Historia de Usuario:** HU-ADM-026
**Rol:** Administrador
**Acción:** Acceder a la sección de ayuda y soporte del sistema.
**Propósito:** Consultar preguntas frecuentes, contactar soporte técnico y descargar documentación.

**Casos de Uso:**
1. **Acceso a soporte:** Redirige a /support y muestra preguntas frecuentes (FAQ).
2. **Visualización de FAQ:** Las preguntas se muestran colapsadas inicialmente.
3. **Expandir pregunta:** Al hacer clic, se abre y colapsa las demás.
4. **Colapsar pregunta:** Si hace clic en una abierta, se vuelve a ocultar.
5. **Contacto:** Opción para comunicarse con soporte técnico.
6. **Descarga de manual:** Descarga en PDF de la documentación/manual técnico.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador hace clic en "Soporte" \nen el menú lateral;
:El sistema redirige a la ruta /support;
:Mostrar panel de preguntas frecuentes (FAQ)\ncon todas las respuestas colapsadas;

fork
  :Administrador hace clic en el \ntítulo de una pregunta frecuente;
  
  :¿La pregunta ya estaba expandida?;
  if () then (Sí)
    :Ocultar respuesta (colapsarla);
  else (No)
    :Expandir la respuesta detallada;
    :Colapsar visualmente las demás \npreguntas que estaban abiertas;
  endif
fork again
  :Administrador hace clic en \n"Contactar Soporte";
  :El sistema lanza interfaz de comunicación \no enlace directo al equipo técnico;
fork again
  :Administrador hace clic en \n"Descargar PDF";
  :El sistema prepara el archivo del manual;
  :Ofrecer descarga del documento al usuario;
end fork

stop
@enduml
```
