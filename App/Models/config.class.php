<?php

require_once 'connect.php';

class Config extends Connect
{

    public function getMaxDesconto() {
        $query = "SELECT valor FROM configuracao WHERE chave = 'max_desconto'";
        $result = $this->SQL->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['valor'];
        }
        return 0;
    }

    public function setMaxDesconto($valor) {
        $query = "INSERT INTO configuracao (chave, valor) VALUES ('max_desconto', ?) 
                  ON DUPLICATE KEY UPDATE valor = ?";
        $stmt = $this->SQL->prepare($query);
        $stmt->bind_param("ii", $valor, $valor);
        $stmt->execute();
    }
}

$config = new Config;
