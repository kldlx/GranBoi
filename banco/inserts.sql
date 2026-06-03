USE `granboi_db`;

START TRANSACTION;

-- =====================================================
-- PAPÉIS
-- =====================================================

INSERT INTO papel (
  nome,
  descricao
) VALUES
('Administrador', 'Dono da fazenda e administrador geral do sistema'),
('Gestor', 'Responsável pela gestão operacional da fazenda'),
('Veterinário', 'Profissional responsável pela sanidade, vacinas e acompanhamento dos animais'),
('Operador', 'Funcionário responsável por cadastros, pesagens e manejos do rebanho');

-- =====================================================
-- PERMISSÕES
-- =====================================================

INSERT INTO permissao (
  nome,
  descricao,
  recurso,
  acao
) VALUES
('Acessar Dashboard', 'Permite visualizar o painel principal', 'dashboard', 'listar'),

('Ver Animais', 'Permite visualizar animais cadastrados', 'animal', 'listar'),
('Cadastrar Animais', 'Permite cadastrar novos animais', 'animal', 'criar'),
('Editar Animais', 'Permite alterar dados dos animais', 'animal', 'editar'),
('Excluir Animais', 'Permite excluir ou inativar animais', 'animal', 'excluir'),

('Ver Pesagens', 'Permite visualizar pesagens', 'pesagem', 'listar'),
('Cadastrar Pesagens', 'Permite registrar novas pesagens', 'pesagem', 'criar'),
('Editar Pesagens', 'Permite alterar registros de pesagem', 'pesagem', 'editar'),
('Excluir Pesagens', 'Permite remover registros de pesagem', 'pesagem', 'excluir'),

('Ver Vacinações', 'Permite visualizar histórico sanitário', 'vacinacao', 'listar'),
('Cadastrar Vacinações', 'Permite registrar aplicações de vacina', 'vacinacao', 'criar'),
('Editar Vacinações', 'Permite alterar registros sanitários', 'vacinacao', 'editar'),
('Excluir Vacinações', 'Permite remover registros sanitários', 'vacinacao', 'excluir'),

('Ver Relatórios', 'Permite visualizar relatórios da fazenda', 'relatorio', 'listar'),

('Ver Financeiro', 'Permite visualizar despesas e movimentações financeiras', 'financeiro', 'listar'),
('Cadastrar Despesas', 'Permite cadastrar despesas financeiras', 'financeiro', 'criar'),
('Editar Despesas', 'Permite editar despesas financeiras', 'financeiro', 'editar'),
('Excluir Despesas', 'Permite excluir despesas financeiras', 'financeiro', 'excluir'),

('Ver Funcionários', 'Permite visualizar funcionários do sistema', 'usuario', 'listar'),
('Cadastrar Funcionários', 'Permite cadastrar funcionários', 'usuario', 'criar'),
('Editar Funcionários', 'Permite editar funcionários', 'usuario', 'editar'),
('Excluir Funcionários', 'Permite excluir ou inativar funcionários', 'usuario', 'excluir'),

('Ver Raças', 'Permite visualizar raças cadastradas', 'raca', 'listar'),
('Cadastrar Raças', 'Permite cadastrar raças', 'raca', 'criar'),
('Editar Raças', 'Permite editar raças', 'raca', 'editar'),
('Excluir Raças', 'Permite excluir raças', 'raca', 'excluir'),

('Ver Lotes', 'Permite visualizar lotes cadastrados', 'lote', 'listar'),
('Cadastrar Lotes', 'Permite cadastrar lotes', 'lote', 'criar'),
('Editar Lotes', 'Permite editar lotes', 'lote', 'editar'),
('Excluir Lotes', 'Permite excluir lotes', 'lote', 'excluir');

-- =====================================================
-- PAPEL_PERMISSAO
-- =====================================================

-- Administrador: tudo
INSERT INTO papel_permissao (
  papel_id,
  permissao_id
)
SELECT
  (SELECT id FROM papel WHERE nome = 'Administrador'),
  permissao.id
FROM permissao;

-- Gestor: tudo menos financeiro completo de exclusão e sem exclusão de funcionário
INSERT INTO papel_permissao (
  papel_id,
  permissao_id
)
SELECT
  (SELECT id FROM papel WHERE nome = 'Gestor'),
  permissao.id
FROM permissao
WHERE recurso IN (
  'dashboard',
  'animal',
  'pesagem',
  'vacinacao',
  'relatorio',
  'usuario',
  'raca',
  'lote'
)
AND NOT (recurso = 'usuario' AND acao = 'excluir');

-- Veterinário: visualiza animais, registra vacinações e acompanha pesagens
INSERT INTO papel_permissao (
  papel_id,
  permissao_id
)
SELECT
  (SELECT id FROM papel WHERE nome = 'Veterinário'),
  permissao.id
FROM permissao
WHERE
  recurso = 'dashboard'
  OR recurso = 'relatorio'
  OR (recurso = 'animal' AND acao = 'listar')
  OR (recurso = 'pesagem' AND acao = 'listar')
  OR (recurso = 'vacinacao' AND acao IN ('listar', 'criar', 'editar'));

-- Operador: rotina de campo
INSERT INTO papel_permissao (
  papel_id,
  permissao_id
)
SELECT
  (SELECT id FROM papel WHERE nome = 'Operador'),
  permissao.id
FROM permissao
WHERE
  recurso = 'dashboard'
  OR (recurso = 'animal' AND acao IN ('listar', 'criar', 'editar'))
  OR (recurso = 'pesagem' AND acao IN ('listar', 'criar'))
  OR (recurso = 'relatorio' AND acao = 'listar');

-- =====================================================
-- USUÁRIOS
-- Senha cadastrada como hash.
-- Se seu sistema usa password_verify(), mantenha hash.
-- =====================================================

INSERT INTO usuario (
  nome,
  email,
  senha,
  status
) VALUES
('Roberto Almeida', 'admin@granboi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'ativo'),
('Carlos Henrique Souza', 'gestor@granboi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'ativo'),
('Mariana Lopes Ferreira', 'veterinario@granboi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'ativo'),
('João Batista Lima', 'operador@granboi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'ativo'),
('Ana Paula Martins', 'ana.operadora@granboi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'ativo'),
('Pedro Nunes Carvalho', 'pedro.campo@granboi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'ativo'),
('Lucas Vieira Prado', 'lucas.inativo@granboi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'inativo');

-- =====================================================
-- PESSOAS
-- =====================================================

INSERT INTO pessoa (
  nome_completo,
  nome_social,
  cpf,
  telefone_movel,
  email,
  usuario_id
) VALUES
('Roberto Almeida', NULL, '11122233301', '5561999000001', 'admin@granboi.com', (SELECT id FROM usuario WHERE email = 'admin@granboi.com')),
('Carlos Henrique Souza', NULL, '11122233302', '5561999000002', 'gestor@granboi.com', (SELECT id FROM usuario WHERE email = 'gestor@granboi.com')),
('Mariana Lopes Ferreira', 'Dra. Mariana', '11122233303', '5561999000003', 'veterinario@granboi.com', (SELECT id FROM usuario WHERE email = 'veterinario@granboi.com')),
('João Batista Lima', NULL, '11122233304', '5561999000004', 'operador@granboi.com', (SELECT id FROM usuario WHERE email = 'operador@granboi.com')),
('Ana Paula Martins', NULL, '11122233305', '5561999000005', 'ana.operadora@granboi.com', (SELECT id FROM usuario WHERE email = 'ana.operadora@granboi.com')),
('Pedro Nunes Carvalho', NULL, '11122233306', '5561999000006', 'pedro.campo@granboi.com', (SELECT id FROM usuario WHERE email = 'pedro.campo@granboi.com')),
('Lucas Vieira Prado', NULL, '11122233307', '5561999000007', 'lucas.inativo@granboi.com', (SELECT id FROM usuario WHERE email = 'lucas.inativo@granboi.com'));

-- =====================================================
-- USUÁRIO_PAPEL
-- =====================================================

INSERT INTO usuario_papel (
  usuario_id,
  papel_id
) VALUES
((SELECT id FROM usuario WHERE email = 'admin@granboi.com'), (SELECT id FROM papel WHERE nome = 'Administrador')),
((SELECT id FROM usuario WHERE email = 'gestor@granboi.com'), (SELECT id FROM papel WHERE nome = 'Gestor')),
((SELECT id FROM usuario WHERE email = 'veterinario@granboi.com'), (SELECT id FROM papel WHERE nome = 'Veterinário')),
((SELECT id FROM usuario WHERE email = 'operador@granboi.com'), (SELECT id FROM papel WHERE nome = 'Operador')),
((SELECT id FROM usuario WHERE email = 'ana.operadora@granboi.com'), (SELECT id FROM papel WHERE nome = 'Operador')),
((SELECT id FROM usuario WHERE email = 'pedro.campo@granboi.com'), (SELECT id FROM papel WHERE nome = 'Operador')),
((SELECT id FROM usuario WHERE email = 'lucas.inativo@granboi.com'), (SELECT id FROM papel WHERE nome = 'Operador'));

-- =====================================================
-- RAÇAS
-- =====================================================

INSERT INTO raca (
  nome_raca
) VALUES
('Nelore'),
('Angus'),
('Brahman'),
('Tabapuã'),
('Guzerá'),
('Senepol'),
('Hereford'),
('Gir'),
('Girolando'),
('Cruzado');

-- =====================================================
-- LOTES
-- =====================================================

INSERT INTO lote (
  nome_lote,
  descricao
) VALUES
('Lote A - Recria', 'Animais jovens em desenvolvimento e ganho inicial de peso'),
('Lote B - Engorda', 'Animais em fase de terminação para venda futura'),
('Lote C - Matrizes', 'Fêmeas adultas destinadas à reprodução e cria'),
('Lote D - Bezerros', 'Bezerros recém-desmamados em acompanhamento'),
('Lote E - Venda', 'Animais próximos do peso ideal de venda'),
('Lote F - Observação', 'Animais separados para acompanhamento sanitário ou manejo especial');

-- =====================================================
-- VACINAS
-- =====================================================

INSERT INTO vacina (
  nome,
  preco_vacina,
  periodo_carencia_dias
) VALUES
('Febre Aftosa', 4.50, 15),
('Brucelose', 8.90, 30),
('Raiva Bovina', 6.75, 21),
('Clostridiose', 7.20, 14),
('Leptospirose', 9.50, 21),
('IBR/BVD', 12.00, 30),
('Vermífugo', 5.80, 7),
('Carbúnculo Sintomático', 6.40, 14),
('Botulismo', 10.30, 21),
('Complexo Respiratório Bovino', 13.75, 28);

-- =====================================================
-- ANIMAIS
-- =====================================================

INSERT INTO animal (
  brinco_identificador,
  raca_id,
  lote_id,
  data_nascimento,
  sexo,
  peso_entrada,
  chip,
  data_compra,
  valor_compra,
  data_venda,
  peso_saida,
  valor_venda,
  status
) VALUES
('GB-0001', (SELECT id FROM raca WHERE nome_raca = 'Nelore'), (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), '2023-01-15', 'M', 210.50, 'CHIP0001', '2023-08-10', 2800.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0002', (SELECT id FROM raca WHERE nome_raca = 'Angus'), (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), '2022-11-20', 'M', 275.00, 'CHIP0002', '2023-07-15', 3500.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0003', (SELECT id FROM raca WHERE nome_raca = 'Brahman'), (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), '2022-09-05', 'M', 300.00, 'CHIP0003', '2023-06-05', 3900.00, '2024-05-20', 485.000, 6200.00, 'Vendido'),
('GB-0004', (SELECT id FROM raca WHERE nome_raca = 'Tabapuã'), (SELECT id FROM lote WHERE nome_lote = 'Lote C - Matrizes'), '2021-03-18', 'F', 330.00, 'CHIP0004', '2023-04-12', 4200.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0005', (SELECT id FROM raca WHERE nome_raca = 'Nelore'), (SELECT id FROM lote WHERE nome_lote = 'Lote D - Bezerros'), '2024-01-10', 'F', 145.00, 'CHIP0005', '2024-03-01', 1800.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0006', (SELECT id FROM raca WHERE nome_raca = 'Senepol'), (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), '2023-05-02', 'M', 225.00, 'CHIP0006', '2023-10-11', 3100.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0007', (SELECT id FROM raca WHERE nome_raca = 'Hereford'), (SELECT id FROM lote WHERE nome_lote = 'Lote E - Venda'), '2022-02-22', 'M', 320.00, 'CHIP0007', '2023-02-14', 4300.00, '2024-06-18', 510.000, 6800.00, 'Vendido'),
('GB-0008', (SELECT id FROM raca WHERE nome_raca = 'Guzerá'), (SELECT id FROM lote WHERE nome_lote = 'Lote F - Observação'), '2023-07-30', 'F', 190.00, 'CHIP0008', '2023-12-05', 2600.00, NULL, 0.000, 0.00, 'Perda'),
('GB-0009', (SELECT id FROM raca WHERE nome_raca = 'Girolando'), (SELECT id FROM lote WHERE nome_lote = 'Lote C - Matrizes'), '2021-12-12', 'F', 360.00, 'CHIP0009', '2023-01-25', 4600.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0010', (SELECT id FROM raca WHERE nome_raca = 'Cruzado'), (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), '2023-04-08', 'M', 205.00, 'CHIP0010', '2023-09-19', 2900.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0011', (SELECT id FROM raca WHERE nome_raca = 'Nelore'), (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), '2022-08-14', 'M', 295.00, 'CHIP0011', '2023-05-20', 3700.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0012', (SELECT id FROM raca WHERE nome_raca = 'Angus'), (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), '2022-10-03', 'M', 310.00, 'CHIP0012', '2023-06-18', 4100.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0013', (SELECT id FROM raca WHERE nome_raca = 'Brahman'), (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), '2023-02-19', 'F', 215.00, 'CHIP0013', '2023-09-02', 2950.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0014', (SELECT id FROM raca WHERE nome_raca = 'Tabapuã'), (SELECT id FROM lote WHERE nome_lote = 'Lote D - Bezerros'), '2024-02-01', 'M', 132.00, 'CHIP0014', '2024-04-07', 1650.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0015', (SELECT id FROM raca WHERE nome_raca = 'Guzerá'), (SELECT id FROM lote WHERE nome_lote = 'Lote C - Matrizes'), '2021-09-11', 'F', 375.00, 'CHIP0015', '2023-03-11', 4800.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0016', (SELECT id FROM raca WHERE nome_raca = 'Senepol'), (SELECT id FROM lote WHERE nome_lote = 'Lote E - Venda'), '2022-04-17', 'M', 340.00, 'CHIP0016', '2023-01-09', 4550.00, '2024-07-22', 530.000, 7100.00, 'Vendido'),
('GB-0017', (SELECT id FROM raca WHERE nome_raca = 'Hereford'), (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), '2023-06-09', 'F', 198.00, 'CHIP0017', '2023-11-15', 2750.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0018', (SELECT id FROM raca WHERE nome_raca = 'Girolando'), (SELECT id FROM lote WHERE nome_lote = 'Lote C - Matrizes'), '2020-12-28', 'F', 390.00, 'CHIP0018', '2022-12-10', 5100.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0019', (SELECT id FROM raca WHERE nome_raca = 'Cruzado'), (SELECT id FROM lote WHERE nome_lote = 'Lote F - Observação'), '2023-03-21', 'M', 220.00, 'CHIP0019', '2023-10-01', 3000.00, NULL, 0.000, 0.00, 'Perda'),
('GB-0020', (SELECT id FROM raca WHERE nome_raca = 'Nelore'), (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), '2022-07-07', 'M', 305.00, 'CHIP0020', '2023-04-23', 3950.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0021', (SELECT id FROM raca WHERE nome_raca = 'Angus'), (SELECT id FROM lote WHERE nome_lote = 'Lote E - Venda'), '2022-01-30', 'M', 355.00, 'CHIP0021', '2023-01-18', 4700.00, '2024-08-14', 545.000, 7350.00, 'Vendido'),
('GB-0022', (SELECT id FROM raca WHERE nome_raca = 'Brahman'), (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), '2023-08-13', 'M', 185.00, 'CHIP0022', '2024-01-04', 2500.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0023', (SELECT id FROM raca WHERE nome_raca = 'Tabapuã'), (SELECT id FROM lote WHERE nome_lote = 'Lote D - Bezerros'), '2024-03-12', 'F', 118.00, 'CHIP0023', '2024-05-02', 1500.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0024', (SELECT id FROM raca WHERE nome_raca = 'Guzerá'), (SELECT id FROM lote WHERE nome_lote = 'Lote C - Matrizes'), '2021-05-24', 'F', 348.00, 'CHIP0024', '2023-02-05', 4450.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0025', (SELECT id FROM raca WHERE nome_raca = 'Senepol'), (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), '2022-12-06', 'M', 285.00, 'CHIP0025', '2023-08-13', 3600.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0026', (SELECT id FROM raca WHERE nome_raca = 'Hereford'), (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), '2022-06-16', 'M', 315.00, 'CHIP0026', '2023-05-08', 4050.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0027', (SELECT id FROM raca WHERE nome_raca = 'Girolando'), (SELECT id FROM lote WHERE nome_lote = 'Lote F - Observação'), '2022-03-09', 'F', 325.00, 'CHIP0027', '2023-01-12', 4300.00, NULL, 0.000, 0.00, 'Perda'),
('GB-0028', (SELECT id FROM raca WHERE nome_raca = 'Cruzado'), (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), '2023-09-18', 'M', 175.00, 'CHIP0028', '2024-01-29', 2400.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0029', (SELECT id FROM raca WHERE nome_raca = 'Nelore'), (SELECT id FROM lote WHERE nome_lote = 'Lote C - Matrizes'), '2020-10-10', 'F', 410.00, 'CHIP0029', '2022-11-20', 5400.00, NULL, 0.000, 0.00, 'Ativo'),
('GB-0030', (SELECT id FROM raca WHERE nome_raca = 'Angus'), (SELECT id FROM lote WHERE nome_lote = 'Lote E - Venda'), '2021-11-05', 'M', 365.00, 'CHIP0030', '2022-12-15', 4900.00, '2024-09-03', 560.000, 7600.00, 'Vendido');

-- =====================================================
-- PASTOS
-- =====================================================

INSERT INTO pasto (
  nome_pasto,
  localizacao,
  custo_mensal,
  capacidade_total,
  quantidade_animais,
  pessoa_id
) VALUES
('Pasto Norte', 'Setor norte da Fazenda Boa Esperança', 1350.00, 90.000, 42.000, (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),
('Pasto Sul', 'Área sul próxima ao córrego', 980.00, 65.000, 31.000, (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
('Pasto Central', 'Área central próxima ao curral principal', 1650.00, 120.000, 58.000, (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),
('Pasto Reserva', 'Área de reserva usada para rotação de pastagem', 750.00, 45.000, 14.000, (SELECT id FROM pessoa WHERE email = 'ana.operadora@granboi.com')),
('Pasto Bezerros', 'Piquete menor destinado aos bezerros', 620.00, 35.000, 18.000, (SELECT id FROM pessoa WHERE email = 'pedro.campo@granboi.com')),
('Pasto Matrizes', 'Área destinada às matrizes e fêmeas adultas', 1450.00, 80.000, 36.000, (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com'));

-- =====================================================
-- PESAGENS
-- =====================================================

INSERT INTO pesagem (
  animal_id,
  peso,
  data_pesagem,
  observacao,
  pessoa_id
) VALUES
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0001'), 210.50, '2023-08-10 08:30:00', 'Peso de entrada após compra', (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0001'), 248.30, '2023-11-10 09:10:00', 'Bom ganho de peso na recria', (SELECT id FROM pessoa WHERE email = 'ana.operadora@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0001'), 286.70, '2024-03-15 08:45:00', 'Animal evoluindo bem', (SELECT id FROM pessoa WHERE email = 'pedro.campo@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0002'), 275.00, '2023-07-15 08:20:00', 'Peso de entrada', (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0002'), 342.80, '2023-12-15 08:50:00', 'Evolução boa em engorda', (SELECT id FROM pessoa WHERE email = 'ana.operadora@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0002'), 398.20, '2024-04-18 10:00:00', 'Próximo da fase de venda', (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0003'), 300.00, '2023-06-05 07:50:00', 'Peso inicial', (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0003'), 410.40, '2023-12-04 08:40:00', 'Boa terminação', (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0003'), 485.00, '2024-05-20 10:15:00', 'Peso final antes da venda', (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0004'), 330.00, '2023-04-12 08:00:00', 'Matriz cadastrada', (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0004'), 368.50, '2023-11-22 09:30:00', 'Matriz em bom estado corporal', (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0005'), 145.00, '2024-03-01 09:25:00', 'Bezerra recém-adquirida', (SELECT id FROM pessoa WHERE email = 'ana.operadora@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0005'), 172.40, '2024-06-10 08:55:00', 'Ganho esperado para bezerra', (SELECT id FROM pessoa WHERE email = 'pedro.campo@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0007'), 320.00, '2023-02-14 08:15:00', 'Entrada no lote de venda', (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0007'), 510.00, '2024-06-18 11:30:00', 'Peso final de venda', (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0016'), 340.00, '2023-01-09 09:30:00', 'Entrada no lote de venda', (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0016'), 530.00, '2024-07-22 10:20:00', 'Animal vendido com bom peso', (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0021'), 355.00, '2023-01-18 09:10:00', 'Animal comprado já pesado', (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0021'), 545.00, '2024-08-14 10:40:00', 'Peso final antes da venda', (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0030'), 365.00, '2022-12-15 08:10:00', 'Entrada em terminação', (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0030'), 560.00, '2024-09-03 11:10:00', 'Vendido com boa margem', (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0019'), 220.00, '2023-10-01 08:00:00', 'Animal colocado em observação', (SELECT id FROM pessoa WHERE email = 'pedro.campo@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0019'), 218.50, '2023-11-15 08:30:00', 'Perda registrada após piora clínica', (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),

((SELECT id FROM animal WHERE brinco_identificador = 'GB-0029'), 410.00, '2022-11-20 09:00:00', 'Matriz adulta cadastrada', (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0029'), 432.00, '2024-04-12 09:45:00', 'Matriz em boa condição', (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com'));

-- =====================================================
-- HISTÓRICO SANITÁRIO / VACINAÇÃO
-- =====================================================

INSERT INTO historico_sanitario (
  animal_id,
  vacina_id,
  data_aplicacao,
  dose,
  proxima_dose,
  preco_custo_sanitario,
  pessoa_id_veterinario
) VALUES
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0001'), (SELECT id FROM vacina WHERE nome = 'Febre Aftosa'), '2024-03-10', 5.000, '2024-09-10', 4.50, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0002'), (SELECT id FROM vacina WHERE nome = 'Raiva Bovina'), '2024-02-15', 5.000, '2025-02-15', 6.75, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0003'), (SELECT id FROM vacina WHERE nome = 'Clostridiose'), '2024-01-20', 5.000, '2024-07-20', 7.20, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0004'), (SELECT id FROM vacina WHERE nome = 'Brucelose'), '2024-04-05', 2.000, NULL, 8.90, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0005'), (SELECT id FROM vacina WHERE nome = 'Vermífugo'), '2024-04-18', 3.000, '2024-07-18', 5.80, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0006'), (SELECT id FROM vacina WHERE nome = 'Leptospirose'), '2024-05-02', 5.000, '2024-11-02', 9.50, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0007'), (SELECT id FROM vacina WHERE nome = 'IBR/BVD'), '2024-03-22', 5.000, '2024-09-22', 12.00, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0008'), (SELECT id FROM vacina WHERE nome = 'Carbúnculo Sintomático'), '2024-01-12', 5.000, '2024-07-12', 6.40, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0009'), (SELECT id FROM vacina WHERE nome = 'Febre Aftosa'), '2024-05-10', 5.000, '2024-11-10', 4.50, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0010'), (SELECT id FROM vacina WHERE nome = 'Vermífugo'), '2024-06-01', 3.000, '2024-09-01', 5.80, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0015'), (SELECT id FROM vacina WHERE nome = 'Botulismo'), '2024-02-08', 5.000, '2025-02-08', 10.30, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0020'), (SELECT id FROM vacina WHERE nome = 'Complexo Respiratório Bovino'), '2024-03-02', 5.000, '2024-09-02', 13.75, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0023'), (SELECT id FROM vacina WHERE nome = 'Vermífugo'), '2024-06-12', 3.000, '2024-09-12', 5.80, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0027'), (SELECT id FROM vacina WHERE nome = 'Leptospirose'), '2024-01-25', 5.000, '2024-07-25', 9.50, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com')),
((SELECT id FROM animal WHERE brinco_identificador = 'GB-0029'), (SELECT id FROM vacina WHERE nome = 'Brucelose'), '2024-04-28', 2.000, NULL, 8.90, (SELECT id FROM pessoa WHERE email = 'veterinario@granboi.com'));

-- =====================================================
-- HISTÓRICO DE MANEJO
-- =====================================================

INSERT INTO historico_manejo (
  data_manejo,
  custo_manejo,
  pasto_id_origem,
  pasto_id_destino,
  lote_id,
  pessoa_id_operador
) VALUES
('2024-02-10', 250.00, (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Norte'), (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Central'), (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
('2024-03-15', 300.00, (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Central'), (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Sul'), (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), (SELECT id FROM pessoa WHERE email = 'ana.operadora@granboi.com')),
('2024-04-20', 180.00, (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Sul'), (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Reserva'), (SELECT id FROM lote WHERE nome_lote = 'Lote F - Observação'), (SELECT id FROM pessoa WHERE email = 'pedro.campo@granboi.com')),
('2024-05-25', 220.00, (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Reserva'), (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Bezerros'), (SELECT id FROM lote WHERE nome_lote = 'Lote D - Bezerros'), (SELECT id FROM pessoa WHERE email = 'ana.operadora@granboi.com')),
('2024-06-08', 275.00, (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Bezerros'), (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Norte'), (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), (SELECT id FROM pessoa WHERE email = 'operador@granboi.com')),
('2024-07-11', 350.00, (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Matrizes'), (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Central'), (SELECT id FROM lote WHERE nome_lote = 'Lote C - Matrizes'), (SELECT id FROM pessoa WHERE email = 'pedro.campo@granboi.com')),
('2024-08-19', 310.00, (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Sul'), (SELECT id FROM pasto WHERE nome_pasto = 'Pasto Central'), (SELECT id FROM lote WHERE nome_lote = 'Lote E - Venda'), (SELECT id FROM pessoa WHERE email = 'gestor@granboi.com'));

-- =====================================================
-- DESPESAS FINANCEIRAS
-- =====================================================

INSERT INTO despesa_financeira (
  descricao,
  categoria,
  valor,
  data_despesa,
  observacao,
  animal_id,
  lote_id,
  usuario_id
) VALUES
('Compra de ração para recria', 'Alimentação', 1250.00, '2024-01-10', 'Ração destinada ao Lote A - Recria', NULL, (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), (SELECT id FROM usuario WHERE email = 'gestor@granboi.com')),
('Suplementação mineral para matrizes', 'Alimentação', 890.00, '2024-01-18', 'Compra de sal mineral para fêmeas adultas', NULL, (SELECT id FROM lote WHERE nome_lote = 'Lote C - Matrizes'), (SELECT id FROM usuario WHERE email = 'gestor@granboi.com')),
('Aplicação de vacina contra febre aftosa', 'Sanidade', 180.00, '2024-03-10', 'Despesa relacionada à vacinação do rebanho', NULL, (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), (SELECT id FROM usuario WHERE email = 'veterinario@granboi.com')),
('Manutenção de cerca do Pasto Norte', 'Infraestrutura', 850.00, '2024-02-18', 'Troca de estacas e arame farpado', NULL, NULL, (SELECT id FROM usuario WHERE email = 'gestor@granboi.com')),
('Consulta veterinária animal GB-0008', 'Sanidade', 320.00, '2024-01-13', 'Animal em observação sanitária', (SELECT id FROM animal WHERE brinco_identificador = 'GB-0008'), (SELECT id FROM lote WHERE nome_lote = 'Lote F - Observação'), (SELECT id FROM usuario WHERE email = 'veterinario@granboi.com')),
('Manejo de transferência de lote', 'Manejo', 250.00, '2024-02-10', 'Custo operacional de movimentação dos animais', NULL, (SELECT id FROM lote WHERE nome_lote = 'Lote A - Recria'), (SELECT id FROM usuario WHERE email = 'operador@granboi.com')),
('Compra de vermífugo', 'Sanidade', 410.00, '2024-04-18', 'Medicamento utilizado nos bezerros', NULL, (SELECT id FROM lote WHERE nome_lote = 'Lote D - Bezerros'), (SELECT id FROM usuario WHERE email = 'veterinario@granboi.com')),
('Serviço de limpeza do curral', 'Mão de obra', 500.00, '2024-05-03', 'Limpeza preventiva das instalações', NULL, NULL, (SELECT id FROM usuario WHERE email = 'gestor@granboi.com')),
('Compra de bebedouro para Pasto Sul', 'Equipamento', 1350.00, '2024-05-15', 'Instalação de bebedouro novo para lote de engorda', NULL, (SELECT id FROM lote WHERE nome_lote = 'Lote B - Engorda'), (SELECT id FROM usuario WHERE email = 'gestor@granboi.com')),
('Reposição de sal proteinado', 'Alimentação', 760.00, '2024-06-07', 'Suplemento usado durante período seco', NULL, (SELECT id FROM lote WHERE nome_lote = 'Lote E - Venda'), (SELECT id FROM usuario WHERE email = 'operador@granboi.com')),
('Tratamento clínico animal GB-0019', 'Sanidade', 280.00, '2023-11-15', 'Atendimento antes do registro de perda', (SELECT id FROM animal WHERE brinco_identificador = 'GB-0019'), (SELECT id FROM lote WHERE nome_lote = 'Lote F - Observação'), (SELECT id FROM usuario WHERE email = 'veterinario@granboi.com')),
('Frete de compra de animais', 'Transporte', 950.00, '2023-08-10', 'Transporte de animais recém-comprados para a fazenda', NULL, NULL, (SELECT id FROM usuario WHERE email = 'admin@granboi.com')),
('Manutenção da balança do curral', 'Equipamento', 680.00, '2024-07-04', 'Ajuste e calibração da balança usada nas pesagens', NULL, NULL, (SELECT id FROM usuario WHERE email = 'gestor@granboi.com')),
('Serviço extra de manejo no curral', 'Mão de obra', 430.00, '2024-08-19', 'Equipe extra para movimentação do lote de venda', NULL, (SELECT id FROM lote WHERE nome_lote = 'Lote E - Venda'), (SELECT id FROM usuario WHERE email = 'gestor@granboi.com'));

COMMIT;