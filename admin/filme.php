<?php
    if (!isset($page)) exit;

    $id = $id ?? $param[2] ?? NULL;

    if (empty($id)) {
        echo "<script>mensagem('ID do registro não foi informado','error');</script>";
        exit;
    }

    try {
        $sqlDelete = "delete from filme where id = :id limit 1";
        $consulta = $pdo->prepare($sqlDelete);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            echo "<script>mensagem('Filme excluído com sucesso','success','listar/filme');</script>";
        } else {
            echo "<script>mensagem('Nenhum filme encontrado com este ID para excluir','error');</script>";
        }

    } catch (PDOException $e) {
        echo "<script>mensagem('Erro ao excluir o filme no banco de dados','error');</script>";
    }
    exit;
?>