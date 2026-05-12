<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Vacinacao
{
    private $db;

    public function __construct()
    {
        $this->db = Conexao::conectar();
    }

    public function listarTodas()
    {
        $sql = "
            SELECT 
                vacinacao.*,
                animal.brinco_identificador,
                animal.raca,
                animal.status AS status_animal
            FROM vacinacao
            INNER JOIN animal 
                ON animal.id = vacinacao.animal_id
            WHERE animal.status != 'excluido'
            ORDER BY vacinacao.data_aplicacao DESC, vacinacao.id DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($dados)
    {
        $sql = "INSERT INTO vacinacao
            (
                animal_id,
                vacina,
                data_aplicacao,
                proxima_dose,
                responsavel,
                lote_vacina,
                quantidade,
                via_aplicacao,
                observacoes,
                status
            )
            VALUES
            (
                :animal_id,
                :vacina,
                :data_aplicacao,
                :proxima_dose,
                :responsavel,
                :lote_vacina,
                :quantidade,
                :via_aplicacao,
                :observacoes,
                'aplicada'
            )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':animal_id' => $dados['animal_id'],
            ':vacina' => $dados['vacina'],
            ':data_aplicacao' => $dados['data_aplicacao'],
            ':proxima_dose' => !empty($dados['proxima_dose']) ? $dados['proxima_dose'] : null,
            ':responsavel' => !empty($dados['responsavel']) ? $dados['responsavel'] : null,
            ':lote_vacina' => !empty($dados['lote_vacina']) ? $dados['lote_vacina'] : null,
            ':quantidade' => !empty($dados['quantidade']) ? $dados['quantidade'] : null,
            ':via_aplicacao' => !empty($dados['via_aplicacao']) ? $dados['via_aplicacao'] : null,
            ':observacoes' => !empty($dados['observacoes']) ? $dados['observacoes'] : null
        ]);
    }

    public function listarPorAnimal($animalId)
    {
        $sql = "
            SELECT *
            FROM vacinacao
            WHERE animal_id = :animal_id
            ORDER BY data_aplicacao DESC, id DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':animal_id' => $animalId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPendentes()
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM vacinacao
            WHERE status = 'pendente'
        ";

        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return $res['total'] ?? 0;
    }
}