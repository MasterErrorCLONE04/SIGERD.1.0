# Manual Técnico del Software

**Nombre del software:** GA10-220501097-AA10-EV01 (SIGERD)
**Versión del software:** 1.0
**Nombre del programa de formación:** Tecnólogo en Análisis y Desarrollo de Software

**Ficha de formación:** 220501097
**Fecha de entrega:** Julio 2025
**Nombres completos de los aprendices/desarrolladores:** [Escribir nombres]
**Nombre del instructor:** [Escribir nombre]
**Centro de formación y regional del SENA:** [Ejemplo: Centro de Comercio y Servicios - Regional Valle]

---

## Contenido
1. [DESCRIPCIÓN DEL SISTEMA](#descripción-del-sistema)
2. [DISEÑO TÉCNICO DEL SISTEMA](#diseño-técnico-del-sistema)
3. [DESPLIEGUE Y CONFIGURACIÓN](#despliegue-y-configuración)
4. [RESOLUCIÓN DE PROBLEMAS](#resolución-de-problemas)
5. [BIBLIOGRAFIA](#bibliografia)

---

## 1. DESCRIPCIÓN DEL SISTEMA

### INTRODUCCIÓN
El sistema SIGERD es una plataforma web integral diseñada para la gestión eficiente de incidentes y tareas. Construido sobre el framework Laravel, permite a las organizaciones centralizar el reporte de fallos, el seguimiento de actividades y la comunicación entre los diferentes roles involucrados en la resolución de problemas técnicos o administrativos.

### OBJETIVO GENERAL
Proveer una herramienta robusta y escalable que optimice el ciclo de vida de los incidentes y la asignación de tareas, mejorando los tiempos de respuesta y la trazabilidad de los procesos operativos.

#### Casos de uso
- **Gestión de Usuarios:** Registro, autenticación y administración de perfiles.
- **Registro de Incidentes:** Permitir a los usuarios reportar problemas con descripciones y evidencias.
- **Asignación de Tareas:** Crear y delegar tareas específicas derivadas de incidentes.
- **Notificaciones:** Sistema de alertas para mantener informados a los responsables.

#### Documento de requerimientos
*Referencia al documento de Análisis de Requisitos del Software (SRS) de la etapa de planificación.*

---

## 2. DISEÑO TÉCNICO DEL SISTEMA

### Requisitos de hardware
- **Procesador:** Mínimo 2 núcleos (Recomendado 4 núcleos).
- **Memoria RAM:** Mínimo 4GB (Recomendado 8GB para entornos de desarrollo).
- **Almacenamiento:** Mínimo 500MB libres para la aplicación + espacio para base de datos y archivos multimedia.

### Requisitos de software
- **Sistema operativo:** Compatible con Windows (Laragon/XAMPP), Linux (Ubuntu/Debian) o macOS.
- **Servidor de base de datos:** MySQL 8.0 o superior / MariaDB 10.4+.
- **Lenguaje de Programación:** PHP 8.2 o superior.
- **Navegadores compatibles:** Google Chrome, Mozilla Firefox, Microsoft Edge (versiones recientes).

### Plataformas tecnológicas Utilizadas
- **Frameworks:**
    - **Backend:** Laravel 12.
    - **Frontend:** Tailwind CSS, Blade Templates.
- **Librerías:**
    - Spatie Laravel Medialibrary (Gestión de medios).
    - Pusher (Notificaciones en tiempo real).
    - Barryvdh Laravel DOMPDF (Generación de Reportes PDF).
- **Patrones de diseño:**
    - **MVC (Model-View-Controller):** Separación de lógica de negocio, datos e interfaz.
    - **Eloquent ORM:** Mapeo objeto-relacional para la base de datos.
- **Protocolos de seguridad:**
    - Autenticación vía Laravel Breeze.
    - Protección contra CSRF, XSS e Inyección SQL (integrado en el core de Laravel).
    - Encriptación de contraseñas mediante BCRYPT.

### MODELO DE BASE DE DATOS

#### Diagrama entidad-relación
*(Debe incluirse imagen del modelo aquí)*
![Diagrama ER](path/to/diagrama_er.png)

#### Diccionario de datos

##### Tabla: users (Usuarios del sistema)
| Campo | Tipo | Nulo | Descripción |
| :--- | :--- | :--- | :--- |
| id | bigint (PK) | No | Identificador único de usuario. |
| name | varchar(255) | No | Nombre completo del usuario. |
| email | varchar(255) | No | Correo electrónico (único). |
| role | varchar(255) | Sí | Rol en el sistema (admin, trabajador). |
| password | varchar(255) | No | Contraseña encriptada. |
| created_at | timestamp | Sí | Fecha de creación del registro. |

##### Tabla: incidents (Reportes de incidentes)
| Campo | Tipo | Nulo | Descripción |
| :--- | :--- | :--- | :--- |
| id | bigint (PK) | No | Identificador único del incidente. |
| title | varchar(255) | No | Título breve del incidente. |
| description | text | Sí | Detalle extenso del suceso. |
| status | varchar(255) | No | Estado (pendiente, en revisión, resuelto, cerrado). |
| image | varchar(255) | Sí | Ruta de la imagen de evidencia inicial. |
| resolved_at | timestamp | Sí | Fecha y hora de resolución. |
| resolution_description | text | Sí | Comentarios sobre cómo se resolvió. |
| reported_by | bigint (FK) | No | ID del usuario que reportó (Relación con users). |

##### Tabla: tasks (Tareas de mantenimiento/seguimiento)
| Campo | Tipo | Nulo | Descripción |
| :--- | :--- | :--- | :--- |
| id | bigint (PK) | No | Identificador único de la tarea. |
| incident_id | bigint (FK) | Sí | ID del incidente asociado si aplica. |
| title | varchar(255) | No | Nombre de la tarea. |
| priority | varchar(255) | No | Prioridad (baja, media, alta). |
| status | varchar(255) | No | Estado (pendiente, progreso, finalizada). |
| deadline_at | timestamp | No | Fecha límite de cumplimiento. |
| location | varchar(255) | No | Lugar donde debe ejecutarse la tarea. |
| assigned_to | bigint (FK) | Sí | Usuario responsable de la ejecución. |

##### Tabla: notifications (Alertas del sistema)
| Campo | Tipo | Nulo | Descripción |
| :--- | :--- | :--- | :--- |
| id | bigint (PK) | No | Identificador único. |
| user_id | bigint (FK) | No | Usuario destinatario. |
| type | varchar(255) | No | Tipo de evento notificado. |
| message | text | No | Cuerpo del mensaje de alerta. |
| read | boolean | No | Estado de lectura (true/false). |

#### Diagrama de componentes
El sistema se compone de un cliente web, una API RESTful interna (Laravel), y un motor de base de datos relacional (MySQL).

#### Diagrama de clases
Estructura basada en Modelos (User, Incident, Task) y sus respectivos Controladores y Request Validators.

---

## 3. DESPLIEGUE Y CONFIGURACIÓN

### Instalación:
#### Prerrequisitos
- Instalación de PHP 8.2+, MySQL, Composer y Node.js.
- Servidor local (ej. Laragon en Windows).

#### Scripts de base de datos
El sistema utiliza migraciones de Laravel instalables mediante:
`php artisan migrate`

#### Pasos de instalación
1. Clonar el repositorio.
2. Ejecutar `composer install` para dependencias de backend.
3. Crear archivo `.env` basado en `.env.example`.
4. Generar clave de aplicación: `php artisan key:generate`.
5. Ejecutar `npm install` y `npm run build` para assets.
6. Configurar la base de datos en el `.env`.
7. Ejecutar migraciones: `php artisan migrate --seed`.

#### Link de Repositorio de Git Hub.
[https://github.com/[usuario]/SIGERD](https://github.com/[usuario]/SIGERD)

### Configuración:
#### Parámetros
- **APP_URL:** URL del software desplegado.
- **DB_DATABASE:** Nombre de la base de datos.
- **MAIL_MAILER:** Configuración del servidor de correo para notificaciones.

#### Roles y permisos
- **Administrador:** Acceso total al sistema.
- **Técnico/Desarrollador:** Gestión de tareas e incidentes asignados.
- **Usuario Final:** Reporte de incidentes y consulta de estado.

### Despliegue:
#### Diagrama de despliegue
*(Insertar diagrama que muestre Cliente -> Servidor Web -> DB)*

#### Puertos y conexiones
- HTTP: 80 / HTTPS: 443.
- MySQL: 3306.
- Vite: 5173 (Entorno de desarrollo).

---

## 4. RESOLUCIÓN DE PROBLEMAS

| Error común | Posible causa | Solución |
| :--- | :--- | :--- |
| Error 500 / "Whoops" | Error de sintaxis o configuración de entorno | Activar `APP_DEBUG=true` en `.env` para ver el detalle. |
| Fallo en conexión DB | Credenciales incorrectas en `.env` | Verificar `DB_USERNAME`, `DB_PASSWORD` y que el servicio de MySQL esté corriendo. |
| Assets no cargan (CSS/JS) | Compilación faltante | Ejecutar `npm run build` en producción o `npm run dev` en desarrollo. |
| Carpetas sin permisos | Permisos de escritura bloqueados | Dar permisos de escritura a `storage` y `bootstrap/cache`. |

---

## 5. BIBLIOGRAFIA

**WEBLIOGRAFIA**

- Laravel Documentation. (2025). [https://laravel.com/docs](https://laravel.com/docs)
- Departamento Nacional de Planeación (DNP). (2020). Guía para la elaboración del manual técnico y de operación de los sistemas de información (Versión 2.0). Oficina de Tecnologías y Sistemas de Información, Grupo de Gestión de Sistemas de Información.
