<a name="inicio"></a>
# PROYECTO SYMFONY

Proyecto prueba de Symfony 3.

## Indice

1. [Clonar el proyecto](#clonar)
2. [Generar base de datos](#baseDatos)
3. [Modificar parameters.yml](#parameters)
4. [Arracar el servicio de Symfony](#run)
5. [Ir a la ruta del proyecto](#ruta)

## Pasos a seguir

<a name="clonar"></a>
### Clonar el proyecto

 * Clona el repositorio [https://github.com/ElisaSb/BlogSymfony.git][1] e instala los archivos necesarios.
    
       $ git clone https://github.com/ElisaSb/BlogSymfony.git
       $ cd BlogSymfony
       $ composer install

<a name="baseDatos"></a>
### Generar la base de datos   
 
   * Inicia sesión en mysql con un usuario con permisos (para crear tablas y base de datos).
   * Carga el archivo de la carpeta raíz del proyecto llamado database.sql
    
         $ source /rutaDelArchivo/database.sql

<a name="parameters"></a>
### Modificar parameters.yml
           
 * Modifica el archivo parameters.yml de la ruta BlogSymfony/app/config/parameters.yml
 
       parameters:
            database_host: 127.0.0.1
            database_port: null
            database_name: blog
            database_user: tu_usuario
            database_password: contraseña_usuario
      
<a name="run"></a>
### Arrancar el servicio de Symfony
  
    $ php bin/console server:run
        
<a name="ruta"></a>
### Ir a la ruta del proyecto

  * Las rutas del proyecto son:
    * [http://127.0.0.1:8000][2]
    * *En español*: [http://127.0.0.1:8000/es][3]
    * *En inglés*: [http://127.0.0.1:8000/en][4] ( *solo la interfaz del raíz* )

Ya tenemos corriendo la aplicación web de prueba.

[<sub>Volver al inicio</sub>](#inicio)

[1]:  https://github.com/ElisaSb/BlogSymfony.git
[2]:  http://127.0.0.1:8000
[3]:  http://127.0.0.1:8000/es
[4]:  http://127.0.0.1:8000/en