<?php
require_once './env.php';
$pageName = 'Job';

require_once './actions/dbFunctions.php';
$job = $database->selectAllWhere('jobs', 'id = '.$_GET['id'].' AND status = "Active"');

if (count($job) > 0) {
    $job = $job[0];
    $user = $database->selectAllWhere('users', 'id = '.$job['user']);
    if (count($user) > 0) {
        $user = $user[0];
        if (isset($_SESSION['user'])) {
            $query = 'SELECT proposal.*, users.first_name, users.last_name, jobs.title, jobs.id as jobId FROM proposal 
            INNER JOIN jobs ON jobs.id = proposal.job
            INNER JOIN users ON users.id = proposal.user
            WHERE proposal.user = '.$_SESSION['user']['id'].' AND proposal.job = '.$job['id'];
            $proposal = $database->customQuery($query);
            if (count($proposal) > 0) $proposal = $proposal[0];
        }
        unset($user['password']);

        // all proposal for client
        if (isset($_SESSION['user']) && $user['id'] == $_SESSION['user']['id']) {
            if (clientValidation('bool')) {
                $query = 'SELECT proposal.*, users.first_name, users.last_name, jobs.title, jobs.id as jobId FROM proposal 
                INNER JOIN jobs ON jobs.id = proposal.job
                INNER JOIN users ON users.id = proposal.user
                WHERE proposal.job = '.$job['id'];
                $clientProposals = $database->customQuery($query);
            }
        }

        // User Other Jobs
        $jobs = $database->selectAllWhere('jobs', 'user = '.$user['id'].' AND status = "Active"');
    }
}

include './components/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0"><?= $job['title'] ?></h5>
                    <small class="text-muted">Posted On: <?= date('d M, Y', strtotime($job['created_at'])) ?></small>
                    <p><?= $job['description'] ?></p>
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div><span class="text-muted">Rate:</span> PKR <?= $job['rate'] ?> / hour</div>
                                <div><span class="text-muted">Hours:</span> <?= $job['time'] ?> hours</div>
                                <div><span class="text-muted">Experience:</span> <?= $job['experience'] ?></div>
                                <strong><?= $job['category'] ?></strong>
                            </div>
                            <div class="align-self-end">
                                <?php if(sellerValidation('bool')): ?>
                                <button data-bs-toggle="modal" data-bs-target="#proposal" class="btn btn-warning">
                                    Send Proposal
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <h6 class="fw-bold">User</h6>
                        <div><?= $user['first_name'].' '.$user['last_name'] ?></div>
                        <div><?= $user['email'] ?></div>
                        <div><span class="text-muted">Active Jobs:</span> <?= count($jobs) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <!-- Seller Proposal View -->
            <?php if(isset($proposal) && count($proposal) > 0): ?>
            <div>
                <h5>My Proposal</h5>
                <?php proposal($proposal) ?>
                <hr />
            </div>
            <?php endif; ?>

            <!-- Client Proposal View -->
            <?php if(isset($clientProposals) && count($clientProposals) > 0): ?>
            <h5>My Proposals</h5>
            <div class="row">
                <?php foreach($clientProposals as $key => $proposal): ?>
                <div class="col-6">
                    <?php proposal($proposal);?>
                </div>
                <?php endforeach;?>
            </div>
            <hr />
            <?php endif; ?>

            <h5><?= $user['first_name'] ?>'s Other Jobs</h5>
            <?php foreach($jobs as $key => $item): ?>
            <?php $job['id'] !== $item['id'] ? job($item) : ''; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="proposal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Proposal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= $appURL . 'actions/proposal.php' ?>" method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="job" value="<?= $job['id'] ?>">
                    <div class="form-group mb-3">
                        <label for="time">Time</label>
                        <input type="text" placeholder="Time" name="time" required class="form-control" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="rate">Rate</label>
                        <input type="text" placeholder="Rate" name="rate" required class="form-control" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="submit">Submit</label>
                        <input type="submit" value="Submit" name="submit" required class="btn btn-primary w-100" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>