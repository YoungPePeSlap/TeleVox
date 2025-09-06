<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Adatbázis kapcsolat
    $conn = mysqli_connect("localhost", "root", "", "televox");
    if (!$conn) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    // Prepared statement a biztonságos adatbevitelhez
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<p>Az üzenet sikeresen elmentve az adatbázisba!</p>";
        echo "<a href='televox.html'>Vissza a formhoz</a>";
    } else {
        echo "<p>Hiba történt az adatbázisba mentéskor: " . $stmt->error . "</p>";
        echo "<a href='televox.html'>Vissza a formhoz</a>";
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    header("Location: TeleVox.html");
    exit;
}
?>
