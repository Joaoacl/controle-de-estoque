<?php

require_once 'connect.php';

class Vendas extends Connect
{
    public function index()
    {
        $query = "SELECT v.idvenda, v.cliente_idcliente, v.dataVenda, v.valorTotal, cli.nome AS nome_cliente 
                  FROM `venda` v JOIN `cliente` cli ON v.cliente_idcliente = cli.idcliente
                  ";
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        if ($result) {
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Valor Total da Venda</th>
                        <th>Cliente</th>
                        <th>Data da Venda</th>                      
                        <th>Opções</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
    
            while ($row = mysqli_fetch_array($result)) {
              
    
                echo '<tr>';
                echo '<td>' . $row['idvenda'] . '</td>';
                echo '<td>' . $row['valorTotal'] . '</td>';
                echo '<td>' . $row['nome_cliente'] . '</td>';
                echo '<td>' . $row['dataVenda'] . '</td>';
                
                echo '<td>
                        <a href="viewproduto.php?id=' . $row['idvenda'] . '" class="btn btn-primary btn-sm">Visualizar</a>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idvenda'] . '">Excluir</button>
    
                           <!-- Modal -->
                      <div class="modal fade" id="deleteModal' . $row['idvenda'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idvenda'] . '" aria-hidden="true" >
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModalLabel' . $row['idvenda'] . '">Excluir Venda</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      Você tem certeza que deseja excluir a venda <strong>' . $row['idvenda'] . '</strong>?
                                  </div>
                                  <div class="modal-footer">
                                      <form action="../../App/Database/delproduto.php" method="POST">
                                          <input type="hidden" name="idvenda" value="' . $row['idvenda'] . '">
                                          <button type="button" name="upload" value="Cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" name="upload" value="Cadastrar" class="btn btn-danger">Excluir</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                      </td>';
                echo '</tr>';
            }
    
            echo '</tbody>';
            echo '</table>';
        }
    }

    public function InsertVenda()
    {
        $query = "INSERT INTO `venda`(`valorTotal`, `cliente_idcliente`, `dataVenda`) 
                  VALUES ('$valorTotal','$cliente_idcliente', '$dataVenda')";
        if (mysqli_query($this->SQL, $query)) {
            return mysqli_insert_id($this->SQL);
        } else {
            return false;
        }
    }


    public function updateVenda($idvenda, $cliente, $data, $valor_total, $ativo)
    {
        $query = "UPDATE `vendas` SET 
                  `cliente`= '$cliente', 
                  `data`= '$data',
                  `valor_total`= '$valor_total', 
                  `ativo` = '$ativo' 
                  WHERE `idvenda`= '$idvenda'";
        mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        header('Location: ../../views/vendas/index.php?alert=1');
    }

    public function deleteVenda($idvenda)
    {
        $query = "UPDATE `vendas` SET `ativo` = 0 WHERE `idvenda` = '$idvenda'";
        mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
        
        header('Location: ../../views/vendas/index.php?alert=1');
    }
}

$vendas = new Vendas;
