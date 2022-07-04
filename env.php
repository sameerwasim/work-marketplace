<?php

/* App Variables */
$appName = 'AppName';
$appVersion = 'v0.1.1';
$appURL = 'http://localhost/upwork-clone/';


/* DB Status */
define('dbHOST', 'localhost');
define('dbUSERNAME', 'root');
define('dbPASSWORD', '');
define('database', 'clone');


/* App Functions */

// Start Session
session_start();

// to check if current url matches
function isActive($url) {
  global $appURL;
  echo $appURL == $appURL . $url ? 'active' : '';
}

// Check if user is loggedIn or not
function sessionValidation($response = '') {
  global $appURL;
  if ($response == 'bool') {
    if (!(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
      return false;
    } else {
      return true;
    }
  } else {
    if (!(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
      header('location: ' . $appURL);
    } else {
      global $user;
      $user = $_SESSION['user'];
    }
  }
}

// Check if user is seller or not
function sellerValidation($response = '') {
  global $appURL;
  if ($response == 'bool') {
    if (!(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
      return false;
    } else {
      if (!($_SESSION['user']['type'] == 'Seller' && $_SESSION['user']['status'] == 'Active')) {
        return false;
      } else {
        return true;
      }
    }
  } else {
    if (!(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
      header('location: ' . $appURL);
    } else {
      if (!($_SESSION['user']['type'] == 'Seller' && $_SESSION['user']['status'] == 'Active')) {
        header('location: ' . $appURL);
      }
    }
  }
}

// Check if user is client or not
function clientValidation($response = '') {
  global $appURL;
  if ($response == 'bool') {
    if (!(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
      return false;
    } else {
      if (!($_SESSION['user']['type'] == 'Client' && $_SESSION['user']['status'] == 'Active')) {
        return false;
      } else {
        return true;
      }
    }
  } else {
    if (!(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
      header('location: ' . $appURL);
    } else {
      if (!($_SESSION['user']['type'] == 'Client' && $_SESSION['user']['status'] == 'Active')) {
        header('location: ' . $appURL);
      }
    }
  }
}

// Check if user is admin or not
function adminValidation($response = '') {
  global $appURL;
  if ($response == 'bool') {
    if (!(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
      return false;
    } else {
      if (!($_SESSION['user']['type'] == 'Admin' && $_SESSION['user']['status'] == 'Active')) {
        return false;
      } else {
        return true;
      }
    }
  } else {
    if (!(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
      header('location: ' . $appURL);
    } else {
      if (!($_SESSION['user']['type'] == 'Admin' && $_SESSION['user']['status'] == 'Active')) {
        header('location: ' . $appURL);
      }
    }
  }
}

// Function to Print Job
function job($job) {
  global $appURL;
  if (!empty($job)) {
    $edit = (!empty($_SESSION['user']) && $job['user'] == $_SESSION['user']['id']) ? '
    <div class="d-flex flex-row mt-3">
      <div class="btn btn-warning rounded-circle border me-3">
          <a href="'.$appURL.'jobs.php?id='.$job['id'].'">
              <i class="fas fa-pencil text-dark"></i>
          </a>
      </div>
      <div class="btn btn-danger rounded-circle border">
          <a href="'.$appURL.'actions/jobs.php?action=delete&id='.$job['id'].'">
              <i class="fas fa-trash text-white"></i>
          </a>
      </div>
    </div>' : '';

    echo '
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <a class="col-sm-8 text-decoration-none text-dark" href="'.$appURL.'job.php?id='.$job['id'].'">
              <div>
                <h6 class="text-overflow mb-0">
                  '.$job['title'].'
                  <small style="font-size: 10px" class="badge bg-info">'.$job['status'].'</small>
                </h6>
                <p class="text-overflow">'.$job['description'].'</p>
              </div>
            </a>
            <div class="col-sm-4">
              <div class="d-flex flex-column align-items-end">
                  <strong>PKR '.$job['rate'].' / Hour</strong>
                  <small>Total Hours: '.$job['time'].'</small>
                '.$edit.'
              </div>
            </div>
          </div>
          <small class="text-muted">Posted on: '.date('d M, Y').'</small>
        </div>
      </div>
    ';
  }
}

// Function to print proposal
function proposal($proposal) {
  global $appURL;
  if(isset($proposal)) {
    echo '
    <a class="text-dark text-decoration-none" href="'.$appURL.'job.php?id='.$proposal['jobId'].'">
      <div class="card my-3">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="text-overflow me-2">'.$proposal['first_name'].'\'s Proposal for Job '.$proposal['title'].'</div>
            <div class="text-nowrap mx-2"><span class="text-muted">Time: </span> '.$proposal['time'].'</div>
            <div class="text-nowrap mx-2"><span class="text-muted">Rate: </span> '.$proposal['rate'].'</div>
            <div class="text-nowrap ms-2"><span class="text-muted">Status: </span>
              <span class="badge bg-primary">'.$proposal['status'].'</span></div>
          </div>
        </div>
      </div>
    </a>';
  }
}