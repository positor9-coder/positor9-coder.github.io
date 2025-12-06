<?php
session_start();
require_once 'db.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username_or_email === '' || $password === '') {
        $errors[] = "Ambos campos son obligatorios.";
    } else {
        $sql = "SELECT id, username, email, password FROM users WHERE username = ? OR email = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username_or_email, $username_or_email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $username, $email, $password_hash);
        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $password_hash)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("Location: index.php"); exit;
            } else { $errors[] = "Usuario o contraseña incorrectos."; }
        } else { $errors[] = "Usuario o contraseña incorrectos."; }
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - Practica1</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 40px;
        }
        h1 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }
        input:focus {
            border-color: #4a90e2;
            outline: none;
        }
        .login-btn {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 12px 20px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }
        .login-btn:hover {
            background-color: #3a7bc8;
        }
        .login-info {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #777;
        }
        .errors {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .errors ul {
            margin-left: 20px;
        }
        .link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .link a {
            color: #4a90e2;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>ACCEDER</h1>
        <?php if (isset($_GET['registered'])): ?>
            <div class="success">Registro exitoso. Ahora inicia sesión.</div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php foreach($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="username_or_email">Usuario o Email</label>
                <input type="text" id="username_or_email" name="username_or_email" value="<?php echo htmlspecialchars($username_or_email ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit" class="login-btn">ACCEDER</button>
            <div class="login-info">Comprobar informacion/Contraseña</div>
        </form>
        <div class="link">
            <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
        </div>
    </div>
</body>
</html>