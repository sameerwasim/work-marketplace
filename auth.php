<?php
require_once './env.php';
$pageName = 'Auth';

include './components/header.php';
?>

<div class="container my-5">
    <nav class="mb-4">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                type="button" role="tab" aria-controls="nav-home" aria-selected="true">SIGN UP</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">SIGN IN</button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <form class="container" method="POST" action="<?= $appURL . 'actions/auth.php' ?>">
                <input name="action" value="register" hidden="true" />
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" class="form-control" name="username" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" class="form-select">
                            <option>Client</option>
                            <option>Seller</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="submit" class="form-label">Submit</label>
                        <button type="submit" name="submit" class="btn btn-outline-primary w-100">SIGN UP NOW</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <form class="container" method="POST" action="<?= $appURL . 'actions/auth.php' ?>">
                <input name="action" value="login" hidden="true" />
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username or Email</label>
                    <input type="text" class="form-control" name="username" required />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required />
                </div>
                <div class="col-md-6">
                    <label for="submit" class="form-label">Submit</label>
                    <button type="submit" class="btn btn-outline-primary w-100">SIGN IN</button>
                </div>
            </form>
        </div>
    </div>
</div>