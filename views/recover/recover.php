<div class="container min-h-100 d-flex justify-content-center align-items-center">

    <div class="mt-5 d-flex justify-content-center cutcontabily" style="width: fit-content; height: fit-content;">

        <div class="d-flex flex-column flex-md-row gap-3 border rounded-2 p-3 bg-white shadow">

            <div class="p-3">
                <div class="header-text mb-2">
                    <h2 class="text-body-secondary">Hola, Bienvenidos</h2>
                    <p class="text-body-secondary">Ingresa tu correo para Recuperar contraseña</p>
                </div>

                <?php include_once __DIR__ . "/../../views/includes/alertaTemplate.php"; ?>

                <form id="recover-form" action="/recover" method="POST">
                    <div class="input-group mb-2">
                        <input type="email" class="form-control form-control-lg bg-light fs-6" name="correo" placeholder="Correo" required>
                    </div>
                    <div class="g-recaptcha mb-3" data-sitekey="6LfaIgwqAAAAAFjrowWPA5vbDBONVvx83AP2Iv9S"></div>
                    <button type="submit" class="btn btn-lg btn-danger w-100 fs-6" style="background-color: #FF0000;">Recuperar</button>
                </form>
            </div>

        </div>

    </div>

</div>

<script src="../JS/alerta_bloqueo.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('recover-form');

        form.addEventListener('submit', function(event) {
            const recaptchaResponse = grecaptcha.getResponse();

            if (recaptchaResponse.length === 0) {
                event.preventDefault();
                alert('Por favor, completa el reCAPTCHA.');
            }
     });
    });
</script>
