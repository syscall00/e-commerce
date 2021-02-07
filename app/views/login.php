<script src="/public/js/login/index.js"></script>
<link href="css/login/index.css" type="text/css" rel="stylesheet" />

<div class="wrapper">
    <div id="login-form" class="form-background">
        <div class="card-header mb-3">
            <h3>Login</h3>
        </div>
        <form>
        <input type="text" name="username-log" placeholder="Username" />
        <input type="password" name="password-log" placeholder="Password" />
        <input type="button" name="login" value="Log In" />
        </form>
        <div id="formFooter">
            <p>Non hai un account?<button id="register-form-link" class="btn btn-link">Registrati ora</button></p>
        </div>
    </div>

    <div id="register-form" class="form-background">
        <div class="card-header mb-3">
            <h3>Registrazione</h3>
        </div>
        <form id="register">
        <input type="text" name="username" placeholder="Username" />
        <input type="text" name="name" placeholder="Nome" />
        <input type="text" name="surname" placeholder="Cognome" />
        <input type="password" name="password" placeholder="Password" />
        <input type="email" name="email" placeholder="Email" />
        <input type="button" name="register" value="Registrati" />
        </form>

        <div id="formFooter">
            <p>Hai già un account?<button id="login-form-link" class="btn btn-link">Effettua il Login</button></p>
        </div>
    </div>
</div>
