<!DOCTYPE html>
<html>
<head>
  <title><?= $captions['title'] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="pages/index/style.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="?page=index">
        <?= $app->getConfig()->get('app_name') ?>
      </a>
      <div class="navbar-nav ms-auto">
        <span class="nav-item nav-link">
          Welcome, <?= htmlspecialchars($user['username']) ?>
        </span>
        <a class="nav-link" href="#" id="logout-link">
          <?= $captions['logout'] ?>
        </a>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Demo Content</h5>
            <p class="card-text">
              This is a demo page showing the basic functionality of the framework.
              Features implemented:
            </p>
            <ul>
              <li>User authentication (register/login)</li>
              <li>Session management</li>
              <li>File-based data storage</li>
              <li>AJAX handling</li>
              <li>Routing system</li>
              <li>Error handling</li>
              <li>Configuration management</li>
              <li>Multilingual support</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="pages/index/controller.js"></script>
</body>
</html>
