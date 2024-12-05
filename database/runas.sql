-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 05-Dez-2024 às 17:55
-- Versão do servidor: 10.6.18-MariaDB-0ubuntu0.22.04.1
-- versão do PHP: 8.1.31

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
-- Estrutura da tabela `atividade`
--

CREATE TABLE `atividade` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `caminho_arquivo` varchar(255) DEFAULT NULL,
  `categoria` varchar(200) DEFAULT NULL,
  `horas_atividade` int(11) DEFAULT NULL,
  `discente_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `data_upload` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `atividade`
--

INSERT INTO `atividade` (`id`, `nome`, `caminho_arquivo`, `categoria`, `horas_atividade`, `discente_id`, `status`, `data_upload`) VALUES
(1, 'teste1', '../atividades/Captura de tela de 2024-10-17 14-53-12.png', 'seminario', 6, 1, 1, '2024-10-25 20:33:58'),
(2, 'teste3', '../atividades/luig3_1729889082.jpeg', 'workshop', 11, 1, 1, '2024-10-25 20:44:43'),
(3, 'teste3', '../atividades/luig3_1729889117.jpeg', 'workshop', 12, 1, 1, '2024-10-25 20:45:17'),
(4, 'relat', '../atividades/REL ESTUDANTE 3_MIGUEL DOMICIANO VIEIRA_8cbb12d7fbe1f8b4fb7c31738cf7cdfd.pdf', 'seminario', 10, 1, 2, '2024-11-19 18:21:29'),
(5, 'eadad', '../atividades/ACORDO DE COOPERAÇÃO E TERMO DE COMPROMISSO DE ESTÁGIO Nº - TERMO ADITIVO coletar assinaturas_7f2e31f5c92fb756d047bf642a9bd1e5.pdf', 'workshop', 0, 1, 1, '2024-11-26 17:56:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `horas_necessarias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id`, `nome`, `horas_necessarias`) VALUES
(1, 'INFORMATICA', 150);

-- --------------------------------------------------------

--
-- Estrutura da tabela `discente`
--

CREATE TABLE `discente` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `matricula` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `turno` varchar(100) DEFAULT NULL,
  `turma` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `discente`
--

INSERT INTO `discente` (`id`, `nome`, `cpf`, `matricula`, `email`, `senha`, `telefone`, `endereco`, `turno`, `turma`, `status`) VALUES
(1, 'Miguel Domiciano Vieira', '400', '15', 'Miguel@teste.com', '#Migueldv1', '41999999999', 'Rua João Goulart 555', 'manha', 3, 1),
(3, 'Marcio Vieira', '11007000020', '1313131313', 'marcio@teste.com', NULL, '41414141414', NULL, 'Manha', 3, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `docente`
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
-- Extraindo dados da tabela `docente`
--

INSERT INTO `docente` (`id`, `nome`, `cpf`, `matricula`, `email`, `senha`, `telefone`, `endereco`, `curso`) VALUES
(1, 'Docente informatica', '4010', '13131313', 'docente@email.com', 'Migueldv1', '', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

CREATE TABLE `turma` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `turma`
--

INSERT INTO `turma` (`id`, `nome`, `curso`) VALUES
(3, 'INFO21', 1),
(6, 'INFO220', 1),
(9, 'INFO19', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atividade`
--
ALTER TABLE `atividade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atividades_discente` (`discente_id`);

--
-- Índices para tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `discente`
--
ALTER TABLE `discente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_discente_turma` (`turma`);

--
-- Índices para tabela `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_docente_curso` (`curso`);

--
-- Índices para tabela `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_turma_curso` (`curso`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atividade`
--
ALTER TABLE `atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `discente`
--
ALTER TABLE `discente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `fk_atividades_discente` FOREIGN KEY (`discente_id`) REFERENCES `discente` (`id`);

--
-- Limitadores para a tabela `discente`
--
ALTER TABLE `discente`
  ADD CONSTRAINT `fk_discente_turma` FOREIGN KEY (`turma`) REFERENCES `turma` (`id`);

--
-- Limitadores para a tabela `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `fk_docente_curso` FOREIGN KEY (`curso`) REFERENCES `curso` (`id`);

--
-- Limitadores para a tabela `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `fk_turma_curso` FOREIGN KEY (`curso`) REFERENCES `curso` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
