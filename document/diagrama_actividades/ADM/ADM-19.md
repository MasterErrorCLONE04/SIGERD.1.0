# Diagrama de Actividades: HU-ADM-019 (Exportar Reporte de Tareas)

**Historia de Usuario:** HU-ADM-019
**Rol:** Administrador
**Acción:** Exportar un reporte mensual de tareas finalizadas en PDF.
**Propósito:** Generar informes de gestión sobre el trabajo finalizado.

**Casos de Uso:**
1. **Exportación con datos:** Si hay finalizadas, descarga reporte-tareas-[Mes]-[Año].pdf.
2. **Exportación sin datos:** Genera el PDF con valores en cero si no hay registros en ese periodo.
3. **Mes o año inválido:** Muestra error de validación si valores están fuera de rango.
4. **Contenido del reporte:** El sistema incluye estadísticas, tablas de tareas y ranking.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador accede al módulo de reportes;
:Selecciona mes y año objetivo;
:Hace clic en "Generar / Exportar PDF";

:El sistema valida los parámetros ingresados;

:¿El mes y/o año son inválidos o fuera de rango?;
if () then (Sí)
  :Mostrar error de validación;
else (No)
  :El sistema consulta las tareas "Finalizadas" \ndel periodo y el ranking de trabajadores;
  
  :¿Existen tareas finalizadas en ese periodo?;
  if () then (Sí)
    :Procesar estadísticas, tabla de detalle \ny ranking real de finalizados;
  else (No)
    :Preparar documento con valores \ny estadísticas en cero;
  endif
  
  :Configurar estructura de plantilla;
  :Generar archivo PDF \n(reporte-tareas-[Mes]-[Año].pdf);
  :Iniciar descarga local del documento;
endif

stop
@enduml
```
