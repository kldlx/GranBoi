<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Lote
{
    private $db;

    public function __construct()
    {
        $this->db = Conexao::conectar();
    }

    public function listarTodos()
    {
        $sql = "SELECT id, nome_lote, descricao
                FROM lote
                ORDER BY nome_lote ASC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT id, nome_lote, descricao
                FROM lote
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function nomeExiste($nome_lote, $idIgnorar = null)
    {
        $sql = "SELECT id
                FROM lote
                WHERE nome_lote = :nome_lote";

        $params = [
            ':nome_lote' => $nome_lote
        ];

        if (!empty($idIgnorar)) {
            $sql .= " AND id != :id";
            $params[':id'] = $idIgnorar;
        }

        $sql .= " LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function salvar($dados)
    {
        $sql = "INSERT INTO lote (nome_lote, descricao)
                VALUES (:nome_lote, :descricao)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nome_lote' => $dados['nome_lote'],
            ':descricao' => !empty($dados['descricao']) ? $dados['descricao'] : null
        ]);
    }

    public function atualizar($dados)
    {
        $sql = "UPDATE lote
                SET nome_lote = :nome_lote,
                    descricao = :descricao
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $dados['id'],
            ':nome_lote' => $dados['nome_lote'],
            ':descricao' => !empty($dados['descricao']) ? $dados['descricao'] : null
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM lote
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function estaEmUso($id)
    {
        $sql = "SELECT id
                FROM animal
                WHERE lote_id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }
}