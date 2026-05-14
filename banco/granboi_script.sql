DROP SCHEMA IF EXISTS `granboi_db`;

CREATE SCHEMA IF NOT EXISTS `granboi_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `granboi_db`;

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `lote` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_lote` VARCHAR(50) NOT NULL,
  `descricao` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `raca` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_raca` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `vacina` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `preco_vacina` DECIMAL(13,2) DEFAULT 0.00,
  `periodo_carencia_dias` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `animal` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `brinco_identificador` VARCHAR(20) NOT NULL,
  `raca_id` INT(11) DEFAULT NULL,
  `lote_id` INT(11) DEFAULT NULL,
  `data_nascimento` DATE DEFAULT NULL,
  `sexo` ENUM('M','F') DEFAULT NULL,
  `peso_entrada` DECIMAL(10,2) DEFAULT NULL,
  `chip` VARCHAR(100) DEFAULT NULL COMMENT 'CODIGO DO CHIP IMPLANTADO NO ANIMAL (=0 para ausente)',
  `peso_saida` DOUBLE(13,3) DEFAULT 0.000 COMMENT 'Peso na saida (ou venda) do animal.',
  `valor_venda` DECIMAL(13,2) DEFAULT 0.00 COMMENT 'Valor da venda do animal.',
  `status` VARCHAR(20) DEFAULT 'Ativo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `brinco_UNIQUE` (`brinco_identificador`),
  KEY `fk_animal_raca` (`raca_id`),
  KEY `fk_animal_lote` (`lote_id`),
  CONSTRAINT `fk_animal_raca` FOREIGN KEY (`raca_id`) REFERENCES `raca` (`id`),
  CONSTRAINT `fk_animal_lote` FOREIGN KEY (`lote_id`) REFERENCES `lote` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `papel` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(20) NOT NULL,
  `descricao` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `permissao` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` VARCHAR(100) DEFAULT NULL,
  `recurso` VARCHAR(100) NOT NULL,
  `acao` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `papel_permissao` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `papel_id` BIGINT(20) NOT NULL,
  `permissao_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_papel_perm_papel` (`papel_id`),
  KEY `fk_papel_perm_perm` (`permissao_id`),
  CONSTRAINT `fk_papel_perm_papel` FOREIGN KEY (`papel_id`) REFERENCES `papel` (`id`),
  CONSTRAINT `fk_papel_perm_perm` FOREIGN KEY (`permissao_id`) REFERENCES `permissao` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `usuario` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pessoa` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nome_completo` VARCHAR(150) NOT NULL,
  `nome_social` VARCHAR(50) DEFAULT NULL,
  `cpf` CHAR(11) DEFAULT NULL COMMENT '11122233344 (Sempre 11 dígitos)',
  `telefone_movel` VARCHAR(15) DEFAULT NULL COMMENT '5511988887777 (Com DDI e DDD)',
  `email` VARCHAR(50) DEFAULT NULL,
  `usuario_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_pessoa_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `usuario_papel` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` BIGINT(20) NOT NULL,
  `papel_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_papel_user` (`usuario_id`),
  KEY `fk_user_papel_papel` (`papel_id`),
  CONSTRAINT `fk_user_papel_user` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  CONSTRAINT `fk_user_papel_papel` FOREIGN KEY (`papel_id`) REFERENCES `papel` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `historico_sanitario` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `animal_id` BIGINT(20) DEFAULT NULL,
  `vacina_id` BIGINT(20) DEFAULT NULL,
  `data_aplicacao` DATE NOT NULL,
  `dose` DECIMAL(10,3) DEFAULT NULL,
  `proxima_dose` DATE DEFAULT NULL,
  `preco_custo_sanitario` DECIMAL(13,2) DEFAULT 0.00 COMMENT 'Preço de custo',
  `pessoa_id_veterinario` BIGINT(20) NOT NULL COMMENT 'ID da Pessoa com Papel de VETERINÁRIO',
  PRIMARY KEY (`id`),
  KEY `fk_sanitario_animal` (`animal_id`),
  KEY `fk_sanitario_vacina` (`vacina_id`),
  KEY `fk_historico_sanitario_pessoa1_idx` (`pessoa_id_veterinario`),
  CONSTRAINT `fk_sanitario_animal` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  CONSTRAINT `fk_sanitario_vacina` FOREIGN KEY (`vacina_id`) REFERENCES `vacina` (`id`),
  CONSTRAINT `fk_historico_sanitario_pessoa1` FOREIGN KEY (`pessoa_id_veterinario`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pesagem` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `animal_id` BIGINT(20) DEFAULT NULL,
  `peso` DECIMAL(10,2) NOT NULL,
  `data_pesagem` DATE NOT NULL,
  `observacao` TEXT DEFAULT NULL,
  `pessoa_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pesagem_animal` (`animal_id`),
  KEY `fk_pesagem_pessoa1_idx` (`pessoa_id`),
  CONSTRAINT `fk_pesagem_animal` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  CONSTRAINT `fk_pesagem_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pasto` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nome_pasto` VARCHAR(200) DEFAULT NULL,
  `localizacao` VARCHAR(200) DEFAULT NULL,
  `custo_mensal` DECIMAL(13,2) DEFAULT 0.00,
  `capacidade_total` DOUBLE(13,3) DEFAULT 0.000,
  `quantidade_animais` DOUBLE(13,3) DEFAULT 0.000,
  `pessoa_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pasto_pessoa1_idx` (`pessoa_id`),
  CONSTRAINT `fk_pasto_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `historico_manejo` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `data_manejo` DATE DEFAULT NULL,
  `custo_manejo` DECIMAL(13,2) DEFAULT 0.00 COMMENT 'Qual o valor para a realização do Manejo do Lote',
  `pasto_id_origem` BIGINT(20) NOT NULL,
  `pasto_id_destino` BIGINT(20) NOT NULL,
  `lote_id` INT(11) NOT NULL,
  `pessoa_id_operador` BIGINT(20) NOT NULL COMMENT 'ID da pessoa (operador) responsável pelo Manejo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_historico_manejo_pasto1_idx` (`pasto_id_origem`),
  KEY `fk_historico_manejo_pasto2_idx` (`pasto_id_destino`),
  KEY `fk_historico_manejo_lote1_idx` (`lote_id`),
  KEY `fk_historico_manejo_pessoa1_idx` (`pessoa_id_operador`),
  CONSTRAINT `fk_historico_manejo_pasto1` FOREIGN KEY (`pasto_id_origem`) REFERENCES `pasto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_historico_manejo_pasto2` FOREIGN KEY (`pasto_id_destino`) REFERENCES `pasto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_historico_manejo_lote1` FOREIGN KEY (`lote_id`) REFERENCES `lote` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_historico_manejo_pessoa1` FOREIGN KEY (`pessoa_id_operador`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;