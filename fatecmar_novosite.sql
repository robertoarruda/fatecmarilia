-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Servidor: 10.243.4.106
-- Tempo de Geração: 02/09/2013 às 16:40
-- Versão do servidor: 5.0.91-community
-- Versão do PHP: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `fatecmar_novosite`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `academicos`
--

CREATE TABLE IF NOT EXISTS `academicos` (
  `funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `titulacao` char(1) NOT NULL COMMENT 'D: Doutor; M: Mestre; E: Especialista; G: Graduado;',
  `urlLattes` varchar(150) default NULL,
  PRIMARY KEY  (`funcionarios_funcionariosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `academicos`
--

INSERT INTO `academicos` (`funcionarios_funcionariosLogin_cpf`, `titulacao`, `urlLattes`) VALUES
('076.840.998-50', 'D', ''),
('190.978.288-21', '', ''),
('269.246.558-07', '', ''),
('354.064.960-34', 'D', ''),
('358.737.898-35', '', ''),
('364.972.918-06', '', ''),
('809.035.410-68', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `academicos_disciplinas`
--

CREATE TABLE IF NOT EXISTS `academicos_disciplinas` (
  `academicos_funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `disciplinas_codigo` int(11) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY  (`academicos_funcionarios_funcionariosLogin_cpf`,`disciplinas_codigo`),
  KEY `disciplinas_codigo` (`disciplinas_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `academicos_niveisdeacesso`
--

CREATE TABLE IF NOT EXISTS `academicos_niveisdeacesso` (
  `niveisdeacesso_codigo` int(11) NOT NULL,
  `funcionarioLogin_cpf` char(15) NOT NULL,
  PRIMARY KEY  (`niveisdeacesso_codigo`),
  KEY `niveisdeacesso_codigo` (`niveisdeacesso_codigo`),
  KEY `funcionarioLogin_cpf` (`funcionarioLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `academicos_niveisdeacesso`
--

INSERT INTO `academicos_niveisdeacesso` (`niveisdeacesso_codigo`, `funcionarioLogin_cpf`) VALUES
(1, '345.816.068-02'),
(8, '345.816.068-02'),
(9, '345.816.068-02'),
(11, '345.816.068-02'),
(15, '345.816.068-02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrativos`
--

CREATE TABLE IF NOT EXISTS `administrativos` (
  `funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `formacao` text,
  PRIMARY KEY  (`funcionarios_funcionariosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `administrativos`
--

INSERT INTO `administrativos` (`funcionarios_funcionariosLogin_cpf`, `formacao`) VALUES
('051.133.106-11', NULL),
('076.840.998-50', NULL),
('106.597.898-76', NULL),
('228.239.398-81', 'Ciências Sociais'),
('270.559.808-10', NULL),
('276.320.558-51', NULL),
('292.196.998-00', NULL),
('305.586.538-39', NULL),
('337.896.428-60', ''),
('345.816.068-02', 'Graduado em Informática para Gestão de Negócios - Fatec Garça');

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrativos_cargos`
--

CREATE TABLE IF NOT EXISTS `administrativos_cargos` (
  `administrativos_funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `cargos_codigo` int(11) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY  (`administrativos_funcionarios_funcionariosLogin_cpf`,`cargos_codigo`),
  KEY `cargos_codigo` (`cargos_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `administrativos_cargos`
--

INSERT INTO `administrativos_cargos` (`administrativos_funcionarios_funcionariosLogin_cpf`, `cargos_codigo`, `data`) VALUES
('051.133.106-11', 9, '2013-08-12'),
('076.840.998-50', 11, '2013-08-19'),
('106.597.898-76', 4, '2013-08-08'),
('228.239.398-81', 12, '2013-08-28'),
('270.559.808-10', 7, '2013-09-02'),
('276.320.558-51', 8, '2013-08-07'),
('292.196.998-00', 7, '2013-08-05'),
('305.586.538-39', 2, '2013-07-11'),
('337.896.428-60', 6, '2013-07-29'),
('345.816.068-02', 1, '2013-05-09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentosaula`
--

CREATE TABLE IF NOT EXISTS `agendamentosaula` (
  `codigo` int(11) NOT NULL auto_increment,
  `data` date NOT NULL,
  `termo` int(11) NOT NULL,
  `turno` int(11) NOT NULL,
  `aula1` tinyint(1) NOT NULL,
  `aula2` tinyint(1) NOT NULL,
  `aula3` tinyint(1) NOT NULL,
  `aula4` tinyint(1) NOT NULL,
  `aula5` tinyint(1) NOT NULL,
  `comentarios` varchar(200) default NULL,
  `agendas_codigo` int(11) NOT NULL,
  `funcionarios_funcionarioslogin_cpf` char(15) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `agendas_codigo` (`agendas_codigo`),
  KEY `funcionarios_funcionarioslogin_cpf` (`funcionarios_funcionarioslogin_cpf`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Fazendo dump de dados para tabela `agendamentosaula`
--

INSERT INTO `agendamentosaula` (`codigo`, `data`, `termo`, `turno`, `aula1`, `aula2`, `aula3`, `aula4`, `aula5`, `comentarios`, `agendas_codigo`, `funcionarios_funcionarioslogin_cpf`) VALUES
(5, '2013-09-04', 6, 3, 1, 1, 1, 1, 1, '', 2, '354.064.960-34'),
(6, '2013-09-05', 6, 1, 1, 1, 1, 1, 1, '', 2, '354.064.960-34'),
(7, '2013-10-09', 6, 3, 1, 1, 1, 1, 1, '', 2, '354.064.960-34'),
(8, '2013-10-10', 6, 1, 1, 1, 1, 1, 1, '', 2, '354.064.960-34'),
(10, '2013-09-03', 6, 1, 0, 0, 0, 1, 1, '', 1, '076.840.998-50'),
(11, '2013-09-03', 6, 3, 0, 0, 0, 1, 1, '', 1, '076.840.998-50'),
(12, '2013-09-03', 1, 1, 1, 1, 0, 0, 0, '', 1, '076.840.998-50');

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentoslivre`
--

CREATE TABLE IF NOT EXISTS `agendamentoslivre` (
  `codigo` int(11) NOT NULL auto_increment,
  `data` date NOT NULL,
  `horarioInicial` time NOT NULL,
  `horarioFinal` time NOT NULL,
  `comentarios` varchar(200) default NULL,
  `agendas_codigo` int(11) NOT NULL,
  `funcionarios_funcionarioslogin_cpf` char(15) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `agendas_codigo` (`agendas_codigo`),
  KEY `funcionarios_funcionarioslogin_cpf` (`funcionarios_funcionarioslogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendas`
--

CREATE TABLE IF NOT EXISTS `agendas` (
  `codigo` int(11) NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL,
  `tipoDeHorario` char(1) NOT NULL COMMENT 'L: Horário Livre; A: Horário de Aula;',
  `diasDeAntecedencia` int(11) NOT NULL,
  `departamentos_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `departamentos_codigo` (`departamentos_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `agendas`
--

INSERT INTO `agendas` (`codigo`, `nome`, `tipoDeHorario`, `diasDeAntecedencia`, `departamentos_codigo`) VALUES
(1, 'Laboratório de Informática', 'A', 1, 1),
(2, 'TV / DVD', 'A', 1, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE IF NOT EXISTS `alunos` (
  `alunosLogin_cpf` char(15) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `nomeAbreviado` varchar(50) NOT NULL,
  `sexo` char(1) NOT NULL,
  `dataNascimento` date NOT NULL,
  `foto` varchar(60) NOT NULL,
  `estadoCivil` char(1) NOT NULL COMMENT 'S: Solteiro(a); C: Casado(a); D: Divorciado(a); V: Viúvo(a);',
  `endereco` varchar(100) NOT NULL,
  `complemento` varchar(50) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `estado` char(2) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `telefone` varchar(14) NOT NULL,
  `celular` varchar(14) NOT NULL,
  `telefoneRecado` varchar(14) NOT NULL,
  `nomeRecado` varchar(50) NOT NULL,
  PRIMARY KEY  (`alunosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `alunos`
--

INSERT INTO `alunos` (`alunosLogin_cpf`, `nome`, `nomeAbreviado`, `sexo`, `dataNascimento`, `foto`, `estadoCivil`, `endereco`, `complemento`, `bairro`, `cep`, `estado`, `cidade`, `telefone`, `celular`, `telefoneRecado`, `nomeRecado`) VALUES
('345.816.068-02', 'Roberto Alves de Arruda', 'Roberto Alves de Arruda', 'M', '1985-07-10', '', 'S', 'Rua Capitão Alberto Mendes Júnior, 1147', '', 'Jd. Vitória', '17520-110', 'SP', 'Marília', '(14) 3301-2991', '(14) 9712-2525', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunoslogin`
--

CREATE TABLE IF NOT EXISTS `alunoslogin` (
  `cpf` char(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(128) NOT NULL,
  `situacao` char(1) NOT NULL COMMENT 'A: Ativo; D: Desativo;',
  `ultimoAcesso` datetime default NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`cpf`),
  UNIQUE KEY `email` (`email`),
  KEY `instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `alunoslogin`
--

INSERT INTO `alunoslogin` (`cpf`, `email`, `senha`, `situacao`, `ultimoAcesso`, `instituicao_codigo`) VALUES
('345.816.068-02', 'robertoadearruda@gmail.com', 'c2ce9087b1445f38cc53e3c3a23ba38bd8158d793054d9aa4777d4647a5dad1a1aa86b9d5dccd667951044b149142c6cce8ef6ea54f7f901d77ec58bd67f7f9c', 'A', '2013-08-09 20:02:22', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunoslogin_solicitacao`
--

CREATE TABLE IF NOT EXISTS `alunoslogin_solicitacao` (
  `cpf` varchar(15) NOT NULL,
  `ra` varchar(13) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `data` date NOT NULL,
  `codigoDeAtivacao` char(8) NOT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`cpf`),
  KEY `instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos_cursos`
--

CREATE TABLE IF NOT EXISTS `alunos_cursos` (
  `alunos_alunosLogin_cpf` char(15) NOT NULL,
  `cursos_codigo` int(11) NOT NULL,
  `ra` varchar(13) NOT NULL,
  PRIMARY KEY  (`alunos_alunosLogin_cpf`,`cursos_codigo`),
  KEY `cursos_codigo` (`cursos_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargos`
--

CREATE TABLE IF NOT EXISTS `cargos` (
  `codigo` int(11) NOT NULL auto_increment,
  `nome` varchar(80) NOT NULL,
  `departamentos_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `departamentos_codigo` (`departamentos_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Fazendo dump de dados para tabela `cargos`
--

INSERT INTO `cargos` (`codigo`, `nome`, `departamentos_codigo`) VALUES
(1, 'Auxiliar Docente', 1),
(2, 'Analista Técnico Administrativo', 1),
(3, 'Diretor(a)', 2),
(4, 'Diretor(a) Acadêmico', 3),
(5, 'Diretor(a) de Serviços', 4),
(6, 'Bibliotecário(a)', 6),
(7, 'Assistente Administrativo', 3),
(8, 'Técnico Administrativo', 5),
(9, 'Auxiliar Docente', 8),
(10, 'Assistente Técnico Administrativo', 10),
(11, 'Coordenador(a)', 9),
(12, 'Auxiliar Administrativo', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargos_niveisdeacesso`
--

CREATE TABLE IF NOT EXISTS `cargos_niveisdeacesso` (
  `cargos_codigo` int(11) NOT NULL,
  `niveisdeacesso_codigo` int(11) NOT NULL,
  `funcionarioLogin_cpf` char(15) NOT NULL,
  PRIMARY KEY  (`cargos_codigo`,`niveisdeacesso_codigo`),
  KEY `niveisdeacesso_codigo` (`niveisdeacesso_codigo`),
  KEY `funcionarioLogin_cpf` (`funcionarioLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `cargos_niveisdeacesso`
--

INSERT INTO `cargos_niveisdeacesso` (`cargos_codigo`, `niveisdeacesso_codigo`, `funcionarioLogin_cpf`) VALUES
(2, 16, '305.586.538-39'),
(1, 1, '345.816.068-02'),
(1, 2, '345.816.068-02'),
(1, 3, '345.816.068-02'),
(1, 4, '345.816.068-02'),
(1, 5, '345.816.068-02'),
(1, 6, '345.816.068-02'),
(1, 7, '345.816.068-02'),
(1, 8, '345.816.068-02'),
(1, 9, '345.816.068-02'),
(1, 10, '345.816.068-02'),
(1, 11, '345.816.068-02'),
(1, 12, '345.816.068-02'),
(1, 13, '345.816.068-02'),
(1, 14, '345.816.068-02'),
(1, 15, '345.816.068-02'),
(1, 16, '345.816.068-02'),
(1, 17, '345.816.068-02'),
(1, 18, '345.816.068-02'),
(1, 19, '345.816.068-02'),
(1, 20, '345.816.068-02'),
(1, 21, '345.816.068-02'),
(1, 22, '345.816.068-02'),
(2, 1, '345.816.068-02'),
(2, 2, '345.816.068-02'),
(2, 3, '345.816.068-02'),
(2, 4, '345.816.068-02'),
(2, 5, '345.816.068-02'),
(2, 6, '345.816.068-02'),
(2, 7, '345.816.068-02'),
(2, 8, '345.816.068-02'),
(2, 9, '345.816.068-02'),
(2, 10, '345.816.068-02'),
(2, 11, '345.816.068-02'),
(2, 12, '345.816.068-02'),
(2, 13, '345.816.068-02'),
(2, 14, '345.816.068-02'),
(2, 15, '345.816.068-02'),
(2, 17, '345.816.068-02'),
(2, 18, '345.816.068-02'),
(2, 19, '345.816.068-02'),
(2, 20, '345.816.068-02'),
(2, 21, '345.816.068-02'),
(2, 22, '345.816.068-02'),
(3, 1, '345.816.068-02'),
(3, 2, '345.816.068-02'),
(3, 6, '345.816.068-02'),
(3, 8, '345.816.068-02'),
(3, 9, '345.816.068-02'),
(3, 10, '345.816.068-02'),
(3, 11, '345.816.068-02'),
(3, 15, '345.816.068-02'),
(3, 18, '345.816.068-02'),
(4, 1, '345.816.068-02'),
(4, 2, '345.816.068-02'),
(4, 6, '345.816.068-02'),
(4, 7, '345.816.068-02'),
(4, 8, '345.816.068-02'),
(4, 9, '345.816.068-02'),
(4, 10, '345.816.068-02'),
(4, 11, '345.816.068-02'),
(4, 15, '345.816.068-02'),
(4, 19, '345.816.068-02'),
(5, 3, '345.816.068-02'),
(5, 4, '345.816.068-02'),
(5, 5, '345.816.068-02'),
(5, 9, '345.816.068-02'),
(5, 10, '345.816.068-02'),
(5, 11, '345.816.068-02'),
(5, 14, '345.816.068-02'),
(5, 18, '345.816.068-02'),
(6, 1, '345.816.068-02'),
(6, 8, '345.816.068-02'),
(6, 9, '345.816.068-02'),
(6, 11, '345.816.068-02'),
(6, 19, '345.816.068-02'),
(7, 1, '345.816.068-02'),
(7, 2, '345.816.068-02'),
(7, 6, '345.816.068-02'),
(7, 7, '345.816.068-02'),
(7, 8, '345.816.068-02'),
(7, 9, '345.816.068-02'),
(7, 10, '345.816.068-02'),
(7, 11, '345.816.068-02'),
(7, 15, '345.816.068-02'),
(7, 19, '345.816.068-02'),
(8, 1, '345.816.068-02'),
(8, 8, '345.816.068-02'),
(8, 11, '345.816.068-02'),
(8, 15, '345.816.068-02'),
(8, 22, '345.816.068-02'),
(9, 1, '345.816.068-02'),
(9, 8, '345.816.068-02'),
(9, 9, '345.816.068-02'),
(9, 11, '345.816.068-02'),
(9, 15, '345.816.068-02'),
(10, 1, '345.816.068-02'),
(10, 11, '345.816.068-02'),
(10, 16, '345.816.068-02'),
(10, 19, '345.816.068-02'),
(11, 17, '345.816.068-02'),
(12, 1, '345.816.068-02'),
(12, 9, '345.816.068-02'),
(12, 11, '345.816.068-02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

CREATE TABLE IF NOT EXISTS `cursos` (
  `codigo` int(11) NOT NULL auto_increment,
  `tipo` int(11) NOT NULL COMMENT '1: Ensino Presencial; 2: Ensino a Distância',
  `nome` varchar(50) NOT NULL,
  `nomeCompleto` varchar(100) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `perfilProfissiografico` text NOT NULL,
  `estruturaCurricular` text NOT NULL,
  `duracao` varchar(50) NOT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `i_instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `cursos`
--

INSERT INTO `cursos` (`codigo`, `tipo`, `nome`, `nomeCompleto`, `imagem`, `perfilProfissiografico`, `estruturaCurricular`, `duracao`, `instituicao_codigo`) VALUES
(1, 1, 'Alimentos', 'Curso Superior de Graduação em Tecnologia em Alimentos', '1365464916.jpg', 'No ambiente das empresas é fato a ocorrência de profundas alterações em sua forma de atuação, o que ocasiona a exigência de plena harmonia entre inovação tecnológica, estrutura e colaboradores com a própria matriz organizacional. A competitividade de uma empresa resulta da habilidade de seus dirigentes em administrar, de forma integrada, esses parâmetros em direção às crescentes e rigorosas exigências de atualização do mercado.\r\n\r\nA atuação do Tecnólogo pode se estender desde a criação, absorção, domínio, digestão e difusão dos conhecimentos, atingindo pleno atendimento das necessidades estabelecidas pelo mercado. Tal profissional é capaz de oferecer soluções criativas e de participar de equipes habilitadas na concepção e desenvolvimento de soluções.\r\n\r\nO Tecnólogo é o agente capaz de conduzir o processo de inovação, inserindo-o harmonicamente, dentro do contexto mercadológico das organizações. É capaz ainda de colocar as forças da natureza e seus recursos à serviço da sociedade, no atendimento de suas necessidades.\r\n\r\nO Tecnólogo é visto como o profissional que busca sistematicamente ampliar seus conhecimentos, habilidades e aptidões, não só no âmbito tecnológico, mas também no humanístico a fim de aperfeiçoar as comunicações e relações humanas a fim de contribuir para o desenvolvimento e inovação da transformação da matéria prima em produtos ofertados à sociedade.\r\n\r\nO Tecnólogo em Alimentos é o profissional que planeja, executa, coordena, controla e supervisiona processos de produção de alimentos e de bebidas. Participa de pesquisas para melhoria, para adequação e para o desenvolvimento de novos produtos e processos. Planeja, realiza e coordena inspeções sanitárias na indústria de alimentos e em ramos afins. Implanta sistemas de garantia da qualidade de alimentos, atendendo normas e padrões nacionais e as exigências do mercado internacional. Orienta as atividades relacionadas à manutenção de equipamentos empregados nos processos das indústrias de alimentos. Controla a qualidade de serviços de alimentação, objetivando a proteção à saúde dos consumidores. Gerencia serviços de atendimento a consumidores de indústrias de alimentos.', '1º Semestre: Química Geral e Experimental; Metodologia da Pesquisa Científica; Bioquímica dos Alimentos; Limpeza e Sanificação de Superfícies; Estatística; Microbiologia Básica; Físico-Química; Controle de Qualidade de Matérias-Primas Agropecuárias.\r\n\r\n2º Semestre: Análise de Alimentos I; Normas e Padrões de Qualidade dos Alimentos; Bioquímica dos Processos; Microbiologia dos Alimentos; Tecnologia de Frutas e Hortaliças; Tecnologia de Processos I; Tecnologia de Açúcar e Álcool de Cana; Fundamentos de Nutrição e Dietética; Química Analítica.\r\n\r\n3º Semestre: Análise de Alimentos II; Tecnologia de Processos II; Análise Sensorial de Alimentos; Laboratório de Microbiologia de Alimentos I; Controle Analítico de Usinas e Destilarias; Tecnologia de Moagem e Panificação; Tecnologia de Produtos Açucarados.\r\n\r\n4º Semestre: Tecnologia de Leite e Derivados; Refrigeração na Indústria de Alimentos; Serviços de Alimentação; Tecnologia de Óleos, Gorduras e Derivados; Controle Preventivo e Operacional da Qualidade e da Segurança Alimentar – O Sistema APPCC; Tecnologia de Carne e Derivados; Laboratório de Microbiologia de Alimentos II.\r\n\r\n5º Semestre: Tecnologia de Bebidas; Biotecnologia; Embalagens de Alimentos; Tecnologia de Amidos, Toxicologia Alimentar; Efluentes Industriais; Administração Industrial I.\r\n\r\n6º Semestre: Gastronomia; Administração Industrial II; Desenvolvimento de Novos Produtos; Gestão Empresarial; Logística; Trabalho de Conclusão de Curso.', '3 anos', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursospos`
--

CREATE TABLE IF NOT EXISTS `cursospos` (
  `codigo` int(11) NOT NULL auto_increment,
  `tipo` int(11) NOT NULL COMMENT '1: Lato Sensu; 2: Stricto Sensu;',
  `nome` varchar(50) NOT NULL,
  `nomeCompleto` varchar(100) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `objetivo` text NOT NULL,
  `publicoAlvo` text NOT NULL,
  `quadroDeDisciplinas` text NOT NULL,
  `duracao` varchar(50) NOT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `i_instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `cursospos`
--

INSERT INTO `cursospos` (`codigo`, `tipo`, `nome`, `nomeCompleto`, `imagem`, `objetivo`, `publicoAlvo`, `quadroDeDisciplinas`, `duracao`, `instituicao_codigo`) VALUES
(1, 1, 'Gestão em Controle de Qualidade dos Alimentos', 'Curso de Pós-graduação em Gestão em Controle de Qualidade dos Alimentos', '1374159336.jpg', 'O objetivo do curso Gestão em Controle de Qualidade dos Alimentos é fornecer conhecimentos técnicos e científicos e inovações tecnológicas aos graduados em áreas compatíveis com Tecnologia em Alimentos.', 'O perfil esperado do egresso é de gestor com visão estratégica em relação ao controle de qualidade dos alimentos, capacitando-o para tomar decisões para a melhoria da qualidade da empresa.', 'Aprovado pelo Conselho Estadual de Educação - Parecer CD 102/2011, de 29/07/2011.\r\n\r\n1º Módulo - Bioquímica e Análise Química dos Alimentos: Epidemiologia e Saúde Pública; Tópicos Avançados de Microbiologia dos alimentos; Bioquímica dos Alimentos; Análises Químicas dos Alimentos; Higiene e Segurança dos Alimentos.\r\n\r\n2º Módulo - Tecnologia de Processos de Alimentos: Tecnologia Enzimática e Fermentações e Processamentos; Tecnologia de Óleos e Gorduras de Origem Vegetal; Tecnologia e Processamento de Grãos; Produção de Açúcar e Álcool e Processamento Mínimo de Vegetais; Processos de Desidratação Osmótica e Secagem de Frutas por Ar Aquecido; Tecnologia de Carne e Derivados; Gestão da Qualidade na Tecnologia de Leite.\r\n\r\n3º Módulo - Tecnologia e Gestão de Indústrias de Bebidas, Embalagens e de Alimentos Funcionais: Indústria de Bebidas, Gestão e Tecnologia; Gerenciamento e Desenvolvimento de Embalagens; Ciência e tecnologia de Alimentos Funcionais; Análise Sensorial dos Alimentos; Gestão Empresarial.\r\n\r\n4º Módulo - Metodologia de pesquisa: Metodologia Científica; Desenvolvimento da Monografia.', '432 horas (23 meses, com aulas quinzenais)', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `codigo` int(11) NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL,
  `mural` tinyint(1) NOT NULL,
  `oculto` tinyint(1) NOT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `i_instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Fazendo dump de dados para tabela `departamentos`
--

INSERT INTO `departamentos` (`codigo`, `nome`, `mural`, `oculto`, `instituicao_codigo`) VALUES
(1, 'Informática', 1, 0, 1),
(2, 'Diretoria', 0, 0, 1),
(3, 'Secretaria Acadêmica', 1, 0, 1),
(4, 'Diretoria de Serviços', 1, 0, 1),
(5, 'Almoxarifado', 0, 0, 1),
(6, 'Biblioteca', 1, 0, 1),
(7, 'Coordenação', 0, 0, 1),
(8, 'Laboratório Didático', 0, 0, 1),
(9, 'Revista Alimentus', 0, 1, 1),
(10, 'Estágios', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `destaques`
--

CREATE TABLE IF NOT EXISTS `destaques` (
  `codigo` char(13) NOT NULL,
  `data` datetime NOT NULL,
  `prioridade` int(11) NOT NULL,
  `titulo` varchar(70) default NULL,
  `resumo` varchar(160) default NULL,
  `imagem` varchar(100) NOT NULL,
  `posicaoTitulo` char(2) default NULL,
  `linkUrl` varchar(150) default NULL,
  `linkTarget` tinyint(1) default NULL,
  `status` char(1) NOT NULL COMMENT 'A: Ativado; D: Desativado; P: Pendente;',
  `funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `dataAlteracao` datetime default NULL,
  `cpfAlteracao` char(15) default NULL,
  PRIMARY KEY  (`codigo`),
  KEY `titulo` (`titulo`),
  KEY `funcionarios_funcionariosLogin_cpf` (`funcionarios_funcionariosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `destaques`
--

INSERT INTO `destaques` (`codigo`, `data`, `prioridade`, `titulo`, `resumo`, `imagem`, `posicaoTitulo`, `linkUrl`, `linkTarget`, `status`, `funcionarios_funcionariosLogin_cpf`, `dataAlteracao`, `cpfAlteracao`) VALUES
('0162147483647', '2012-08-25 05:38:28', 0, '', '', '1374254769.jpg', '', 'http://www.vestibularfatec.com.br', 1, 'D', '345.816.068-02', '0000-00-00 00:00:00', ''),
('ahi1372377794', '2013-06-27 21:03:14', 2, 'Alunos da Fatec Marília visitam a CristaLins', 'Alunos do 5º Termo de Tecnologia em Alimentos realizaram na manhã de (25/03) uma visita técnica à Cristalins na área industrial, e gerencial da empresa.', '1372377856.jpg', 'LT', 'http://novosite.fatecmarilia.edu.br/noticias/2013/06/27/Alunos-da-Fatec-Marilia-visitam-a-CristaLins.html', NULL, 'A', '345.816.068-02', '0000-00-00 00:00:00', ''),
('cih1373658757', '2013-07-12 16:52:37', 2, 'Rematrícula de Veteranos', 'Confira o calendário e horários para a realizar a matrícula de alunos veteranos.', '1373658690.jpg', 'LT', 'http://novosite.fatecmarilia.edu.br/noticias/2013/07/12/rematricula-de-veteranos.html', NULL, 'D', '345.816.068-02', '0000-00-00 00:00:00', ''),
('doH1373658573', '2013-07-12 16:49:33', 2, 'Matrícula de Alunos Ingressantes', 'Confira o calendário e horários para a realizar a matrícula de alunos ingressantes.', '1373658553.jpg', 'LT', 'http://novosite.fatecmarilia.edu.br/noticias/2013/07/12/matricula-de-alunos-ingressantes.html', NULL, 'D', '345.816.068-02', '0000-00-00 00:00:00', ''),
('eqi1376422824', '2013-08-13 16:40:24', 2, 'Colação de Grau da 10ª Turma de Tecnologia em Alimentos', 'Confira as fotos da colação de grau da 10ª turma do curso de Tecnologia em Alimentos', '1376422709.jpg', 'LB', 'http://novosite.fatecmarilia.edu.br/noticias/2013/08/13/colacao-de-grau-da-10a-turma-de-tecnologia-em-alimentos.html', 0, 'A', '292.196.998-00', '2013-08-13 16:57:42', '345.816.068-02'),
('eQu1376933720', '2013-08-19 14:35:20', 2, 'Deficientes visuais superaram a deficiência e derrubam barreiras', 'Sem medo de ser feliz, deficientes enfrentam suas dificuldades e se tornam tecnólogos em alimentos. Fatec Marília tem participação ativa no processo.', '1376933493.jpg', 'RB', 'http://novosite.fatecmarilia.edu.br/noticias/2013/08/19/deficientes-visuais-superaram-a-deficiencia-e-derrubam-barreiras.html', 0, 'A', '345.816.068-02', '2013-08-19 14:37:00', '345.816.068-02'),
('Guj1372963207', '2013-07-04 15:40:07', 2, 'Festival Gastronômico de Marília', 'O 1º Festival Gastronômico de Marília reunirá 15 restaurantes da cidade lançando novos pratos com o intuito de movimentar o fluxo das casas participantes.', '1375126472.jpg', 'LT', 'http://novosite.fatecmarilia.edu.br/noticias/2013/07/04/festival-gastronomico-de-marilia.html', NULL, 'A', '345.816.068-02', '0000-00-00 00:00:00', ''),
('ibu1376351314', '2013-08-12 20:48:34', 2, 'Alunos do ensino médio e técnico realizam aula de química na Fatec', 'A Fatec Marília recebeu alunos de ensino médio e técnico para que pudessem ter um contato prático com a disciplina de química.', '1376347511.jpg', 'LT', 'http://novosite.fatecmarilia.edu.br/noticias/2013/08/12/alunos-do-ensino-medio-e-tecnico-realizam-aula-de-quimica-na-fatec.html', NULL, 'A', '345.816.068-02', '2013-08-13 16:51:18', '345.816.068-02'),
('juX1372380461', '2013-06-27 21:47:41', 2, 'Especialização em Gestão em Controle de Qualidade dos Alimentos', '', '1372380401.jpg', 'LB', 'http://www.fundacaofat.org.br/cursos/inscricao.asp?cod_curso=27', 1, 'A', '345.816.068-02', '2013-08-13 16:07:30', '345.816.068-02'),
('oMo1377262310', '2013-08-23 09:51:50', 2, 'Você sabe o que é Doença Celíaca?', 'A Doença Celíaca pode ser entendida como a intolerância permanente ao glúten, proteína presente no trigo, aveia, centeio, cevada e malte.', '1377262247.jpg', 'LT', 'http://novosite.fatecmarilia.edu.br/noticias/2013/08/23/voce-sabe-o-que-e-doenca-celiaca.html', 0, 'A', '305.586.538-39', NULL, NULL),
('sof1372374819', '2013-06-27 20:13:39', 2, 'O ensino da disciplina gastronomia na Fatec Marília', 'A disciplina Gastronomia é recente no curso de Tecnologia em Alimentos na Fatec Marília, e foi inserida na grade do curso em fevereiro de 2012.', '1372374522.jpg', 'LT', 'http://novosite.fatecmarilia.edu.br/noticias/2013/06/27/o-ensino-da-disciplina-gastronomia-na-fatec-marilia.html', 0, 'A', '345.816.068-02', '0000-00-00 00:00:00', ''),
('upi1372449208', '2013-06-28 16:53:28', 2, 'Indique um Amigo', 'Eliana Pereira do 2º Termo Diurno foi a grande ganhadora, que indicou o candidato Caio César Abreu Pereira.', '1372448482.jpg', 'RB', 'http://novosite.fatecmarilia.edu.br/noticias/2013/06/28/indique-um-amigo.html', 0, 'A', '345.816.068-02', '2013-08-13 16:08:16', '345.816.068-02'),
('weY1377624857', '2013-08-27 14:34:17', 2, 'Seminário de Monitoramento e Rastreabilidade na Indústria de Alimentos', 'Entre em contato com o 2º Termo para informações. Fone: 99616-0099 ou vamosparaoital@hotmail.com - São 48 VAGAS!', '1377624794.jpg', 'RB', 'http://novosite.fatecmarilia.edu.br/imagens/noticias/1377708995.jpg', 1, 'A', '305.586.538-39', '2013-08-29 07:43:49', '305.586.538-39');

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplinas`
--

CREATE TABLE IF NOT EXISTS `disciplinas` (
  `codigo` int(11) NOT NULL auto_increment,
  `nome` varchar(80) NOT NULL,
  `cargaHoraria` int(11) NOT NULL,
  `cursos_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `i_cursos_codigo` (`cursos_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplinaspos`
--

CREATE TABLE IF NOT EXISTS `disciplinaspos` (
  `codigo` int(11) NOT NULL auto_increment,
  `nome` varchar(80) NOT NULL,
  `cargaHoraria` int(11) NOT NULL,
  `cursospos_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `i_cursos_codigo` (`cursospos_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE IF NOT EXISTS `funcionarios` (
  `funcionariosLogin_cpf` char(15) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `nomeAbreviado` varchar(50) NOT NULL,
  `sexo` char(1) NOT NULL,
  `dataNascimento` date NOT NULL,
  `foto` varchar(60) NOT NULL,
  PRIMARY KEY  (`funcionariosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `funcionarios`
--

INSERT INTO `funcionarios` (`funcionariosLogin_cpf`, `nome`, `nomeAbreviado`, `sexo`, `dataNascimento`, `foto`) VALUES
('076.840.998-50', 'Marie Oshiiwa', 'Marie Oshiiwa', 'F', '0000-00-00', ''),
('228.239.398-81', 'Adler', 'Adler', 'M', '1983-07-10', ''),
('276.320.558-51', 'Cássio Luiz Xavier', 'Cássio Luiz Xavier', 'M', '1980-07-21', ''),
('292.196.998-00', 'Lilian Reis', 'Lilian Reis', 'F', '1980-09-04', ''),
('305.586.538-39', 'Eduardo Jose da Silva', 'Eduardo Jose da Silva', 'M', '1983-09-11', ''),
('337.896.428-60', 'Márcio Barrio Nuevo Navas', 'Márcio Barrio Nuevo Navas', 'M', '1983-12-06', ''),
('345.816.068-02', 'Roberto Alves de Arruda', 'Roberto Alves de Arruda', 'M', '1985-07-10', ''),
('354.064.960-34', 'Luiz Fernando Santos Escouto', 'Luiz Fernando Santos Escouto', 'M', '0000-00-00', ''),
('364.972.918-06', 'Letícia Yuri Nagai', 'Letícia Yuri Nagai', 'F', '1987-01-07', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarioslogin`
--

CREATE TABLE IF NOT EXISTS `funcionarioslogin` (
  `cpf` char(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(128) NOT NULL,
  `situacao` char(1) NOT NULL COMMENT 'A: Ativo; D: Desativo;',
  `ultimoAcesso` datetime default NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`cpf`),
  UNIQUE KEY `email` (`email`),
  KEY `instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `funcionarioslogin`
--

INSERT INTO `funcionarioslogin` (`cpf`, `email`, `senha`, `situacao`, `ultimoAcesso`, `instituicao_codigo`) VALUES
('051.133.106-11', 'hebertyeduardo@gmail.com', '839e4eac168787fd079858226a64d30ce8896609d1aed2a6978eea50da0ad1e1029b7a3ab03d2b00c8dfef7a895ae88fedb2fef5290a6c378d8b2b3044994f58', 'A', NULL, 1),
('076.840.998-50', 'moshiiwa@terra.com.br', '43e26022898537bff63df79a173c4917404f94605c0215c9c118fe2b8c8e1698d9e43a4389d2b4dcb7031e5156c47a336635febe5248386745833515634a646e', 'A', '2013-09-02 14:36:39', 1),
('106.597.898-76', 'fatecmarilia@gmail.com', '5baab849236686ac84a871dbfec0f31db62b485ea21f4d1b064a82037ec47bcb506a89ffe3639f2b3646861a48aa5b070742d367de3ed068d4ecb10f19cac70a', 'A', NULL, 1),
('190.978.288-21', 'adriana.fiorini@ig.com.br', '50e478a0b595c5c0bc9aea7c70d6e399572190414cc5e15d6520295de8aa4fc2ba2effabbeafa96e7fa8cfa5a8eeb1c4771a0b6ce9e1a8aea1cd16c02065f04b', 'A', '2013-09-02 15:48:30', 1),
('228.239.398-81', 'adler.shirakura@yahoo.com.br', 'b7fedf97755a4764bf7c9e1639dcad833613d6329dd81b950c4a201a32d43d521655f54ae5e25567877aa049eef95b4b5c679ca4623b91c4fd597632e4a3c850', 'A', '2013-08-29 16:16:50', 1),
('269.246.558-07', 'farinazzimachado@hotmail.com', 'd36853faa47aa9eb09d8468dd7df9146ec3c40c3e8cded09ca61472e8eede11cd172cd713869d2a0d0b52e5efc61eec14571d69fc6f4062f490c89112eeef5ad', 'A', NULL, 1),
('270.559.808-10', 'fatecmarilia.sueli@gmail.com', 'cf0036c05ebf79bdd602e24f5266e8ba72fcc67b1ee31354f10893aad4625f6a2169f935d3e5e783ba9a2d11e601514819a65296a43d0fd015fda94ea2436955', 'A', NULL, 1),
('276.320.558-51', 'cassio.xavier@fatec.sp.gov.br', 'ebf9784796f8e2c37fc11a66e52f0225e38506445f98beed5f86546953f5785f0f85f9f8a1c56866f8e6f448edcbb6eba4736e20136b87354d7d664193556e58', 'A', '2013-08-07 16:43:11', 1),
('292.196.998-00', 'lilian.reis@gmail.com', '9adce1cbf9dafa262d8f551d3a61aabc34b3fb8014c95893dc1801dd1f97e41dcbd4ca92936966241279f41cb6f2dde593247daf73494c3a134c59e721a1d7b1', 'A', '2013-08-05 15:20:00', 1),
('305.586.538-39', 'eduardo.silva25@fatec.sp.gov.br', 'f2501514c4c2e5a35420d53d8c281dbb27a83a7ba74442ad245a55874fe58312b597a168e9dee9fa08e56e62ad26e1f2fcec380299d75794e6d3a8b3b8ce5027', 'A', '2013-09-02 15:44:08', 1),
('337.896.428-60', 'marcio.navas01@fatec.sp.gov.br', 'e9bbfcf6ad2fedfeed97aa5ec0c3e3df881b7e1b1a840799a72a9706b9e2b0ab957fa84e01a63327d2ecff5b5ada112f242e555ded73889ac6ea168947dd765e', 'A', '2013-08-19 19:39:39', 1),
('345.816.068-02', 'robertoadearruda@gmail.com', 'c2ce9087b1445f38cc53e3c3a23ba38bd8158d793054d9aa4777d4647a5dad1a1aa86b9d5dccd667951044b149142c6cce8ef6ea54f7f901d77ec58bd67f7f9c', 'A', '2013-09-02 21:13:16', 1),
('354.064.960-34', 'educacaoparaosabor@gmail.com', '7bf2809d449735381b1a5205bb13452af56b93871d3bd07db74e298f7e2da93ed68728c256a70132219c4557fb887744aa002386a54151f9f1aa3294081f6d31', 'A', '2013-08-16 09:45:33', 1),
('358.737.898-35', 'dcris_moraes@yahoo.com.br', '383996aea6e1a7a8fb60612ddd2fc23886579bb01243039671dce6d3e6582f174387424a5561ab2c50de21b705a7076cde043becb5328da2990690eb4cfab6bc', 'A', NULL, 1),
('364.972.918-06', 'le.yuri@yahoo.com.br', '6f8bd6b2f0a2344792bcd68395aeba988206f1a19bb7600200781a453d2fac6d152933f7bdd5f2b71c0e915fb6ec2f64bc09903454ce14e9b77e9a0b23ff258b', 'A', '2013-08-26 09:38:12', 1),
('809.035.410-68', 'acsmichel@gmail.com', '09a7273dc217b6e670f5b4629f984e003b9200c83615bda10f914a83f71c96ad884277ac89d65f7cdeda084065af65b7d65f21fd606ecd58e625272e20c4bf86', 'A', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `instituicao`
--

CREATE TABLE IF NOT EXISTS `instituicao` (
  `codigo` int(11) NOT NULL auto_increment,
  `nome` varchar(100) NOT NULL,
  `nomeFantasia` varchar(100) NOT NULL,
  `imagem` varchar(60) NOT NULL,
  `descricao` text NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `complemento` varchar(50) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `estado` char(2) NOT NULL,
  `telefone` varchar(14) NOT NULL,
  `fax` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `emailSuporte` varchar(100) NOT NULL,
  PRIMARY KEY  (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `instituicao`
--

INSERT INTO `instituicao` (`codigo`, `nome`, `nomeFantasia`, `imagem`, `descricao`, `endereco`, `complemento`, `cep`, `cidade`, `estado`, `telefone`, `fax`, `email`, `emailSuporte`) VALUES
(1, 'Faculdade de Tecnologia \\"Estudante Rafael Almeida Camarinha\\"', 'Fatec Marília', '1365464861.jpg', 'Marília é hoje o maior Pólo Industrial de Alimentos do Brasil, sendo uma ótima opção de investimento, que une oportunidades de desenvolvimento econômico a muita qualidade de vida. Através de pesquisa realizada pela FIPE-USP, Marília ficou em 1º lugar em Desenvolvimento do Estado. Foi apontada pela Unicef-ONU como Cidade Amiga da Criança e também reconhecida pelo Instituto Ayrton Senna como cidade Modelo de Educação. É apontada como modelo em estrutura de ensino e como a quarta cidade mais segura do Estado. Tudo isso fez com que Marília se transformasse em pólo regional, com índice positivo na geração de empregos nas indústrias de alimentos e demais segmentos. Por apresentar este perfil de crescimento na área alimentícia, o Centro Paula Souza instalou uma Faculdade de Tecnologia (FATEC) em Marília, visando qualificar os trabalhadores que atuam no mercado de alimentos e abrindo novas oportunidades a todos que buscam ensino público com qualidade. A FATEC \\"Estudante Rafael Almeida Camarinha\\" (FATEC-Marília) foi criada em 02 de Março de 2006, através do Decreto nº 50.575, pelo Governador Geraldo Alckmim e iniciou suas atividades acadêmicas em 22 de março de 2006 com o curso de Tecnologia em Alimentos e possui instalações próprias na Rua Castro Alves, nº 62. Sua missão é \\"Formar profissionais competentes e éticos, capazes de enfrentar desafios na busca do desenvolvimento tecnológico, social e econômico\\".\r\n\r\nO Centro Paula Souza é uma autarquia do Governo do Estado de São Paulo, responsável pela educação profissional pública nos níveis técnico, tecnológico e pós-graduação. Vinculado à Secretaria de Desenvolvimento, oferece cursos Superiores de Tecnologia ministrados nas 56 FATECs, localizadas nos municípios de Americana, Botucatu, Carapicuíba, Cruzeiro, Garça, Guaratinguetá, Indaiatuba, Itapetininga, Jaú, Jundiaí, Marília, Mauá, Mococa, Ourinhos, Pindamonhangaba, Praia Grande, Santos, São José dos Campos, São José do Rio Preto, São Paulo (3), Sorocaba, São Bernardo do Campo, Taquaritinga e Tatuí.\r\n\r\nFundada em 1929, a cidade de Marília tem uma área total de 1.194 km² e aproximadamente 200 mil habitantes. A 443 quilômetros de São Paulo, Marília destaca-se no segmento industrial com a produção de alimentos e também com indústrias dos mais variados ramos: metalúrgica; gráfica; plásticos; construção civil, entre outras,; totalizando 1.095 indústrias. Essas empresas exportam para a América do Sul, Europa e resto do mundo.\r\n\r\nA cidade conta com estabelecimentos comerciais, sendo considerada neste segmento, um centro polarizador, pois apresenta grande variedade e quantidade de produtos; além de representar uma grande expressão econômica para a cidade.', 'Av. Castro Alves, 62', '2º Andar', '17506-000', 'Marília', 'SP', '(14) 3454-7540', '', 'fatecmarilia@gmail.com', 'f.racamarinha.ti@centropaulasouza.sp.gov.br');

-- --------------------------------------------------------

--
-- Estrutura para tabela `murais`
--

CREATE TABLE IF NOT EXISTS `murais` (
  `codigo` int(11) NOT NULL auto_increment,
  `titulo` varchar(70) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `arquivo` varchar(100) NOT NULL,
  `linkUrl` varchar(150) NOT NULL,
  `departamento_codigo` int(11) NOT NULL,
  PRIMARY KEY  (`codigo`),
  KEY `departamento_codigo` (`departamento_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Fazendo dump de dados para tabela `murais`
--

INSERT INTO `murais` (`codigo`, `titulo`, `imagem`, `descricao`, `arquivo`, `linkUrl`, `departamento_codigo`) VALUES
(1, 'Horário das Aulas', '1373480969.jpg', 'Veja o horário das aulas.', 'horario-das-aulas.pdf', '', 3),
(2, 'Calendário Acadêmico', '1373480903.jpg', 'Veja o calendário acadêmico completo.', 'calendario-academico.pdf', '', 3),
(3, 'Manual do Aluno', '1373481524.jpg', 'Veja o manual do aluno.', 'manual-do-aluno.pdf', '', 3),
(4, 'Horário de atendimento', '1375200161.jpg', 'De segunda a sexta, das 07h às 21h50min.', '', '', 6),
(5, 'Regulamento', '1375201341.jpg', 'Veja o regulamento.', 'regulamento.pdf', '', 6),
(6, 'Guia de normalização de referências', '1375202293.jpg', 'Veja o guia de normalização de referências.', 'guia-de-normalizacao-de-referencias.pdf', '', 6),
(7, 'Catálogo de livros', '1375231607.jpg', 'Veja o catálogo de livros.', 'catalogo-de-livros.pdf', '', 6),
(8, 'Links úteis', '1375285744.jpg', 'Veja a lista de links úteis.', 'links-uteis.pdf', '', 6),
(9, 'Infraestrutura e equipe', '1375292178.jpg', 'Veja a infraestrutura e equipe.', 'infraestrutura-e-equipe.pdf', '', 6),
(10, 'Contato', '1375292392.jpg', 'Veja os contatos.', 'contato.pdf', '', 6),
(11, 'SIGA', '1375479829.jpg', 'Link para acesso ao Sistema Integrado de Gestão Acadêmica.', '', 'http://projetocps.pro.br/aluno', 3),
(12, 'IntraGov Connection', '1375480395.jpg', 'IntraGov Connection aplica automaticamente as configurações exigidas para navegação na rede.', 'intragov-connection.zip', '', 1),
(13, 'Live@edu', '1375490605.jpg', 'Parceria entre CPS e Microsoft disponibiliza emails institucionais aos professores e alunos.', '', 'http://novosite.fatecmarilia.edu.br/noticias/2011/02/04/liveedu.html', 1),
(14, 'Horário de Funcionamento', '1373480969.jpg', 'De segunda a sexta, das 08h às 12h e das 14h às 18h.', '', '', 4),
(15, 'Contato', '1376077187.jpg', 'Telefone: (14) 3454-7541', '', '', 4),
(16, 'Horário de Funcionamento', '1373480969.jpg', 'De segunda a sexta, das 07h30 às 12h, das 13h às 17h e das 18h às 21h.', '', '', 3),
(17, 'Contato', '1376077187.jpg', 'Telefone: (14) 3454-7540', '', '', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `niveisdeacesso`
--

CREATE TABLE IF NOT EXISTS `niveisdeacesso` (
  `codigo` int(11) NOT NULL auto_increment,
  `tipo` varchar(100) NOT NULL,
  PRIMARY KEY  (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Fazendo dump de dados para tabela `niveisdeacesso`
--

INSERT INTO `niveisdeacesso` (`codigo`, `tipo`) VALUES
(1, 'AREA'),
(2, 'INSTITUICAO'),
(3, 'FUNCIONARIO'),
(4, 'DEPARTAMENTO'),
(5, 'CARGO'),
(6, 'CURSO'),
(7, 'DISCIPLINA'),
(8, 'ALBUM'),
(9, 'NOTICIA'),
(10, 'DESTAQUE'),
(11, 'PERFIL'),
(12, 'PERMISSAO-ADMINISTRATIVO'),
(13, 'PERMISSAO-ACADEMICO'),
(14, 'CARGOS-FUNCIONARIO'),
(15, 'AGENDA'),
(16, 'CONTRATE'),
(17, 'REVISTA'),
(18, 'PARCEIRO'),
(19, 'MURAL'),
(20, 'ADMINISTRAR-DESTAQUE'),
(21, 'ADMINISTRAR-NOTICIA'),
(22, 'ADMINISTRAR-AGENDA');

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
  `codigo` char(13) NOT NULL,
  `data` datetime NOT NULL,
  `prioridade` int(11) NOT NULL,
  `titulo` varchar(70) NOT NULL,
  `urlTitulo` varchar(70) NOT NULL,
  `resumo` varchar(160) NOT NULL,
  `conteudo` text NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `linkTitulo` varchar(100) default NULL,
  `linkUrl` varchar(150) default NULL,
  `linkTarget` tinyint(1) default NULL,
  `status` char(1) NOT NULL COMMENT 'A: Ativado; D: Desativado; P: Pendente;',
  `funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `dataAlteracao` datetime default NULL,
  `cpfAlteracao` char(15) default NULL,
  PRIMARY KEY  (`codigo`),
  KEY `titulo` (`titulo`,`urlTitulo`,`funcionarios_funcionariosLogin_cpf`),
  KEY `funcionarios_funcionariosLogin_cpf` (`funcionarios_funcionariosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `noticias`
--

INSERT INTO `noticias` (`codigo`, `data`, `prioridade`, `titulo`, `urlTitulo`, `resumo`, `conteudo`, `imagem`, `linkTitulo`, `linkUrl`, `linkTarget`, `status`, `funcionarios_funcionariosLogin_cpf`, `dataAlteracao`, `cpfAlteracao`) VALUES
('ahi1372377794', '2013-06-27 21:03:14', 2, 'Alunos da Fatec Marília visitam a CristaLins', 'alunos-da-fatec-marilia-visitam-a-cristalins', 'Alunos do 5º Termo de Tecnologia em Alimentos realizaram na manhã de (25/03) uma visita técnica à Cristalins na área industrial, e gerencial da empresa.', 'Os alunos do 5º Termo do Curso superior de Tecnologia em Alimentos da Fatec Marília realizaram na manhã desta segunda-feira (25/03) uma visita técnica à Cristalins na área industrial, e gerencial da empresa.\r\n\r\nDurante a visita, os alunos foram acompanhados pelo diretor da empresa, Fabio Trevisi, que apresentou todo o processo de produção da água mineral, desde a fonte de exploração até a embalagem.\r\n\r\nDe acordo com o professor da Fatec que acompanhou a visita Gustavo Lana Soares (Engenheiro de Alimentos), “para os alunos foi uma experiência muito importante, por que puderam ver na pratica o que eles conheciam pela teoria e puderam acompanhar como a Cristalins segue todas as normas sanitárias vigentes para envase de água mineral”, ele ainda concluiu que esse tipo de visita vem somar ao currículo dos alunos devido ao conhecimento adquirido.\r\n\r\nAo final da visita a Cristalins ofereceu um café da manhã aos alunos que interagiram e questionaram o diretor da Cristalins Fabio Trevisi sobre vários procedimentos e rotinas no processo de produção.\r\n\r\nEste anos em especial tem sido bastante movimentado para a Água Mineral Cristalins, com lançamento de novos produtos, certificação de qualidade internacional, contratação da Musa do Linense como “garota propaganda” da marca e parceria com o Linense no Paulistão 2013.', '1372377856.jpg', 'Fonte: CristaLins', 'http://177.52.160.43/~cristali/evento.php?i=7', 1, 'A', '345.816.068-02', '0000-00-00 00:00:00', ''),
('cih1373658757', '2013-07-12 16:52:37', 2, 'Rematrícula de Veteranos', 'rematricula-de-veteranos', 'Confira o calendário e horários para a realizar a matrícula de alunos veteranos.', 'A rematrícula ON LINE de veteranos será entre os dias:\r\n\r\n07/07 à 26/07/2013.\r\n\r\nJá a rematrícula PRESENCIAL de veteranos (caso não consiga ou tenha problema na hora de fazer a rematrícula on-line) deverá ser feita aqui na FATEC pelo próprio aluno nos dias:\r\n\r\n24/07 e 25/07/2013.\r\n\r\nDas 08h30 às 11h30; das 14h às 16h30 e das 18h às 21h.', '1373658690.jpg', 'Acesse www.projetocps.pro.br/aluno', 'http://www.projetocps.pro.br/aluno', 1, 'D', '345.816.068-02', '0000-00-00 00:00:00', ''),
('doH1373658573', '2013-07-12 16:49:33', 2, 'Matrícula de Alunos Ingressantes', 'matricula-de-alunos-ingressantes', 'Confira o calendário e horários para a realizar a matrícula de alunos ingressantes.', '19/07/2013 - Divulgação da 1ª lista de convocação e da lista de classificação geral\r\n22 e 23/07/2013- Matrícula da 1ª lista de convocação na Fatec\r\n24/07/2013 - Divulgação da 2ª lista de convocação\r\n25/07/2013 - Matrícula da 2ª lista de convocação na Fatec\r\nHorários\r\n\r\nManhã: 08h30 às 11h30\r\nTarde: 14h00 às 16h30\r\nNoite: 18h00 às 21h00', '1373658553.jpg', '', '', 0, 'D', '345.816.068-02', '0000-00-00 00:00:00', ''),
('eqi1376422824', '2013-08-13 16:40:24', 2, 'Colação de Grau da 10ª Turma de Tecnologia em Alimentos', 'colacao-de-grau-da-10a-turma-de-tecnologia-em-alimentos', 'Confira as fotos da colação de grau da 10ª turma do curso de Tecnologia em Alimentos', 'Realizada no dia 26/07/2013 a 10ª Turma do Curso de Tecnologia de Alimentos da Faculdade de Tecnologia “Estudante Rafael Almeida Camarinha” teve como patrono o prefeito Vinícius Camarinha, o professor Gustavo Lana Soares como paraninfo, a turma levou o nome da professora Sandra  Maria Barbalho e a professora Juliana Audi Giannoni como patronesse.', '1376422709.jpg', '', '', 0, 'A', '292.196.998-00', NULL, NULL),
('eQu1376933720', '2013-08-19 14:35:20', 2, 'Deficientes visuais superaram a deficiência e derrubam barreiras', 'deficientes-visuais-superaram-a-deficiencia-e-derrubam-barreiras', 'Sem medo de ser feliz, deficientes enfrentam suas dificuldades e se tornam tecnólogos em alimentos. Fatec Marília tem participação ativa no processo.', 'A deficiência visual é definida clinicamente como a perda ou redução da capacidade visual em ambos os olhos, com caráter definitivo, não tendo possibilidade de ser melhorada ou corrigida com o uso de lentes ou tratamento clínico ou cirúrgico. Mas na prática, essa dificuldade pode ser definida como: “Ou você aceita e supera, ou passará sua vida lamentando e reclamando”.\r\n\r\nPalavras do tecnólogo em alimentos, recém formado e empregado, Deivisson Lima de Araújo, 24, que perdeu a visão aos 11 anos e quando se deparou com a deficiência total de um de seus sentidos pensou que teria dois caminhos. Ou ele lutava contra as dificuldades ou viveria na dependência de seus pais.\r\n\r\n“Eu sabia que seria difícil, mas era o mais inteligente a fazer naquele momento. Por isso, depois de ter passado a fase de depressão, resolvi voltar a estudar na escola pública. Ganhei uma bolsa de estudos em um colégio particular de Marília e como sempre gostei de química me indicaram a Fatec, onde eu poderia me formar e ter uma profissão”, contou.\r\n\r\nDeivisson nasceu com a visão perfeita, mas por conta de uma reação alérgica a um medicamento ele desenvolveu uma síndrome chamada de Stevens-Johnson, que muitas vezes é fatal e ataca principalmente boca, olhos, uretra, vagina e ânus, com lesões avermelhadas. Com o agravamento da síndrome, o tecnólogo teve lesões muito graves nos olhos e no rosto e por conta disso perdeu a visão.\r\n\r\nAs lesões tem o formato de bolhas ou vesículas e se manifestam de forma tão agressiva que levam a alterações no sistema nervoso central, sistema gastrointestinal, rins e coração. Geralmente a síndrome de Stevens-Johnson é uma reação alérgica a medicamentos como a Penicilina e antibióticos que contêm sulfa. Ela surge de forma repentina entre uma e três semanas após o indivíduo usar ao medicamento. Sua incidência é de um caso em cada um milhão de pessoas.\r\n\r\nEle foi o primeiro aluno com deficiência visual atendido pela Fatec “Estudante Rafael Almeida Camarinha” e apesar de ser novidade, a instituição já estava preparada com estrutura que possibilitou a ele se locomover pelos corredores e principalmente deu a ele todo respaldo psicopedagógico para o acompanhamento das atividades.\r\n\r\n“O que me deu forças quando entrei na Fatec, foi que as pessoas não me tratavam como um ninguém ou como um bebê recém-nascido. Elas me tratavam como alguém normal e capaz de estudar e render na faculdade”.\r\n\r\nDeivisson colou grau como tecnólogo em alimentos na noite de 26 de julho, em cerimônia realizada pela Fatec, na presença dos colegas de faculdade e ao lado de sua esposa. Atualmente, ele trabalha dando treinamento e auxílio em laboratório de análise de amostras em uma das grandes empresas de alimentos de Marília.\r\n\r\n“Eu já havia conhecido outros casos de superação e como tive apoio da escola de reabilitação e de tantas outras pessoas como minha família, resolvi seguir em frente e vencer”, disse Deivisson.\r\n\r\nDébora seguiu os conselhos da filha e voltou a estudar\r\n\r\nA depressão foi deixada para trás depois que Débora Calixto Bonfim, 35, resolveu se mexer para se adaptar à vida que seria sua condição permanente. Com a única filha criada e uma vida inteira pela frente, limitada por uma miopia severa, agravada por um processo de degeneração macular, que a deixou com 3% da visão apenas, ela voltou a estudar e guiada pelos conselhos da filha Priscila, 18, ingressou no curso de tecnologia em alimentos da Fatec de Marília.\r\n\r\n“Eu incentivei porque vi a tristeza profunda que ela estava e como não queria ver minha mãe se sentindo assim busquei informações para que ela pudesse começar a fazer o curso. Eu sabia que já tinha um rapaz com o mesmo problema e foi o que me deu mais energia para incentivá-la”, conta Priscila que também é aluna do curso da Fatec.\r\n\r\nComo teve que parar de estudar quando a miopia se agravou, Débora não teve dúvidas em terminar o ensino médio sabendo da oportunidade que teria de estudar mais. Com o certificado do segundo grau em mãos, o próximo passo foi fazer a inscrição para o vestibular, que já tinha a opção da prova com fonte ampliada.\r\n\r\n“Ela passou muito bem no vestibular e pra mim foi um exemplo de vida e de superação que se confirma todos os dias dentro da faculdade e no laboratório de pesquisa onde estagiamos juntas”, disse Priscila.\r\n\r\nApesar de estar afastada há três anos do mercado de trabalho e estar deprimida, o acolhimento dos professores e dos alunos deram novo fôlego para Débora que se animou e hoje é um das melhores alunas da turma. “No começo eu tinha medo de não conseguir acompanhar os alunos, de atrapalhar a turma, mas tive todo o respaldo da faculdade com uma estrutura adaptada para o deficiente visual. Tive medo até de ver minha classificação no vestibular que por sinal foi muito boa”, lembra a estudante.\r\n\r\nDébora agora cursa o segundo ano do curso que tem duração de três anos e faz estágio no laboratório de pesquisa e desenvolvimento de fisicoquímica da Fatec. “Estou buscando mais segurança no que faço para o próximo ano buscar uma vaga de estágio em alguma empresa. Sei que sou capaz e que dará tudo certo”.\r\n\r\nPassar o dia inteiro dentro da faculdade é um verdadeiro prazer para Débora, que vai de manhã para a aula e à tarde para o estágio onde fica até à noite. “A faculdade mudou minha vida e por isso me dedico 100% não só em dar o melhor nos estudos, mas também às amizades que fiz aqui e o ambiente saudável onde convivo todos os dias”, completa.\r\n\r\nFaculdade disponibiliza estrutura e acolhimento\r\n\r\nCom a chegada de Deivisson à Fatec “Estudante Rafael Almeida Camarinha” a coordenação e todos os professores tiveram que se adaptar às necessidades dele. Para isso foi contratada uma professora especial e todos os materiais de estudo e as aulas eram gravadas para que ele pudesse estudar sem nenhum prejuízo em relação aos outros alunos.\r\n\r\nSegundo o coordenador do curso de tecnologia em alimentos, Leandro Repeti, a preocupação principal foi acolher Deivisson com uma estrutura adequada e que ele pudesse desenvolver todas as suas habilidades. Por isso, desde o vestibular, que foi feito de maneira especial para que ele pudesse ser avaliado, todos os detalhes foram pensados para que ele pudesse se sentir bem e acolhido na Fatec.\r\n\r\nA equipe de 25 docentes, das 44 disciplinas do curso também foi treinada e uma professora com conhecimentos técnicos na área de alimentação e especializada em educação especial foi contratada para acompanhar o novo aluno nas atividades.\r\n\r\n“Ele foi nosso primeiro aluno com deficiência visual e foi um desafio muito grande, mesmo porque os professores teriam que entender o problema e obrigatoriamente agir de maneira diferenciada com ele em relação à formulação das avaliações semestrais e procurar tirar dúvidas quando surgissem”.\r\n\r\nHoje, além de Deivisson que acaba de se formar e da Débora que está no segundo ano, existem outros dois deficientes na faculdade, estes com dificuldades físicas, um do primeiro ano e outro do segundo. “Agora já estamos acostumados à nova realidade e ao dia a dia de cada um e estamos buscando melhorar a cada dia para facilitar a vida deles aqui dentro”, disse Repeti.\r\n\r\nAlém da estrutura acadêmica e do acolhimento, a Fatec também possui todo o prédio adaptado à lei de acessibilidade, o que facilita os alunos com deficiência a se locomoverem pelas instalações sem grandes dificuldades.\r\n\r\nPrecisa-se de educadores especiais com paciência e amor\r\n\r\nFormada em tecnologia de alimentos em 2009 e especializada em gestão do controle de qualidade e educação especial, a ex-aluna da Fatec de Marília, Amabriane Oliveira, 26, se interessou pela vaga que a faculdade divulgou há cerca de três anos. Era a chance dela colocar em prática os conhecimentos que adquiriu em anos de estudos e ainda ajudar quem tem vontade de progredir. Ela trabalhava em uma indústria de alimentos na época, mas resolveu buscar a vaga como professora.\r\n\r\n“Foi uma seleção breve e eles precisavam de alguém com formação muito específica como a minha. O candidato precisava ter uma boa base teórica na área de alimentos e ter formação em educação especial”.\r\n\r\nPara trabalhar com os alunos, Amabriane lançou mão de todo seu amor pela profissão e de muita paciência adquirida na especialização em educação para entender e buscar caminhos para o desenvolvimento de cada um deles. “A deficiência é um fato na vida deles, por isso o jeito era encontrar maneiras para driblar o fato e procurar desenvolver todas as habilidades que o curso requer”.\r\n\r\nNo caso de Deivisson, a professora confessa que foi um pouco mais fácil, já que ele estudou em boas escolas. “Ele chegou com uma base muito boa e como sempre foi muito autônomo teve uma evolução rápida e de qualidade. Por isso conseguiu se encaixar na empresa onde trabalha agora”, lembra Amabriane.\r\n\r\nCom a Débora o desenvolvimento foi mais detalhado. “Tivemos que trabalhar inclusive a parte de relacionamentos, flexibilidade e assim, adquirindo confiança ela conseguiu atingir um desenvolvimento muito bom”.\r\n\r\nAmabriane conta que o essencial é resgatar a autoestima e levar os alunos a confiarem em si mesmos, o que ajuda também a criar uma maneira nova de ver a vida e de se relacionar com as pessoas, já que um profissional apenas técnico não é completo.\r\n\r\nPara sua vida inteira, a professora conta que deve levar o exemplo de cada um. “Não por eles serem deficientes e terem alcançado um certo grau de conhecimento. Mas sim pela determinação e comprometimento que cada um deles tem pelo que está fazendo, independente das adversidades. Quando os conheci me tornei uma pessoa muito mais grata e comprometida com minha própria vida”.', '1376933493.jpg', 'Fotos e reportagem: Jornal Diário de Marília', 'http://www.diariodemarilia.com.br/Noticias/124740/Derrubar-barreiras-a-especialidade-daqueles-que-superaram-a-deficincia-visual', 1, 'A', '345.816.068-02', NULL, NULL),
('Guj1372963207', '2013-07-04 15:40:07', 2, 'Festival Gastronômico de Marília', 'festival-gastronomico-de-marilia', 'O 1º Festival Gastronômico de Marília reunirá 15 restaurantes da cidade lançando novos pratos com o intuito de movimentar o fluxo das casas participantes.', 'O 1º Festival Gastronômico de Marília reunirá 15 restaurantes da cidade lançando novos pratos com o intuito de movimentar o fluxo das casas participantes. Serão os melhores restaurantes, excelentes chefs e novos talentos, a preços acessíveis. Nosso objetivo é mostrar que a boa gastronomia pode ser apreciada por todos e que é possível fazê-la a preços populares. Os pratos serão individuais e terão o mesmo preço. Parte desse valor deverá ser repassado a duas entidades beneficentes. Outra característica importante é que os pratos terão o seu nome ligado à cidade de Marília, a algum fato histórico, local ou pessoa que mereça destaque em nossa história.\r\n\r\nO Festival terá duração 45 dias - de 01 julho a 16 de agosto de 2013 e somente participarão casas associadas no MRC&VB.', '1375126472.jpg', 'Visite o site do festival', 'http://www.visitemarilia.com.br/eventos.php?secao=Calendario_de_eventos&evento=87', 1, 'A', '345.816.068-02', '0000-00-00 00:00:00', ''),
('ibu1376351314', '2013-08-12 20:48:34', 2, 'Alunos do ensino médio e técnico realizam aula de química na Fatec', 'alunos-do-ensino-medio-e-tecnico-realizam-aula-de-quimica-na-fatec', 'A Fatec Marília recebeu alunos de ensino médio e técnico para que pudessem ter um contato prático com a disciplina de química.', 'A Fatec Marília, no mês de junho de 2013, recebeu em seu laboratório de química geral alunos de ensino médio e técnico, para que pudessem ter um contato prático com a disciplina.  Por intermédio do auxiliar docente Heberty Eduardo De Marco e supervisão do Professor Ms. Paulo Sérgio Marinelli  estes alunos puderam ter suas aulas teóricas vivenciadas na prática.\r\n\r\nEsta integração entre o Ensino Superior e o Ensino Médio e Técnico visa mostrar a comunidade local que no nosso Município temos uma faculdade muito bem equipada e que oferece gratuitamente , ensino superior de qualidade. \r\n\r\nEm breve estarão abertas as inscrições para o vestibular de verão da nossa faculdade de Tecnologia em alimentos .', '1376347511.jpg', '', '', 0, 'A', '345.816.068-02', '2013-08-13 16:51:18', '345.816.068-02'),
('ide1372959642', '2011-02-04 14:40:42', 3, 'Live@edu', 'liveedu', 'O CPS e a Microsoft firmaram uma parceria que permitirá aos professores e alunos terem acesso a um e-mail institucional e aos Softwares da Microsoft.', 'O Centro Paula Souza e a Microsoft firmaram uma parceria que permitirá aos professores e alunos terem acesso a um e-mail institucional no padrão \\"«nome».«sobrenome»@fatec.sp.gov.br\\"; exemplo: joao.silva@fatec.sp.gov.br; e também terem acesso a todos os Softwares da Microsoft (exceto o pacote OFFICE).\r\nO Live@edu é mais do que apenas contas de e-mail gratuitas. Com uma solução hospedada da Microsoft, você obtém uma solução confiável e fácil de usar para sua escola.\r\n\r\nDeixe-nos ajudar a aumentar a capacidade de comunicação e colaboração da escola com um conjunto de ferramentas online, incluindo calendários, documentos e espaços de trabalho compartilhados.\r\n\r\nMantenha alunos, professores e ex-alunos conectados em qualquer lugar com acesso online em praticamente qualquer dispositivo habilitado para Web e prepare seus alunos para o mundo real.\r\n\r\nVeja o vídeo institucional do projeto com a Profª Laura Laganá - Diretora Superintendente do Centro Paula Souza.\r\nhttp://www.visionline.com.br/grafica/InstPaulaSouza_video_logo.zip\r\nSaiba como Aumentar a Produtividade com Windows Live@edu\r\n\r\nO que é Skydrive? Para que serve?\r\nhttp://rogerioamancio.wordpress.com/2010/11/25/armazenando-e-compartilhando-arquivos-com-skydrive/ \r\nUtilizando o Calendário do Live@edu Outlook Live \r\nhttp://rogerioamancio.wordpress.com/2010/11/25/utilizando-o-calendrio-do-liveedu-outlook-live/ \r\nCriando e Gerenciando Grupos Com Live@edu\r\nhttp://rogerioamancio.wordpress.com/2010/11/25/criando-e-gerenciando-grupos-com-liveedu/\r\n\r\nLink Office Web Apps - crie e edite documentos do Word, Excel, PowerPoint e OneNote de qualquer computador conectado à internet\r\nhttp://rogerioamancio.wordpress.com/2010/11/25/liveedu-office-web-apps/\r\n\r\n\r\nMaiores informações sobre o projeto acessem http://www.centropaulasouza.sp.gov.br/projetos/msdnaa/\r\nACESSE AGORA MESMO A ÁREA DO ALUNO E CONFIRA OS DADOS PARA ATIVAR A SUA CONTA!\r\n\r\nO e-mail pode ser ativado em: http://outlook.com ou na página do Hotmail.', '1372959622.jpg', '', '', 0, 'A', '345.816.068-02', '0000-00-00 00:00:00', ''),
('oMo1377262310', '2013-08-23 09:51:50', 2, 'Você sabe o que é Doença Celíaca?', 'voce-sabe-o-que-e-doenca-celiaca', 'A Doença Celíaca pode ser entendida como a intolerância permanente ao glúten, proteína presente no trigo, aveia, centeio, cevada e malte.', 'A Doença Celíaca pode ser entendida como a intolerância permanente ao glúten, proteína presente no trigo, aveia, centeio, cevada e malte. A doença ocorre em pacientes com tendência genética a aparece geralmente na infância, mas pode acometer pessoas de qualquer idade, inclusive adultos.\r\nOs sintomas mais comuns apresentados pelas pessoas portadoras da doença são: diarréia crônica (mais de 30 dias), prisão de ventre, anemia, falta de apetite, emagrecimento, distensão abdominal, dor abdominal, pêrda de peso e alteração no humor.\r\nO único tratamento para a doença é uma alimentação sem glúten por toda a vida. Desta forma, quem tem a Doença Celíaca nunca poderá consumir alimentos com trigo, aveia, centeio, cevada ou malte, além dos seus derivados, como farinha de trigo, pão, farinha de rosca, macarrão, bolachas e biscoitos, dentre outros.\r\nPor outro lado, vários outros alimentos são permitidos para quem tem a doença: arroz, milho, farinha de mandioca, fubá, féculas, óleos, margarina, todas as frutas, leite, manteiga, queijos e derivados, hortaliças e leguminosas, carnes e ovos. Os pacientes portadores da doença devem prestar atenção aos rótulos dos produtos industrializados, pois estes precisam obrigatoriamente informar em seus rótulos se o produto “CONTÉM GLÚTEN” ou “NÃO CONTÉM GLÚTEN” (Lei Federal no 10.674, de 2003).\r\n \r\nFonte: Hospital das Clínicas – Faculdade de Medicina de Botucatu', '1377262247.jpg', '', '', 0, 'A', '305.586.538-39', NULL, NULL),
('sof1372374819', '2013-06-27 20:13:39', 2, 'O ensino da disciplina gastronomia na Fatec Marília', 'o-ensino-da-disciplina-gastronomia-na-fatec-marilia', 'A disciplina Gastronomia é recente no curso de Tecnologia em Alimentos na Fatec Marília, e foi inserida na grade do curso em fevereiro de 2012.', 'A disciplina GASTRONOMIA é recente no curso de Tecnologia em Alimentos na Fatec Marília e data de fevereiro de 2012.\r\n\r\nO curso visa preparar os acadêmicos para perceberem a GASTRONOMIA como área interdisciplinar e de interface com a ciência, a tecnologia e a arte, e por conseguinte, como marco referencial na geração de conhecimentos e saberes correlacionados a cultura alimentar e a educação do gosto.\r\n\r\nOportunizar ao tecnólogo em alimentos a possibilidade de construir uma visão gastronômica amparada nas expressões mais significativas da cultura contemporânea a saber: as ciências humanas, as técnicas culinárias e a arte cinematográfica é seu objetivo.\r\n\r\nAssim os conteúdos são trabalhados e agrupados colecionando encontros que tratam de leituras da GASTRONOMIA através dos aspectos histórico-antropossociológicos e filosóficos, as leituras a partir da elaboração de biografias alimentares, as leituras que tem por base a linguagem do cinema, de filmes com foco gastronômico e as leituras que subsidiam o desenvolvimento e acompanhamento das práticas gastronômicas.\r\n\r\nResponsável\r\nProf. Dr. Luiz Fernando Santos Escouto\r\n\r\nAs imagens aqui apresentadas são resultado do trabalho \\"Ensaio Fotográfico com TCCs\\" e Ensaio Fotográfico com Práticas Gastronômicas” que lança DVD a partir deste semestre.', '1372374522.jpg', '', '', 0, 'A', '345.816.068-02', '0000-00-00 00:00:00', ''),
('uju1373891056', '2013-07-15 09:33:43', 2, 'Novo site da Fatec Marília', 'novo-site-da-fatec-marilia', 'A Fatec Maríllia tem prazer de apresentar seu novo site, com design mais limpo e moderno e interação com as redes sociais.', 'A Fatec Marília se orgulha em apresentar seu novo site. Com um visual mais limpo e moderno, e com interação com as redes sociais, o novo site da faculdade busca acelerar e facilitar a comunicação e divulgação de notícias e informações da unidade.\r\n\r\nO novo site também conta com um sistema CMS (Sistema de Gerenciamento de Conteúdo), que permite a inserção de conteúdo de forma simples e dinâmica, fazendo com que os usuários cadastrados possam gerenciar as informações contidas no site. Este sistema faz com que as novidades, notícias, fotos e várias outras informações, sejam divulgadas de maneira mais rápida e precisa.\r\n\r\nO Departamento de Informática da faculdade está aberto para sugestões, dúvidas e críticas. Mande um e-mail para f.racamarinha.ti@centropaulasouza.sp.gov.br.\r\n', '1373891346.jpg', '', '', 0, 'A', '345.816.068-02', '2013-08-06 22:04:04', '345.816.068-02'),
('upi1372449208', '2013-06-28 16:53:28', 2, 'Indique um Amigo', 'indique-um-amigo', 'Eliana Pereira do 2º Termo Diurno foi a grande ganhadora, que indicou o candidato Caio César Abreu Pereira.', 'A promoção \\"Indique um Amigo e Concorra a um Tablet!!!\\" da Fatec Marília foi um sucesso, e na noite de 18/6 foi realizado o sorteio para definir o ganhador do premio.\r\n\r\nA aluna Eliana Pereira do 2º Termo Diurno foi a grande ganhadora da promoção. Ela indicou o candidato Caio César Abreu Pereira.\r\n\r\nA promoção era válida somente para alunos da Fatec Marília, que a cada indicação com inscrição confirmada do Vestibular Fatec, ganhava um cupom para concorrer ao tablet.\r\n\r\nParabéns a ganhadora, aos organizadores e obrigado a todos que participaram!', '1372448482.jpg', '', '', 0, 'A', '345.816.068-02', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `revista`
--

CREATE TABLE IF NOT EXISTS `revista` (
  `codigo` int(11) NOT NULL auto_increment,
  `descricao` text NOT NULL,
  `equipeeditorial` text NOT NULL,
  `comitecientifico` text NOT NULL,
  `equipediagramacaowebdesigner` text NOT NULL,
  PRIMARY KEY  (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `revista`
--

INSERT INTO `revista` (`codigo`, `descricao`, `equipeeditorial`, `comitecientifico`, `equipediagramacaowebdesigner`) VALUES
(1, 'A Revista Alimentus - Ciências e Tecnologias é um veículo de divulgação científica eletrônica da Faculdade de Tecnologia “Estudante Rafael Almeida Camarinha” (Fatec Marília) que tem por objetivo publicar estudos da comunidade, nacional e internacional, de professores, pesquisadores, estudantes de graduação e pós-graduação e profissionais da área de alimentos dos setores público e privado.\r\nA primeira edição apresenta trabalhos de conclusão de curso desenvolvidos na Fatec Marília com docentes e discentes do curso de Tecnologia em Alimentos.', 'Dra. Cláudia C. Teixeira Nicolau\r\nMsc. Flávia M. V. Farinazzi Machado\r\nDr. Luiz Fernando Santos Escouto\r\nDra. Marie Oshiiwa\r\nDr. Paulo Sérgio Jorge\r\nDra. Renata Bonini Pardo\r\nDra. Susi Meire Maximimo Leite\r\nMsc. Vania Regina Alves de Souza', 'Msc. Anna Cláudia Sahade Brunatti (Fatec Marília/SP)\r\nDra. Cássia F. D. Bassan (UNIMAR/SP)\r\nDra. Cláudia Dorta (Fatec Marília/SP)\r\nDra. Cláudia R. P. Detregiachi (UNESP – Botucatu/SP)\r\nProfa. Christina Castilho de Quental (UEM – Maringá/PR)\r\nDr. Edson Watanabe (EMBRAPA)\r\nMsc. Débora Cristina Moraes (Fatec Marília/SP)\r\nDra. Juliana Audi Giannoni (Fatec Marília/SP)\r\nMsc. Juliana Cristina Bassan (UNESP – Araraquara/SP)\r\nDr. Julio de Mello Neto (UEL – Londrina/PR)\r\nDra. Karla Silva Ferreira (Universidade Estadual do Norte Fluminense/RJ)\r\nDra. Kátia Cristina Portero McLellan (UNESP – Botucatu/SP)\r\nMsc. Leandro Repetti (Fatec Marília/SP)\r\nDra. Lilian Viana Teixeira (UFMG – Belo Horizonte/MG)\r\nDr. Luciano Menezes Ferreira (UNIFEB - Barretos/SP)\r\nDra. Margarida Masami Yamaguchi (UTFPR - Londrina/PR)\r\nDra. Marta Helena Fillet Spoto (ESALQ/USP – Piracicaba/SP)\r\nDra. Marisa Silveira Almeida Renaud Faulin (Fatec Pompéia/SP)\r\nDra. Miriam Coelho de Souza (UNIMEP – Piracicaba/SP)\r\nDra. Patricia Miranda Brusantin (UNIMAR - Marília/SP)\r\nDr. Rodolfo Cláudio Spers (UNIMAR - Marília/SP)\r\nMsc. Rosana Toledo (Universidade Cruzeiro do Sul – SP)\r\nDra. Sandra Maria Barbalho (Fatec Marília/SP)\r\nDra. Silvana Pedroso de Góes Favoni (Fatec Marília/SP)\r\nDra. Solange Guidolin Canniatti Brazaca (ESALQ/USP – Piracicaba/SP)\r\nMsc. Tamie Aguilera Watanabe (Universidade Cruzeiro do Sul – SP)\r\nMsc. Teresa Cristina Castilho Gorayeb (Fatec - Rio Preto/SP)\r\nDra. Viviane de Souza (EMBRAPA)', 'Lilian Amaral dos Reis\r\nLuciana Akemi Oshiiwa\r\nRoberto Alves de Arruda');

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `academicos`
--
ALTER TABLE `academicos`
  ADD CONSTRAINT `academicos_ibfk_1` FOREIGN KEY (`funcionarios_funcionariosLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `academicos_disciplinas`
--
ALTER TABLE `academicos_disciplinas`
  ADD CONSTRAINT `academicos_disciplinas_ibfk_1` FOREIGN KEY (`academicos_funcionarios_funcionariosLogin_cpf`) REFERENCES `academicos` (`funcionarios_funcionariosLogin_cpf`) ON UPDATE CASCADE,
  ADD CONSTRAINT `academicos_disciplinas_ibfk_2` FOREIGN KEY (`disciplinas_codigo`) REFERENCES `disciplinas` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `academicos_niveisdeacesso`
--
ALTER TABLE `academicos_niveisdeacesso`
  ADD CONSTRAINT `academicos_niveisdeacesso_ibfk_1` FOREIGN KEY (`funcionarioLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE,
  ADD CONSTRAINT `academicos_niveisdeacesso_ibfk_3` FOREIGN KEY (`niveisdeacesso_codigo`) REFERENCES `niveisdeacesso` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `administrativos`
--
ALTER TABLE `administrativos`
  ADD CONSTRAINT `administrativos_ibfk_1` FOREIGN KEY (`funcionarios_funcionariosLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `administrativos_cargos`
--
ALTER TABLE `administrativos_cargos`
  ADD CONSTRAINT `administrativos_cargos_ibfk_1` FOREIGN KEY (`administrativos_funcionarios_funcionariosLogin_cpf`) REFERENCES `administrativos` (`funcionarios_funcionariosLogin_cpf`) ON UPDATE CASCADE,
  ADD CONSTRAINT `administrativos_cargos_ibfk_2` FOREIGN KEY (`cargos_codigo`) REFERENCES `cargos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `agendamentosaula`
--
ALTER TABLE `agendamentosaula`
  ADD CONSTRAINT `agendamentosaula_ibfk_2` FOREIGN KEY (`agendas_codigo`) REFERENCES `agendas` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `agendamentosaula_ibfk_3` FOREIGN KEY (`funcionarios_funcionarioslogin_cpf`) REFERENCES `funcionarios` (`funcionariosLogin_cpf`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `agendamentoslivre`
--
ALTER TABLE `agendamentoslivre`
  ADD CONSTRAINT `agendamentoslivre_ibfk_1` FOREIGN KEY (`agendas_codigo`) REFERENCES `agendas` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `agendamentoslivre_ibfk_2` FOREIGN KEY (`funcionarios_funcionarioslogin_cpf`) REFERENCES `funcionarios` (`funcionariosLogin_cpf`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `agendas_ibfk_1` FOREIGN KEY (`departamentos_codigo`) REFERENCES `departamentos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `alunos_ibfk_2` FOREIGN KEY (`alunosLogin_cpf`) REFERENCES `alunoslogin` (`cpf`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `alunoslogin`
--
ALTER TABLE `alunoslogin`
  ADD CONSTRAINT `alunoslogin_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `alunoslogin_solicitacao`
--
ALTER TABLE `alunoslogin_solicitacao`
  ADD CONSTRAINT `alunoslogin_solicitacao_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `alunos_cursos`
--
ALTER TABLE `alunos_cursos`
  ADD CONSTRAINT `alunos_cursos_ibfk_1` FOREIGN KEY (`cursos_codigo`) REFERENCES `cursos` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `alunos_cursos_ibfk_2` FOREIGN KEY (`alunos_alunosLogin_cpf`) REFERENCES `alunos` (`alunosLogin_cpf`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `cargos`
--
ALTER TABLE `cargos`
  ADD CONSTRAINT `cargos_ibfk_1` FOREIGN KEY (`departamentos_codigo`) REFERENCES `departamentos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `cargos_niveisdeacesso`
--
ALTER TABLE `cargos_niveisdeacesso`
  ADD CONSTRAINT `cargos_niveisdeacesso_ibfk_2` FOREIGN KEY (`niveisdeacesso_codigo`) REFERENCES `niveisdeacesso` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cargos_niveisdeacesso_ibfk_3` FOREIGN KEY (`funcionarioLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cargos_niveisdeacesso_ibfk_4` FOREIGN KEY (`cargos_codigo`) REFERENCES `cargos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `cursospos`
--
ALTER TABLE `cursospos`
  ADD CONSTRAINT `cursospos_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `destaques`
--
ALTER TABLE `destaques`
  ADD CONSTRAINT `destaques_ibfk_1` FOREIGN KEY (`funcionarios_funcionariosLogin_cpf`) REFERENCES `funcionarios` (`funcionariosLogin_cpf`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `disciplinas`
--
ALTER TABLE `disciplinas`
  ADD CONSTRAINT `disciplinas_ibfk_1` FOREIGN KEY (`cursos_codigo`) REFERENCES `cursos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `disciplinaspos`
--
ALTER TABLE `disciplinaspos`
  ADD CONSTRAINT `disciplinaspos_ibfk_1` FOREIGN KEY (`cursospos_codigo`) REFERENCES `cursospos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`funcionariosLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `funcionarioslogin`
--
ALTER TABLE `funcionarioslogin`
  ADD CONSTRAINT `funcionarioslogin_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `murais`
--
ALTER TABLE `murais`
  ADD CONSTRAINT `murais_ibfk_1` FOREIGN KEY (`departamento_codigo`) REFERENCES `departamentos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`funcionarios_funcionariosLogin_cpf`) REFERENCES `funcionarios` (`funcionariosLogin_cpf`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
