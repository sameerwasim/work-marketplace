<?php
require_once './env.php';
$pageName = 'Admin';

require_once './actions/dbFunctions.php';

$users = $database->selectAll('users');
$jobs = $database->selectAll('jobs');

$query = 'SELECT proposal.*, jobs.id as jobId, jobs.title as jobTitle, 
          jobs.rate as jobRate, jobs.time as jobTime, users.username
          FROM proposal
          INNER JOIN jobs ON jobs.id = proposal.job
          INNER JOIN users ON users.id = proposal.user
          ';
$proposals = $database->customQuery($query);

include './components/header.php';
?>

<div class="container my-5">
    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link <?= empty($_GET['tab']) ? 'active' : '' ?>" id="pills-u-tab" data-bs-toggle="pill"
                data-bs-target="#pills-u">Users</button>
            <button class="nav-link <?= !empty($_GET['tab']) && $_GET['tab'] == 'jobs' ? 'active' : '' ?>"
                id="pills-j-tab" data-bs-toggle="pill" data-bs-target="#pills-j">Jobs</button>
            <button class="nav-link <?= !empty($_GET['tab']) && $_GET['tab'] == 'proposal' ? 'active' : '' ?>"
                id="pills-p-tab" data-bs-toggle="pill" data-bs-target="#pills-p">Proposals</button>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade <?= empty($_GET['tab']) ? 'show active' : '' ?>" id="pills-u">
                <?php include './admin/user.php' ?>
            </div>
            <div class="tab-pane fade <?= !empty($_GET['tab']) && $_GET['tab'] == 'jobs' ? 'show active' : '' ?>"
                id="pills-j">
                <?php include './admin/jobs.php' ?>
            </div>
            <div class="tab-pane fade <?= !empty($_GET['tab']) && $_GET['tab'] == 'proposal' ? 'show active' : '' ?>"
                id="pills-p">
                <?php include './admin/proposals.php' ?>
            </div>
        </div>
    </div>
</div>