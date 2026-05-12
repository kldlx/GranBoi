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
        (brinco_identificador, raca_id, lote_id, data_nascimento, sexo, peso_entrada, status) 
        VALUES 
        (:brinco, :raca, :lote, :nascimento, :sexo, :peso, 'ativo')";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($dados);
    }

    public function listarTodos()
    {
        $sql = "SELECT * FROM animal WHERE status != 'excluido' ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function atualizar($dados)
{
    $sql = "UPDATE animal 
            SET brinco_identificador = :brinco,
                sexo = :sexo,
                peso_entrada = :peso,
                status = :status
            WHERE id = :id";

    $stmt = $this->db->prepare($sql);
    return $stmt->execute($dados);
}

public function softDelete($id)
{
    $sql = "UPDATE animal SET status = 'excluido' WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':id' => $id
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

}
