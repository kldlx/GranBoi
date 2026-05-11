<?php
require_once 'Conexao.php';
// Classe responsável pelo LOGIN do usuário
// Busca dados em 3 tabelas: usuario, usuario_papel e pessoa
class Usuario {
    private $pdo;
    public function __construct()
    {
        $this->pdo = Conexao::conectar();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function logarUsuario($em, $sen)
    {
        // 1) Procura o email na tabela usuario
        $cmd = $this->pdo->prepare("SELECT * FROM usuario WHERE email = :e");
        $cmd->bindValue(":e", $em);
        $cmd->execute();
        if ($cmd->rowCount() == 0) {
            return "email_inexistente";
        }
        // Armazena os dados do usuário encontrado
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        $id_usu = $dados['id'];
        // 2) Busca o papel do usuário na tabela usuario_papel
        $stmt = $this->pdo->prepare("SELECT * FROM usuario_papel WHERE usuario_id = :i");
        $stmt->bindValue(":i", $id_usu);
        $stmt->execute();
        $dados2 = $stmt->fetch(PDO::FETCH_ASSOC);
        // 3) Busca os dados pessoais na tabela pessoa
        $stmt2 = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :i");
        $stmt2->bindValue(":i", $dados['pessoa_id']);
        $stmt2->execute();
        $dados3 = $stmt2->fetch(PDO::FETCH_ASSOC);
        // 4) Verifica a senha com password_verify
        // (compara a senha digitada com o hash salvo no banco)
        if (password_verify($sen, $dados['senha'])) {
            // Senha correta — retorna os 3 arrays de dados
            return [
                'usuario' => $dados,
                'papel'   => $dados2,
                'pessoa'  => $dados3
            ];
        } else {
            return "senha_nao_confere";
        }
    }
}
