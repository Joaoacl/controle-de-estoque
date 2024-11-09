<?php

require_once 'connect.php';
require_once '../../App/Models/produto.class.php';



class Compras extends Connect
{
    public function index($value)
    {
        $value = in_array($value, [0, 1]) ? $value : 1;

        $query = "SELECT 
                    c.idcompra, 
                    c.fornecedor_idfornecedor, 
                    c.dataCompra, 
                    c.dataEntrega,
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

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th>ID</th>                
                        <th>Produtos</th>
                        <th>Fornecedor</th>';
                        
                    // Verifica se há resultados antes de acessar $row
                        $row = mysqli_fetch_assoc($result);
                        if ($row) {
                            echo ($row['ativo'] == 1) ? '<th>Data Compra</th>' : '<th>Data Entrega</th>';
                        }
                        echo '<th>Status</th>                       
                            <th>Opções</th>
                    </tr>
                </thead>';
        echo '<tbody>';

        // Reseta o ponteiro para o início do resultado
        mysqli_data_seek($result, 0);

            while ($row = mysqli_fetch_array($result)) {
                $ativo_class = ($row['ativo'] == 0) ? 'class="success"' : '';
                echo '<tr ' . $ativo_class . '>';
                echo '<td>' . $row['idcompra'] . '</td>';
                echo '<td>' . $row['itensComprados'] . '</td>'; // Exibe todos os itens comprados em uma única célula
                echo '<td>' . $row['nome_fornecedor'] . '</td>';

                echo '<td>' .($row['ativo'] == 1 ? date('d/m/Y', strtotime($row['dataCompra'])) : date('d/m/Y', strtotime($row['dataEntrega'])) ). '</td>';
                echo '<td>' . ($row['ativo'] == 1 ? 'Em andamento' : 'Entregue') . '</td>';
                
                // Botões de opções, incluindo o botão para abrir o modal de Visualizar
                echo '<td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewModal' . $row['idcompra'] . '">Visualizar</button>';
                        if($row['ativo'] == 1){
                        echo' <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idcompra'] . '">Cancelar</button>';
                        }
                    echo'</td>';
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
                                    echo' <form action="../../App/Database/concluirCompra.php" method="POST">
                                    <input type="hidden" name="idcompra" value="' . $row['idcompra'] . '">
                                    <button type="submit" class="btn btn-success">Concluir Compra</button>
                                    </form>';
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


    public function concluirCompra($idCompra)
    {
        $dataAtual = date('Y-m-d');
        $queryCompra = "UPDATE `compra` SET `ativo` = 0, `dataEntrega` = '$dataAtual' WHERE `idcompra` = '$idCompra'";
        mysqli_query($this->SQL, $queryCompra) or die(mysqli_error($this->SQL));

        $queryProdutos = "SELECT produto_id, quantidade FROM compra_has_produto WHERE compra_id = '$idCompra'";
        $resultProdutos = mysqli_query($this->SQL, $queryProdutos);

        while ($produto = mysqli_fetch_assoc($resultProdutos)) {
            $idProduto = $produto['produto_id'];
            $quantidadeComprada = $produto['quantidade'];

       
            $queryEstoque = "UPDATE produto SET quantidade = quantidade + $quantidadeComprada WHERE idproduto = '$idProduto'";
            mysqli_query($this->SQL, $queryEstoque) or die(mysqli_error($this->SQL));
        }

        return true;
    }


    public function getRelatorioCompras() {
        $query = "SELECT 
                    c.idcompra, 
                    c.dataCompra, 
                    c.dataEntrega, 
                    c.ativo, 
                    f.nome AS nome_fornecedor, 
                    f.telefone AS telefone_fornecedor,
                    f.email AS email_fornecedor, 
                    f.numConta AS conta_fornecedor, 
                    f.agencia AS agencia_fornecedor, 
                    f.banco AS banco_fornecedor,
                    GROUP_CONCAT(p.nome SEPARATOR ', ') AS itensComprados,
                    GROUP_CONCAT(cp.quantidade SEPARATOR ', ') AS quantidades
                  FROM `compra` c
                  JOIN `fornecedor` f ON c.fornecedor_idfornecedor = f.idfornecedor
                  JOIN `compra_has_produto` cp ON c.idcompra = cp.compra_id
                  JOIN `produto` p ON cp.produto_id = p.idproduto
                  WHERE c.public = 1
                  GROUP BY c.idcompra
                  ORDER BY c.dataCompra DESC";
        
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
        return $result;
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
