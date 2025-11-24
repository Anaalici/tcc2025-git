-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/11/2025 às 06:26
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
-- Banco de dados: `receitadmestre`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `idAvaliacao` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idReceita` int(11) NOT NULL,
  `idTempero` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `dataHora` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoriareceita`
--

CREATE TABLE `categoriareceita` (
  `idCategoriaRec` int(11) NOT NULL,
  `categoriaRec` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoriatempero`
--

CREATE TABLE `categoriatempero` (
  `idCategoriaTemp` int(11) NOT NULL,
  `categoriaTemp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contato`
--

CREATE TABLE `contato` (
  `idContato` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,            
  `email` varchar(100) NOT NULL,           
  `assunto` varchar(100) NOT NULL,         
  `mensagem` text NOT NULL,                
  `idUsuario` int(11) DEFAULT NULL,        
  `data_envio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `receita`
--

CREATE TABLE `receita` (
  `idReceita` int(11) NOT NULL,
  `nomeReceita` varchar(50) NOT NULL,
  `descricaoReceita` varchar(255) NOT NULL,
  `ingredientes` varchar(255) NOT NULL,
  `modoPreparo` varchar(255) NOT NULL,
  `tempoMedio` varchar(50) NOT NULL,
  `idCategoriaRec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tempero`
--

CREATE TABLE `tempero` (
  `idTempero` int(11) NOT NULL,
  `nomeTempero` varchar(50) NOT NULL,
  `utilidade` varchar(255) NOT NULL,
  `beneficios` varchar(255) NOT NULL,
  `idCategoriaTemp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nomeUsuario` varchar(255) NOT NULL,
  `dataNasc` date NOT NULL,
  `cpf` char(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contato` char(11) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `dataCadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`idAvaliacao`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idReceita` (`idReceita`),
  ADD KEY `idTempero` (`idTempero`);

--
-- Índices de tabela `categoriareceita`
--
ALTER TABLE `categoriareceita`
  ADD PRIMARY KEY (`idCategoriaRec`);

--
-- Índices de tabela `categoriatempero`
--
ALTER TABLE `categoriatempero`
  ADD PRIMARY KEY (`idCategoriaTemp`);

--
-- Índices de tabela `contato`
--
ALTER TABLE `contato`
  ADD PRIMARY KEY (`idContato`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`idReceita`),
  ADD KEY `idCategoriaRec` (`idCategoriaRec`);

--
-- Índices de tabela `tempero`
--
ALTER TABLE `tempero`
  ADD PRIMARY KEY (`idTempero`),
  ADD KEY `idCategoriaTemp` (`idCategoriaTemp`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `idAvaliacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoriareceita`
--
ALTER TABLE `categoriareceita`
  MODIFY `idCategoriaRec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoriatempero`
--
ALTER TABLE `categoriatempero`
  MODIFY `idCategoriaTemp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contato`
--
ALTER TABLE `contato`
  MODIFY `idContato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `receita`
--
ALTER TABLE `receita`
  MODIFY `idReceita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tempero`
--
ALTER TABLE `tempero`
  MODIFY `idTempero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`idReceita`) REFERENCES `receita` (`idReceita`),
  ADD CONSTRAINT `avaliacao_ibfk_3` FOREIGN KEY (`idTempero`) REFERENCES `tempero` (`idTempero`);

--
-- Restrições para tabelas `contato`
--
ALTER TABLE `contato`
  ADD CONSTRAINT `contato_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Restrições para tabelas `receita`
--
ALTER TABLE `receita`
  ADD CONSTRAINT `receita_ibfk_1` FOREIGN KEY (`idCategoriaRec`) REFERENCES `categoriareceita` (`idCategoriaRec`);

ALTER TABLE `usuario`
ADD COLUMN `tokenRedefinicao` VARCHAR(255) NULL AFTER `senha`,
ADD COLUMN `expiracaoToken` DATETIME NULL AFTER `tokenRedefinicao`;
--
-- Restrições para tabelas `tempero`
--
ALTER TABLE `tempero`
  ADD CONSTRAINT `tempero_ibfk_1` FOREIGN KEY (`idCategoriaTemp`) REFERENCES `categoriatempero` (`idCategoriaTemp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
