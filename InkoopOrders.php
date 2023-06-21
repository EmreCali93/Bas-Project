<?php
include 'conn.php';
include 'Config.php';

class Inkooporder extends Config {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertInkooporder($inkordid, $artid, $levid, $inkorddatum, $inkordbestaantal, $inkordstatus) {
        $sql = "INSERT INTO inkooporders (inkordid, artid, levid, inkorddatum, inkordbestaantal, inkordstatus)
                VALUES (:inkordid, :artid, :levid, :inkorddatum, :inkordbestaantal, :inkordstatus)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':inkordid', $inkordid);
        $stmt->bindParam(':artid', $artid);
        $stmt->bindParam(':levid', $levid);
        $stmt->bindParam(':inkorddatum', $inkorddatum);
        $stmt->bindParam(':inkordbestaantal', $inkordbestaantal);
        $stmt->bindParam(':inkordstatus', $inkordstatus);

        $stmt->execute();
    }

    public function getLeveranciers() {
        $sql = "SELECT l.levid, l.levnaam FROM leveranciers AS l";
        $result = $this->conn->query($sql);

        $leveranciers = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $leveranciers[$row['levid']] = $row['levnaam'];
        }

        return $leveranciers;
    }
}
?>