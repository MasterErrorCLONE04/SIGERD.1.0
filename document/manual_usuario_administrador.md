# MANUAL DE USUARIO DEL SISTEMA DE INFORMACIÓN

**Proyecto:** Sistema de Gestión de Reportes de Daños (SIGERD)  
**Módulo:** Dashboard del Administrador  
**Versión:** 1.0  
**URL Base:** http://127.0.0.1:8000/

_Análisis y Desarrollo de Software_

**Servicio Nacional de Aprendizaje SENA**  
**Centro de Formación Agroindustrial La Angostura**  
**Regional Huila – Campoalegre**  
_Marzo de 2026_

---

## Tabla de Contenido
1. [Objetivo](#1-objetivo)
2. [Alcance](#2-alcance)
3. [Términos y Definiciones](#3-términos-y-definiciones)
4. [Introducción](#4-introducción)
5. [Objetivo del Sistema de Información Desarrollado](#5-objetivo-del-sistema-de-información-desarrollado)
6. [Alcance Funcional y Organizacional](#6-alcance-funcional-y-organizacional)
7. [Funciones y Utilización del Sistema](#7-funciones-y-utilización-del-sistema)
    - 7.1 Inicio de Sesión
    - 7.2 Dashboard del Administrador
    - 7.3 Gestión de Usuarios
    - 7.4 Gestión de Tareas
    - 7.5 Gestión de Incidentes
    - 7.6 Notificaciones
    - 7.7 Perfil del Administrador
    - 7.8 Cerrar Sesión
8. [Preguntas Frecuentes](#8-preguntas-frecuentes)
9. [Solución de Problemas](#9-solución-de-problemas)
10. [Datos de Contacto](#10-datos-de-contacto)

---

## 1. Objetivo 
El presente manual de usuario tiene como objetivo proporcionar información detallada sobre el funcionamiento, arquitectura, configuración y mantenimiento del Sistema de Gestión de Reportes de Daños – SIGERD, dirigido específicamente al perfil de Administrador. Este documento guía al usuario en la gestión eficiente de usuarios, tareas e incidentes dentro de la plataforma.

## 2. Alcance 
Este manual abarca los aspectos funcionales del sistema SIGERD para el rol de Administrador, incluyendo la gestión de usuarios, asignación y supervisión de tareas, monitoreo de incidentes y reporte de actividades. No incluye funciones específicas de los roles Instructor o Trabajador, salvo en su relación con la administración.

## 3. Términos y Definiciones

| TÉRMINO | DEFINICIÓN |
|---|---|
| **SIGERD** | Sistema de Gestión de Reportes de Daños |
| **Back-end** | Parte del sistema que gestiona la lógica del lado del servidor (Laravel/PHP) |
| **Front-end** | Interfaz gráfica interactiva de usuario (Blade/Tailwind) |
| **Incidente** | Reporte de un daño o falla en las instalaciones reportado visualmente al sistema |
| **Tarea** | Actividad asignada a un trabajador para resolver un incidente |
| **Dashboard** | Tablero de control principal que muestra indicadores y estadísticas |
| **Rol de Usuario** | Permisos y responsabilidades del usuario (Administrador, Instructor o Trabajador) |
| **Estado de Tarea** | Condición actual formal de una actividad (Asignada, En Progreso, Realizada) |
| **Prioridad** | Nivel de urgencia establecido para atender una tarea (Alta, Media, Baja) |
| **Evidencia** | Archivos (imágenes menores a 2MB) que documentan fotográficamente un evento |
| **Notificación** | Aviso asíncrono sobre un evento clave dentro del sistema interconectado |
| **Exportar PDF** | Generación de documentos formales usando la librería de DomPDF |
| **Base de Datos** | Estructura donde se almacena todo el esquema en MySQL 8.0 |

## 4. Introducción 
SIGERD (Sistema de Gestión de Reportes de Daños) es una plataforma web integral diseñada para optimizar, automatizar y centralizar el proceso de reporte, seguimiento y solución de incidentes en la infraestructura de la institución. El sistema permite al administrador tener un control total sobre los usuarios, asignar tareas de mantenimiento a los trabajadores de forma expedita, monitorear los estados y generar estadísticas PDF automatizadas.

Tecnologías del entorno:
- **Backend:** PHP 8.2+ con Laravel 12.x (Patrón MVC Modular).
- **Frontend:** Blade Templates, TailwindCSS (Diseño Responsivo) y Alpine.js.
- **Base de Datos:** MySQL 8.0 / MariaDB.
- **Servidor Local:** Laragon, XAMPP, Nginx o Servidor Integrado PHP.

## 5. Objetivo del Sistema de Información Desarrollado
El objetivo es facilitar la toma de decisiones basada en métricas y evidencias, agilizar la respuesta técnica ante incidentes de daños locales, y asegurar una trazabilidad inmutable de las operaciones de mantenimiento.

## 6. Alcance Funcional y Organizacional

**Funcional:**
- Gestión de Usuarios (CRUD total a contraseñas y perfiles).
- Gestión de Tareas (Emisión, aprobación y rechazo de evidencias).
- Tablero Analítico Interactivo de Incidentes y Productividad.

**Organizacional:**
- **Administrador:** Control Máximo.
- **Instructor:** Visualiza y crea Incidentes.
- **Trabajador:** Operario visualizador de Tareas e inyector de Evidencias en Terreno.

---

## 7. Funciones y Utilización del Sistema

En este capítulo se describe el flujo detallado de las funcionalidades disponibles para el rol de Administrador junto con las capturas automatizadas del sistema:

### 7.1 Inicio Sesión

1. **Ingreso a la plataforma:** Abra su navegador y digite la URL del sistema. Visualizará la pantalla de bienvenida.
   ![Pantalla de Bienvenida / Login vacío](capturas_manual_usuario_admin/1_login_vacio.png)
2. **Autenticación:** Ingrese su correo electrónico y contraseña en los campos correspondientes.
   ![Formulario de Login con datos diligenciados](capturas_manual_usuario_admin/2_login_lleno.png)
3. **Acceso exitoso:** Haga clic en el botón "Iniciar Sesión".
   *(Redirección Automática al Dashboard asegurada por Middleware).*
4. **Error de acceso:** Si ingresa credenciales incorrectas, el sistema mostrará una alerta indicando que los datos son inválidos.
   ![Alerta de credenciales inválidas](capturas_manual_usuario_admin/3_login_error.png)

### 7.2 Dashboard del Administrador

1. **Vista General:** Al ingresar, lo primero que verá es el Panel de Control.
   ![Vista completa del Dashboard](capturas_manual_usuario_admin/4_dashboard_general.png)
2. **Tarjetas de Resumen y Gráficos:** Observe los indicadores clave en la parte superior y analice las estadísticas visuales (Usuarios por Rol, Tareas por Prioridad, y Estados).
   *(Los Gráficos y Tarjetas están expuestos centralmente en la captura general anterior)*.

### 7.3 Gestión de Usuarios

1. **Acceso al Módulo:** En el menú lateral, haga clic en el botón "Usuarios". Las interacciones de la lista ocurren aquí:
   ![Pantalla con la Tabla de Usuarios](capturas_manual_usuario_admin/6_lista_usuarios.png)
2. **Crear y Modificar Usuario:** Pulse los botones correspondientes a Creación de Nuevo Usuario o el ícono de Edición (`Editar Usuario`).
   ![Formulario de Creación (Captura)](capturas_manual_usuario_admin/7_crear_usuario.png)
3. **Confirmación y Eliminación:** Una vez rellenados Rol, Nombre y Contraseña, un mensaje verde le confirmará la acción. Asimismo el botón de papelera sirve para borrar, lanzando alerta formal.

### 7.4 Gestión de Tareas

1. **Acceso e Interfaz de Trabajo:** Seleccione "Tareas" para abrir el listado logístico de actividades del sistema.
   ![Vista general del módulo de Tareas](capturas_manual_usuario_admin/8_lista_tareas.png)
2. **Nueva Tarea / Preasignaciones:** Pulse `Nueva Tarea` para ver el Formulario Completo de Tarea. Asigne la prioridad (Alta/Baja), la fecha de expiración y despliegue la lista para elegir a un "Trabajador" al que recaerá la acción.
   ![Formulario Padrón de Tarea](capturas_manual_usuario_admin/9_crear_tarea.png)
3. **Verificar Evidencias y Aprobaciones:** Una tarea que fue llevada al estado de "Realizada" por el Trabajador mostrará fotografías que un Administrador debe validar desde el Detalle (`Ojo`).
   ![Evidencias de Trabajador (Detalle)](capturas_manual_usuario_admin/10_detalle_tarea_evidencia.png)
4. **Exportar a PDF:** Use el botón de descarga situado sobre la tabla global para formalizar todas las visualizaciones a un documento ISO con membrete.

### 7.5 Gestión de Incidentes 

1. **Revisar Solicitudes:** Ingrese a "Incidentes" para ver la "Bandeja de Entrada" enviada por Instructores que reportan averías.
   ![Detalle Global de Incidentes](capturas_manual_usuario_admin/11_lista_incidentes.png)
2. **Evaluar el Daño o Convertición:** Acceda mediante el botón `Ver` y analice la Ficha que contiene Fotos del daño original. Si aplica, pulse el botón "Convertir a Tarea" para redirigir toda esa metadata precargada en una orden de trabajo operativa.
   ![Incidente Fotográfico (Detalle)](capturas_manual_usuario_admin/12_detalle_incidente.png)

### 7.6 Notificaciones 
1. **Campanita de Alertas:** El ícono interactivo superior reportará de manera asincrónica qué nuevas asignaciones se generaron, o qué Tareas ya pasaron a "En Progreso" y necesitan su evaluación.
   ![Notificaciones de Sistema](capturas_manual_usuario_admin/5_notificaciones.png)

### 7.7 Perfil del Administrador
1. **Su Ficha de Seguridad:** Haga clic en su icono de usuario. Accederá al módulo `profile` donde alterará contraseñas o datos biométricos de su Avatar.
   ![Actualización de Datos Persistentes](capturas_manual_usuario_admin/13_perfil_usuario.png)
   
---

## 8. Preguntas Frecuentes

- **¿Cómo recupero mi contraseña?** El administrador general del sistema interno asigna y re-asigna passwords desde el Módulo "Usuarios". En un despliegue total, use el comando "Olvidé mi contraseña" en la página principal.
- **¿Puedo reasignar una tarea ya creada?** Sí. En el listado haga clic en editar y cambie al nuevo operario en el campo "Asignar a".
- **¿Qué hago si un trabajador no aparece en la lista de asignación?** Garantice primero que la persona tenga seleccionada concretamente la opción "Trabajador" en el select de su Rol al crearlo/editarlo.
- **¿Cuál es la diferencia entre un Incidente y una Tarea?** Un *Incidente* expone que hay algo dañado en el centro. Una *Tarea* dicta la directiva formal de "quién, cuándo y con qué prioridad" arreglará ese daño.
- **¿Qué formatos de imagen se permiten para las evidencias?** Todo componente sube fotografías `.png`, `.jpg`, `.jpeg`. Para asegurar la velocidad del AWS / Servidor, el *FormRequest* de Laravel abortará forzosamente cualquier archivo superior a `2MB`.

## 9. Solución de Problemas

| Problema | Posible Causa | Solución |
|---|---|---|
| **No carga el sistema** | Problemas de red o hosting caído | Verificar conexión LAN/Wan al Servidor o recargar Apache/Nginx. |
| **Error 500 Constante** | Fallas fatales en PHP / MySQL | Abrir consola y revisar logs o notificar a Tecnología con Screenshots. |
| **Acceso Denegado (403)** | Rol incorrecto a Nivel de Middleware | Chequear que usted está usando la cuenta designada como "Administrador". |
| **No se cargan las Imágenes** | `Storage Link` roto | Exigir a sistemas correr `php artisan storage:link` por terminal, o la foto es mayor a 2MB. |
| **Usuario duplicado** | Correo o DNI ya registrado | Buscar qué usuario ya tiene registrado ese identificador y reasignarlo. |
| **No puedo Asignar Tareas** | Catálogo sin empleados | Diríjase al Módulo de Usuarios y cree al menos una persona con el perfil de "Trabajador". |
| **PDF no carga** | GD / DomPDF Missing | Instalar Extensión PHP_GD y librerías temporales. |

## 10. Datos de Contacto
**Oficina de Tecnología y Sistemas de Información**
- **Teléfonos:** 302 5382862 / 305 3474244
- **Correo Electrónico:** soporte@sigerd.gov.co
- **Horario de atención:** Lunes a viernes de 8:00 a.m. a 5:00 p.m.
