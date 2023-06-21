<?php

class Inkooporder {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getInkoopOrders() {
        try {
            $query = "SELECT * FROM inkooporders";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            echo "Fout bij het ophalen van de inkooporders: " . $e->getMessage();
            return false;
        }
    }

    public function updateOrder($inkordid, $artid, $levid, $inkorddatum, $inkordbestaantal, $inkordstatus) {
        try {
            $query = "UPDATE inkooporders SET
                        artid = :artid,
                        levid = :levid,
                        inkorddatum = :inkorddatum,
                        inkordbestaantal = :inkordbestaantal,
                        inkordstatus = :inkordstatus
                    WHERE inkordid = :inkordid";
            $stmt = $this->conn->prepare($query);

            // Loop through the arrays and bind the values
            for ($i = 0; $i < count($inkordid); $i++) {
                $stmt->bindParam(':artid', $artid[$i]);
                $stmt->bindParam(':levid', $levid[$i]);
                $stmt->bindParam(':inkorddatum', $inkorddatum[$i]);
                $stmt->bindParam(':inkordbestaantal', $inkordbestaantal[$i]);
                $stmt->bindParam(':inkordstatus', $inkordstatus[$i]);
                $stmt->bindParam(':inkordid', $inkordid[$i]);
                $stmt->execute();
            }

            echo "Order(s) is bijgewerkt.";
            return true;
        } catch(PDOException $e) {
            echo "Fout bij het bijwerken van de order: " . $e->getMessage();
            return false;
        }
    }
}

try {
    $order = new Inkooporder($conn);

    // Inkooporders ophalen
    $inkoopOrders = $order->getInkoopOrders();

    // Order bijwerken
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_all'])) {
        $inkordid = isset($_POST['inkordid']) ? $_POST['inkordid'] : [];
        $artid = isset($_POST['artid']) ? $_POST['artid'] : [];
        $levid = isset($_POST['levid']) ? $_POST['levid'] : [];
        $inkorddatum = isset($_POST['inkorddatum']) ? $_POST['inkorddatum'] : [];
        $inkordbestaantal = isset($_POST['inkordbestaantal']) ? $_POST['inkordbestaantal'] : [];
        $inkordstatus = isset($_POST['inkordstatus']) ? $_POST['inkordstatus'] : [];

        $updated = $order->updateOrder($inkordid, $artid, $levid, $inkorddatum, $inkordbestaantal, $inkordstatus);
        if ($updated) {
            // Toon een succesbericht of voer andere acties uit
        }
    }
} catch(Exception $e) {
    echo "Er is een fout opgetreden: " . $e->getMessage();
}

?>

