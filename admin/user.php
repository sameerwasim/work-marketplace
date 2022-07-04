<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $key => $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['first_name'].' '.$user['last_name'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['type'] ?></td>
                    <td><?= $user['status'] ?></td>
                    <td>
                        <div class="d-flex flex-row">
                            <a href="<?= $appURL . '/actions/auth.php?action=status&status=2&id=' . $user['id'] ?>"><i
                                    class="fas fa-check text-success"></i></a>
                            <a href="<?= $appURL . '/actions/auth.php?action=status&status=3&id=' . $user['id'] ?>"><i
                                    class="fas fa-times text-danger ms-3"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>