<?php

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
            (:brinco, NULL, :raca, :lote, :data_nascimento, :sexo, :peso_entrada, 'ativo', :observacoes)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':brinco' => $dados['brinco'],
            ':raca' => !empty($dados['raca']) ? $dados['raca'] : null,
            ':lote' => !empty($dados['lote']) ? $dados['lote'] : null,
            ':data_nascimento' => !empty($dados['data_nascimento']) ? $dados['data_nascimento'] : null,
            ':sexo' => $dados['sexo'],
            ':peso_entrada' => $dados['peso_entrada'],
            ':observacoes' => !empty($dados['observacoes']) ? $dados['observacoes'] : null
        ]);

        return $this->db->lastInsertId();
    }

    public function listarTodos()
    {
        $sql = "
            SELECT 
                animal.*,
                COALESCE(ultima_pesagem.peso, animal.peso_entrada) AS peso_atual,
                ultima_pesagem.data_registro AS data_ultima_pesagem
            FROM animal
            LEFT JOIN (
                SELECT aph1.animal_id, aph1.peso, aph1.data_registro
                FROM animal_peso_historico aph1
                INNER JOIN (
                    SELECT animal_id, MAX(data_registro) AS ultima_data
                    FROM animal_peso_historico
                    GROUP BY animal_id
                ) aph2 
                    ON aph2.animal_id = aph1.animal_id
                    AND aph2.ultima_data = aph1.data_registro
            ) ultima_pesagem
                ON ultima_pesagem.animal_id = animal.id
            WHERE animal.status != 'excluido'
            ORDER BY animal.id DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function brincoExiste($brinco)
    {
        $sql = "SELECT id 
                FROM animal 
                WHERE brinco_identificador = :brinco 
                AND status != 'excluido'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':brinco' => $brinco
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM animal WHERE status != 'excluido'";
        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ?? 0;
    }

    public function getMediaPeso()
    {
        $sql = "SELECT AVG(peso_entrada) as media FROM animal";
        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return round($res['media'] ?? 0);
    }

    public function getUltimos($limit = 5)
    {
        $limit = (int) $limit;

        $sql = "SELECT * FROM animal ORDER BY id DESC LIMIT $limit";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countVacinasPendentes()
    {
        return 0; // futuro módulo
    }

    public function buscarPorId($id)
{
    $sql = "SELECT * FROM animal WHERE id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

public function atualizar($dados)
{
    $sql = "UPDATE animal 
            SET brinco_identificador = :brinco,
                sexo = :sexo,
                peso_entrada = :peso,
                status = :status
            WHERE id = :id";

    public function atualizar($dados)
    {
        $sql = "UPDATE animal 
                SET raca = :raca,
                    lote = :lote,
                    data_nascimento = :data_nascimento,
                    sexo = :sexo,
                    status = :status,
                    observacoes = :observacoes
                WHERE id = :id";

public function softDelete($id)
{
    $sql = "UPDATE animal SET status = 'excluido' WHERE id = :id";
    $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $dados['id'],
            ':raca' => !empty($dados['raca']) ? $dados['raca'] : null,
            ':lote' => !empty($dados['lote']) ? $dados['lote'] : null,
            ':data_nascimento' => !empty($dados['data_nascimento']) ? $dados['data_nascimento'] : null,
            ':sexo' => $dados['sexo'],
            ':status' => $dados['status'],
            ':observacoes' => !empty($dados['observacoes']) ? $dados['observacoes'] : null
        ]);
    }

public function adicionarPeso($animal_id, $peso)
{
    $sql = "INSERT INTO animal_peso_historico (animal_id, peso)
            VALUES (:animal_id, :peso)";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':animal_id' => $animal_id,
        ':peso' => $peso
    ]);
}

public function getHistoricoPeso($animal_id)
{
    $sql = "SELECT * FROM animal_peso_historico 
            WHERE animal_id = :id 
            ORDER BY data_registro DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $animal_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
