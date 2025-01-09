<!DOCTYPE html>
<html>
<head>
  <title><?= $captions['title'] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="pages/auth/style.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card mt-5">
          <div class="card-body">
            <h2 class="text-center mb-4"><?= $captions['title'] ?></h2>
            
            <div class="alert alert-danger d-none" id="error-message">
              <?= $captions['error'] ?>
            </div>

            <form id="login-form">
              <div class="mb-3">
                <label class="form-label"><?= $captions['username'] ?></label>
                <input type="text" class="form-control" name="username" required>
              </div>

              <div class="mb-3">
                <label class="form-label"><?= $captions['password'] ?></label>
                <input type="password" class="form-control" name="password" required>
              </div>

              <button type="submit" class="btn btn-primary w-100">
                <?= $captions['submit'] ?>
              </button>

              <div class="text-center mt-3">
                <a href="?page=auth&action=register">
                  <?= $captions['register_link'] ?>
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="pages/auth/controller.js"></script>
</body>
</html>
