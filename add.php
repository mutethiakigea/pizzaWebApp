<?php
include('config/db_connect.php');

$email = $title = $ingredients = '';
$errors = array('email'=>'','title'=>'', 'ingredients'=>'');

if(isset($_POST['submit'])){
   // echo htmlspecialchars($_POST['email']);
   // echo htmlspecialchars($_POST['title']);
   // echo htmlspecialchars($_POST['ingredients']);

   if(empty($_POST['email'])){
    $errors['email']= '* An email is required <br />';
   }else{
    $email = $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email']='Email must be a valid email address';
    }
   }
    if(empty($_POST['title'])){
        $errors['title'] = '* An title is required <br />';
    }else{
    $title = $_POST['title'];
    if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
        $errors['title'] = 'Title must be letters and Spaces alone';
    }
    }

    if(empty($_POST['ingredients'])){
        $errors['ingredients'] = '* Atleast one ingredient is required <br />';
    }else{
        $ingredients = $_POST['ingredients'];
        if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
            $errors['ingredients'] =  'ingredient must be CSV';
    }
}
if(array_filter($errors)){
    //echo 'errors in the form';
    }else{
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $title=mysqli_real_escape_string($conn,$_POST['title']);
        $ingredients=mysqli_real_escape_string($conn,$_POST['ingredients']);
        
        //create sql
        $sql="INSERT INTO pizzas(title, email, ingredients)VALUES('$title','$email','$ingredients')";

        //save to db and check
        if(mysqli_query($conn, $sql)){
            //success
            // echo 'form is valid';
            header('location: index.php');
        }else{
            //error
            echo 'query error: '. mysqli_error($conn);
        }
    }

} // end of POST check


?>


<!DOCTYPE html>
<html lang="en">
<body>
    <?php include("templates/header.php"); ?>
    <section class = "container grey-text">
        <h4 class="center">Add a Pizza</h4>
        <form class = "white" action = "add.php" method = "POST">
            <label>Your Email</label>
            <div class="red-text"><?php echo $errors['email']?></div>
            <input type = "text" name = "email" value ="<?php echo htmlspecialchars($email) ?>">
            <label>Pizza Title</label>
            <div class="red-text"><?php echo $errors['title']?></div>
            <input type = "text" name = "title" value ="<?php echo htmlspecialchars($title) ?>">
            <label>Ingredients (comma separated)</label>
            <div class="red-text"><?php echo $errors['ingredients']?></div>
            <input type = "text" name = "ingredients" value ="<?php echo htmlspecialchars($ingredients) ?>">
            <div class = "center">
                <input type = "submit" name = "submit" class = "btn brand z-depth-0">
            </div>
        </form>
    </section>
    <?php include("templates/footer.php"); ?>
</body>
</html>