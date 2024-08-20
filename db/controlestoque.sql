-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/08/2024 às 04:30
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `controlestoque`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoriacesta`
--

CREATE TABLE `categoriacesta` (
  `idcategoriaCesta` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `ativo` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `categoriacesta`
--

INSERT INTO `categoriacesta` (`idcategoriaCesta`, `nome`, `ativo`) VALUES
(1, 'Alimentícia', 1),
(2, 'Limpeza', 1),
(3, 'teste1', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cestabasica`
--

CREATE TABLE `cestabasica` (
  `idcestaBasica` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `valor` varchar(45) DEFAULT NULL,
  `categoriaCesta_idcategoriaCesta` int(11) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `cestabasica`
--

INSERT INTO `cestabasica` (`idcestaBasica`, `nome`, `descricao`, `valor`, `categoriaCesta_idcategoriaCesta`, `ativo`) VALUES
(1, 'Cesta Básica', 'Cesta composta por produtos alimentícios', '130,00', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cestabasica_has_produto`
--

CREATE TABLE `cestabasica_has_produto` (
  `cestaBasica_idcestaBasica` int(11) NOT NULL,
  `produto_idproduto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `cestabasica_has_produto`
--

INSERT INTO `cestabasica_has_produto` (`cestaBasica_idcestaBasica`, `produto_idproduto`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cestabasica_has_venda`
--

CREATE TABLE `cestabasica_has_venda` (
  `cestaBasica_idcestaBasica` int(11) NOT NULL,
  `venda_idvenda` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `dataVenda` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `cpf` varchar(45) NOT NULL,
  `desconto` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `telefone` varchar(11) NOT NULL,
  `endereco_idendereco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nome`, `cpf`, `desconto`, `email`, `telefone`, `endereco_idendereco`) VALUES
(1, 'Joaozinho', '12345678911', NULL, 'joaozinho@gmail.com', '17988888888', 1),
(2, 'julia', '233472844', '10', 'julia@email.com', '17988888888', 4),
(4, 'ana', '2324324342', '10', 'ana@email.com', '21355645636', 5),
(5, 'nicolas', '1234567890', '5', 'nicolas@gmail.com', '1837378273', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `idendereco` int(11) NOT NULL,
  `rua` varchar(45) NOT NULL,
  `numero` varchar(45) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `endereco`
--

INSERT INTO `endereco` (`idendereco`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `cep`) VALUES
(1, 'joao clemente', '1234', 'amarelo', 'bebedouro', 'sp', '14784087'),
(2, 'brigadeiro', '0987', 'vermelho', 'barretos', 'sp', '27567987'),
(3, 'Rua Exemplo', '123', 'Bairro Exemplo', 'Cidade Exemplo', 'mg', '12345-678'),
(4, 'Avenida Teste', '456', 'Bairro Teste', 'Cidade Teste', 'sp', '98765-432'),
(5, 'teste', '1213', 'teste', 'teste', 'ts', '231453152'),
(6, 'teste1', '2749', 'teste1', 'teste1', 'sp', '875876986986');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `idfornecedor` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `numConta` varchar(45) DEFAULT NULL,
  `agencia` varchar(45) DEFAULT NULL,
  `banco` varchar(45) DEFAULT NULL,
  `endereco_idendereco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `idproduto` int(11) NOT NULL,
  `ativo` tinyint(4) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `valor` varchar(45) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `descricao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`idproduto`, `ativo`, `nome`, `valor`, `quantidade`, `descricao`) VALUES
(1, 1, 'Arroz', '20,00', 40, 'Arroz de 5kg'),
(2, 1, 'feijão', '10,00', 20, 'Feijão 1kg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacompra`
--

CREATE TABLE `solicitacompra` (
  `idsolicitaCompra` int(11) NOT NULL,
  `dataEntrega` date DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `produto_idproduto` int(11) NOT NULL,
  `fornecedor_idfornecedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `salario` decimal(10,0) DEFAULT NULL,
  `cargo` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `endereco_idendereco` int(11) NOT NULL,
  `permissao` tinyint(4) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nome`, `cpf`, `salario`, `cargo`, `email`, `senha`, `telefone`, `endereco_idendereco`, `permissao`, `imagem`) VALUES
(1, 'admin', '12345678911', NULL, NULL, NULL, 'admin', NULL, 1, 1, 'dist/img/person.png'),
(2, 'joao', '12345678911', 2, 'vendedor', 'joaozinho@gmail.com', '1234', '17988888888', 2, NULL, NULL),
(3, 'João Silva', '12345678901', 2500, 'Vendedor', 'joao.silva@example.com', 'senha123', '1234567890', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_has_venda`
--

CREATE TABLE `usuario_has_venda` (
  `usuario_idusuario` int(11) NOT NULL,
  `venda_idvenda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `idvenda` int(11) NOT NULL,
  `valorTotal` decimal(10,0) DEFAULT NULL,
  `cliente_idcliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categoriacesta`
--
ALTER TABLE `categoriacesta`
  ADD PRIMARY KEY (`idcategoriaCesta`);

--
-- Índices de tabela `cestabasica`
--
ALTER TABLE `cestabasica`
  ADD PRIMARY KEY (`idcestaBasica`),
  ADD KEY `fk_cestaBasica_categoriaCesta1_idx` (`categoriaCesta_idcategoriaCesta`);

--
-- Índices de tabela `cestabasica_has_produto`
--
ALTER TABLE `cestabasica_has_produto`
  ADD PRIMARY KEY (`cestaBasica_idcestaBasica`,`produto_idproduto`),
  ADD KEY `fk_cestaBasica_has_produto_produto1_idx` (`produto_idproduto`),
  ADD KEY `fk_cestaBasica_has_produto_cestaBasica1_idx` (`cestaBasica_idcestaBasica`);

--
-- Índices de tabela `cestabasica_has_venda`
--
ALTER TABLE `cestabasica_has_venda`
  ADD PRIMARY KEY (`cestaBasica_idcestaBasica`,`venda_idvenda`),
  ADD KEY `fk_cestaBasica_has_venda_venda1_idx` (`venda_idvenda`),
  ADD KEY `fk_cestaBasica_has_venda_cestaBasica1_idx` (`cestaBasica_idcestaBasica`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `fk_cliente_endereço_idx` (`endereco_idendereco`);

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`idendereco`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`idfornecedor`),
  ADD KEY `fk_fornecedor_endereco1_idx` (`endereco_idendereco`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idproduto`);

--
-- Índices de tabela `solicitacompra`
--
ALTER TABLE `solicitacompra`
  ADD PRIMARY KEY (`idsolicitaCompra`),
  ADD KEY `fk_solicitaCompra_produto1_idx` (`produto_idproduto`),
  ADD KEY `fk_solicitaCompra_fornecedor1_idx` (`fornecedor_idfornecedor`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `fk_usuario_endereco1_idx` (`endereco_idendereco`);

--
-- Índices de tabela `usuario_has_venda`
--
ALTER TABLE `usuario_has_venda`
  ADD PRIMARY KEY (`usuario_idusuario`,`venda_idvenda`),
  ADD KEY `fk_usuario_has_venda_venda1_idx` (`venda_idvenda`),
  ADD KEY `fk_usuario_has_venda_usuario1_idx` (`usuario_idusuario`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`idvenda`),
  ADD KEY `fk_venda_cliente1_idx` (`cliente_idcliente`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoriacesta`
--
ALTER TABLE `categoriacesta`
  MODIFY `idcategoriaCesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `cestabasica`
--
ALTER TABLE `cestabasica`
  MODIFY `idcestaBasica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `idendereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `idfornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `idproduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `solicitacompra`
--
ALTER TABLE `solicitacompra`
  MODIFY `idsolicitaCompra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `idvenda` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cestabasica`
--
ALTER TABLE `cestabasica`
  ADD CONSTRAINT `fk_cestaBasica_categoriaCesta1` FOREIGN KEY (`categoriaCesta_idcategoriaCesta`) REFERENCES `categoriacesta` (`idcategoriaCesta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cestabasica_has_produto`
--
ALTER TABLE `cestabasica_has_produto`
  ADD CONSTRAINT `fk_cestaBasica_has_produto_cestaBasica1` FOREIGN KEY (`cestaBasica_idcestaBasica`) REFERENCES `cestabasica` (`idcestaBasica`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cestaBasica_has_produto_produto1` FOREIGN KEY (`produto_idproduto`) REFERENCES `produto` (`idproduto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cestabasica_has_venda`
--
ALTER TABLE `cestabasica_has_venda`
  ADD CONSTRAINT `fk_cestaBasica_has_venda_cestaBasica1` FOREIGN KEY (`cestaBasica_idcestaBasica`) REFERENCES `cestabasica` (`idcestaBasica`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cestaBasica_has_venda_venda1` FOREIGN KEY (`venda_idvenda`) REFERENCES `venda` (`idvenda`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_endereco` FOREIGN KEY (`endereco_idendereco`) REFERENCES `endereco` (`idendereco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD CONSTRAINT `fk_fornecedor_endereco1` FOREIGN KEY (`endereco_idendereco`) REFERENCES `endereco` (`idendereco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `solicitacompra`
--
ALTER TABLE `solicitacompra`
  ADD CONSTRAINT `fk_solicitaCompra_fornecedor1` FOREIGN KEY (`fornecedor_idfornecedor`) REFERENCES `fornecedor` (`idfornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitaCompra_produto1` FOREIGN KEY (`produto_idproduto`) REFERENCES `produto` (`idproduto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_endereco1` FOREIGN KEY (`endereco_idendereco`) REFERENCES `endereco` (`idendereco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `usuario_has_venda`
--
ALTER TABLE `usuario_has_venda`
  ADD CONSTRAINT `fk_usuario_has_venda_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_has_venda_venda1` FOREIGN KEY (`venda_idvenda`) REFERENCES `venda` (`idvenda`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `fk_venda_cliente1` FOREIGN KEY (`cliente_idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
