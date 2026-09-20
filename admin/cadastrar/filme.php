<?php
    if (!isset($page)) exit;

    if(!empty($id)) {
         $sql="select * from filme  where id = :id limit 1";
         $consulta = $pdo->prepare($sql);
         $consulta->bindParam(":id", $id);
         $consulta->execute();

         $dados = $consulta->fetch(PDO::FETCH_OBJ);
    }

    $titulo = $dados->titulo ?? NULL;
    $original = $dados->original ?? NULL;
    $ano = $dados->ano ?? NULL;
    $categoria_id = $dados->categoria_id ?? NULL;
    $youtube = $dados->youtube ?? NULL;
    $sinopse = $dados->sinopse ?? NULL;
?>
<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Filme</h2>
            </div>
            <div class="float-end">
                <a href="cadastrar/filmes" class="btn btn-primary">
                    Novo Registro
                </a>
                <a href="listar/filmes" class="btn btn-primary">
                    Listar Registros
                </a>
            </div>
        </div>
        <div class="card-body">
            <form name="formCadastro" method="post" action="salvar/filme" data-parsley-validate enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="number" name="id" id="id" readonly class="form-control" value="<?=$id?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="titulo">Título do Filme:</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required data-parsley-required-message="Preencha este campo"
                        value="<?=$titulo?>">
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="original">Título Original:</label>
                        <input type="text" name="original" id="original" class="form-control" required data-parsley-required-message="Preencha este campo"
                        value="<?=$original?>">
                    </div>
                    <div class="col-12 col-md-1">
                        <label for="ano">Ano:</label>
                        <input type="number" name="ano" id="ano" required class="form-control" data-parsley-required-message="Preencha este campo"
                        value="<?=$ano?>">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="categoria_id">Selecione a Categoria:</label>
                        <select name="categoria_id" id="categoria_id" class="form-control" required data-parsley-required-message="Selecione uma opção">
                            <option value="">Selecione</option>
                            <?php
                                $sqlCategoria = "select id, categoria from categoria order by categoria";
                                $consultaCategoria = $pdo->prepare($sqlCategoria);
                                $consultaCategoria->execute();

                                $dadosCategoria = $consultaCategoria->fetchAll(PDO::FETCH_OBJ);

                                foreach($dadosCategoria as $dados) {
                                    ?>
                                    <option value="<?=$dados->id ?>"><?=$dados->categoria?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <script>
                        $(document).ready(function(){
                            $("#categoria_id").val(<?=$categoria_id?>);
                        })     
                        </script>
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="youtube">Cod. Youtube:</label>
                        <input type="text" name="youtube" id="youtube" class="form-control" required data-parsley-required-message="Preencha este campo"
                        value="<?=$youtube?>">
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="capa">Selecione a Capa:</label>
                        <input type="file" name="capa" id="capa" class="form-control">
                    </div>
                    <div class="col-12 col-md-12">
                        <label for="sinopse">Descrição da Sinopse</label>
                        <textarea name="sinopse" id="sinopse" class="form-control" required data-parsley-required-message="Preencha este campo"><?= $sinopse?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-end mt-3">
                    Salvar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#sinopse').summernote({
            placeholder:'Digite a Sinopse!',
            tabsize: 2,
            height: 300
    });
})
   
</script>
