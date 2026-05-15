<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Usuario
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexao::conectar();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function logarUsuario($email, $senha)
    {
        $sql = "
            SELECT 
                usuario.id,
                usuario.email,
                usuario.senha,
                usuario.nome,
                usuario.status,
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

        $stmt->execute([
            ':email' => $email
        ]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            return [
                'sucesso' => false,
                'mensagem' => 'E-mail ou senha inválidos.'
            ];
        }

        if (strtolower($usuario['status'] ?? '') !== 'ativo') {
            return [
                'sucesso' => false,
                'mensagem' => 'Usuário inativo. Procure o administrador do sistema.'
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
                'papel_nome' => $usuario['papel_nome'],
                'status' => $usuario['status']
            ]
        ];
    }

    public function listarTodos()
    {
        $sql = "
            SELECT 
                usuario.id,
                usuario.nome,
                usuario.email,
                usuario.status,
                pessoa.id AS pessoa_id,
                pessoa.nome_completo,
                pessoa.nome_social,
                pessoa.cpf,
                pessoa.telefone_movel,
                papel.id AS papel_id,
                papel.nome AS papel_nome
            FROM usuario
            INNER JOIN pessoa
                ON pessoa.usuario_id = usuario.id
            INNER JOIN usuario_papel
                ON usuario_papel.usuario_id = usuario.id
            INNER JOIN papel
                ON papel.id = usuario_papel.papel_id
            ORDER BY 
                CASE WHEN usuario.status = 'ativo' THEN 0 ELSE 1 END,
                pessoa.nome_completo ASC
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPapeis()
    {
        $sql = "
            SELECT id, nome, descricao
            FROM papel
            ORDER BY 
                CASE 
                    WHEN LOWER(nome) = 'administrador' THEN 1
                    WHEN LOWER(nome) = 'gestor' THEN 2
                    WHEN LOWER(nome) IN ('veterinário', 'veterinario') THEN 3
                    WHEN LOWER(nome) = 'operador' THEN 4
                    ELSE 5
                END,
                nome ASC
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "
            SELECT 
                usuario.id,
                usuario.nome,
                usuario.email,
                usuario.status,
                pessoa.id AS pessoa_id,
                pessoa.nome_completo,
                pessoa.nome_social,
                pessoa.cpf,
                pessoa.telefone_movel,
                papel.id AS papel_id,
                papel.nome AS papel_nome
            FROM usuario
            INNER JOIN pessoa
                ON pessoa.usuario_id = usuario.id
            INNER JOIN usuario_papel
                ON usuario_papel.usuario_id = usuario.id
            INNER JOIN papel
                ON papel.id = usuario_papel.papel_id
            WHERE usuario.id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExiste($email, $idIgnorar = null)
    {
        $sql = "
            SELECT id
            FROM usuario
            WHERE email = :email
        ";

        $params = [
            ':email' => $email
        ];

        if (!empty($idIgnorar)) {
            $sql .= " AND id != :id";
            $params[':id'] = $idIgnorar;
        }

        $sql .= " LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function cpfExiste($cpf, $usuarioIdIgnorar = null)
    {
        $sql = "
            SELECT pessoa.id
            FROM pessoa
            WHERE pessoa.cpf = :cpf
        ";

        $params = [
            ':cpf' => $this->limparCpf($cpf)
        ];

        if (!empty($usuarioIdIgnorar)) {
            $sql .= " AND pessoa.usuario_id != :usuario_id";
            $params[':usuario_id'] = $usuarioIdIgnorar;
        }

        $sql .= " LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function salvar($dados)
    {
        $this->pdo->beginTransaction();

        try {
            $nomeCompleto = trim($dados['nome_completo'] ?? '');
            $email = trim($dados['email'] ?? '');
            $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);

            $sqlUsuario = "
                INSERT INTO usuario
                    (nome, email, senha, status)
                VALUES
                    (:nome, :email, :senha, 'ativo')
            ";

            $stmtUsuario = $this->pdo->prepare($sqlUsuario);

            $stmtUsuario->execute([
                ':nome' => $nomeCompleto,
                ':email' => $email,
                ':senha' => $senhaHash
            ]);

            $usuarioId = $this->pdo->lastInsertId();

            $sqlPessoa = "
                INSERT INTO pessoa
                    (
                        nome_completo,
                        nome_social,
                        cpf,
                        telefone_movel,
                        email,
                        usuario_id
                    )
                VALUES
                    (
                        :nome_completo,
                        :nome_social,
                        :cpf,
                        :telefone_movel,
                        :email,
                        :usuario_id
                    )
            ";

            $stmtPessoa = $this->pdo->prepare($sqlPessoa);

            $stmtPessoa->execute([
                ':nome_completo' => $nomeCompleto,
                ':nome_social' => !empty($dados['nome_social']) ? trim($dados['nome_social']) : null,
                ':cpf' => !empty($dados['cpf']) ? $this->limparCpf($dados['cpf']) : null,
                ':telefone_movel' => !empty($dados['telefone']) ? $this->limparTelefone($dados['telefone']) : null,
                ':email' => $email,
                ':usuario_id' => $usuarioId
            ]);

            $sqlPapel = "
                INSERT INTO usuario_papel
                    (usuario_id, papel_id)
                VALUES
                    (:usuario_id, :papel_id)
            ";

            $stmtPapel = $this->pdo->prepare($sqlPapel);

            $stmtPapel->execute([
                ':usuario_id' => $usuarioId,
                ':papel_id' => $dados['papel_id']
            ]);

            $this->pdo->commit();

            return $usuarioId;

        } catch (Exception $e) {
            $this->pdo->rollBack();

            throw $e;
        }
    }

    public function atualizar($dados)
    {
        $this->pdo->beginTransaction();

        try {
            $usuarioId = $dados['id'];
            $nomeCompleto = trim($dados['nome_completo'] ?? '');
            $email = trim($dados['email'] ?? '');
            $status = !empty($dados['status']) ? strtolower(trim($dados['status'])) : 'ativo';

            $sqlUsuario = "
                UPDATE usuario
                SET 
                    nome = :nome,
                    email = :email,
                    status = :status
            ";

            $paramsUsuario = [
                ':id' => $usuarioId,
                ':nome' => $nomeCompleto,
                ':email' => $email,
                ':status' => $status
            ];

            if (!empty($dados['senha'])) {
                $sqlUsuario .= ", senha = :senha";
                $paramsUsuario[':senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
            }

            $sqlUsuario .= " WHERE id = :id";

            $stmtUsuario = $this->pdo->prepare($sqlUsuario);

            $stmtUsuario->execute($paramsUsuario);

            $sqlPessoa = "
                UPDATE pessoa
                SET 
                    nome_completo = :nome_completo,
                    nome_social = :nome_social,
                    cpf = :cpf,
                    telefone_movel = :telefone_movel,
                    email = :email
                WHERE usuario_id = :usuario_id
            ";

            $stmtPessoa = $this->pdo->prepare($sqlPessoa);

            $stmtPessoa->execute([
                ':usuario_id' => $usuarioId,
                ':nome_completo' => $nomeCompleto,
                ':nome_social' => !empty($dados['nome_social']) ? trim($dados['nome_social']) : null,
                ':cpf' => !empty($dados['cpf']) ? $this->limparCpf($dados['cpf']) : null,
                ':telefone_movel' => !empty($dados['telefone']) ? $this->limparTelefone($dados['telefone']) : null,
                ':email' => $email
            ]);

            $sqlAtualizarPapel = "
                UPDATE usuario_papel
                SET papel_id = :papel_id
                WHERE usuario_id = :usuario_id
            ";

            $stmtPapel = $this->pdo->prepare($sqlAtualizarPapel);

            $stmtPapel->execute([
                ':usuario_id' => $usuarioId,
                ':papel_id' => $dados['papel_id']
            ]);

            $this->pdo->commit();

            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();

            throw $e;
        }
    }

    public function desativar($id)
    {
        $sql = "
            UPDATE usuario
            SET status = 'inativo'
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function reativar($id)
    {
        $sql = "
            UPDATE usuario
            SET status = 'ativo'
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
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

    private function limparCpf($cpf)
    {
        return preg_replace('/\D/', '', $cpf);
    }

    private function limparTelefone($telefone)
    {
        return preg_replace('/\D/', '', $telefone);
    }
}