<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>View Documents</title>

<?php include('header.php'); ?>


</head>
<body>

<br><br>

<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">

        <?php include('navbar.php'); ?>

            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-9">
                            <h3>View Documents</h3>
                        </div>
                        <div class="col-md-3">
                            <div align="right">
                                <a class="btn btn-primary" href="add-document.php?task_id=<?php echo $_GET['task_id'] ?>">Add Document</a>
                            </div>    
                        </div>
                    </div>
                    
                    <br>
                    
                    <div class="table-responsive">

                    <table class="table table-bordered" id="tblDocs">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Document Name</th>
                                <th scope="col">File Name</th>
                                <th scope="col">Downlaod</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    
                    </div>

                </div>
            </div>
            

        </div>
        <div class="col-md-1"></div>
    </div>
</div>    

<?php include('footer.php'); ?>

<script>
jQuery(document).ready(function($){

    jQuery.ajax({
        type: 'POST',
        url: "https://tfkgdemo.com/vtiger-crm/api/view-documents",
        data: {
            user_id: getCookie('vtiger_user'),
            task_id: <?php echo (int)@$_GET['task_id'] ?>
        },
        success: function(response){

            if (response.success === "true")
            {
                jQuery.each(response.documents, function(index, objDoc){
                    $('#tblDocs > tbody:first').append(`
                        <tr>
                            <td>`+(parseInt(index) + 1)+`</td>
                            <td>`+objDoc.title+`</td>
                            <td>`+objDoc.filename+`</td>
                            <td><a target="_blank" href="../`+objDoc.path+objDoc.attachment_id+`_`+objDoc.filename+`">Download</td>
                        </tr>
                    `); 
                })
            }
            
        }
    });

});    
</script>
</body>
</html>