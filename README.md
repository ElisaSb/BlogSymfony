PROYECTO SYMFONY
========================

Proyecto Blog de Symfony 3 de prueba.

Pasos a seguir
--------------

 * Clona el proyecto [https://github.com/ElisaSb/BlogSymfony.git][1]
    
        $ git clone https://github.com/ElisaSb/BlogSymfony.git
        $ cd BlogSymfony
        $ composer install
        
 * Generar la base de datos:
 
    * Inicia sesión en mysql con un usuario con permisos (para crear tablas y base de datos).
    * Carga el archivo de la carpeta raíz del proyecto llamado database.sql
    
            source /rutaDelArchivo/database.sql
            
 * Modificamos el archivo de la ruta BlogSymfony/app/config/parameters.yml
 
        parameters:
            database_host: 127.0.0.1
            database_port: null
            database_name: blog
            database_user: tu_usuario
            database_password: contraseña_usuario
            
  * Arrancamos el servicio de Symfony
  
        php bin/console server:run
        
  * De no abrirse directamente el proyecto, mete la ruta [http://127.0.0.1:8000/es][2]

Ya tenemos corriendo la aplicación web de prueba

[1]:  https://github.com/ElisaSb/BlogSymfony.git
[2]:  http://127.0.0.1:8000/es