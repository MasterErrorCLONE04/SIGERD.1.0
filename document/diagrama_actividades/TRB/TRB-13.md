# Diagrama de Actividades: HU-TRB-013 (Ayuda y Soporte)

**Historia de Usuario:** HU-TRB-013
**Rol:** Trabajador
**Acción:** Acceder a la sección de ayuda y soporte del sistema.
**Propósito:** Consultar preguntas frecuentes y obtener asistencia técnica.

**Casos de Uso:**
1. **Acceso:** Ir a la ruta `/support` y evidenciar Acordeón de preguntas frecuentes.
2. **Visualizar FAQ:** Entran ocultas / cerradas por defecto en lista vertical.
3. **Manejo Expandir:** El clic las agranda de forma que devela el cuadro de texto inferido, si otra está abierta, se auto-colapsa.
4. **Manejo Colapsar:** Clic en FAQ ya abierta, se guarda limpiamente.
5. **Contactar urgencias:** El botón "Contactar Soporte" brinda puentes físicos (formulario, tel).
6. **Descargar Manual:** "Descargar PDF" ejecuta Request GET hacia un fichero estático devolviendo un payload tipo `application/pdf` al sistema.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador usa botón de "Soporte" ubicado en barra lateral;
:La app redirige a la URL global /support;

:Presentar listado gráfico de Preguntas Frecuentes (FAQ)\ncomo un acordeón;
:Renderizar textos colapsados previamentes \n(Solo mostrar las interrogantes);

fork
  :Trabajador toca un recuadro de FAQ;
  
  :¿El bloque que se tocó ya \nya mostraba expuesta su Respuesta?;
  if () then (Sí)
    :Cerrar vista extendida del bloque, \nocultar contenedor con la respuesta;
  else (No)
    :Extender altura de bloque exhibiendo su respuesta;
    :Forzar en cadena el efecto ocultar (colapsar) a todo \nel resto de los elementos FAQ que estuviesen vivos o abiertos;
  endif
fork again
  :Trabajador necesita reportar una grave urgencia base;
  :Presiona en botón CTA de "Contactar Soporte Urgente";
  :Visualiza formas de enlace al técnico especializado. (Link o view directo);
fork again
  :Trabajador cliquea el ícono "Descargar PDF";
  :Gateway del servidor entrega blob del Manual de Trabajador _manual_trabajador.pdf_;
  :Navegador fuerza proceso y barrita de descarga exitosa;
end fork

stop
@enduml
```
