<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Relatorio
{
    private $db;

    public function __construct()
    {
        $this->db = Conexao::conectar();
    }

    public function resumoRebanho()
    {
        $sql = "
            SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN LOWER(status) = 'ativo' THEN 1 ELSE 0 END) AS ativos,
                SUM(CASE WHEN LOWER(status) = 'vendido' THEN 1 ELSE 0 END) AS vendidos,
                SUM(CASE WHEN LOWER(status) = 'morto' THEN 1 ELSE 0 END) AS abatidos
            FROM animal
            WHERE LOWER(COALESCE(status, '')) != 'excluido'
        ";

        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function pesoMedioAtual()
    {
        $sql = "
            SELECT AVG(peso_atual) AS peso_medio
            FROM (
                SELECT 
                    animal.id,
                    COALESCE(ultima_pesagem.peso, animal.peso_entrada) AS peso_atual
                FROM animal
                LEFT JOIN (
                    SELECT 
                        pesagem.animal_id,
                        pesagem.peso
                    FROM pesagem
                    INNER JOIN (
                        SELECT 
                            animal_id,
                            MAX(id) AS ultima_pesagem_id
                        FROM pesagem
                        GROUP BY animal_id
                    ) ultima
                        ON ultima.ultima_pesagem_id = pesagem.id
                ) ultima_pesagem
                    ON ultima_pesagem.animal_id = animal.id
                WHERE LOWER(COALESCE(animal.status, '')) != 'excluido'
            ) pesos
        ";

        $resultado = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return round((float) ($resultado['peso_medio'] ?? 0), 2);
    }

    public function animaisPorRaca()
    {
        $sql = "
            SELECT 
                COALESCE(raca.nome_raca, 'Sem raça') AS raca,
                COUNT(animal.id) AS total
            FROM animal
            LEFT JOIN raca
                ON raca.id = animal.raca_id
            WHERE LOWER(COALESCE(animal.status, '')) != 'excluido'
            GROUP BY COALESCE(raca.nome_raca, 'Sem raça')
            ORDER BY total DESC, raca ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function animaisPorLote()
    {
        $sql = "
            SELECT 
                COALESCE(lote.nome_lote, 'Sem lote') AS lote,
                COUNT(animal.id) AS total
            FROM animal
            LEFT JOIN lote
                ON lote.id = animal.lote_id
            WHERE LOWER(COALESCE(animal.status, '')) != 'excluido'
            GROUP BY COALESCE(lote.nome_lote, 'Sem lote')
            ORDER BY total DESC, lote ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rankingGanhoPeso($limite = 10)
    {
        $limite = (int) $limite;

        $sql = "
            SELECT
                animal.id,
                animal.brinco_identificador,
                raca.nome_raca AS raca,
                lote.nome_lote AS lote,
                primeira_pesagem.peso AS peso_inicial,
                ultima_pesagem.peso AS peso_atual,
                primeira_pesagem.data_pesagem AS data_inicial,
                ultima_pesagem.data_pesagem AS data_atual,
                (ultima_pesagem.peso - primeira_pesagem.peso) AS ganho_total,
                DATEDIFF(ultima_pesagem.data_pesagem, primeira_pesagem.data_pesagem) AS dias,
                CASE
                    WHEN DATEDIFF(ultima_pesagem.data_pesagem, primeira_pesagem.data_pesagem) <= 0 THEN
                        ROUND((ultima_pesagem.peso - primeira_pesagem.peso), 2)
                    ELSE
                        ROUND(
                            (ultima_pesagem.peso - primeira_pesagem.peso) /
                            DATEDIFF(ultima_pesagem.data_pesagem, primeira_pesagem.data_pesagem),
                            2
                        )
                END AS gmd
            FROM animal
            INNER JOIN (
                SELECT p1.*
                FROM pesagem p1
                INNER JOIN (
                    SELECT animal_id, MIN(id) AS primeira_pesagem_id
                    FROM pesagem
                    GROUP BY animal_id
                ) primeira
                    ON primeira.primeira_pesagem_id = p1.id
            ) primeira_pesagem
                ON primeira_pesagem.animal_id = animal.id
            INNER JOIN (
                SELECT p2.*
                FROM pesagem p2
                INNER JOIN (
                    SELECT animal_id, MAX(id) AS ultima_pesagem_id
                    FROM pesagem
                    GROUP BY animal_id
                ) ultima
                    ON ultima.ultima_pesagem_id = p2.id
            ) ultima_pesagem
                ON ultima_pesagem.animal_id = animal.id
            LEFT JOIN raca
                ON raca.id = animal.raca_id
            LEFT JOIN lote
                ON lote.id = animal.lote_id
            WHERE LOWER(COALESCE(animal.status, '')) != 'excluido'
            AND primeira_pesagem.id != ultima_pesagem.id
            ORDER BY ganho_total DESC
            LIMIT {$limite}
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function vacinacoesPorPeriodo($dataInicio = null, $dataFim = null)
    {
        $dataInicio = $dataInicio ?: date('Y-m-01');
        $dataFim = $dataFim ?: date('Y-m-d');

        $sql = "
            SELECT 
                historico_sanitario.id,
                historico_sanitario.data_aplicacao,
                historico_sanitario.dose AS quantidade,
                historico_sanitario.proxima_dose,

                vacina.nome AS vacina,

                animal.brinco_identificador,
                animal.status AS status_animal,

                raca.nome_raca AS raca,

                pessoa.nome_completo AS responsavel,

                CASE
                    WHEN historico_sanitario.proxima_dose IS NULL THEN 'aplicada'
                    WHEN historico_sanitario.proxima_dose < CURDATE() THEN 'atrasada'
                    WHEN historico_sanitario.proxima_dose = CURDATE() THEN 'pendente'
                    ELSE 'aplicada'
                END AS status
            FROM historico_sanitario
            INNER JOIN animal
                ON animal.id = historico_sanitario.animal_id
            LEFT JOIN raca
                ON raca.id = animal.raca_id
            INNER JOIN vacina
                ON vacina.id = historico_sanitario.vacina_id
            INNER JOIN pessoa
                ON pessoa.id = historico_sanitario.pessoa_id_veterinario
            WHERE LOWER(COALESCE(animal.status, '')) != 'excluido'
            AND historico_sanitario.data_aplicacao BETWEEN :data_inicio AND :data_fim
            ORDER BY 
                historico_sanitario.data_aplicacao DESC,
                historico_sanitario.id DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':data_inicio' => $dataInicio,
            ':data_fim' => $dataFim
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function vacinasPendentes()
    {
        $sql = "
            SELECT 
                historico_sanitario.id,
                historico_sanitario.proxima_dose,
                vacina.nome AS vacina,
                animal.brinco_identificador,
                raca.nome_raca AS raca
            FROM historico_sanitario
            INNER JOIN animal
                ON animal.id = historico_sanitario.animal_id
            LEFT JOIN raca
                ON raca.id = animal.raca_id
            INNER JOIN vacina
                ON vacina.id = historico_sanitario.vacina_id
            WHERE LOWER(COALESCE(animal.status, '')) != 'excluido'
            AND historico_sanitario.proxima_dose = CURDATE()
            ORDER BY historico_sanitario.proxima_dose ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function vacinasAtrasadas()
    {
        $sql = "
            SELECT 
                historico_sanitario.id,
                historico_sanitario.proxima_dose,
                vacina.nome AS vacina,
                animal.brinco_identificador,
                raca.nome_raca AS raca,
                DATEDIFF(CURDATE(), historico_sanitario.proxima_dose) AS dias_atraso
            FROM historico_sanitario
            INNER JOIN animal
                ON animal.id = historico_sanitario.animal_id
            LEFT JOIN raca
                ON raca.id = animal.raca_id
            INNER JOIN vacina
                ON vacina.id = historico_sanitario.vacina_id
            WHERE LOWER(COALESCE(animal.status, '')) != 'excluido'
            AND historico_sanitario.proxima_dose < CURDATE()
            ORDER BY historico_sanitario.proxima_dose ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}