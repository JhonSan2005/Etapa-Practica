<div class="container d-flex justify-content-center align-items-center" style="margin-top: 100px;">
    <div class="card shadow p-4 border-0" style="max-width: 420px; width: 100%; background-color: #f8f9fa;">
        <div class="text-center mb-4">
            <h2 class="text-primary">CUTCONTABILY</h2>
        </div>
        <?php include_once __DIR__ . "../../../helpers/Alerta.php"; ?>

        <form id="login-form" action="/login" method="POST">
            <div class="mb-3">
                <input type="email" name="correo" class="form-control form-control-lg" placeholder="Correo" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Contraseña" required>
            </div>

            <div class="mb-3 text-center">
                <div class="g-recaptcha d-inline-block" data-sitekey="6LfaIgwqAAAAAFjrowWPA5vbDBONVvx83AP2Iv9S"></div>
            </div>

            <button type="submit" class="btn w-100 btn-lg" style="background-color: #003366; color: #fff;">Iniciar Sesión</button>
        </form>

        <div class="mt-4 text-center">
            <small>¿Olvidaste tu contraseña? <a href="/recover" class="text-decoration-none" style="color: #003366;">Recupérala aquí</a></small>
        </div>
    </div>








    

    <script src="../JS/alerta_bloqueo.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('login-form');
            form.addEventListener('submit', function (event) {
                const recaptchaResponse = grecaptcha.getResponse();
                if (recaptchaResponse.length === 0) {
                    event.preventDefault();
                    alert('Por favor, completa el reCAPTCHA.');
                }
            });
        });
    </script>
</div>
