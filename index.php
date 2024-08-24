<?php
    include('config/db_connect.php');
$sql='SELECT title, ingredients, id FROM pizzas';
$result= mysqli_query($conn, $sql);

//fetch the resulting rows as an array
$pizzas=mysqli_fetch_all($result,MYSQLI_ASSOC);

//freeing memory
mysqli_free_result($result);

// closing connection
mysqli_close($conn);

// print_r($pizzas);

// print_r(explode(',',$pizzas[0]['ingredients']));

//}

?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php include("templates/header.php"); ?>
    <h4 class="center grey-text">Pizzas!</h4>
    <div class="container">
        <div class="row">
            <?php foreach($pizzas as $pizza): ?>
                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                            <ul>
                                <?php foreach(explode(',',$pizzas[0]['ingredients']) as $ing) {?>
                                    <li><?php echo htmlspecialchars($ing) ?></li>
                                    <?php } ?>
                            </ul>
                        </div>
                        <div class="card-action right-align">
                            <a class="brand-text" href="details.php?id=<?php echo $pizza['id']?>">More Info</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?> 
        </div>
    </div>
    <?php include("templates/footer.php"); ?>
</body>
</html>