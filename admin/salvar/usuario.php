<?php
    if (!isset($page)) exit;

    if ($_POST) {
        foreach ($_POST as $chave => $valor) {
            $$chave = trim($valor);
        }

        $id = $id ?? NULL;
        $nome = $nome ?? NULL;
        $email = $email ?? NULL;
        $senha = $senha ?? NULL;
        $cpf = $cpf ?? NULL;
        $salario = $salario ?? NULL;
        $datanascimento = $datanascimento ?? NULL;
        $ativo = $ativo ?? "Sim";

        if (strlen($nome) < 5) {
            echo "<script>mensagem('Preencha o nome completo','error');</script>";
            exit;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>mensagem('Preencha um e-mail válido','error');</script>";
            exit;
        } else {

            if (function_exists('validarCPF') && validarCPF($cpf) != 1) {
                echo "<script>mensagem('CPF inválido','error');</script>";
                exit;
            }

            if (function_exists('dataUS')) {
                $datanascimento = dataUS($datanascimento);
            } else if (!empty($datanascimento)) {
                $data = explode("/", $datanascimento);
                if (count($data) == 3) {
                    $datanascimento = $data[2] . "-" . $data[1] . "-" . $data[0];
                }
            }

            if (function_exists('valores')) {
                $salario = valores($salario);
            } else if (!empty($salario)) {
                $salario = str_replace(".", "", $salario);
                $salario = str_replace(",", ".", $salario);
            }

            if (empty($id)) {

                $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

                $sql = "insert into usuario (nome, email, senha, cpf, salario, datanascimento, ativo) 
                        values (:nome, :email, :senha, :cpf, :salario, :datanascimento, :ativo)";

                $consulta = $pdo->prepare($sql);
                $consulta->bindParam(":nome", $nome);
                $consulta->bindParam(":email", $email);
                $consulta->bindParam(":senha", $senhaHash);
                $consulta->bindParam(":cpf", $cpf);
                $consulta->bindParam(":salario", $salario);
                $consulta->bindParam(":datanascimento", $datanascimento);
                $consulta->bindParam(":ativo", $ativo);

            } else if (empty($senha)) {

                $sql = "update usuario set nome = :nome, email = :email, cpf = :cpf, salario = :salario,
                        datanascimento = :datanascimento, ativo = :ativo where id = :id limit 1";

                $consulta = $pdo->prepare($sql);
                $consulta->bindParam(":nome", $nome);
                $consulta->bindParam(":email", $email);
                $consulta->bindParam(":cpf", $cpf);
                $consulta->bindParam(":salario", $salario);
                $consulta->bindParam(":datanascimento", $datanascimento);
                $consulta->bindParam(":ativo", $ativo);
                $consulta->bindParam(":id", $id, PDO::PARAM_INT);

            } else {

                $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

                $sql = "update usuario set nome = :nome, email = :email, cpf = :cpf, salario = :salario,
                        datanascimento = :datanascimento, ativo = :ativo, senha = :senha where id = :id limit 1";

                $consulta = $pdo->prepare($sql);
                $consulta->bindParam(":nome", $nome);
                $consulta->bindParam(":email", $email);
                $consulta->bindParam(":cpf", $cpf);
                $consulta->bindParam(":salario", $salario);
                $consulta->bindParam(":datanascimento", $datanascimento);
                $consulta->bindParam(":ativo", $ativo);
                $consulta->bindParam(":senha", $senhaHash);
                $consulta->bindParam(":id", $id, PDO::PARAM_INT);

            }

            try {
                if ($consulta->execute()) {
                    echo "<script>mensagem('Registro Salvo', 'success', 'listar/usuario');</script>";
                    exit;
                }

                echo "<script>mensagem('Erro ao Salvar','error');</script>";
                exit;

            } catch (PDOException $e) {
                if ($e->getCode() == '23000') {
                    echo "<script>mensagem('Este e-mail ou CPF já está cadastrado!','error');</script>";
                } else {
                    echo "<script>mensagem('Erro no banco de dados','error');</script>";
                }
                exit;
            }
        }
    }
?>