<?php

require_once '../env.php';
require_once './dbFunctions.php';

sessionValidation();
clientValidation();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $value = $_POST;
    $error = false;

    // To create an job
    if ($value['action'] == 'add') {
        
        $user = $_SESSION['user']['id'];

        $columns = ['title', 'description', 'category', 'time', 'rate', 'experience', 'user', 'status'];
        $values = [$value['title'], $value['description'], $value['category'], $value['time'], $value['rate'], $value['experience'], $user, 1];
        $id = $database->insertTbl('jobs', $columns, $values);

        header('location: '. $appURL . 'jobs.php');
    }

    if ($value['action'] == 'edit') {
        $data = $database->selectAllWhere('jobs', 'id = '.$value['id']);
        if (count($data) > 0 && $data[0]['user'] == $_SESSION['user']['id']) {
            $values = ['title' => $value['title'], 'description' => $value['description'], 'category' => $value['category'],
            'time' => $value['time'], 'rate' => $value['rate'], 'experience' => $value['experience'], 'status' => 1];
            $database->updateWhere('jobs', $values, 'id = '.$value['id']);

            header('location: '. $appURL . 'jobs.php');
        } else {
            echo 'Error<br />';
            echo '<a href="'.$appURL.'">Go Back</a>';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $value = $_GET;
    $error = false;

    // To delete an job
    if ($value['action'] == 'delete') {
        $data = $database->selectAllWhere('jobs', 'id = '.$value['id']);
        if (count($data) > 0 && $data[0]['user'] == $_SESSION['user']['id']) {
            $database->deleteWhere('jobs', 'id = '.$value['id']);
            header('location: '. $appURL . 'jobs.php');
        } else {
            echo 'Error<br />';
            echo '<a href="'.$appURL.'">Go Back</a>';
        }
    }

    // To update jobs status
    if ($value['action'] == 'status') {
        adminValidation();

        $database->updateWhere('jobs', ['status' => $value['status']], "id = ".$value['id']);
        header('Location: '. $appURL . 'admin.php?tab=jobs');
    }
}