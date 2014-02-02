<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('agenda');

$cpf = $objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;
$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objAgenda = new Agenda();
$objAgenda = $objAgenda->consultar(returnGet('c'));
if ((!$objAgenda) || ($objAgenda->tipoDeHorario <> 'A')) {
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
    _funcoes::error404($url);
}

$funcionarioIsDpto = false;
$objAdministrativo = new Administrativo();
$obj = $objAdministrativo->consultar($cpf);
if ($obj) {
    $objAdministrativo_Cargo = new Administrativo_Cargo();
    foreach ($objAdministrativo_Cargo->listarTudoFuncionario($obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf) as $objAC) {
        $objCargo = new Cargo();
        $objCargo = $objCargo->consultar($objAC->cargos_codigo->codigo);
        $objDepartamento = new Departamento();
        $objDepartamento = $objDepartamento->consultar($objCargo->departamentos_codigo->codigo);
        if ($objAgenda->departamentos_codigo->codigo == $objDepartamento->codigo)
            $funcionarioIsDpto = true;
    }
}
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
        <link rel="stylesheet" type="text/css" href="/css/_forms.css">
        <title><?php print "$objI->nomeFantasia - Agendamento"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/scripts/_agendamentosAula.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Agendamento - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1><?php print $objAgenda->nome; ?> - Agenda</h1>
                        <a href="/<?php print "$tipoUrl/agendas/a/$objAgenda->codigo"; ?>/agendamento.html">Cadastrar Novo Agendamento</a>
                        <?php
                        $objAgendamentos = new AgendamentoAula();
                        $objAgendamentos->excluirAntigos();
                        $tempRes = ($funcionarioIsDpto) ? $objAgendamentos->qtdRegistrosAgenda($objAgenda->codigo) : $objAgendamentos->qtdRegistrosFuncionarioAgenda($cpf, $objAgenda->codigo);
                        if ($tempRes <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                        <table>
                            <thead>
                                <tr>
                                    <th class="alCenter">Data</th>
                                    <th class="codigo">Termo</th>
                                    <th class="alCenter">Turno</th>
                                    <th class="alCenter">1ª Aula</th>
                                    <th class="alCenter">2ª Aula</th>
                                    <th class="alCenter">3ª Aula</th>
                                    <th class="alCenter">4ª Aula</th>
                                    <th class="alCenter">5ª Aula</th>
                                    <th class="opcoes1">Opções</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td class="alCenter">Data</td>
                                    <td class="codigo">Termo</td>
                                    <td class="alCenter">Turno</td>
                                    <td class="alCenter">1ª Aula</td>
                                    <td class="alCenter">2ª Aula</td>
                                    <td class="alCenter">3ª Aula</td>
                                    <td class="alCenter">4ª Aula</td>
                                    <td class="alCenter">5ª Aula</td>
                                    <td class="opcoes1">Opções</td>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $count = 1;
                                $tempRes = ($funcionarioIsDpto) ? $objAgendamentos->listarTudoAgenda($objAgenda->codigo) : $objAgendamentos->listarTudoFuncionarioAgenda($cpf, $objAgenda->codigo);
                                foreach ($tempRes as $obj) {
                                    $count++;
                                    $classPar = (($count % 2) == 0)?' class="par"': '';
                                    
                                    $cpf_ = $obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf;                                    
                                    $objFuncionario = $obj->funcionarios_funcionariosLogin_cpf->consultar($cpf_);
                                    
                                    $turno = ($obj->turno == 1) ? 'Manhã' : 'Noite';
                                    $aula1 = ($obj->aula1) ? 'checked' : 'unchecked';
                                    $aula2 = ($obj->aula2) ? 'checked' : 'unchecked';
                                    $aula3 = ($obj->aula3) ? 'checked' : 'unchecked';
                                    $aula4 = ($obj->aula4) ? 'checked' : 'unchecked';
                                    $aula5 = ($obj->aula5) ? 'checked' : 'unchecked';
                                    
                                    $nome = '';
                                    if (!$objAdministrativo->consultar($cpf_)) {
                                        $nome = 'Prof';
                                        $nome .= ($objFuncionario->consultar($cpf_)->sexo == 'F') ? 'ª. ' : '. ';
                                    }
                                    $objFuncionario = new Funcionario();
                                    $nome .= $objFuncionario->consultar($cpf_)->nomeAbreviado;
                                    $btnExcluir = ($cpf == $cpf_) ? "<a title=\"Excluir\" data-codigo=\"$obj->codigo\">Excluir</a>" : $nome;
                                    
                                    print "
                                    <tr$classPar>
                                        <td class=\"alCenter\">" . date('d/m', strtotime($obj->data)) . "</td>
                                        <td class=\"alCenter\">" . $obj->termo . "°</td>
                                        <td class=\"alCenter\">$turno</td>
                                        <td class=\"alCenter\"><span class=\"$aula1\"></span></td>
                                        <td class=\"alCenter\"><span class=\"$aula2\"></span></td>
                                        <td class=\"alCenter\"><span class=\"$aula3\"></span></td>
                                        <td class=\"alCenter\"><span class=\"$aula4\"></span></td>
                                        <td class=\"alCenter\"><span class=\"$aula5\"></span></td>
                                        <td class=\"alCenter\">$btnExcluir</td>
                                    </tr>
                                ";
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </article>
                    <a class="btnVoltar" href="/<?php print $tipoUrl; ?>/agendas/">Voltar</a>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>