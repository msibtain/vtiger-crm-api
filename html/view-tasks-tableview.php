<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>View Tasks</title>

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
                    <h3>View Tasks</h3>
                    <br>

                    
                    <div class="table-responsive">

                    <table class="table table-bordered" id="tblTasks">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Project Task Name</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Progress</th>
                                <th scope="col">Worked Hours</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Action</th>
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
        url: "https://tfkgdemo.com/vtiger-crm/api/viewtasks",
        data: {
            user_id: getCookie('vtiger_user')
        },
        success: function(response){

            if (response.success === "true")
            {
                jQuery.each(response.tasks, function(index, objEvent){

                    

                    $('#tblTasks > tbody:first').append(`
                        <tr>
                            <td>`+objEvent.projecttaskid+`</td>
                            <td>`+objEvent.projecttaskname+`</td>
                            <td>`+objEvent.projecttaskpriority+`</td>
                            <td>`+objEvent.projecttaskprogress+`</td>
                            <td>`+objEvent.projecttaskhours+`</td>
                            <td>`+objEvent.startdate+`</td>
                            <td>`+objEvent.enddate+`</td>
                            <td>
                                <a class="btn btn-outline-primary btn-sm" href="edit-task.php?id=`+objEvent.projecttaskid+`">Edit</a> 
                                <a class="btn btn-outline-primary btn-sm" href="view-documents.php?task_id=`+objEvent.projecttaskid+`">Documents</a>
                            </td>
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