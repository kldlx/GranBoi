<?php

class Boi {
    public function salvar($dados) {
        $db = Conexao::conectar();
        $sql = "INSERT INTO animal (brinco_identificador, raca_id, lote_id, data_nascimento, sexo, peso_entrada) 
                VALUES (:brinco, :raca, :lote, :nascimento, :sexo, :peso)";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute($dados);
    }

    public function listarTodos() {
        $db = Conexao::conectar();
        return $db->query("SELECT * FROM animal ORDER BY id DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }
}