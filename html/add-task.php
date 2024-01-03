<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Add Task</title>

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
                    <h3>Add Task</h3>
                    <br>

                    <form id="frmAddTask">

                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" />
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">Type</label>
                            <select class="form-control" name="type">
                                <option value="administrative">administrative</option>
                                <option value="operative">operative</option>
                                <option value="other">other</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">Status</label>
                            <select class="form-control" name="status">
                                <option value="Open">Open</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="title">Progress</label>
                            <select class="form-control" name="progress">
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
                            <select class="form-control" name="priority">
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
                        <input type="hidden" name="created_by" id="created_by"  />
                        
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

    $('#created_by').val( getCookie('vtiger_user') );

    jQuery('#frmAddTask').on('submit', function(event){
        event.preventDefault();
        const myFormData = new FormData(event.target);
        const formDataObj = {};
        myFormData.forEach((value, key) => (formDataObj[key] = value));
        console.log(formDataObj);
        

        jQuery.ajax({
            type: 'POST',
            url: "https://tfkgdemo.com/vtiger-crm/api/addtask",
            data: formDataObj,
            success: function(response){
                console.log("in success");
                console.log( response );

                if (response.success === "true")
                {
                    toastr.success('Task has been added.', 'Success!')
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