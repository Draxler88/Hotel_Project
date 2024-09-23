

<?php function style3(){ ?>

                .custom-alerta {
                    border: 1px solid red;
                    background-color: red;
                    color: #721c24;
                    border-radius: 5px;
                    padding: 15px;
                    margin: 20% 25%;
                    font-weight: bold;
                }
<?php }?>

<?php function nav3(){ ?>
        <div class="alert custom-alerta alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Your account has been blocked. Please contact support for assistance.
        </div>
    <?php } ?>