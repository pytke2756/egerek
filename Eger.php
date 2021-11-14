<?php

class Eger {
    private $id;
    private $nev;
    private $szin;
    private $erzekelo;
    private $gombokSzama;
    private $bluetooth;
    private $vezetekNelkuli;
    private $usbCsatlakozo;
    private $utoljaraVasaroltak;

    /**
     * Objektum létrehozása adattagok alapján.
     * ID-t itt nem adunk meg, azt az adatbázis tudja generálni!
     */
    public function __construct(string $nev, string $szin, string $erzekelo, int $gombokSzama, bool $bluetooth, bool $vezetekNelkuli, bool $usbCsatlakozo, DateTime $utoljaraVasaroltak) {
        $this->nev = $nev;
        $this->szin = $szin;
        $this->erzekelo = $erzekelo;
        $this->gombokSzama = $gombokSzama;
        $this->bluetooth = $bluetooth;
        $this->vezetekNelkuli = $vezetekNelkuli;
        $this->usbCsatlakozo = $usbCsatlakozo;
        $this->utoljaraVasaroltak = $utoljaraVasaroltak;
    }
    public function getId() : int {
        return $this->id;
    }


    public function getNev() : string {
        return $this->nev;
    }

    public function getSzin() : string {
        return $this->szin;
    }

    public function getErzekelo() : string {
        return $this->erzekelo;
    }

    public function getGombokSzama() : int {
        return $this->gombokSzama;
    }

    public function getBluetooth() : string {
        $isBluetooth = $this->bluetooth ? 'igen' : 'nem';
        return $isBluetooth;
    }
    
    public function getVezetekNelkuli() : string {
        $isVezetekNelkuli = $this->vezetekNelkuli ? 'igen' : 'nem';
        return $isVezetekNelkuli;
    }

    public function getUsbCsatlakozo() : string {
        $isUsbCsatlakozo = $this->usbCsatlakozo ? 'igen' : 'nem';
        return $isUsbCsatlakozo;
    }

    public function getUtoljaraVasaroltak() : DateTime{
        return $this->utoljaraVasaroltak;
    }

    public static function getById(int $id) : Eger {
        global $db;

        $stmt = $db->prepare('SELECT * FROM egerek WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $eredmeny = $stmt->fetchAll();

        if (count($eredmeny) !== 1) {
            throw new Exception('A DB lekerdezes nem egy sort adott vissza');
        }

        $eger = new Eger($eredmeny[0]['nev'], $eredmeny[0]['szin'] ,$eredmeny[0]['erzekelo'], $eredmeny[0]['gombok_szama'],
                        $eredmeny[0]['bluetooth'], $eredmeny[0]['vezetek_nelkuli'], $eredmeny[0]['usb_csatlakozo'],
                        new DateTime($eredmeny[0]['utoljara_vasaroltak']));

            
        $eger->id = $eredmeny[0]['id'];
        return $eger;
    }

    public static function osszes() : array {
        global $db;

        $t = $db->query("SELECT * FROM egerek ORDER BY id DESC")
        ->fetchAll();
        $eredmeny = [];

        foreach ($t as $elem) {
            $eger = new Eger($elem['nev'], $elem['szin'] ,$elem['erzekelo'], $elem['gombok_szama'],
                                $elem['bluetooth'], $elem['vezetek_nelkuli'], $elem['usb_csatlakozo'],
                                new DateTime($elem['utoljara_vasaroltak']));
            $eger->id = $elem['id'];
            $eredmeny[] = $eger;
        }

        return $eredmeny;
    }

    public function uj() {
        global $db;
        $felBlue = $this->bluetooth ? 1 : 0;
        $felVez = $this->vezetekNelkuli ? 1 : 0;
        $felUsb = $this->usbCsatlakozo ? 1 : 0;

        $db->prepare('INSERT INTO egerek (nev, szin, erzekelo, gombok_szama, bluetooth, vezetek_nelkuli, usb_csatlakozo, utoljara_vasaroltak)
                    VALUES (:nev, :szin, :erzekelo, :gombok_szama, :bluetooth, :vezetek_nelkuli, :usb_csatlakozo, :utoljara_vasaroltak)')
            ->execute([
                ':nev' => $this->nev,
                ':szin' => $this->szin,
                ':erzekelo' => $this->erzekelo,
                ':gombok_szama' => $this->gombokSzama,
                ':bluetooth' => $felBlue,
                ':vezetek_nelkuli' => $felVez,
                ':usb_csatlakozo' => $felUsb,
                ':utoljara_vasaroltak' => $this->utoljaraVasaroltak->format('Y:m:d')
            ]);
    }

    public static function torol(int $id) {
        global $db;

        $db->prepare('DELETE FROM egerek WHERE id = :id')
            ->execute([':id' => $id]);
    }

    public function mentes(int $idBe) {
        global $db;
        $updateBlue = $this->bluetooth ? 1 : 0;
        $updateVez = $this->vezetekNelkuli ? 1 : 0;
        $updateUsb = $this->usbCsatlakozo ? 1 : 0;

        // Paraméteres lekérdezéskor a ->prepare fv-t kell használni!
        $db->prepare('UPDATE egerek SET nev = :nev, szin = :szin, erzekelo = :erzekelo, gombok_szama = :gombok_szama, bluetooth = :bluetooth, vezetek_nelkuli = :vezetek_nelkuli, usb_csatlakozo = :usb_csatlakozo, utoljara_vasaroltak = :utoljara_vasaroltak
            WHERE id = :id')
            ->execute([
                ':nev' => $this->nev,
                ':szin' => $this->szin,
                ':erzekelo' => $this->erzekelo,
                ':gombok_szama' => $this->gombokSzama,
                ':bluetooth' => $updateBlue,
                ':vezetek_nelkuli' => $updateVez,
                ':usb_csatlakozo' => $updateUsb,
                ':utoljara_vasaroltak' => $this->utoljaraVasaroltak->format('Y:m:d'),
                ':id' => $idBe
            ]);
    }
}