<?php

    require_once 'db.php';
    require_once 'Eger.php';

    $nevHiba = false;
    $nevHibaUzenet = "";

    $szinHiba = false;
    $szinHibaUzenet = "";

    $erzekeloHiba = false;
    $erzekeloHibaUzenet = "";

    $gombokSzamaHiba = false;
    $gombokSzamaHibaUzenet = "";

    $isValid = false;
    $isValidMessage = "";


 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Az ilyen jellegű eldöntés, hogy új vagy töröl, nem elegáns, nagyon sok
    // if/elseif/... ág készülhet összetett program esetén.

    $deleteId = $_POST['deleteId'] ?? '';
    if ($deleteId !== '') {
        Eger::torol($deleteId);
    }
    else{
        $ujNev = $_POST['nev'] ?? '';
        $ujSzin = $_POST['szin'] ?? '';
        $ujErzekelo = $_POST['erzekelo'] ?? '';
        $ujGombokSzama = $_POST['gombok_szama'] ?? '';
        $ujBluetooth = $_POST['bluetooth']  ?? '';
        $ujVezetekNelkuli = $_POST['vezetek_nelkuli'] ?? '';
        $ujUsbCsatlakozo = $_POST['usb_csatlakozo'] ?? '';

        $ujBluetooth = $ujBluetooth ? true : false;
        $ujVezetekNelkuli = $ujVezetekNelkuli ? true : false;
        $ujUsbCsatlakozo = $ujUsbCsatlakozo ? true : false;

        if (empty($ujNev)) {
            $nevHiba = true;
            $nevHibaUzenet = "Kötelező megadni nevet!";
        }

        if (empty($ujSzin)) {
            $szinHiba = true;
            $szinHibaUzenet = "Kötelező megadni a színt!";
        }

        if (empty($ujErzekelo)) {
            $erzekeloHiba = true;
            $erzekeloHibaUzenet = "Kötelező megadni az érzékelő típusát!";
        }

        if ($ujGombokSzama < 3) {
            $gombokSzamaHiba = true;
            $gombokSzamaHibaUzenet = "A gombok száma minmum 3-nak kell lennie!";
        }

        if (!$nevHiba && !$szinHiba && !$erzekeloHiba && !$gombokSzamaHiba ) {
            $isValid = true;
            $isValidMessage = "Sikeres hozzáadás!";
            $ujEger = new Eger($ujNev, $ujSzin, $ujErzekelo, $ujGombokSzama, $ujBluetooth, $ujVezetekNelkuli, $ujUsbCsatlakozo, new DateTime());
            $ujEger->uj();
        }
    }
}
    $egerek = Eger::osszes();


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Egerek</title>
</head>
<body>
    <div class="container">
        <div class="pb-2">
            <form method="POST" onsubmit="return valid()" name="eger_adatok">
                <div class="row">
                    <div class="col-4">
                        <label for="nev">Termék neve: <input type="text" name="nev" required></label>
                        <div class="hiba_uzenet"><?php if (!$isValid) { echo $nevHibaUzenet ;}?></div>
                    </div>
                    <div class="col-4">
                        <label for="gombok_szama">Gombok száma: <input type="number" name="gombok_szama"></label>
                        <div class="hiba_uzenet"><?php if (!$isValid) { echo $gombokSzamaHibaUzenet ;}?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="szin">Szín: </label>
                        <select name="szin">
                            <option value="fekete">Fekete</option>
                            <option value="piros">Piros</option>
                            <option value="zöld">Zöld</option>
                            <option value="kék">Kék</option>
                        </select>
                        <div class="hiba_uzenet"><?php if (!$isValid) { echo $szinHibaUzenet ;}?></div>
                    </div>
                    <div class="col-4">
                        <label for="erzekelo">Érzékelő tipusa: </label>
                        <select name="erzekelo">
                            <option value="optikai">Optikai</option>
                            <option value="mechanikus">Mechanikus</option>
                        </select>
                        <div class="hiba_uzenet"><?php if (!$isValid) { echo $erzekeloHibaUzenet ;}?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="bluetooth">Bluetooth: <input type="checkbox" name="bluetooth"></label>
                    </div>
                    <div class="col-4">
                        <label for="vezetek_nelkuli">Vezeték nélküli: <input type="checkbox" name="vezetek_nelkuli">  </label>
                    </div>
                    <div class="col-4">
                        <label for="usb_csatlakozo">USB csatlakozó: <input type="checkbox" name="usb_csatlakozo"></label>
                    </div>
                </div>
                
                <input type="submit" value="Felvesz">
            </form>
            <?php if ($isValid) {
                echo "<div id='sikeres_validacio'>Sikeres</div>";
            }?>
        </div>
        <div class="row">
            <?php
                foreach ($egerek as $eger) {
                    echo "<div class='col-sm-12 col-md-6 pb-2'><div class='card'>";
                    echo "<h2 class='card-header'>" . $eger->getNev() . "</h2>";
                    echo "<div class='card-body'>";
                    echo "<ul class='list-group list-group-flush'>
                                <li class='list-group-item'>Szín: " . $eger->getSzin() . "</li>
                                <li class='list-group-item'>Érzékelő: " . $eger->getErzekelo() . "</li>
                                <li class='list-group-item'>Gombok száma: " . $eger->getGombokSzama() . "db</li>
                                <li class='list-group-item'>Bluetooth: " . $eger->getBluetooth() . "</li>
                                <li class='list-group-item'>Vezeték nélküli: " . $eger->getVezetekNelkuli() . "</li>
                                <li class='list-group-item'>USB csatlakozó: " . $eger->getUsbCsatlakozo() . "</li>
                            </ul>";
                    echo "</div>";
                    echo "<div class='card-footer'><div class='col-12'>Utolsó vásárlás ideje: " . $eger->getUtoljaraVasaroltak()->format('Y.m.d') . "</div>
                            <div class='row'>
                                <div class='col-6'>
                                    <form method='POST'>
                                        <input type='hidden' name='deleteId' value='" . $eger->getId() . "'>
                                        <button type='submit'>Törlés</button>
                                    </form>
                                </div>
                                <div class='col-6'>
                                    <a href='edit.php?id=" . $eger->getId() . "'>Szerkeszt</a>
                                </div>
                            </div>
                            </div>";
                    echo "</div></div>";
                    }
            ?>
        </div>
    </div>
    <script>
        function valid() {
            let nev = document.forms["eger_adatok"]["nev"].value;
            let szin = document.forms["eger_adatok"]["szin"].value;
            let erzekelo = document.forms["eger_adatok"]["erzekelo"].value;
            let gombokSzama = document.forms["eger_adatok"]["gombok_szama"].value;

            if (nev == "") {
                alert("A név nem lehet üres!")
                return false;
            }
            if (szin == "") {
                alert("Kötelező színt választani!")
                return false;
            }
            if (erzekelo == "") {
                alert("Kötelező az érzékelő típusát kiválasztani!")
                return false;
            }
            if (parseInt(gombokSzama) < 3 || gombokSzama == "") {
                alert("A gombok száma nem lehet 3-nál kisebb")
                return false;
            }   
        }
    </script>
</body>
</html>