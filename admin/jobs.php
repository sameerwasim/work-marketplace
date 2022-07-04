<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Time</th>
                    <th>Rate</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($jobs as $key => $job): ?>
                <tr>
                    <td><?= $job['id'] ?></td>
                    <td><?= $job['title'] ?></td>
                    <td><?= $job['description'] ?></td>
                    <td><?= $job['category'] ?></td>
                    <td><?= $job['title'] ?></td>
                    <td><?= $job['rate'] ?></td>
                    <td><?= $job['experience'] ?></td>
                    <td><?= $job['status'] ?></td>
                    <td>
                        <div class="d-flex flex-row">
                            <a href="<?= $appURL . '/actions/jobs.php?action=status&status=2&id=' . $job['id'] ?>"><i
                                    class="fas fa-check text-success"></i></a>
                            <a href="<?= $appURL . '/actions/jobs.php?action=status&status=3&id=' . $job['id'] ?>"><i
                                    class="fas fa-times text-danger ms-3"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>