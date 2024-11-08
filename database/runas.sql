-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/11/2024 às 11:15
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
-- Banco de dados: `runas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividade`
--

CREATE TABLE `atividade` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `caminho_arquivo` varchar(255) DEFAULT NULL,
  `categoria` varchar(200) DEFAULT NULL,
  `horas_atividade` int(11) DEFAULT NULL,
  `discente_id` int(11) DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL,
  `data_upload` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `atividade`
--

INSERT INTO `atividade` (`id`, `nome`, `caminho_arquivo`, `categoria`, `horas_atividade`, `discente_id`, `status`, `data_upload`) VALUES
(1, 'teste1', '../atividades/Captura de tela de 2024-10-17 14-53-12.png', 'seminario', 122, 1, 'Pendente', '2024-10-25 20:33:58'),
(2, 'teste3', '../atividades/luig3_1729889082.jpeg', 'workshop', 122, 1, 'Pendente', '2024-10-25 20:44:43'),
(3, 'teste3', '../atividades/luig3_1729889117.jpeg', 'workshop', 122, 1, 'Pendente', '2024-10-25 20:45:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `curso`
--

INSERT INTO `curso` (`id`, `nome`) VALUES
(1, 'INFORMATICA');

-- --------------------------------------------------------

--
-- Estrutura para tabela `discente`
--

CREATE TABLE `discente` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `matricula` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `turno` varchar(100) NOT NULL,
  `turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `discente`
--

INSERT INTO `discente` (`id`, `nome`, `cpf`, `matricula`, `email`, `senha`, `telefone`, `endereco`, `turno`, `turma`) VALUES
(1, 'Miguel Domiciano Vieira', '400', '14', 'Miguel@teste.com', '#Migueldv1', '41999999999', 'Rua João Goulart 555', 'manha', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `docente`
--

CREATE TABLE `docente` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `matricula` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(10) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `docente`
--

INSERT INTO `docente` (`id`, `nome`, `cpf`, `matricula`, `email`, `senha`, `telefone`, `endereco`, `curso`) VALUES
(1, 'Docente informatica', '4010', '13131313', 'docente@email.com', 'Migueldv1', '', '', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `turma`
--

CREATE TABLE `turma` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turma`
--

INSERT INTO `turma` (`id`, `nome`, `curso`) VALUES
(3, 'INFO21', 1),
(6, 'INFO220', 1),
(9, 'INFO19', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `atividade`
--
ALTER TABLE `atividade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atividades_discente` (`discente_id`);

--
-- Índices de tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `discente`
--
ALTER TABLE `discente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_discente_turma` (`turma`);

--
-- Índices de tabela `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_docente_curso` (`curso`);

--
-- Índices de tabela `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_turma_curso` (`curso`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atividade`
--
ALTER TABLE `atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `discente`
--
ALTER TABLE `discente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `turma`
--
ALTER TABLE `turma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `fk_atividades_discente` FOREIGN KEY (`discente_id`) REFERENCES `discente` (`id`);

--
-- Restrições para tabelas `discente`
--
ALTER TABLE `discente`
  ADD CONSTRAINT `fk_discente_turma` FOREIGN KEY (`turma`) REFERENCES `turma` (`id`);

--
-- Restrições para tabelas `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `fk_docente_curso` FOREIGN KEY (`curso`) REFERENCES `curso` (`id`);

--
-- Restrições para tabelas `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `fk_turma_curso` FOREIGN KEY (`curso`) REFERENCES `curso` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
