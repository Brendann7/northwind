<?php
require_once 'classes/User.php';

$user = new User();
$error = '';

if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email = $_POST['inputEmail'];
  $password = $_POST['inputPassword'];
  $loginData = $user->login($email, $password);

  if ($loginData) {
    $_SESSION['user_id'] = $loginData['id_user'];
    $_SESSION['user_nama'] = $loginData['nama'];

    echo "<script>alert('Login Berhasil!'); window.location='index.php';</script>";
  } else {
    $error = "Password salah";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <?php if ($error != ''): ?>
    <p style="color:red;">
      <?php echo $error; ?>
    </p>
  <?php endif; ?>
  <form action="" method="post">
    <input type="email" name="inputEmail" id="inputEmail" placeholder="email">
    <br><br>
    <input type="password" name="inputPassword" id="inputPassword" placeholder="password">
    <br><br>
    <button type="submit">Submit</button>
  </form>
</body>

</html>