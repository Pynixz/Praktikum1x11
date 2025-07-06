<?php
// Script untuk insert data kategori menggunakan PDO
try {
    // Database connection
    $host = 'localhost';
    $dbname = 'sukses';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if kategori table exists and has data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM kategori");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] == 0) {
        echo "Inserting sample categories...\n";

        // Insert sample categories
        $categories = [
            ['nama_kategori' => 'Teknologi', 'slug_kategori' => 'teknologi'],
            ['nama_kategori' => 'Bisnis', 'slug_kategori' => 'bisnis'],
            ['nama_kategori' => 'Lifestyle', 'slug_kategori' => 'lifestyle'],
            ['nama_kategori' => 'Pendidikan', 'slug_kategori' => 'pendidikan'],
            ['nama_kategori' => 'Kesehatan', 'slug_kategori' => 'kesehatan']
        ];

        $stmt = $pdo->prepare("INSERT INTO kategori (nama_kategori, slug_kategori) VALUES (?, ?)");

        foreach ($categories as $category) {
            $stmt->execute([$category['nama_kategori'], $category['slug_kategori']]);
        }

        echo "Categories inserted successfully!\n";
    } else {
        echo "Categories already exist. Count: " . $result['count'] . "\n";
    }

    // Show all categories
    $stmt = $pdo->query("SELECT * FROM kategori");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "\nExisting categories:\n";
    foreach ($categories as $cat) {
        echo "ID: {$cat['id_kategori']}, Name: {$cat['nama_kategori']}, Slug: {$cat['slug_kategori']}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
