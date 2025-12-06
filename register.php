<?php
session_start();
require_once 'db.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    if ($username === '') $errors[] = "Ingrese un nombre de usuario.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email inválido.";
    if (strlen($password) < 6) $errors[] = "La contraseña debe tener al menos 6 caracteres.";
    if ($password !== $password_confirm) $errors[] = "Las contraseñas no coinciden.";
    if (empty($errors)) {
        $sql = "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = "El nombre de usuario o email ya están en uso.";
        } else {
            mysqli_stmt_close($stmt);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt2 = mysqli_prepare($conn, $insert);
            mysqli_stmt_bind_param($stmt2, "sss", $username, $email, $password_hash);
            if (mysqli_stmt_execute($stmt2)) {
                header("Location: login.php?registered=1"); exit;
            } else { $errors[] = "Error al registrar. Intente de nuevo."; }
            mysqli_stmt_close($stmt2);
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro - Practica1</title>
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
        .register-container {
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
        input[type="email"],
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
        .register-btn {
            background-color: #5cb85c;
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
        .register-btn:hover {
            background-color: #4cae4c;
        }
        .register-info {
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
    <div class="register-container">
        <h1>REGISTRO</h1>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php foreach($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post" action="register.php">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirmar contraseña</label>
                <input type="password" id="password_confirm" name="password_confirm">
            </div>
            <button type="submit" class="register-btn">CREAR CUENTA</button>
            <div class="register-info">Información Aplicada / Contraseña</div>
        </form>
        <div class="link">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>
</body>
</html>