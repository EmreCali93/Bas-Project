<?php

class Order {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getVerkoopOrders() {
        try {
            $query = "SELECT * FROM verkooporders";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            echo "Fout bij het ophalen van de verkooporders: " . $e->getMessage();
            return false;
        }
    }

    public function updateOrder($verkordid, $artid, $klantid, $verkorddatum, $verkordbestaantal, $verkordstatus) {
        try {
            $query = "UPDATE verkooporders SET
                        artid = :artid,
                        klantid = :klantid,
                        verkorddatum = :verkorddatum,
                        verkordbestaantal = :verkordbestaantal,
                        verkordstatus = :verkordstatus
                    WHERE verkordid = :verkordid";
            $stmt = $this->conn->prepare($query);

            // Loop through the arrays and bind the values
            for ($i = 0; $i < count($verkordid); $i++) {
                $stmt->bindParam(':artid', $artid[$i]);
                $stmt->bindParam(':klantid', $klantid[$i]);
                $stmt->bindParam(':verkorddatum', $verkorddatum[$i]);
                $stmt->bindParam(':verkordbestaantal', $verkordbestaantal[$i]);
                $stmt->bindParam(':verkordstatus', $verkordstatus[$i]);
                $stmt->bindParam(':verkordid', $verkordid[$i]);
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
    $order = new Order($conn);

    // Verkooporders ophalen
    $verkoopOrders = $order->getVerkoopOrders();

    // Order bijwerken
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_all'])) {
        $verkordid = isset($_POST['verkordid']) ? $_POST['verkordid'] : [];
        $artid = isset($_POST['artid']) ? $_POST['artid'] : [];
        $klantid = isset($_POST['klantid']) ? $_POST['klantid'] : [];
        $verkorddatum = isset($_POST['verkorddatum']) ? $_POST['verkorddatum'] : [];
        $verkordbestaantal = isset($_POST['verkordbestaantal']) ? $_POST['verkordbestaantal'] : [];
        $verkordstatus = isset($_POST['verkordstatus']) ? $_POST['verkordstatus'] : [];

        $updated = $order->updateOrder($verkordid, $artid, $klantid, $verkorddatum, $verkordbestaantal, $verkordstatus);
        if ($updated) {
            // Toon een succesbericht of voer andere acties uit
        }
    }
} catch(Exception $e) {
    echo "Er is een fout opgetreden: " . $e->getMessage();
}

?>
