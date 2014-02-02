<div id="efeitoDegradeLinear2"></div>
<div class="shadow"></div>
<div id="footer1">
    <div class="enquadramento1000px">
        <a href="http://www.centropaulasouza.sp.gov.br" target="_blank">
            <img src="/imagens/layout/estrutura/png/CPS-SP.graphic.png">
        </a>
    </div>
</div>
<div class="shadow"></div>
<div id="footer2">
    <div class="enquadramento1000px">
        <div id="bloco1">
            <hgroup>
                <h1><?php print $objI->nomeFantasia; ?></h1>
                <h2><?php print $objI->nome; ?></h2>
            </hgroup>
            <address>
                <?php
                $complemento =  ($objI->complemento) ? " $objI->complemento," : "";
                $fax = ($objI->fax) ?  " - Fax: $objI->fax" : "";
                ?>
                <a href="http://maps.google.com/maps?q=<?php print urlencode("$objI->endereco, $objI->cep, $objI->cidade, $objI->estado"); ?>&z=19" target="_blank"><?php print "$objI->endereco,$complemento $objI->cep, $objI->cidade, $objI->estado"; ?></a><br>
                <?php print "Fone: $objI->telefone$fax";?><br>E-mail: <a href="mailto:<?php print $objI->email; ?>"><?php print $objI->email; ?></a>
            </address>
            <div class="clear"></div>
        </div>
        <div id="bloco2">
            <nav id="menuFooter">
                <ul>
                    <li class="dropFooter">
                        <a>INSTITUIÇÃO</a>
                        <ul class="dropFooter">
                            <li><a href="/instituicao/">A Fatec Marília</a></li>
                            <?php
                            $objD123 = new Departamento();
                            if ($objD123->qtdRegistrosMural() > 0) {
                                foreach ($objD123->listarMural() as $obj) {
                                    print "<li><a href=\"/mural/" . _funcoes::urlString(strtolower($obj->nome)) . ".html\">$obj->nome</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="dropFooter">
                        <a>CURSOS</a>
                        <ul class="dropFooter">
                        <?php
                            $objC123 = new Curso();
                            if ($objC123->qtdRegistros() > 0) {
                                foreach ($objC123->listarTudo() as $obj) {
                                    print "
                                        <li><a href=\"/cursos/graduacao/" . _funcoes::urlString(strtolower($obj->nome)) . ".html\">$obj->nomeCompleto</a></li>
                                    ";
                                }
                            }
                            $objC123 = new CursoPos();
                            if ($objC123->qtdRegistros() > 0) {
                                foreach ($objC123->listarTudo() as $obj) {
                                    print "
                                        <li><a href=\"/cursos/pos-graduacao/" . _funcoes::urlString(strtolower($obj->nome)) . ".html\">$obj->nomeCompleto</a></li>
                                    ";
                                }
                            }
                        ?>
                        </ul>
                    </li>
                    <li><a href="/fotos/">FOTOS</a></li>
                    <li><a href="/noticias/">NOTÍCIAS</a></li>
                </ul>
            </nav>
            <p>Copyright © 2006 - <?php print date('Y', time()) . " $objI->nomeFantasia"; ?>. Todos os direitos reservados.</p>
        </div>
        <div class="clear"></div>
    </div>
</div>
