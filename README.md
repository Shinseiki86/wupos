# Eva360

Debido a que el proyecto se basa en la construcción de sistema para encuestas, es fundamental definir sus partes y características.

#5.1	ENCUESTA
Una encuesta es un procedimiento cuyo objetivo es recolectar datos por medio de cuestionarios. Los datos se obtienen mediante un conjunto de preguntas dirigidas a un grupo en particular (personas, empresas o entes institucionales), con el fin de conocer estados de opinión, ideas, características o hechos específicos. Con ellas se logra conocer la satisfacción de los clientes, estudiar un mercado o hasta el clima laboral de una empresa. [3]

#5.2	PREGUNTAS
Son enunciados interrogativos que se emite con la intención de conocer algo u obtener alguna información.

Las preguntas que conforman a la encuesta se clasifican según la respuesta que se espera recolectar. El tipo de pregunta utilizado en la encuesta infiere mucho en los datos que serán recolectados. Por ello, es necesario conocer los objetivos de la encuesta y la información que se desea obtener, ya que ayudará a decidir el tipo de pregunta adecuado.

Figura 1. Tipos de pregunta.
![Figura 1. Tipos de pregunta.jpg](https://bitbucket.org/repo/ngEy7bA/images/889262410-Figura%201.%20Tipos%20de%20pregunta.jpg)
Fuente: http://www.e-encuesta.com/blog/2015/tipos-de-pregunta-en-la-encuesta 

En el proyecto se implementarán los siguientes tipos de pregunta:

5.2.1	Preguntas Abiertas
La respuesta obtenida consta de una redacción propia del encuestado, permitiendo total libertad en la respuesta. Su deficiencia radica en que los datos recolectados nos son fáciles de analizar y conlleva una inversión en tiempo y trabajo, siendo necesario analizar cada respuesta de forma individual.

5.2.2	Preguntas Cerradas
Para responder, el encuestado debe elegir opciones entre las establecidas por el encuestador. Son más fáciles de analizar y requieren menos tiempo y esfuerzo al contestar. Al plantearlas es necesario abarcar todas las posibles respuestas, ya que su defecto es que limitan las respuestas de los encuestados.

5.2.2.1	Elección Única
Sólo puede ser elegida una opción de entre las opciones planteadas en la pregunta. Las opciones son excluyentes entre sí.
Pueden ser:
* Dicotómicas: Se responden con un Sí o con un No.
* Politómicas: Presentan varias opciones para que el encuestado elija.

5.2.2.2	Elección múltiple
A diferencia de las preguntas de elección única, permite seleccionar varias opciones de respuesta simultáneamente. Se utiliza cuando las opciones de respuesta no son excluyentes entre sí.

5.2.2.3	Escala numérica
Se utiliza para evaluar el grado de intensidad o sentimiento de una característica o variable que se está midiendo. Se debe tener en cuenta que una escala excesivamente larga puede llegar a confundir al encuestado y puede requerir que la población encuestada sea más grande para poder realizar análisis estadísticos. En el proyecto, las preguntas de escala van desde 1 hasta 5 (donde 1 es la menor expresión y 5 la máxima).


#6.	DESARROLLO DEL PROYECTO

#6.1	METODOLOGÍA
La metodología del proyecto esta enfatizada al modelo RUP, este es un proceso de ingeniería de software, que hace una propuesta orientada por disciplinas para lograr las tareas, responsabilidades y objetivos en el desarrollo e implementación de software. Su meta principal es asegurar la producción de software de alta calidad que cumpla con las necesidades de los usuarios.

Las fases del proyecto se han clasificado en:

•	Análisis.
•	Revisión de análisis y análisis de requerimientos.
•	Elaboración del modelo de datos.
•	Revisión de la base de datos.
•	Elaboración de prototipos de software.
•	Evaluación y revisión del prototipo de software.
•	Levantamiento de requerimiento.
•	Refinamiento de requerimientos.
•	Diseño de interfaces graficas de usuario.
•	Revisión de diseño de interfaces graficas de usuario.
•	Integración de la capa de almacenamiento con la GUI.
•	Pruebas de funcionamiento.
•	Corrección de fallas y errores evidenciados en la fase de pruebas.
•	Pruebas secundarias de funcionamiento.
•	Implementación del sistema y pruebas.

Para el control de versiones y repositorio se utilizó la plataforma Bitbucket. La última versión estable es la v4.1.3.

https://Shinseiki86@bitbucket.org/Shinseiki86/eva360.git


#6.2	ARQUITECTURA

#6.2.1	Laravel 5.2

El proyecto está creado con Laravel 5.2 [10] [11], el cual es un framework que brinda soporte para MVC (Modelo Vista Controlador), pero propone en el desarrollo usar “Routes with Closures”. 
El patrón MVC (Model View Controller) fue creado por Trygve Reenskaug a finales de los 70 para su posterior implementación en Smalltalk-80 , el cual plantea obtener información de la vista, las acciones capturadas procesarlas por un controlador y los datos obtenidos guardarlos en la base de datos mediante un modelo.

Al desarrollar una aplicación web generalmente necesitamos otras capas que no provee el patrón MVC:
* Representar las rutas que se encargan de analizar las URLs y asignarlas a un método o función.
* Proteger las rutas de accesos no autorizados.
* La representación de datos a través de un modelo requiere mucho más lógica que almacenar datos.

Laravel está escrito en PHP y diseñado con la filosofía de la convención de la configuración. Propone el uso de rutas y middleware, lo cual se representa en la siguiente gráfica:

Figura 2. Arquitectura proyecto
![Figura 2. Arquitectura proyecto.png](https://bitbucket.org/repo/ngEy7bA/images/1840781341-Figura%202.%20Arquitectura%20proyecto.png)
Fuente: Diseño propio

Esto nos permite obtener una serie de ventajas, entre las cuales destacan las siguientes:

* Reducción de costos y tiempos en el desarrollo y mantenimiento.
* Curva de aprendizaje relativamente baja en comparación con otros framework PHP. Para el desarrollo del proyecto, se dedicaron 4 semanas de capacitación desde la página https://styde.net/.
* Excelente documentación del framework, sobre todo en el sitio oficial , y cuenta con una amplia comunidad y foros.
* Es modular y con un amplio sistema de paquetes y componentes con los cuales se puede extender la funcionalidad de forma fácil, robusta y segura.
* Permite que el manejo de los datos no sea complejo. Mediante Eloquent (un ORM basado en el patrón active record) la interacción con las bases de datos es totalmente orientada a objetos, siendo compatible  con MySql, Postgress, SQLite y SQL Server. Esto facilita la migración de nuestros datos de una forma fácil y segura. Otro punto es que permite la creación de consultas robustas y complejas.
* Facilita el manejo de ruteo de nuestra aplicación, la generación de url amigables y control de enlaces auto–actualizables lo cual hace más fácil el mantenimiento de un sitio web.
* El sistema de plantillas Blade de Laravel, trae consigo la generación de mejoras en la parte de presentación de la aplicación como la generación de plantillas más simples y limpias en el código y además incluye un sistema de cache que las hace más rápidas, lo que mejora el rendimiento de la aplicación.
* Cuenta con una herramienta de interfaces de líneas de comando llamada Artisan. Permite realizar tareas programadas como por ejemplo mantenimientos, migraciones, pruebas programadas, etc.

El proyecto está organizado en una estructura de carpetas, el cual se describe en la figura 3.

Figura 3. Estructura carpetas proyecto
![Figura 3. Estructura carpetas proyecto.png](https://bitbucket.org/repo/ngEy7bA/images/1837432049-Figura%203.%20Estructura%20carpetas%20proyecto.png)
Fuente: Diseño propio

# Librerías Front-End

Para la construcción de las páginas web presentadas al usuario, se utilizó el componente Blade de Laravel, apoyándose en varias librerías de JavaScript. En el anexo 3 se mencionan todas las librerías utilizadas y su respectiva licencia.

11.3	ANEXO 3: LIBRERÍAS FRONT-END

### Bootstrap v3.3.7 ###
Framework CSS creado por Twitter utilizado para el desarrollo de sitios web soportando diseños sensibles, ajustando dinámicamente la página tomando en cuenta las características del dispositivo usado (Computadoras, tabletas, teléfonos móviles). Esta técnica de diseño es conocida como “Responsive Design”.
Página:	http://getbootstrap.com
Licencia: 	MIT

### Font Awesome v4.7 ###
Conjunto de 634 iconos pictográficos para gráficos vectoriales escalables.
Página:	https://github.com/FortAwesome/Font-Awesome
Licencia:	CC BY 3.0, SIL OFL 1.1 y MIT http://fontawesome.io/license

### Chart.js v2.4.0 ###
Librería JavaScript para generar gráficos estadísticos.
Página:	http://chartjs.org
Licencia:	MIT 

### jQuery v1.11.2 ###
Librería de JavaScript que permite simplificar la manera de interactuar con los documentos HTML, manipular el árbol DOM, manejar eventos, desarrollar animaciones y agregar interacción con la técnica AJAX a páginas web.
Página:	https://jquery.org 
Licencia:	GPL y MIT jquery.org/license 

### The Final Countdown for jQuery v2.2.0 ###
Librería para mostrar un contador de tiempo.
Página:	http://hilios.github.io/jQuery.countdown/
Licencia:	MIT

### jQuery Validation Plugin v1.15.0 ###
Librería JavaScript para validar formularios.
Página:	http://jqueryvalidation.org
Licencia:	MIT

### Moment.js v2.17.1 ###
Librería JavaScript para analizar, validar, manipular y mostrar fechas.
Página:	http://momentjs.com
Licencia:	MIT

### AngularJS v1.5.8 ###
Framework de JavaScript de código abierto, mantenido por Google.
Página:	http://angularjs.org
Licencia: 	MIT

### UI Bootstrap v2.3.1 ### 
Librería de Angular para Bootstrap.
Página:	http://angular-ui.github.io
Licencia: 	MIT

### dirPagination 2014 ###
Directiva para AngularJS utilizada para crear paginación de resultados.
Página:          github.com/michaelbromley/angularUtils/tree/master/src/directives/pagination
Licencia:	MIT 

### Bootstrap 3 Date/Time Picker v4.17.43 ###
Librería JavaScript para el manejo de campos de fecha y hora.
Página: 	https://github.com/Eonasdan/bootstrap-datetimepicker
Licencia	MIT

### Bootstrap Multiselect v2.0 ### 
Librería JavaScript para el manejo de campos de listas.
Página:	https://github.com/davidstutz/bootstrap-multiselect
Licencia	MIT

### Pace 1.0.0 ###
Librería JavaScript para generar un indicador de progreso en la carga de la página.
Página:	https://github.com/HubSpot/pace/
Licencia:	MIT

### html2canvas v0.4.1 ###
Librería JavaScript que permite tomar capturas de pantalla de páginas web del lado cliente. Se utiliza con jsPDF para guardar los gráficos generados por Chart.js en un PDF.
Página:	http://html2canvas.hertzen.com
Licencia:	MIT

### jsPDF v 1.3.2 ###
Librería JavaScript para generar archivos PDF en JavaScript del lado cliente.
Página:	https://github.com/MrRio/jsPDF
Licencia:	MIT

### Sortable ###
Librería JavaScript para generar listas ordenables mediante arrastrar y soltar (drag and drop).
Página:	https://github.com/RubaXa/Sortable
Licencia:	MIT