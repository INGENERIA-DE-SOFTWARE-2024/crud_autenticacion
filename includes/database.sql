CREATE DATABASE crud_autenticacion;

create table aplicacion (
app_id serial,
app_nombre varchar(50),
app_situacion smallint default 1,
primary key (app_id)
);

create table rol (
rol_id serial,
rol_nombre varchar(50),
rol_nombre_ct varchar(10),
rol_app integer,
rol_situacion smallint default 1,
primary key (rol_id),
foreign key (rol_app) references aplicacion (app_id)
);

create table usuario(
usu_id serial,
usu_nombre varchar(50),
usu_catalogo integer,
usu_password lvarchar,
usu_situacion smallint default 1,
primary key (usu_id)
);

create table permiso (
permiso_id serial,
permiso_usuario integer,
permiso_rol integer,
permiso_situacion smallint default 1,
primary key (permiso_id),
foreign key (permiso_rol) references rol (rol_id),
foreign key (permiso_usuario) references usuario
(usu_id)
);
