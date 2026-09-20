<div class="login">
    <div class="card shadow">
        <div class="card-header text-center">
            <img src="../imgs/logo.PNG" alt="IMDB" class="w-100">
        </div>
        <div class="card-body">
            <form name="formLogin" method="post" data-parsley-validate>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required
                data-parsley-required-message="Preencha este campo"
                data-parsley-type-message="digite um  e-mail válido"
                class="form-control">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required
                data-parsley-required-message="Preencha esta campo"
                class="form-control">
                <br>
                <button type="submit" class="btn btn-success w-100">
                    Realizar Login
                </button>
            </form>
        </div>
    </div>
</div>