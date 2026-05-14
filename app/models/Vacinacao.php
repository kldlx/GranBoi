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
                historico_sanitario.id,
                historico_sanitario.animal_id,
                historico_sanitario.vacina_id,
                historico_sanitario.data_aplicacao,
                historico_sanitario.dose AS quantidade,
                historico_sanitario.proxima_dose,
                historico_sanitario.preco_custo_sanitario,

                vacina.nome AS vacina,

                animal.brinco_identificador,
                animal.status AS status_animal,

                raca.nome_raca AS raca,

                pessoa.nome_completo AS responsavel,

                NULL AS lote_vacina,
                NULL AS via_aplicacao,
                NULL AS observacoes,
                'aplicada' AS status

            FROM historico_sanitario

            INNER JOIN animal 
                ON animal.id = historico_sanitario.animal_id

            LEFT JOIN raca
                ON raca.id = animal.raca_id

            INNER JOIN vacina
                ON vacina.id = historico_sanitario.vacina_id

            INNER JOIN pessoa
                ON pessoa.id = historico_sanitario.pessoa_id_veterinario

            WHERE LOWER(animal.status) != 'excluido'

            ORDER BY 
                historico_sanitario.data_aplicacao DESC,
                historico_sanitario.id DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($dados)
    {
        $vacinaId = $this->buscarOuCriarVacina($dados['vacina']);

        $pessoaIdVeterinario = $this->resolverPessoaResponsavel();

        $precoCustoSanitario = $this->buscarPrecoVacina($vacinaId);

        $sql = "INSERT INTO historico_sanitario
            (
                animal_id,
                vacina_id,
                data_aplicacao,
                dose,
                proxima_dose,
                preco_custo_sanitario,
                pessoa_id_veterinario
            )
            VALUES
            (
                :animal_id,
                :vacina_id,
                :data_aplicacao,
                :dose,
                :proxima_dose,
                :preco_custo_sanitario,
                :pessoa_id_veterinario
            )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':animal_id' => $dados['animal_id'],
            ':vacina_id' => $vacinaId,
            ':data_aplicacao' => $dados['data_aplicacao'],
            ':dose' => !empty($dados['quantidade']) ? $dados['quantidade'] : null,
            ':proxima_dose' => !empty($dados['proxima_dose']) ? $dados['proxima_dose'] : null,
            ':preco_custo_sanitario' => $precoCustoSanitario,
            ':pessoa_id_veterinario' => $pessoaIdVeterinario
        ]);
    }

    public function listarPorAnimal($animalId)
    {
        $sql = "
            SELECT 
                historico_sanitario.id,
                historico_sanitario.animal_id,
                historico_sanitario.vacina_id,
                historico_sanitario.data_aplicacao,
                historico_sanitario.dose AS quantidade,
                historico_sanitario.proxima_dose,
                historico_sanitario.preco_custo_sanitario,

                vacina.nome AS vacina,

                pessoa.nome_completo AS responsavel,

                NULL AS lote_vacina,
                NULL AS via_aplicacao,
                NULL AS observacoes,
                'aplicada' AS status

            FROM historico_sanitario

            INNER JOIN vacina
                ON vacina.id = historico_sanitario.vacina_id

            INNER JOIN pessoa
                ON pessoa.id = historico_sanitario.pessoa_id_veterinario

            WHERE historico_sanitario.animal_id = :animal_id

            ORDER BY 
                historico_sanitario.data_aplicacao DESC,
                historico_sanitario.id DESC
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
            FROM historico_sanitario
            WHERE proxima_dose IS NOT NULL
              AND proxima_dose < CURDATE()
        ";

        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        return $res['total'] ?? 0;
    }

    private function buscarOuCriarVacina($nomeVacina)
    {
        $nomeVacina = trim($nomeVacina);

        $sql = "
            SELECT id
            FROM vacina
            WHERE nome = :nome
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':nome' => $nomeVacina
        ]);

        $vacina = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($vacina) {
            return $vacina['id'];
        }

        $sql = "
            INSERT INTO vacina
                (nome, preco_vacina, periodo_carencia_dias)
            VALUES
                (:nome, 0.00, 0)
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':nome' => $nomeVacina
        ]);

        return $this->db->lastInsertId();
    }

    private function buscarPrecoVacina($vacinaId)
    {
        $sql = "
            SELECT preco_vacina
            FROM vacina
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $vacinaId
        ]);

        $vacina = $stmt->fetch(PDO::FETCH_ASSOC);

        return $vacina['preco_vacina'] ?? 0;
    }

    private function resolverPessoaResponsavel()
    {
        $usuarioId = $_SESSION['usuario']['id'] ?? $_SESSION['usuario']['usuario_id'] ?? null;

        if (!empty($usuarioId)) {
            $sql = "
                SELECT id
                FROM pessoa
                WHERE usuario_id = :usuario_id
                LIMIT 1
            ";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':usuario_id' => $usuarioId
            ]);

            $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($pessoa) {
                return $pessoa['id'];
            }
        }

        $sql = "
            SELECT id
            FROM pessoa
            ORDER BY id ASC
            LIMIT 1
        ";

        $pessoa = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        if ($pessoa) {
            return $pessoa['id'];
        }

        throw new PDOException('Nenhuma pessoa cadastrada para vincular como responsável pela vacinação.');
    }
}