CREATE DATABASE IF NOT EXISTS granboi_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE granboi_db;

DROP TABLE IF EXISTS vacinacao;
DROP TABLE IF EXISTS animal_peso_historico;
DROP TABLE IF EXISTS animal;
DROP TABLE IF EXISTS usuario_papel;
DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS papel;
DROP TABLE IF EXISTS pessoa;

CREATE TABLE pessoa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(150) NOT NULL,
    cpf VARCHAR(14) NULL UNIQUE,
    telefone_movel VARCHAR(20) NULL,
    data_nascimento DATE NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    status ENUM('ativo', 'inativo', 'bloqueado') DEFAULT 'ativo',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario_pessoa
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(id)
);

CREATE TABLE papel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    slug VARCHAR(80) NOT NULL UNIQUE,
    descricao VARCHAR(255) NULL
);

CREATE TABLE usuario_papel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    papel_id INT NOT NULL,

    CONSTRAINT fk_usuario_papel_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuario(id),

    CONSTRAINT fk_usuario_papel_papel
    FOREIGN KEY (papel_id) REFERENCES papel(id),

    CONSTRAINT uq_usuario_papel
    UNIQUE (usuario_id, papel_id)
);

CREATE TABLE animal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brinco_identificador VARCHAR(50) NOT NULL UNIQUE,
    nome VARCHAR(100) NULL,
    raca VARCHAR(100) NULL,
    lote VARCHAR(100) NULL,
    data_nascimento DATE NULL,
    sexo ENUM('Macho', 'Fêmea') NOT NULL,
    peso_entrada DECIMAL(10,2) NOT NULL,
    status ENUM('ativo', 'vendido', 'morto', 'excluido') DEFAULT 'ativo',
    observacoes TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE animal_peso_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    animal_id INT NOT NULL,
    peso DECIMAL(10,2) NOT NULL,
    data_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    observacao TEXT NULL,

    CONSTRAINT fk_peso_animal
    FOREIGN KEY (animal_id) REFERENCES animal(id)
);

CREATE TABLE vacinacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    animal_id INT NOT NULL,
    vacina VARCHAR(100) NOT NULL,
    data_aplicacao DATE NOT NULL,
    proxima_dose DATE NULL,
    responsavel VARCHAR(150) NULL,
    lote_vacina VARCHAR(100) NULL,
    quantidade VARCHAR(50) NULL,
    via_aplicacao ENUM('subcutanea', 'intramuscular', 'oral') NULL,
    observacoes TEXT NULL,
    status ENUM('pendente', 'aplicada', 'atrasada', 'cancelada') DEFAULT 'pendente',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_vacinacao_animal
    FOREIGN KEY (animal_id) REFERENCES animal(id)
);

INSERT INTO papel (id, nome, slug, descricao) VALUES
(1, 'Administrador', 'administrador', 'Acesso total ao sistema'),
(2, 'Gestor', 'gestor', 'Responsável pela gestão do rebanho'),
(3, 'Veterinário', 'veterinario', 'Responsável pela saúde e vacinação do gado'),
(4, 'Operador', 'operador', 'Responsável por operações básicas do sistema');

INSERT INTO pessoa (
    id,
    nome_completo,
    cpf,
    telefone_movel,
    data_nascimento
) VALUES (
    1,
    'Administrador GranBoi',
    NULL,
    NULL,
    NULL
);

INSERT INTO usuario (
    id,
    pessoa_id,
    email,
    senha,
    status
) VALUES (
    1,
    1,
    'admin@granboi.com',
    '$2y$12$zJAthZv5qyKG9s38zXSvdOMTSpDD/qeK6qAusUQffqBoZUoxPBJYG',
    'ativo'
);

INSERT INTO usuario_papel (
    usuario_id,
    papel_id
) VALUES (
    1,
    1
);

INSERT INTO animal (
    brinco_identificador,
    nome,
    raca,
    lote,
    data_nascimento,
    sexo,
    peso_entrada,
    status,
    observacoes
) VALUES
('1023', 'Trovão', 'Nelore', 'Lote A', '2024-01-10', 'Macho', 410.00, 'ativo', 'Animal saudável'),
('2045', 'Estrela', 'Angus', 'Lote B', '2023-11-22', 'Fêmea', 450.00, 'ativo', 'Acompanhar vacinação'),
('8741', 'Bravo', 'Brahman', 'Lote C', '2024-03-05', 'Macho', 390.00, 'ativo', 'Animal em observação');

INSERT INTO animal_peso_historico (
    animal_id,
    peso,
    data_registro,
    observacao
) VALUES
(1, 410.00, '2026-05-01 08:00:00', 'Peso inicial registrado'),
(1, 425.00, '2026-05-15 08:00:00', 'Evolução normal'),
(2, 450.00, '2026-05-01 08:00:00', 'Peso inicial registrado'),
(2, 462.00, '2026-05-15 08:00:00', 'Boa evolução'),
(3, 390.00, '2026-05-01 08:00:00', 'Peso inicial registrado'),
(3, 398.00, '2026-05-15 08:00:00', 'Evolução abaixo do esperado');

INSERT INTO vacinacao (
    animal_id,
    vacina,
    data_aplicacao,
    proxima_dose,
    responsavel,
    lote_vacina,
    quantidade,
    via_aplicacao,
    observacoes,
    status
) VALUES
(1, 'Febre Aftosa', '2026-05-12', '2026-11-12', 'Carlos Silva', 'AFT-2026', '5ml', 'subcutanea', 'Vacinação sem reações.', 'pendente'),
(2, 'Brucelose', '2026-05-15', '2026-11-15', 'Marcos Oliveira', 'BRU-9921', '3ml', 'intramuscular', 'Aplicação realizada normalmente.', 'aplicada'),
(3, 'Raiva', '2026-05-18', '2026-11-18', 'Fernanda Costa', 'RAV-4412', '4ml', 'oral', 'Vacinação atrasada devido ao manejo.', 'atrasada');