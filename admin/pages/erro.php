<?php
    if (!isset($page)) exit;

    $caminhoImagem = __DIR__ . '/../imgs/erro.png';

    if (!file_exists($caminhoImagem)) {
        $caminhoImagem = $_SERVER['DOCUMENT_ROOT'] . '/imdb-admin/admin/imgs/erro.png';
    }
    if (!file_exists($caminhoImagem)) {
        $caminhoImagem = $_SERVER['DOCUMENT_ROOT'] . '/imdb-admin/imgs/erro.png';
    }

    $srcImagem = '';
    if (file_exists($caminhoImagem)) {
        $tipo = pathinfo($caminhoImagem, PATHINFO_EXTENSION);
        $dados = file_get_contents($caminhoImagem);
        $srcImagem = 'data:image/' . $tipo . ';base64,' . base64_encode($dados);
    }
?>
<div class="container text-center py-5">
    <div class="card shadow p-4">
        <div class="card-body">
            <?php if ($srcImagem): ?>
                <img src="<?= $srcImagem ?>" alt="Erro" class="img-fluid my-3" style="max-width: 300px;">
            <?php else: ?>
                <div class="alert alert-warning my-3">
                    A imagem não foi localizada no caminho físico: <br>
                    <code><?= $caminhoImagem ?></code>
                </div>
            <?php endif; ?>
            
            <h2 class="text-danger mt-3">Ops! Página não encontrada.</h2>
            <p class="text-muted">A página ou ação solicitada não existe ou ainda está em desenvolvimento.</p>
            <a href="index.php" class="btn btn-warning mt-3">Voltar ao Início</a>
        </div>
    </div>
</div>
