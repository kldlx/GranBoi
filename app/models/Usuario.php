<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Usuario
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexao::conectar();
    }

    public function logarUsuario($email, $senha)
    {
        $sql = "
            SELECT 
                usuario.id,
                usuario.email,
                usuario.senha,
                usuario.nome,
                pessoa.id AS pessoa_id,
                pessoa.nome_completo,
                papel.id AS papel_id,
                papel.nome AS papel_nome
            FROM usuario
            INNER JOIN pessoa 
                ON pessoa.usuario_id = usuario.id
            INNER JOIN usuario_papel 
                ON usuario_papel.usuario_id = usuario.id
            INNER JOIN papel 
                ON papel.id = usuario_papel.papel_id
            WHERE usuario.email = :email
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            return [
                'sucesso' => false,
                'mensagem' => 'E-mail ou senha inválidos.'
            ];
        }

        if (!password_verify($senha, $usuario['senha'])) {
            return [
                'sucesso' => false,
                'mensagem' => 'E-mail ou senha inválidos.'
            ];
        }

        return [
            'sucesso' => true,
            'usuario' => [
                'id' => $usuario['id'],
                'pessoa_id' => $usuario['pessoa_id'],
                'nome' => $usuario['nome_completo'],
                'email' => $usuario['email'],
                'papel_id' => $usuario['papel_id'],
                'papel' => $this->normalizarPapel($usuario['papel_nome']),
                'papel_nome' => $usuario['papel_nome']
            ]
        ];
    }

    private function normalizarPapel($papelNome)
    {
        $papelNome = mb_strtolower($papelNome, 'UTF-8');

        $mapa = [
            'administrador' => 'administrador',
            'gestor' => 'gestor',
            'veterinário' => 'veterinario',
            'veterinario' => 'veterinario',
            'operador' => 'operador'
        ];

        return $mapa[$papelNome] ?? $papelNome;
    }
}