<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Job Title</th>
                    <th>User (username)</th>
                    <th>Offered Time</th>
                    <th>Job Time</th>
                    <th>Offered Rate</th>
                    <th>Job Rate</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($proposals as $key => $proposal): ?>
                <tr>
                    <td><?= $proposal['id'] ?></td>
                    <td><?= $proposal['jobTitle'] ?></td>
                    <td><?= $proposal['username'] ?></td>
                    <td><?= $proposal['time'] ?> Hours</td>
                    <td><?= $proposal['jobTime'] ?> Hours</td>
                    <td><?= $proposal['rate'] ?>/Hour</td>
                    <td><?= $proposal['jobRate'] ?>/Hour</td>
                    <td><?= $proposal['status'] ?></td>
                    <td>
                        <div class="d-flex flex-row">
                            <a
                                href="<?= $appURL . '/actions/proposal.php?action=status&status=2&id=' . $proposal['id'] ?>"><i
                                    class="fas fa-check text-success"></i></a>
                            <a
                                href="<?= $appURL . '/actions/proposal.php?action=status&status=3&id=' . $proposal['id'] ?>"><i
                                    class="fas fa-times text-danger ms-3"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>