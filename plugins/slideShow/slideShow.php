<?php
$objDestaque = new Destaque();
$qtdSlides = ($objDestaque->qtdAtivoRegistros() > 5) ? 5 : $objDestaque->qtdAtivoRegistros();

if ($qtdSlides > 0) {
    print "<ul id=\"destaque\" qtdslides=\"$qtdSlides\">";
    $ordem = 'ASC';
    $count = ($ordem == 'ASC') ? 0 : $qtdSlides + 1;
    foreach ($objDestaque->listarAtivoSlides($ordem) as $obj) {
        ($ordem == 'ASC') ? $count++ : $count--;
        $a = ($obj->linkTarget) ? ' target="_blank"' : '';
        $a = "<a href=\"$obj->linkUrl\"$a title=\"$obj->titulo\">";
        printf('
            <li>
                <article id="slideSS%s" class="destaque">
                    %s
                        <figure><img src="%s" title="%s"></figure>
			<div class="%s">
                            %s
                            %s
			</div>
		    %s
		</article>
            </li>
            ',
            $count,
            ($obj->linkUrl)? $a : '',
            $obj->dirImagem . '984x434/' . $obj->imagem,
            $obj->titulo,
            ($obj->titulo) ? $obj->posicaoTitulo : '',
            ($obj->titulo) ? "<h1 class = \"$obj->posicaoTitulo\">$obj->titulo</h1>" : '',
            ($obj->resumo) ? "<section>$obj->resumo</section>" : '',
            ($obj->linkUrl)? '</a>' : ''
        );
    }
    print '</ul>';
}
if ($qtdSlides > 0) {
    print '<div class="menu"><ul id="menu">';
    $ordem = 'DESC';
    $count = ($ordem == 'ASC') ? 0 : $qtdSlides + 1;
    foreach ($objDestaque->listarAtivoSlides($ordem) as $obj) {
        ($ordem == 'ASC') ? $count++ : $count--;
        printf('
            <li>
                <figure><img id="menuSS%s" src="%s" title="%s"></figure>
            </li>
            ',
            $count,
            $obj->dirImagem . '145x86/' . $obj->imagem,
            $obj->titulo
        );
    }
    print '<div id="slideSeletor"></div></ul></div>';
}
?>