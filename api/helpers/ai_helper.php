<?php

// Reescritura del contenido con IA (Gemini)

function reescribirConIA($textoOriginal) {
    $apiKey = getenv('API_KEY_GEMINI');
    
    // ----------------------------------------------------------------
    // Verificar que existe la API key
    if (empty($apiKey)) {
        return $textoOriginal;
    }
    
    $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

    // ----------------------------------------------------------------

    // Prompt optimizado
    $prompt = "Actúa como un periodista profesional especializado en redacción original de noticias.
                Te proporcionaré el contenido de una noticia.  
                Tu tarea es reescribirla completamente para que sea 100% original, manteniendo el significado, los hechos y el contexto, pero cambiando:

                    - La estructura de las oraciones  
                    - El orden de las ideas  
                    - El estilo de redacción  
                    - El vocabulario utilizado  

                Evita cualquier forma de copia literal.  
                No uses sinónimos directos palabra por palabra: reformula las ideas.

                El nuevo texto debe:

                    - Sonar natural y humano  
                    - Tener coherencia periodística  
                    - Mantener un tono informativo y profesional  
                    - Conservar todos los datos importantes (fechas, cifras, nombres, lugares)  
                    - Ser indistinguible del original para detectores de plagio  

                No agregues opiniones personales ni información que no esté en el texto original.
                Aquí está la noticia original: " . $textoOriginal;

    $data = [
        "contents" => [["parts" => [["text" => $prompt]]]]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
    $result = json_decode($response, true);
    curl_close($ch);
    

    return $result['candidates'][0]['content']['parts'][0]['text'];
}

?>