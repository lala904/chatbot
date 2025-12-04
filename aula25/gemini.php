<?php
    header("Content-Type: application/json");

    $mensagem = $_POST["mensagem"] ?? "";

    $api_key = "";
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $api_key;

    $prompt_iot = "
    Você é um assistente virtual que explica conceitos básicos de enfermagem com IoT.
    Responda SEMPRE de forma bem resumida (no máximo 3 frase).
    Use apenas texto simplis, sem negrito, sem asterisco e sem formatação.
    Fale simples, como se fosse para iniciantes.
    
    Mensagem: $mensagem
    ";
    
    $data =[
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt_iot]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if(curl_errno($ch)){
        echo json_encode(["resposta" => "❌ Erro ao conectar á IA: " . curl_error($ch)]);
        exit;
    }

    curl_close($ch);

    $json = json_decode($response, true);

    $resposta = $json["candidates"][0]["content"]["parts"][0]["text"]
        ?? "❌ A IA não respondeu. Verifique sua API KEY";

    echo json_encode(["resposta" => $resposta]);
   
