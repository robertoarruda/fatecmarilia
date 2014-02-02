<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('agenda');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objAgendamento = new AgendamentoLivre();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = explode('/', returnPost('data'));
    if (count($data) == 3) {
        if ($data[2] > 31)
            $data = "$data[2]-$data[1]-$data[0]";
        else
            $data = returnPost('data');
    } else
        $data = returnPost('data');

    $objAgendamento->data = $data;
    $objAgendamento->horarioInicial = returnPost('horarioInicial');
    $objAgendamento->horarioFinal = returnPost('horarioFinal');
    $objAgendamento->comentarios = returnPost('comentarios');
    $objAgendamento->agendas_codigo->codigo = returnPost('agendas_codigo');
    $objAgendamento->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = returnPost('cpf');

    $dir = "/$tipoUrl/agendas/l/" . $objAgendamento->agendas_codigo->codigo . "/";
    $erro = "
        <script>
        $.showMsg({
            msg: 'Ocorreu um erro na operação solicitada.',
            titulo: 'Erro'
        });
        </script>
    ";
    switch (strtolower(returnPost('acao'))) {
        case 'cadastrar':
            $objAgenda = new Agenda();
            $objAgenda = $objAgenda->consultar($objAgendamento->agendas_codigo->codigo);
            if (strtotime("+$objAgenda->diasDeAntecedencia days 00:00:00") > strtotime($objAgendamento->data)) {
                $data = date('d/m/Y', strtotime('+' . $objAgenda->diasDeAntecedencia . ' days 00:00:00'));
                print "
                    <script>
                    $.showMsg({
                        msg: 'Não é possível cadastrar uma reserva nesta data.<br>Tente em uma data a partir de $data.',
                        titulo: 'Erro'
                    });
                    </script>
                ";
            } elseif (in_array(date('w', strtotime($objAgendamento->data)), array(0,6))) {
                print "
                    <script>
                    $.showMsg({
                        msg: 'Não é possível cadastrar uma reserva fora de um dia útil.',
                        titulo: 'Erro'
                    });
                    </script>
                ";
            } elseif ($objAgendamento->existeAgendamento($objAgendamento->data, $objAgendamento->agendas_codigo->codigo, $objAgendamento->horarioInicial, $objAgendamento->horarioFinal)) {
                print "
                    <script>
                    $.showMsg({
                        msg: 'Já existe uma reserva cadastrada dentro destas condições.',
                        titulo: 'Erro'
                    });
                    </script>
                ";
            } else {
                if ($objAgendamento->inserir())
                    print("
                        <script>
                        $.showMsg({
                            msg: 'Cadastro efetuado com sucesso.',
                            titulo: 'Sucesso'
                        }, function(){
                            window.location = '$dir';
                        });
                        </script>
                    ");
                else
                    print($erro);
            }
            break;
        case 'excluir':
            $obj = $objAgendamento->consultar(returnPost('dados'));
            if ($objAgendamento->excluir(returnPost('dados'))) {
                print("
                    <script>
                    $.showMsg({
                        msg: 'Remoção efetuada com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                        window.location = '/$tipoUrl/agendas/l/" . $obj->agendas_codigo->codigo . "/';
                    });
                    </script>
                ");
            }
            else
                print($erro);
            break;
    }
    die();
}
$objAgenda = new Agenda();
$objAgenda = $objAgenda->consultar(returnGet('c'));
if ((!$objAgenda) || ($objAgenda->tipoDeHorario <> 'L')) {
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
    _funcoes::error404($url);
}

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') === FALSE)
    $objAgendamento->data = ($objAgendamento->data) ? date('d/m/Y', strtotime($objAgendamento->data)) : '';
$cpf = $objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;
$minData = date('Y-m-d', strtotime("+$objAgenda->diasDeAntecedencia days 00:00:00"));
$minData2 = date('d/m/Y', strtotime($minData));
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') === FALSE)
    $minData = date('d/m/Y', strtotime($minData));

$str = <<<STR
        <input
            id="agendas_codigo"
            name="agendas_codigo"
            type="hidden"
            value="$objAgenda->codigo"
        >
        <input
            id="cpf"
            name="cpf"
            type="hidden"
            value="$cpf"
        >
        <label for="data">Data</label>
        <input
            id="data"
            name="data"
            type="date"
            placeholder="00/00/0000"
            value="$objAgendamento->data"
            min="$minData"
            min-data="$minData2"
        >
        <label for="horarioInicial">Horário Inicial</label>
        <input
            id="horarioInicial"
            name="horarioInicial"
            type="time"
            value="$objAgendamento->horarioInicial"
        >
        <label for="horarioFinal">Horário Final</label>
        <input
            id="horarioFinal"
            name="horarioFinal"
            type="time"
            value="$objAgendamento->horarioFinal"
        >
        <label for="comentarios">Comentários</label>
        <textarea id="comentarios" name="comentarios"></textarea>
    <div class="clear"></div>
    <div class="buttons">
        <input
            id="btnCancelar"
            name="btnCancelar"
            type="button"
            class="btnForm"
            title="Cancelar"
            value="Cancelar"
        >
        <input
            id="btnSalvar"
            name="btnSalvar"
            type="submit"
            class="btnForm"
            title="Cadastrar"
            value="Cadastrar"
        >
    </div>
STR;
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
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/jquery.maskedinput.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_agendamentoLivre-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Agendamento - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Agendamento - <?php print $objAgenda->nome; ?></h1>
                        <form method="post">
                            <?php print $str; ?>
                        </form>
                    </article>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>