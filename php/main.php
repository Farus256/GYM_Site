<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $db_password = $_POST["password"];
    $message = $_POST["message"];

    $host = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "Gym";

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error) {
        die("Ошибка соединения с базой данных: " . $connection->connect_error);
    }

    $stmt = $connection->prepare("INSERT INTO Customers (name , email, password, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $db_password, $message);


    if ($stmt->execute()) {
        echo "Вы  успешно зарегистрированы!";
        
        $subject = "Вы $name успешно занесены в список посетителей";
        $message = "Ваш комеентарий $message почта $email и пароль от аккаунта $db_password";

        mail($email, $subject, $message);
    } else {
        echo "Ошибка при сохранении заказа в базе данных: " . $connection->error;
    }

    $stmt->close();


    $connection->close();
} else {
    echo "Недопустимый метод запроса.";
}


session_start(); 

$file_path = '../users.txt';

if ($password != $confirm_password) {
    echo "Паролі не співпадають. Будь ласка, спробуйте ще раз.";
    exit();
}

$all_users = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($all_users as $user) {
    $user_data = json_decode($user, true);
    if ($user_data['username'] === $username) {
        $_SESSION['username'] = $username;

        if ($name === 'admin') {
            $_SESSION['user_type'] = 'admin'; 
            header('Location: ../pages/admin.html');
            exit();
        } else {
            $_SESSION['user_type'] = 'registered_user';
            header('Location: ../pages/user.html');
            exit();
        }
    }
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$user_data = [
    'username' => $username,
    'email' => $email,
    'password' => $hashed_password 
];

$user_json = json_encode($user_data);

if (file_put_contents($file_path, $user_json . PHP_EOL, FILE_APPEND | LOCK_EX)) {
    $_SESSION['username'] = $username;
    $_SESSION['user_type'] = 'user'; 
    echo "Ви успішно зареєстровані.";
} else {
    echo "Помилка при реєстрації.";
}
?>