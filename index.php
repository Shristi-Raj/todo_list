<?php

define("DB_HOST", "localhost:8111");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "todo_list");

$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// you could test connection eventually using a if and else conditional statement, 
// feel free to take out the code below once you see Connected!
/*if ($db) {
  echo "Connected!";
} else {
  echo "Connection Failed";
}*/

if($db->connect_errno){
    die('connection to mysqli failed : '.$db->connect_error);
  }

  //Creating a todo item
  if(isset($_POST['add'])){
    $item=$_POST['item'];
    
    if(!empty($item)){
        
        $query = "INSERT INTO todo (name) VALUES ('$item')";
        if(mysqli_query($db,$query)){
            echo'
            <center>
            <div class="alert alert-success" role="alert">
              Item added Successfully!
            </div>
            </center>
            ';
        }
        else{
            echo mysqli_error($db);
        }
    }
  }

    //Check if action parameter is present
    if(isset($_GET['action'])){
        $itemId=$_GET['item'];
        
        if($_GET['action']== 'done'){
            
            $query = "UPDATE todo SET status = 1 WHERE id = '$itemId'";
            if(mysqli_query($db,$query)){
                echo'
                <center>
                <div class="alert alert-info" role="alert">
                Item Marked as Done!
                </div>
                </center>
                ';
            }
            else{
                echo mysqli_error($db);
            }
        }
        elseif($_GET['action']== 'delete'){
            $query= "DELETE FROM todo WHERE id = '$itemId'";
            if(mysqli_query($db,$query)){
                echo'
                <center>
                <div class="alert alert-danger" role="alert">
                Item Deleted Successfully!
                </div>
                </center>
                ';
            }
            else{
                echo mysqli_error($db);
            }
        }
      }




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo-List app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .done{
            text-decoration: line-through;
        }
    </style>
</head>
<body>
    <main>
        <div class="container pt-5">
            <div class="row">
                <div class="col-sm-12 col-md-3"> </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <p>Todo List</p>
                            </div>
                            <div class="card-body">
                                <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="item" placeholder="Add a Todo Item">
                                    </div>
                                    <input type="submit" class="btn btn-dark" name="add" value="Add Item">
                                    </form>
                                    <div class="mt-5 mb-5">

                                        <?php
                                         $query = "SELECT * FROM todo";
                                         $result = mysqli_query($db,$query);
                                         if($result->num_rows >0){
                                            $i=1;
                                            while($row = $result->fetch_assoc()){
                                                $done = $row['status']==1? "done":"";
                                            echo'
                                            <div class="row mt-4">
                                            <div class="col-sm-12 col-md-1"><h5>'.$i.'</h5></div>
                                            <div class="col-sm-12 col-md-6"><h5 class="'.$done.'">'.$row['name'].'</h5></div>
                                            <div class="col-sm-12 col-md-5">
                                                <a href="?action=done&item='.$row['id'].'" class="btn btn-outline-dark">Mark as Done</a>
                                                <a href="?action=delete&item='.$row['id'].'" class="btn btn-outline-danger">Delete</a>
                                            </div>
                                            </div>
                                        ';
                                        $i++;
                                         }
                                        }
                                         else{
                                            echo'
                                                <center>
                                                    <img src="folder.png" width="50px" alt="Empty list"><br><span>Your List is Empty</span>
                                                </center>
                                            ';
                                         }
                                        ?>

                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 

<!--jquery code -->
<script>
    $(document).ready(function(){
        $(".alert").fadeTo(1000,500).slideUp(500,function(){
            $('.alert').slideUp(500);
        });
    })
</script>
</body>
</html>