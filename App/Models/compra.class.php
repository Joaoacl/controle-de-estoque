<?php

require_once 'connect.php';
require_once '../../App/Models/produto.class.php';



class Compras extends Connect
{
    public function index($value)
    {
        $query = "SELECT 
                    c.idcompra, 
                    c.fornecedor_idfornecedor, 
                    c.dataCompra, 
                    c.ativo, 
                    f.nome AS nome_fornecedor,
                    GROUP_CONCAT(CONCAT(p.nome) SEPARATOR ' | ') AS itensComprados,
                    GROUP_CONCAT(CONCAT(p.nome, ' - Qtd: ', cp.quantidade) SEPARATOR '<br>') AS detalhesItensComprados
                FROM 
                    `compra` c 
                    JOIN `fornecedor` f ON c.fornecedor_idfornecedor = f.idfornecedor
                    JOIN `compra_has_produto` cp ON c.idcompra = cp.compra_id
                    JOIN `produto` p ON cp.produto_id = p.idproduto
                WHERE 
                    c.ativo = '$value' AND c.public = 1
                GROUP BY 
                    c.idcompra";

        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        if ($result) {
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th>ID</th>                
                        <th>Produtos</th>
                        <th>Fornecedor</th>
                        <th>Data Compra</th>
                        <th>Status</th>                       
                        <th>Opções</th>
                    </tr>
                </thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_array($result)) {
                $ativo_class = ($row['ativo'] == 0) ? 'class="success"' : '';
                echo '<tr ' . $ativo_class . '>';
                echo '<td>' . $row['idcompra'] . '</td>';
                echo '<td>' . $row['itensComprados'] . '</td>'; // Exibe todos os itens comprados em uma única célula
                echo '<td>' . $row['nome_fornecedor'] . '</td>';
                echo '<td>' . date('d/m/Y', strtotime($row['dataCompra'])) . '</td>';
                echo '<td>' . ($row['ativo'] == 1 ? 'Em andamento' : 'Entregue') . '</td>';
                
                // Botões de opções, incluindo o botão para abrir o modal de Visualizar
                echo '<td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewModal' . $row['idcompra'] . '">Visualizar</button>
                        
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idcompra'] . '">Cancelar</button>
                        
                    </td>';
                echo '</tr>';

                

                // Modal informações da compra
                echo '<div class="modal fade" id="viewModal' . $row['idcompra'] . '" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel' . $row['idcompra'] . '" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h4 class="modal-title" id="viewModalLabel' . $row['idcompra'] . '">Detalhes da Compra</h4>
                                </div>
                                <div class="modal-body">
                                    <p><strong>ID da Solicitação:</strong> ' . $row['idcompra'] . '</p>
                                    <h4><strong>Itens da compra</strong></h4>
                                    <p>' . $row['detalhesItensComprados'] . '</p>
                                    <p><strong>Fornecedor:</strong> ' . $row['nome_fornecedor'] . '</p>
                                    <p><strong>Data da Compra:</strong> ' . date('d/m/Y', strtotime($row['dataCompra'])) . '</p>
                                </div>
                                <div class="modal-footer">';
                                if($row['ativo'] == 1){
                                    echo'<button type="button" class="btn btn-success" data-dismiss="modal">Concluir</button>';
                                }
                                    echo'<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>    
                                </div>
                            </div>
                        </div>
                    </div>';
                
                // Modal de Exclusão
                echo '<div class="modal fade" id="deleteModal' . $row['idcompra'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idcompra'] . '" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="deleteModalLabel' . $row['idcompra'] . '">Excluir Compra</h5>
                                </div>
                                <div class="modal-body">
                                    Você tem certeza que deseja cancelar a compra ID: <strong>' . $row['idcompra'] . '</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="../../App/Database/delcompra.php" method="POST">
                                        <input type="hidden" name="idcompra" value="' . $row['idcompra'] . '">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="upload" value="Cadastrar"  class="btn btn-danger">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';
            }

            echo '</tbody>';
            echo '</table>';
        }
    }


    public function insertCompra($fornecedor) {
        $query = "INSERT INTO compra (fornecedor_idfornecedor, dataCompra, ativo) VALUES ('$fornecedor', NOW(), '1')";
        mysqli_query($this->SQL, $query);
        return mysqli_insert_id($this->SQL);
    }
    
    public function insertProdutoCompra($idCompra, $idProduto, $quantidade) {
        $query = "INSERT INTO compra_has_produto (compra_id, produto_id, quantidade) VALUES ('$idCompra', '$idProduto', '$quantidade')";
        mysqli_query($this->SQL, $query);
    }
    


    public function verificarEstoque($idproduto) {
        $query = "SELECT nome, quantidade, quantidade_minima FROM `produto` WHERE `idproduto` = '$idproduto'";
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
    
        if ($produto = mysqli_fetch_assoc($result)) {
            if ($produto['quantidade'] <= $produto['quantidade_minima']) {
                // Adicione a lógica de notificação aqui, exemplo:
                $_SESSION['notificacoes'][] = "O produto " . $produto['nome'] . " está com estoque baixo. Apenas " . $produto['quantidade'] . " unidades restantes.";
            }
        }
    }


    public function deleteCompra($idcompra)
    {
        $query = "UPDATE `compra` SET `public` = 0 WHERE `idcompra` = '$idcompra'";
        mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
        
        header('Location: ../../views/compras/index.php?alert=deletado');
    }
}

$compras = new Compras;
