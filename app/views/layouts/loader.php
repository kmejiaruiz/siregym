<!-- Loader -->
<div id="loader">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Cargando...</span>
    </div>
</div>
<style>
    /* Loader Styles */
    #loader {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: #fff;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>

<!-- JS (jQuery, Bootstrap, AdminLTE) -->
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
    // Ocultar el loader y mostrar el contenido una vez que la p\u00e1gina est\u00e9 cargada
    $(document).ready(function () {
        $("#loader").fadeOut(500, function () {
            $("#content-wrapper").fadeIn(500);
        });
    });
</script>