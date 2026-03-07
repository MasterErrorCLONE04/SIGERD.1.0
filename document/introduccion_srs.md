# 1 Introducción

Este documento describe detalladamente las funcionalidades, características y restricciones del **Sistema de Gestión de Reportes de Daños (SIGERD)**, implementado en el **Centro de Formación Agroindustrial**. Su objetivo principal es proporcionar una guía clara sobre este software, el cual permite a los instructores reportar problemas físicos e infraestructurales, a los administradores asignar y supervisar estas tareas, y a los trabajadores ejecutar y registrar las reparaciones, mejorando sustancialmente la eficiencia y trazabilidad en estos procesos operativos.

El sistema abarca funcionalidades clave como la creación y gestión digital de reportes de incidentes, asignación directa de tareas a trabajadores, seguimiento fotográfico del progreso, notificaciones dentro de la plataforma y la generación de estadísticas y reportes en PDF. Los roles involucrados son:
- **Instructores:** Quienes reportan los daños hallados en la infraestructura.
- **Administradores:** Quienes gestionan usuarios, priorizan incidentes, asigan tareas y evalúan el trabajo final.
- **Trabajadores:** Quienes ejecutan las reparaciones operativas in situ y suben evidencias de conclusión.

El proyecto se orienta a ser una plataforma web moderna accesible desde dispositivos móviles y de escritorio conectados a internet. El documento incluye escenarios de uso y casos prácticos. 

Este documento (y sus anexos) están estructurados para abarcar desde la descripción general hasta los requisitos funcionales, no funcionales, diagramas de componentes, clases y despliegue técnico; garantizando que todas las partes involucradas comprendan las especificaciones del software SIGERD. Servirá como una referencia integral sobre la arquitectura y capacidad del proyecto.

## 1.1 Objetivo General

El objetivo principal de este documento es definir y detallar los requisitos, capacidades y la arquitectura del **Sistema de Gestión de Reportes de Daños (SIGERD)** en el **Centro de Formación Agroindustrial**. Este software optimiza el proceso íntegro de registro, asignación y solución de daños de infraestructura, proporcionando herramientas digitales eficientes para mejorar la trazabilidad y la gestión de recursos físicos humanos.

Este documento está dirigido principalmente a las siguientes audiencias:
- **Equipo de desarrollo de software:** Para comprender la estructura funcional, técnica y la arquitectura de bases de datos necesarias para mantener o escalar el sistema.
- **Administradores del Centro / Directivos:** Para garantizar que sus necesidades operativas de trazabilidad y gestión estén correctamente plasmadas.
- **Interesados internos (Usuarios Finales):** Administradores del sistema, trabajadores operativos e instructores, quienes utilizan el sistema en su día a día.

El propósito central es servir como una guía técnica integral que facilite la comprensión del sistema entre todas las partes involucradas, asegurando que el producto cumple con los objetivos institucionales establecidos.

### 1.1.1 Objetivos Específicos

1. **Optimizar el registro y seguimiento de reportes de daños**  
   Proporcionar un sistema donde los **Instructores** puedan reportar daños físicos e infraestructurales con información detallada, incluyendo títulos, ubicaciones precisas, descripciones y fotografías adjuntas como evidencia inicial.

2. **Facilitar la asignación ágil de tareas**  
   Ofrecer funcionalidad robusta para que los **Administradores** puedan convertir rápidamente los incidentes reportados en tareas formales y asignarlas a los **Trabajadores** específicos, definiendo prioridades (Alta, Media, Baja) y fechas límite de ejecución.

3. **Notificar y gestionar el estado de las tareas**  
   El sistema informa a través de alertas visuales internas a los trabajadores sobre las tareas asignadas, y permite actualizar el ciclo de vida de las mismas (desde "Pendiente" hasta "En Progreso" y "Realizada"), asegurando la trazabilidad total de las reparaciones con evidencias finales.

4. **Proveer herramientas para la supervisión y análisis**  
   Un módulo de "Dashboard Principal" y "Reportes" que ofrezca a los administradores estadísticas visuales sobre el progreso de las tareas, conteo de incidentes, y reportes exportables en formato PDF para formalizar el trabajo realizado.

5. **Garantizar la usabilidad y accesibilidad del sistema**  
   Una interfaz web intuitiva, segura (basada en sesiones) y responsive (adaptable a dispositivos móviles), construida con Laravel y TailwindCSS, que asegura interacciones fluidas sin necesidad de instalaciones pesadas en los clientes.

6. **Centralizar la gestión de usuarios y permisos**  
   Un gestor administrativo interno que permite centralizar los roles (Administrador, Trabajador, Instructor), garantizando un control estricto sobre el acceso a los módulos correspondientes de la plataforma.

## 1.2 Propósito

El propósito de este documento es especificar de manera clara y detallada el alcance y operación del **Sistema de Gestión de Reportes de Daños (SIGERD)** del Centro de Formación Agroindustrial. Este material documenta la alineación alcanzada entre las necesidades operativas de la institución y las capacidades tecnológicas ya implementadas, sirviendo como mapa del software actual.

Esta documentación está dirigida a:
- **Equipo de tecnología y soporte:** Para tener una referencia técnica clara de la estructura (componentes, clases, base de datos MySQL) facilitando su mantenimiento y futuros desarrollos.
- **Administradores del sistema:** Para que comprendan todas las capacidades que poseen a nivel de gestión de usuarios, asignación de tareas y generación de reportes.
- **Instructores y Trabajadores:** Para que reconozcan su rol interactivo y las herramientas que poseen para informar fallas y gestionar soluciones respectivamente.

Este documento establece un marco común de comprensión del producto final de software implementado, asegurando en todo momento el valor empresarial aportado.

## 1.3 Alcance

El sistema documentado, **Sistema de Gestión de Reportes de Daños (SIGERD)**, está diseñado fundamental y exclusivamente para centralizar, digitalizar y optimizar todo el proceso reactivo de reporte, asignación y resolución de incidencias físicas, técnicas y de infraestructura dentro de las instalaciones del **Centro de Formación Agroindustrial**.

El sistema le permite a los **Instructores** registrar casos de daño de forma estructurada, adjuntando descripciones y evidencias fotográficas. Los **Administradores** toman control analítico de estos reportes, creando a partir de ellos órdenes de trabajo (Tareas) asignadas al catálogo de **Trabajadores**, de acuerdo con sus perfiles de mantenimiento. Los trabajadores de campo reciben notificaciones sistémicas sobre su carga laboral e interactúan enviando fotografías confirmatorias tras culminar las reparaciones in situ.

El flujo de SIGERD busca reemplazar los procesos verbales o manuales de mantenimiento por un pipeline digital eficiente, que eleva la trazabilidad temporal e histórica de las operaciones físicas de la institución.

**Características Clave del Entorno SIGERD:**
- Interfaz dedicada y segregada por perfiles: **Administrador, Instructor y Trabajador.**
- Creación, seguimiento visual e histórico interactivo de Incidentes y Tareas de Mantenimiento.
- Gestión de evidencias multiformato (Carga y validación de fotografías *Antes* y *Después* inferior a 2MB cada una).
- Lógica de Notificaciones de atención integradas a nivel de aplicación (lectura / no lectura).
- Panel analítico y de control estadístico global.
- Compatibilidad absoluta con navegadores modernos bajo tecnología web responsiva (Laravel 12, TailwindCSS).
- Generación de documentos formales de soporte en PDF.

SIGERD asume operaciones centralizadas, conectividad persistente a la base de datos MySQL y una autenticación basada en credenciales firmes, abarcando una solución moderna completa a los retos del mantenimiento institucional.

## 1.4 Resumen
Este documento detalla los requisitos para desarrollar el Sistema de Gestión de Reportes de Daños (SIGERD). Se organiza en dos secciones principales: **Descripción General**, que abarca el contexto, funcionalidad, roles de usuarios, restricciones, dependencias y evolución futura; y **Requisitos Específicos**, que incluye interfaces corporativas, hardware, software de los servidores, además de requisitos funcionales y no funcionales como rendimiento, seguridad cifrada, fiabilidad, disponibilidad, y portabilidad responsiva. Esta estructura garantiza que el sistema cumpla técnica y lógicamente con los objetivos del centro, optimizando el reporte interactivo, asignación y resolución fotográfica de daños, con un enfoque implacable en la eficiencia y trazabilidad estricta.

# 2 Descripción General

## 2.1 Perspectiva del producto

El **Sistema de Gestión de Reportes de Daños (SIGERD)** es un producto independiente de software alojado, diseñado para operar de manera autónoma dentro del **Centro de Formación Agroindustrial**. Su propósito fundamental y exclusivo es digitalizar la burocracia actual y optimizar los procesos de reporte visual, asignación estructurada y el seguimiento de daños físicos e infraestructurales.

El sistema en su versión `1.0` no depende obligatoriamente de otras plataformas o sistemas externos contables para su funcionamiento transaccional; aunque sí es capaz de integrarse con herramientas de mail y SMTP si se habilita el envío de Notificaciones asíncronas por correo electrónico según las configuraciones del archivo de entorno.  

El diseño monolítico y modular de SIGERD (bajo la filosofía Modelo-Vista-Controlador de Laravel) garantiza una ágil implementación, entregando capacidades inmediatas y diferenciadas para administradores, trabajadores operativos e instructores sin curvas de aprendizaje prolongadas.

## 2.2 Funcionalidad del producto

El Sistema de Gestión de Reportes de Daños incluye las siguientes 5 macro-funcionalidades principales en sus respectivos módulos de código:

1. **Gestión de Reportes de Incidentes (Instructor)**  
   - Permite a los Instructores registrar daños y deficiencias en las instalaciones con detalles formales como título, la ubicación física de la falla y adjuntar material fotográfico de evidencia (fotografías directas del daño menores a 2MB).  
   - Almacena el historial en un listado tabular interactivo donde el remitente puede monitorear qué incidentes fueron leídos y ya se convirtieron o no en tareas.

2. **Asignación de Tareas de Reparación (Administrador)**  
   - Los Administradores pueden recibir los incidentes reportados, revisarlos y convertirlos inteligentemente en tareas directas. Tras esto asignan estas `tasks` a los Trabajadores dados de alta en el sistema, decidiendo variables como la prioridad (Alta/Media/Baja) y la fecha programada o límite.  

3. **Notificaciones y Alertas (Global)**
   - Subsistema de alertas de campanita in-app que informa a los usuarios (mediante modelos interconectados) sobre eventos clave: nuevas tareas asignadas al trabajador, veredictos de evaluación final sobre el trabajo hecho, y avisos de progreso.

4. **Seguimiento y Trazabilidad (Trabajador y Admin)** 
   - El Trabajador debe cambiar obligatoriamente su estatus de tarea a "En Progreso", y al culminar "Realizada" adjuntado forzosamente una prueba fotográfica (*El Trabajo Después*) junto a comentarios resolutivos.  
   - Proporciona estadísticas sobre métricas de la actividad consolidada a nivel global en Dashboards dedicados al administrador.  

5. **Gestión estricta de Usuarios y Roles (Administrador)** 
   - Controla el ecosistema logístico completo mediante *Middlewares* que segregan las rutas HTTP por rol (Administrador, Instructor, Trabajador).
   - Panel de control de personal (`CRUD`) para la creación, edición de passwords, o eliminación de usuarios con un clic.

## 2.3 Restricciones Técnicas y Operativas

En la arquitectura de desarrollo o despliegue del SIGERD, el servidor y el cliente se someten a las siguientes restricciones identificadas:

**1. Restricciones Tecnológicas Base** 
- **Lenguajes de programación e Interfaz:**  
  La construcción lógica del sistema está anclada a las directrices restrictivas del framework Laravel y PHP 8.2 en el backend, enarbolando vistas mediante plantillas `Blade`, con incrustaciones ligeras de JavaScript reactivo (*Alpine.js*) y diseño CSS utilitario puramente dominado por *TailwindCSS*.
- **Base de datos relacional:**  
  El diseño de modelos, tablas puente y campos JSON se rigen por el Motor y dialecto de **MySQL 8.0+** (o MariaDB 10.6+). Restringe la compatibilidad a otros motores no relacionales (Causado por las migraciones nativas de esquema).  
- **Compatibilidad de Navegadores:**  
  Las vistas Blade inyectan grid moderno de Tailwind, obligando a renderizarse sobre las versiones más recientes de Chrome, Safari o Mozilla Firefox. El comportamiento se degradable (no apto para interactuar) en navegadores obsoletos (ej. Internet Explorer).

**2. Restricciones de Hardware / Servidor** 
- **Dispositivos Clientes:**  
  Se garantiza compatibilidad multidispositivo desde PCs hasta SmartPhones, si este tiene capacidad Web (Mínimos técnicos: 2-3GB de RAM en un Smartphone Android/iOS).
- **Servidor / Hosting Web:**  
  El hardware para montar y ejecutar esta aplicación en modo producción en HTTP/S (Apache o Nginx) deberá poseer tecnología de al menos de Memoria (RAM): Mínimo 4 GB, Almacenamiento: SSD, Procesamiento: 2 vCores para aguantar las subidas JSON de evidencias concurrentes y el cálculo al renderizar reportes con *DomPDF*.

**3. Restricciones Operativas en la Institución** 
- **Conectividad:**  
  SIGERD 1.0 no soporta caché *off-line*. Su diseño (Validación Server-Side y redireccionamientos seguros de sesión) obliga a poseer conexión internet constante al servidor a la hora de publicar tareas y reportar los daños.
- **Alfabetización Tecnológica:**  
  La interfaz fue construida con diseño intuitivo usando iconos neutros de material UI Google; sin embargo, en usuarios altamente alejados de perfiles web se requiere adiestramiento inicial.

## 2.4 Suposiciones y Dependencias

**Suposiciones Directas:**
- **Acceso Físico a Cámara:** Se asume firmemente que los recursos humanos que ejercen como Trabajadores o Instructores tendrán al momento del hallazgo dispositivo Smartphone que captan una lente y navegador, lo cual es requisito crítico e indivisible de la validación fotográfica (*initial* o *final_evidence*).
- **Competencias Técnicas:** Los administradores que otorgan permisos de la escuela sabrán cómo y cuándo crearle una cuenta de Instructor a los profesores vs Trabajador a mantenimiento (y asignarle una "Identidad Visual" coherente e individual).
- **Motor PHP/MySQL Oficial:** Se rige por el hecho de que Laravel continuará dando soporte LTS a versiones 11 y actualizando dependencias de *Composer* contra parches de vulnerabilidades.
- **Soporte Institucional:** La empresa asumirá responsabilidades de crear backup rutinario (dumps) de la base de datos para prever desastres donde se eliminen tareas terminadas de manera inadvertida.

**Dependencias Críticas:**
- **Archivos Estáticos Public y Vite:** Los estilos HTML se ven afectados inmediatamente si por comandos de Terminal no se corrió preventivamente el agrupador de front build `npm run build`; Dependencia intrínseca.
- **Almacenamiento Simbólico Mapeado:** Todo el flujo y ciclo de vida visual de evidencias (Las fotos de antes y las de después del arreglo), dependen de que el binario de PHP tenga acceso y permiso (vía `storage:link`) a escribir en el servidor de archivos internos.
- **Legislación Nacional sobre Datos Personales:** La política oficial puede impactar cómo el administrador recaba directamente "nombres" completos, fotografías de perfil personal del personal al interior del software y las almacena de forma digital, atada a la política de tratamiento local de la escuela (GDPR, Habeas Data).

## 2.5 Evolución Previsible del Sistema

SIGERD está esculpido sistemáticamente como aplicación modular sobre arquitectura MVC. Esto abre un mundo de oportunidades para adaptarlo y vitaminarlo de lógicas más fuertes a medida que mejore su presupuesto anual y la usabilidad de su institución:

1. **Módulo de Mantenimiento Preventivo Global**  
   Podemos mutar la lógica de ser solo un sistema de reacción ante incidentes ocurridos, hacia una app preventiva, configurando un *Cron Job* o *Scheduler* mensual en Laravel que origine tareas forzosas de limpieza general/Mantenimiento en lotes fijos sin necesidad explícita del reporte de un instructor.

2. **Gestor de Inventario con Kilos y Referencias Contables**  
   Aunque originalmente contemplado en modelos base de otra arquitectura (Agrosac), aquí en la versión actual de soporte se podría implementar a futuro Tablas Puente (`Movement Models`). Reemplaza pedir a viva voz "Cómprame tubos PVC para aplicar una tarea", a que un trabajador pueda *Descontar en tiempo real* objetos de una tabla Inventario al finalizar un ticket, restando el Stop Contable.

3. **Arquitectura API Rest y Apps Móviles (PWA / Flutter Native)**  
   Ya que Laravel soporta Sanstum nativamente para la emisión de Tokens; no se encuentra muy distante que se solicite migrar estas lógicas transaccionales hacia apis (`api.php`), en caso de que en futuras decisiones financieras decidan compilar y repartir .APKs nativas a los trabajadores para un comportamiento totalmente off-line y con acceso a Bluetooth/NFC de la dependencia antes que llegue el WiFi.

4. **Automatización Robótica de Asignaciones AI**  
   Bajar la carga del *Administrador*, entrenando o haciendo *pipelines* de algoritmos predictivos (Basados en tags o especialidades creadas al modelo Usuario). Por inducción lógica un algorimo evalúa las descripciones de las incidencias del colegio y le distribuye inteligentemente a fontaneros, lo eléctrico, etc sin la intermediación humana del Admin.

---

# 4 Apéndices

## Apéndice A: Glosario de Términos
- **Usuario:** Persona que interactúa con el sistema autenticándose bajo un rol formal (Administrador, Trabajador o Instructor).
- **Reportes de Daños (Incidentes):** Registros inmutables creados por los Instructores para notificar incidencias, fallas técnicas o daños en las instalaciones o equipos del C.F.A.
- **CRUD (Create, Read, Update, Delete):** Las cuatro funciones elementales de almacenamiento persistente en el entorno de bases de datos relacionales, manejadas por los Controladores.
- **ORM (Object-Relational Mapping):** Técnica de programación (en este caso, *Eloquent* de Laravel) usada para convertir datos entre el sistema de tipos incompatibles y la base de datos orientada a objetos.
- **Frontend (Blade/Alpine/Tailwind):** Interfaz pública con la que interactúan los usuarios finales, renderizada desde el servidor corporativo para visualizar y manipular los datos del sistema.
- **Backend (Laravel/PHP):** El núcleo de procesamiento, validaciones, enrutamiento web y gestión de la base de datos relacional.
- **Token CSRF:** Medida de seguridad obligatoria inyectada en todos los formularios Blade para prevenir ataques de falsificación de peticiones entre sitios.

## Apéndice B: Diagrama de Arquitectura del Sistema
A nivel macro, el diagrama básico de la arquitectura del sistema sigue el robusto estándar MVC (Modelo-Vista-Controlador) y expone la siguiente interacción trilateral:
- **Bloque Frontend (Vistas):** Motor de plantillas Blade inyectando directivas reactivas de Alpine.js y diseño de TailwindCSS.
- **Bloque Backend (Controladores y Modelos):** Lógica del negocio dictaminada por clases de PHP 8.2+ orquestadas por Laravel 12, atendiendo peticiones Web, subidas de fotografías y autorizaciones de Middlewares.
- **Bases de Datos (Almacenamiento):** Servidor MySQL 8.0 donde residen las tablas estructuradas conectadas vía capa PDO.
- **Componentes extra:** Sistema de archivos local (`Local Storage`) acoplado para albergar persistentemente las fotografías JPEG/PNG. 

## Apéndice C: Diagramas de Casos de Uso
En este apéndice se referencian lógicamente las acciones de los roles definidos en el sistema (cuyos diagramas UML en PlantUML reposan en anexos independientes):
- **Administrador:** Gestionar usuarios (Alta/Baja), priorizar reportes de daños, asignar tareas, evaluar trabajos terminados (Aprobar/Rechazar), y exportar reportes PDF.
- **Trabajador:** Consultar de tablero interactivo las tareas físicas asignadas en su área, aceptar y ejecutar labor ("En Progreso"), enviar evidencias fotográficas formales para su revisión inminente.
- **Instructor:** Descubrir fallas, documentar problemas levantando un Incidente con descripciones, y ubicar espacialmente dentro de la institución el objeto a intervenir.

## Apéndice D: Requisitos Técnicos del Sistema
Este apéndice describe los requisitos operativos y físicos (Hardware y Software) exigidos para el despliegue del sistema SIGERD.
- **Requisitos de hardware para Host:**
  - Procesador: 2 vCores a 2.0 GHz o superior.
  - Memoria RAM: 4 GB mínimo recomendado (Por el consumo de DomPDF y manipulación de imágenes multipart).
  - Espacio de Disco SSD: Mínimo 20 GB libres (reservando expansión masiva por peso histórico de las fotografías).
- **Requisitos de software base:**
  - Servidor web: Módulo Nginx o Apache emparejado a PHP-FPM.
  - Lenguaje Servidor: PHP 8.2+ con extensiones GD, PDO, JSON.
  - Base de Datos: MySQL 8.0+ / MariaDB 10.6+ con soporte `utf8mb4`.
  - Sistema operativo: GNU/Linux (Ubuntu/Debian) recomendado nativamente para entorno en Producción. 

## Apéndice E: Plan de Pruebas
Garantiza el estándar de seguridad y fiabilidad antes del despliegue:
- **Pruebas Frontend e Integración Continua (E2E):** Uso iterativo de scripts en *Puppeteer* o utilidades equivalentes para automatizar y cronometrar las respuestas del Trabajador ante las notificaciones Push.
- **Pruebas de Componentes Lógicos:** Validaciones estáticas de modelos de Eloquent como la segregación obligatoria de fotos ligeras (Max 2MB) filtradas nativamente por los *FormRequests* de Laravel.
- **Auditorías de Seguridad Criptográfica:** Sanitización interna del core contra inyección SQL directa por medio de consultas pre-preparadas del ORM, y ataques XSS (vía escapado natural del motor de plantillas Blade de tipo `{{ }}`).

## Apéndice F: Fuentes y Referencias Técnicas
Documentación externa utilizada orgánicamente para establecer la topología de la SRS, los diagramas subyacentes y el ciclo del producto:
- **Norma IEEE 830-1998:** Práctica recomendada por la IEEE para configurar especificaciones limpias en requerimientos de software.
- **Documentación Oficial de Laravel (v11.x):** Estándares de seguridad corporativa, ruteo y diseño de DB para el desarrollo en PHP.
- **Estándares PSR-12 (PHP-FIG):** Guía universal de estilos para la escritura extendida de código limpio en lenguaje PHP.
- **Convenciones W3C:** Buenas prácticas formales de accesibilidad y etiquetado sintáctico de interfaces web DOM.
