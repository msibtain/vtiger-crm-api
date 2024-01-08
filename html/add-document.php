<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Add Document</title>

<?php include('header.php'); ?>


</head>
<body>

<br><br>

<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">

            <?php include('navbar.php'); ?>

            <div class="card">
                <div class="card-body">
                    <h3>Add Document</h3>
                    <br>

                    <form id="frmAddDoc">

                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" />
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">File</label>
                            <input type="file" class="form-control" name="file" id="file" />
                        </div>

                        <br><br>

                        <input type="hidden" name="assigned_to" value="1" />
                        <input type="hidden" name="uploaded_by" id="uploaded_by"  />
                        <input type="hidden" name="task_id" id="task_id" value="<?php echo $_GET['task_id'] ?>"  />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            

        </div>
        <div class="col-md-2"></div>
    </div>
</div>    

<?php include('footer.php'); ?>

<script>
jQuery(document).ready(function($){

    $('#uploaded_by').val( getCookie('vtiger_user') );

    $("#frmAddDoc").submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "https://tfkgdemo.com/vtiger-crm/api/add-document",
            crossDomain: true,
            data: new FormData(this),
            dataType: "json",
            contentType: "multipart/form-data",
            processData: false,
            contentType: false,
            headers: {
                "Accept": "application/json"
            }
            }).done(function(response) {
                if (response.success === "true")
                {
                    toastr.success('Document has been added.', 'Success!')
                }
                else
                {
                    toastr.error('Error uploading document.', 'Error!')
                }
            }).fail(function() {
                toastr.error('Something went wrong.', 'Error!')
        });
    });

});    
</script>
</body>
</html>