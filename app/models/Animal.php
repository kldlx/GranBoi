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
            (brinco_identificador, raca_id, lote_id, data_nascimento, sexo, peso_entrada, chip, status) 
            VALUES 
            (:brinco, :raca_id, :lote_id, :data_nascimento, :sexo, :peso_entrada, :chip, 'ativo')";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':brinco' => $dados['brinco'],
            ':raca_id' => !empty($dados['raca']) ? $dados['raca'] : null,
            ':lote_id' => !empty($dados['lote']) ? $dados['lote'] : null,
            ':data_nascimento' => !empty($dados['data_nascimento']) ? $dados['data_nascimento'] : null,
            ':sexo' => !empty($dados['sexo']) ? $dados['sexo'] : null,
            ':peso_entrada' => !empty($dados['peso_entrada']) ? $dados['peso_entrada'] : null,
            ':chip' => !empty($dados['chip']) ? $dados['chip'] : null
        ]);

        return $this->db->lastInsertId();
    }

    public function listarTodos()
    {
        $sql = "
            SELECT 
                animal.*,
                raca.nome_raca AS raca,
                lote.nome_lote AS lote,
                COALESCE(ultima_pesagem.peso, animal.peso_entrada) AS peso_atual,
                ultima_pesagem.data_pesagem AS data_ultima_pesagem
            FROM animal
            LEFT JOIN raca 
                ON raca.id = animal.raca_id
            LEFT JOIN lote 
                ON lote.id = animal.lote_id
            LEFT JOIN (
                SELECT 
                    pesagem.animal_id,
                    pesagem.peso,
                    pesagem.data_pesagem
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
            ORDER BY animal.id DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function brincoExiste($brinco, $idIgnorar = null)
    {
        $sql = "SELECT id 
                FROM animal 
                WHERE brinco_identificador = :brinco";

        $params = [
            ':brinco' => $brinco
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

    public function countAll()
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM animal 
                WHERE LOWER(COALESCE(status, '')) != 'excluido'";

        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return $res['total'] ?? 0;
    }

    public function getMediaPeso()
    {
        $sql = "
            SELECT AVG(peso_atual) AS media
            FROM (
                SELECT 
                    animal.id,
                    COALESCE(ultima_pesagem.peso, animal.peso_entrada) AS peso_atual
                FROM animal
                LEFT JOIN (
                    SELECT 
                        pesagem.animal_id,
                        pesagem.peso,
                        pesagem.data_pesagem
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

        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return round($res['media'] ?? 0);
    }

    public function getUltimos($limit = 5)
    {
        $limit = (int) $limit;

        $sql = "
            SELECT 
                animal.*,
                raca.nome_raca AS raca,
                lote.nome_lote AS lote,
                COALESCE(ultima_pesagem.peso, animal.peso_entrada) AS peso_atual,
                ultima_pesagem.data_pesagem AS data_ultima_pesagem
            FROM animal
            LEFT JOIN raca 
                ON raca.id = animal.raca_id
            LEFT JOIN lote 
                ON lote.id = animal.lote_id
            LEFT JOIN (
                SELECT 
                    pesagem.animal_id,
                    pesagem.peso,
                    pesagem.data_pesagem
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
            ORDER BY animal.id DESC
            LIMIT {$limit}
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "
            SELECT 
                animal.*,
                animal.raca_id AS raca,
                animal.lote_id AS lote,
                raca.nome_raca,
                lote.nome_lote,
                COALESCE(ultima_pesagem.peso, animal.peso_entrada) AS peso_atual,
                ultima_pesagem.data_pesagem AS data_ultima_pesagem
            FROM animal
            LEFT JOIN raca 
                ON raca.id = animal.raca_id
            LEFT JOIN lote 
                ON lote.id = animal.lote_id
            LEFT JOIN (
                SELECT 
                    pesagem.animal_id,
                    pesagem.peso,
                    pesagem.data_pesagem
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
            WHERE animal.id = :id 
            AND LOWER(COALESCE(animal.status, '')) != 'excluido'
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($dados)
    {
        $sql = "UPDATE animal 
                SET brinco_identificador = :brinco,
                    raca_id = :raca_id,
                    lote_id = :lote_id,
                    data_nascimento = :data_nascimento,
                    sexo = :sexo,
                    status = :status,
                    chip = :chip
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $dados['id'],
            ':brinco' => $dados['brinco'],
            ':raca_id' => !empty($dados['raca']) ? $dados['raca'] : null,
            ':lote_id' => !empty($dados['lote']) ? $dados['lote'] : null,
            ':data_nascimento' => !empty($dados['data_nascimento']) ? $dados['data_nascimento'] : null,
            ':sexo' => !empty($dados['sexo']) ? $dados['sexo'] : null,
            ':status' => !empty($dados['status']) ? $dados['status'] : 'ativo',
            ':chip' => !empty($dados['chip']) ? $dados['chip'] : null
        ]);
    }

    public function softDelete($id)
    {
        $sql = "UPDATE animal 
                SET status = 'excluido'
                WHERE id = :id
                AND LOWER(COALESCE(status, '')) != 'excluido'";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function adicionarPeso($animal_id, $peso, $observacao = null, $pessoa_id = null)
    {
        if ($pessoa_id === null) {
            if (isset($_SESSION['usuario']['pessoa_id'])) {
                $pessoa_id = $_SESSION['usuario']['pessoa_id'];
            } elseif (isset($_SESSION['pessoa_id'])) {
                $pessoa_id = $_SESSION['pessoa_id'];
            }
        }

        if (empty($pessoa_id)) {
            throw new Exception('Não foi possível identificar a pessoa responsável pela pesagem.');
        }

        $sql = "INSERT INTO pesagem 
                (animal_id, peso, data_pesagem, observacao, pessoa_id)
                VALUES 
                (:animal_id, :peso, NOW(), :observacao, :pessoa_id)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':animal_id' => $animal_id,
            ':peso' => $peso,
            ':observacao' => $observacao,
            ':pessoa_id' => $pessoa_id
        ]);
    }

    public function getHistoricoPeso($animal_id)
    {
        $sql = "SELECT 
                    pesagem.id,
                    pesagem.animal_id,
                    pesagem.peso,
                    pesagem.data_pesagem,
                    pesagem.data_pesagem AS data_registro,
                    pesagem.observacao,
                    pesagem.pessoa_id,
                    pessoa.nome_completo AS responsavel
                FROM pesagem
                LEFT JOIN pessoa
                    ON pessoa.id = pesagem.pessoa_id
                WHERE pesagem.animal_id = :id 
                ORDER BY pesagem.data_pesagem DESC, pesagem.id DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $animal_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}