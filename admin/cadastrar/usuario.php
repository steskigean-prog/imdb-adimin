<?php

    if(!isset($page)) exit;

    if (!empty($id)) {
        $sql = "select *,date_format(datanascimento, '%d/%m/%Y') data
        from usuario where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id",$id);
        $consulta->execute();

        $dadosCadastro = $consulta->fetch(PDO::FETCH_OBJ);
    }

    $nome = $dadosCadastro->nome ?? NULL;
    $email = $dadosCadastro->email ?? NULL;
    $data = $dadosCadastro->data ?? NULL;
    $cpf = $dadosCadastro->cpf ?? NULL;
    $salario = $dadosCadastro->salario ?? NULL;
    $ativo = $dadosCadastro->ativo ?? NULL;

    if (!empty($salario)) $salario=number_format($salario, 2,"," , ",");
?>
<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Usuario</h2>
            </div>
            <div class="float-end">
                <a href="cadastrar/usuario" class="btn btn-primary">
                    Novo Registro
                </a>
                <a href="listar/usuario" class="btn btn-primary">
                    Listar Registros
                </a>
            </div>
        </div>
        <div class="card-body">
            <form name="formCadastro" method="post" action="salvar/usuario" data-parsley-validate>
                <div class="row">
                    <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="text" name="id" id="id" class="form-control" readonly
                        value="<?= $id?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="nome">Nome completo:</label>
                        <input type="text" name="nome" id="nome" class="form-control" required
                        data-parsley-required-message="Preencha este campo" value="<?=$nome?>">
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="email">Seu melhor e-mail:</label>
                        <input type="email" name="email" id="email" class="form-control" required data-parsley-required-message="Preencha este campo"
                        data-parsley-type-message="Digite um e-mail válido"
                        value="<?=$email?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="senha">Digite um a senha com mínimo de 6 caracteres:</label>
                        <input type="passaword" name="senha" id="senha" class="form-control" required
                        data-parsley-required-message="Preencha este campo">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="senha2">Redigite a senha:</label>
                        <input type="passaword" name="senha2" id="senha2" class="form-control" required
                        data-parsley-required-message="Preencha este campo"
                        data-parsley-equalto="#senha"
                        data-parsley-equalto-message="As senhas não conferem!">
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="salario">Salário:</label>
                        <input type="text" name="salario" id="salario" class="form-control" required
                        data-parsley-required-message="Preencha este campo"
                        value="<?=$salario?>">
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="datanascimento">Data de Nascimento:</label>
                        <input type="text" name="datanascimento" id="datanascimento"
                        class="form-control" required
                        data-parsley-required-message="Preencha este campo"
                        value="<?=$data?>">
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="cpf">CPF:</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" required
                        data-parsley-required-message="Preencha este campo"
                        value="<?=$cpf?>">
                    </div>
                    <div class="com12 col-md-3">
                        <label for="ativo">Selecione Ativo:</label>
                        <select name="ativo" id="ativo" required class="form-control"
                        data-parsley-required-message="Selecione uma opção">
                            <option value=""></option>
                            <option value="Sim">Sim</option>
                            <option value="Não">Não</option>
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary float-end">
                    Gravar Dados
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#cpf").inputmask('999.999.999-99');
        $("#datanascimento").inputmask('99/99/9999');
        $('#salario').mask('000.000.00',{
            reverse: true
        });

        $("#ativo") . val("<?= $ativo ?>");

        <?php
            if (!empty($id)) {
                 ?>
                    $('#senha').remaveAttr('required').parsley().reset();
                    $('#senha2').removeAttr('required').parsley().reset();
                 <?php
            }
        ?>


    })
</script>
