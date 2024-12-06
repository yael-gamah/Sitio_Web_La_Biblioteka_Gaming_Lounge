-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS laBliblioteka;
USE laBliblioteka;

-- Tabla Usuario
CREATE TABLE Usuario (
    ID_usuario INT AUTO_INCREMENT PRIMARY KEY, 
    nombre_usuario VARCHAR(100) NOT NULL,
    telefono VARCHAR(10) NOT NULL unique,
    contraseña VARCHAR(255) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    rol ENUM('Cliente', 'Trabajador', 'Administrador') NOT NULL,
    puntos INT,
    promocion_activa varchar(255)
);
select * from Usuario;

-- Tabla Paquete
CREATE TABLE Paquete (
    ID_paquete INT AUTO_INCREMENT PRIMARY KEY,
    nombre_paquete VARCHAR(100) NOT NULL,
    consolas VARCHAR(100) NOT NULL,
    elementos_incluidos TEXT,
    sala ENUM('Sala TV') NOT NULL,
    horas_incluidas INT NOT NULL,
    asistencia_maxima INT NOT NULL,
    costos VARCHAR(50) NOT NULL
);

INSERT INTO Paquete (nombre_paquete, consolas, elementos_incluidos, sala, horas_incluidas, asistencia_maxima, costos)
values ('Paquete Smash', '', 'Sala VIP (Incluye 1 Consola, karaoke y Servicios de Streaming)', 'Sala TV', 4, 6 , 'Domingo a Jueves: $500, Viernes y Sábados: $600.');

INSERT INTO Paquete (nombre_paquete, consolas, elementos_incluidos, sala, horas_incluidas, asistencia_maxima, costos)
values ('Paquete Survival', '5 Consolas de su elección', 'Sala VIP (Incluye 1 Consola, karaoke y Servicios de Streaming)', 'Sala TV', 4, 25 , 'Domingo a Jueves: $1000, Viernes y Sábados: $1500');

INSERT INTO Paquete (nombre_paquete, consolas, elementos_incluidos, sala, horas_incluidas, asistencia_maxima, costos)
values ('Paquete Ultimate', '19 Consolas de su elección.', 'Sala VIP (Incluye 1 Consola, karaoke y Servicios de Streaming)', 'Sala TV', 4, 50 , 'Domingo a Jueves: $2500, Viernes y Sábados: $3500');



-- Tabla Consola
CREATE TABLE Consola (
    ID_consola INT AUTO_INCREMENT PRIMARY KEY,
    tipo_consola ENUM('PlayStation_5', 'Xbox_Series_X', 'Nintendo_Switch', 'PC_Gamer') NOT NULL unique
);
INSERT INTO Consola (tipo_consola) values ("PlayStation_5");
INSERT INTO Consola (tipo_consola) values ("Xbox_Series_X");
INSERT INTO Consola (tipo_consola) values ("Nintendo_Switch");
INSERT INTO Consola (tipo_consola) values ("PC_Gamer");


-- Tabla Juego
CREATE TABLE Juego (
    ID_juego INT AUTO_INCREMENT PRIMARY KEY,
    nombre_juego VARCHAR(100) NOT NULL,
    ID_consola INT,
    FOREIGN KEY (ID_consola) REFERENCES Consola(ID_consola) ON DELETE CASCADE
);
-- Tabla Reservacion
CREATE TABLE Reservacion (
    ID_reservacion INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    fecha_evento DATE NOT NULL,
    hora_evento TIME NOT NULL,
    ID_paquete INT,
    ID_usuario int,
    FOREIGN KEY (ID_paquete) REFERENCES Paquete(ID_paquete) ON DELETE CASCADE,
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(ID_usuario) ON DELETE CASCADE
);


-- Tabla Registro_visita
CREATE TABLE Registro_visita (
    ID_visita INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(100) NOT NULL,
    fecha_visita DATE NOT NULL,
    hora_visita time not null,
    horas_jugadas INT NOT NULL,
    ID_consola INT,
    ID_juego INT,
    ID_usuario int,     
    FOREIGN KEY (ID_consola) REFERENCES Consola(ID_consola) ON DELETE CASCADE,
    FOREIGN KEY (ID_juego) REFERENCES Juego(ID_juego) ON DELETE CASCADE,
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(ID_usuario) ON DELETE CASCADE
);

-- Tabla Promocion
CREATE TABLE Promocion (
    ID_promocion INT AUTO_INCREMENT PRIMARY KEY,
    nombre_promocion VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    costo_en_puntos INT NOT NULL,
    codigo_promocion VARCHAR(50) NOT NULL UNIQUE
);
-- INSERT INTO Promocion (nombre_promocion, descripcion, costo_en_puntos, codigo_promocion)values ('Descuento por Puntos', '20% de descuento en reservación', 500, 'DESC20');
-- INSERT INTO Promocion (nombre_promocion, descripcion, costo_en_puntos, codigo_promocion)values ('Descuento de Fin de Semana', '15% de descuento en fin de semana', 400, 'WEEKEND15');
-- INSERT INTO Promocion (nombre_promocion, descripcion, costo_en_puntos, codigo_promocion)values ('Promoción de Evento Especial', '30% en eventos especiales', 600, 'EVENT30');
-- Tabla intermedia Usuario_Promocion para canjes de promociones por usuarios
CREATE TABLE Usuario_Promocion (
    ID_usuario int, 
    ID_promocion INT,
    fecha_canje DATE,
    costo INT NOT NULL, -- Nuevo atributo costo para registrar el costo en puntos del canje
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(ID_usuario) ON DELETE CASCADE,
    FOREIGN KEY (ID_promocion) REFERENCES Promocion(ID_promocion) ON DELETE CASCADE,
    PRIMARY KEY (ID_usuario, ID_promocion) -- Clave compuesta para evitar duplicidad de canjes
);
