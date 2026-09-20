<?php
    if (!isset($page)) exit;

    if ($_POST) {
        $id = trim($_POST["id"] ?? NULL);
        $categoria = trim($_POST["categoria"] ?? NULL);

        if (empty($categoria)) {
            echo "<script>mensagem('Preencha o nome da categoria','error');</script>";
            exit;
        }

        if (empty($id)) {
            $sql = "insert into categoria (categoria) values (:categoria)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":categoria", $categoria);
        } else {
            $sql = "update categoria set categoria = :categoria where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":categoria", $categoria);
            $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        }

        try {
            if ($consulta->execute()) {
                echo "<script>mensagem('Categoria salva com sucesso!','success','listar/categoria');</script>";
            } else {
                echo "<script>mensagem('Erro ao salvar categoria','error');</script>";
            }
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                echo "<script>mensagem('Já existe uma categoria cadastrada com este nome!','error');</script>";
            } else {
                echo "<script>mensagem('Erro no banco de dados','error');</script>";
            }
        }
    } else {
        echo "<script>mensagem('Requisição inválida','error');</script>";
    }
    exit;
?>