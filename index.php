<?php
function hattertarolok($conn) {
        $tipusStmt = $conn->query("SELECT * FROM hattertarolok");
        $tipusok = $tipusStmt->fetchAll(PDO::FETCH_ASSOC);
        return $tipusok;
    }

    function tipusok($conn) {
        $tipusStmt = $conn->query("SELECT * FROM hattertarolo_tipusok");
        $tipusok = $tipusStmt->fetchAll(PDO::FETCH_ASSOC);
        return $tipusok;
    }

    function torles($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM hattertarolok 
        WHERE HattertaroloID = ?");
        $stmt->execute([$id]);
    }

    $conn = new PDO("mysql:host=localhost;dbname=hattertarolok;charset=utf8;", 
    "root", "");

    if(isset($_POST["felvitel"])) {
        $hibak = "";

        $stmt = $conn->prepare("INSERT INTO hattertarolok 
        (HattertaroloTipus, Kapacitas, Melyseg, Magassag, Szelesseg, Marka, Tipus) 
        VALUES(?,?,?,?,?,?,?)");

        if($_POST["hattertaroloTipus"] == 0) {
            $hibak .= "<h3>Nem választottál ki háttértároló típust!</h3>";
        }

        if(empty($_POST["kapacitas"]) || $_POST["kapacitas"] == 0) {
            $hibak .= "<h3>A kapacitás mező nincs megfelelően kitöltve!</h3>";
        }

        $stmt->execute([
            $_POST["hattertaroloTipus"],
            $_POST["kapacitas"],
            $_POST["melyseg"],
            $_POST["magassag"],
            $_POST["szelesseg"],
            $_POST["marka"],
            $_POST["tipus"]
        ]);
    }

    if(isset($_POST["termekid"])) {
        torles($conn, $_POST["termekid"]);
    }

    $adatok = hattertarolok($conn);
    $tipusok = tipusok($conn);

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <div class="tartalom container-fluid">
        <form method="POST">
            <h3>Háttértároló típus</h3>
            <select name="hattertaroloTipus">
                <option value="0">Válassz típust!</option>
                <?php foreach($tipusok as $tipus): ?>
                    <option value="<?=$tipus["TipusID"]?>"><?=$tipus["TipusNev"]?></option>
                <?php endforeach; ?>
            </select>

            <h3>Kapacitas</h3>
            <input type="number" name="kapacitas" placeholder="kapacitás">

            <h3>Mélység</h3>
            <input type="number" name="melyseg" placeholder="mélység">

            <h3>Magasság</h3>
            <input type="number" name="magassag" placeholder="magasság">

            <h3>Szélesség</h3>
            <input type="number" name="szelesseg" placeholder="szélesség">

            <h3>Márka</h3>
            <input type="text" name="marka" placeholder="márka">

            <h3>Típus</h3>
            <input type="text" name="tipus" placeholder="típus">

            <button name="felvitel">Felvitel!</button>
        </form>

        <div class="grid-4">
            <?php foreach($adatok as $adat): ?>
                <div class="box">
                    <h3>Háttértároló márkája</h3>
                    <h4><?=$adat["Marka"]?></h4>
                    <h3>Háttértároló típusa</h3>
                    <h4><?=$adat["Tipus"]?></h4>
                    <h3>Kapacitás</h3>
                    <h4><?=$adat["Kapacitas"]?></h4>
                    <form method="POST">
                        <button name="termekid" value="<?=$adat["HattertaroloID"]?>">Törlés!</button>
                    </form>

                    <a href="http://localhost/Beadandok_ssd/szerkesztes.php?id=<?=$adat["HattertaroloID"]?>">megnyitás</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

