<?php
    if (!isset($page)) exit;

    $id = $param[2] ?? NULL;

    if (empty($id)) {
        echo "<script>mensagem('Registro inválido','error');</script>";
        exit;
    }

    try {
        $pdo->beginTransaction();

        $sqlDelete = "delete from categoria where id = :id limit 1";
        $consulta = $pdo->prepare($sqlDelete);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $pdo->commit();

        echo "<script>mensagem('Registro excluído com sucesso','success','listar/categoria');</script>";

    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        if ($e->getCode() == '23000') {
            echo "<script>mensagem('Esta categoria não pode ser excluída pois existem filmes associados a ela!','error');</script>";
        } else {
            echo "<script>mensagem('Erro ao excluir no banco de dados','error');</script>";
        }
    }
    exit;
?>
