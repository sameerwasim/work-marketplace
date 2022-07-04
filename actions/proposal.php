<?php

require_once '../env.php';
require_once './dbFunctions.php';

sessionValidation();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $value = $_POST;
    $error = false;

    // To create an proposal
    if ($value['action'] == 'add') {
        
        $user = $_SESSION['user']['id'];
        $proposal = $database->selectAllWhere('proposal', 'job = '.$value['job'].' AND user = '.$user);
        if (count($proposal) <= 0) {
            $columns = ['job', 'user', 'time', 'rate', 'status'];
            $values = [$value['job'], $user, $value['time'], $value['rate'], 1];

            $id = $database->insertTbl('proposal', $columns, $values);
            header('location: '.$appURL.'job.php?id='.$value['job']);
        } else {
            $values = ['time' => $value['time'], 'rate' => $value['rate'], 'status' => 1];
            $database->updateWhere('proposal', $values, 'id = '.$proposal[0]['id']);
            header('location: '.$appURL.'job.php?id='.$value['job']);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $value = $_GET;
    $error = false;

    // To create an proposal
    if ($value['action'] == 'update') {
        
        $user = $_SESSION['user']['id'];
        $proposal = $database->selectAllWhere('proposal', 'id = '.$value['id']);
        if (count($proposal) > 0) {
            $job = $database->selectAllWhere('jobs', 'id = '.$proposal[0]['job']);
            if (count($job) > 0) {
                if ($job[0]['user'] == $user) {
                    $values = ['status' => $value['status']];
                    $database->updateWhere('proposal', $values, 'id = '.$value['id']);
                    header('location: '.$appURL.'dashboard.php');
                }
            }
        } else {
            header('location: '.$appURL.'dashboard.php');
        }
    }

    // To update proposal status
    if ($value['action'] == 'status') {
        adminValidation();

        $database->updateWhere('proposal', ['status' => $value['status']], "id = ".$value['id']);
        header('location: '. $appURL . 'admin.php?tab=proposal');
    }
}