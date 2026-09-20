<?php if (!isset($page)) exit; ?>
<?php

    $sqlCadastro = "select * from usuario order by nome";
    $consultaCadastro = $pdo->prepare($sqlCadastro);
    $consultaCadastro->execute();

    $dadosCadastro = $consultaCadastro->fetchAll(PDO::FETCH_OBJ);


?>
<div class="card shadow">
    <div class="card-header">
        <h2 class="float-start">Cadastro de Usuário</h2>
        <div class="float-end">
            <a href="cadastrar/usuario" class="btn btn-primary">Cadastrar Novo</a>
            <a href="listar/usuario" class="btn btn-primary">Listar</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped m-2">
            <thead>
                <tr>
                    <td width="10%">ID</td>
                    <td width="70%">Nome do Usuário</td>
                    <td width="20%">Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($dadosCadastro as $dados) {
                        ?>
                        <tr>
                            <td><?= $dados->id ?></td>
                            <td><?= $dados->nome ?></td>
                            <td>
                                <a href="cadastrar/usuario/<?= $dados->id ?>" class="btn btn-warning">
                                    Editar
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>