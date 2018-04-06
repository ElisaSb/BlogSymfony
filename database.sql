CREATE DATABASE IF NOT EXISTS blog;
USE blog;

CREATE TABLE usuarios(
id          int(255) auto_increment not null,
rol         varchar(20),
nombre      varchar(255),
apellido    varchar(255),
email       varchar(255),
pass        varchar(255),
imagen      varchar(255),
CONSTRAINT pk_usuarios PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE categorias(
id          int(255) auto_increment not null,
nombre      varchar(255),
descripcion text,
CONSTRAINT pk_categorias PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE entradas(
id              int(255) auto_increment not null,
usuario_id      int(255) not null,
categoria_id    int(255) not null,
titulo          varchar(255),
contenido       text,
estado          varchar(20),
imagen          varchar(255),
CONSTRAINT pk_entradas PRIMARY KEY(id),
CONSTRAINT fk_entradas_usuarios FOREIGN KEY(usuario_id) REFERENCES usuarios(id),
CONSTRAINT fk_entradas_categorias FOREIGN KEY(categoria_id) REFERENCES categorias(id)
)ENGINE=InnoDb;

CREATE TABLE etiquetas(
id          int(255) auto_increment not null,
nombre      varchar(255),
descripcion text,
CONSTRAINT pk_etiquetas PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE entrada_etiqueta(
id      int(255) auto_increment not null,
entrada_id int(255) not null,
etiqueta_id int(255) not null,
CONSTRAINT pk_entrada_etiqueta PRIMARY KEY(id),
CONSTRAINT fk_entrada_etiqueta_entradas FOREIGN KEY (entrada_id) REFERENCES entradas(id),
CONSTRAINT fk_entrada_etiqueta_etiquetas FOREIGN KEY (etiqueta_id) REFERENCES etiquetas(id)
)ENGINE=InnoDb;