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
    - 7.3 [Dashboard del Administrador](#73-dashboard-del-administrador)
    - 7.4 [Gestión de Usuarios](#73-gestión-de-usuarios)
    - 7.5 [Gestión de Tareas](#74-gestión-de-tareas)
    - 7.6 [Gestión de Incidentes](#75-gestión-de-incidentes)
    - 7.7 [Notificaciones](#76-notificaciones)
    - 7.8 [Perfil del Administrador](#77-perfil-del-administrador)
    - 7.9 [Configuración](#79-configuración)
    - 7.10 [Ayuda y Soporte](#710-ayuda-y-soporte)
    - 7.11 [Cerrar Sesión](#711-cerrar-sesión)
8. [Preguntas Frecuentes](#8-preguntas-frecuentes)

---

### 1. Objetivo
El presente manual de usuario tiene como objetivo proporcionar información detallada sobre el funcionamiento, arquitectura, configuración y mantenimiento del **Sistema de Gestión de Reportes de Daños – SIGERD**, dirigido específicamente al perfil de **Administrador**. Este documento guía al usuario en la gestión eficiente de usuarios, tareas e incidentes dentro de la plataforma.

### 2. Alcance
        Este manual abarca los aspectos funcionales del sistema SIGERD para el rol de Administrador, incluyendo la gestión de usuarios, asignación y supervisión de tareas, monitoreo de incidentes y reporte de actividades. No incluye funciones específicas de los roles Instructor o Trabajador, salvo en su relación con la administración.

### 3. Términos y Definiciones
*   **SIGERD:** Sistema de Gestión de Reportes de Daños.
*   **Back-end:** Parte del sistema que gestiona la lógica del lado del servidor.
*   **Front-end:** Interfaz gráfica de usuario con la que interactúan las personas.
*   **Incidente:** Reporte de un daño o falla en las instalaciones que requiere atención o evaluación.
*   **Tarea:** Actividad asignada a un trabajador para resolver un incidente o realizar una labor de mantenimiento.
*   **Dashboard:** Tablero de control principal que muestra indicadores, gráficas y accesos directos.
*   **Rol de Usuario:** Permisos y responsabilidades asignados a una cuenta (Administrador, Instructor o Trabajador).
*   **Estado de Tarea:** Condición actual de una actividad (Asignada, En Progreso, Finalizada).
*   **Prioridad:** Nivel de urgencia establecido para atender una tarea o incidente (Alta, Media, Baja).
*   **Evidencia:** Archivos (generalmente imágenes) adjuntos que documentan un incidente o la finalización de una tarea.
*   **Notificación:** Aviso del sistema sobre un evento relevante, como la asignación o finalización de una tarea.
*   **Exportar PDF:** Funcionalidad para generar archivos portables con reportes de tareas o actividades.
*   **Base de Datos:** Estructura donde se almacena toda la información del sistema (usuarios, reportes, tareas).
*   **Inicio de Sesión (Login):** Proceso de autenticación mediante correo y contraseña para acceder al sistema.

### 4. Introducción
**SIGERD** (Sistema de Gestión de Reportes de Daños) es una plataforma web integral diseñada para optimizar, automatizar y centralizar el proceso de reporte, seguimiento y solución de incidentes en la infraestructura de la institución. El sistema permite al administrador tener un control total sobre los usuarios, asignar tareas de mantenimiento de manera eficiente a los trabajadores, monitorear el estado de los reportes en tiempo real y generar estadísticas para la toma de decisiones.

El módulo se accede a través de un navegador web y está construido con las siguientes tecnologías modernas para garantizar rendimiento y escalabilidad:
*   **Backend:** PHP 8.2 con Laravel 10.x (Patrón MVC Modular).
*   **Frontend:** Blade Templates, Tailwind CSS para el diseño, Alpine.js para interactividad ligera y Chart.js para visualización de datos.
*   **Base de Datos:** MySQL / MariaDB.
*   **Servidor:** Laragon (en entorno de desarrollo local) / Apache o Nginx (en producción).

### 5. Objetivo del Sistema de Información Desarrollado
El objetivo de SIGERD es facilitar la toma de decisiones basada en datos, agilizar la respuesta ante incidentes y asegurar una trazabilidad completa de las acciones realizadas por el equipo de trabajo, centralizando la información en un entorno seguro y accesible.

### 6. Alcance Funcional y Organizacional
**Funcional:**
*   **Gestión de Usuarios:** Administración de cuentas para Administradores, Instructores y Trabajadores.
*   **Gestión de Tareas:** Creación, asignación, seguimiento y revisión de tareas.
*   **Gestión de Incidentes:** Recepción de reportes y conversión a tareas operativas.
*   **Reportes:** Visualización de métricas y generación de informes (PDF).

**Organizacional:**
*   **Administrador:** Control total, gestión de usuarios y supervisión de operaciones.
*   **Instructor:** Reporte de incidentes y seguimiento básico (según configuración).
*   **Trabajador:** Ejecución de tareas asignadas y actualización de estado.

---

### 7. Funciones y Utilización del Sistema
En este capítulo se describe el flujo detallado de las funcionalidades disponibles para el rol de Administrador. Cada paso incluye una referencia visual para facilitar la comprensión.

#### 7.1 Inicio de Sesión
1.  **Ingreso a la plataforma:** Abra su navegador y digite la URL del sistema. Visualizará la pantalla de bienvenida.
    
    [Insertar captura de: Pantalla de Bienvenida / Login vacío]

2.  **Autenticación:** Ingrese su correo electrónico y contraseña en los campos correspondientes.
    
    [Insertar captura de: Formulario de Login con datos diligenciados]

3.  **Acceso exitoso:** Haga clic en el botón "Iniciar Sesión". Si los datos son correctos, ingresará al sistema.

4.  **Error de acceso:** Si ingresa credenciales incorrectas, el sistema mostrará una alerta indicando que los datos son inválidos.
    
    [Insertar captura de: Alerta de credenciales inválidas]

#### 7.2 Recuperación de Contraseña
Si ha olvidado su contraseña, el sistema le permite restablecerla siguiendo estos pasos:

1.  **Solicitud de recuperación:** En la pantalla de inicio de sesión, haga clic en el enlace **"¿Olvidaste tu contraseña?"**.
    
    [Insertar captura de: Enlace de recuperación resaltado en el Login]

2.  **Ingreso de correo:** Ingrese su dirección de correo electrónico institucional y haga clic en **"Enviar enlace de recuperación"**.
    
    [Insertar captura de: Formulario de recuperación con correo diligenciado]

3.  **Confirmación de envío:** El sistema mostrará un mensaje indicando que se ha enviado un enlace a su correo electrónico.
    
    [Insertar captura de: Alerta verde de éxito de envío]

4.  **Restablecimiento:** Revise su correo, haga clic en el enlace recibido y asigne una nueva contraseña segura para recuperar el acceso.

#### 7.3 Dashboard del Administrador
1.  **Vista General:** Al ingresar, lo primero que verá es el **Panel de Control**.
    
    [Insertar captura de: Vista completa del Dashboard]

2.  **Tarjetas de Resumen:** Observe los indicadores clave en la parte superior (Total Usuarios, Tareas, Incidentes).
    
    [Insertar captura de: Acercamiento a las Tarjetas de Estadísticas]

3.  **Gráficos:** Analice las estadísticas visuales de "Tareas por Estado" y "Usuarios por Rol".
    
    [Insertar captura de: Gráficos del Dashboard]

#### 7.4 Gestión de Usuarios
1.  **Acceso al Módulo:** En el menú de navegación o desde el Dashboard, haga clic en la opción **"Usuarios"**.
    
    [Insertar captura de: Menú seleccionando Usuarios]

2.  **Lista de Usuarios:** Se mostrará la tabla con todos los usuarios registrados actualmente.
    
    [Insertar captura de: Pantalla con la Tabla de Usuarios]

3.  **Crear Nuevo Usuario:** Haga clic en el botón **"Nuevo Usuario"** ubicado en la parte superior derecha.
    
    [Insertar captura de: Botón Nuevo Usuario]

4.  **Formulario de Registro:** Se abrirá una ventana emergente (modal). Diligencie el Nombre, Correo, Contraseña y seleccione el **Rol** (Administrador, Instructor o Trabajador).
    
    [Insertar captura de: Modal de Crear Usuario con datos llenos]

5.  **Confirmación:** Haga clic en "Guardar". El sistema mostrará un mensaje de éxito.
    
    [Insertar captura de: Mensaje de "Usuario Creado Exitosamente"]

6.  **Editar Usuario:** En la lista, ubique un usuario y haga clic en el botón de **Editar** (ícono de lápiz).
    
    [Insertar captura de: Modal de Edición de Usuario]

7.  **Eliminar Usuario:** Si desea eliminar una cuenta, haga clic en el ícono de **Papelera** y confirme la acción.
    
    [Insertar captura de: Alerta de confirmación para eliminar]

#### 7.5 Gestión de Tareas
1.  **Acceso al Módulo:** Haga clic en la opción **"Tareas"** del menú principal.
    
    [Insertar captura de: Vista general del módulo de Tareas]

2.  **Crear Tarea:** Presione el botón **"Nueva Tarea"**.
    
    [Insertar captura de: Botón Nueva Tarea]

3.  **Detalles de la Tarea:** Llene el formulario con el Título, Descripción, Fecha Límite y Ubicación.
    
    [Insertar captura de: Formulario de Tarea - Parte 1 (Datos básicos)]

4.  **Asignación y Prioridad:** Seleccione la Prioridad (Alta/Media/Baja) y elija al **Trabajador** responsable en la lista desplegable.
    
    [Insertar captura de: Formulario de Tarea - Parte 2 (Asignación y Prioridad)]

5.  **Adjuntar Referencias:** (Opcional) Suba imágenes de referencia si es necesario y haga clic en "Crear".
    
    [Insertar captura de: Carga de imágenes y botón Guardar]

6.  **Revisión de Tarea:** Para revisar una tarea finalizada, haga clic en el botón de **"Ver Detalle"** (ícono de ojo) sobre una tarea en estado "Finalizada".
    
    [Insertar captura de: Icono de ver detalle en una tarea finalizada]

7.  **Aprobar Tarea:** Si el trabajo es satisfactorio, haga clic en el botón **"Aprobar Revisión"**. La tarea pasará a estado "Finalizada".
    
    [Insertar captura de: Botón de Aprobar Tarea]

8.  **Devolver para Corrección:** Si el trabajo requiere ajustes, haga clic en el botón **"Devolver para Corrección"**. La tarea regresará al estado "En Progreso" y el trabajador será notificado.
    
    [Insertar captura de: Botón de Devolver para Corrección]

9.  **Marcar con Retraso:** Si la tarea no se ha cumplido en el tiempo estipulado, puede usar la opción **"Marcar con Retraso"**. La tarea pasará al estado "Retraso en Proceso".
    
    [Insertar captura de: Botón de Marcar con Retraso]

#### 7.6 Gestión de Incidentes
1.  **Bandeja de Entrada:** Ingrese al módulo de **"Incidentes"** para ver los reportes de daños recibidos.
    
    [Insertar captura de: Lista de Incidentes recibidos]

2.  **Ver Detalle:** Haga clic en un incidente específico para ver la descripción completa y las fotos de evidencia.
    
    [Insertar captura de: Vista detallada del Incidente]

3.  **Convertir a Tarea:** Si el incidente requiere reparación, haga clic en el botón **"Convertir a Tarea"**.
    
    [Insertar captura de: Ubicación del botón Convertir a Tarea]

4.  **Formulario de Conversión:** El sistema abrirá el formulario de creación de tarea con los datos del incidente ya precargados. Asigne un trabajador y guarde.
    
    [Insertar captura de: Formulario de tarea con datos del incidente precargados]

#### 7.7 Notificaciones
1.  **Alertas:** Haga clic en el ícono de la **Campana** en la barra superior derecha.
    
    [Insertar captura de: Ícono de campana con indicador de alertas]

2.  **Leer Notificación:** Se desplegará la lista de eventos recientes. Haga clic en una para ir al detalle.
    
    [Insertar captura de: Lista desplegable de notificaciones]

#### 7.8 Perfil del Administrador
1.  **Menú de Usuario:** Haga clic en su nombre o avatar en la esquina superior derecha para desplegar el menú de cuenta.
    
    [Insertar captura de: Menú de usuario desplegado]

2.  **Ver Perfil:** Seleccione la opción **"Mi Perfil"**. Aquí podrá ver sus datos personales, rol y fecha de ingreso.
    
    [Insertar captura de: Vista de Mi Perfil]

3.  **Ir a Configuración:** Desde la vista de perfil, puede hacer clic en el botón **"Ir a Configuración"** para gestionar su cuenta (cambio de contraseña y datos).

#### 7.9 Configuración
El módulo de configuración permite personalizar su experiencia en SIGERD:

1.  **Acceso:** Seleccione **"Configuración"** en el menú de usuario o desde la vista de perfil.
    
    [Insertar captura de: Módulo de Configuración abierto]

2.  **Notificaciones:** Configure qué tipo de alertas desea recibir (Nuevas tareas, cambios de estado).
    
    [Insertar captura de: Pestaña de Notificaciones]

3.  **Apariencia:** Cambie el tema del sistema entre **Claro**, **Oscuro** o **Sistema** (automático).
    
    [Insertar captura de: Pestaña de Apariencia con opciones de tema]

#### 7.10 Ayuda y Soporte
Si presenta dudas o inconvenientes técnicos, SIGERD cuenta con un centro de soporte integrado:

1.  **Acceso:** Haga clic en la opción **"Soporte"** en el menú de usuario.
    
    [Insertar captura de: Vista del Centro de Ayuda]

2.  **FAQs:** Consulte la lista de preguntas frecuentes para resolver dudas comunes de inmediato.
    
    [Insertar captura de: Sección de Preguntas Frecuentes]

3.  **Contacto:** Utilice el botón **"Contactar Soporte"** si requiere asistencia directa del equipo técnico.

#### 7.11 Cerrar Sesión
1.  **Salir:** Despliegue el menú de usuario y haga clic en la opción **"Cerrar Sesión"**.
    
    [Insertar captura de: Opción Cerrar Sesión resaltada]

2.  **Confirmación:** El sistema cerrará la sesión de forma segura y lo redirigirá al Login.
    
    [Insertar captura de: Redirección al Login]

---

### 8. Preguntas Frecuentes

**¿Cómo recupero mi contraseña?**
Ingrese a la página principal y haga clic en "¿Olvidó su contraseña?". Recibirá un correo con instrucciones para restablecerla.

**¿Puedo reasignar una tarea ya creada?**
Sí. Busque la tarea en el listado, haga clic en el botón de editar y cambie el trabajador en el campo "Asignar a".

**¿Qué hago si un trabajador no aparece en la lista de asignación?**
Verifique en el módulo de Usuarios que la persona esté registrada correctamente y que su rol sea estrictamente "Trabajador".

**¿Cómo actualizo mis datos personales?**
Desde su perfil (menú superior derecho), seleccione "Perfil" para editar su nombre, correo o contraseña.

**¿Cuál es la diferencia entre un Incidente y una Tarea?**
Un **Incidente** es un reporte de un daño o problema (generalmente creado por un Instructor). Una **Tarea** es la asignación formal de trabajo a un operario para solucionar dicho problema.

**¿Puedo eliminar un usuario del sistema?**
Sí, desde la gestión de usuarios puede eliminar una cuenta. Tenga en cuenta que esto podría afectar el historial de las tareas que esa persona tenía asignadas anteriormente.

**¿Cómo sé si una tarea está vencida?**
En el Dashboard principal existe una tarjeta llamada "Tareas Vencidas" que muestra el contador. Además, en la lista de tareas, aquellas cuya fecha límite haya pasado se marcarán visualmente (generalmente en rojo).

**¿Puedo cambiar el rol de un usuario ya creado?**
Sí, puede editar el usuario y seleccionar un nuevo rol en el menú desplegable. Recuerde guardar los cambios.

**¿Qué formatos de imagen se permiten para las evidencias?**
El sistema acepta imágenes en formato JPG, JPEG y PNG. Se recomienda que no superen los 2MB de peso para garantizar una carga rápida.

### 9. Solución de Problemas

| Problema | Posible causa | Solución |
| :--- | :--- | :--- |
| **No carga el sistema** | Problemas de red | Verificar conexión a Internet. |
| **Error 500** | Fallo del servidor | Reportar inmediatamente a soporte técnico con captura de pantalla. |
| **Acceso denegado** | Rol incorrecto | Verifique que está ingresando con una cuenta de Administrador. |
| **No se suben imágenes** | Archivo muy pesado | Asegúrese de que las imágenes pesen menos de 2MB. |
| **Usuario duplicado** | Correo ya registrado | Verifique que el correo electrónico no esté asignado a otro usuario activo. |
| **No puedo asignar tarea** | Falta de trabajadores | Asegúrese de tener usuarios creados con el rol de 'Trabajador'. |
| **Error al exportar PDF** | Bloqueo de pop-ups | Habilite las ventanas emergentes en su navegador para descargar el reporte. |

### 10. Datos de Contacto
**Oficina de Tecnología y Sistemas de Información**
*   **Teléfono:** (1) 3456789
*   **Correo electrónico:** soporte@sigerd.gov.co
*   **Horario de atención:** Lunes a viernes de 8:00 a.m. a 5:00 p.m.
