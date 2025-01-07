<?php
include "../config.php";
include "protect-docente.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? null;
    $horas = intval($_POST['horas-atividade']);
    $atividadeId = $_GET['id'];

    $updateSql = "UPDATE atividade SET status=?, horas_atividade=? WHERE id=?";

    $stmt = $DB->prepare($updateSql);
    $stmt->bind_param("ssi", $status, $horas, $atividadeId);

    if ($stmt->execute()) {
        //echo "<p>Dados atualizados com sucesso!</p>";
        echo "<script>alert('Dados atualizados com sucesso!'); window.location.href='main.php';</script>";
        //header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $atividadeId);
        exit();
    } else {
        echo "Erro ao atualizar os dados.";
    }
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $atividadeId = (int) $_GET['id'];

    // Consulta a atividade e o nome do discente
    $sql = "
        SELECT a.*, d.nome AS nome_discente
        FROM atividade a
        INNER JOIN discente d ON a.discente_id = d.id
        WHERE a.id = $atividadeId
    ";
    $resultAtividades = $DB->query($sql);

    if ($resultAtividades->num_rows > 0) {
        $atividade = $resultAtividades->fetch_assoc();
    } else {
        echo "Atividade não encontrada.";
        exit;
    }
} else {
    echo "ID de atividade inválido.";
    exit;
}

if (isset($_FILES['certificado'])) {
    $allowed_types = ['pdf', 'jpg', 'jpeg', 'png'];
    $max_file_size = 5 * 1024 * 1024; // 5MB max

    $file_name = $_FILES['certificado']['name'];
    $file_size = $_FILES['certificado']['size'];
    $file_tmp = $_FILES['certificado']['tmp_name'];
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (in_array($file_type, $allowed_types) && $file_size <= $max_file_size) {
        $unique_filename = uniqid() . '.' . $file_type;
        $upload_path = '../atividades/' . $unique_filename;

        if (!is_dir('../atividades')) {
            mkdir('../atividades', 0755, true);
        }

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $update_sql = "UPDATE atividade SET caminho_arquivo = ?, status = ? WHERE id = ?";
            $stmt = $DB->prepare($update_sql);
            $status = $_POST['categoria'];
            $stmt->bind_param("ssi", $unique_filename, $status, $atividadeId);

            if ($stmt->execute()) {
                echo "Arquivo enviado com sucesso!";
                // Reload page to show updated information
                header("Refresh:0");
                exit();
            } else {
                echo "Erro ao salvar no banco de dados.";
            }
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        echo "Arquivo inválido. Verifique o tipo e o tamanho.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de Atividades Complementares - Instituto Federal</title>
    <link rel="stylesheet" href="styles/valida-atividade.css">
</head>

<body>
    <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
    <div class="container">
        <div class="box">
            <h1>Validação de Atividades Complementares</h1>
            <form method="post">
                <div class="form-group">
                    <label for="nome-discente">Certificado</label>
                    <?php
                    if (!empty($atividade['caminho_arquivo'])) {
                        $file_path = '../atividades/' . $atividade['caminho_arquivo'];
                        if (file_exists($file_path)) {
                            $file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                            if (in_array($file_ext, ['pdf'])) {
                                echo '<embed src="' . $file_path . '" type="application/pdf" width="100%" height="500px" />';
                            } else {
                                echo '<img src="' . $file_path . '" style="max-width:100%; height:auto;" />';
                            }
                        } else {
                            echo "<p>Arquivo não encontrado.</p>";
                        }
                    } else {
                        echo "<p>Nenhum certificado enviado.</p>";
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="nome-discente">Nome do Discente</label>
                    <input type="text" id="nome-discente" name="nome-discente"
                        value="<?php echo htmlspecialchars($atividade['nome_discente']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nome-atividade">Nome da Atividade</label>
                    <input type="text" id="nome-atividade" name="nome-atividade" placeholder="Nome da Atividade"
                        value="<?php echo $atividade['nome'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <input type="text" id="Categoria" name="Categoria" placeholder="Categoria"
                        value="<?php echo $atividade['categoria'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="horas-atividade">Horas da Atividade</label>
                    <input type="text" id="horas-atividade" name="horas-atividade" placeholder="Horas da Atividade"
                        value="<?php echo $atividade['horas_atividade']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status">Status da Atividade</label>
                    <select id="status" name="status" required>
                        <option value="1" disabled selected>Selecione o Status</option>
                        <option value="2">Atividade valida</option>
                        <option value="3">Atividade invalida</option>
                    </select>
                </div>
                <button type="submit" class="submit-button">Enviar</button>
                <a class="submit-button" href="valida-atividades.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html> 