<?php

/*
 Class Enderecos
*/

require_once 'connect.php';

class Enderecos extends Connect
{
    public function InsertEndereco($rua, $numero, $bairro, $cidade, $estado, $cep)
    {
        $query = "INSERT INTO `endereco`(`rua`, `numero`, `bairro`, `cidade`, `estado`, `cep`) VALUES ('$rua', '$numero', '$bairro', '$cidade', '$estado', '$cep')";
        if ($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))) {
            return mysqli_insert_id($this->SQL); // Retorna o ID do endereço inserido
        } else {
            return false;
        }
    }

    public function updateEndereco($rua, $numero, $bairro, $cidade, $estado, $cep, $idendereco)
    {
    $query = "UPDATE `endereco` 
              SET `rua` = '$rua', `numero` = '$numero', `bairro` = '$bairro', 
                  `cidade` = '$cidade', `estado` = '$estado', `cep` = '$cep' 
              WHERE `idendereco` = '$idendereco'";

    if (mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))) {
        return true; // Retorna true se a atualização for bem-sucedida
    } else {
        return false; // Retorna false se ocorrer algum erro
    }
    }


    public function listEnderecos($value = NULL)
    {
        $query = "SELECT * FROM `endereco`";
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $selected = ($value == $row['idendereco']) ? "selected" : "";
                echo '<option value="'.$row['idendereco'].'" '.$selected.'>'.$row['rua'].' '.$row['numero'].', '.$row['bairro'].', '.$row['cidade'].', '.$row['estado'].' - '.$row['cep'].'</option>';
            }
        }
    }
}

$enderecos = new Enderecos;

?>
