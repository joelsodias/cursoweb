-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 26/11/2019 às 16:20
-- Versão do servidor: 10.4.10-MariaDB-1:10.4.10+maria~eoan
-- Versão do PHP: 7.3.11-1+ubuntu19.10.1+deb.sury.org+6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mesquitaweb201902`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `id` bigint(20) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_agendamento` datetime NOT NULL,
  `especialidade` varchar(10) NOT NULL,
  `paciente` varchar(200) NOT NULL,
  `medico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `agendamento`
--

INSERT INTO `agendamento` (`id`, `data_cadastro`, `data_agendamento`, `especialidade`, `paciente`, `medico`) VALUES
(9, '2019-11-26 18:20:30', '2019-11-26 08:00:00', 'CLI', 'Joao Santos', 1),
(10, '2019-11-26 18:22:03', '2019-11-26 08:00:00', 'PIS', 'Maria de Lourdes', 1),
(11, '2019-11-26 18:25:03', '2019-11-26 08:00:00', 'OTO', 'Jose Afonso Soares', 1),
(12, '2019-11-26 18:31:54', '2019-11-26 08:00:00', 'PED', 'Tadeu Oliveira', 1),
(13, '2019-11-26 18:51:53', '2019-11-26 08:00:00', 'CLI', 'Ronaldo Vicentino', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `especialidade`
--

CREATE TABLE `especialidade` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ativa` tinyint(1) NOT NULL,
  `codigo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `especialidade`
--

INSERT INTO `especialidade` (`id`, `nome`, `ativa`, `codigo`) VALUES
(1, 'PEDIATRIA', 1, 'PED'),
(2, 'CLINICO GERAL', 1, 'CLI'),
(5, 'OTORRINO', 1, 'OTO'),
(6, 'PSICOLOGIA', 1, 'PIS');

-- --------------------------------------------------------

--
-- Estrutura para tabela `medico`
--

CREATE TABLE `medico` (
  `id` bigint(20) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `nascimento` date NOT NULL,
  `especialidade` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `medico`
--

INSERT INTO `medico` (`id`, `nome`, `nascimento`, `especialidade`) VALUES
(1, 'Marcelo Sheffell', '1978-10-23', 'PED'),
(2, 'Maria Carla Nunes', '1984-02-15', 'CLI'),
(3, 'Robson Antunes', '1989-05-12', 'OTO'),
(4, 'Roberto Maciel', '1988-04-15', 'CLI'),
(5, 'Jonas Dias', '1976-03-11', 'PIS'),
(6, 'Marilia Chan', '1983-09-17', 'CLI');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `especialidade`
--
ALTER TABLE `especialidade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `espec_codigo` (`codigo`);

--
-- Índices de tabela `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `especialidade`
--
ALTER TABLE `especialidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `medico`
--
ALTER TABLE `medico`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
