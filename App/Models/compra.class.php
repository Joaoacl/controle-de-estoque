<?php

require_once 'connect.php';
require_once '../../App/Models/produto.class.php';



class Compras extends Connect
{
    public function index($value)
    {
        $query = "SELECT sc.idsolicitaCompra, sc.dataEntrega, sc.quantidade, sc.produto_idproduto, sc.fornecedor_idfornecedor, sc.ativo, f.nome AS nome_fornecedor
                FROM `solicitacompra` sc 
                JOIN `fornecedor` f ON sc.fornecedor_idfornecedor = f.idfornecedor
                WHERE sc.ativo = '$value'";

        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        if ($result) {
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Produtos Solicitados</th>
                        <th>Quantidade</th>
                        <th>Fornecedor</th>
                        <th>Previsão Entrega</th>
                        <th>Status</th>                       
                        <th>Opções</th>
                    </tr>
                </thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_array($result)) {
                $ativo_class = ($row['ativo'] == 0) ? 'class="success"' : '';
                echo '<tr ' . $ativo_class . '>';
                echo '<td>' . $row['idsolicitaCompra'] . '</td>';
                echo '<td>' . $row['produto_idproduto'] . '</td>';
                echo '<td>' . $row['quantidade'] . '</td>';
                echo '<td>' . $row['nome_fornecedor'] . '</td>';
                echo '<td>' . date('d/m/Y', strtotime($row['dataEntrega'])) .  '</td>';
                echo '<td>' . ($row['ativo'] == 1 ? 'Em andamento' : 'Entregue') . '</td>';
                
                // Botões de opções, incluindo o botão para abrir o modal de Visualizar
                echo '<td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewModal' . $row['idsolicitaCompra'] . '">Visualizar</button>';
                        
                        //<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idvenda'] . '">Excluir</button>
                        
                    echo'</td>';
                echo '</tr>';

                // Modal informações da venda
                echo '<div class="modal fade" id="viewModal' . $row['idsolicitaCompra'] . '" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel' . $row['idsolicitaCompra'] . '" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h4 class="modal-title" id="viewModalLabel' . $row['idsolicitaCompra'] . '">Detalhes da Compra</h4>
                                </div>
                                <div class="modal-body">
                                    <p><strong>ID da Solicitação:</strong> ' . $row['idsolicitaCompra'] . '</p>
                                    <h4><strong>Itens da compra</strong></h4>
                                    <p><strong>Produto:</strong> ' . $row['produto_idproduto'] . '</p>
                                    <p><strong>Quantidade:</strong> ' . $row['quantidade'] . '</p>
                                    <p><strong>Fornecedor:</strong> ' . $row['fornecedor_idfornecedor']. '</p>
                                    <p><strong>Previsão de Entrega:</strong> ' . date('d/m/Y', strtotime($row['dataEntrega'])) . '</p>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">Concluir</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>    
                                </div>
                            </div>
                        </div>
                    </div>';

                // Modal de Exclusão
                echo '<div class="modal fade" id="deleteModal' . $row['idsolicitaCompra'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idsolicitaCompra'] . '" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="deleteModalLabel' . $row['idsolicitaCompra'] . '">Excluir Venda</h5>
                                </div>
                                <div class="modal-body">
                                    Você tem certeza que deseja excluir a venda <strong>' . $row['idsolicitaCompra'] . '</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="../../App/Database/delvenda.php" method="POST">
                                        <input type="hidden" name="idsolicitaCompra" value="' . $row['idsolicitaCompra'] . '">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="upload" value="Cadastrar" class="btn btn-danger">Excluir</button>
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


    public function InsertVenda($cliente, $valor_total, $data_venda, $idCesta)
    {      
        if (!$this->quantidadeEstoque($idCesta)) {
            header('Location: ../../views/vendas/index.php?alert=estoque_insuficiente');
            return false;
        }

        $query = "INSERT INTO `venda`(`valorTotal`, `cliente_idcliente`, `dataVenda`, `public`) 
                VALUES ('$valor_total','$cliente', '$data_venda', '1')";
        if (mysqli_query($this->SQL, $query)) {
            $idVenda = mysqli_insert_id($this->SQL);
            // Seleciona os produtos e quantidades da cesta
            $queryProdutosCesta = "SELECT produto_idproduto, quantidade 
                                FROM cestabasica_has_produto 
                                WHERE cestaBasica_idcestaBasica = $idCesta";
            $resultProdutosCesta = mysqli_query($this->SQL, $queryProdutosCesta) or die(mysqli_error($this->SQL));

            // Atualiza o estoque de cada produto na cesta
            while ($produto = mysqli_fetch_assoc($resultProdutosCesta)) {
                $idproduto = $produto['produto_idproduto'];
                $quantidadeVendida = $produto['quantidade'];

                // Reduz a quantidade no estoque do produto
                $queryUpdateEstoque = "UPDATE `produto` SET `quantidade` = `quantidade` - $quantidadeVendida 
                                    WHERE `idproduto` = $idproduto";
                mysqli_query($this->SQL, $queryUpdateEstoque) or die(mysqli_error($this->SQL));

                $this->verificarEstoque($idproduto);
            }

            return $idVenda;
        } else {
            return false;
        }
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

    public function quantidadeEstoque($idCesta)
    {
        // Seleciona os produtos e quantidades necessários para a cesta
        $query = "SELECT p.idproduto, p.quantidade, chp.quantidade AS quantidadeNecessaria
                  FROM produto p
                  JOIN cestabasica_has_produto chp ON p.idproduto = chp.produto_idproduto
                  WHERE chp.cestaBasica_idcestaBasica = $idCesta";
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        // Verifica cada produto para garantir que há estoque suficiente
        while ($produto = mysqli_fetch_assoc($result)) {
            if ($produto['quantidade'] < $produto['quantidadeNecessaria']) {
                // Se o estoque for insuficiente, retorna falso
                return false;
            }
        }
        // Se todos os produtos têm estoque suficiente, retorna verdadeiro
        return true;
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
        $query = "UPDATE `venda` SET `public` = 0 WHERE `idvenda` = '$idvenda'";
        mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
        
        header('Location: ../../views/vendas/index.php?alert=deletado');
    }
}

$compras = new Compras;
