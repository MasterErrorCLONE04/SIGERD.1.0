# MANUAL DE USUARIO DEL SISTEMA DE INFORMACIÓN
## Sistema de Gestión de Reportes de Daños – SIGERD
**Versión:** 1.0  
**Fecha de elaboración:** 16/02/2026  
**Elaborado por:** Oficina de Tecnología y Sistemas de Información  
**Entidad responsable:** [Nombre de la Entidad]  
**Dirección de contacto:** Calle 123 # 45-67, Bogotá D.C., Colombia  
**Teléfono y correo:** (1) 3456789 - soporte@sigerd.gov.co  

---

## Tabla de Contenido

1. [Objetivo](#1-objetivo)
2. [Alcance](#2-alcance)
3. [Términos y Definiciones](#3-términos-y-definiciones)
4. [Introducción](#4-introducción)
5. [Objetivo del Sistema de Información Desarrollado](#5-objetivo-del-sistema-de-información-desarrollado)
6. [Alcance Funcional y Organizacional](#6-alcance-funcional-y-organizacional)
7. [Funciones y Utilización del Sistema](#7-funciones-y-utilización-del-sistema)
    - 7.1 [Inicio de Sesión](#71-inicio-de-sesión)
    - 7.2 [Recuperación de Contraseña](#72-recuperación-de-contraseña)
    - 7.3 [Dashboard del Trabajador](#72-dashboard-del-trabajador)
    - 7.4 [Gestión de Tareas Asignadas](#73-gestión-de-tareas-asignadas)
    - 7.5 [Notificaciones](#74-notificaciones)
    - 7.6 [Perfil del Usuario](#75-perfil-del-usuario)
    - 7.7 [Configuración](#77-configuración)
    - 7.8 [Ayuda y Soporte](#78-ayuda-y-soporte)
    - 7.9 [Cerrar Sesión](#76-cerrar-sesión)
8. [Preguntas Frecuentes](#8-preguntas-frecuentes)

---

### 1. Objetivo
El presente manual de usuario tiene como objetivo guiar al personal con perfil de **Trabajador** en el uso eficiente del sistema SIGERD, específicamente para la consulta, ejecución y reporte de finalización de las tareas de mantenimiento asignadas.

### 2. Alcance
Este manual cubre las funciones operativas del Trabajador: visualizar tareas pendientes, actualizar el estado de las mismas y subir evidencia fotográfica del trabajo realizado.

### 3. Términos y Definiciones
*   **SIGERD:** Sistema de Gestión de Reportes de Daños.
*   **Tarea:** Orden de trabajo asignada por un administrador para reparar un daño o realizar mantenimiento.
*   **Evidencia Final:** Fotos que demuestran que la tarea ha sido completada satisfactoriamente.
*   **Estado de Tarea:**
    *   *Asignada:* Tarea nueva pendiente de iniciar.
    *   *En Progreso:* Tarea en ejecución.
    *   *Finalizada:* Trabajo terminado y enviado a revisión.
*   **Prioridad:** Nivel de urgencia de la tarea (Alta, Media, Baja).
*   **Fecha Límite:** Plazo máximo para completar el trabajo asignado.
*   **Ubicación:** Lugar físico donde se debe realizar el trabajo.

### 4. Introducción
**SIGERD** (Sistema de Gestión de Reportes de Daños) es una plataforma web integral diseñada para optimizar, automatizar y centralizar el proceso de reporte, seguimiento y solución de incidentes en la infraestructura de la institución. Para el trabajador operativo, el sistema elimina el uso de papel y centraliza la información, permitiéndole consultar desde cualquier dispositivo qué debe reparar, dónde y cuándo, además de reportar su trabajo completado de forma inmediata.

El módulo se accede a través de un navegador web y está construido con las siguientes tecnologías modernas para garantizar rendimiento y escalabilidad:
*   **Backend:** PHP 8.2 con Laravel 10.x (Patrón MVC Modular).
*   **Frontend:** Blade Templates, Tailwind CSS para el diseño, Alpine.js para interactividad ligera y Chart.js para visualización de datos.
*   **Base de Datos:** MySQL / MariaDB.
*   **Servidor:** Laragon (en entorno de desarrollo local) / Apache o Nginx (en producción).

### 5. Objetivo del Sistema de Información Desarrollado
Para el perfil operativo, el objetivo es proporcionar una herramienta clara y sencilla que le permita gestionar su carga de trabajo diaria, conocer sus prioridades y demostrar el cumplimiento de sus labores mediante evidencia digital.

### 6. Alcance Funcional y Organizacional
**Funcional:**
*   **Recepción de Tareas:** Visualización clara de trabajos asignados.
*   **Gestión de Estados:** Capacidad de marcar tareas como iniciadas o terminadas.
*   **Carga de Evidencia:** Subida de fotos del trabajo finalizado.

**Organizacional:**
*   **Trabajador:** Responsable de ejecutar las tareas asignadas en tiempo y forma, y reportar su culminación en el sistema.

---

### 7. Funciones y Utilización del Sistema
A continuación, se detalla el paso a paso para el uso de la plataforma por parte del Trabajador. Cada acción va acompañada de una referencia visual con una descripción de lo que debe mostrar la captura.

#### 7.1 Inicio de Sesión
1.  **Ingreso a la plataforma:** Abra su navegador web e ingrese la URL institucional del sistema. Visualizará la pantalla de bienvenida.
    
    [Insertar captura de: Pantalla de inicio de sesión vacía]

2.  **Autenticación:** Ingrese su **Correo Electrónico** y **Contraseña** asignados en los campos correspondientes.
    
    [Insertar captura de: Formulario de login con los datos del trabajador diligenciados]

3.  **Acceso:** Haga clic en el botón **"Iniciar Sesión"** para entrar al sistema.
    
    [Insertar captura de: Botón de iniciar sesión siendo presionado]

4.  **Error de credenciales:** Si los datos son incorrectos, aparecerá un mensaje de alerta indicando el error.
    
    [Insertar captura de: Mensaje de alerta indicando "Credenciales inválidas" o "Error de acceso"]

#### 7.2 Recuperación de Contraseña
Si no puede acceder por olvido de su contraseña, siga estos pasos:

1.  **Recuperar Acceso:** En la pantalla de ingreso, haga clic en **"¿Olvidaste tu contraseña?"**.
    
    [Insertar captura de: Pantalla de login con el enlace de recuperación señalado]

2.  **Validación de Correo:** Ingrese su correo electrónico y presione el botón **"Enviar enlace de recuperación"**.
    
    [Insertar captura de: Formulario de envío de enlace de recuperación]

3.  **Correo de Instrucciones:** El sistema le notificará que el correo ha sido enviado.
    
    [Insertar captura de: Alerta de mensaje enviado con éxito]

4.  **Cambio de Clave:** Ingrese a su buzón de correo, abra el mensaje de SIGERD y use el enlace para asignar una nueva contraseña.

#### 7.3 Dashboard del Trabajador
1.  **Vista General:** Al ingresar, visualizará su panel personal de control con el resumen de sus asignaciones.
    
    [Insertar captura de: Vista general completa del Dashboard del Trabajador]

2.  **Resumen de Tareas:** Observe las tarjetas superiores con los contadores de sus tareas: "Pendientes", "En Progreso" y "Finalizadas".
    
    [Insertar captura de: Acercamiento a las tarjetas de estadísticas de tareas]

3.  **Tareas Recientes:** En la parte inferior verá una lista rápida de las últimas tareas que le han sido asignadas.
    
    [Insertar captura de: Tabla de "Mis Tareas Recientes" ubicada en la dashboard]

#### 7.3 Gestión de Tareas Asignadas
Aquí administrará su trabajo diario.

**Ver Mis Tareas:**
1.  **Menú de Tareas:** Haga clic en la opción **"Mis Tareas"** en el menú de navegación.
    
    [Insertar captura de: Menú lateral con la opción "Mis Tareas" seleccionada]

2.  **Lista de Asignaciones:** Verá el listado completo de trabajos pendientes. Preste atención a la columna de **Prioridad** y **Fecha Límite**.
    
    [Insertar captura de: Pantalla con la lista de tareas asignadas, destacando alguna de prioridad Alta]

**Iniciar una Tarea:**
1.  **Seleccionar Tarea:** Haga clic en el título de una tarea que esté en estado "Asignada" para ver los detalles.
    
    [Insertar captura de: Selección de una tarea específica en la lista]

2.  **Revisar Información:** Lea la descripción del daño y la ubicación. Si hay fotos del reporte inicial, revíselas para entender el problema.
    
    [Insertar captura de: Vista de detalle de la tarea mostrando la descripción y fotos del reporte]

3.  **Cambiar Estado:** Haga clic en el botón o selector de estado y cámbielo a **"En Progreso"** para indicar que ha comenzado a trabajar.
    
    [Insertar captura de: Acción de cambiar el estado de la tarea a "En Progreso"]

**Finalizar una Tarea:**
Una vez termine el trabajo físico en el sitio:
1.  **Volver al Detalle:** Ingrese nuevamente a la tarea que estaba "En Progreso".
    
    [Insertar captura de: Vista de detalle de la tarea en progreso]

2.  **Subir Evidencia:** Desplácese hasta la sección "Evidencia de Finalización". Haga clic para subir las fotos que demuestran el arreglo.
    
    [Insertar captura de: Formulario de carga de evidencia con fotos seleccionadas]

3.  **Comentario Final:** (Opcional) Escriba una nota sobre el trabajo realizado (ej. "Se cambió la pieza X").
    
    [Insertar captura de: Campo de texto con observaciones del trabajador]

4.  **Finalizar:** Cambie el estado a **"Finalizada"** o haga clic en el botón "Finalizar Tarea". Esto enviará el trabajo a revisión del administrador.
    
    [Insertar captura de: Botón de finalizar tarea y mensaje de confirmación]

#### 7.5 Notificaciones
1.  **Alertas:** Ubique el ícono de **Campana** en la barra superior. Si tiene un punto rojo, tiene nuevas asignaciones.
    
    [Insertar captura de: Ícono de campana con indicador de alerta]

2.  **Leer Avisos:** Haga clic para ver si tiene nuevas tareas asignadas o si alguna tarea fue rechazada por el administrador para corrección.
    
    [Insertar captura de: Lista de notificaciones desplegada con mensajes de asignación]

#### 7.6 Perfil del Usuario
1.  **Menú de Usuario:** Haga clic en su nombre en la esquina superior derecha.
    
    [Insertar captura de: Menú de usuario desplegado]

2.  **Mi Perfil:** Seleccione la opción **"Mi Perfil"**. Aquí podrá revisar su cargo y fecha de registro.
    
    [Insertar captura de: Pantalla de perfil del trabajador]

3.  **Gestión de Cuenta:** Use el botón **"Ir a Configuración"** si requiere realizar cambios en sus preferencias de acceso.

#### 7.7 Configuración
Ajuste su entorno de trabajo digital:

1.  **Notificaciones:** Active las alertas para recibir correos cada vez que se le asigne una nueva tarea.
2.  **Apariencia:** Use el "Modo Oscuro" para una mejor visualización en entornos de poca luz durante sus labores.
    
    [Insertar captura de: Pestaña de apariencia seleccionada]

#### 7.8 Ayuda y Soporte
Consulte el centro de ayuda ante cualquier duda:

1.  **FAQs:** Encuentre respuestas sobre la carga de evidencias y tipos de archivos permitidos.
2.  **Soporte:** Si el sistema presenta errores al subir fotos, contacte a soporte mediante el botón correspondiente.

#### 7.9 Cerrar Sesión
1.  **Salir:** Al terminar su jornada, despliegue el menú de usuario y haga clic en **"Cerrar Sesión"**.
    
    [Insertar captura de: Opción "Cerrar Sesión" resaltada]

2.  **Confirmación:** El sistema volverá a la pantalla de inicio para proteger su cuenta.
    
    [Insertar captura de: Pantalla de login tras el cierre de sesión]

---

### 8. Preguntas Frecuentes

**¿Puedo rechazar una tarea asignada?**
No hay un botón para rechazar. Si no puede realizarla o no tiene los materiales, debe comunicarse directamente con su administrador o dejar un comentario en la tarea.

**¿Qué pasa si no tengo fotos para subir?**
La evidencia fotográfica es obligatoria para cerrar una tarea en el sistema. Debe tomar al menos una foto del trabajo realizado con su celular o dispositivo.

**¿Cómo sé si mi tarea fue aprobada?**
La tarea cambiará a estado "Cerrado" o desaparecerá de su lista de pendientes. Si es rechazada, volverá a aparecer para que la corrija.

**¿Puedo ver tareas que ya terminé hace tiempo?**
Sí, puede usar los filtros en la lista de tareas para ver las "Finalizadas" o "Cerradas".

**¿Qué hago si me equivoqué de foto al subirla?**
Si aún no ha finalizado la tarea, puede eliminar la foto y subir la correcta. Si ya la finalizó, contacte al administrador para que le permita editarla.

### 9. Solución de Problemas

| Problema | Posible causa | Solución |
| :--- | :--- | :--- |
| **No puedo subir fotos** | Archivo muy pesado | Verifique que sean JPG/PNG y pesen menos de 2MB. |
| **No veo mis tareas nuevas** | Falta actualizar | Recargue la página o revise su conexión a internet. |
| **Olvidé mi contraseña** | Olvido de credenciales | Use la opción "¿Olvidó su contraseña?" en la pantalla de inicio. |
| **No puedo finalizar tarea** | Falta evidencia | Suba al menos una foto del trabajo realizado antes de cambiar el estado. |
| **Datos no coinciden** | Error de escritura | Revise que esté escribiendo correctamente su correo y contraseña (mayúsculas/minúsculas). |
| **Pantalla en blanco** | Error de carga | Intente abrir el sistema en una pestaña de incógnito o recargue la página. |

### 10. Datos de Contacto
**Oficina de Tecnología y Sistemas de Información**
*   **Teléfono:** (1) 3456789
*   **Correo electrónico:** soporte@sigerd.gov.co
*   **Horario de atención:** Lunes a viernes de 8:00 a.m. a 5:00 p.m.
