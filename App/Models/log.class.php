<?php
require_once 'connect.php';

class Log extends Connect
{
    public function registrar($entidade, $user, $operacao, $detalhes = null)
    {
        $query = "INSERT INTO logs (entidade, user, operacao, detalhes) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->SQL, $query);
        mysqli_stmt_bind_param($stmt, 'ssss', $entidade, $user, $operacao, $detalhes);
        mysqli_stmt_execute($stmt);
    }

    public function getLogs($limit = 50)
    {
        $query = "SELECT * FROM logs ORDER BY datahora DESC LIMIT $limit";
        $result = mysqli_query($this->SQL, $query);
        return $result;
    }
}

$log = new Log;
?>
