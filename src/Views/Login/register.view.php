<?php $this->layout('Templates/Login/login') ?>
<?php $this->section('body'); ?>
<div class="register-box">
    <div class="register-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>
            <div id="error">
            </div>
            <form id="registerForm">
                <div class="input-group mb-3">
                    <input id="name" type="text" class="form-control" placeholder="Full name" require>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control" placeholder="Email" require>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control" placeholder="Password" require>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="confirmPassword" type="password" class="form-control" placeholder="Retype password" require>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i>
                    Sign up using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i>
                    Sign up using Google+
                </a>
            </div>

            <a href="/login" class="text-center">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<?php $this->end() ?>

<?php $this->section('script'); ?>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
    document.getElementById('registerForm').addEventListener('submit', registerUser);

    function showError(erro) {
        var errorAlert = document.getElementById("error");
        errorAlert.setAttribute("class", "alert alert-danger");
        errorAlert.setAttribute("role", "alert")
        errorAlert.innerHTML = erro;
    }

    function registerUser(event) {
        event.preventDefault(); // Evitar o envio padrão do formulário

        // Função para obter o valor do campo do formulário
        function getFieldValue(fieldId) {
            return document.getElementById(fieldId).value;
        }

        // Verificar se os campos obrigatórios estão preenchidos
        const requiredFields = ['name', 'email', 'password', 'confirmPassword'];
        for (const fieldId of requiredFields) {
            const fieldValue = getFieldValue(fieldId);
            if (fieldValue.trim() === '') {
                showError(`${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)} deve ser preenchido.`);
                return;
            }
        }

        // Validar se as senhas coincidem
        const password = getFieldValue('password');
        const confirmPassword = getFieldValue('confirmPassword');
        if (password !== confirmPassword) {
            showError('As senhas não coincidem.');
            return;
        }

        // Enviar dados para o backend usando fetch
        fetch('/newUser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: getFieldValue('name'),
                    email: getFieldValue('email'),
                    password: password,
                }),
            })
            .then(response => {
                if (!response.ok) {
                    return response.text();
                } else {
                    return Promise.resolve('');
                }
            })
            .then(errorText => {
                if (errorText) {
                    showError(errorText);
                } else {
                    // Redirecionar para a página de login se o cadastro for bem-sucedido
                     window.location.href = '/login';
                }
            })
            .catch(error => {
                showError(error.message);
            });
    }
</script>
<?php $this->end() ?>