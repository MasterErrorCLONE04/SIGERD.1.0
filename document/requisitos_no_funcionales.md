# Requisitos No Funcionales - SIGERD

Este documento detalla los requerimientos no funcionales (atributos de calidad, restricciones y rendimiento) del sistema SIGERD, alineados estrictamente con sus capacidades técnicas actuales.

---

## 3.3.1 Requisitos de rendimiento

### RNF-01
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-01** |
| **Nombre de requisito** | Soporte de Concurrencia de Usuarios |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • El sistema debe soportar al menos 500 usuarios concurrentes sin degradación significativa del rendimiento, respaldado por la configuración del servidor web y caché de Laravel. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-02
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-02** |
| **Nombre de requisito** | Tiempo de Respuesta de Operaciones |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Las consultas y operaciones realizadas por los usuarios deben completarse en un tiempo promedio de respuesta inferior a 2 segundos. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-03
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-03** |
| **Nombre de requisito** | Capacidad de Gestión de Reportes |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • El sistema debe poder procesar y gestionar un mínimo de 100 reportes por hora, con posibilidad de escalabilidad a mayores volúmenes mediante la optimización de consultas Eloquent. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-04
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-04** |
| **Nombre de requisito** | Velocidad de Generación de Informes |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • La exportación de reportes PDF (mediante DomPDF) debe generarse de manera optimizada en un tiempo no superior a 5 segundos para conjuntos de datos estándar del mes. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

## 3.3.2 Seguridad

### RNF-05
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-05** |
| **Nombre de requisito** | Autenticación Basada en Roles |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • El sistema garantiza, mediante middlewares de Laravel, que cada usuario acceda únicamente a las funcionalidades asignadas según su perfil (Administrador, Instructor o Trabajador). |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-06
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-06** |
| **Nombre de requisito** | Comunicación Segura con HTTPS |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Se debe asegurar la protección de datos en tránsito forzando el uso de protocolos SSL/TLS (HTTPS) a nivel de servidor (Nginx/Apache). |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-07
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-07** |
| **Nombre de requisito** | Cifrado y Hashing de Datos Sensibles |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Protege las contraseñas de los usuarios en la base de datos utilizando el algoritmo de hashing unidireccional Bcrypt. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-08
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-08** |
| **Nombre de requisito** | Prevención de Inyección SQL y XSS |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • El uso del ORM Eloquent y el motor de plantillas Blade mitiga nativamente los ataques de inyección SQL y Cross-Site Scripting (XSS). |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

## 3.3.3 Fiabilidad

### RNF-09
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-09** |
| **Nombre de requisito** | Alta Fiabilidad del Sistema |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • La arquitectura del servidor debe garantizar un nivel de funcionamiento y disponibilidad superior al 99.9%. |
| **Prioridad del requisito** | ☐ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☒ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-10
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-10** |
| **Nombre de requisito** | Recuperación Automática ante Errores Críticos |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Se deben implementar mecanismos a nivel de Sistema Operativo (ej. Supervisor, Systemd) para reiniciar los servicios web y reconectar la base de datos automáticamente en caso de fallos. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-11
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-11** |
| **Nombre de requisito** | Copias de Seguridad y Restauración Rápida |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Se deben configurar tareas programadas (CRON) en el servidor para asegurar respaldos diarios automáticos de la base de datos MySQL. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

## 3.3.4 Disponibilidad

### RNF-12
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-12** |
| **Nombre de requisito** | Alta Disponibilidad del Sistema |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Asegura un tiempo operativo del 99.5%, limitando la inactividad mensual planificada a un máximo de 4 horas para actualizaciones. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-13
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-13** |
| **Nombre de requisito** | Notificaciones de Mantenimiento Programado |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Se debe informar a los usuarios con al menos 24 horas de antelación sobre actualizaciones o interrupciones previstas en el servidor. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

## 3.3.5 Mantenibilidad

### RNF-14
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-14** |
| **Nombre de requisito** | Estandarización y Documentación del Código |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • El código fuente en PHP debe seguir los estándares PSR-12 y la arquitectura lógica de Laravel para facilitar la legibilidad de otros desarrolladores. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-15
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-15** |
| **Nombre de requisito** | Gestión Centralizada de Dependencias |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Uso de archivos centralizados (composer.json para PHP, package.json para Node/Tailwind) para la gestión segura de dependencias externas. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-16
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-16** |
| **Nombre de requisito** | Facilidad de Expansión |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • El uso estricto del patrón Modelo-Vista-Controlador (MVC) permite la integración de nuevas funcionalidades sin romper la lógica existente. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-17
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-17** |
| **Nombre de requisito** | Logs Accesibles para Diagnóstico |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Registros de errores detallados y trazables a través de los archivos de log nativos de Laravel (storage/logs) para resolver incidencias rápidamente. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

## 3.3.6 Portabilidad

### RNF-18
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-18** |
| **Nombre de requisito** | Compatibilidad con Navegadores Modernos |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Asegura el correcto funcionamiento en Google Chrome, Firefox, Safari y Microsoft Edge en sus versiones estables actuales. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-19
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-19** |
| **Nombre de requisito** | Diseño Responsivo Multidispositivo |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Garantiza una experiencia de usuario óptima en móviles, tabletas y pantallas de escritorio gracias al uso de utilidades CSS (TailwindCSS). |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-20
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-20** |
| **Nombre de requisito** | Soporte Multiplataforma de Servidores |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • El sistema es inherentemente multiplataforma, compatible con entornos de servidor Linux y Windows (mediante XAMPP/Laragon o Nginx/Apache). |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RNF-21
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RNF-21** |
| **Nombre de requisito** | Escalabilidad de la Base de Datos |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Posibilidad de migrar la base de datos de MySQL a sistemas como PostgreSQL sin reescribir consultas SQL gracias a la capa de abstracción del ORM Eloquent. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

