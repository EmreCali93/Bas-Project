<?php

class Verkooporder extends Config {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertVerkooporder($verkordid, $artid, $klantid, $verkorddatum, $verkordbestaantal, $verkordstatus) {
        $sql = "INSERT INTO verkooporders (verkordid, artid, klantid, verkorddatum, verkordbestaantal, verkordstatus)
                VALUES (:verkordid, :artid, :klantid, :verkorddatum, :verkordbestaantal, :verkordstatus)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':verkordid', $verkordid);
        $stmt->bindParam(':artid', $artid);
        $stmt->bindParam(':klantid', $klantid);
        $stmt->bindParam(':verkorddatum', $verkorddatum);
        $stmt->bindParam(':verkordbestaantal', $verkordbestaantal);
        $stmt->bindParam(':verkordstatus', $verkordstatus);

        $stmt->execute();
    }

    public function updateVerkooporder($verkordid, $artid, $klantid, $verkorddatum, $verkordbestaantal, $verkordstatus) {
        $sql = "UPDATE verkooporders SET artid = :artid, klantid = :klantid, verkorddatum = :verkorddatum, verkordbestaantal = :verkordbestaantal, verkordstatus = :verkordstatus
                WHERE verkordid = :verkordid";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':verkordid', $verkordid);
        $stmt->bindParam(':artid', $artid);
        $stmt->bindParam(':klantid', $klantid);
        $stmt->bindParam(':verkorddatum', $verkorddatum);
        $stmt->bindParam(':verkordbestaantal', $verkordbestaantal);
        $stmt->bindParam(':verkordstatus', $verkordstatus);

        $stmt->execute();
    }
}

if (isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen") {
    $verkooporder = new Verkooporder($conn);

    $verkordid = $_POST['verkordid'];
    $artid = $_POST['artid'];
    $klantid = $_POST['klantid'];
    $verkorddatum = $_POST['verkorddatum'];
    $verkordbestaantal = $_POST['verkordbestaantal'];
    $verkordstatus = $_POST['verkordstatus'];

    $verkooporder->insertVerkooporder($verkordid, $artid, $klantid, $verkorddatum, $verkordbestaantal, $verkordstatus);

    echo "<script>alert('Verkooporder met ID: " . $_POST['verkordid'] . " is toegevoegd')</script>";
    echo "<script>location.replace('select.php');</script>";
}

if (isset($_POST["update"]) && $_POST["update"] == "Bijwerken") {
    $verkooporder = new Verkooporder($conn);

    $verkordid = $_POST['verkordid'];
    $artid = $_POST['artid'];
    $klantid = $_POST['klantid'];
    $verkorddatum = $_POST['verkorddatum'];
    $verkordbestaantal = $_POST['verkordbestaantal'];
    $verkordstatus = $_POST['verkordstatus'];

    $verkooporder->updateVerkooporder($verkordid, $artid, $klantid, $verkorddatum, $verkordbestaantal, $verkordstatus);

    echo "<script>alert('Verkooporder met ID: " . $verkordid . " is bijgewerkt')</script>";
    echo "<script>location.replace('select.php');</script>";
}
?>
