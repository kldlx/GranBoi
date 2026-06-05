DROP SCHEMA IF EXISTS `granboi_db`;

CREATE SCHEMA IF NOT EXISTS `granboi_db`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE `granboi_db`;

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `lote` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico do lote.',
  `nome_lote` VARCHAR(50) NOT NULL COMMENT 'Nome usado para identificar o lote de animais.',
  `descricao` TEXT COMMENT 'Descricao livre sobre finalidade ou caracteristicas do lote.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Cadastro dos lotes usados para agrupar animais.';

CREATE TABLE `tipo_raca` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico do tipo de raca.',
  `nome_tipo_raca` VARCHAR(50) NOT NULL COMMENT 'Nome da raca bovina cadastrada.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Cadastro das racas disponiveis para os animais.';

CREATE TABLE `vacina` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico da vacina.',
  `nome` VARCHAR(100) NOT NULL COMMENT 'Nome comercial ou tecnico da vacina.',
  `preco_vacina` DECIMAL(13,2) DEFAULT 0.00 COMMENT 'Preco padrao da vacina para uso nos registros sanitarios.',
  `periodo_carencia_dias` INT(11) DEFAULT 0 COMMENT 'Quantidade de dias de carencia apos aplicacao.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Cadastro de vacinas e informacoes padrao de aplicacao.';

CREATE TABLE `animal` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico do animal.',
  `brinco_identificador` VARCHAR(100) NOT NULL COMMENT 'Codigo do brinco usado para identificar o animal no manejo.',
  `tipo_raca_id` INT(11) DEFAULT NULL COMMENT 'Referencia para a raca cadastrada em tipo_raca.',
  `lote_id` INT(11) DEFAULT NULL COMMENT 'Referencia para o lote atual do animal.',
  `data_nascimento` DATE DEFAULT NULL COMMENT 'Data de nascimento do animal, quando conhecida.',
  `sexo` ENUM('M','F') DEFAULT NULL COMMENT 'Sexo do animal: M para macho e F para femea.',
  `peso_entrada` DECIMAL(10,2) DEFAULT NULL COMMENT 'Peso registrado na entrada ou cadastro do animal em kg.',
  `chip` VARCHAR(100) DEFAULT NULL COMMENT 'Codigo do chip implantado no animal, quando houver.',
  `data_compra` DATE DEFAULT NULL COMMENT 'Data de compra ou entrada do animal na fazenda.',
  `valor_compra` DECIMAL(13,2) DEFAULT NULL COMMENT 'Valor pago na compra do animal.',
  `data_venda` DATE DEFAULT NULL COMMENT 'Data de venda ou saida comercial do animal.',
  `peso_saida` DOUBLE(13,3) DEFAULT 0.000 COMMENT 'Peso na saida ou venda do animal em kg.',
  `valor_venda` DECIMAL(13,2) DEFAULT 0.00 COMMENT 'Valor recebido na venda do animal.',
  `status` VARCHAR(20) DEFAULT 'Ativo' COMMENT 'Situacao do animal: Ativo, Vendido, Perda ou Excluido.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `brinco_UNIQUE` (`brinco_identificador`),
  KEY `fk_animal_tipo_raca` (`tipo_raca_id`),
  KEY `fk_animal_lote` (`lote_id`),
  CONSTRAINT `fk_animal_tipo_raca` FOREIGN KEY (`tipo_raca_id`) REFERENCES `tipo_raca` (`id`),
  CONSTRAINT `fk_animal_lote` FOREIGN KEY (`lote_id`) REFERENCES `lote` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Cadastro principal dos animais do rebanho.';

CREATE TABLE `papel` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico do papel de acesso.',
  `nome` VARCHAR(100) NOT NULL COMMENT 'Nome do papel ou funcao do usuario no sistema.',
  `descricao` VARCHAR(255) DEFAULT NULL COMMENT 'Descricao resumida das responsabilidades do papel.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Funcoes de acesso disponiveis para usuarios.';

CREATE TABLE `permissao` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico da permissao.',
  `nome` VARCHAR(100) NOT NULL COMMENT 'Nome amigavel da permissao.',
  `descricao` VARCHAR(100) DEFAULT NULL COMMENT 'Descricao resumida da permissao.',
  `recurso` VARCHAR(100) NOT NULL COMMENT 'Area ou recurso do sistema controlado pela permissao.',
  `acao` VARCHAR(50) NOT NULL COMMENT 'Acao permitida sobre o recurso, como listar, criar, editar ou excluir.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Permissoes granulares usadas no controle de acesso.';

CREATE TABLE `papel_permissao` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico do vinculo entre papel e permissao.',
  `papel_id` BIGINT NOT NULL COMMENT 'Referencia ao papel que recebera a permissao.',
  `permissao_id` BIGINT NOT NULL COMMENT 'Referencia a permissao atribuida ao papel.',
  PRIMARY KEY (`id`),
  KEY `fk_papel_perm_papel` (`papel_id`),
  KEY `fk_papel_perm_perm` (`permissao_id`),
  CONSTRAINT `fk_papel_perm_papel` FOREIGN KEY (`papel_id`) REFERENCES `papel` (`id`),
  CONSTRAINT `fk_papel_perm_perm` FOREIGN KEY (`permissao_id`) REFERENCES `permissao` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de associacao entre papeis e permissoes.';

CREATE TABLE `usuario` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico do usuario de acesso.',
  `nome` VARCHAR(100) NOT NULL COMMENT 'Nome de exibicao do usuario.',
  `email` VARCHAR(100) NOT NULL COMMENT 'E-mail usado para login no sistema.',
  `senha` VARCHAR(255) NOT NULL COMMENT 'Senha do usuario armazenada em hash.',
  `status` ENUM('ativo', 'inativo') NOT NULL DEFAULT 'ativo' COMMENT 'Situacao de acesso do usuario.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Usuarios com credenciais de acesso ao sistema.';

CREATE TABLE `pessoa` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico da pessoa.',
  `nome_completo` VARCHAR(150) NOT NULL COMMENT 'Nome completo da pessoa vinculada ao usuario.',
  `nome_social` VARCHAR(50) DEFAULT NULL COMMENT 'Nome social ou nome preferencial da pessoa.',
  `cpf` CHAR(11) DEFAULT NULL COMMENT 'CPF da pessoa com 11 digitos, sem mascara.',
  `telefone_movel` VARCHAR(15) DEFAULT NULL COMMENT 'Telefone movel com DDI e DDD, sem mascara.',
  `email` VARCHAR(50) DEFAULT NULL COMMENT 'E-mail de contato da pessoa.',
  `usuario_id` BIGINT NOT NULL COMMENT 'Referencia ao usuario de acesso vinculado a pessoa.',
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_pessoa_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Dados pessoais vinculados aos usuarios do sistema.';

CREATE TABLE `usuario_papel` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico do vinculo entre usuario e papel.',
  `usuario_id` BIGINT NOT NULL COMMENT 'Referencia ao usuario que recebe o papel.',
  `papel_id` BIGINT NOT NULL COMMENT 'Referencia ao papel atribuido ao usuario.',
  PRIMARY KEY (`id`),
  KEY `fk_user_papel_user` (`usuario_id`),
  KEY `fk_user_papel_papel` (`papel_id`),
  CONSTRAINT `fk_user_papel_user` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  CONSTRAINT `fk_user_papel_papel` FOREIGN KEY (`papel_id`) REFERENCES `papel` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de associacao entre usuarios e papeis.';

CREATE TABLE `historico_sanitario` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico do registro sanitario.',
  `animal_id` BIGINT DEFAULT NULL COMMENT 'Referencia ao animal vacinado ou atendido.',
  `vacina_id` BIGINT DEFAULT NULL COMMENT 'Referencia a vacina aplicada.',
  `data_aplicacao` DATE NOT NULL COMMENT 'Data em que a vacina foi aplicada.',
  `dose` DECIMAL(10,3) DEFAULT NULL COMMENT 'Quantidade ou dose aplicada.',
  `proxima_dose` DATE DEFAULT NULL COMMENT 'Data prevista para a proxima dose, quando houver.',
  `preco_custo_sanitario` DECIMAL(13,2) DEFAULT 0.00 COMMENT 'Custo sanitario registrado para a aplicacao.',
  `pessoa_id_veterinario` BIGINT NOT NULL COMMENT 'Referencia a pessoa responsavel pela aplicacao ou registro sanitario.',
  PRIMARY KEY (`id`),
  KEY `fk_sanitario_animal` (`animal_id`),
  KEY `fk_sanitario_vacina` (`vacina_id`),
  KEY `fk_historico_sanitario_pessoa1_idx` (`pessoa_id_veterinario`),
  CONSTRAINT `fk_sanitario_animal` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  CONSTRAINT `fk_sanitario_vacina` FOREIGN KEY (`vacina_id`) REFERENCES `vacina` (`id`),
  CONSTRAINT `fk_historico_sanitario_pessoa1` FOREIGN KEY (`pessoa_id_veterinario`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Historico de vacinacoes e custos sanitarios dos animais.';

CREATE TABLE `pesagem` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico da pesagem.',
  `animal_id` BIGINT DEFAULT NULL COMMENT 'Referencia ao animal pesado.',
  `peso` DECIMAL(10,2) NOT NULL COMMENT 'Peso registrado do animal em kg.',
  `data_pesagem` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data e hora em que a pesagem foi registrada.',
  `observacao` TEXT COMMENT 'Observacoes livres sobre a pesagem.',
  `pessoa_id` BIGINT NOT NULL COMMENT 'Referencia a pessoa responsavel pelo registro da pesagem.',
  PRIMARY KEY (`id`),
  KEY `fk_pesagem_animal` (`animal_id`),
  KEY `fk_pesagem_pessoa1_idx` (`pessoa_id`),
  CONSTRAINT `fk_pesagem_animal` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  CONSTRAINT `fk_pesagem_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Historico de pesagens dos animais.';

CREATE TABLE `pasto` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico do pasto.',
  `nome_pasto` VARCHAR(200) DEFAULT NULL COMMENT 'Nome usado para identificar o pasto.',
  `localizacao` VARCHAR(200) DEFAULT NULL COMMENT 'Descricao da localizacao fisica do pasto.',
  `custo_mensal` DECIMAL(13,2) DEFAULT 0.00 COMMENT 'Custo mensal estimado de manutencao do pasto.',
  `capacidade_total` DOUBLE(13,3) DEFAULT 0.000 COMMENT 'Capacidade total estimada do pasto.',
  `quantidade_animais` DOUBLE(13,3) DEFAULT 0.000 COMMENT 'Quantidade atual ou estimada de animais no pasto.',
  `pessoa_id` BIGINT NOT NULL COMMENT 'Referencia a pessoa responsavel pelo pasto.',
  PRIMARY KEY (`id`),
  KEY `fk_pasto_pessoa1_idx` (`pessoa_id`),
  CONSTRAINT `fk_pasto_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Cadastro de pastos e suas informacoes operacionais.';

CREATE TABLE `despesa_financeira` (
  `id` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico da despesa financeira.',
  `descricao` VARCHAR(200) NOT NULL COMMENT 'Descricao resumida da despesa.',
  `categoria` VARCHAR(100) NOT NULL COMMENT 'Categoria da despesa, como Alimentacao, Sanidade, Manejo, Transporte ou Outros.',
  `valor` DECIMAL(13,2) NOT NULL COMMENT 'Valor monetario da despesa.',
  `data_despesa` DATE NOT NULL COMMENT 'Data em que a despesa ocorreu.',
  `observacao` TEXT COMMENT 'Observacoes livres ou detalhes adicionais da despesa.',
  `animal_id` BIGINT DEFAULT NULL COMMENT 'Referencia opcional ao animal relacionado a despesa.',
  `lote_id` INT(11) DEFAULT NULL COMMENT 'Referencia opcional ao lote relacionado a despesa.',
  `usuario_id` BIGINT DEFAULT NULL COMMENT 'Referencia opcional ao usuario que registrou a despesa.',
  PRIMARY KEY (`id`),
  KEY `fk_despesa_animal` (`animal_id`),
  KEY `fk_despesa_lote` (`lote_id`),
  KEY `fk_despesa_usuario` (`usuario_id`),
  CONSTRAINT `fk_despesa_animal` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_despesa_lote` FOREIGN KEY (`lote_id`) REFERENCES `lote` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_despesa_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Registro de despesas operacionais e financeiras da fazenda.';

SET FOREIGN_KEY_CHECKS = 1;
