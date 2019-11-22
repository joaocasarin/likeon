create database likeon;
use likeon;

create table usuario (
    id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario varchar(30) UNIQUE not null,
    senhaHash char(32),
    salt varchar(32),
    foto varchar(50)
) ENGINE = INNODB;

create table contato (
    id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    id_usuario smallint,
    telefone varchar(12),
    email varchar(100),
    endereco varchar(100),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE
);

create table amigos (
	id SMALLINT,
    id_amigo SMALLINT,
    FOREIGN KEY (id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_amigo) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (id, id_amigo)
);

create table posts (
    id_post SMALLINT AUTO_INCREMENT PRIMARY KEY,
    id_usuario SMALLINT,
    conteudo varchar(400),
    data datetime,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE
);