<?php
    if (!isset($page)) exit;

    $sql = "select * from categoria order by categoria";
    $consulta = $pdo->prepare($sql);
    $consulta->execute();
    $dadosCategoria = $consulta->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Listar Categorias</h2>
            </div>
            <div class="float-end">
                <a href="cadastrar/categoria" class="btn btn-primary">
                    Novo Registro
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th>Categoria</th>
                        <th width="20%">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($dadosCategoria as $dados) {
                    ?>
                        <tr>
                            <td><?= $dados->id ?></td>
                            <td><?= $dados->categoria ?></td>
                            <td>
                                <a href="cadastrar/categoria/<?= $dados->id ?>" class="btn btn-sm btn-primary">
                                    Editar
                                </a>
                                <a href="javascript:excluir(<?= $dados->id ?>)" class="btn btn-sm btn-danger">
                                    Excluir
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
</div>

<script>
    function excluir(id) {
        Swal.fire({
            title: 'Deseja realmente excluir este registro?',
            text: "Esta ação não poderá ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'excluir/categoria/' + id;
            }
        });
    }
</script>
