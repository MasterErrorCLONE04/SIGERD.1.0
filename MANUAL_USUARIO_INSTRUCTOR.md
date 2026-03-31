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
    - 7.3 [Dashboard del Instructor](#72-dashboard-del-instructor)
    - 7.4 [Gestión de Incidentes (Reportes)](#73-gestión-de-incidentes-reportes)
    - 7.5 [Notificaciones](#74-notificaciones)
    - 7.6 [Perfil del Usuario](#75-perfil-del-usuario)
    - 7.7 [Configuración](#77-configuración)
    - 7.8 [Ayuda y Soporte](#78-ayuda-y-soporte)
    - 7.9 [Cerrar Sesión](#76-cerrar-sesión)
8. [Preguntas Frecuentes](#8-preguntas-frecuentes)

---

### 1. Objetivo
El presente manual de usuario tiene como objetivo proporcionar información detallada sobre el funcionamiento y uso del **Sistema de Gestión de Reportes de Daños – SIGERD**, dirigido específicamente al perfil de **Instructor**. Este documento guía al usuario en el proceso de reporte de fallas, daños o incidentes dentro de las instalaciones, así como el seguimiento de su resolución.

### 2. Alcance
Este manual abarca las funcionalidades disponibles para el rol de Instructor en SIGERD, centrándose principalmente en la creación de nuevos reportes de incidentes, la carga de evidencia fotográfica y el monitoreo del estado de dichos reportes. No incluye funciones administrativas ni de ejecución de tareas.

### 3. Términos y Definiciones
*   **SIGERD:** Sistema de Gestión de Reportes de Daños.
*   **Incidente:** Reporte formal de un daño, falla o riesgo identificado en las instalaciones que requiere atención.
*   **Evidencia:** Fotografías o archivos adjuntos que demuestran y documentan el daño reportado.
*   **Estado del Incidente:** Condición actual del reporte (Pendiente de Revisión, Asignado, Resuelto, Cerrado).
*   **Dashboard:** Pantalla principal donde se visualiza el resumen de los reportes realizados.
*   **Notificación:** Aviso sobre cambios en el estado de sus reportes.
*   **Ubicación:** Espacio físico específico (aula, laboratorio, oficina) donde se encuentra la falla.
*   **Fecha de Reporte:** Día en el que se registra el incidente en el sistema.
*   **Descripción:** Detalle textual del problema observado, necesario para que el trabajador entienda qué debe reparar.
*   **Trabajador Asignado:** Persona encargada de realizar la reparación del daño reportado.
*   **Cerrar Sesión:** Acción de salir del sistema de forma segura para proteger la cuenta.

### 4. Introducción
**SIGERD** (Sistema de Gestión de Reportes de Daños) es una plataforma web integral diseñada para optimizar, automatizar y centralizar el proceso de reporte, seguimiento y solución de incidentes en la infraestructura de la institución. El sistema permite a los instructores registrar de forma ágil cualquier daño o falla detectada, adjuntar evidencia fotográfica y realizar un seguimiento transparente del estado de sus solicitudes hasta su resolución.

El módulo se accede a través de un navegador web y está construido con las siguientes tecnologías modernas para garantizar rendimiento y escalabilidad:
*   **Backend:** PHP 8.2 con Laravel 10.x (Patrón MVC Modular).
*   **Frontend:** Blade Templates, Tailwind CSS para el diseño, Alpine.js para interactividad ligera y Chart.js para visualización de datos.
*   **Base de Datos:** MySQL / MariaDB.
*   **Servidor:** Laragon (en entorno de desarrollo local) / Apache o Nginx (en producción).

### 5. Objetivo del Sistema de Información Desarrollado
El objetivo central para el perfil de Instructor es simplificar y agilizar el canal de comunicación para el reporte de novedades, eliminando procesos manuales en papel y permitiendo una trazabilidad clara desde que se detecta el problema hasta que es solucionado.

### 6. Alcance Funcional y Organizacional
**Funcional:**
*   **Reporte de Incidentes:** Formulario estandarizado para registrar daños con ubicación, fecha y evidencia.
*   **Seguimiento:** Visualización del historial de reportes y su estado actual.
*   **Tablero de Control:** Estadísticas personales sobre los reportes realizados.

**Organizacional:**
*   **Instructor:** Responsable de identificar y reportar oportunamente cualquier daño o riesgo en su área de trabajo para garantizar un entorno seguro y funcional.

---

### 7. Funciones y Utilización del Sistema
A continuación, se detalla el paso a paso para el uso de la plataforma por parte del Instructor. Cada acción va acompañada de una referencia visual con una descripción de lo que debe mostrar la captura.

#### 7.1 Inicio de Sesión
1.  **Ingreso a la plataforma:** Abra su navegador web e ingrese la URL institucional del sistema. Visualizará la pantalla de bienvenida.
    
    [Insertar captura de: Pantalla de inicio de sesión vacía lista para ingresar credenciales]

2.  **Autenticación:** Ingrese su **Correo Electrónico** y **Contraseña** asignados en los campos correspondientes.
    
    [Insertar captura de: Formulario de login con los datos del usuario diligenciados]

3.  **Acceso:** Haga clic en el botón **"Iniciar Sesión"** para entrar al sistema.
    
    [Insertar captura de: Botón de iniciar sesión siendo presionado]

4.  **error de credenciales:** Si los datos son incorrectos, aparecerá un mensaje de alerta indicando el error.
    
    [Insertar captura de: Mensaje de alerta indicando "Credenciales inválidas" o "Error de acceso"]

#### 7.2 Recuperación de Contraseña
En caso de extravío de su clave, puede recuperarla de la siguiente manera:

1.  **Solicitud:** En la pantalla de login, presione el enlace **"¿Olvidaste tu contraseña?"**.
    
    [Insertar captura de: Enlace de recuperación en el formulario de login]

2.  **Correo Electrónico:** Digite su correo registrado y presione **"Enviar enlace de recuperación"**.
    
    [Insertar captura de: Formulario de recuperación de contraseña]

3.  **Envío Exitoso:** El sistema le confirmará que las instrucciones han sido enviadas a su correo.
    
    [Insertar captura de: Mensaje de éxito de envío del enlace]

4.  **Acción en Correo:** Siga el vínculo enviado a su bandeja de entrada para establecer una nueva clave.

#### 7.3 Dashboard del Instructor
1.  **Vista General:** Al ingresar, visualizará su panel personal de control.
    
    [Insertar captura de: Vista general completa del Dashboard del Instructor al cargar]

2.  **Resumen de Actividad:** Observe las tarjetas superiores con los contadores de sus reportes (Total, Pendientes, Asignados).
    
    [Insertar captura de: Acercamiento a las tarjetas de estadísticas con los números de reportes]

3.  **Listado Rápido:** En la parte inferior verá una tabla con los incidentes más recientes que ha registrado.
    
    [Insertar captura de: Tabla de "Incidentes Recientes" ubicada en la parte inferior del dashboard]

#### 7.4 Gestión de Incidentes (Reportes)
Esta es la función principal del Instructor.

**Listar mis Reportes:**
1.  **Menú de Incidentes:** Haga clic en la opción "Incidentes" en el menú de navegación lateral.
    
    [Insertar captura de: Menú lateral con la opción "Incidentes" resaltada o seleccionada]

2.  **Visualización de Lista:** Verá todos sus reportes históricos. Puede usar los filtros o el buscador.
    
    [Insertar captura de: Pantalla con la lista completa de incidentes y la barra de búsqueda]

**Crear Nuevo Reporte:**
1.  **Iniciar Reporte:** Haga clic en el botón **"Nuevo Incidente"** o "Reportar Falla" ubicado usualmente en la parte superior.
    
    [Insertar captura de: Botón "Nuevo Incidente" resaltado]

2.  **Diligenciamiento:** Complete el formulario con Título, Descripción, Ubicación y Fecha del incidente.
    
    [Insertar captura de: Formulario de creación de incidente con los campos de texto llenos]

3.  **Carga de Evidencia:** Haga clic en el área de carga para subir las fotos del daño. Es un paso obligatorio.
    
    [Insertar captura de: Selector de archivos o vista previa de las imágenes cargadas en el formulario]

4.  **Guardar:** Presione el botón **"Guardar"** para enviar el reporte al sistema.
    
    [Insertar captura de: Botón "Guardar" y mensaje de confirmación de "Incidente creado correctamente"]

**Ver Detalle:**
1.  **Seleccionar Incidente:** Haga clic en el título de un incidente o en el botón de ver detalle (ícono de ojo) en la lista.
    
    [Insertar captura de: Cursor seleccionando un incidente específico en la tabla]

2.  **Revisar Información:** Se mostrará toda la información del reporte, incluyendo las fotos y el estado actual.
    
    [Insertar captura de: Pantalla de detalle del incidente mostrando descripción, estado y fotos adjuntas]

#### 7.5 Notificaciones
1.  **Alertas:** Ubique el ícono de **Campana** en la barra superior. Si tiene un punto rojo, significa que hay novedades.
    
    [Insertar captura de: Barra superior mostrando el ícono de campana con indicador de notificación pendiente]

2.  **Leer Mensajes:** Haga clic en la campana para desplegar las notificaciones y leer los avisos sobre cambios en sus reportes.
    
    [Insertar captura de: Lista desplegable con las notificaciones recibidas visibles]

#### 7.6 Perfil del Usuario
1.  **Menú de Usuario:** Haga clic en su nombre o foto de perfil en la esquina superior derecha.
    
    [Insertar captura de: Menú de usuario con opciones de perfil]

2.  **Ver Mi Perfil:** Seleccione la opción **"Mi Perfil"**. Podrá ver su información, rol y tiempo en la plataforma.
    
    [Insertar captura de: Vista de detalles del perfil]

3.  **Actualizar Datos:** Puede acceder a la edición de su cuenta mediante el botón **"Ir a Configuración"** en su perfil.

#### 7.7 Configuración
Personalice su interfaz y alertas:

1.  **Pestaña Notificaciones:** Elija si desea alertas por correo para sus reportes.
    
    [Insertar captura de: Configuración de notificaciones]

2.  **Pestaña Apariencia:** Seleccione el modo claro u oscuro según su preferencia visual.
    
    [Insertar captura de: Selección de tema claro/oscuro]

#### 7.8 Ayuda y Soporte
Resuelva sus dudas sobre el uso del sistema:

1.  **Preguntas Frecuentes:** Consulte por qué no puede editar reportes o qué formatos de fotos se aceptan.
    
    [Insertar captura de: Sección FAQ del instructor]

2.  **Soporte Técnico:** Si tiene un problema técnico, use el canal de soporte para contactar a la oficina de sistemas.

#### 7.9 Cerrar Sesión
1.  **Salir del Sistema:** En el menú de su nombre, haga clic en la opción **"Cerrar Sesión"**.
    
    [Insertar captura de: Opción "Cerrar Sesión" resaltada en el menú de usuario]

2.  **Confirmación:** Será redirigido a la pantalla de inicio, confirmando la salida segura.
    
    [Insertar captura de: Pantalla de login tras el cierre de sesión]

---

### 8. Preguntas Frecuentes

**¿Qué hago si olvidé subir una foto en el reporte?**
Por el momento, el reporte se crea con la evidencia inicial. Si necesita agregar más detalles, contacte al administrador o cree un nuevo reporte haciendo referencia al anterior si es necesario.

**¿Puedo editar un reporte enviado?**
Una vez enviado, el reporte entra a revisión. Si nota un error grave recién enviado, comuníquese con soporte; de lo contrario, espere a que sea gestionado.

**¿Cómo sé si ya arreglaron el daño que reporté?**
Revise el estado de su incidente en el Dashboard. Cuando cambie a **"Resuelto"** o **"Cerrado"**, significa que el trabajo ha concluido. También recibirá una notificación.

**¿Qué tipo de archivos puedo subir como evidencia?**
El sistema acepta imágenes en formato JPG, JPEG y PNG. Asegúrese de que no pesen más de 2MB cada una.

**¿Puedo eliminar un reporte que hice por error?**
No, por razones de seguridad y trazabilidad, los instructores no pueden eliminar reportes. Debe contactar al administrador para que anule o elimine el incidente incorrecto.

**¿Quién puede ver los reportes que yo genero?**
Sus reportes son visibles para los Administradores (quienes gestionan la solución) y para los Trabajadores que sean asignados a esa reparación específica.

**¿Qué pasa si mi reporte es rechazado?**
Recibirá una notificación indicando el motivo del rechazo (ej. duplicado, falta de información). Podrá ver el comentario del administrador en el detalle del incidente.

**¿Puedo filtrar mis reportes por fecha?**
Sí. En la sección de "Incidentes", encontrará filtros en la parte superior que le permiten buscar reportes realizados en un rango de fechas específico.

### 9. Solución de Problemas

| Problema | Posible causa | Solución |
| :--- | :--- | :--- |
| **Error al subir imagen** | Archivo muy pesado o formato inválido | Verifique que la imagen sea JPG/PNG y pese menos de 2MB. Intente comprimirla. |
| **No veo mis reportes antiguos** | Filtros activos | Verifique que no tenga filtros de búsqueda aplicados en la lista de incidentes. |
| **El sistema está lento** | Conexión inestable | Compruebe su conexión a internet o intente recargar la página. |
| **No recibo notificaciones** | Configuración de navegador | Verifique que su navegador permita las notificaciones emergentes. |
| **Error al cargar dashboard** | Caché del navegador | Borre la caché y cookies de su navegador e intente nuevamente. |
| **Sesión se cierra sola** | Inactividad prolongada | El sistema cierra la sesión por seguridad después de un tiempo sin uso. Vuelva a ingresar. |

### 10. Datos de Contacto
**Oficina de Tecnología y Sistemas de Información**
*   **Teléfono:** (1) 3456789
*   **Correo electrónico:** soporte@sigerd.gov.co
*   **Horario de atención:** Lunes a viernes de 8:00 a.m. a 5:00 p.m.
