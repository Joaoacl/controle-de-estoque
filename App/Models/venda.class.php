<?php

require_once 'connect.php';
require_once '../../App/Models/produto.class.php';
require_once '../../App/Models/cestas.class.php';


class Vendas extends Connect
{
    public function index($value)
    {
        $query = "SELECT v.idvenda, v.cliente_idcliente, v.dataVenda, v.valorTotal, v.public, 
                cli.nome AS nome_cliente, cli.desconto AS desconto_cliente, cli.telefone AS telefone_cliente, 
                u.nomeUsuario AS nome_vendedor,
                GROUP_CONCAT(CONCAT(c.nome) SEPARATOR ' | ') AS itensVendidos,
                GROUP_CONCAT(CONCAT(c.nome, ' | Qtd: ', cv.quantidade) SEPARATOR ' </br> ') AS detalhesItensVendidos
            FROM `venda` v 
            JOIN `cliente` cli ON v.cliente_idcliente = cli.idcliente
            JOIN `cestabasica_has_venda` cv ON v.idvenda = cv.venda_idvenda
            JOIN `cestabasica` c ON cv.cestaBasica_idcestaBasica = c.idcestaBasica         
            JOIN `usuario_has_venda` uv ON v.idvenda = uv.venda_idvenda
            JOIN `usuario` u ON uv.usuario_idusuario = u.idusuario
            WHERE v.`public` = '$value'
            GROUP BY v.idvenda";

        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        if ($result) {
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Itens Vendidos</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Total da Venda</th>
                        <th>Data da Venda</th>                      
                        <th>Opções</th>
                    </tr>
                </thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_array($result)) {
                $public_class = ($row['public'] == 0) ? 'class="danger"' : '';
                echo '<tr ' . $public_class . '>';
                echo '<td>' . $row['idvenda'] . '</td>';
                echo '<td>' . $row['itensVendidos'] . '</td>'; // Exibe todos os itens vendidos em uma única célula
                echo '<td>' . $row['nome_cliente'] . '</td>';
                echo '<td>' . $row['nome_vendedor'] . '</td>';
                echo '<td>R$ ' . $row['valorTotal'] . '</td>';   
                echo '<td>' . date('d/m/Y', strtotime($row['dataVenda'])) . '</td>';
                
             
                echo '<td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewModal' . $row['idvenda'] . '">Visualizar</button>';
                        if($row['public'] == 1){
                        echo' <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idvenda'] . '">Cancelar</button>';
                        }
                    echo'</td>';
                echo '</tr>';

                // Modal informações da venda
                echo '<div class="modal fade" id="viewModal' . $row['idvenda'] . '" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel' . $row['idvenda'] . '" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h4 class="modal-title" id="viewModalLabel' . $row['idvenda'] . '">Detalhes da Venda</h4>
                                </div>
                                <div class="modal-body">
                                    <p><strong>ID da Venda:</strong> ' . $row['idvenda'] . '</p>
                                    <h4 class="text-primary"><strong>Cliente</strong></h4>
                                    <p><strong>Nome Cliente:</strong> ' . $row['nome_cliente'] . '</p>
                                    <p><strong>Telefone Cliente:</strong> ' . $row['telefone_cliente'] . '</p>
                                    <p><strong>Desconto do Cliente:</strong> ' . ($row['desconto_cliente'] == null ? '0' : $row['desconto_cliente']). ' %</p>
                                
                                    <h4 class="text-primary"><strong>Vendedor</strong></h4>
                                    <p><strong>Nome Vendedor:</strong> ' . $row['nome_vendedor'] . '</p>
                                
                                    <h4 class="text-primary"><strong>Itens Vendidos</strong></h4>
                                    <p>' . $row['detalhesItensVendidos'] . '</p>
                                    <p class="col-8 text-success"><strong>Valor Total:</strong > R$ ' . $row['valorTotal'] . '</p>
                                    <p><strong>Data da Venda:</strong> ' . date('d/m/Y', strtotime($row['dataVenda'])) . '</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>';

                // Modal de Exclusão
                echo '<div class="modal fade" id="deleteModal' . $row['idvenda'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idvenda'] . '" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="deleteModalLabel' . $row['idvenda'] . '">Cancelar Venda</h5>
                                </div>
                                <div class="modal-body">
                                    Você tem certeza que deseja cancelar a venda <strong>' . $row['idvenda'] . '</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="../../App/Database/delvenda.php" method="POST">
                                        <input type="hidden" name="idvenda" value="' . $row['idvenda'] . '">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        <button type="submit" name="upload" value="Cadastrar" class="btn btn-danger">Cancelar</button>
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



    public function InsertVenda($cliente, $valor_total, $data_venda, $cestasSelecionadas, $cestas)
    {
      
        $produtosNecessarios = [];

      
        foreach ($cestasSelecionadas as $cesta) {
            $idCesta = $cesta['id'];
            $quantidade = $cesta['quantidade'];

           
            $queryProdutosCesta = "SELECT produto_idproduto, quantidade 
                                FROM cestabasica_has_produto 
                                WHERE cestaBasica_idcestaBasica = $idCesta";
            $resultProdutosCesta = mysqli_query($this->SQL, $queryProdutosCesta) or die(mysqli_error($this->SQL));

            while ($produto = mysqli_fetch_assoc($resultProdutosCesta)) {
                $idproduto = $produto['produto_idproduto'];
                $quantidadeNecessaria = $produto['quantidade'] * $quantidade;

               
                if (isset($produtosNecessarios[$idproduto])) {
                    $produtosNecessarios[$idproduto] += $quantidadeNecessaria;
                } else {
                    $produtosNecessarios[$idproduto] = $quantidadeNecessaria;
                }
            }
        }

        
        $estoqueInsuficiente = false;
        foreach ($produtosNecessarios as $idproduto => $quantidadeTotalNecessaria) {
            $queryEstoque = "SELECT quantidade FROM produto WHERE idproduto = $idproduto";
            $resultEstoque = mysqli_query($this->SQL, $queryEstoque) or die(mysqli_error($this->SQL));
            $produto = mysqli_fetch_assoc($resultEstoque);

            if ($produto['quantidade'] < $quantidadeTotalNecessaria) {
                $estoqueInsuficiente = true;
                break;
            }
        }

       
        if ($estoqueInsuficiente) {
            header('Location: ../../views/vendas/index.php?alert=estoque_insuficiente');
            return false;
        }

      
        $query = "INSERT INTO `venda`(`valorTotal`, `cliente_idcliente`, `dataVenda`, `public`) 
                VALUES ('$valor_total', '$cliente', '$data_venda', '1')";
        if (mysqli_query($this->SQL, $query)) {
            $idVenda = mysqli_insert_id($this->SQL);

            
            foreach ($produtosNecessarios as $idproduto => $quantidadeTotalNecessaria) {
                $queryUpdateEstoque = "UPDATE `produto` SET `quantidade` = `quantidade` - $quantidadeTotalNecessaria 
                                    WHERE `idproduto` = $idproduto";
                mysqli_query($this->SQL, $queryUpdateEstoque) or die(mysqli_error($this->SQL));

                $this->verificarEstoque($idproduto);
            }

            
            foreach ($cestasSelecionadas as $cesta) {
                $idCesta = $cesta['id'];
                $quantidade = $cesta['quantidade'];
                $cestas->InsertCestaVendida($idCesta, $idVenda, $data_venda, $quantidade);
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
                
                $_SESSION['notificacoes'][] = "O produto " . $produto['nome'] . " está com estoque baixo. Apenas " . $produto['quantidade'] . " unidades restantes.";
            }
        }
    }

    public function quantidadeEstoque($idCesta, $quantidadeCesta)
    {
        $produtosInsuficientes = [];

        $query = "SELECT p.idproduto, p.nome, p.quantidade, chp.quantidade AS quantidadeNecessaria
                FROM produto p
                JOIN cestabasica_has_produto chp ON p.idproduto = chp.produto_idproduto
                WHERE chp.cestaBasica_idcestaBasica = $idCesta";
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        while ($produto = mysqli_fetch_assoc($result)) {
            $quantidadeTotalNecessaria = $produto['quantidadeNecessaria'] * $quantidadeCesta;
            if ($produto['quantidade'] < $quantidadeTotalNecessaria) {
                $produtosInsuficientes[] = [
                    'idproduto' => $produto['idproduto'],
                    'nome' => $produto['nome'],
                    'estoqueAtual' => $produto['quantidade'],
                    'necessario' => $quantidadeTotalNecessaria
                ];
            }
        }

        return $produtosInsuficientes;
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

    public function cancelarVenda($idvenda)
    {
        $query = "SELECT * FROM `venda` WHERE `idvenda` = '$idvenda' AND `public` = 1";
        $result = mysqli_query($this->SQL, $query);

        if (mysqli_num_rows($result) > 0) {
            
            $queryProdutos = "SELECT chp.produto_idproduto, chp.quantidade, cv.quantidade AS quantidadeVendida
                            FROM `cestabasica_has_produto` chp
                            JOIN `cestabasica_has_venda` cv ON chp.cestaBasica_idcestaBasica = cv.cestaBasica_idcestaBasica
                            WHERE cv.venda_idvenda = '$idvenda'";
            $resultProdutos = mysqli_query($this->SQL, $queryProdutos);

            
            while ($produto = mysqli_fetch_assoc($resultProdutos)) {
                $idproduto = $produto['produto_idproduto'];
                $quantidadeParaAdicionar = $produto['quantidade'] * $produto['quantidadeVendida'];

                
                $queryUpdateEstoque = "UPDATE `produto` SET `quantidade` = `quantidade` + $quantidadeParaAdicionar 
                                    WHERE `idproduto` = $idproduto";
                mysqli_query($this->SQL, $queryUpdateEstoque) or die(mysqli_error($this->SQL));
            }

           
            $queryCancelarVenda = "UPDATE `venda` SET `public` = 0 WHERE `idvenda` = '$idvenda'";
            mysqli_query($this->SQL, $queryCancelarVenda) or die(mysqli_error($this->SQL));

            
            header('Location: ../../views/vendas/index.php?alert=venda_cancelada');
        } else {
            
            header('Location: ../../views/vendas/index.php?alert=erro_cancelamento');
        }
    }

    public function getRelatorioVendas() {
        $query = "SELECT 
                    v.idvenda, 
                    v.valorTotal, 
                    v.dataVenda, 
                    cli.nome AS nome_cliente, 
                    cli.telefone AS telefone_cliente,
                    u.nomeUsuario AS nome_vendedor,
                    GROUP_CONCAT(c.nome SEPARATOR ', ') AS itensVendidos,
                    GROUP_CONCAT(cv.quantidade SEPARATOR ', ') AS quantidadeVendida
                  FROM `venda` v 
                  JOIN `cliente` cli ON v.cliente_idcliente = cli.idcliente
                  JOIN `usuario_has_venda` uv ON v.idvenda = uv.venda_idvenda
                  JOIN `usuario` u ON uv.usuario_idusuario = u.idusuario
                  JOIN `cestaBasica_has_venda` cv ON v.idvenda = cv.venda_idvenda
                  JOIN `cestaBasica` c ON cv.cestaBasica_idcestaBasica = c.idcestaBasica
                  WHERE v.public = 1
                  GROUP BY v.idvenda
                  ORDER BY v.dataVenda DESC";
        
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
        return $result;
    }
    
    
    public function getRelatorioFinanceiro() {
        // 1. Consulta para obter o total das vendas realizadas
        $queryVendas = "
            SELECT 
                SUM(v.valorTotal) AS total_vendas 
            FROM venda v 
            WHERE v.public = 1";
        $resultVendas = mysqli_query($this->SQL, $queryVendas);
        $totalVendas = mysqli_fetch_assoc($resultVendas)['total_vendas'];
    
        // 2. Consulta para obter o custo total dos produtos utilizados nas cestas vendidas
        $queryCustoProdutos = "
            SELECT 
                SUM(p.valor * chp.quantidade * cv.quantidade) AS custo_total
            FROM cestabasica_has_venda cv
            JOIN cestabasica_has_produto chp ON cv.cestaBasica_idcestaBasica = chp.cestaBasica_idcestaBasica
            JOIN produto p ON chp.produto_idproduto = p.idproduto
            WHERE cv.venda_idvenda IN (SELECT idvenda FROM venda WHERE public = 1)";
        $resultCustoProdutos = mysqli_query($this->SQL, $queryCustoProdutos);
        $custoTotal = mysqli_fetch_assoc($resultCustoProdutos)['custo_total'];
    
        // 3. Calcular o lucro
        $lucro = $totalVendas - $custoTotal;
    
        return [
            'total_vendas' => $totalVendas,
            'custo_total' => $custoTotal,
            'lucro' => $lucro
        ];
    }
    

    public function deleteVenda($idvenda)
    {
        $query = "UPDATE `venda` SET `public` = 0 WHERE `idvenda` = '$idvenda'";
        mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
        
        header('Location: ../../views/vendas/index.php?alert=deletado');
    }
}

$vendas = new Vendas;
