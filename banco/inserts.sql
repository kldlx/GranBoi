USE granboi_db;

-- ==============================
-- PAPÉIS
-- ==============================

INSERT INTO papel (id, nome, descricao) VALUES 
(1, 'Administrador', 'Administrador do sistema'),
(2, 'Gestor', 'Gestão das operações'),
(3, 'Veterinário', 'Profissional Veterinário que cuida da saúde do gado'), 
(4, 'Operador', 'Operador do sistema');

-- ==============================
-- PERMISSÕES
-- ==============================

INSERT INTO permissao (id, nome, descricao, recurso, acao) VALUES 
(1, 'Ver Animais', 'Visualiza os animais cadastrados', 'animal', 'listar'),
(2, 'Cadastrar Animais', 'Cadastra novos animais', 'animal', 'criar'),
(3, 'Editar Animais', 'Altera dados dos animais', 'animal', 'atualizar'),
(4, 'Gerenciar Catálogo', 'Gerencia o catálogo de animais', 'animal', 'gerenciar'),

(5, 'Incluir Pesagem', 'Registra pesagem dos animais', 'pesagem', 'criar'),
(6, 'Minhas Pesagens', 'Visualiza histórico de pesagens', 'pesagem', 'listar'),
(7, 'Meus Animais', 'Visualiza animais cadastrados', 'animal', 'listar_proprio'),
(8, 'Todas as Pesagens', 'Visualiza todas as pesagens registradas', 'pesagem', 'listar_tudo'),
(9, 'Todos os Animais', 'Visualiza todos os animais do sistema', 'animal', 'listar_tudo'),

(10, 'Ver Meu Perfil', 'Acessa os próprios dados', 'pessoa', 'ler_proprio'),
(11, 'Editar Meu Perfil', 'Altera os próprios dados', 'pessoa', 'atualizar_proprio'),
(12, 'Ver Funcionários', 'Visualiza funcionários cadastrados', 'usuario', 'listar'),
(13, 'Acesso Completo', 'Acesso total ao sistema', '*', '*'),
(14, 'Gerenciar Vacinas', 'Gerencia vacinas cadastradas', 'vacina', 'gerenciar'),
(15, 'Ver Carteira de Vacinas', 'Visualiza histórico sanitário dos animais', 'historico_sanitario', 'listar'),
(16, 'Gerenciar Financeiro', 'Acessa e gerencia informações financeiras', 'financeiro', 'gerenciar');

-- ==============================
-- PAPEL X PERMISSÃO
-- ==============================

INSERT INTO papel_permissao (papel_id, permissao_id) VALUES 
-- Administrador
(1, 1), (1, 2), (1, 3), (1, 4),
(1, 5), (1, 6), (1, 7), (1, 8), (1, 9),
(1, 10), (1, 11), (1, 12), (1, 13),
(1, 14), (1, 15), (1, 16),

-- Gestor
(2, 1), (2, 2), (2, 3), (2, 4),
(2, 5), (2, 6), (2, 7), (2, 8), (2, 9),
(2, 10), (2, 11), (2, 12), (2, 14), (2, 15),

-- Veterinário
(3, 1), (3, 5), (3, 6), (3, 9),
(3, 10), (3, 11), (3, 14), (3, 15),

-- Operador
(4, 1), (4, 2), (4, 5), (4, 6), (4, 7),
(4, 10), (4, 11);

-- ==============================
-- USUÁRIOS
-- Senha de todos: 123456
-- ==============================

INSERT INTO usuario (id, nome, email, senha, status) VALUES 
(1, 'Carlos Silva Administrador', 'admin@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy', 'ativo'),
(2, 'Maria Alves Gerente', 'gerente@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy', 'ativo'),
(3, 'Leticia Correia Veterinário', 'veterinario@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy', 'ativo'),
(4, 'Jose Usuário Operador', 'operador@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy', 'ativo');

-- ==============================
-- PESSOAS
-- ==============================

INSERT INTO pessoa (id, usuario_id, nome_completo, nome_social, cpf, telefone_movel, email) VALUES 
(1, 1, 'Carlos Silva Administrador', 'Carlos', '11122233344', '5511999998888', 'admin@gmail.com'),
(2, 2, 'Maria Alves Gerente', 'Maria', '55566677788', '5511977776666', 'gerente@gmail.com'),
(3, 3, 'Leticia Correia Veterinário', 'Leticia', '99988877766', '5511955554444', 'veterinario@gmail.com'),
(4, 4, 'Jose Usuário Operador', 'Jose', '45685877766', '5511953254414', 'operador@gmail.com');

-- ==============================
-- USUÁRIO X PAPEL
-- ==============================

INSERT INTO usuario_papel (usuario_id, papel_id) VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- ==============================
-- RAÇAS
-- ==============================

INSERT INTO raca (id, nome_raca) VALUES 
(1, 'Nelore'),
(2, 'Red Angus'),
(3, 'Angus Mocho'),
(4, 'Hereford'),
(5, 'Brahman'),
(6, 'Guzerá'),
(7, 'Simental'),
(8, 'Gir'),
(9, 'Girolando'),
(10, 'Jersey');

-- ==============================
-- VACINAS
-- ==============================

INSERT INTO vacina (id, nome, preco_vacina, periodo_carencia_dias) VALUES 
(1, 'Febre Aftosa', 10.00, 180),
(2, 'Brucelose', 20.00, 150),
(3, 'Clostridioses', 30.00, 120),
(4, 'Raiva', 13.00, 360),
(5, 'Leptospirose', 18.00, 180),
(6, 'IBR/BVD', 35.00, 210);

-- ==============================
-- LOTES
-- Sem data_inicio por enquanto
-- ==============================

INSERT INTO lote (id, nome_lote, descricao) VALUES 
(1, 'LOTE NELORE 01', 'Lote principal com animais Nelore para engorda'),
(2, 'LOTE ANGUS 01', 'Lote com animais Angus de primeira linha'),
(3, 'LOTE MISTO 01', 'Lote com animais de raças variadas para demonstração'),
(4, 'LOTE LEITEIRO 01', 'Lote com animais Girolando e Jersey');

-- ==============================
-- ANIMAIS PARA DEMONSTRAÇÃO
-- ==============================

INSERT INTO animal (
  id,
  brinco_identificador,
  raca_id,
  lote_id,
  data_nascimento,
  sexo,
  peso_entrada,
  chip,
  peso_saida,
  valor_venda,
  status
) VALUES
(1, 'GB001', 1, 1, '2024-01-15', 'M', 320.00, 'CHIP-GB001', 0.000, 0.00, 'Ativo'),
(2, 'GB002', 1, 1, '2024-02-10', 'M', 305.00, 'CHIP-GB002', 0.000, 0.00, 'Ativo'),
(3, 'GB003', 1, 1, '2023-12-20', 'F', 290.00, 'CHIP-GB003', 0.000, 0.00, 'Ativo'),

(4, 'GB004', 2, 2, '2024-03-05', 'M', 340.00, 'CHIP-GB004', 0.000, 0.00, 'Ativo'),
(5, 'GB005', 3, 2, '2024-01-28', 'M', 355.00, 'CHIP-GB005', 0.000, 0.00, 'Ativo'),
(6, 'GB006', 4, 2, '2023-11-12', 'F', 310.00, 'CHIP-GB006', 0.000, 0.00, 'Ativo'),

(7, 'GB007', 5, 3, '2024-04-18', 'M', 275.00, 'CHIP-GB007', 0.000, 0.00, 'Ativo'),
(8, 'GB008', 6, 3, '2024-02-22', 'F', 285.00, 'CHIP-GB008', 0.000, 0.00, 'Ativo'),
(9, 'GB009', 7, 3, '2023-10-30', 'M', 365.00, 'CHIP-GB009', 0.000, 0.00, 'Ativo'),

(10, 'GB010', 9, 4, '2024-01-08', 'F', 260.00, 'CHIP-GB010', 0.000, 0.00, 'Ativo'),
(11, 'GB011', 10, 4, '2024-03-19', 'F', 230.00, 'CHIP-GB011', 0.000, 0.00, 'Ativo'),
(12, 'GB012', 8, 4, '2023-09-25', 'M', 300.00, 'CHIP-GB012', 0.000, 0.00, 'Ativo');

-- ==============================
-- PESAGENS PARA DEMONSTRAÇÃO
-- pessoa_id = funcionário responsável pelo registro
-- ==============================

INSERT INTO pesagem (animal_id, peso, data_pesagem, observacao, pessoa_id) VALUES
(1, 320.00, '2026-03-01 08:00:00', 'Peso inicial registrado no sistema', 4),
(1, 348.50, '2026-04-01 08:15:00', 'Animal apresentou bom ganho de peso', 4),
(1, 376.00, '2026-05-01 08:10:00', 'Evolução positiva para demonstração', 4),

(2, 305.00, '2026-03-01 08:20:00', 'Peso inicial registrado no sistema', 4),
(2, 331.00, '2026-04-01 08:30:00', 'Ganho dentro do esperado', 4),
(2, 359.00, '2026-05-01 08:25:00', 'Animal em desenvolvimento', 4),

(4, 340.00, '2026-03-05 09:00:00', 'Peso inicial do lote Angus', 4),
(4, 372.00, '2026-04-05 09:10:00', 'Bom desempenho no lote', 4),
(4, 401.50, '2026-05-05 09:05:00', 'Animal próximo da meta de peso', 4),

(7, 275.00, '2026-03-10 10:00:00', 'Peso inicial do lote misto', 4),
(7, 298.00, '2026-04-10 10:15:00', 'Ganho moderado', 4),
(7, 322.00, '2026-05-10 10:20:00', 'Evolução registrada', 4),

(10, 260.00, '2026-03-12 07:40:00', 'Animal do lote leiteiro', 4),
(10, 279.00, '2026-04-12 07:45:00', 'Ganho regular', 4),
(10, 296.00, '2026-05-12 07:50:00', 'Pesagem para acompanhamento', 4);

-- ==============================
-- HISTÓRICO SANITÁRIO PARA DEMONSTRAÇÃO
-- pessoa_id_veterinario = 3
-- ==============================

INSERT INTO historico_sanitario (
  animal_id,
  vacina_id,
  data_aplicacao,
  dose,
  proxima_dose,
  preco_custo_sanitario,
  pessoa_id_veterinario
) VALUES
(1, 1, '2026-03-15', 5.000, '2026-09-15', 10.00, 3),
(2, 1, '2026-03-15', 5.000, '2026-09-15', 10.00, 3),
(3, 3, '2026-03-20', 4.000, '2026-07-20', 30.00, 3),
(4, 2, '2026-04-01', 5.000, '2026-09-01', 20.00, 3),
(5, 4, '2026-04-08', 5.000, '2027-04-08', 13.00, 3),
(7, 5, '2026-04-12', 5.000, '2026-10-12', 18.00, 3),
(10, 6, '2026-04-20', 5.000, '2026-11-20', 35.00, 3);