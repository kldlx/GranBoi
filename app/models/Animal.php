<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Animal
{
    private $db;

    public function __construct()
    {
        $this->db = Conexao::conectar();
    }

    public function salvar($dados)
    {
        $sql = "INSERT INTO animal 
            (brinco_identificador, nome, raca, lote, data_nascimento, sexo, peso_entrada, status, observacoes) 
            VALUES 
            (:brinco, :nome, :raca, :lote, :data_nascimento, :sexo, :peso_entrada, 'ativo', :observacoes)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':brinco' => $dados['brinco'],
            ':nome' => $dados['nome'] ?? null,
            ':raca' => $dados['raca'] ?? null,
            ':lote' => $dados['lote'] ?? null,
            ':data_nascimento' => $dados['data_nascimento'] ?? null,
            ':sexo' => $dados['sexo'],
            ':peso_entrada' => $dados['peso_entrada'],
            ':observacoes' => $dados['observacoes'] ?? null
        ]);
    }

    public function listarTodos()
    {
        $sql = "SELECT * 
                FROM animal 
                WHERE status != 'excluido' 
                ORDER BY id DESC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM animal 
                WHERE status != 'excluido'";

        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return $res['total'] ?? 0;
    }

    public function getMediaPeso()
    {
        $sql = "SELECT AVG(peso_entrada) AS media 
                FROM animal 
                WHERE status != 'excluido'";

        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return round($res['media'] ?? 0);
    }

    public function getUltimos($limit = 5)
    {
        $limit = (int) $limit;

        $sql = "SELECT * 
                FROM animal 
                WHERE status != 'excluido' 
                ORDER BY id DESC 
                LIMIT {$limit}";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * 
                FROM animal 
                WHERE id = :id 
                AND status != 'excluido'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($dados)
    {
        $sql = "UPDATE animal 
                SET brinco_identificador = :brinco,
                    nome = :nome,
                    raca = :raca,
                    lote = :lote,
                    data_nascimento = :data_nascimento,
                    sexo = :sexo,
                    peso_entrada = :peso_entrada,
                    status = :status,
                    observacoes = :observacoes
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $dados['id'],
            ':brinco' => $dados['brinco'],
            ':nome' => $dados['nome'] ?? null,
            ':raca' => $dados['raca'] ?? null,
            ':lote' => $dados['lote'] ?? null,
            ':data_nascimento' => $dados['data_nascimento'] ?? null,
            ':sexo' => $dados['sexo'],
            ':peso_entrada' => $dados['peso_entrada'],
            ':status' => $dados['status'],
            ':observacoes' => $dados['observacoes'] ?? null
        ]);
    }

    public function softDelete($id)
    {
        $sql = "UPDATE animal 
                SET status = 'excluido' 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function adicionarPeso($animal_id, $peso, $observacao = null)
    {
        $sql = "INSERT INTO animal_peso_historico 
                (animal_id, peso, observacao)
                VALUES 
                (:animal_id, :peso, :observacao)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':animal_id' => $animal_id,
            ':peso' => $peso,
            ':observacao' => $observacao
        ]);
    }

    public function getHistoricoPeso($animal_id)
    {
        $sql = "SELECT * 
                FROM animal_peso_historico 
                WHERE animal_id = :id 
                ORDER BY data_registro DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $animal_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}