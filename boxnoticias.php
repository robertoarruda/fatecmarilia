<?php

require_once(corrigeArq('config/loadConfig.php'));
$objNoticia = new Noticia();

if ($objNoticia->qtdAtivoRegistros() > 0) {
    print '<ul id="boxNoticias">';
    foreach ($objNoticia->listarAtivoMain() as $obj) {
        $dia = date('d', strtotime($obj->data));
        $mes = date('m', strtotime($obj->data));
        $ano = date('Y', strtotime($obj->data));
        printf('
            <li>
                <article class="boxNoticia">
                    <figure>
                        <a href="/noticias/%s.html">
                            <img class="lazy" src="/imagens/layout/estrutura/gif/lazyload-bg.gif" data-original="/%s">
                        </a>
                    </figure>
                    <h1>%s</h1>
                    <section><p>%s</p></section>
                     <a href="/noticias/%s.html" class="vejaMais">Veja Mais</a>
                </article>
            </li>
            ', "$ano/$mes/$dia/$obj->urlTitulo", $obj->dirImagem . '400x300/' . $obj->imagem, $obj->titulo, $obj->resumo, "$ano/$mes/$dia/$obj->urlTitulo"
        );
    }
    print '</ul>';
} else {
    print "<p class=\"null\">Nenhuma notícia encontrada.</p>";
}
?>