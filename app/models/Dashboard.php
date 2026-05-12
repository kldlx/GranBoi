<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Dashboard
{
    private $db;

    public function __construct()
    {
        $this->db = Conexao::conectar();
    }

    public function totalAnimais()
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM animal 
                WHERE status != 'excluido'";

        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return $res['total'] ?? 0;
    }

    public function pesoMedioAtual()
    {
        $sql = "
            SELECT AVG(peso_atual) AS media
            FROM (
                SELECT 
                    animal.id,
                    COALESCE(ultima_pesagem.peso, animal.peso_entrada) AS peso_atual
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
            ) pesos
        ";

        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return round($res['media'] ?? 0);
    }

    public function ultimosAnimais($limit = 5)
    {
        $limit = (int) $limit;

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
            LIMIT {$limit}
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function gmdMedio()
    {
        $sql = "SELECT DISTINCT animal_id 
                FROM animal_peso_historico";

        $animais = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        if (empty($animais)) {
            return null;
        }

        $soma = 0;
        $quantidade = 0;

        foreach ($animais as $animal) {
            $gmd = $this->calcularGmdAnimal($animal['animal_id']);

            if ($gmd !== null) {
                $soma += $gmd;
                $quantidade++;
            }
        }

        if ($quantidade === 0) {
            return null;
        }

        return round($soma / $quantidade, 2);
    }

    private function calcularGmdAnimal($animalId)
    {
        $primeira = $this->buscarPrimeiraPesagem($animalId);
        $ultima = $this->buscarUltimaPesagem($animalId);

        if (!$primeira || !$ultima) {
            return null;
        }

        if ($primeira['id'] == $ultima['id']) {
            return null;
        }

        $dataInicial = new DateTime($primeira['data_registro']);
        $dataFinal = new DateTime($ultima['data_registro']);

        $dias = $dataInicial->diff($dataFinal)->days;

        if ($dias <= 0) {
            $dias = 1;
        }

        $ganhoPeso = $ultima['peso'] - $primeira['peso'];

        return round($ganhoPeso / $dias, 2);
    }

    private function buscarPrimeiraPesagem($animalId)
    {
        $sql = "SELECT *
                FROM animal_peso_historico
                WHERE animal_id = :animal_id
                ORDER BY data_registro ASC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':animal_id' => $animalId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function buscarUltimaPesagem($animalId)
    {
        $sql = "SELECT *
                FROM animal_peso_historico
                WHERE animal_id = :animal_id
                ORDER BY data_registro DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':animal_id' => $animalId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function totalPorStatus($status)
{
    $sql = "SELECT COUNT(*) AS total 
            FROM animal 
            WHERE status = :status";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':status' => $status
    ]);

    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    return $res['total'] ?? 0;
}

public function ultimasPesagens($limit = 5)
{
    $limit = (int) $limit;

    $sql = "
        SELECT 
            animal_peso_historico.id,
            animal_peso_historico.animal_id,
            animal_peso_historico.peso,
            animal_peso_historico.data_registro,
            animal.brinco_identificador,
            animal.raca
        FROM animal_peso_historico
        INNER JOIN animal 
            ON animal.id = animal_peso_historico.animal_id
        WHERE animal.status != 'excluido'
        ORDER BY animal_peso_historico.data_registro DESC
        LIMIT {$limit}
    ";

    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
}