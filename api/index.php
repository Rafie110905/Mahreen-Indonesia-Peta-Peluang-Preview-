<?php
require_once __DIR__ . '/data/petal.php';
$programs = require __DIR__ . '/data/programs.php';
$icons    = require __DIR__ . '/data/icons.php';

// Kategori unik untuk filter tabs, urut sesuai kemunculan di data
$categories = [];
foreach ($programs as $p) {
    $categories[$p['id']] = $p['kategori'];
}

// Label singkat khusus untuk orbit hero (ruang di lingkaran kecil terbatas)
$shortLabel = [
    'kreativitas' => 'Kreativitas',
    'teknologi'   => 'Teknologi',
    'talenta'     => 'Talenta',
    'bisnis'      => 'Bisnis',
    'komunitas'   => 'Komunitas',
    'sosial'      => 'Sosial',
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mahreen Indonesia — Peta Peluang</title>
<meta name="description" content="Temukan program dan peluang Mahreen Indonesia yang paling cocok untukmu. Satu Ide. Satu Karya. Satu Dampak.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Manrope:wght@500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header class="site-header">
  <div class="wrap">
    <div class="logo">Mahreen <span>Indonesia</span></div>
    <nav class="nav-links" id="navLinks">
      <a href="#kuis">Mulai Dari Mana</a>
      <a href="#peta-peluang">Peta Peluang</a>
      <a href="#tentang">Tentang</a>
      <a href="#gabung">Gabung</a>
    </nav>
    <button type="button" class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="navLinks" aria-label="Buka menu navigasi">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<section class="hero">
  <?= render_petal('hero-a') ?>
  <?= render_petal('hero-b') ?>
  <div class="wrap">
    <div class="hero-copy">
      <p class="hero-eyebrow">Berkarya Untuk Indonesia</p>
      <h1>Satu ide bisa jadi
        langkah nyata
        untuk Indonesia.</h1>
      <p class="lead">Mahreen Indonesia adalah ekosistem kreativitas, teknologi, dan kolaborasi untuk generasi muda. Cari tahu peluang mana yang paling cocok denganmu, dalam kurang dari satu menit.</p>
      <div class="hero-actions">
        <a href="#kuis" class="btn btn-primary">Temukan Program yang Cocok</a>
        <a href="#peta-peluang" class="btn btn-ghost">Lihat Semua Peluang</a>
      </div>
    </div>

    <div class="hero-orbit" aria-hidden="true">
      <div class="orbit-core">Mahreen<br>Indonesia</div>
      <div class="orbit-spin">
        <div class="orbit-ring"></div>
        <?php $i = 0; foreach ($categories as $catId => $catName): $i++; ?>
          <div class="orbit-node orbit-node-<?= $i ?>">
            <div class="orbit-node-inner">
              <span class="orbit-icon"><?= $icons[$catId] ?? '' ?></span>
              <span class="orbit-label"><?= htmlspecialchars($shortLabel[$catId] ?? $catName) ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="wave-shape wave-to-white" aria-hidden="true"></div>
</section>

<section class="quiz" id="kuis">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="kicker">Mulai Dari Mana</p>
      <h2>Kamu tertarik di bidang apa?</h2>
      <p>Pilih satu yang paling menggambarkan kamu — kami tunjukkan program yang paling relevan.</p>
    </div>

    <div class="quiz-card reveal">
      <?= render_petal('quiz-a') ?>
      <p class="quiz-question">Bidang yang paling menarik buat kamu:</p>
      <div class="quiz-options">
        <?php foreach ($programs as $p): ?>
          <button type="button" class="quiz-option" data-interest="<?= htmlspecialchars($p['id']) ?>" aria-pressed="false">
            <span class="quiz-option-icon"><?= $icons[$p['id']] ?? '' ?></span>
            <span><?= htmlspecialchars($p['kategori']) ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="quiz-result" aria-live="polite"></div>
      <p class="quiz-status" aria-live="polite"></p>
    </div>
  </div>
</section>

<section class="programs" id="peta-peluang">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="kicker">Peta Peluang</p>
      <h2>Semua program dan peluang, dalam satu tempat.</h2>
      <p>Jelajahi peluang Mahreen Indonesia berdasarkan bidang yang kamu minati.</p>
    </div>

    <div class="filter-tabs" role="tablist" aria-label="Filter kategori program">
      <button type="button" class="filter-tab is-active" data-filter="semua">Semua</button>
      <?php foreach ($categories as $catId => $catName): ?>
        <button type="button" class="filter-tab" data-filter="<?= htmlspecialchars($catId) ?>"><?= htmlspecialchars($catName) ?></button>
      <?php endforeach; ?>
    </div>

    <div class="program-grid">
      <?php $i = 0; foreach ($programs as $p): $i++; ?>
        <article
          class="program-card reveal program-card-<?= $i ?>"
          id="program-<?= htmlspecialchars($p['id']) ?>"
          data-category="<?= htmlspecialchars($p['id']) ?>"
          data-accent="<?= htmlspecialchars($p['accent']) ?>"
        >
          <div class="card-icon-badge"><?= $icons[$p['id']] ?? '' ?></div>
          <span class="kategori-tag"><?= htmlspecialchars($p['kategori']) ?></span>
          <h3><?= htmlspecialchars($p['title']) ?></h3>
          <p class="tagline"><?= htmlspecialchars($p['tagline']) ?></p>
          <p class="deskripsi"><?= htmlspecialchars($p['deskripsi']) ?></p>
          <p class="cocok-untuk"><?= htmlspecialchars($p['cocok_untuk']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="wave-shape wave-to-white-flip" aria-hidden="true"></div>
</section>

<section class="about" id="tentang">
  <div class="wrap">
    <div class="about-figure">
      <div class="stat"><strong><?= count($programs) ?></strong><span>bidang peluang aktif</span></div>
      <div class="stat"><strong>1</strong><span>ekosistem, banyak jalan berkarya</span></div>
    </div>
    <div class="about-text">
      <p>Mahreen Indonesia bergerak di bidang kreativitas, teknologi digital, pengembangan talenta, bisnis, komunitas, dan kontribusi sosial — dengan satu tujuan yang sama: membuka ruang bagi generasi muda untuk berkarya dan memberi dampak.</p>
      <p>Halaman ini dibuat supaya peluang yang tersedia lebih mudah dikenal, dipahami, dan diikuti — mulai dari menemukan bidang yang cocok, sampai menjelajahi semua program yang ada.</p>
    </div>
  </div>
</section>

<section class="join" id="gabung">
  <div class="wrap">
    <h2>Satu Ide. Satu Karya. Satu Dampak.</h2>
    <p>Sudah tahu bidang yang cocok? Saatnya mulai berkarya bersama Mahreen Indonesia.</p>
    <a href="https://www.mahreenindonesia.com" class="btn btn-primary" target="_blank" rel="noopener">Kunjungi Mahreen Indonesia</a>
  </div>
</section>

<footer class="site-footer">
  <?= render_petal('footer-a') ?>
  <div class="wrap">
    <span>&copy; <?= date('Y') ?> Mahreen Indonesia — Creative • Digital • Social Company</span>
    <span>Prototype untuk Creative Challenge Internship Batch 2</span>
  </div>
</footer>

<script src="assets/script.js"></script>
</body>
</html>