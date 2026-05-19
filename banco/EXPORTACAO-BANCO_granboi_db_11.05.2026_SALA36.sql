-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Maio-2026 às 20:09
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `granboi_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `animal`
--
DROP TABLE IF EXISTS `granboi_db`.`animal` ;

CREATE TABLE IF NOT EXISTS `animal` (
  `id` bigint(20) NOT NULL,
  `brinco_identificador` varchar(20) NOT NULL,
  `raca_id` int(11) DEFAULT NULL,
  `lote_id` int(11) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `sexo` enum('M','F') DEFAULT NULL,
  `peso_entrada` decimal(10,2) DEFAULT NULL,
  `chip` varchar(100) DEFAULT NULL COMMENT 'CODIGO DO CHIP IMPLANTADO NO ANIMAL (=0 para ausente)',
  `peso_saida` double(13,3) DEFAULT 0.000 COMMENT 'Peso na saida (ou venda) do animal. ',
  `valor_venda` decimal(13,2) DEFAULT 0.00 COMMENT 'Valor da venda do animal.',
  `status` varchar(20) DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico_manejo`
--

CREATE TABLE `historico_manejo` (
  `id` bigint(20) NOT NULL,
  `data_manejo` date DEFAULT NULL,
  `custo_manejo` decimal(13,2) DEFAULT 0.00 COMMENT 'Qual o valor para a realização do Manejo do Lote',
  `pasto_id_origem` bigint(20) NOT NULL,
  `pasto_id_destino` bigint(20) NOT NULL,
  `lote_id` int(11) NOT NULL,
  `pessoa_id_operador` bigint(20) NOT NULL COMMENT 'ID da pessoa (operador) responsável pelo Manejo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico_sanitario`
--

CREATE TABLE `historico_sanitario` (
  `id` bigint(20) NOT NULL,
  `animal_id` bigint(20) DEFAULT NULL,
  `vacina_id` bigint(20) DEFAULT NULL,
  `data_aplicacao` date NOT NULL,
  `dose` decimal(10,3) DEFAULT NULL,
  `proxima_dose` date DEFAULT NULL,
  `preco_custo_sanitario` decimal(13,2) DEFAULT 0.00 COMMENT 'Preço de custo',
  `pessoa_id_veterinario` bigint(20) NOT NULL COMMENT 'ID da Pessoa com Papel de VETERINÁRIO '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lote`
--

CREATE TABLE `lote` (
  `id` int(11) NOT NULL,
  `nome_lote` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `papel`
--

CREATE TABLE `papel` (
  `id` bigint(20) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `papel`
--

INSERT INTO `papel` (`id`, `nome`, `descricao`) VALUES
(1, 'Administrador', 'Administrador do sistema'),
(2, 'Gestor', 'Gestão das operações'),
(3, 'Veterinário', 'Profissional Veterinário que cuida da saúde do gado'),
(4, 'Operador', 'Operador do sistema');

-- --------------------------------------------------------

--
-- Estrutura da tabela `papel_permissao`
--

CREATE TABLE `papel_permissao` (
  `id` bigint(20) NOT NULL,
  `papel_id` bigint(20) NOT NULL,
  `permissao_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `papel_permissao`
--

INSERT INTO `papel_permissao` (`id`, `papel_id`, `permissao_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 1, 13),
(5, 2, 13),
(6, 3, 13),
(7, 1, 14),
(8, 2, 14),
(9, 3, 14),
(10, 1, 2),
(11, 1, 3),
(12, 1, 4),
(13, 1, 8),
(14, 1, 10),
(15, 1, 11),
(16, 1, 15),
(17, 2, 5),
(18, 2, 7),
(19, 2, 9),
(20, 1, 12),
(21, 2, 12),
(22, 3, 6),
(23, 4, 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pasto`
--

CREATE TABLE `pasto` (
  `id` bigint(20) NOT NULL,
  `nome_pasto` varchar(200) DEFAULT NULL,
  `localizacao` varchar(200) DEFAULT NULL,
  `custo_mensal` decimal(13,2) DEFAULT 0.00,
  `capacidade_total` double(13,3) DEFAULT 0.000,
  `quantidade_animais` double(13,3) DEFAULT 0.000,
  `pessoa_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE `permissao` (
  `id` bigint(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `recurso` varchar(100) NOT NULL,
  `acao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `permissao`
--

INSERT INTO `permissao` (`id`, `nome`, `descricao`, `recurso`, `acao`) VALUES
(1, 'Ver Animais', 'Visualiza os eventos cadastrados pelo Organizador', 'evento', 'listar'),
(2, 'Cadastrar Animais', 'Adiciona eventos.', 'evento', 'criar'),
(3, 'Editar Animais', 'Altera dados dados dos eventos', 'evento', 'atualizar'),
(4, 'Gerenciar Catálogo', 'Gerenciamento dos eventos', 'evento', 'gerenciar'),
(5, 'Incluir pesagem', 'Inclusão de Colaborador em evento.', 'participante', 'criar'),
(6, 'Minhas Pesagens', 'Vê histórico de particições', 'participante', 'ler_participacoes'),
(7, 'Meus Animais', 'Vê avaliações', 'avaliacao', 'ler_avaliacoes_por_evento'),
(8, 'Todas as Pesagens', 'Vê todas as participações em eventos', 'participacao', 'ler_tudo'),
(9, 'Todos os Animais', 'Cancela a participação', 'participacao', 'cancelar'),
(10, 'Ver Meu Perfil', 'Acessa próprios dados', 'pessoa', 'ler_proprio'),
(11, 'Editar Meu Perfil', 'Altera próprios dados', 'pessoa', 'atualizar_proprio'),
(12, 'Ver Carteira', 'Acessa dados de todos os clientes', 'pessoa', 'ler_tudo'),
(13, 'Acesso completo', 'para suporte do sistema', '*', '*'),
(14, 'Editar Meu Perfil', 'Altera próprios dados', 'pessoa', 'atualizar_proprio'),
(15, 'Ver Carteira de Vacinas', 'Acessa dados de todos os clientes', 'pessoa', 'ler_tudo'),
(16, 'Acesso completo', 'para suporte do sistema', '*', '*');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pesagem`
--

CREATE TABLE `pesagem` (
  `id` bigint(20) NOT NULL,
  `animal_id` bigint(20) DEFAULT NULL,
  `peso` decimal(10,2) NOT NULL,
  `data_pesagem` date NOT NULL,
  `observacao` text DEFAULT NULL,
  `pessoa_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `id` bigint(20) NOT NULL,
  `nome_completo` varchar(150) NOT NULL,
  `nome_social` varchar(50) DEFAULT NULL,
  `cpf` char(11) DEFAULT NULL COMMENT '11122233344 (Sempre 11 dígitos)',
  `telefone_movel` varchar(15) DEFAULT NULL COMMENT '5511988887777 (Com DDI e DDD)',
  `email` varchar(50) NOT NULL,
  `usuario_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id`, `nome_completo`, `nome_social`, `cpf`, `telefone_movel`, `email`, `usuario_id`) VALUES
(1, 'Carlos Silva Administrador', 'Carlos', '11122233344', '5511999998888', '', 1),
(2, 'Maria Alves Gerente', 'Maria', '55566677788', '5511977776666', '', 2),
(3, 'Leticia Correia Veterinário', 'Leticia', '99988877766', '5511955554444', '', 3),
(4, 'Jose Usuáro Operador', 'Jose', '45685877766', '5511953254414', '', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `raca`
--

CREATE TABLE `raca` (
  `id` int(11) NOT NULL,
  `nome_raca` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `raca`
--

INSERT INTO `raca` (`id`, `nome_raca`) VALUES
(1, 'Nelore'),
(2, 'Red Angus'),
(3, 'Nelore'),
(4, 'Red Angus'),
(5, 'Angus Mocho'),
(6, 'Hereford'),
(7, 'Brahman'),
(8, 'Guzerá'),
(9, 'Simental'),
(10, 'Gir'),
(11, 'Girolando'),
(12, 'Jersey');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Carlos Silva Administrador', 'admin@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy'),
(2, 'Maria Alves Gerente', 'gerente@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy'),
(3, 'Leticia Correia Veterinário', 'veterinario@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy'),
(4, 'Jose Usuáro Operador', 'operador@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_papel`
--

CREATE TABLE `usuario_papel` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `papel_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario_papel`
--

INSERT INTO `usuario_papel` (`id`, `usuario_id`, `papel_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vacina`
--

CREATE TABLE `vacina` (
  `id` bigint(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco_vacina` decimal(13,2) DEFAULT 0.00,
  `periodo_carencia_dias` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vacina`
--

INSERT INTO `vacina` (`id`, `nome`, `preco_vacina`, `periodo_carencia_dias`) VALUES
(1, 'Febre afitosa', '10.00', 715),
(2, 'Febre afitosa', '10.00', 180),
(3, 'Bucelose', '20.00', 150),
(4, 'Clostridioses', '30.00', 120),
(5, 'Raiva', '13.00', 360);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brinco_UNIQUE` (`brinco_identificador`),
  ADD KEY `fk_animal_raca` (`raca_id`),
  ADD KEY `fk_animal_lote` (`lote_id`);

--
-- Índices para tabela `historico_manejo`
--
ALTER TABLE `historico_manejo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_historico_manejo_pasto1_idx` (`pasto_id_origem`),
  ADD KEY `fk_historico_manejo_pasto2_idx` (`pasto_id_destino`),
  ADD KEY `fk_historico_manejo_lote1_idx` (`lote_id`),
  ADD KEY `fk_historico_manejo_pessoa1_idx` (`pessoa_id_operador`);

--
-- Índices para tabela `historico_sanitario`
--
ALTER TABLE `historico_sanitario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sanitario_animal` (`animal_id`),
  ADD KEY `fk_sanitario_vacina` (`vacina_id`),
  ADD KEY `fk_historico_sanitario_pessoa1_idx` (`pessoa_id_veterinario`);

--
-- Índices para tabela `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `papel`
--
ALTER TABLE `papel`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `papel_permissao`
--
ALTER TABLE `papel_permissao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_papel_perm_papel` (`papel_id`),
  ADD KEY `fk_papel_perm_perm` (`permissao_id`);

--
-- Índices para tabela `pasto`
--
ALTER TABLE `pasto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pasto_pessoa1_idx` (`pessoa_id`);

--
-- Índices para tabela `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pesagem`
--
ALTER TABLE `pesagem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pesagem_animal` (`animal_id`),
  ADD KEY `fk_pesagem_pessoa1_idx` (`pessoa_id`);

--
-- Índices para tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pessoa_usuario1_idx` (`usuario_id`);

--
-- Índices para tabela `raca`
--
ALTER TABLE `raca`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Índices para tabela `usuario_papel`
--
ALTER TABLE `usuario_papel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_papel_user` (`usuario_id`),
  ADD KEY `fk_user_papel_papel` (`papel_id`);

--
-- Índices para tabela `vacina`
--
ALTER TABLE `vacina`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `animal`
--
ALTER TABLE `animal`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_manejo`
--
ALTER TABLE `historico_manejo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_sanitario`
--
ALTER TABLE `historico_sanitario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `lote`
--
ALTER TABLE `lote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `papel`
--
ALTER TABLE `papel`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `papel_permissao`
--
ALTER TABLE `papel_permissao`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `pasto`
--
ALTER TABLE `pasto`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `permissao`
--
ALTER TABLE `permissao`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `pesagem`
--
ALTER TABLE `pesagem`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `raca`
--
ALTER TABLE `raca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuario_papel`
--
ALTER TABLE `usuario_papel`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `vacina`
--
ALTER TABLE `vacina`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `fk_animal_lote` FOREIGN KEY (`lote_id`) REFERENCES `lote` (`id`),
  ADD CONSTRAINT `fk_animal_raca` FOREIGN KEY (`raca_id`) REFERENCES `raca` (`id`);

--
-- Limitadores para a tabela `historico_manejo`
--
ALTER TABLE `historico_manejo`
  ADD CONSTRAINT `fk_historico_manejo_lote1` FOREIGN KEY (`lote_id`) REFERENCES `lote` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historico_manejo_pasto1` FOREIGN KEY (`pasto_id_origem`) REFERENCES `pasto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historico_manejo_pasto2` FOREIGN KEY (`pasto_id_destino`) REFERENCES `pasto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historico_manejo_pessoa1` FOREIGN KEY (`pessoa_id_operador`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `historico_sanitario`
--
ALTER TABLE `historico_sanitario`
  ADD CONSTRAINT `fk_historico_sanitario_pessoa1` FOREIGN KEY (`pessoa_id_veterinario`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sanitario_animal` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  ADD CONSTRAINT `fk_sanitario_vacina` FOREIGN KEY (`vacina_id`) REFERENCES `vacina` (`id`);

--
-- Limitadores para a tabela `papel_permissao`
--
ALTER TABLE `papel_permissao`
  ADD CONSTRAINT `fk_papel_perm_papel` FOREIGN KEY (`papel_id`) REFERENCES `papel` (`id`),
  ADD CONSTRAINT `fk_papel_perm_perm` FOREIGN KEY (`permissao_id`) REFERENCES `permissao` (`id`);

--
-- Limitadores para a tabela `pasto`
--
ALTER TABLE `pasto`
  ADD CONSTRAINT `fk_pasto_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pesagem`
--
ALTER TABLE `pesagem`
  ADD CONSTRAINT `fk_pesagem_animal` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  ADD CONSTRAINT `fk_pesagem_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD CONSTRAINT `fk_pessoa_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario_papel`
--
ALTER TABLE `usuario_papel`
  ADD CONSTRAINT `fk_user_papel_papel` FOREIGN KEY (`papel_id`) REFERENCES `papel` (`id`),
  ADD CONSTRAINT `fk_user_papel_user` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
