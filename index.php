<?php
require_once './env.php';
$pageName = 'Home';

require_once './actions/dbFunctions.php';

if (isset($_GET['search'])) {
    $jobs = $database->selectAllWhere('jobs', '(
        title LIKE "%'.$_GET['search'].'%" OR
        description LIKE "%'.$_GET['search'].'%" OR
        category LIKE "%'.$_GET['search'].'%" OR
        time LIKE "%'.$_GET['search'].'%" OR
        rate LIKE "%'.$_GET['search'].'%" OR
        experience LIKE "%'.$_GET['search'].'%"
        ) AND status = "Active" ORDER BY id DESC');
} else {
    $jobs = $database->selectAllWhere('jobs', 'status = "Active" ORDER BY id DESC');
}

include './components/header.php';
?>

<div class="container my-5">

    <div class="mb-4">
        <form method="get">
            <div class="position-relative">
                <input class="form-control form-control-lg" name="search"
                    placeholder="Search By Title, Category, Rate, Time"
                    value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" />
                <div class="position-absolute" style="right: 10px; top: 8.5px">
                    <button class="btn btn-sm btn-primary rounded-pill px-4">Search</button>
                </div>
            </div>
        </form>
    </div>

    <div class=" row">
        <?php foreach($jobs as $key => $job): ?>
        <div class="col-sm-6">
            <?php job($job); ?>
        </div>
        <?php endforeach; ?>
        <div></div>
    </div>
</div>