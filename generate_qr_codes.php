<?php
// 1. Include the QR library
require_once 'phpqrcode/qrlib.php';

// 2. Your database connection
require_once 'includes/dbh.inc.php';

// 3. Fetch all shelf IDs
$query = "SELECT DISTINCT Oznaka FROM Polica";
$stmt = $pdo->query($query);
$shelves = $stmt->fetchAll(PDO::FETCH_COLUMN);

// 4. Output directory
$qrDir = 'generated_qrcodes/';
if (!file_exists($qrDir)) {
    mkdir($qrDir, 0755, true);
}

// 5. Generate QR for each shelf
foreach ($shelves as $shelf) {
    $cleanShelf = preg_replace('/[^a-zA-Z0-9\-_]/', '', $shelf);
    $filename = $qrDir . 'shelf_' . $cleanShelf . '.png';
    
    // Generate QR code
    QRcode::png(
        $shelf,            // Text to encode
        $filename,         // Output file
        QR_ECLEVEL_L,      // Error correction level
        10,                // Pixel size
        2                  // Margin
    );
    
    echo "Generated QR for shelf: $shelf<br>";
}

echo "<h2>All QR Codes Generated</h2>";
foreach ($shelves as $shelf) {
    $cleanShelf = preg_replace('/[^a-zA-Z0-9\-_]/', '', $shelf);
    echo "<div style='display: inline-block; margin: 10px; text-align: center;'>
            <img src='generated_qrcodes/shelf_$cleanShelf.png' width='100'><br>
            $shelf
          </div>";
}
?>