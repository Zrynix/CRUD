<?php
    echo "<h1>Insert Bier</h1>";
    require_once('functions_bieren.php');

    // Test of er op de insert-knop is gedrukt 
    if(isset($_POST) && isset($_POST['btn_ins'])){
        InsertBier($_POST);
    }
?>

<html>
    <body>
        <form method="post">
        <br>
        Biercode:<input type="" name="biercode"><br>
        Naam:<input type="" name="naam"><br> 
        Soort: <input type="text" name="soort"><br>
        Stijl: <input type="text" name="stijl"><br>
        Alcohol: <input type="text" name="alcohol"><br>
        Brouwcode: <input type="text" name="brouwcode"><br>
        <input type="submit" name="btn_ins" value="Insert"><br>
        </form>
    </body>
</html>
