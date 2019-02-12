<?php  
if($_GET['form'] == "exc"){
    //export.php  
    require 'export-exc.php';
}else if($_GET['form'] == "pdf"){
    include_once("connection.php");
    require 'export-pdf.php';
}
?>
