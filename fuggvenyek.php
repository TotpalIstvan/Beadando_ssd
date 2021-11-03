<?php

    $conn = new PDO("mysql:host=localhost;dbname=hattertarolok;charset=utf8;", 
    "root", "");
    $localhostKonyvar = explode("/", $_SERVER["PHP_SELF"]);
    $localhostKonyvar = isset($localhostKonyvar[1]) ? "/{$localhostKonyvar[1]}": "";
    $alapUrl = "http://" . $_SERVER["HTTP_HOST"] . $localhostKonyvar;

    function hattertarolok($conn) {
        $stmt = $conn->query("SELECT * FROM hattertarolok");
        $tarolok = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tarolok;
    }

    function tipusok($conn) {
        $tipusStmt = $conn->query("SELECT * FROM hattertarolo_tipusok");
        $tipusok = $tipusStmt->fetchAll(PDO::FETCH_ASSOC);
        return $tipusok;
    }

    function hattertarolo($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM hattertarolok WHERE HattertaroloID = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row !== false ? $row : [];
    }

    function torles($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM hattertarolok 
        WHERE HattertaroloID = ?");
        $stmt->execute([$id]);
    }

    function felvitel($conn, $adatok) {
        $hibak = "";
    
        $stmt = $conn->prepare("INSERT INTO hattertarolok 
        (HattertaroloTipus, Kapacitas, Melyseg, Magassag, Szelesseg, Marka, Tipus) 
        VALUES(?,?,?,?,?,?,?)");
    
        if($adatok["hattertaroloTipus"] == 0) {
            $hibak .= "<h3>Nem választottál ki háttértároló típust!</h3>";
        }
    
        if(empty($adatok["kapacitas"]) || $adatok["kapacitas"] == 0) {
            $hibak .= "<h3>A kapacitás mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["melyseg"]) || $adatok["melyseg"] == 0) {
            $hibak .= "<h3>A mélység mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["magassag"]) || $adatok["magassag"] == 0) {
            $hibak .= "<h3>A magasság mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["szelesseg"]) || $adatok["szelesseg"] == 0) {
            $hibak .= "<h3>A szélesség mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["marka"])) {
            $hibak .= "<h3>A márka mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["tipus"])) {
            $hibak .= "<h3>A típus mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($hibak)) {
            $stmt->execute([
                $adatok["hattertaroloTipus"],
                $adatok["kapacitas"],
                $adatok["melyseg"],
                $adatok["magassag"],
                $adatok["szelesseg"],
                $adatok["marka"],
                $adatok["tipus"]
            ]);

            return "";
        }

        return $hibak;
    }

    function feluliras($conn, $adatok) {
        $hibak = "";
    
        $stmt = $conn->prepare("UPDATE hattertarolok 
        SET HattertaroloTipus = ?, Kapacitas = ?, 
        Melyseg = ?, Magassag = ?, 
        Szelesseg = ?, Marka = ?, Tipus = ? 
        WHERE HattertaroloID = ?");
    
        if($adatok["hattertaroloTipus"] == 0) {
            $hibak .= "<h3>Nem választottál ki háttértároló típust!</h3>";
        }
    
        if(empty($adatok["kapacitas"]) || $adatok["kapacitas"] == 0) {
            $hibak .= "<h3>A kapacitás mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["melyseg"]) || $adatok["melyseg"] == 0) {
            $hibak .= "<h3>A mélység mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["magassag"]) || $adatok["magassag"] == 0) {
            $hibak .= "<h3>A magasság mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["szelesseg"]) || $adatok["szelesseg"] == 0) {
            $hibak .= "<h3>A szélesség mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["marka"])) {
            $hibak .= "<h3>A márka mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($adatok["tipus"])) {
            $hibak .= "<h3>A típus mező nincs megfelelően kitöltve!</h3>";
        }

        if(empty($hibak)) {
            $stmt->execute([
                $adatok["hattertaroloTipus"],
                $adatok["kapacitas"],
                $adatok["melyseg"],
                $adatok["magassag"],
                $adatok["szelesseg"],
                $adatok["marka"],
                $adatok["tipus"],
                $adatok["hattertaroloID"]
            ]);

            return "";
        }

        return $hibak;
    }

?>