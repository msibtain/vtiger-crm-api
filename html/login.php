<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Login</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />


</head>
<body>

<br><br>

<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">
                    <h3>Login</h3>
                    <br>

                    <form id="frmLogin">

                        <div class="form-group">
                          <label for="title">Username</label>
                          <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Enter Username" />
                        </div>

                        <div class="form-group">
                          <label for="title">Password</label>
                          <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Enter Password" />
                        </div>

                        
                        <br><br>
                        
                        <button type="submit" class="btn btn-primary">Login</button>
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

    var vtiger_user = getCookie('vtiger_user');
    if (vtiger_user)
    {
        window.location = "view-tasks.php";
    }

    jQuery('#frmLogin').on('submit', function(event){
        event.preventDefault();
        const myFormData = new FormData(event.target);
        const formDataObj = {};
        myFormData.forEach((value, key) => (formDataObj[key] = value));
        

        jQuery.ajax({
            type: 'POST',
            url: "https://tfkgdemo.com/vtiger-crm/api/login",
            data: formDataObj,
            success: function(response){
                console.log("in success");
                console.log( response );

                if (response.success === "true")
                {
                    toastr.success(response.message, 'Success!')
                    setCookie('vtiger_user', response.id, 3);
                    window.location = "view-tasks.php";
                }
                else
                {
                    toastr.error(response.message, 'Error!')
                }
            }
        });
        return false;
    });
});

</script>
</body>
</html>