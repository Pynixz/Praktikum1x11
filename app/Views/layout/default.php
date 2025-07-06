<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'Judul') ?></title>
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
  <div id="container">
    
    <?= $this->include('template/header') ?>

    <!-- User Info Bubble -->
    <?php if (session()->get('logged_in')) : ?>
      <div class="user-bubble">
        <div class="user-avatar">👤</div>
        <div class="user-details">
          <span class="user-name"><?= session()->get('user_name') ?></span>
          <span class="user-role">Admin</span>
        </div>
      </div>
    <?php endif; ?>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('flash_msg')): ?>
      <div class="flash-message" id="flashMessage">
        <div class="alert alert-success">
          <span class="close-btn" onclick="closeFlashMessage()">&times;</span>
          <?= session()->getFlashdata('flash_msg') ?>
        </div>
      </div>
    <?php endif; ?>

    <div id="content-wrapper">
      <section id="main">
        <?= $this->renderSection('content') ?>
      </section>

      <aside id="sidebar">
        <?= view_cell('App\\Cells\\ArtikelLatest::render', [
            'category' => $_GET['category'] ?? null,
        ]) ?>

        <div class="widget-box">
          <h3 class="title">Widget Header:</h3>
          <ul>
            <li><a href="#">href Link</a></li>
            <li><a href="#">href Link</a></li>
          </ul>
        </div>

        <div class="widget-box">
          <h3 class="title">Bio:</h3>
          <p>Ignorance brings peace, but wisdom bears weight.</p>
        </div>
      </aside>
    </div>

    <footer>
      <p>&copy; Universitas Pelita Bangsa - 2025.</p>
    </footer>

  </div>

  <script>
    // Auto-close flash message after 3 seconds
    function closeFlashMessage() {
      const flashMessage = document.getElementById('flashMessage');
      if (flashMessage) {
        flashMessage.style.animation = 'slideUp 0.5s ease-out forwards';
        setTimeout(() => {
          flashMessage.style.display = 'none';
        }, 500);
      }
    }

    // Auto-close after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const flashMessage = document.getElementById('flashMessage');
      if (flashMessage) {
        setTimeout(() => {
          closeFlashMessage();
        }, 3000); // 3 seconds
      }
    });
  </script>
</body>
</html>
