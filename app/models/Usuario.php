<?php
require_once 'Conexao.php';
// Classe responsável pelo LOGIN do usuário
// Busca dados em 3 tabelas: usuario, usuario_papel e pessoa
class Usuario {
    private $pdo;
    public function logarUsuario($em, $sen)
{
    $cmd = $this->pdo->prepare("
        SELECT *
        FROM usuario
        WHERE email = :e
        LIMIT 1
    ");

    $cmd->bindValue(":e", $em);
    $cmd->execute();

    if ($cmd->rowCount() == 0) {
        return "email_inexistente";
    }

    $dadosUsuario = $cmd->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($sen, $dadosUsuario['senha'])) {
        return "senha_nao_confere";
    }

    $stmt = $this->pdo->prepare("
        SELECT 
            usuario_papel.papel_id,
            papel.nome AS nome_papel
        FROM usuario_papel
        INNER JOIN papel ON papel.id = usuario_papel.papel_id
        WHERE usuario_papel.usuario_id = :id
        LIMIT 1
    ");

    $stmt->bindValue(":id", $dadosUsuario['id']);
    $stmt->execute();

    $dadosPapel = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt2 = $this->pdo->prepare("
        SELECT *
        FROM pessoa
        WHERE id = :id
        LIMIT 1
    ");

    $stmt2->bindValue(":id", $dadosUsuario['pessoa_id']);
    $stmt2->execute();

    $dadosPessoa = $stmt2->fetch(PDO::FETCH_ASSOC);

    return [
        'usuario' => $dadosUsuario,
        'papel'   => $dadosPapel,
        'pessoa'  => $dadosPessoa
    ];
}