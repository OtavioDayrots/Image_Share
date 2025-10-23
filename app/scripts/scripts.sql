CREATE DATABASE webapp;
USE webapp;

CREATE TABLE imagens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    nome_original VARCHAR(255) NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    caminho VARCHAR(255) NOT NULL
);

create table usuarios (
	id int primary key auto_increment,
    nome varchar(255) not null,
    email varchar(255) not null,
    senha varchar(255) not null,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    img_perfil_id INT, -- chave estrangeira
    FOREIGN KEY (img_perfil_id) REFERENCES imagens(id)
);

create table galeria (
	imagem_id int not null,
    usuario_id int not null,
    
    constraint FK_GALERIA_IMAGEM foreign key (imagem_id) references imagens(id),
    constraint FK_GALERIA_USUARIOS foreign key (usuario_id) references usuarios(id),
    
    constraint PK_GALERIA_ID primary key (imagem_id, usuario_id)
);
