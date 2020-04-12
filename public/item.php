
<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<div class="container">

<?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>

<?php 
    $query = query(" SELECT * FROM products WHERE product_id = " . escape_string($_GET['id']) . " ");
    confirm($query);
    // pocetak while     
    while($row = fetch_array($query)) :
?>
        
<?php add_reviews(); ?>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-7">
               <img class="img-responsive" style="height:230px;" src="../resources/uploads/<?php echo $row['product_image']; ?>"  alt="">
            </div>

            <div class="col-md-5">
                <div class="thumbnail">
                    <div class="caption-full">
                        <h4><a href="#"><?php echo $row['product_title']; ?></a></h4>
                        <hr>
                        <h4 class="">
                            <?php 
                                $prod_price = $row['product_price'];
                                echo number_format($prod_price,2,",",".").' RSD'; 
                            ?>
                        </h4>

                        <?php avg_star();?> 

                        <p><?php echo $row['short_desc']; ?></p>

                        <form action="">
                            <div class="form-group">
                                <a href="../resources/cart.php?add=<?php echo $row['product_id']; ?>" class="btn btn-primary">ADD</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <hr>

    <div class="row">
        <div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <p></p>
                    <p><?php echo $row['product_description']; ?></p>
                </div>

                <div role="tabpanel" class="tab-pane" id="profile">
                    <div class="col-md-6">
                        <h3>Reviews</h3>

                        <hr>

                <?php show_reviews(); ?>
    </div>

    <div class="col-md-6">
        <h3>Add A review</h3>
            <form action="" class="form-inline" method="POST">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="review_name" class="form-control" >
                </div>
                <br><br>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="test" name="review_email" class="form-control">
                </div>
                <div>
                    <h3>Your Rating</h3>
                        <table>
                            <tr>
                                <td>
                                    <input type="radio" name="raiting" value="5">
                                    <label style="color:blue" for="5" title="Excellent">&nbsp;Excellent</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" name="raiting" value="4">
                                    <label style="color:purple" for="4" title="Very Good">&nbsp;Fantastic</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" name="raiting" value="3">
                                    <label style="color:green" for="3" title="Average">&nbsp;Very Good</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" name="raiting" value="2">
                                    <label style="color:orange" for="2" title="Poor">&nbsp;Good</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" name="raiting" value="1">
                                    <label style="color:red" for="1" title="Terrible">&nbsp;Interisting</label>
                                </td>
                            </tr>
                        </table>
                </div>
                <br>             
                <div class="form-group">
                    <textarea name="review_text" id="" cols="50" rows="10" class="form-control"></textarea>
                </div>
                    <br><br>
                <div class="form-group">
                    <input type="submit" name="add_review" class="btn btn-primary" value="SUBMIT">
                </div>
            </form>
    </div>

</div>

</div>

</div>

</div>

</div>

    <?php 
        endwhile; // kraj while 
    ?>

</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
