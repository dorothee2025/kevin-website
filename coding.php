<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" href="images/cs dream.png" type="image/png">
  <title>CS Dream — Learn to Code</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Lora:wght@400;700&display=swap" rel="stylesheet">

  <style>
  /* -----------------------
     Internal CSS (all styles combined)
     Place your image assets in an images/ folder as noted below.
     ----------------------- */

  * { box-sizing: border-box; }
  html,body { height: 100%; }
  body{
    margin:0;
    font-family: "Montserrat", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    color:#d9f8d9;
    background-color:#04120b;
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
    line-height:1.45;
  }

  /* Matrix background effect using layered backgrounds */
  body::before{
    content:"";
    position:fixed;
    inset:0;
    background-image:
      url("images/matrix-bg.jpg"),
      radial-gradient(circle at 10% 20%, rgba(24,72,44,0.12), transparent 10%),
      linear-gradient(180deg, rgba(12,30,18,0.9), rgba(6,12,9,0.9));
    background-size: cover, auto, auto;
    background-repeat: no-repeat;
    z-index:-2;
    opacity:1;
    filter:contrast(1.05) saturate(1.2);
  }

  body::after{
    content:"";
    position:fixed;
    inset:0;
    background: radial-gradient(circle at 90% 10%, rgba(0,255,120,0.02), transparent 5%),
                linear-gradient(180deg, rgba(0,0,0,0.12), rgba(0,0,0,0.6));
    z-index:-1;
  }

  .container{
    width: 92%;
    max-width: 1100px;
    margin: 0 auto;
  }

  /* Header */
  .site-header{
    position:sticky;
    top:0;
    z-index:10;
    backdrop-filter: blur(6px);
    border-bottom: 1px solid rgba(12,60,36,0.45);
    background: linear-gradient(180deg, rgba(0,0,0,0.15), rgba(0,0,0,0.25));
  }
  .header-inner{
    display:flex;
    align-items:center;
    gap:20px;
    padding:18px 0;
  }

  .logo{
    display:flex;
    gap:12px;
    align-items:center;
  }
  .logo-mark{
    width:44px;
    height:30px;
    border-radius:6px;
    background: linear-gradient(180deg,#8fe08f,#2a6f3a);
    box-shadow: 0 1px 0 rgba(255,255,255,0.03) inset, 0 6px 14px rgba(0,0,0,0.5);
  }
  .logo-text{
    font-weight:800;
    letter-spacing:1px;
    font-size:20px;
    color:#f1ffef;
  }

  .main-nav{
    margin-left:48px;
    display:flex;
    gap:24px;
    align-items:center;
    flex:1;
  }
  .main-nav a{
    color: #c9f7c9;
    text-decoration:none;
    font-weight:600;
    opacity:0.95;
  }
  .main-nav a:hover{ color:#e6ffea; }

  .header-cta{
    display:flex;
    gap:12px;
    align-items:center;
  }
  .signup{
    display:inline-block;
    padding:8px 14px;
    background:#c84a3d;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    font-weight:700;
    box-shadow: 0 4px 10px rgba(200,80,70,0.15);
  }
  .icon-btn{
    width:36px;
    height:36px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background: rgba(0,0,0,0.35);
    border-radius:6px;
    color:#d8fff0;
    text-decoration:none;
    font-weight:700;
  }

  /* Profile Widget Styles */
  .user-profile-widget{
    display:flex;
    align-items:center;
    gap:10px;
    background: rgba(0,0,0,0.35);
    padding:6px 12px;
    border-radius:6px;
    cursor:pointer;
    transition: all 0.3s ease;
    position:relative;
  }
  .user-profile-widget:not(.hidden){
    display:flex;
  }
  .user-profile-widget.hidden{
    display:none;
  }
  .user-profile-widget:hover{
    background: rgba(0,0,0,0.5);
  }
  .profile-pic{
    width:30px;
    height:30px;
    border-radius:50%;
    overflow:hidden;
    background: rgba(255,255,255,0.1);
  }
  .profile-pic img{
    width:100%;
    height:100%;
    object-fit:cover;
  }
  .user-profile-widget #navUsername{
    color:#d9f8d9;
    font-weight:600;
    font-size:14px;
    max-width:80px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }
  .user-menu{
    position:fixed;
    min-width:150px;
    background: linear-gradient(180deg, rgba(20,50,30,0.95), rgba(6,12,9,0.95));
    border:1px solid rgba(255,255,255,0.1);
    border-radius:6px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.4);
    padding:8px 0;
    z-index:10000;
    display:none;
    flex-direction:column;
  }
  .user-menu.visible{
    display:flex;
  }
  .user-menu a{
    padding:10px 16px;
    color:#d9f8d9;
    text-decoration:none;
    font-weight:500;
    transition: all 0.2s ease;
    display:block;
  }
  .user-menu a:hover{
    background: rgba(100,200,120,0.2);
    color:#e6ffea;
  }

  /* HERO */
  .hero{
    padding:56px 0 30px;
  }
  .hero-inner{
    display:flex;
    align-items:center;
    gap:36px;
    padding-top:18px;
    padding-bottom:18px;
  }

  .hero-left{
    flex: 1 1 480px;
  }
  .hero-left h1{
    font-size:56px;
    margin:0 0 12px;
    font-weight:800;
    color:#dbf9db;
    letter-spacing: -1px;
    text-shadow: 0 6px 18px rgba(0,0,0,0.6);
    font-family: "Lora", "Georgia", serif;
  }
  .hero-left .lead{
    font-size:20px;
    margin:0 0 20px;
    color:#cfe6c9;
    opacity:0.95;
  }
  .btn{
    display:inline-block;
    padding:12px 22px;
    border-radius:8px;
    text-decoration:none;
    font-weight:700;
    color:#eafbe9;
    background: linear-gradient(180deg, rgba(38,142,61,0.95), rgba(10,82,36,0.96));
    border: 2px solid rgba(255,255,255,0.06);
    box-shadow: 0 8px 18px rgba(6,40,20,0.5);
  }
  .btn.primary{
    background: linear-gradient(180deg,#6fc26e,#2e7a3c);
  }
  .btn.large{ padding:14px 36px; font-size:18px; }
  .btn.small{ padding:10px 16px; font-size:14px; }

  /* --- Skeleton Loading Placeholders --- */
  .skeleton { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 2s infinite; }
  @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
  .skeleton-card { width: 100%; height: 260px; border-radius: 16px; margin-bottom: 12px; }
  .skeleton-thumb { width: 100%; height: 200px; border-radius: 8px; margin-bottom: 8px; }
  .skeleton-title { width: 80%; height: 16px; border-radius: 4px; margin-bottom: 8px; }
  .skeleton-text { width: 60%; height: 12px; border-radius: 4px; margin-bottom: 6px; }
  .skeleton-buttons { display: flex; gap: 8px; height: 32px; }
  .skeleton-btn { flex: 1; height: 100%; border-radius: 6px; }

  .hero-right{
    flex: 0 0 500px;
    display:flex;
    justify-content:flex-end;
  }
  .hero-right img{
    width:460px;
    max-width:100%;
    border-radius:6px;
    box-shadow: 0 18px 50px rgba(0,0,0,0.7);
    border: 1px solid rgba(255,255,255,0.02);
  }

  /* Secondary CTA */
  .cta-secondary{
    padding:54px 0 56px;
    text-align:center;
    border-top: 1px solid rgba(255,255,255,0.03);
    border-bottom: 1px solid rgba(255,255,255,0.03);
    background: linear-gradient(180deg, rgba(5,25,18,0.05), rgba(0,0,0,0.05));
  }
  .cta-secondary h2{
    margin:0 0 8px;
    font-size:34px;
    color:#e8ffdf;
    font-weight:800;
  }
  .cta-secondary .sub{
    margin:8px 0 22px;
    color:#cfe6c9;
    font-size:16px;
  }

  /* Featured courses */
  .featured-courses{
    padding:56px 0;
    text-align:center;
  }
  .featured-courses h3{
    font-size:28px;
    margin:0 0 6px;
    font-weight:800;
  }
  .featured-courses .sub{
    margin:6px 0 28px;
    color:#cfe6c9;
    opacity:0.95;
  }

  .courses-grid{
    display:grid;
    grid-template-columns: repeat(4, 1fr);
    gap:20px;
    margin-top:10px;
  }
  .course-card{
    background: linear-gradient(180deg, rgba(5,25,18,0.18), rgba(6,12,9,0.18));
    border:1px solid rgba(255,255,255,0.04);
    padding:22px;
    border-radius:8px;
    text-align:center;
    box-shadow: 0 6px 30px rgba(0,0,0,0.6);
  }
  .course-card img{
    width:95px;
    height:95px;
    object-fit:contain;
    margin-bottom:12px;
  }
  .course-card h4{
    margin:8px 0 8px;
    font-size:18px;
    color:#e7ffdf;
  }
  .course-desc{
    color:#cfe6c9;
    font-size:14px;
    margin-bottom:12px;
  }

  /* Video tiles */
  .why-learn{
    padding:56px 0 80px;
  }
  .why-learn h3{ text-align:center; font-size:28px; margin-bottom:20px; font-weight:800; color:#e9ffd9; }
  .video-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:18px;
    margin-top:10px;
  }
  .video-card{
    position:relative;
    border-radius:8px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.04);
    background:rgba(0,0,0,0.25);
    box-shadow: 0 8px 30px rgba(0,0,0,0.6);
    min-height:130px;
  }
  .video-card img{
    width:100%;
    height:160px;
    object-fit:cover;
    display:block;
    opacity:0.95;
  }
  .play-overlay{
    position:absolute;
    left:16px;
    top:50%;
    transform:translateY(-50%);
    font-size:42px;
    color:rgba(255,255,255,0.95);
    background: rgba(0,0,0,0.35);
    width:72px;
    height:72px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    text-shadow: 0 6px 18px rgba(0,0,0,0.7);
  }
  .video-title{
    position:absolute;
    left:18%;
    bottom:12px;
    color:#eaffea;
    font-weight:700;
    background: rgba(0,0,0,0.25);
    padding:8px 12px;
    border-radius:6px;
    font-size:16px;
  }

  .site-footer{
    padding:18px 0;
    text-align:center;
    border-top:1px solid rgba(255,255,255,0.03);
    color:#9fe6a4;
    font-size:14px;
  }

  /* Responsive */
  @media (max-width: 1000px){
    .courses-grid{ grid-template-columns: repeat(2,1fr); }
    .video-grid{ grid-template-columns: repeat(2,1fr); }
    .hero-right img{ width:360px; }
  }
  @media (max-width: 720px){
    .header-inner{ flex-wrap:wrap; gap:12px; }
    .main-nav{ order:3; margin-left:0; gap:12px; width:100%; overflow:auto; padding:6px 0;}
    .hero-inner{ flex-direction:column-reverse; align-items:center; }
    .hero-left{ text-align:center; }
    .hero-left h1{ font-size:44px; }
    .courses-grid{ grid-template-columns: 1fr; }
    .video-grid{ grid-template-columns: 1fr; }
    .hero-right img{ width:100%; max-width:420px; }
    .play-overlay{ left:12px; }
    .video-title{ left:18%; font-size:14px; }
  }
  /* Floating Back to Top Button */
  #backToTop {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #00ffcc, #0099ff);
      border: none;
      border-radius: 50%;
      cursor: pointer;
      display: none;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: #fff;
      box-shadow: 0 8px 30px rgba(0, 153, 255, 0.4);
      z-index: 999;
      transition: all 0.3s ease;
  }
  #backToTop:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(0, 153, 255, 0.6);
  }
  #backToTop.show {
      display: flex;
  }
  @media (max-width: 768px) {
      #backToTop {
          width: 45px;
          height: 45px;
          bottom: 20px;
          right: 20px;
          font-size: 20px;
      }
  }
  </style>
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="logo">
        <div class="logo-mark" aria-hidden="true"></div>
        <div class="logo-text">CS DREAM</div>
      </div>

      <nav class="main-nav" aria-label="Main navigation">
        <a href="home.php" data-en="Home" data-rw="Ahabanza" data-fr="Accueil" data-lg="Oludda">Home</a>
        <a href="about.php" data-en="About" data-rw="Ibyerekeye" data-fr="À propos" data-lg="About">About</a>
        <a href="coding.php" data-en="Coding" data-rw="Kwandika" data-fr="Codage" data-lg="Coding">Coding</a>
        <a href="service.php" data-en="Services" data-rw="Serivisi" data-fr="Services" data-lg="Services">Services</a>
        <a href="news-section.php" data-en="News" data-rw="Amakuru" data-fr="Actualités" data-lg="Amakuru">News</a>
        <a href="contact.php" data-en="Contact" data-rw="Hamagara" data-fr="Contact" data-lg="Contact">Contact</a>
        <select id="languageSelect" style="padding:6px 10px;border-radius:4px;border:1px solid rgba(255,255,255,0.1);background-color:rgba(0,0,0,0.35);color:#d9f8d9;cursor:pointer;font-weight:600;">
          <option value="en">English</option>
          <option value="rw">Kinyarwanda</option>
          <option value="fr">French</option>
          <option value="lg">Luganda</option>
        </select>
      </nav>

      <div class="header-cta" id="authLinks">
        <a id="loginLink" href="login.php" class="signup">Login</a>
        <a id="signupLink" href="register.php" class="signup">Sign up</a>
        <div class="user-profile-widget hidden" id="userWidget" tabindex="0" aria-haspopup="true" aria-expanded="false">
          <div class="profile-pic">
            <img id="navProfilePic" src="https://via.placeholder.com/30/00ffff/000000?text=U" alt="Profile">
          </div>
          <span id="navUsername">Guest</span>
          <div class="user-menu" id="userMenu" role="menu" aria-hidden="true">
            <a href="setting.php" id="navProfileSettings" role="menuitem">Settings</a>
            <a href="#" id="navLogout" role="menuitem">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main>
    <!-- Hero -->
    <section class="hero">
      <div class="container hero-inner">
        <div class="hero-left">
          <h1 data-en="Learn to Code" data-rw="Wandike amashusho" data-fr="Apprendre à Coder" data-lg="Wandike amashusho">Learn to Code</h1>
          <p class="lead" data-en="Master the skills of tomorrow." data-rw="Injizire ubuhanga bw'ejo." data-fr="Maîtrisez les compétences de demain." data-lg="Injizire ubuhanga bw'ejo.">Master the skills of tomorrow.</p>
          <a href="register.php" class="btn primary" data-en="Get Started" data-rw="Tandika" data-fr="Commencer" data-lg="Tandika">Get Started</a>
        </div>

        <div class="hero-right">
          <!-- Replace with your provided image: rename your coding.png to images/hero-illustration.png -->
          <img src="images/hero-illustration.png" alt="Person coding illustration">
        </div>
      </div>
    </section>

    <!-- Secondary CTA -->
    <section class="cta-secondary">
      <div class="container">
        <h2 data-en="Start Your Coding Journey Today!" data-rw="Tandika umwanya wawe w'kwandika!" data-fr="Commencez Votre Parcours Maintenant!" data-lg="Tandika umwanya wawe w'kwandika!">Start Your Coding Journey Today!</h2>
        <p class="sub" data-en="Join millions of learners and start coding now." data-rw="Injira imbere y'abanyeshuri n'wandike." data-fr="Rejoignez des millions d'apprenants." data-lg="Injira imbere y'abanyeshuri n'wandike.">Join millions of learners and start coding now.</p>
        <a href="register.php" class="btn large" data-en="Join Now" data-rw="Injira Hasi" data-fr="Rejoindre" data-lg="Injira Hasi">Join Now</a>
      </div>
    </section>

    <!-- Featured Courses -->
    <section class="featured-courses">
      <div class="container">
        <h3 data-en="Featured Courses" data-rw="Amasomo atandukanye" data-fr="Cours en Vedette" data-lg="Amasomo atandukanye">Featured Courses</h3>
        <p class="sub" data-en="Explore Our Most Popular Classes" data-rw="Reba amasomo atandukanye" data-fr="Explorez Nos Cours Populaires" data-lg="Reba amasomo atandukanye">Explore Our Most Popular Classes</p>

        <div class="courses-grid">
          <article class="course-card">
            <img src="images/html and css.png" alt="HTML & CSS">
            <h4>HTML & CSS</h4>
            <p class="course-desc">Build beautiful, responsive websites</p>
            <a class="btn small" href="#">Learn More</a>
          </article>

          <article class="course-card">
            <img src="images/python.png" alt="Python Programming">
            <h4>Python Programming</h4>
            <p class="course-desc">Learn Python from beginner to advanced</p>
            <a class="btn small" href="#">Learn More</a>
          </article>

          <article class="course-card">
            <img src="images/javap.png" alt="Java Development">
            <h4>Java Development</h4>
            <p class="course-desc">Master Java for software development</p>
            <a class="btn small" href="#">Learn More</a>
          </article>

          <article class="course-card">
            <img src="images/all p.webp" alt="C++ Programming">
            <h4>C++ Programming</h4>
            <p class="course-desc">Discover the powerful C++ language</p>
            <a class="btn small" href="#">Learn More</a>
          </article>
        </div>
      </div>
    </section>

    <!-- Why Learn With Us (video tiles) -->
    <section class="why-learn">
      <div class="container">
        <h3 data-en="Why Learn with Us?" data-rw="Ni inde twiga neza?" data-fr="Pourquoi apprendre avec nous?" data-lg="Ni inde twiga neza?">Why Learn with Us?</h3>

        <div class="video-grid">
          <div class="video-card" data-title="JavaScript Basics" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=coding&video=javascript-basics';">
            <img src="images/video-1.jpg" alt="">
            <div class="play-overlay" aria-hidden="true">▶</div>
            <div class="video-title">JavaScript Basics</div>
          </div>

          <div class="video-card" data-title="Python for Beginners" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=coding&video=python-beginners';">
            <img src="images/video-2.jpg" alt="">
            <div class="play-overlay" aria-hidden="true">▶</div>
            <div class="video-title">Python for Beginners</div>
          </div>

          <div class="video-card" data-title="HTML & CSS Crash Course" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=coding&video=html-css-crash';">
            <img src="images/video-3.jpg" alt="">
            <div class="play-overlay" aria-hidden="true">▶</div>
            <div class="video-title">HTML & CSS Crash Course</div>
          </div>

          <div class="video-card" data-title="Intro to C++" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=coding&video=cpp-intro';">
            <img src="images/video-4.jpg" alt="">
            <div class="play-overlay" aria-hidden="true">▶</div>
            <div class="video-title">Intro to C++</div>
          </div>

          <div class="video-card" data-title="Advanced CSS Tricks" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=coding&video=css-advanced';">
            <img src="images/video-5.jpg" alt="">
            <div class="play-overlay" aria-hidden="true">▶</div>
            <div class="video-title">Advanced CSS Tricks</div>
          </div>

          <div class="video-card" data-title="Python Data Science Tutorial" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=coding&video=python-data-science';">
            <img src="images/video-6.jpg" alt="">
            <div class="play-overlay" aria-hidden="true">▶</div>
            <div class="video-title">Python Data Science Tutorial</div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">
      <p>&copy; <span id="year"></span> CS Dream. All rights reserved.</p>
    </div>
  </footer>

  <script src="auth.js"></script>
  <script src="translations.js"></script>
  <script src="content-data.js"></script>
  <script src="page-content.js"></script>
  <script>
  // Initialize language system
  initializeLanguageSystem();

  // -----------------------
  // Authentication State Management
  // -----------------------
  let isLoggedIn = false;
  let userCredentials = {
    username: null,
    profilePicture: null
  };

  // Update UI based on authentication state
  function updateAuthState(loggedIn, username) {
    isLoggedIn = loggedIn;
    const authLinks = document.getElementById('authLinks');
    const userWidget = document.getElementById('userWidget');
    const loginLink = document.getElementById('loginLink');
    const signupLink = document.getElementById('signupLink');
    const navUsername = document.getElementById('navUsername');
    const navProfilePic = document.getElementById('navProfilePic');

    if (loggedIn && username) {
      // User is logged in
      userCredentials.username = username;
      userCredentials.profilePicture = profilePicFor(username);
      
      // Hide login/signup links
      loginLink.style.display = 'none';
      signupLink.style.display = 'none';
      
      // Show profile widget
      userWidget.classList.remove('hidden');
      navUsername.textContent = username;
      navProfilePic.src = userCredentials.profilePicture;
    } else {
      // User is not logged in
      userCredentials.username = null;
      userCredentials.profilePicture = null;
      
      // Show login/signup links
      loginLink.style.display = 'inline-block';
      signupLink.style.display = 'inline-block';
      
      // Hide profile widget
      userWidget.classList.add('hidden');
      navUsername.textContent = 'Guest';
      navProfilePic.src = 'https://via.placeholder.com/30/00ffff/000000?text=U';
    }
  }

  // Profile menu toggle and logout handling
  (function setupProfileMenu() {
    const userWidgetEl = document.getElementById('userWidget');
    const userMenu = document.getElementById('userMenu');
    const navLogout = document.getElementById('navLogout');

    function closeUserMenu(){
      if(!userMenu) return;
      userMenu.classList.remove('visible');
      userMenu.setAttribute('aria-hidden','true');
      if(userWidgetEl) userWidgetEl.setAttribute('aria-expanded','false');
      userMenu.style.position = '';
      userMenu.style.top = '';
      userMenu.style.left = '';
      userMenu.style.right = '';
      userMenu.style.zIndex = '';
    }

    function openUserMenu(){
      if(!userMenu || !userWidgetEl) return;
      userMenu.style.position = 'fixed';
      userMenu.style.zIndex = '100000';
      userMenu.classList.add('visible');
      userMenu.setAttribute('aria-hidden','false');
      userWidgetEl.setAttribute('aria-expanded','true');

      const rect = userWidgetEl.getBoundingClientRect();
      const menuRect = userMenu.getBoundingClientRect();
      const top = Math.round(rect.bottom + 8);
      let left = Math.round(rect.right - menuRect.width);
      if (left < 8) left = 8;
      userMenu.style.top = top + 'px';
      userMenu.style.left = left + 'px';
      userMenu.style.right = 'auto';
    }

    // Toggle when clicking the widget
    userWidgetEl && userWidgetEl.addEventListener('click', (e)=>{
      e.stopPropagation();
      if(userMenu.classList.contains('visible')) closeUserMenu(); else openUserMenu();
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e)=>{ if(userMenu && !userMenu.contains(e.target)) closeUserMenu(); });

    // Logout handler
    navLogout && navLogout.addEventListener('click', (e)=>{
      e.preventDefault();
      try{ clearSession(); }catch(err){}
      updateAuthState(false, null);
      closeUserMenu();
      alert('Logged out successfully.');
    });
  })();

  // Initialize auth state from session
  (function initAuthFromSession(){
    const session = readSession();
    if(session && session.username){
      userCredentials.profilePicture = profilePicFor(session.username);
      updateAuthState(true, session.username);
    } else {
      updateAuthState(false, null);
    }
  })();

  // -----------------------
  // Page Functionality
  // - sets year
  // - adds a simple click handler for video tiles (open modal simulation)
  // -----------------------
  (function(){
    // Set current year
    document.getElementById('year').textContent = new Date().getFullYear();

    // Simple click-to-alert behavior for video tiles (replace with modal/player as needed)
    var tiles = document.querySelectorAll('.video-card');
    tiles.forEach(function(t){
      t.style.cursor = 'pointer';
      t.addEventListener('click', function(){
        var title = t.getAttribute('data-title') || 'Video';
        alert('Play video: ' + title);
      });
    });
  })();

  // Skeleton loading placeholders
  (function(){
      document.addEventListener('DOMContentLoaded', () => {
          setTimeout(() => {
              document.querySelectorAll('.skeleton-card').forEach(el => el.style.display = 'none');
              document.querySelectorAll('.video-card, .video-item, .news-card').forEach(el => el.style.opacity = '1');
          }, 1500);
      });
      window.addEventListener('load', () => {
          document.querySelectorAll('.skeleton-card').forEach(el => el.style.display = 'none');
          document.querySelectorAll('.video-card, .video-item, .news-card').forEach(el => el.style.opacity = '1');
      });
  })();

  // Global Keyboard Shortcuts
  (function(){
      document.addEventListener('keydown', (e) => {
          // Ctrl+K or / to focus search
          if ((e.ctrlKey && e.key === 'k') || e.key === '/') {
              e.preventDefault();
              const searchInput = document.getElementById('searchInput');
              if (searchInput) { searchInput.focus(); searchInput.select(); }
          }
          // Ctrl+Shift+D to toggle dark mode
          if (e.ctrlKey && e.shiftKey && e.key === 'D') {
              e.preventDefault();
              const modeToggle = document.getElementById('ModeToggle');
              if (modeToggle) { modeToggle.click(); }
          }
          // Alt+H to go home
          if (e.altKey && e.key === 'h') {
            e.preventDefault();
            window.location.href = 'home.php';
          }

          // History navigation: '<' => back, '>' => forward
          // Skip when user is typing in an input/textarea or contenteditable
          const active = document.activeElement;
          const isTyping = active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA' || active.isContentEditable);
          if (!isTyping) {
            if (e.key === '<') {
              e.preventDefault();
              window.history.back();
            }
            if (e.key === '>') {
              e.preventDefault();
              window.history.forward();
            }
          }
      });
  })();
      // Navigation hint (dismissible)
      (function(){
        try { if (localStorage.getItem('historyHintDismissed')) return; } catch(e) {}
        const hint = document.createElement('div');
        hint.className = 'fixed bottom-4 left-4 bg-gray-900 text-white px-4 py-2 rounded shadow z-50';
        hint.style.opacity = '0';
        hint.style.transition = 'opacity 200ms ease';
        hint.innerHTML = `<span>Press '<' to go back, '>' to go forward</span>`;
        const btn = document.createElement('button');
        btn.className = 'ml-3 bg-gray-700 px-2 py-1 rounded text-sm';
        btn.innerText = 'Got it';
        btn.addEventListener('click', () => { try{ localStorage.setItem('historyHintDismissed','1'); }catch(e){}; hint.remove(); });
        hint.appendChild(btn);
        document.addEventListener('DOMContentLoaded', () => { document.body.appendChild(hint); setTimeout(()=> hint.style.opacity='1', 120); });
        if (document.readyState === 'complete' || document.readyState === 'interactive') { document.body.appendChild(hint); setTimeout(()=> hint.style.opacity='1', 120); }
      })();
  </script>
<script src="clock.js" defer></script>
  <!-- Back to Top Button -->
  <button id="backToTop" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
  </button>

  <script>
    // Back to Top Button
    (function(){
        const backToTopBtn = document.getElementById('backToTop');
        
        const scrollToTop = () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
        
        // Show button when scrolled down
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });
        
        // Smooth scroll to top on button click
        backToTopBtn.addEventListener('click', scrollToTop);
        
        // Home key to scroll to top
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Home') {
                e.preventDefault();
                scrollToTop();
            }
        });
    })();
  </script>
</body>
</html>
