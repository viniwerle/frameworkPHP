<?php $this->layout('Templates/Login/login') ?>
<?php $this->section('body'); ?>
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <div id="error">
            </div>
            <form id="loginForm">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" nullable="true">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                </div>
                <div class="col-4">
                    <button id="submit" class="btn btn-primary btn-block">Sign In</a>
                </div>
            </form>


            <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <a href="#" id="facebookLogin" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                </a>
            </div>
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="forgot-password.html">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="/register" class="text-center">Register a new membership</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<?php $this->end() ?>

<?php $this->section('script'); ?>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
    document.getElementById('facebookLogin').addEventListener('click', facebookLogin);
    document.getElementById('loginForm').addEventListener('submit', sendForm);

    function sendForm(event) {
        var x = document.forms['loginForm']['email'].value;
        if (x === "") {
            alert("Name must be filled out");
            event.preventDefault();
        } else {

            var formData = new FormData(document.getElementById('loginForm'));
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        var url = new URL(window.location.href);
                        var redirectParam = url.searchParams.get('redirect');
                        if (redirectParam) {
                            // Redirecionar para a URL especificada
                            window.location.href = redirectParam;
                        } else {
                            window.location.href = "/";
                        }
                    } else {
                        var errorAlert = document.getElementById("error");
                        errorAlert.setAttribute("class", "alert alert-danger");
                        errorAlert.setAttribute("role", "alert")
                        errorAlert.innerHTML = "Erro no login: " + xhr.responseText;
                    }
                }
            };

            xhr.open('POST', '/login', true);
            xhr.send(formData);

            event.preventDefault(); // Evitar o envio padrão do formulário
        }
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId: 'SEU_APP_ID_DO_FACEBOOK',
            cookie: true,
            xfbml: true,
            version: 'v10.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function facebookLogin() {
        FB.login(function(response) {
            if (response.authResponse) {
                // O usuário autorizou o aplicativo
                console.log('Autenticação bem-sucedida:', response);
                // Aqui você pode adicionar lógica adicional, como enviar os dados para o servidor
            } else {
                console.log('Login cancelado ou ocorreu um erro.');
            }
        }, {
            scope: 'public_profile,email'
        });
    }
</script>
<?php $this->end() ?>