<?php
require_once './env.php';
$pageName = 'Jobs';
sessionValidation();
clientValidation();

require_once './actions/dbFunctions.php';
$jobs = $database->selectAllWhere('jobs', 'user = '.$_SESSION['user']['id'].' ORDER BY status DESC');

// Code if edit is true
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    foreach ($jobs as $key => $job) {
        if ($job['id'] === $id) {
           $editJob = $job; 
        }
    }
}

include './components/header.php';
?>

<div class="container my-5">
    <div class="row no-gutters">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <?php if(!(isset($editJob))): ?>
                    <h5 class="card-title border-bottom mb-3">Add Job</h5>
                    <form action="<?= $appURL . 'actions/jobs.php' ?>" method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" required="true" placeholder="Title" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" required="true"
                                placeholder="Description"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <select name="category" class="form-select" required="true" id="category">
                                <option value="">--- Select ---</option>
                                <option>Plumber</option>
                                <option>Mechanic</option>
                                <option>Painter</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="time">Time</label>
                            <input type="text" name="time" class="form-control" required="true" placeholder="Time" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="rate">Rate <small class="text-muted">(per hour)</small></label>
                            <input type="text" name="rate" class="form-control" required="true" placeholder="Rate" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="experience">Experience </label>
                            <input type="text" name="experience" class="form-control" required="true"
                                placeholder="Experience" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="submit">Submit</label>
                            <input type="submit" name="submit" class="btn btn-success w-100" />
                        </div>
                    </form>
                    <?php else: ?>
                    <h5 class="card-title border-bottom mb-3">Edit Job</h5>
                    <form action="<?= $appURL . 'actions/jobs.php' ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $editJob['id'] ?>">
                        <input type="hidden" name="action" value="edit">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="<?= $editJob['title'] ?>"
                                required="true" placeholder="Title" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" required="true"
                                placeholder="Description"><?= $editJob['description'] ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <select name="category" class="form-select" required="true" id="category">
                                <option value="">--- Select ---</option>
                                <option <?= $editJob['category'] == 'Plumber' ? 'selected': '' ?>>Plumber
                                </option>
                                <option <?= $editJob['category'] == 'Mechanic' ? 'selected' : '' ?>>Mechanic
                                </option>
                                <option <?= $editJob['category'] == 'Painter' ? 'selected': '' ?>>Painter
                                </option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="time">Time</label>
                            <input type="text" name="time" class="form-control" value="<?= $editJob['time'] ?>"
                                required="true" placeholder="Time" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="experience">Experience</label>
                            <input type="text" name="experience" class="form-control"
                                value="<?= $editJob['experience'] ?>" required="true" placeholder="Experience" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="submit">Submit</label>
                            <input type="submit" name="submit" class="btn btn-success w-100" />
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <div class="col-sm-8">
            <?php foreach($jobs as $key => $job): ?>
            <?php job($job); ?>
            <?php endforeach; ?>
        </div>
    </div>