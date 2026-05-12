<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Pesagem
{
    private $db;

    public function __construct()
    {
        $this->db = Conexao::conectar();
    }

    public function registrar($dados)
    {
        $sql = "INSERT INTO animal_peso_historico 
                (animal_id, peso, observacao)
                VALUES 
                (:animal_id, :peso, :observacao)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':animal_id' => $dados['animal_id'],
            ':peso' => $dados['peso'],
            ':observacao' => $dados['observacao'] ?? null
        ]);
    }

    public function listarPorAnimal($animalId)
    {
        $sql = "SELECT *
                FROM animal_peso_historico
                WHERE animal_id = :animal_id
                ORDER BY data_registro ASC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':animal_id' => $animalId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPrimeiraPesagem($animalId)
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

    public function buscarUltimaPesagem($animalId)
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

    public function calcularGmd($animalId)
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
}