<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Edit Task</title>

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
                    <div class="row">
                        <div class="col-10"><h3>Edit Task</h3></div>
                        <div class="col-2"><a href="view-tasks.php" style="float:right; font-size: 17px;">Back</a></div>
                    </div>
                    <br>

                    <form id="frmAddTask">

                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" />
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">Type</label>
                            <select class="form-control" name="type" id="type">
                                <option value="administrative">administrative</option>
                                <option value="operative">operative</option>
                                <option value="other">other</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="Open">Open</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">Progress</label>
                            <select class="form-control" name="progress" id="progress">
                                <option value="10%">10%</option>
                                <option value="20%">20%</option>
                                <option value="30%">30%</option>
                                <option value="40%">40%</option>
                                <option value="50%">50%</option>
                                <option value="60%">60%</option>
                                <option value="70%">70%</option>
                                <option value="80%">80%</option>
                                <option value="90%">90%</option>
                                <option value="100%">100%</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date" />
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" />
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">Priority</label>
                            <select class="form-control" name="priority" id="priority">
                                <option value="normal">Normal</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        
                        <br>

                        <div class="form-group">
                            <label for="title">Task No</label>
                            <input type="text" class="form-control" name="task_no" id="task_no" />
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">Worked Hours</label>
                            <input type="number" class="form-control" name="worked_hours" id="worked_hours" />
                        </div>
                        
                        <br>

                        <div class="form-group">
                            <label for="title">Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>

                        <br><br>

                        <input type="hidden" name="projectid" value="4" />
                        <input type="hidden" name="assigned_to" value="1" />
                        <input type="hidden" name="created_by" value="1" />
                        <input type="hidden" name="task_id" value="<?php echo $_GET['id']; ?>" />
                        
                        <button type="submit" class="btn btn-primary">Submit</button> <br/><br/>
                        <a class="btn btn-outline-primary" href="add-document.php?task_id=<?php echo $_GET['id'] ?>">Upload Document</a>
                        <a class="btn btn-outline-success" href="view-documents.php?task_id=<?php echo $_GET['id'] ?>">View Documents</a>
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

    jQuery.ajax({
        type: 'POST',
        url: "https://crm.widdsigns.co.uk/api/gettask.php",
        data: {
            task_id: "<?php echo $_GET['id'] ?>"
        },
        success: function(response){

            if (response.success === "true")
            {
                $('#title').val( response.data.projecttaskname );
                $('#type').val( response.data.projecttasktype );
                $('#status').val( response.data.projecttaskstatus );
                $('#progress').val( response.data.projecttaskprogress );
                $('#start_date').val( response.data.startdate );
                $('#end_date').val( response.data.enddate );
                $('#priority').val( response.data.projecttaskpriority );
                $('#task_no').val( response.data.projecttasknumber );
                $('#worked_hours').val( response.data.projecttaskhours );
                $('#description').val( response.data.description );
            }
            
        }
    });

    

    jQuery('#frmAddTask').on('submit', function(event){
        event.preventDefault();
        const myFormData = new FormData(event.target);
        const formDataObj = {};
        myFormData.forEach((value, key) => (formDataObj[key] = value));
        console.log(formDataObj);
        

        jQuery.ajax({
            type: 'POST',
            url: "https://crm.widdsigns.co.uk/api/updatetask.php",
            data: formDataObj,
            success: function(response){
                console.log("in success");
                console.log( response );

                if (response.success === "true")
                {
                    toastr.success('Task has been updated.', 'Success!')
                }
                else
                {
                    toastr.error('Something went wrong.', 'Error!')
                }
            }
        });
        return false;
    });
});    
</script>
</body>
</html>