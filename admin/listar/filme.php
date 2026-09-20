<?php
    if (!isset($page)) exit;
?>
<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Listagem de Filme</h2>
            </div>
            <div class="float-end">
                <a href="cadastrar/filme" class="btn btn-primary">
                    Novo Registro
                </a>
                <a href="listar/filme" class="btn btn-primary">
                    Listar Registros
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <td width="80">Capa</td>
                        <td width="50">ID</td>
                        <td>Título</td>
                        <td>Categoria</td>
                        <td width="180" class="text-center">Opções</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sqlListar = "select f.id, f.capa, f.titulo, c.categoria, f.youtube
                            from filme f 
                            inner join categoria c on (c.id = f.categoria_id) 
                            order by f.titulo";
                        $consultarListar = $pdo->prepare($sqlListar);
                        $consultarListar->execute();
                        
                        $dadosListar = $consultarListar->fetchAll(PDO::FETCH_OBJ);

                        foreach ($dadosListar as $dados) {
                            ?>
                            <tr>
                                <td class="text-center">
                                    <img src="../arquivos/<?= $dados->capa ?>" alt="<?= $dados->titulo ?>" width="60">
                                </td>
                                <td><?= $dados->id ?></td>
                                <td>
                                    <a href="https://www.youtube.com/watch?v=<?= $dados->youtube ?>" target="_blank">
                                        <?= $dados->titulo ?>
                                    </a>
                                </td>
                                <td><?= $dados->categoria ?></td>
                                
                                <td class="text-center">
                                    <a href="cadastrar/filme/<?= $dados->id ?>" class="btn btn-sm btn-primary">
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
<script>
    function excluir(id) {
        Swal.fire({
            title: 'Deseja realmente excluir este filme?',
            text: "Esta ação não poderá ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'excluir/filme/' + id;
            }
        });
    }
</script>
<script>
    $(document).ready(function(){
        $(".table").DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nada encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                }
            }
        });
    })
</script>