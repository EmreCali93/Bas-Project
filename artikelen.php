<?php 

include 'conn.php';
include 'Config.php';

class Artikelen {
    private $conn;


    public function getArtikelen() {
        try {
            $query = "SELECT artid, artikelenomschrijving, artinkoop, artverkoop, artvoorraad, artminvoorraad, artmaxvoorraad, levid, artlocatie FROM artikelen";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            echo "Fout bij het ophalen van de artikelen: " . $e->getMessage();
            return [];
        }
    }

    public function insert($artid, $artikelenomschrijving, $artinkoop, $artverkoop, $artvoorraad, $artminvoorraad, $artmaxvoorraad, $artlocatie, $levid) {
        $errorFields = [];

        // Controleer op lege velden
        if (empty($artid)) {
            $errorFields[] = 'artid';
        }

        if (empty($artikelenomschrijving)) {
            $errorFields[] = 'artikelenomschrijving';
        }

        if (empty($artinkoop)) {
            $errorFields[] = 'artinkoop';
        }

        if (empty($artverkoop)) {
            $errorFields[] = 'artverkoop';
        }

        if (empty($artvoorraad)) {
            $errorFields[] = 'artvoorraad';
        }

        if (empty($artminvoorraad)) {
            $errorFields[] = 'artminvoorraad';
        }

        if (empty($artmaxvoorraad)) {
            $errorFields[] = 'artmaxvoorraad';
        }

        if (empty($artlocatie)) {
            $errorFields[] = 'artlocatie';
        }

        if (empty($levid)) {
            $errorFields[] = 'levid';
        }

        if (!empty($errorFields)) {
            echo "Fout: Alle velden moeten worden ingevuld. Ontbrekende velden: " . implode(', ', $errorFields);
            return;
        }

        // Controleer of numerieke waarden correct zijn
        if (!is_numeric($artid)) {
            $errorFields[] = 'artid';
        }

        if (!is_numeric($artinkoop)) {
            $errorFields[] = 'artinkoop';
        }

        if (!is_numeric($artverkoop)) {
            $errorFields[] = 'artverkoop';
        }

        if (!is_numeric($artvoorraad)) {
            $errorFields[] = 'artvoorraad';
        }

        if (!is_numeric($artminvoorraad)) {
            $errorFields[] = 'artminvoorraad';
        }

        if (!is_numeric($artmaxvoorraad)) {
            $errorFields[] = 'artmaxvoorraad';
        }

        if (!is_numeric($levid)) {
            $errorFields[] = 'levid';
        }

        if (!empty($errorFields)) {
            echo "Fout: Ongeldige numerieke waarden voor velden. Ongeldige velden: " . implode(', ', $errorFields);
            return;
        }
}
}

?>
