<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "task36");

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]));
}

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 3; // Jumlah data per halaman
$offset = ($page - 1) * $limit;

// Total data
$result = $conn->query("SELECT COUNT(*) AS total FROM students");
$totalData = $result->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);

// Ambil data sesuai halaman
$query = "SELECT * FROM students LIMIT $offset, $limit";
$data = $conn->query($query);

$students = [];
if ($data && $data->num_rows > 0) {
    while ($row = $data->fetch_assoc()) {
        $students[] = $row;
    }
}

// Kirim data sebagai JSON
echo json_encode([
    'students' => $students,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);

// Tutup koneksi
$conn->close();
?>
