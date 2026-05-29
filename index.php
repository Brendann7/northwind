<?php
require_once 'classes/User.php';

$user = new User();

// Tambah data (jika form disubmit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($user->create($nama, $email, $password)) {
        echo "<p>Data berhasil ditambahkan!</p>";
    } else {
        echo "<p>Gagal menambahkan data.</p>";
    }
}

// Hapus data (jika link hapus diklik)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $user->delete($id);
    header("Location: index.php");
    exit;
}
?>

<h2>Tambah Pengguna</h2>
<form method="POST" action="">
    <input type="text" name="nama" placeholder="Nama" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Simpan</button>
</form>

<hr>

<h2>Daftar Pengguna</h2>
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Aksi</th>
    </tr>

    <?php
    $data = $user->readAll();
    if ($data->num_rows > 0) {
        while ($row = $data->fetch_assoc()) {
            echo "
            <tr>
                <td>{$row['id_user']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['email']}</td>
                <td>
                    <a href='?hapus={$row['id_user']}'>Hapus</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Belum ada data</td></tr>";
    }
    ?>
</table>
