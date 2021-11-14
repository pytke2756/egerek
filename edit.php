<?php

require_once 'db.php';
require_once 'Eger.php';

$egerId = $_GET['id'] ?? null;

if ($egerId === null) {
    header('Location: index.php');
    exit();
}

$eger = Eger::getById($egerId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if ($ujNev === '') {
        $ujNev = $eger->getNev();
    }

    if ($ujGombokSzama === '') {
        $ujGombokSzama = $eger->getGombokSzama();
    }

    $ujEger = new Eger($ujNev, $ujSzin, $ujErzekelo, $ujGombokSzama, $ujBluetooth, $ujVezetekNelkuli, $ujUsbCsatlakozo, new DateTime());
    $ujEger->mentes((int)$egerId);
    header('Location: index.php');
    exit();
}

?><!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST">
        <div class="row">
            <div class="col-4">
                <label for="nev">Termék neve: <input type="text" name="nev" placeholder="<?php echo $eger->getNev();?>"></label>
            </div>
            <div class="col-4">
                <label for="gombok_szama">Gombok száma: <input type="number" name="gombok_szama" placeholder="<?php echo $eger->getGombokSzama();?>"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="szin">Szín: </label>
                <select name="szin">
                    <?php
                        var_dump($eger->getSzin());
                        switch ($eger->getSzin()) {
                            case 'fekete':
                                echo "<option value='fekete' selected='selected'>Fekete</option>
                                    <option value='piros'>Piros</option>
                                    <option value='zöld'>Zöld</option>
                                    <option value='kék'>Kék</option>";
                                break;
                            case 'piros':
                                echo "<option value='fekete'>Fekete</option>
                                    <option value='piros' selected='selected'>Piros</option>
                                    <option value='zöld'>Zöld</option>
                                    <option value='kék'>Kék</option>";
                                break;
                            case 'zöld':
                                echo "<option value='fekete'>Fekete</option>
                                    <option value='piros'>Piros</option>
                                    <option value='zöld' selected='selected'>Zöld</option>
                                    <option value='kék'>Kék</option>";
                                break;
                            case 'kék':
                                echo "<option value='fekete'>Fekete</option>
                                    <option value='piros'>Piros</option>
                                    <option value='zöld'>Zöld</option>
                                    <option value='kék' selected='selected'>Kék</option>";
                                break;
                        }
                    ?>
                </select>
            </div>
            <div class="col-4">
                <label for="erzekelo">Érzékelő tipusa: </label>
                <select name="erzekelo">
                    <?php
                        switch ($eger->getErzekelo()) {
                            case 'mechanikus':
                                echo "<option value='optikai'>Optikai</option>
                                        <option value='mechanikus' selected='selected'>Mechanikus</option>";
                                break;
                            case 'optikai':
                                echo "<option value='optikai' selected='selected'>Optikai</option>
                                    <option value='mechanikus'>Mechanikus</option>";
                            break;
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="bluetooth">
                    Bluetooth: 
                    <?php 
                    if ($eger->getBluetooth() === "igen") {
                        echo "<input type='checkbox' name='bluetooth' checked>";
                    }
                    else{
                        echo "<input type='checkbox' name='bluetooth'>";
                    }
                ?>
                </label>
            </div>
            <div class="col-4">
                <label for="vezetek_nelkuli">
                    Vezeték nélküli: 
                    <?php 
                    if ($eger->getVezetekNelkuli() === "igen") {
                        echo "<input type='checkbox' name='vezetek_nelkuli' checked>";
                    }
                    else{
                        echo "<input type='checkbox' name='vezetek_nelkuli'>";
                    }
                ?>
                </label>
            </div>
            <div class="col-4">
                <label for="usb_csatlakozo">
                    USB csatlakozó: 
                    <?php 
                    if ($eger->getUsbCsatlakozo() === "igen") {
                        echo "<input type='checkbox' name='usb_csatlakozo' checked>";
                    }
                    else{
                        echo "<input type='checkbox' name='usb_csatlakozo'>";
                    }
                ?>
                </label>
            </div>
        </div>
        <input type="submit" value="Felvesz">
    </form>
</body>
</html>