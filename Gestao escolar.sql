CREATE DATABASE IF NOT EXISTS gestao_escolar;

USE gestao_escolar;


DROP TABLE IF EXISTS Notas;
DROP TABLE IF EXISTS Funcionario;
DROP TABLE IF EXISTS Turma_Materia;
DROP TABLE IF EXISTS Materia;
DROP TABLE IF EXISTS Professor;
DROP TABLE IF EXISTS Matricula;
DROP TABLE IF EXISTS aluno;
DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS Turma;


-- TURMA

CREATE TABLE Turma (
    id_turma INT NOT NULL AUTO_INCREMENT,
    nome_turma VARCHAR(50) NOT NULL,
    serie VARCHAR(20) NOT NULL,
    turno VARCHAR(20),
    ano_letivo INT NOT NULL,
    PRIMARY KEY (id_turma)
);

-- ALUNO

CREATE TABLE Aluno (
    id_aluno INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(50),
    data_nascimento DATE,
    cpf VARCHAR(14) NOT NULL,
    tel VARCHAR(20),
    responsavel VARCHAR(100) NOT NULL,
    
    PRIMARY KEY (id_aluno),
    UNIQUE (cpf),
    UNIQUE (email)
    
);


-- PROFESSOR

CREATE TABLE Professor (
    id_professor INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL,
    data_nascimento DATE,
    cpf VARCHAR(14) NOT NULL,
    tel VARCHAR(20),
    salario DECIMAL(10,2),
    
    PRIMARY KEY (id_professor),
    UNIQUE (cpf),
    UNIQUE (email)
);


-- MATÉRIA

CREATE TABLE Materia (
    id_materia INT NOT NULL AUTO_INCREMENT,
    nome_materia VARCHAR(100) NOT NULL,
    carga_horaria INT,
    PRIMARY KEY (id_materia)
);

-- TURMA_MATERIA

CREATE TABLE Turma_Materia (
    id_turma_materia INT NOT NULL AUTO_INCREMENT,
    tm_id_turma INT NOT NULL,
    tm_id_materia INT NOT NULL,
    tm_id_professor INT NOT NULL,
    PRIMARY KEY (id_turma_materia),

    FOREIGN KEY (tm_id_turma) REFERENCES Turma(id_turma),
    FOREIGN KEY (tm_id_materia) REFERENCES Materia(id_materia),
    FOREIGN KEY (tm_id_professor) REFERENCES Professor(id_professor),

    UNIQUE (tm_id_turma, tm_id_materia)
);

-- MATRICULA

CREATE TABLE Matricula (
    id_matricula INT NOT NULL AUTO_INCREMENT,
    id_aluno INT NOT NULL,
    id_turma INT NOT NULL,
    ano_letivo INT NOT NULL,
    data_matricula DATE,
    estado ENUM('Ativa', 'Concluida', 'Cancelada', 'Transferida') NOT NULL,

    PRIMARY KEY (id_matricula),

    FOREIGN KEY (id_aluno)
        REFERENCES Aluno(id_aluno),

    FOREIGN KEY (id_turma)
        REFERENCES Turma(id_turma),
        
    UNIQUE (id_aluno, ano_letivo)
);


-- FUNCIONÁRIO

CREATE TABLE Funcionario (
    id_funcionario INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    cargo VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    telefone VARCHAR(20),
    salario DECIMAL(10,2),
    PRIMARY KEY (id_funcionario),
    UNIQUE (cpf),
    UNIQUE (email)
);


-- NOTAS

CREATE TABLE Notas (
    id_nota INT NOT NULL AUTO_INCREMENT,
    bimestre ENUM ('Primeiro', 'Segundo', 'Terceiro', 'Quarto'),
    nota1 DECIMAL(4,2),
    nota2 DECIMAL(4,2),
    nota3 DECIMAL(4,2),
    media DECIMAL(4,2),
    
    nota_id_aluno INT NOT NULL,
    nota_id_turma_materia INT NOT NULL,
    PRIMARY KEY (id_nota),
    
    UNIQUE (nota_id_aluno, nota_id_turma_materia, bimestre),
    
    FOREIGN KEY (nota_id_aluno) REFERENCES Aluno(id_aluno),
    FOREIGN KEY (nota_id_turma_materia) REFERENCES Turma_Materia(id_turma_materia)
);


-- USUÁRIO

CREATE TABLE Usuario (
    id_usuario INT AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('Administrador', 'Professor', 'Aluno') NOT NULL,

    id_professor INT NULL,
    id_aluno INT NULL,

    PRIMARY KEY (id_usuario),

    UNIQUE (email),

    FOREIGN KEY (id_professor)
        REFERENCES Professor(id_professor),

    FOREIGN KEY (id_aluno)
        REFERENCES Aluno(id_aluno)
);
