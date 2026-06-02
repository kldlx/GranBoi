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
        $pessoaId = $this->resolverPessoaResponsavel();

        $sql = "INSERT INTO pesagem 
        (
            animal_id,
            peso,
            data_pesagem,
            observacao,
            pessoa_id
        )
        VALUES 
        (
            :animal_id,
            :peso,
            :data_pesagem,
            :observacao,
            :pessoa_id
        )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':animal_id' => $dados['animal_id'],
            ':peso' => $dados['peso'],
            ':data_pesagem' => !empty($dados['data_pesagem']) ? $dados['data_pesagem'] : date('Y-m-d'),
            ':observacao' => !empty($dados['observacao']) ? $dados['observacao'] : null,
            ':pessoa_id' => $pessoaId
        ]);
    }

    public function listarPorAnimal($animalId)
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
                WHERE pesagem.animal_id = :animal_id
                ORDER BY pesagem.data_pesagem DESC, pesagem.id DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':animal_id' => $animalId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPrimeiraPesagem($animalId)
    {
        $sql = "SELECT 
                    pesagem.id,
                    pesagem.animal_id,
                    pesagem.peso,
                    pesagem.data_pesagem,
                    pesagem.data_pesagem AS data_registro,
                    pesagem.observacao,
                    pesagem.pessoa_id
                FROM pesagem
                WHERE pesagem.animal_id = :animal_id
                ORDER BY pesagem.data_pesagem ASC, pesagem.id ASC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':animal_id' => $animalId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarUltimaPesagem($animalId)
    {
        $sql = "SELECT 
                    pesagem.id,
                    pesagem.animal_id,
                    pesagem.peso,
                    pesagem.data_pesagem,
                    pesagem.data_pesagem AS data_registro,
                    pesagem.observacao,
                    pesagem.pessoa_id
                FROM pesagem
                WHERE pesagem.animal_id = :animal_id
                ORDER BY pesagem.data_pesagem DESC, pesagem.id DESC
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

        $ganhoPeso = (float) $ultima['peso'] - (float) $primeira['peso'];

        return round($ganhoPeso / $dias, 2);
    }

    private function resolverPessoaResponsavel()
    {
        if (!empty($_SESSION['usuario']['pessoa_id'])) {
            return $_SESSION['usuario']['pessoa_id'];
        }

        if (!empty($_SESSION['pessoa_id'])) {
            return $_SESSION['pessoa_id'];
        }

        $usuarioId = $_SESSION['usuario']['id'] ?? $_SESSION['usuario']['usuario_id'] ?? null;

        if (!empty($usuarioId)) {
            $sql = "SELECT id
                    FROM pessoa
                    WHERE usuario_id = :usuario_id
                    LIMIT 1";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':usuario_id' => $usuarioId
            ]);

            $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($pessoa) {
                return $pessoa['id'];
            }
        }

        $sql = "SELECT id
                FROM pessoa
                ORDER BY id ASC
                LIMIT 1";

        $pessoa = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        if ($pessoa) {
            return $pessoa['id'];
        }

        throw new Exception('Não foi possível identificar a pessoa responsável pela pesagem.');
    }
}