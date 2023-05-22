<?php
    echo "<h1>Delete Bier</h1>";
    require_once('functions_bieren.php');

    // Test of er op de verwijder-knop is gedrukt 
    if(isset($_POST) && isset($_POST['btn_verw'])){
        DeleteBier($_POST['biercode']);
        echo "De rij met biercode " . $_POST['biercode'] . " is verwijderd.";
    }

    if(isset($_GET['biercode'])){
        echo "verwijderen<br>";
        // Haal alle info van de betreffende biercode $_GET['biercode']
        $biercode = $_GET['biercode'];
        $row = GetBier($biercode);
        echo "Biercode: " . $row['biercode'] . "<br>";
        echo "Naam: " . $row['naam'] . "<br>";
        echo "Soort: " . $row['soort'] . "<br>";
        echo "Stijl: " . $row['stijl'] . "<br>";
        echo "Alcohol: " . $row['alcohol'] . "<br>";
        echo "Brouwcode: " . $row['brouwcode'] . "<br>";
    }
?>

<form action="" method="POST">
    <input type="hidden" name="biercode" value="<?php echo $row['biercode']; ?>">
    <input type="submit" name="btn_verw" value="Verwijder">
</form>

