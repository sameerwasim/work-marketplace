<?php
require_once './env.php';
$pageName = 'Dashboard';
sessionValidation();

if (adminValidation('bool')) {
    header('location: ./admin.php');
}

include './actions/dbFunctions.php';

if(sellerValidation('bool')) {
    $query = 'SELECT proposal.*, users.first_name, users.last_name, jobs.title, jobs.id as jobId FROM proposal 
    INNER JOIN jobs ON jobs.id = proposal.job
    INNER JOIN users ON users.id = proposal.user
    WHERE proposal.user = '.$_SESSION['user']['id'];
    $proposals = $database->customQuery($query);

    $query = 'SELECT proposal.*, users.first_name, users.last_name, jobs.title, jobs.id as jobId FROM proposal 
    INNER JOIN jobs ON jobs.id = proposal.job
    INNER JOIN users ON users.id = jobs.user
    WHERE proposal.user = '.$_SESSION['user']['id'].' AND proposal.status = "Accepted"';
    $workHistory = $database->customQuery($query);
}

if (clientValidation('bool')) {
    $query = 'SELECT proposal.*, users.first_name, users.last_name, jobs.title, jobs.id as jobId FROM proposal 
    INNER JOIN jobs ON jobs.id = proposal.job
    INNER JOIN users ON users.id = proposal.user
    WHERE proposal.job IN (
        SELECT id FROM jobs WHERE user = '.$_SESSION['user']['id'].'
    )';
    $clientProposals = $database->customQuery($query);

    $query = 'SELECT proposal.*, users.first_name, users.last_name, jobs.title, jobs.id as jobId FROM proposal 
    INNER JOIN jobs ON jobs.id = proposal.job
    INNER JOIN users ON users.id = proposal.user
    WHERE proposal.job IN (
        SELECT id FROM jobs WHERE user = '.$_SESSION['user']['id'].' AND `status` = "Active"
    ) AND proposal.status = "Accepted"';
    $employementHistory = $database->customQuery($query);
}

include './components/header.php';
?>

<div class="container my-5">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="py-2">
                    <h6 class="my-0 font-weight-bold"><?= $user['first_name'].' '.$user['last_name'] ?></h6>
                    <p class="my-0 text-muted btn-text text-center">Member since
                        <?= date('M Y', strtotime($user['created_at'])) ?></p>
                </div>
                <div class="align-self-center">
                    <?php if(clientValidation('bool')): ?>
                    <a class="btn btn-primary mt-2" href="<?= $appURL . 'jobs.php' ?>">My Job</a>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- // Seller Proposal -->
        <?php if(isset($proposals) && count($proposals) > 0): ?>
        <div class="col-sm-6">
            <h4 class="mt-5 mb-0">Sent Proposals</h4>
            <div class="row">
                <?php foreach($proposals as $key => $proposal): ?>
                <div class="col-12">
                    <?php proposal($proposal);?>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif; ?>

        <!-- // Employement History -->
        <?php if(isset($employementHistory) && count($employementHistory) > 0): ?>
        <div class="col-sm-6">
            <h4 class="mt-5 mb-0">Employement History</h4>
            <div class="row">
                <?php foreach($employementHistory as $key => $history): ?>
                <div class="col-12">
                    <div class="card my-3">
                        <div class="card-body text-overflow">
                            You hired <?= $history['first_name'] ?> for <?= $history['title'] ?>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif; ?>

        <!-- // Client Proposal -->
        <?php if(isset($clientProposals) && count($clientProposals) > 0): ?>
        <div class="col-sm-6">
            <h4 class="mt-5 mb-0">Recieved Proposals</h4>
            <div class="row">
                <?php foreach($clientProposals as $key => $proposal): ?>
                <div class="col-sm-12">
                    <div class="row gx-0">
                        <div class="col-10">
                            <?php proposal($proposal) ?>
                        </div>
                        <div class="col-2">
                            <div class="d-flex border mt-3 p-2">
                                <div class="d-flex flex-row justify-content-center">
                                    <?php if($proposal['status'] == 'Pending'): ?>
                                    <div class="btn btn-success rounded-circle border me-3">
                                        <a
                                            href="<?= $appURL ?>actions/proposal.php?action=update&status=2&id=<?= $proposal['id'] ?>">
                                            <i class="fas fa-check text-white"></i>
                                        </a>
                                    </div>
                                    <div class="btn btn-danger rounded-circle border">
                                        <a
                                            href="<?= $appURL ?>actions/proposal.php?action=update&status=3&id=<?= $proposal['id'] ?>">
                                            <i class="fas fa-times text-white"></i>
                                        </a>
                                    </div>
                                    <?php else: ?>
                                    <div class="mt-2 mb-2"><?= $proposal['status'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>

            </div>
        </div>
        <?php endif; ?>

        <!-- // Work History -->
        <?php if(isset($workHistory) && count($workHistory) > 0): ?>
        <div class="col-sm-6">
            <h4 class="mt-5 mb-0">Work History</h4>
            <div class="row">
                <?php foreach($workHistory as $key => $history): ?>
                <div class="col-12">
                    <div class="card my-3">
                        <div class="card-body text-overflow">
                            You were hired by <?= $history['first_name'] ?> for <?= $history['title'] ?>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif; ?>

    </div>


</div>