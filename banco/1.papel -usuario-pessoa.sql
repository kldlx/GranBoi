-- SELECT * FROM granboi_db.papel;

use granboi_db;


insert into papel values 
(1, 'Administrador', 'Administrador do sistema'),
(2, 'Gestor', 'Gestão das operações'),
(3, 'Veterinário', 'Profissional Veterinário que cuida da saúde do gado'), 
(4, 'Operador', 'Operador do sistema');

/* DML de IAM, Identificação e Controle de Acesso  */

-- 2. Inserir Permissões (Ajustadas para o PHP reconhecer os recursos)
INSERT INTO permissao (id, nome, descricao, recurso, acao) VALUES 
-- Catálogo de Animais
(1, 'Ver Animais', 'Visualiza os eventos cadastrados pelo Organizador','evento', 'listar'),  -- todos
(2, 'Cadastrar Animais', 'Adiciona eventos.', 'evento', 'criar'), -- organizador
(3, 'Editar Animais', 'Altera dados dados dos eventos', 'evento', 'atualizar'), -- organizador
(4, 'Gerenciar Catálogo', 'Gerenciamento dos eventos', 'evento', 'gerenciar'), -- organizador
-- Pesagem
(5, 'Incluir pesagem', 'Inclusão de Colaborador em evento.', 'participante', 'criar'), -- vendedor
(6, 'Minhas Pesagens', 'Vê histórico de particições', 'participante', 'ler_participacoes'), -- cliente
(7, 'Meus Animais', 'Vê avaliações', 'avaliacao', 'ler_avaliacoes_por_evento'),  -- vendedor
(8, 'Todas as Pesagens', 'Vê todas as participações em eventos', 'participacao', 'ler_tudo'), -- gerente
(9, 'Todos os Animais', 'Cancela a participação', 'participacao', 'cancelar'), -- vendedor e gerente
-- Pessoas e Perfis
(10, 'Ver Meu Perfil', 'Acessa próprios dados', 'pessoa', 'ler_proprio'), -- todos
(11, 'Editar Meu Perfil', 'Altera próprios dados', 'pessoa', 'atualizar_proprio'),  -- todos
(12, 'Ver Carteira', 'Acessa dados de todos os clientes', 'pessoa', 'ler_tudo'), -- gerente
(13, 'Acesso completo', 'para suporte do sistema', '*', '*'),
(14, 'Editar Meu Perfil', 'Altera próprios dados', 'pessoa', 'atualizar_proprio'),  -- todos
(15, 'Ver Carteira de Vacinas', 'Acessa dados de todos os clientes', 'pessoa', 'ler_tudo'), -- gerente
(16, 'Acesso completo', 'para suporte do sistema', '*', '*'); -- suporte

-- 3. Ligar Papéis e Permissões (A Mágica do RBAC)
INSERT INTO papel_permissao (papel_id, permissao_id) VALUES 
-- PERMISSÕES GERAIS (Todos os papéis: 1, 2 e 3)
(1, 1), (2, 1), (3, 1),
(1, 13), (2, 13), (3, 13),
(1, 14), (2, 14), (3, 14),
-- PERMISSÕES EXCLUSIVAS DO GERENTE (papel_id = 1)
(1, 2), (1, 3), (1, 4), (1, 8), (1, 10), (1, 11), (1, 15),
-- PERMISSÕES EXCLUSIVAS DO VENDEDOR (papel_id = 2)
(2, 5), (2, 7), (2, 9),
-- PERMISSÕES COMPARTILHADAS (Gerente e Vendedor)
(1, 12), (2, 12),
-- PERMISSÕES EXCLUSIVAS DO CLIENTE (papel_id = 3)
(3, 6),
-- PERMISSÕES EXCLUSIVAS DO SUPORTE (papel_id = 4)
-- (16) Acesso Completo (*.*)
(4, 16);



-- ==============================
-- 1. AUTENTICAÇÃO - As senhas devem ser geradas com password_hash no PHP AuthModel, aqui usamos hashes ilustrativos
INSERT INTO usuario (id, email, senha, nome) VALUES 
(1,'admin@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy', 'Carlos Silva Administrador'), -- senha 123456
(2,'gerente@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy', 'Maria Alves Gerente'),
(3,'veterinario@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy', 'Leticia Correia Veterinário'),
(4,'operador@gmail.com', '$2y$10$nL6KX7Tm8ZKwg8WFb.1gweixcCKPbowEuzV1oW21jlZlz/wADcIuy', 'Jose Usuáro Operador');

-- 2. PESSOAS - ligando pessoa ao usuário (O cadastro detalhado vinculado ao usuário)
INSERT INTO pessoa (id, usuario_id, nome_completo, nome_social, cpf, telefone_movel) VALUES 
(1, 1, 'Carlos Silva Administrador', 'Carlos', '11122233344', '5511999998888'),
(2, 2, 'Maria Alves Gerente', 'Maria', '55566677788', '5511977776666'),
(3, 3, 'Leticia Correia Veterinário', 'Leticia', '99988877766', '5511955554444'),
(4, 4, 'Jose Usuáro Operador', 'Jose', '45685877766', '5511953254414');

-- 6. AUTORIZAÇÃO - dando papel  (A amarração do RBAC) autorização (data_inicio automática)
INSERT INTO usuario_papel (usuario_id, papel_id) VALUES 
(1, 1), -- Carlos é Administrador 
(2, 2), -- Maria é Gerente0 
(3, 3), -- Leticia é Veterinário
(4, 4); -- Operador

INSERT INTO `raca` (`id`, `nome_raca`) VALUES (NULL, 'Nelore'), (NULL, 'Red Angus'),
(NULL, 'Angus Mocho'), (NULL, 'Hereford'),
(NULL, 'Brahman'), (NULL, 'Guzerá'), (NULL, 'Simental'),
(NULL, 'Gir'), (NULL, 'Girolando'), (NULL, 'Jersey');

INSERT INTO `vacina` (`id`, `nome`, `preco_vacina`, `periodo_carencia_dias`) 
VALUES (NULL, 'Febre afitosa', '10', '180'),
(NULL, 'Bucelose', '20', '150'),
(NULL, 'Clostridioses', '30', '120'),
(NULL, 'Raiva', '13', '360');

INSERT INTO `lote` (`id`, `nome_lote`, `descricao`) 
VALUES (NULL, 'NELORE - 500 ANIMAIS', 'Conjunto de 500 Nelore da Fazenda Mariana'), 
(NULL, 'ANGUS - 100 - ANIMAIS PRIMEIRA LINHA', 'Conjunto de 100 Raça ANGUS.');