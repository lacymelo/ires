-- use network_planning;

-- --------------------
-- Tabela usuario
-- --------------------
create table usuario(
    usuario_id int not null auto_increment,
    first_name varchar(200) null,
    last_name varchar(200) null,
    genre varchar(1) null,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime null,
    primary key(usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------
-- Tabela addresses
-- --------------------
create table addresses(
    addresses_id int not null auto_increment,
    address_usuario_id int not null,
    street text null,
    number varchar(16) null,
    primary key(addresses_id),
    KEY fk_address_user(address_usuario_id),
    CONSTRAINT fk_address_user
        FOREIGN KEY (address_usuario_id) 
        REFERENCES usuario(usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;