
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `materia` (
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `nome_materia` varchar(100) NOT NULL,
  `carga_horaria` int DEFAULT NULL,
  PRIMARY KEY (`id_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `turma` (
  `id_turma` int NOT NULL AUTO_INCREMENT,
  `nome_turma` varchar(50) NOT NULL,
  `serie` varchar(20) NOT NULL,
  `turno` varchar(20) DEFAULT NULL,
  `ano_letivo` int NOT NULL,
  PRIMARY KEY (`id_turma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `turma_materia` (
  `id_turma_materia` int NOT NULL AUTO_INCREMENT,
  `tm_id_turma` int NOT NULL,
  `tm_id_materia` int NOT NULL,
  `tm_id_professor` int NOT NULL,
  PRIMARY KEY (`id_turma_materia`),
  UNIQUE KEY `tm_id_turma` (`tm_id_turma`,`tm_id_materia`),
  KEY `tm_id_materia` (`tm_id_materia`),
  KEY `tm_id_professor` (`tm_id_professor`),
  CONSTRAINT `turma_materia_ibfk_1`
    FOREIGN KEY (`tm_id_turma`) REFERENCES `turma` (`id_turma`),
  CONSTRAINT `turma_materia_ibfk_2`
    FOREIGN KEY (`tm_id_materia`) REFERENCES `materia` (`id_materia`),
  CONSTRAINT `turma_materia_ibfk_3`
    FOREIGN KEY (`tm_id_professor`) REFERENCES `professor` (`id_professor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  CONSTRAINT `matricula_ibfk_1`
    FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`),
  CONSTRAINT `matricula_ibfk_2`
    FOREIGN KEY (`id_turma`) REFERENCES `turma` (`id_turma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  CONSTRAINT `notas_ibfk_1`
    FOREIGN KEY (`nota_id_aluno`) REFERENCES `aluno` (`id_aluno`),
  CONSTRAINT `notas_ibfk_2`
    FOREIGN KEY (`nota_id_turma_materia`) REFERENCES `turma_materia` (`id_turma_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  CONSTRAINT `usuario_ibfk_1`
    FOREIGN KEY (`id_professor`) REFERENCES `professor` (`id_professor`),
  CONSTRAINT `usuario_ibfk_2`
    FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuario (email, senha_hash, tipo_usuario, id_professor, id_aluno)
VALUES (
  'admin@escola.com',
  '$2y$10$JAcpooErUpxO/RoHRU8PN.mJywRG5Ma8VAbWf4N0UJVx88L6yWeXy',
  'Administrador',
  NULL,
  NULL
);
