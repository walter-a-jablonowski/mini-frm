<!DOCTYPE html>
<html>
<head>
  <title><?= $title ?? 'Welcome' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="pages/index/controller.js"></script>
  <link rel="stylesheet" href="pages/index/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
      <a class="navbar-brand" href="?page=index">
        <?= $captions?->get('index.brand') ?? 'Simple Framework' ?>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active" href="?page=index">
              <?= $captions?->get('nav.home') ?? 'Home' ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=demo">
              <?= $captions?->get('nav.demo') ?? 'Demo' ?>
            </a>
          </li>
        </ul>
        <div class="d-flex">
          <?php if( $app->isLoggedIn()): ?>
            <button id="logout-button" class="btn btn-outline-light">
              <?= $captions?->get('nav.logout') ?? 'Logout' ?>
            </button>
          <?php else: ?>
            <a href="?page=auth" class="btn btn-outline-light me-2">
              <?= $captions?->get('nav.login') ?? 'Login' ?>
            </a>
            <a href="?page=auth&action=register" class="btn btn-light">
              <?= $captions?->get('nav.register') ?? 'Register' ?>
            </a>
          <?php endif ?>
        </div>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-body">
            <h2><?= $captions?->get('index.welcome_title') ?? 'Welcome to Simple Framework' ?></h2>
            <p class="lead">
              <?= $captions?->get('index.welcome_text') ?? 'A lightweight PHP framework for building web applications.' ?>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-body">
                <h3><?= $captions?->get('index.features_title') ?? 'Features' ?></h3>
                <ul>
                  <li>File-based data storage</li>
                  <li>Simple routing system</li>
                  <li>User authentication</li>
                  <li>Clean MVC structure</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-body">
                <h3><?= $captions?->get('index.getting_started_title') ?? 'Getting Started' ?></h3>
                <ol>
                  <li>Clone the repository</li>
                  <li>Run composer install</li>
                  <li>Configure your settings</li>
                  <li>Start building!</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h3><?= $captions?->get('index.quick_links') ?? 'Quick Links' ?></h3>
            <div class="list-group">
              <a href="?page=demo" class="list-group-item list-group-item-action">
                <?= $captions?->get('nav.demo') ?? 'View Demo' ?>
              </a>
              <a href="?page=auth" class="list-group-item list-group-item-action">
                <?= $captions?->get('nav.login') ?? 'Login' ?>
              </a>
              <a href="?page=auth&action=register" class="list-group-item list-group-item-action">
                <?= $captions?->get('nav.register') ?? 'Register' ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
