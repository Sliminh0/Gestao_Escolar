-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.4.3 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para gestao_escolar
CREATE DATABASE IF NOT EXISTS `gestao_escolar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gestao_escolar`;

-- Copiando estrutura para tabela gestao_escolar.aluno
CREATE TABLE IF NOT EXISTS `aluno` (
  `id_aluno` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `responsavel` varchar(100) NOT NULL,
  PRIMARY KEY (`id_aluno`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela gestao_escolar.aluno: ~1 rows (aproximadamente)
INSERT INTO `aluno` (`id_aluno`, `nome`, `email`, `data_nascimento`, `cpf`, `tel`, `responsavel`) VALUES
	(1, 'Adriel De Souza Rodrigues', 'Adriel@gmail.com', '2009-04-07', '543.756.123-43', '(11) 96567-0675', 'Adrian De Souza Rodrigues');

-- Copiando estrutura para tabela gestao_escolar.funcionario
CREATE TABLE IF NOT EXISTS `funcionario` (
  `id_funcionario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_funcionario`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela gestao_escolar.funcionario: ~1 rows (aproximadamente)
INSERT INTO `funcionario` (`id_funcionario`, `nome`, `cpf`, `cargo`, `email`, `telefone`, `salario`) VALUES
	(1, 'Julia Medeiros Costa', '123.765.342-47', 'Secretária', 'julia@gmail.com', '(11) 92117-3212', 1743.32);

-- Copiando estrutura para tabela gestao_escolar.materia
CREATE TABLE IF NOT EXISTS `materia` (
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `nome_materia` varchar(100) NOT NULL,
  `carga_horaria` int DEFAULT NULL,
  PRIMARY KEY (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela gestao_escolar.materia: ~2 rows (aproximadamente)
INSERT INTO `materia` (`id_materia`, `nome_materia`, `carga_horaria`) VALUES
	(1, 'Matemática', 80),
	(2, 'Música', 20);

-- Copiando estrutura para tabela gestao_escolar.matricula
CREATE TABLE IF NOT EXISTS `matricula` (
  `id_matricula` int NOT NULL AUTO_INCREMENT,
  `id_aluno` int NOT NULL,
  `id_turma` int NOT NULL,
  `ano_letivo` int NOT NULL,
  `data_matricula` date DEFAULT NULL,
  `estado` enum('Ativa','Concluida','Cancelada','Transferida') NOT NULL,
  PRIMARY KEY (`id_matricula`),
  UNIQUE KEY `id_aluno` (`id_aluno`,`ano_letivo`),
  KEY `id_turma` (`id_turma`),
  CONSTRAINT `matricula_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`),
  CONSTRAINT `matricula_ibfk_2` FOREIGN KEY (`id_turma`) REFERENCES `turma` (`id_turma`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela gestao_escolar.matricula: ~1 rows (aproximadamente)
INSERT INTO `matricula` (`id_matricula`, `id_aluno`, `id_turma`, `ano_letivo`, `data_matricula`, `estado`) VALUES
	(1, 1, 1, 2026, '2026-11-24', 'Ativa');

-- Copiando estrutura para tabela gestao_escolar.notas
CREATE TABLE IF NOT EXISTS `notas` (
  `id_nota` int NOT NULL AUTO_INCREMENT,
  `bimestre` enum('Primeiro','Segundo','Terceiro','Quarto') DEFAULT NULL,
  `nota1` decimal(4,2) DEFAULT NULL,
  `nota2` decimal(4,2) DEFAULT NULL,
  `nota3` decimal(4,2) DEFAULT NULL,
  `media` decimal(4,2) DEFAULT NULL,
  `nota_id_aluno` int NOT NULL,
  `nota_id_turma_materia` int NOT NULL,
  PRIMARY KEY (`id_nota`),
  UNIQUE KEY `nota_id_aluno` (`nota_id_aluno`,`nota_id_turma_materia`,`bimestre`),
  KEY `nota_id_turma_materia` (`nota_id_turma_materia`),
  CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`nota_id_aluno`) REFERENCES `aluno` (`id_aluno`),
  CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`nota_id_turma_materia`) REFERENCES `turma_materia` (`id_turma_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela gestao_escolar.notas: ~2 rows (aproximadamente)
INSERT INTO `notas` (`id_nota`, `bimestre`, `nota1`, `nota2`, `nota3`, `media`, `nota_id_aluno`, `nota_id_turma_materia`) VALUES
	(1, 'Primeiro', 4.00, 3.00, 7.00, 4.67, 1, 1),
	(2, 'Primeiro', 10.00, 9.00, 8.00, 9.00, 1, 2);

-- Copiando estrutura para tabela gestao_escolar.professor
CREATE TABLE IF NOT EXISTS `professor` (
  `id_professor` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_professor`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela gestao_escolar.professor: ~2 rows (aproximadamente)
INSERT INTO `professor` (`id_professor`, `nome`, `email`, `data_nascimento`, `cpf`, `tel`, `salario`) VALUES
	(1, 'Marcelo Ramalho', 'ramalhofisica@gmail.com', '1978-10-10', '431.867.234-05', NULL, 1542.43),
	(2, 'Daniel Alves', 'dan666@gmail.com', '1999-06-02', '321.867.322-67', '(11) 96377-0281', 5452.32);

-- Copiando estrutura para tabela gestao_escolar.turma
CREATE TABLE IF NOT EXISTS `turma` (
  `id_turma` int NOT NULL AUTO_INCREMENT,
  `nome_turma` varchar(50) NOT NULL,
  `serie` varchar(20) NOT NULL,
  `turno` varchar(20) DEFAULT NULL,
  `ano_letivo` int NOT NULL,
  PRIMARY KEY (`id_turma`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela gestao_escolar.turma: ~1 rows (aproximadamente)
INSERT INTO `turma` (`id_turma`, `nome_turma`, `serie`, `turno`, `ano_letivo`) VALUES
	(1, '1DSA', '1 ano', 'Manhã', 2026);

-- Copiando estrutura para tabela gestao_escolar.turma_materia
CREATE TABLE IF NOT EXISTS `turma_materia` (
  `id_turma_materia` int NOT NULL AUTO_INCREMENT,
  `tm_id_turma` int NOT NULL,
  `tm_id_materia` int NOT NULL,
  `tm_id_professor` int NOT NULL,
  PRIMARY KEY (`id_turma_materia`),
  UNIQUE KEY `tm_id_turma` (`tm_id_turma`,`tm_id_materia`),
  KEY `tm_id_materia` (`tm_id_materia`),
  KEY `tm_id_professor` (`tm_id_professor`),
  CONSTRAINT `turma_materia_ibfk_1` FOREIGN KEY (`tm_id_turma`) REFERENCES `turma` (`id_turma`),
  CONSTRAINT `turma_materia_ibfk_2` FOREIGN KEY (`tm_id_materia`) REFERENCES `materia` (`id_materia`),
  CONSTRAINT `turma_materia_ibfk_3` FOREIGN KEY (`tm_id_professor`) REFERENCES `professor` (`id_professor`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela gestao_escolar.turma_materia: ~2 rows (aproximadamente)
INSERT INTO `turma_materia` (`id_turma_materia`, `tm_id_turma`, `tm_id_materia`, `tm_id_professor`) VALUES
	(1, 1, 1, 1),
	(2, 1, 2, 2);

-- Copiando estrutura para tabela gestao_escolar.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `tipo_usuario` enum('Administrador','Professor','Aluno') NOT NULL,
  `id_professor` int DEFAULT NULL,
  `id_aluno` int DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`),
  KEY `id_professor` (`id_professor`),
  KEY `id_aluno` (`id_aluno`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_professor`) REFERENCES `professor` (`id_professor`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela gestao_escolar.usuario: ~4 rows (aproximadamente)
INSERT INTO `usuario` (`id_usuario`, `email`, `senha_hash`, `tipo_usuario`, `id_professor`, `id_aluno`) VALUES
	(1, 'admin@gmail.com', '$2y$10$AzeJ.ytiy5l617ciekHW.OcL0M5TNOigYf0xsXwrBWzou4gxjvSya', 'Administrador', NULL, NULL),
	(2, 'Adriel@gmail.com', '$2y$10$IdcIJZOiRHwCJGrUbWOnHezmn7E7ZZF6z947tCPSo1MJQ4le3oy7.', 'Aluno', NULL, 1),
	(3, 'ramalhofisica@gmail.com', '$2y$10$p0L1D5yFVJOR2JpmbrRYNe0Wf2nP.sjltdVRm8ECtK1TfSaQqnwSi', 'Professor', 1, NULL),
	(4, 'dan666@gmail.com', '$2y$10$v9S7DKANnRulsgQgBzQUKe7VV9.PG02oA.hEdw3Ankejdm17TwxHy', 'Professor', 2, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
