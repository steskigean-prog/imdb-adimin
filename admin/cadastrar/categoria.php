<?php
    if (!isset($page)) exit;

    $id = $param[2] ?? NULL;
    $categoria = "";

    if (!empty($id)) {
        $sql = "select * from categoria where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        if ($dados) {
            $categoria = $dados->categoria;
        }
    }

    if ($_POST) {
        $id = trim($_POST["id"] ?? NULL);
        $categoria = trim($_POST["categoria"] ?? NULL);

        if (empty($categoria)) {
            echo "<script>mensagem('Preencha o campo Categoria','error');</script>";
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
                echo "<script>mensagem('Registro Salvo com Sucesso','success','listar/categoria');</script>";
            } else {
                echo "<script>mensagem('Erro ao salvar registro','error');</script>";
            }
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                echo "<script>mensagem('A categoria \"{$categoria}\" já está cadastrada!','error');</script>";
            } else {
                echo "<script>mensagem('Erro ao salvar no banco de dados','error');</script>";
            }
        }
        exit;
    }
?>

<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Categoria</h2>
            </div>
            <div class="float-end">
                <a href="cadastrar/categoria" class="btn btn-primary">
                    Novo Registro
                </a>
                <a href="listar/categoria" class="btn btn-primary">
                    Listar Registros
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="cadastrar/categoria" data-parsley-validate="">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="id" class="form-label">ID:</label>
                        <input type="text" name="id" id="id" class="form-control" value="<?= $id ?>" readonly>
                    </div>
                    <div class="col-md-10 mb-3">
                        <label for="categoria" class="form-label">Categoria:</label>
                        <input type="text" name="categoria" id="categoria" class="form-control" value="<?= $categoria ?>" required data-parsley-required-message="Preencha este campo">
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
