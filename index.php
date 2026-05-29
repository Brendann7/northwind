<?php
require_once 'classes/User.php';
session_start();
$user = new User();

//variabel ketika enggak di edit
$isEdit = false;
$idEdit;
$namaEdit;
$emailEdit;
$passwordEdit;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

//ngambil variabel sebelumnya kalo pencet edit
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $isEdit = true;

    if($oldRow = $user->readById($id)){
        $idEdit = $oldRow['id_user'];
        $namaEdit = $oldRow['nama'];
        $emailEdit = $oldRow['email'];
        $passwordEdit = $oldRow['password'];
    } else {
        echo "Cant read data";
    }
}

// Tambah data (jika form disubmit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    if(isset($_POST['indikasiEdit'])){
        $id_user = $_POST['indikasiEdit'];
        $message = "diupdate!";
        $executeQuery = $user->update($id_user, $nama, $email);
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $message = "diinput!";
        $executeQuery = $user->create($nama, $email, $password);
    }

    if ($executeQuery) {
        echo "<script>alert('Data berhasil $message'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Data gagal $message'); window.location='index.php';</script>";
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

<h2><?php echo $isEdit?"Edit ":"Tambah " ?>Pengguna</h2>
<div style="text-align: right;">
    Halo, <?php echo $_SESSION['user_nama']; ?>! | <a href="logout.php">Logout</a>
</div>
<hr>
<form method="POST" action="">
    <?php if($isEdit):?>
    <input type="hidden" name="indikasiEdit" value="<?php echo $idEdit ?>">
    <?php endif;?>
    <input type="text" name="nama" placeholder="Nama" value="<?php echo $isEdit? $namaEdit:null ?>" required><br><br>
    <input type="email" name="email" placeholder="Email" value="<?php echo $isEdit? $emailEdit:null ?>" required><br><br>
    <?php if($isEdit == false):?>
    <input type="password" name="password" placeholder="Password" value="<?php echo $isEdit? $passwordEdit:null ?>" required><br><br>
    <?php endif;?>
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
                    <a href='?hapus={$row['id_user']}'>Hapus</a>|
                    <a href='?edit={$row['id_user']}'>Edit</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Belum ada data</td></tr>";
    }
    ?>
</table>
