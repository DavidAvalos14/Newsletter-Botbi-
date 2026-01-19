<?php

// A partir de la URL de la noticia extraer todo su contenido

function extraerContenidoCompleto($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    $html = curl_exec($ch);
    curl_close($ch);
    
    if (empty($html)) return '';
    
    // Usar DOMDocument para extraer el contenido
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    
    // Intentar extraer párrafos del artículo
    $xpath = new DOMXPath($dom);
    $paragraphs = $xpath->query('//article//p | //div[contains(@class, "content")]//p');
    
    $contenido = '';
    foreach ($paragraphs as $p) {
        $contenido .= $p->textContent . "\n\n";
    }
    
    return trim($contenido);
}
?>