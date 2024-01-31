# Manual técnico del sistema de información web UniGym

> [!WARNING]  
> Si usted es un usuario final del sistema, consulte el [manual de usuario](user.md).


## Tabla de contenidos
- [Capítulo 1: Introducción](#introducción.) **(Presenta el propósito, el alcance, los objetivos y la organización)**
- [Capítulo 2: Arquitectura](#arquitectura.) **(Explica la arquitectura del sistema, los patrones de diseño aplicados, los diagramas de clases, de secuencia, de componentes y de despliegue, y la distribución de las capas y los módulos)**
- [Capítulo 3: Tecnologías](#tecnologías.) **(Describe las tecnologías utilizadas para el desarrollo e implementación del sistema, tales como los lenguajes de programación, los frameworks, las librerías, las herramientas, las bases de datos y los servidores)**
- [Capítulo 4: Instalación](#instalación.) **(Indica los pasos para instalar el sistema en un servidor local o en la nube)**
- [Capítulo 5: Configuración](#configuración.) **(Explica los pasos para configurar el sistema, tales como la conexión a la base de datos, el acceso a los recursos y la configuración de los parámetros)**
- [Capítulo 6: Despliegue](#funcionalidades.) **(Describe las funcionalidades del sistema, los flujos de ejecución, las pantallas, los formularios, los reportes y las validaciones)**
- [Capítulo 7: Funcionalidades](#funcionalidades.) **(Describe las funcionalidades del sistema, los flujos de ejecución, las pantallas, los formularios, los reportes y las validaciones)**

> [!NOTE]
> El sistema cumple con los estándares de calidad, seguridad y accesibilidad establecidos por la Universidad Nacional
> de Colombia y por la normativa vigente.

> [!IMPORTANT]
> El sistema se encuentra alojado en un servidor web, y se puede acceder a él desde cualquier dispositivo con
> conexión a internet y un navegador compatible.

> [!TIP]
> El sistema es escalable, y se puede adaptar a las necesidades de otros centros de acondicionamiento y preparación
> física. Además, se puede integrar con otros sistemas de información de la Universidad Nacional de Colombia.

{collapsible="true" default-state="collapsed"}

# Introducción

El presente documento describe el diseño, desarrollo e implementación del sistema de información web
“UniGym” que permite la gestión del centro de acondicionamiento y preparación física CAPF de la Universidad Nacional de
Colombia - sede Manizales.

El objetivo de este sistema es facilitar la gestión de los servicios que ofrece el gimnasio, tales como el control de
usuarios, pagos, asistencias, test o evaluaciones físicas, entre otros. El manual está dirigido a los desarrolladores,
administradores y mantenedores del sistema, y contiene información detallada sobre los requisitos, las tecnologías
utilizadas, la arquitectura, los componentes, las funcionalidades, las pruebas y la documentación del código.

> [!NOTE]
> Este manual técnico se ha revisado para corregir errores ortográficos, gramaticales o de formato. Sin embargo, se agradece cualquier feedback para mejorar la claridad, la precisión y la utilidad del manual.

> [!IMPORTANT]
> Este manual técnico no sustituye a la formación o experiencia profesional en PHP, SQL, JavaScript, NPM y Composer. Los usuarios deben tener un conocimiento básico de estos lenguajes y herramientas para utilizar este manual de manera efectiva.

# Arquitectura

En este capítulo se explica la estructura, el diseño y el funcionamiento del sistema de información web que permite la
administración del gimnasio de la Universidad Nacional de Colombia en la sede Manizales. Se describen los patrones de
diseño aplicados, los diagramas que representan la arquitectura, la distribución de las capas y los módulos que componen
el sistema, y las tecnologías utilizadas para el desarrollo e implementación del sistema.

## Tipo de arquitectura

El sistema de información web “UniGym” se basa en una arquitectura de tres capas que utiliza el patrón de diseño
modelo-vista-controlador (MVC). Esta arquitectura se compone de una capa de presentación, una capa de negocio y una capa
de datos.

- La capa de presentación, implementada con HTML, CSS y JavaScript, se encarga de mostrar la interfaz gráfica del
  sistema y actúa como la “vista” en el patrón MVC. Esta capa se encarga de la presentación de la interfaz de usuario.
- La capa de negocio, implementada con PHP, se encarga de procesar las peticiones del usuario y de comunicarse con la
  capa de datos. Esta capa actúa como el “controlador” en el patrón MVC, manejando la comunicación entre el modelo y la
  vista.
- La capa de datos, implementada con MySQL, se encarga de almacenar la información del sistema y actúa como el “modelo”
  en el patrón MVC. Esta capa se encarga de la interacción con la base de datos.

> [!NOTE]
> Este tipo de arquitectura facilita la modularidad, la reusabilidad y el mantenimiento del código, al separar la lógica
> de la aplicación en tres componentes principales.

## Patrones de diseño

El sistema utiliza el framework Laravel, que es un framework de PHP que sigue el patrón MVC y ofrece varias
funcionalidades y herramientas para el desarrollo e implementación de aplicaciones web. Además, el sistema utiliza las
librerías AlpineJS y el framework Livewire, que permiten añadir comportamiento dinámico y reactivo a la vista.
AlpineJS se integra bien con Laravel y Livewire, y ofrece una sintaxis similar a VueJS. Livewire se basa en el concepto
de "HTML sobre el cable", que significa que envía y recibe HTML en lugar de datos JSON. Livewire facilita la
sincronización de datos entre el modelo y la vista, y ofrece varias funcionalidades como validación, paginación,
carga de archivos, etc

Asimismo, el sistema utiliza el framework Tailwind CSS, que es un framework de CSS que ofrece clases de utilidad para
crear diseños personalizados sin estilos predefinidos. Tailwind CSS se integra con Laravel, AlpineJS y Livewire, y
permite crear interfaces de usuario modernas y flexibles. Tailwind CSS se basa en el patrón utility-first, que consiste
en usar clases atómicas que representan propiedades de CSS, como color, tamaño, margen, posición, etc. De esta forma,
se puede crear cualquier diseño directamente en el HTML, sin tener que escribir hojas de estilo separadas

# Tecnologías

En este capítulo se describen las tecnologías utilizadas para el desarrollo e implementación del sistema de información

## Lenguajes de programación

El sistema de información web “UniGym” se desarrolló principalmente con PHP, que es un lenguaje de programación de
propósito general de código abierto que se utiliza para el desarrollo de aplicaciones web. PHP se basa en el paradigma
de programación orientada a objetos (POO), y se puede integrar con HTML, CSS y JavaScript. Además, el sistema utiliza
JavaScript, que es un lenguaje de programación interpretado que se utiliza principalmente para crear páginas web
dinámicas. JavaScript se basa en el paradigma de programación orientada a objetos (POO), y se puede integrar con HTML y
CSS.

## Frameworks

- Laravel

  El sistema de información web “UniGym” se desarrolló principalmente con Laravel, que es un framework de PHP que
  sigue el patrón MVC y ofrece varias funcionalidades y herramientas para el desarrollo e implementación de
  aplicaciones web.
- Tailwind CSS

  El sistema de información web “UniGym” utiliza Tailwind CSS, que es un framework de CSS que ofrece clases de
  utilidad para crear diseños personalizados sin estilos predefinidos. Tailwind CSS se integra con Laravel,
  AlpineJS y Livewire, y permite crear interfaces de usuario modernas y flexibles. Tailwind CSS se basa en el
  patrón utility-first, que consiste en usar clases atómicas que representan propiedades de CSS, como color,
  tamaño, margen, posición, etc. De esta forma, se puede crear cualquier diseño directamente en el HTML, sin tener
  que escribir hojas de estilo separadas.
- AlpineJS

  El sistema de información web “UniGym” utiliza AlpineJS, que es una librería de JavaScript que permite añadir
  comportamiento dinámico y reactivo a la vista. AlpineJS se integra bien con Laravel y Livewire, y ofrece una
  sintaxis similar a VueJS.

- Livewire

  El sistema de información web “UniGym” utiliza Livewire, que es un framework de PHP que permite añadir
  comportamiento dinámico y reactivo a la vista. Livewire se basa en el concepto de "HTML sobre el cable", que
  significa que envía y recibe HTML en lugar de datos JSON. Livewire facilita la sincronización de datos entre el
  modelo y la vista, y ofrece varias funcionalidades como validación, paginación, carga de archivos, etc.


## Herramientas

El sistema de información web “UniGym” utiliza varias herramientas para el desarrollo e implementación del sistema, como
Git, Composer, NPM, PHP, MySQL, Apache, etc. Git es un sistema de control de versiones distribuido de código abierto
que se utiliza para el desarrollo de aplicaciones web. Git se basa en el paradigma de programación orientada a objetos
(POO), y se puede integrar con HTML, CSS y JavaScript. Composer es un gestor de dependencias de PHP que se utiliza para
el desarrollo de aplicaciones web. Composer se basa en el paradigma de programación orientada a objetos (POO), y se
puede integrar con HTML, CSS y JavaScript. NPM es un gestor de paquetes de JavaScript que se utiliza para el desarrollo
de aplicaciones web. NPM se basa en el paradigma de programación orientada a objetos (POO), y se puede integrar con
HTML, CSS y JavaScript. PHP es un lenguaje de programación de propósito general de código abierto que se utiliza para
el desarrollo de aplicaciones web. PHP se basa en el paradigma de programación orientada a objetos (POO), y se puede
integrar con HTML, CSS y JavaScript. MySQL es un sistema de gestión de bases de datos relacionales de código abierto que
se utiliza para el desarrollo de aplicaciones web. MySQL se basa en el paradigma de programación orientada a objetos
(POO), y se puede integrar con HTML, CSS y JavaScript. Apache es un servidor web de código abierto que se utiliza para
el desarrollo de aplicaciones web. Apache se basa en el paradigma de programación orientada a objetos (POO), y se puede
integrar con HTML, CSS y JavaScript. XAMPP es un paquete de software libre que se utiliza para el desarrollo de
aplicaciones web. XAMPP se basa en el paradigma de programación orientada a objetos (POO), y se puede integrar con
HTML, CSS y JavaScript. VS Code es un editor de código de código abierto que se utiliza para el desarrollo de
aplicaciones web. VS Code se basa en el paradigma de programación orientada a objetos (POO), y se puede integrar con

## Bases de datos

El sistema de información web “UniGym” utiliza MySQL como sistema de gestión de bases de datos relacionales. MySQL es un
sistema de gestión de bases de datos relacionales de código abierto que se utiliza para el desarrollo de aplicaciones
web. MySQL se basa en el paradigma de programación orientada a objetos (POO), y se puede integrar con HTML, CSS y
JavaScript.

## Servidores

El sistema de información web “UniGym” utiliza Apache como servidor web. Apache es un servidor web de código abierto que
se utiliza para el desarrollo de aplicaciones web. Apache se basa en el paradigma de programación orientada a objetos
(POO), y se puede integrar con HTML, CSS y JavaScript.

# Instalación

En este capítulo se describen los pasos para instalar el sistema de información web “UniGym” en un servidor local o en
la nube.

## Requisitos

El sistema de información web “UniGym” se desarrolló principalmente con PHP, que es un lenguaje de programación de
propósito general de código abierto que se utiliza para el desarrollo de aplicaciones web. PHP se basa en el paradigma
de programación orientada a objetos (POO), y se puede integrar con HTML, CSS y JavaScript. Además, el sistema utiliza
JavaScript, que es un lenguaje de programación interpretado que se utiliza principalmente para crear páginas web
dinámicas. JavaScript se basa en el paradigma de programación orientada a objetos (POO), y se puede integrar con HTML y
CSS.

## Pasos

1. Descargar el sistema de información web “UniGym” del repositorio de GitHub.
2. Instalar las dependencias del sistema con Composer.
3. Instalar las dependencias del sistema con NPM.
4. Configurar el sistema.
5. Crear la base de datos del sistema.
6. Ejecutar las migraciones del sistema.
7. Ejecutar los seeders del sistema.

# Configuración

En este capítulo se describen los pasos para configurar el sistema de información web “UniGym” en un servidor local o en
la nube.