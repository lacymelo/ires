-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Nov-2021 às 22:05
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `place_reservation`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `recurso`
--

CREATE TABLE `recurso` (
  `recurso_id` int(11) NOT NULL,
  `recurso_nome` varchar(100) NOT NULL,
  `data_criacao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `recurso`
--

INSERT INTO `recurso` (`recurso_id`, `recurso_nome`, `data_criacao`) VALUES
(1, 'apagador de quadro branco', '2021-10-25 17:52:58'),
(2, 'data show', '2021-10-25 17:52:58'),
(3, 'cadeira', '2021-10-25 17:52:58'),
(4, 'computador', '2021-10-25 23:17:22'),
(5, 'pincel para quadro branco', '2021-10-28 15:19:06'),
(6, 'bloco de papel', '2021-10-28 16:15:07'),
(7, 'mesa', '2021-11-01 17:22:03'),
(8, 'Armário', '2021-11-01 17:30:45'),
(9, 'Ar condicionado', '2021-11-01 17:31:04');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sala`
--

CREATE TABLE `sala` (
  `sala_id` int(11) NOT NULL,
  `sala_nome` varchar(100) NOT NULL,
  `sala_status` varchar(1) NOT NULL DEFAULT 'F',
  `data_criacao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sala`
--

INSERT INTO `sala` (`sala_id`, `sala_nome`, `sala_status`, `data_criacao`) VALUES
(1, 'Mini Auditório - 1º andar', 'A', '2021-10-25 17:51:19'),
(2, 'Infocentro', 'A', '2021-10-25 23:16:54'),
(5, 'Auditório Alberto Mocbel', 'F', '2021-10-29 16:19:41'),
(6, 'Laboratório de sistemas de informação', 'A', '2021-10-29 16:22:19'),
(7, 'Laboratório de Química', 'F', '2021-10-31 12:13:17'),
(8, 'Labex', 'F', '2021-11-01 17:38:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sala_recurso`
--

CREATE TABLE `sala_recurso` (
  `sala_recurso_id` int(11) NOT NULL,
  `qtd_recurso` int(11) NOT NULL,
  `sala_recurso_sala_id` int(11) NOT NULL,
  `sala_recurso_recurso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sala_recurso`
--

INSERT INTO `sala_recurso` (`sala_recurso_id`, `qtd_recurso`, `sala_recurso_sala_id`, `sala_recurso_recurso_id`) VALUES
(2, 70, 1, 3),
(3, 30, 2, 4),
(4, 1, 5, 2),
(5, 100, 5, 3),
(9, 40, 6, 3),
(19, 20, 6, 6),
(27, 40, 7, 3),
(29, 1, 7, 2),
(30, 1, 7, 4),
(33, 2, 7, 8),
(34, 2, 7, 9),
(35, 5, 7, 1),
(36, 1, 7, 6),
(37, 1, 7, 7),
(38, 1, 8, 9),
(39, 1, 8, 8),
(40, 1, 8, 7),
(41, 2, 8, 6),
(42, 3, 8, 5),
(43, 1, 8, 4),
(44, 4, 8, 1),
(45, 1, 8, 2),
(46, 16, 8, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nome` varchar(45) DEFAULT NULL,
  `usuario_sobrenome` varchar(45) DEFAULT NULL,
  `usuario_tipo` varchar(1) NOT NULL DEFAULT 'P',
  `faculdade` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `escolaridade` text DEFAULT NULL,
  `profissao` text DEFAULT NULL,
  `data_criacao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nome`, `usuario_sobrenome`, `usuario_tipo`, `faculdade`, `email`, `senha`, `escolaridade`, `profissao`, `data_criacao`) VALUES
(1, 'Laciene', 'Melo', 'A', 'FASI', 'lacienealvesmelo@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'S', 'Desenvolvedora', '2021-10-25 16:33:00'),
(2, 'Fabrício', 'Farias', 'P', 'FASI', 'fabricio@email.com', '25d55ad283aa400af464c76d713c07ad', 'S', 'Professor', '2021-10-25 23:19:41'),
(3, 'Felipe', 'Windsor', 'P', 'FASI', 'felipe@email.com', '25d55ad283aa400af464c76d713c07ad', 'S', 'Tenente da Marinha', '2021-10-26 13:57:41'),
(4, 'Isabel', 'Windsor', 'P', 'FASI', 'isabel@email.com', '25d55ad283aa400af464c76d713c07ad', 'S', 'Engenheira de Computação', '2021-10-27 18:18:56'),
(5, 'Camila', 'Melo', 'P', 'FASI', 'camila@email.com', '25d55ad283aa400af464c76d713c07ad', 'S', 'Engenheira de Computação', '2021-11-01 17:54:46');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_sala`
--

CREATE TABLE `usuario_sala` (
  `usuario_sala_id` int(11) NOT NULL,
  `usuario_sala_status` varchar(1) NOT NULL DEFAULT 'R',
  `data_criacao` datetime NOT NULL DEFAULT current_timestamp(),
  `reserva_inicia` datetime NOT NULL,
  `reserva_fim` datetime NOT NULL,
  `usuario_sala_usuario_id` int(11) NOT NULL,
  `usuario_sala_sala_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario_sala`
--

INSERT INTO `usuario_sala` (`usuario_sala_id`, `usuario_sala_status`, `data_criacao`, `reserva_inicia`, `reserva_fim`, `usuario_sala_usuario_id`, `usuario_sala_sala_id`) VALUES
(1, 'C', '2021-10-25 23:20:34', '2021-10-26 04:19:48', '2021-11-01 19:19:48', 2, 1),
(2, 'R', '2021-11-26 13:58:20', '2021-11-27 18:57:55', '2021-11-02 18:57:55', 2, 2),
(10, 'R', '2021-11-03 03:29:45', '2021-12-12 12:12:00', '2021-12-12 12:12:00', 2, 2),
(11, 'R', '2021-11-03 03:43:12', '2021-11-04 12:12:00', '2021-11-06 12:12:00', 2, 2),
(12, 'R', '2021-11-03 11:52:45', '2021-11-15 08:00:00', '2021-11-16 12:12:00', 1, 1),
(13, 'R', '2021-11-03 15:27:41', '2021-11-17 08:00:00', '2021-11-19 12:00:00', 1, 6),
(14, 'R', '2021-11-03 15:32:24', '2021-11-17 08:00:00', '2021-11-18 12:00:00', 1, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`recurso_id`);

--
-- Índices para tabela `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`sala_id`);

--
-- Índices para tabela `sala_recurso`
--
ALTER TABLE `sala_recurso`
  ADD PRIMARY KEY (`sala_recurso_id`,`sala_recurso_sala_id`,`sala_recurso_recurso_id`),
  ADD KEY `fk_sala_has_recurso_sala1` (`sala_recurso_sala_id`),
  ADD KEY `fk_sala_has_recurso_recurso1` (`sala_recurso_recurso_id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Índices para tabela `usuario_sala`
--
ALTER TABLE `usuario_sala`
  ADD PRIMARY KEY (`usuario_sala_id`,`usuario_sala_usuario_id`,`usuario_sala_sala_id`),
  ADD KEY `fk_usuario_has_sala_usuario1` (`usuario_sala_usuario_id`),
  ADD KEY `fk_usuario_has_sala_sala1` (`usuario_sala_sala_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `recurso`
--
ALTER TABLE `recurso`
  MODIFY `recurso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `sala`
--
ALTER TABLE `sala`
  MODIFY `sala_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `sala_recurso`
--
ALTER TABLE `sala_recurso`
  MODIFY `sala_recurso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuario_sala`
--
ALTER TABLE `usuario_sala`
  MODIFY `usuario_sala_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `sala_recurso`
--
ALTER TABLE `sala_recurso`
  ADD CONSTRAINT `fk_sala_has_recurso_recurso1` FOREIGN KEY (`sala_recurso_recurso_id`) REFERENCES `recurso` (`recurso_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sala_has_recurso_sala1` FOREIGN KEY (`sala_recurso_sala_id`) REFERENCES `sala` (`sala_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario_sala`
--
ALTER TABLE `usuario_sala`
  ADD CONSTRAINT `fk_usuario_has_sala_sala1` FOREIGN KEY (`usuario_sala_sala_id`) REFERENCES `sala` (`sala_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_has_sala_usuario1` FOREIGN KEY (`usuario_sala_usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
