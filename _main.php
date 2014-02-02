<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('area');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/_main.css">
        <title><?php print "$objI->nomeFantasia - Área do $tipo"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
    </head>
   <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <?php
                    $ul = '<ul class="lembretes">';
                    $objAdministrativo = new Administrativo();
                    $obj = $objAdministrativo->consultar($objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf);
                    if ($obj) {
                        $objAdministrativo_Cargo = new Administrativo_Cargo();
                        foreach ($objAdministrativo_Cargo->listarTudoFuncionario($obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf) as $objAC) {
                            $objCargo = new Cargo();
                            $objCargo = $objCargo->consultar($objAC->cargos_codigo->codigo);
                            $objDepartamento = new Departamento();
                            $objDepartamento = $objDepartamento->consultar($objCargo->departamentos_codigo->codigo);
                            $objAgenda = new Agenda();
                            $objAgenda = $objAgenda->consultarDepartamento($objDepartamento->codigo);
                            $objAgendamentoAula = new AgendamentoAula();
                            if ($objAgendamentoAula->qtdRegistrosAgendaHoje($objAgenda->codigo)) {
                                print $ul;
                                $ul = '';
                                foreach ($objAgendamentoAula->listarTudoAgendaHoje($objAgenda->codigo) as $obj) {
                                    $objFuncionario = new Funcionario();
                                    $objFuncionario = $objFuncionario->consultar($obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf);
                                    $professor = '';
                                    if (!$objAdministrativo->consultar($obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf)) {
                                        $professor = 'Prof';
                                        $professor .= ($objFuncionario->consultar($obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf)->sexo == 'F') ? 'ª. ' : '. ';
                                    }
                                    $aula1 = ($obj->aula1) ? ($obj->turno == '1') ? '07h30-08h20 ' : '18h50-19h40 ' : '';
                                    $aula2 = ($obj->aula2) ? ($obj->turno == '1') ? '08h20-09h10 ' : '19h40-20h30 ' : '';
                                    $aula3 = ($obj->aula3) ? ($obj->turno == '1') ? '09h10-10h00 ' : '20h30-21h20 ' : '';
                                    $aula4 = ($obj->aula4) ? ($obj->turno == '1') ? '10h20-11h10 ' : '21h30-22h20 ' : '';
                                    $aula5 = ($obj->aula5) ? ($obj->turno == '1') ? '11h10-12h00 ' : '22h20-23h00 ' : '';
                                    print "
                                        <li class=\"lembrete\">
                                            <a href=\"/$tipoUrl/agendas/a/$objAgenda->codigo/\">
                                                <h1>Agendamento</h1>
                                                <h2>$objAgenda->nome</h2>
                                                <p>$professor$objFuncionario->nomeAbreviado</p>
                                                <p>" . $obj->termo . "º Termo</p>
                                                <p class=\"horario\">$aula1$aula2$aula3$aula4$aula5</p>
                                                <p class=\"comentarios\">Comentários: $obj->comentarios</p>
                                            </a>
                                        </li>
                                    ";

                                }
                            }
                            $objAgendamentoLivre = new AgendamentoLivre();
                            if ($objAgendamentoLivre->qtdRegistrosAgendaHoje($objAgenda->codigo)) {
                                print $ul;
                                $ul = '';
                                foreach ($objAgendamentoLivre->listarTudoAgendaHoje($objAgenda->codigo) as $obj) {
                                    $objFuncionario = new Funcionario();
                                    $objFuncionario = $objFuncionario->consultar($obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf);
                                    print "
                                        <li class=\"lembrete\">
                                            <a href=\"/$tipoUrl/agendas/l/$objAgenda->codigo/\">
                                                <h1>Agendamento</h1>
                                                <h2>$objAgenda->nome</h2>
                                                <p>$objFuncionario->nomeAbreviado</p>
                                                <p class=\"horario\">$obj->horarioInicial - $obj->horarioFinal</p>
                                                <p class=\"comentarios\">Comentários: $obj->comentarios</p>
                                            </a>
                                        </li>
                                    ";

                                }
                            }
                            if ($objFL->checaPermissao('administrar-noticia')) {
                                print $ul;
                                $ul = '';
                                $objNoticia = new Noticia();
                                if ($objNoticia->qtdPendenteRegistros()) {
                                    print "
                                        <li class=\"lembrete\">
                                            <a href=\"/$tipoUrl/noticias/pendentes.html\">
                                                <h1>Notícias Pendentes</h1>
                                                <h2>Existem notícias aguardando liberação.</h2>
                                                <p>Você tem " . $objNoticia->qtdPendenteRegistros() . " notícia(s) aguardando liberação.</p>
                                            </a>
                                        </li>
                                    ";
                                }
                            }
                            if ($objFL->checaPermissao('administrar-destaque')) {
                                print $ul;
                                $ul = '';
                                $objDestaque = new Destaque();
                                if ($objDestaque->qtdPendenteRegistros()) {
                                    print "
                                        <li class=\"lembrete\">
                                            <a href=\"/$tipoUrl/destaques/pendentes.html\">
                                                <h1>Destaques Pendentes</h1>
                                                <h2>Existem destaques aguardando liberação.</h2>
                                                <p>Você tem " . $objDestaque->qtdPendenteRegistros() . " destaque(s) aguardando liberação.</p>
                                            </a>
                                        </li>
                                    ";
                                }
                            }
                        }
                        if (!$ul)
                            print '</ul><div class="clear"></div>';
                    }
                    ?>
                    <h1>Área do <?php print $tipo; ?></h1>
                    <ul id="boxButtons">
                        <?php if ($objFL->checaPermissao('instituicao')) { ?><li><a href="/<?php print $tipoUrl; ?>/instituicao.html">Instituição</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('funcionario')) { ?><li><a href="/<?php print $tipoUrl; ?>/funcionarios/">Funcionários</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('departamento')) { ?><li><a href="/<?php print $tipoUrl; ?>/departamentos/">Departamentos</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('cargo')) { ?><li><a href="/<?php print $tipoUrl; ?>/cargos/">Cargos</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('cargos-funcionario')) { ?><li><a href="/<?php print $tipoUrl; ?>/funcionarios/cargos/">Cargos por Funcionário</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('curso')) { ?><li><a href="/<?php print $tipoUrl; ?>/cursos/">Cursos</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('disciplina')) { ?><li><a href="/<?php print $tipoUrl; ?>/disciplinas/">Disciplinas</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('aluno')) { ?><li><a href="/<?php print $tipoUrl; ?>/alunos/">Alunos</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('album')) { ?><li><a href="/<?php print $tipoUrl; ?>/albuns/">Álbum de Fotos</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('noticia')) { ?><li><a href="/<?php print $tipoUrl; ?>/noticias/">Notícias</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('destaque')) { ?><li><a href="/<?php print $tipoUrl; ?>/destaques/">Destaques</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('mural')) { ?><li><a href="/<?php print $tipoUrl; ?>/mural/">Murais</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('permissao-administrativo')) { ?><li><a href="/<?php print $tipoUrl; ?>/permissoes/administrativo/">Permissões Administrativas</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('permissao-academico')) { ?><li><a href="/<?php print $tipoUrl; ?>/permissoes/academico/cadastro.html">Permissões Academicas</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('agenda')) { ?><li><a href="/<?php print $tipoUrl; ?>/agendas/">Agendas</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('revista')) { ?><li><a href="/<?php print $tipoUrl; ?>/revista/">Revista Alimentus</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('parceiro')) { ?><li><a href="/<?php print $tipoUrl; ?>/parceiros/">Parceiros</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('contrate')) { ?><li><a href="/frame/<?php print base64_encode('http://www.fatecmarilia.edu.br/contrate/admr/admr_login.php'); ?>/">Contrate um Tecnólogo</a></li><?php } ?>
                        <?php if ($objFL->checaPermissao('banco_de_dados')) { ?><li><a href="http://www.fatecmarilia.edu.br:2082/cpsess3892419708/frontend/x3/sql/PhpMyAdmin.html" target="_blank">Banco de dados</a></li><?php } ?>
                    </ul>
                    <?php if ($objFL->checaPermissao('perfil')) { ?>
                    <div class="clear"></div>
                    <h1>Meus Dados</h1>
                    <ul id="boxButtons">
                        <li><a href="/<?php print $tipoUrl; ?>/perfil/cadastro.html">Meus Dados</a></li>
                        <li><a href="/<?php print $tipoUrl; ?>/perfil/senha.html">Alterar Senha</a></li>
                    </ul>
                    <?php } ?>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>