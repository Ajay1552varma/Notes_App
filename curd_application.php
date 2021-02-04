<?php
$insert=false;
$update=false;
$delete=false;
$servername="localhost";
$username="root";
$password="";
$database="notes";

$con=mysqli_connect($servername,$username,$password,$database);
if(!$con){
    die("sorry we failed to connect:".mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $sno=$_GET['delete'];
  $delete=true;
$sql="DELETE FROM `notes` WHERE `serial`=$sno";
$result=mysqli_query($con,$sql);
}
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['snoedit']))
  {
     $sno=$_POST['snoedit'];
     $title=$_POST['titleedit'];
     $description=$_POST['descriptionedit'];
     $sql="UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`serial` = $sno";
     $result=mysqli_query($con,$sql);
     if($result){
       $update=true;
     }
  }
else{
$title=$_POST['title'];
$description=$_POST['description'];
$sql="INSERT INTO `notes` (`title`,`description`) VALUES ('$title','$description')";
$result=mysqli_query($con,$sql);
// Adding new table records in database.
if($result){
     echo "Record has been inserted succefully<br>";
    $insert=true;
}else{
    echo "Record not inserted succesfully...>".mysqli_error($conn);
}
}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    
    
    <title>virtual Note</title>
   
  </head>
  <body>
  <!-- edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit modal
</button> -->

<!--edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="curd_application.php" method="POST">
          <input type="hidden" name="snoedit" id="snoedit">
          <div class="mb-3">
            <label for="title" class="form-label">Note Title</label>
            <input name="titleedit" type="text" class="form-control" id="titleedit" aria-describedby="emailHelp">
            
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Note discription</label>
            <textarea class="form-control" name="descriptionedit" id="descriptionedit" cols="30" rows="2"></textarea>
          </div>
        
          <button type="submit" class="btn btn-primary">Update Note</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">iNote</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<?php
if($insert){
  echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong>your note has been added successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if($delete){
  echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong>your note has been deleted successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if($update){
  echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong>your note has been updated successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

<div class="container my-4">
<h2>Add Note</h2>
<form action="curd_application.php" method="POST">
  <div class="mb-3">
    <label for="title" class="form-label">Note Title</label>
    <input name="title" type="text" class="form-control" id="title" aria-describedby="emailHelp">
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Note discription</label>
    <textarea class="form-control" name="description" id="desc" cols="30" rows="2"></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Add Note</button>
</form>
</div>
<div class="container my-4">


<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">serial no</th>
      <th scope="col">Title</th>
      <th scope="col">Discription</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>

  <?php
$sql="SELECT * FROM `notes`";
$result=mysqli_query($con,$sql);
$num= mysqli_num_rows($result);
$sno=0;
if($num>0){
    while($row=mysqli_fetch_assoc($result)){
      $sno=$sno+1;
      echo"
      <tr>
        <th scope='row'>".$sno."</th>
        <td>".$row['title']."</td>
        <td>".$row['description']."</td>
        <td><button id=".$sno." class='edit btn btn-sm btn-primary'>Edit</button>  <button id=d".$sno." class='delete btn btn-sm btn-primary'>Delete</button> </td>
      </tr>";
     
    }
}

?>
 
  </tbody>
</table>
</div>
<hr>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
     } );
    </script>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
    <script>
      edits=document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
      element.addEventListener("click",(e)=>{
       console.log("edit",);
       tr= e.target.parentNode.parentNode;
       title=tr.getElementsByTagName("td")[0].innerText;
       description=tr.getElementsByTagName("td")[1].innerText;
       console.log(title,description);
       descriptionedit.value=description;
       titleedit.value=title;
       snoedit.value=e.target.id;
       console.log(e.target.id);
       $('#editModal').modal('toggle');
      })
      })
     
      deletes=document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
      element.addEventListener("click",(e)=>{
       console.log("edit",);
       tr= e.target.parentNode.parentNode;
       sno=e.target.id.substr(1,)

       if(confirm("press a button")){
         console.log("yes");
         window.location=`curd_application.php?delete=${sno}`;
       }
       else{
         console.log("no");
       }
      })
      })
      
      </script>
  </body>
</html>