<?php
// auteur: Amin
// functie: algemene functies tbv hergebruik
 function ConnectDb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bieren";
   
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        echo "Connected successfully";
        return $conn;
    } 
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

 }

 
 
 function GetData($table){
    // Connect database
    $conn = ConnectDb();

    // Select data uit de opgegeven table methode query
    // query: is een prepare en execute in 1 zonder placeholders
    // $result = $conn->query("SELECT * FROM $table")->fetchAll();

    // Select data uit de opgegeven table methode prepare
    $query = $conn->prepare(" SELECT * FROM $table ");
    $query->execute();
    $result = $query->fetchAll();

    return $result;
 }

 function GetBier($brouwercode){
    // Connect database
    $conn = ConnectDb();

    // Select data uit de opgegeven table methode query
    // query: is een prepare en execute in 1 zonder placeholders
    // $result = $conn->query("SELECT * FROM $table")->fetchAll();

    // Select data uit de opgegeven table methode prepare
    $query = $conn->prepare("SELECT * FROM brouwer WHERE brouwercode = $brouwercode");
    $query->execute();
    $result = $query->fetch();

    return $result;
 }


 function OvzBieren(){

    // Haal alle bier record uit de tabel 
    $result = GetData("brouwer");
    
    //print table
    PrintTable($result);
    //PrintTableTest($result);
    
 }

 function OvzBrouwers(){
    // Haal alle bier record uit de tabel 
    $result = GetData("brouwer");
    
    //print table
    PrintTable($result);
     
 }

 function PrintTableTest($result){
    // Zet de hele table in een variable en print hem 1 keer 
    $table = "<table border = 1px>";
    // print elke rij
    foreach ($result as $row) {
        echo "<br> rij:";
        
        foreach ($row as  $value) {
            echo "kolom" . "$value";
        }          
        
    }
}

// Function 'PrintTable' print een HTML-table met data uit $result.
function PrintTable($result){
    // Zet de hele table in een variable en print hem 1 keer 
    $table = "<table border = 1px>";

    // Print header table

    // haal de kolommen uit de eerste [0] van het array $result mbv array_keys
    $headers = array_keys($result[0]);
    $table .= "<tr>";
    foreach($headers as $header){
        $table .= "<th bgcolor=gray>" . $header . "</th>";   
    }

    // print elke rij
    foreach ($result as $row) {
        
        $table .= "<tr>";
        // print elke kolom
        foreach ($row as $cell) {
            $table .= "<td>" . $cell . "</td>";
        }
        $table .= "</tr>";
    }
    $table.= "</table>";

    echo $table;
}


function CrudBrouwer(){

    // Haal alle bier record uit de tabel 
    $result = GetData("brouwer");
    
    //print table
    PrintCrudBrouwer($result);
    
 }
 function PrintCrudBrouwer($result){
    // Zet de hele table in een variable en print hem 1 keer 
    $table = "<table border = 1px>";

    // Print header table

    // haal de kolommen uit de eerste [0] van het array $result mbv array_keys
    $headers = array_keys($result[0]);
    $table .= "<tr>";
    foreach($headers as $header){
        $table .= "<th bgcolor=gray>" . $header . "</th>";   
    }

    // print elke rij
    foreach ($result as $row) {
        
        $table .= "<tr>";
        // print elke kolom
        foreach ($row as $cell) {
            $table .= "<td>" . $cell . "</td>";
        }
        //$table .= "</tr>";
        
        // Controleer of de array-sleutel "brouwercode" bestaat voordat deze wordt gebruikt
        if (isset($row["brouwcode"])) {
            // Wijzig knopje
            $table .= "<td>". 
                "<form method='post' action='update_bier.php?brouwcode=$row[brouwcode]' >       
                        <button name='wzg'>Wzg</button>	 
                </form>" . "</td>";

            // Delete via linkje href
            $table .= '<td><a href="delete_bier.php?brouwcode='.$row["brouwcode"].'">verwijder</a></td>';
        }
        
        $table .= "</tr>";
    }
    $table.= "</table>";

    echo $table;
}
function UpdateBier($row){
    echo "Update row<br>";

    try{
        // Connect database
        $conn = ConnectDb();

        // Update data uit de opgegeven table method prepare
        $sql = "UPDATE bier
        SET
             naam = '$row[naam]',
             soort = '$row[soort]',
             stijl = '$row[stijl]',
             alcohol = '$row[alcohol]',
             brouwcode = '$row[brouwcode]'
        WHERE brouwercode  = '$row[brouwercode]'";
       echo $sql;
       
       $query = $conn->prepare($sql);
       $query->execute();
    }
        catch(PDOExpection $e) {
            echo "Connection failed: " . $e ->getMessage();
        }

}

function DeleteBier($brouwercode){
    echo "Delete row<br>";

    try{
        // Connect database
        $conn = ConnectDb();

        // Delete row from table using prepared statement
        $sql = "DELETE FROM bier WHERE brouwercode = ?";
        $query = $conn->prepare($sql);
        $query->execute([$brouwercode]);
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function dropDown($label, $data){
    $txt = "
    <label for='$label'>Choose a $label:</label>
    <select name='$label' id='$label'>";
    foreach($data as $row){
        $txt .= "<option value='$row[brouwcode]'>$row[naam]</option>";
    }
    
    $txt .= "</select>";
    
    echo $txt;
}


?>