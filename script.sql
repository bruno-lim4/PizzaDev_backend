
create database pizza_dev;

-- create
CREATE TABLE pizzas (
  pizza_id int NOT NULL AUTO_INCREMENT,
  nome varchar(50) NOT NULL,
  ingredientes varchar(500) NOT NULL,
  img varchar(80),
  brotinho float NOT NULL,
  media float NOT NULL,
  grande float NOT NULL,
  PRIMARY KEY (pizza_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

CREATE TABLE usuarios (
  usuario_id int NOT NULL AUTO_INCREMENT,
  nome_completo varchar(100) NOT NULL,
  username varchar(50) NOT NULL,
  senha varchar(200) NOT NULL,
  PRIMARY KEY (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE mensagens (
    mensagem_id int NOT NULL AUTO_INCREMENT,
    nome_completo varchar(100) NOT NULL,
    email varchar(150) NOT NULL,
    assunto varchar(100) NOT NULL,
    mensagem varchar(1000) NOT NULL,
    PRIMARY KEY(mensagem_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
