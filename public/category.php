
<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

    <div class="container">
        <header class="jumbotron hero-spacer" style='background-color:#d0f2f2'>
        <div class="row">
            <div class="col-lg-8">
                <h1>Wellcome to Web Shop</h1>
                <p>"Vreme ide u jednom pravcu, secanje u drugom..."</p>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Date & Time</button>
            </div>
            <div class="col-lg-4"> 
                <img src="../resources/uploads/time2.jpg" style="height:200px;">
            </div>
        </div>
        </header>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Product</h3>
            </div>
        </div>
        <div class="row text-center">
            <?php get_products_in_cat_page(); ?>
        </div>
    </div>

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>



<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style='background-color:#1dc7de'>
          <h4 class="modal-title" >Uvek je pravo vreme za dobre odluke</h4>
        </div>
        <div class="modal-body">
          <p>Date: </p>
          <?php $date =  date("d-m-Y");  ?>
          <input type="text" id="naziv_partnera" name="naziv_partnera" value="<?php echo $date.' in London'; ?>" />
          <br/><br/>
          <p>Time: </p>
          <?php $time =  date("h:i");  ?>
          <input type="text" id="konto_partnera" name="konto_partnera" value="<?php echo $time.' in London'; ?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
        </div>
      </div>
    </div>
  </div>
