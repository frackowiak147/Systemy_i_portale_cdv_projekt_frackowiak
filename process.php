<?php
try {
    $sql = "INSERT INTO gracze (nazwa, wygrana) VALUES (:nazwa, :wygrana)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nazwa', $graczName);
    $stmt->bindParam(':wygrana', $wygrana);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}
?>
