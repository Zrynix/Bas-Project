<!--
    Auteur: Amin
    Functie: home page CRUD InkoopOrder
-->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InkoopOrder</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>InkoopOrder</h1>
    <nav>
        <a class="tvgklant" href='../index.html'>Home</a><br>
        <a class="tvgklant" href='insert.php'>Toevoegen inkoop order</a><br>
    </nav>
    
<?php

// Autoloader classes via composer
require '../../vendor/autoload.php';

use Bas\classes\InkoopOrder;

// Maak een object InkoopOrder
$inkoopOrder = new InkoopOrder;

// Start CRUD
$inkoopOrder->crudInkoopOrder();

?>
</body>
</html>
