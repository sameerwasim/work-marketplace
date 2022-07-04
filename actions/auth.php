<?php

require_once '../env.php';
require_once './dbFunctions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $value = $_POST;
    $error = false;

    // To create an account
    if ($value['action'] == 'register') {
        $data = $database->selectAllWhere('users', 'email = "'.$value['email'].'" OR username = "'.$value['username'].'"');
        if (count($data) <= 0) {
            $value['password'] = password_hash($value['password'], PASSWORD_DEFAULT);

            $columns = ['first_name', 'last_name', 'username', 'email', 'password', 'type', 'status'];
            $values = [$value['first_name'], $value['last_name'], $value['username'], $value['email'], $value['password'], $value['type'], 1];
            $id = $database->insertTbl('users', $columns, $values);

            $data = $database->selectAllWhere('users', "id = ".$id);
            $_SESSION['loggedIn'] = true;
            unset($data[0]['password']);
            $_SESSION['user'] = $data[0];

            header('location: '. $appURL . 'dashboard.php');
        } else {
            echo 'Account already exists';
            echo '<br /><a href="'. $appURL .'auth.php">Go Back</a>';
        }
    }

    // To login into an account
    if ($value['action'] == 'login') {
        $data = $database->selectAllWhere('users', "username = '$value[username]' OR email = '$value[username]'");
        if (count($data) > 0) {
            if (password_verify($value['password'], $data[0]['password'])) {
            } else $error = true;
        } else {
            $error = true;
        }

        if ($error) {
            echo 'Invalid Email or Password';
            echo '<br /><a href="'. $appURL .'auth.php">Go Back</a>';
        } else {
            $_SESSION['loggedIn'] = true;
            unset($data[0]['password']);
            $_SESSION['user'] = $data[0];

            header('location: '. $appURL . 'dashboard.php');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $value = $_GET;
    $error = false;

    // To update account status
    if ($value['action'] == 'status') {
        adminValidation();

        $database->updateWhere('users', ['status' => $value['status']], "id = ".$value['id']);
        header('location: '. $appURL . 'admin.php');
    }
}