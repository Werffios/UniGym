# Manual técnico del aplicativo web UniGym

> [!WARNING]  
> Si usted es un usuario final del sistema, consulte el [manual de usuario](user.md).

## Tabla de contenidos

- [Introducción](#1-introducción)
- [Arquitectura](#2-arquitectura)
- [Tecnologías](#3-tecnologías)
- [Instalación](#4-instalación)
- [Configuración](#5-configuración)
- [Despliegue](#6-despliegue)
- [Pruebas](#7-pruebas)
- [Referencias](#8-referencias)
- [Anexos](#9-anexos)
- [Glosario](#10-glosario)
- [Acrónimos](#11-acrónimos)
- [Versiones](#12-versiones)
- [Autores](#13-autores)
- [Licencia](#14-licencia)
- [Agradecimientos](#15-agradecimientos)

## 1. Introducción

El presente documento describe el diseño, desarrollo e implementación del sistema de información web 
“UniGym” que permite la gestión del centro de acondicionamiento y preparación física CAPF de la Universidad Nacional de 
Colombia - sede Manizales.

El objetivo de este sistema es facilitar la gestión de los servicios que ofrece el gimnasio, tales como el control de 
usuarios, pagos, asistencias, test o evaluaciones físicas, entre otros. El manual está dirigido a los desarrolladores, 
administradores y mantenedores del sistema, y contiene información detallada sobre los requisitos, las tecnologías 
utilizadas, la arquitectura, los componentes, las funcionalidades, las pruebas y la documentación del código. 

> [!NOTE]
> El sistema cumple con los estándares de calidad, seguridad y accesibilidad establecidos por la Universidad Nacional 
> de Colombia y por la normativa vigente.

> [!IMPORTANT]
> El sistema se encuentra alojado en un servidor web, y se puede acceder a él desde cualquier dispositivo con 
> conexión a internet y un navegador compatible.

> [!TIP]
> El sistema es escalable, y se puede adaptar a las necesidades de otros centros de acondicionamiento y preparación
> física. Además, se puede integrar con otros sistemas de información de la Universidad Nacional de Colombia.

Capítulo 1: Introducción. Presenta el propósito, el alcance, los objetivos y la organización del manual técnico.
Capítulo 2: Requisitos. Especifica los requisitos funcionales y no funcionales del sistema, así como los casos de uso y los actores involucrados.
Capítulo 3: Tecnologías. Describe las tecnologías utilizadas para el desarrollo e implementación del sistema, tales como los lenguajes de programación, los frameworks, las librerías, las herramientas, las bases de datos y los servidores.
Capítulo 4: Arquitectura. Explica la arquitectura del sistema, los patrones de diseño aplicados, los diagramas de clases, de secuencia, de componentes y de despliegue, y la distribución de las capas y los módulos.
Capítulo 5: Componentes. Detalla los componentes del sistema, sus responsabilidades, sus interfaces, sus dependencias y sus interacciones.
Capítulo 6: Funcionalidades. Describe las funcionalidades del sistema, los flujos de ejecución, las pantallas, los formularios, los reportes y las validaciones.
Capítulo 7: Pruebas. Muestra los tipos de pruebas realizadas al sistema, los criterios de aceptación, los escenarios, los resultados y las incidencias.
Capítulo 8: Documentación. Indica la forma de documentar el código, los estándares de codificación, los comentarios, las etiquetas y la generación automática de documentación.
Capítulo 9: Conclusiones. Resume los logros, las dificultades, las lecciones aprendidas y las recomendaciones del proyecto.
Anexos. Incluye información complementaria, como el glosario de términos, las referencias bibliográficas, los manuales de instalación y configuración, y los códigos fuente.

