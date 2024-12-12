<?php
include "../config.php";
include "protect-discente.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome-atividade'];
    $horas = $_POST['horas-atividade'];
    $categoria = $_POST['categoria'];
    $arquivo = $_FILES['certificado'];
    $discente_id = $_SESSION['id'];
    $status = '1'; // Status inicial

    // Verifica se o arquivo foi carregado sem erros
    if ($arquivo['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $nomeArquivo = pathinfo($arquivo['name'], PATHINFO_FILENAME) . "_" . md5(time()) . "." . $extensao;
        $diretorioDestino = '../atividades/' . $nomeArquivo;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($arquivo['tmp_name'], $diretorioDestino)) {
            // Inserir os dados no banco de dados
            $sql = "INSERT INTO atividade (nome, caminho_arquivo, categoria, horas_atividade, discente_id, status, data_upload) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $DB->prepare($sql);
            $stmt->bind_param("ssssis", $nome, $diretorioDestino, $categoria, $horas, $discente_id, $status);

            if ($stmt->execute()) {
                echo "<p>Atividade enviada com sucesso!</p>";
            } else {
                echo "<p>Erro ao salvar no banco de dados.</p>";
            }
        } else {
            echo "<p>Erro ao mover o arquivo.</p>";
        }
    } else {
        echo "<p>Erro no upload do arquivo.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio de Atividades Complementares - Instituto Federal</title>
    <link rel="stylesheet" href="styles/enviar-atividades.css">
</head>

<body>
    <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
    <div class="container">
        <div class="box">
            <h1>Envio de Atividades Complementares</h1>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome-atividade">Nome da Atividade</label>
                    <input type="text" id="nome-atividade" name="nome-atividade" placeholder="Nome da Atividade" required>
                </div>
                <div class="form-group">
                    <label for="horas-atividade">Horas da Atividade</label>
                    <input type="number" id="horas-atividade" name="horas-atividade" placeholder="Horas da Atividade" required>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoria da Atividade</label>
                    <select id="categoria" name="categoria" required>
                        <option value="" disabled selected>Selecione a Categoria</option>
                        <option value="palestra">Palestra</option>
                        <option value="workshop">Workshop</option>
                        <option value="curso">Curso</option>
                        <option value="seminario">Seminário</option>
                        <option value="outros">Outros</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="certificado">Upload do Certificado</label>
                    <input type="file" id="certificado" name="certificado" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <button type="submit" class="submit-button">Enviar</button>
                <a class="submit-button" href="main.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>