<?php include_once("./views/templates/document-start.php");?>
<div class="text center">
    <h1>Error 404</h1><br><br>
    <a class="btn btn-danger" href="<?php echo PATHSERVER; ?>">Return</a><br><br><br>
</div>

<?php echo var_dump($partesRuta);;
include_once("./views/templates/document-end.php");
?>