<?php

require_once __DIR__ . '/app/models/conexao.php';

$pdo = Conexao::conectar();

$senhaHash = password_hash('123456', PASSWORD_DEFAULT);

$pdo->beginTransaction();

$cmd = $pdo->prepare("
    INSERT INTO pessoa 
    (nome_completo, nome_social, cpf, telefone_movel, email)
    VALUES 
    ('Administrador', NULL, NULL, NULL, 'admin@granboi.com')
");
$cmd->execute();

$pessoa_id = $pdo->lastInsertId();

$cmd = $pdo->prepare("
    INSERT INTO usuario
    (nome, email, senha, pessoa_id)
    VALUES
    ('Administrador', 'admin@granboi.com', :senha, :pessoa_id)
");
$cmd->execute([
    ':senha' => $senhaHash,
    ':pessoa_id' => $pessoa_id
]);

$usuario_id = $pdo->lastInsertId();

$cmd = $pdo->prepare("
    INSERT INTO usuario_papel
    (usuario_id, papel_id)
    VALUES
    (:usuario_id, 1)
");
$cmd->execute([
    ':usuario_id' => $usuario_id
]);

$pdo->commit();

echo "Administrador criado com sucesso.";