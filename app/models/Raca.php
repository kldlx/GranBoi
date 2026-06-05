<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Raca
{
    private $db;

    public function __construct()
    {
        $this->db = Conexao::conectar();
    }

    public function listarTodos()
    {
        $sql = "SELECT id, nome_tipo_raca AS nome_raca
                FROM tipo_raca
                ORDER BY nome_tipo_raca ASC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT id, nome_tipo_raca AS nome_raca
                FROM tipo_raca
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function nomeExiste($nome_raca, $idIgnorar = null)
    {
        $sql = "SELECT id
                FROM tipo_raca
                WHERE nome_tipo_raca = :nome_raca";

        $params = [
            ':nome_raca' => $nome_raca
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
        $sql = "INSERT INTO tipo_raca (nome_tipo_raca)
                VALUES (:nome_raca)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nome_raca' => $dados['nome_raca']
        ]);
    }

    public function atualizar($dados)
    {
        $sql = "UPDATE tipo_raca
                SET nome_tipo_raca = :nome_raca
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $dados['id'],
            ':nome_raca' => $dados['nome_raca']
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM tipo_raca
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
                WHERE tipo_raca_id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }
}
