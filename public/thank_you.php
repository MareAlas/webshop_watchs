
<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<?php 
/*
// prebacio u cart.php u funkciju report()
  if(isset($_GET['tx']))
  {
    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $transaction = $_GET['tx'];
    $status = $_GET['st'];
    //  za test -  http://localhost/ecom/public/thank_you.php?tx=3517888&amt=350&cc=USA&st=Completed
    $query = query("INSERT INTO orders (order_amount, order_transaction, order_status, order_currency)
                        VALUES ('{$amount}', '{$transaction}', '{$status}', '{$currency}')");
    confirm($query);
    report();
    // session_destroy();
  }
  else 
  {
    redirect("index.php");
  }
*/

  process_transaction();

?>
    <div class="container">
      <h1 class="text-center">THANK YOU</h1>
    </div>

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
