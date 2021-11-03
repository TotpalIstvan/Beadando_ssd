<?php

    $hibak = "";

    require_once "fuggvenyek.php";
    $id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? (int)$_GET["id"] : 0;

    if(isset($_POST["modositas"])) {
        $hibak = feluliras($conn, $_POST);
    }


    $tipusok = tipusok($conn);
    $adatok = hattertarolo($conn, $id);

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="tartalom">
        <?php if(!empty($hibak)): ?>
            <form method="POST" class="hiba-megjelenito">
                <?=$hibak?>
                <button>OK!</button>
            </form>
        <?php endif; ?>

        <a href="<?=$alapUrl?>">Vissza az előző oldalra</a>

        <form method="POST" class="szoveg-kozepre">
            <h3>Háttértároló típus</h3>
            <select name="hattertaroloTipus">
                <option value="0">Válassz típust!</option>
                <?php foreach($tipusok as $tipus): ?>
                    <option <?=isset($adatok["HattertaroloTipus"]) 
                    && $adatok["HattertaroloTipus"] == $tipus["TipusID"] ? "selected" : ""?>
                    value="<?=$tipus["TipusID"]?>"><?=$tipus["TipusNev"]?></option>
                <?php endforeach; ?>
            </select>

            <h3>Kapacitas</h3>
            <input type="number" name="kapacitas" 
            value="<?=isset($adatok["Kapacitas"]) ? $adatok["Kapacitas"] : ""?>"
            placeholder="kapacitás">

            <h3>Mélység</h3>
            <input type="number" name="melyseg" 
            value="<?=isset($adatok["Melyseg"]) ? $adatok["Melyseg"] : ""?>"
            placeholder="mélység">

            <h3>Magasság</h3>
            <input type="number" name="magassag" 
            value="<?=isset($adatok["Magassag"]) ? $adatok["Magassag"] : ""?>"
            placeholder="magasság">

            <h3>Szélesség</h3>
            <input type="number" name="szelesseg" 
            value="<?=isset($adatok["Szelesseg"]) ? $adatok["Szelesseg"] : ""?>"
            placeholder="szélesség">

            <h3>Márka</h3>
            <input type="text" name="marka" 
            value="<?=isset($adatok["Marka"]) ? $adatok["Marka"] : ""?>"
            placeholder="márka">

            <h3>Típus</h3>
            <input type="text" name="tipus"
            value="<?=isset($adatok["Tipus"]) ? $adatok["Tipus"] : ""?>" 
            placeholder="típus">

            <input type="hidden" name="hattertaroloID" value="<?=$id?>">

            <button name="modositas">Módosítás!</button>
        </form>
    </div>
</body>
</html>