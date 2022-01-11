-- -----------------------------------------------------
-- Schema place_reservation
-- -----------------------------------------------------
create schema if not exists place_reservation default character set utf8 ;
use place_reservation;

-- -----------------------------------------------------
-- usuario
-- -----------------------------------------------------
create table usuario (
  usuario_id int not null AUTO_INCREMENT,
  usuario_nome varchar(45) NULL,
  usuario_sobrenome TEXT NULL,
  usuario_tipo varchar(1) not null default 'P',
  faculdade TEXT NULL,
  email varchar(100) NULL,
  senha varchar(100) NULL,
  escolaridade text null,
  profissao text null,
  data_criacao datetime not null default current_timestamp,
  primary key (usuario_id))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- sala
-- obs.: status pode ser :
-- F -> para fechado (exclusivo do admin)
-- L -> para livre
-- O -> para ocupado
-- -----------------------------------------------------
create table sala (
  sala_id int not null AUTO_INCREMENT,
  sala_nome varchar(100) not null,
  sala_status varchar(1) not null default 'F',
  data_criacao datetime not null default current_timestamp,
  primary key (sala_id))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- usuario_sala
-- obs.: status pode ser :
-- F -> Reservado
-- C -> Cancelado
-- -----------------------------------------------------
create table usuario_sala (
  usuario_sala_id int not null AUTO_INCREMENT,
  usuario_sala_status varchar(1) not null default 'R',
  data_criacao datetime not null default current_timestamp,
  reserva_inicia datetime not null,
  reserva_fim datetime not null,
  usuario_sala_usuario_id int not null,
  usuario_sala_sala_id int not null,
  primary key (usuario_sala_id, usuario_sala_usuario_id, usuario_sala_sala_id),
  constraint fk_usuario_has_sala_usuario1
    foreign key (usuario_sala_usuario_id)
    references usuario (usuario_id)
    on delete no action
    on update no action,
  constraint fk_usuario_has_sala_sala1
    foreign key (usuario_sala_sala_id)
    references sala (sala_id)
    on delete no action
    on update no action)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- recurso
-- -----------------------------------------------------
create table recurso (
  recurso_id int not null AUTO_INCREMENT,
  recurso_nome varchar(100) not null,
  data_criacao datetime not null default current_timestamp,
  primary key (recurso_id))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- sala_recurso
-- -----------------------------------------------------
create table sala_recurso (
  sala_recurso_id int not null AUTO_INCREMENT,
  qtd_recurso int not null,
  sala_recurso_sala_id int not null,
  sala_recurso_recurso_id int not null,
  primary key (sala_recurso_id, sala_recurso_sala_id, sala_recurso_recurso_id),
  constraint fk_sala_has_recurso_sala1
    foreign key (sala_recurso_sala_id)
    references sala (sala_id)
    on delete no action
    on update no action,
  constraint fk_sala_has_recurso_recurso1
    foreign key (sala_recurso_recurso_id)
    references recurso (recurso_id)
    on delete no action
    on update no action)
ENGINE = InnoDB;
