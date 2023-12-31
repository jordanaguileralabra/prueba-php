
//Creamos la base de datos
CREATE DATABASE votacion;

//Creamos las tablas necesaria para nuestra votación
CREATE TABLE regiones(
    id int(11) auto_increment not null,
    region varchar(50) not null,
    CONSTRAINT pk_id PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE comunas(
    id int(11) auto_increment not null,
    comuna varchar(100) not null,
    id_region int(11) not null,
    CONSTRAINT pk_id PRIMARY KEY(id),
    CONSTRAINT fk_id_region FOREIGN KEY(id_region) REFERENCES regiones(id)
)ENGINE=InnoDb;

CREATE TABLE candidatos(
    id int(11) auto_increment not null,
    nombre_candidato varchar(100) not null,
    CONSTRAINT pk_id PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE medios(
    id int(11) auto_increment not null,
    medio varchar(100) not null,
    CONSTRAINT pk_id PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE votaciones(
    id int(11) auto_increment not null,
    rut varchar(9) not null,
    nombres varchar(100) not null,
    alias varchar(30) not null,
    email varchar(100) not null,
    id_region int(11) not null,
    id_comuna int(11) not null,
    id_candidato int(11) not null,
    CONSTRAINT fk_id_region FOREIGN KEY (id_region) REFERENCES regiones(id),
    CONSTRAINT fk_id_comuna FOREIGN KEY (id_comuna) REFERENCES comunas(id),
    CONSTRAINT fk_id_candidato FOREIGN KEY (id_candidato) REFERENCES candidatos(id),
    CONSTRAINT pk_id PRIMARY KEY(id),
    CONSTRAINT uq_rut UNIQUE(rut),
    CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDb;

CREATE TABLE response_checkbox (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_votacion INT NOT NULL,
    id_medio INT NOT NULL,
    FOREIGN KEY (id_votacion) REFERENCES votaciones(id),
    FOREIGN KEY (id_medio) REFERENCES medios(id)
) ENGINE=InnoDB;

//Insertamos datos a nuestras tabla que son requeridas
//Regiones
INSERT INTO regiones(id, region) VALUES(1, 'Arica y Parinacota');
INSERT INTO regiones(id, region) VALUES(2, 'Tarapaca');
INSERT INTO regiones(id, region) VALUES(3, 'Atacama');
INSERT INTO regiones(id, region) VALUES(4, 'Coquimbo');
INSERT INTO regiones(id, region) VALUES(5, 'Valparaiso');
INSERT INTO regiones(id, region) VALUES(6, 'Metropolitana');
INSERT INTO regiones(id, region) VALUES(7, 'Ohiggin');
INSERT INTO regiones(id, region) VALUES(8, 'Maule');
INSERT INTO regiones(id, region) VALUES(9, 'Ñuble');
INSERT INTO regiones(id, region) VALUES(10, 'Bio Bio');
INSERT INTO regiones(id, region) VALUES(11, 'Araucania');
INSERT INTO regiones(id, region) VALUES(12, 'Los Lagos');
INSERT INTO regiones(id, region) VALUES(13, 'Los Rios');
INSERT INTO regiones(id, region) VALUES(14, 'Aysen');
INSERT INTO regiones(id, region) VALUES(15, 'Magallanes');

//Comunas
INSERT INTO comunas(id, comuna, id_region) VALUES(1, 'Arica', 1);
INSERT INTO comunas(id, comuna, id_region) VALUES(2, 'Putre', 1);
INSERT INTO comunas(id, comuna, id_region) VALUES(3, 'Iquique', 2);
INSERT INTO comunas(id, comuna, id_region) VALUES(4, 'Atacama', 3);
INSERT INTO comunas(id, comuna, id_region) VALUES(5, 'Coquimbo', 4);
INSERT INTO comunas(id, comuna, id_region) VALUES(6, 'La Serena', 4);
INSERT INTO comunas(id, comuna, id_region) VALUES(7, 'Valle del Elqui', 4);
INSERT INTO comunas(id, comuna, id_region) VALUES(8, 'Valparaiso', 5);
INSERT INTO comunas(id, comuna, id_region) VALUES(9, 'Los Andes', 5);
INSERT INTO comunas(id, comuna, id_region) VALUES(10, 'Portillo', 5);
INSERT INTO comunas(id, comuna, id_region) VALUES(11, 'La Reina', 6);
INSERT INTO comunas(id, comuna, id_region) VALUES(12, 'Maipu', 6);
INSERT INTO comunas(id, comuna, id_region) VALUES(13, 'La Pintana', 6);

//Candidatos
INSERT INTO candidatos(id, nombre_candidato) VALUES(1, 'Andres Fuenzalida');
INSERT INTO candidatos(id, nombre_candidato) VALUES(2, 'Loaiza Figueroa');
INSERT INTO candidatos(id, nombre_candidato) VALUES(3, 'Martin Martinez');
INSERT INTO candidatos(id, nombre_candidato) VALUES(4, 'Michelle Arancibia');

//Medio
INSERT INTO medios(id, medio) VALUES(1, 'Web');
INSERT INTO medios(id, medio) VALUES(2, 'TV');
INSERT INTO medios(id, medio) VALUES(3, 'Redes Sociales');
INSERT INTO medios(id, medio) VALUES(4, 'Amigo');