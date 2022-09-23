<?php

//Verifica se o servidor é local ou não
$tipo_conexao = $_SERVER['HTTP_HOST'];
if (($tipo_conexao == 'localhost') || ($tipo_conexao == '127.0.0.1')) {
    $url_padrao = 'C:/xampp/htdocs/fvb/uploads/p07/';
    $caminho_final = 'http://localhost/fvb/uploads/p07';
} else {
    $url_padrao = '/home/fvblocadora/www/FVB/painel/uploads/p07/';
    $caminho_final = 'http://fvblocadora.com.br/FVB/painel/uploads/p07';
}

//Verifica se existe uma pasta criada com o mes, e o ano atual
if (is_dir($url_padrao . date('m-Y'))) {
} else {
    mkdir($url_padrao . date('m-Y') . '/');
}

//Define o url padrão de upload e a mensagem de erro padrão
$uploadDir = $url_padrao . date('m-Y') . '/';
$response = array(
    'status' => 0,
    'message' => 'Ocorreu um erro, tente novamente mais tarde',
);

//Verifica se tem algum arquivo adicionado
if (isset($_FILES['file'])) {
    $uploadStatus = 1;
    $uploadedFile = '';

    //Verifica se o arquivo possui um nome
    if (!empty($_FILES["file"]["name"])) {
        $fileName = time() . '-' . basename($_FILES["file"]["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        // Habilita os formatos
        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to the server 
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $uploadedFile = $fileName;
                $response = array(
                    'status' => 1,
                    'message' => 'Arquivo adicionado com sucesso!',
                    'url' => $caminho_final . "/" . date('m-Y') . "/" . $fileName,
                );
            } else {
                $uploadStatus = 0;
                $response['message'] = 'Desculpe, aconteceu um erro no upload do seu arquivo';
            }
        } else {
            $uploadStatus = 0;
            $response['message'] = 'Desculpe, apenas arquvios PDF, DOC, JPG, JPEG, & PNG';
        }
    }
}

// Return response 
echo json_encode($response);
