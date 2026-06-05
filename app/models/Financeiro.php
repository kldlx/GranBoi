<?php

require_once ROOT_PATH . '/app/models/conexao.php';

class Financeiro
{
    private $db;

    public function __construct()
    {
        $this->db = Conexao::conectar();
    }

    public function getTotalReceitas()
    {
        $sql = "SELECT COALESCE(SUM(valor_venda), 0) AS total
                FROM animal
                WHERE LOWER(status) = 'vendido'
                  AND valor_venda > 0";

        return (float) $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalCustosSanitarios()
    {
        $sql = "SELECT COALESCE(SUM(preco_custo_sanitario), 0) AS total
                FROM historico_sanitario";

        return (float) $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalCustosManejo()
    {
        $sql = "SELECT COALESCE(SUM(valor), 0) AS total
                FROM despesa_financeira
                WHERE LOWER(categoria) = 'manejo'";

        return (float) $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalCustosPasto()
    {
        $sql = "SELECT COALESCE(SUM(custo_mensal), 0) AS total
                FROM pasto";

        return (float) $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getUltimasVendas($limit = 8)
    {
        $limit = (int) $limit;

        $sql = "SELECT
                    animal.brinco_identificador,
                    animal.valor_venda,
                    animal.peso_saida,
                    tipo_raca.nome_tipo_raca AS raca
                FROM animal
                LEFT JOIN tipo_raca ON tipo_raca.id = animal.tipo_raca_id
                WHERE LOWER(animal.status) = 'vendido'
                  AND animal.valor_venda > 0
                ORDER BY animal.id DESC
                LIMIT {$limit}";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUltimosCustosSanitarios($limit = 8)
    {
        $limit = (int) $limit;

        $sql = "SELECT
                    historico_sanitario.data_aplicacao,
                    historico_sanitario.preco_custo_sanitario,
                    vacina.nome AS vacina,
                    animal.brinco_identificador
                FROM historico_sanitario
                INNER JOIN vacina ON vacina.id = historico_sanitario.vacina_id
                INNER JOIN animal ON animal.id = historico_sanitario.animal_id
                WHERE historico_sanitario.preco_custo_sanitario > 0
                ORDER BY historico_sanitario.id DESC
                LIMIT {$limit}";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalDespesasOperacionais()
    {
        $sql = "SELECT COALESCE(SUM(valor), 0) AS total FROM despesa_financeira";
        return (float) $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getUltimasDespesas()
    {
        $sql = "SELECT
                    df.id,
                    df.descricao,
                    df.categoria,
                    df.valor,
                    df.data_despesa,
                    df.observacao,
                    df.lote_id,
                    a.brinco_identificador AS animal_brinco,
                    l.nome_lote
                FROM despesa_financeira df
                LEFT JOIN animal a ON a.id = df.animal_id
                LEFT JOIN lote l ON l.id = df.lote_id
                ORDER BY df.data_despesa DESC, df.id DESC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarDespesaPorId($id)
    {
        $stmt = $this->db->prepare("
            SELECT df.*, l.nome_lote
            FROM despesa_financeira df
            LEFT JOIN lote l ON l.id = df.lote_id
            WHERE df.id = :id LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarDespesa($id, $dados)
    {
        $stmt = $this->db->prepare("
            UPDATE despesa_financeira
            SET descricao = :descricao,
                categoria = :categoria,
                valor = :valor,
                data_despesa = :data_despesa,
                observacao = :observacao,
                lote_id = :lote_id
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id'          => $id,
            ':descricao'   => $dados['descricao'],
            ':categoria'   => $dados['categoria'],
            ':valor'       => $dados['valor'],
            ':data_despesa'=> $dados['data_despesa'],
            ':observacao'  => !empty($dados['observacao']) ? $dados['observacao'] : null,
            ':lote_id'     => !empty($dados['lote_id']) ? $dados['lote_id'] : null,
        ]);
    }

    public function excluirDespesa($id)
    {
        $stmt = $this->db->prepare("DELETE FROM despesa_financeira WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function salvarDespesa($dados)
    {
        $sql = "INSERT INTO despesa_financeira
                    (descricao, categoria, valor, data_despesa, observacao, animal_id, lote_id, usuario_id)
                VALUES
                    (:descricao, :categoria, :valor, :data_despesa, :observacao, :animal_id, :lote_id, :usuario_id)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':descricao'   => $dados['descricao'],
            ':categoria'   => $dados['categoria'],
            ':valor'       => $dados['valor'],
            ':data_despesa'=> $dados['data_despesa'],
            ':observacao'  => !empty($dados['observacao']) ? $dados['observacao'] : null,
            ':animal_id'   => !empty($dados['animal_id']) ? $dados['animal_id'] : null,
            ':lote_id'     => !empty($dados['lote_id'])   ? $dados['lote_id']   : null,
            ':usuario_id'  => !empty($dados['usuario_id'])? $dados['usuario_id']: null,
        ]);
    }
}
