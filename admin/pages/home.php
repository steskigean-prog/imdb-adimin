<?php
    if (!isset($page)) exit;
?>
<div class="container">
    <div class="card mt-5 mb-5 shadow">
        <div class="card-header">
            <h2>Atalhos:</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 text-center">
                    <?php
                        $sqlCategorias = "select count(id) conta from categoria limit 1";
                        $consultaCategoria = $pdo->prepare($sqlCategorias);
                        $consultaCategoria->execute();
                        $categorias = $consultaCategoria->fetch(PDO::FETCH_OBJ)->conta;
                    ?>
                    <div class="alert alert-info text-center p-4 shadow h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h2>Categorias</h2>
                            <p class="fs-5">Temos <strong><?= $categorias ?></strong> cadastradas no Banco!</p>
                        </div>
                        <p class="mb-0 mt-3">
                            <a href="cadastrar/categoria" title="categoria" class="btn btn-info w-100 text-white fw-bold">
                                Cadastrar Categoria
                            </a>
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-4 text-center">
                    <?php
                        $sqlFilmes = "select count(id) conta from filme limit 1";
                        $consultaFilme = $pdo->prepare($sqlFilmes);
                        $consultaFilme->execute();
                        $filmes = $consultaFilme->fetch(PDO::FETCH_OBJ)->conta;
                    ?>
                    <div class="alert alert-warning text-center p-4 shadow h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h2>Filmes</h2>
                            <p class="fs-5">Temos <strong><?= $filmes ?></strong> cadastrados no Banco!</p>
                        </div>
                        <p class="mb-0 mt-3">
                            <a href="cadastrar/filme" title="filme" class="btn btn-warning w-100 fw-bold">
                                Cadastrar Filme
                            </a>
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-4 text-center">
                    <?php
                        $sqlUltimos = "select f.id, f.titulo, c.categoria 
                                       from filme f 
                                       left join categoria c on (c.id = f.categoria_id) 
                                       order by f.id desc limit 3";
                        $consultaUltimos = $pdo->prepare($sqlUltimos);
                        $consultaUltimos->execute();
                        $ultimosFilmes = $consultaUltimos->fetchAll(PDO::FETCH_OBJ);
                    ?>
                    <div class="alert alert-success text-center p-4 shadow h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h2>Últimos Adicionados</h2>
                            <ul class="list-group list-group-flush text-start my-2">
                                <?php 
                                    if (!empty($ultimosFilmes)):
                                        foreach ($ultimosFilmes as $item): 
                                ?>
                                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 py-1">
                                                <span class="text-truncate me-2" style="max-width: 160px;" title="<?= $item->titulo ?>">
                                                    <strong><?= $item->titulo ?></strong>
                                                </span>
                                                <span class="badge bg-secondary"><?= $item->categoria ?? 'Sem Categoria' ?></span>
                                            </li>
                                <?php 
                                        endforeach;
                                    else:
                                ?>
                                        <li class="list-group-item bg-transparent text-center px-0 py-1">Nenhum filme cadastrado</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <p class="mb-0 mt-3">
                            <a href="listar/filme" title="filmes" class="btn btn-success w-100 fw-bold">
                                Ver Todos os Filmes
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>