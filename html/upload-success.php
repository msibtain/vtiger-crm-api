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
                    <center><h2>Document Uploaded Successfully</h2></center>
                    <br/>
                    <a href="view-tasks.php"><button class="btn btn-lg btn-primary" style="width: 100%;">Back to tasks</button></a><br/><br/>
                    <a href="add-document.php?id=<?php echo $_GET['id'] ?>"><button class="btn btn-lg btn-success" style="width: 100%;">Add another file</button></a>
                </div>
            </div>
            

        </div>
        <div class="col-md-2"></div>
    </div>
</div>    

<?php include('footer.php'); ?>

</body>
</html>