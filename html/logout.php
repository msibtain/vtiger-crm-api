<!DOCTYPE html>
<head>

<title>Logout</title>

<?php include('header.php'); ?>


</head>
<body>

<br><br>

<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">
                    <h3>Logout</h3>
                    <br>

                    <form id="frmLogout">
                        
                        <br><br>
                        
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
            

        </div>
        <div class="col-md-2"></div>
    </div>
</div>    

<?php include('footer.php'); ?>

<script>
jQuery(document).ready(function(){

    jQuery('#frmLogout').on('submit', function(event){

        setCookie('vtiger_user', 0, 0);
        window.location = 'login.php'
        
        return false;
    });
});

</script>
</body>
</html>