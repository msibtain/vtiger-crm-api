<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Completed Tasks</title>

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
                    <h3>Completed Tasks</h3>
                    <br>

                    <span id="view_tasks_wrapper"></div>

                    

                </div>
            </div>
            

        </div>
        <div class="col-md-1"></div>
    </div>
</div>    

<?php include('footer.php'); ?>

<script>

function loadTasks() {
    jQuery.ajax({
        type: 'POST',
        url: "https://crm.widdsigns.co.uk/api/viewtasks.php",
        //url: "https://tfkgdemo.com/vtiger-crm/api/viewtasks.php",
        data: {
            user_id: getCookie('vtiger_user'),
            progress: '100%'
        },
        success: function(response){

            if (response.success === "true")
            {
                var cardHTML = `<div class="row">`;

                if (response.tasks.length)
                {
                    jQuery.each(response.tasks, function(index, objEvent){

var priority = objEvent.projecttaskpriority.charAt(0).toUpperCase() + objEvent.projecttaskpriority.slice(1);

cardHTML += `<div class="col-md-6"><div class="card" style="margin-bottom: 15px;">
<div class="card-header">
<h5 class="card-title">`+objEvent.projecttaskname+`</h5>
</div>
<div class="card-body">

<h6 class="card-subtitle mb-2 text-muted"><b>Progress:</b></h6>
<div class="progress">
<div class="progress-bar" role="progressbar" style="width: `+objEvent.projecttaskprogress+`;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">`+objEvent.projecttaskprogress+`</div>
</div>
<br>

<p class="card-text">
<b>Priority:</b> `+priority+`<br>
<b>Worked Hours:</b> `+objEvent.projecttaskhours+`<br>
<b>Start Date:</b> `+objEvent.startdate+`<br>
<b>End Date:</b> `+objEvent.enddate+`
</p>
<div align="center">
<a style="width: 50%; margin-bottom: 10px;" class="btn btn-outline-primary btn-lg" href="edit-task.php?id=`+objEvent.projecttaskid+`">View</a> 
</div>

<div align="center">
<a style="width: 50%;" class="btn btn-outline-primary btn-lg" href="view-documents.php?task_id=`+objEvent.projecttaskid+`">Documents</a>
</div>

</div>
</div></div>`;


});
                }
                else
                {
                    cardHTML += `<font color="red">No Tasks found.</font>`;
                }

                cardHTML += `</div>`
                $('#view_tasks_wrapper').html( cardHTML );
            }
            
        }
    });
}    

jQuery(document).ready(function($){
    loadTasks();
});    


</script>
</body>
</html>