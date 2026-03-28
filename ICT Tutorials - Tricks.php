<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<link rel="icon" href="images/cs dream.png" type="image/png">
<title>CS DREAM - ICT Tutorials</title>
<style>
  /* ---------- Base ---------- */
  :root{
    --neon:#00ff66;    /* neon green */
    --muted:#0b0b0b;   /* panel bg */
    --panel-alpha:0.14;/* panel transparency */
    --glass-blur:6px;
    --accent:#7fffd4;
    --text:#d9ffd7;
  }
  html,body{height:100%;margin:0;padding:0;font-family:Inter, "Segoe UI", Roboto, Arial, monospace;background:transparent;color:var(--text);-webkit-font-smoothing:antialiased;}
  body{display:flex;flex-direction:column;min-height:100vh;position:relative;overflow-x:hidden;}

  /* ---------- MATRIX CANVAS (background) ---------- */
  #matrixCanvas{
    position:fixed;inset:0;width:100%;height:100%;z-index:-2;background:#000;
    will-change:transform;
  }

  /* optional faint overlay to soften contrast */
  .matrix-overlay{
    position:fixed;inset:0;z-index:-1;pointer-events:none;
    background:linear-gradient(180deg, rgba(0,0,0,0.30), rgba(0,0,0,0.55));
  }

  /* ---------- Top scroll bar ---------- */
  .scroll-text{
    background:rgba(8,8,8,0.45);
    color:var(--neon);
    padding:8px 12px;
    animation:scroll 15s linear infinite;
    backdrop-filter: blur(var(--glass-blur));
    border-bottom:1px solid rgba(0,255,102,0.06);
    font-weight:600;
    letter-spacing:0.3px;
  }
  @keyframes scroll{0%{transform:translateX(100%);}100%{transform:translateX(-100%);}}

  /* ---------- Header / top-tools (glass panel) ---------- */
  header{z-index:100;position:relative;}
  .top-tools{
    display:flex;align-items:center;justify-content:flex-end;gap:12px;padding:10px 16px;
    background:linear-gradient(180deg, rgba(3,3,3,var(--panel-alpha)), rgba(3,3,3,0.08));
    backdrop-filter: blur(var(--glass-blur));
    border-bottom:1px solid rgba(0,255,102,0.06);
  }
  .top-tools select, .top-tools input{
    background:rgba(0,0,0,0.35);color:var(--text);border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;outline:none;
  }
  .dark-mode-switch{display:flex;align-items:center;gap:10px;color:var(--neon);font-weight:600;}
  .hamburger-icon{position:relative;left:10px;top:0;cursor:pointer;display:flex;flex-direction:column;gap:4px;z-index:1200}
  .hamburger-icon div{width:26px;height:3px;background:var(--neon);opacity:0.9;border-radius:2px;box-shadow:0 0 6px rgba(0,255,102,0.12);}

  /* matrix toggle button */
  .matrix-toggle{
    display:inline-flex;align-items:center;gap:8px;padding:6px 10px;border-radius:8px;background:transparent;border:1px solid rgba(0,255,102,0.08);color:var(--neon);cursor:pointer;
  }

  /* ---------- Navigation (center) ---------- */
  .nav-container{
    display:flex;justify-content:center;gap:28px;padding:10px 0;
    background:transparent;
    margin-top:6px;
  }
  .nav-container a{
    color:var(--neon);text-decoration:none;font-weight:700;padding:8px 14px;border-radius:8px;transition:all .25s cubic-bezier(0.4, 0, 0.2, 1);
    text-shadow:0 0 6px rgba(0,255,102,0.06);position:relative;display:inline-block;
  }
  .nav-container a::after{
    content:'';position:absolute;bottom:0;left:50%;width:0;height:2px;background:linear-gradient(90deg, transparent, var(--neon), transparent);transition:all .3s ease;transform:translateX(-50%);
  }
  .nav-container a:hover{
    color:#fff;background:rgba(0,255,102,0.08);box-shadow:0 6px 20px rgba(0,255,102,0.15);transform:translateY(-3px);text-shadow:0 0 12px rgba(0,255,102,0.3);
  }
  .nav-container a:hover::after{
    width:80%;bottom:2px;
  }

  .dropdown{
    position:absolute;top:calc(100% + 10px);left:0;display:none;background:linear-gradient(135deg, rgba(10,10,10,0.95), rgba(20,20,20,0.9));backdrop-filter:blur(var(--glass-blur));
    border-radius:12px;padding:8px;min-width:200px;box-shadow:0 12px 40px rgba(0,255,102,0.15);border:1px solid rgba(0,255,102,0.2);
    animation:dropdownSlide .25s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  @keyframes dropdownSlide{
    0%{opacity:0;transform:translateY(-12px);}
    100%{opacity:1;transform:translateY(0);}
  }
  .nav-item{position:relative;}
  .nav-item:hover>.dropdown{display:flex;flex-direction:column;gap:0;}

  .dropdown a{
    color:var(--text);padding:12px 14px;font-weight:600;border-radius:6px;transition:all .2s;display:block;position:relative;overflow:hidden;
  }
  .dropdown a::before{
    content:'';position:absolute;left:0;top:0;width:3px;height:100%;background:linear-gradient(180deg, var(--neon), var(--accent));opacity:0;transition:opacity .2s;
  }
  .dropdown a:hover{
    background:rgba(0,255,102,0.12);color:#fff;padding-left:18px;box-shadow:0 4px 12px rgba(0,255,102,0.2);
  }
  .dropdown a:hover::before{
    opacity:1;
  }

  /* ---------- Layout: container / sidebar / content ---------- */
  .container{display:flex;gap:20px;margin:18px;padding:8px;align-items:flex-start;}
  .sidebar{
    width:260px;background:linear-gradient(135deg, rgba(2,2,2,0.45), rgba(2,2,2,0.25));
    color:var(--text);padding:16px;border-radius:16px;border:1.5px solid rgba(0,255,102,0.1);backdrop-filter:blur(var(--glass-blur));
    box-shadow:0 12px 40px rgba(0,0,0,0.6);transition:all .3s;
  }
  .sidebar:hover{
    border-color:rgba(0,255,102,0.2);box-shadow:0 15px 50px rgba(0,255,102,0.15);
  }

  .sidebar h3{
    color:var(--neon);margin:12px 0 10px 0;font-size:15px;text-transform:uppercase;letter-spacing:1px;font-weight:700;
  }
  .sidebar a{
    display:block;color:var(--text);padding:10px 12px;border-radius:8px;text-decoration:none;margin:6px 0;font-weight:600;transition:all .25s;position:relative;overflow:hidden;
  }
  .sidebar a::before{
    content:'';position:absolute;left:0;top:0;width:3px;height:100%;background:var(--neon);transform:scaleY(0);transition:transform .2s;transform-origin:top;
  }
  .sidebar a:hover{
    background:rgba(0,255,102,0.08);color:var(--neon);box-shadow:0 4px 12px rgba(0,255,102,0.15);padding-left:16px;
  }
  .sidebar a:hover::before{
    transform:scaleY(1);
  }

  .content{
    flex:1;background:linear-gradient(180deg, rgba(0,0,0,0.28), rgba(0,0,0,0.08));
    padding:16px;border-radius:12px;border:1px solid rgba(0,255,102,0.04);backdrop-filter:blur(var(--glass-blur));
    box-shadow:0 10px 30px rgba(0,0,0,0.45);
  }
  .content h2{color:var(--neon);margin-top:0;text-shadow:0 0 8px rgba(0,255,102,0.06);}

  .video-card{
    background:linear-gradient(135deg, rgba(0,255,102,0.02), rgba(127,255,212,0.01));border-radius:16px;padding:0;overflow:hidden;border:1.5px solid rgba(0,255,102,0.06);
    transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);position:relative;isolation:isolate;
  }
  .video-card::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.1), rgba(127,255,212,0.05));opacity:0;transition:opacity .3s;z-index:-1;
  }
  .video-card:hover{
    transform:translateY(-8px) scale(1.02);box-shadow:0 20px 50px rgba(0,255,102,0.25);border-color:rgba(0,255,102,0.15);
  }
  .video-card:hover::before {
    opacity:1;
  }

  .video-card h4{
    background:linear-gradient(90deg, rgba(0,0,0,0.7), rgba(0,0,0,0.4));color:var(--neon);font-weight:700;margin:0;padding:12px 14px;font-size:0.95rem;transition:all .3s;
  }

  /* ---------- Footer ---------- */
  footer{
    margin-top:auto;padding:18px;text-align:center;background:linear-gradient(180deg, rgba(0,0,0,0.5), rgba(2,2,2,0.2));
    color:var(--text);border-top:2px solid rgba(0,255,102,0.1);backdrop-filter:blur(var(--glass-blur));
    transition:all .3s;
  }
  footer:hover{
    background:linear-gradient(180deg, rgba(0,0,0,0.6), rgba(2,2,2,0.3));border-top-color:rgba(0,255,102,0.2);
  }
  footer p{
    margin:0;letter-spacing:0.5px;font-weight:500;
  }

  /* ---------- Sidebar menu (hidden panel) ---------- */
  .sidebar-menu{height:100%;width:260px;background:linear-gradient(180deg, rgba(2,2,2,0.56), rgba(2,2,2,0.18));position:fixed;top:0;left:-280px;transition:left .35s;z-index:1200;padding-top:60px;border-right:1px solid rgba(0,255,102,0.04);}
  .sidebar-menu.active{left:0;}
  .sidebar-menu a{color:var(--text);padding:12px 18px;display:block;text-decoration:none;}
  .sidebar-menu .close-btn{position:absolute;top:10px;right:14px;color:var(--neon);font-size:22px;cursor:pointer;}

  /* ---------- Misc small responsive ---------- */
  @media (max-width:900px){
    .container{flex-direction:column;padding:12px;}
    .sidebar{width:100%;}
    .content{width:100%;}
    .sidebar-menu{width:220px;}
  }

  /* Auth Links & User Profile Widget */
  .nav-right {
    margin-left: auto;
    display: flex;
    gap: 15px;
    align-items: center;
  }
  
  .nav-right a {
    color: var(--neon);
    text-decoration: none;
    font-weight: bold;
    padding: 6px 12px;
    border-radius: 6px;
    transition: 0.3s;
    background: none;
  }
  
  .nav-right a:hover {
    background: rgba(0,255,102,0.1);
    color: #fff;
  }
  
  .user-profile-widget {
    display: flex;
    align-items: center;
    color: white;
    font-weight: 700;
    cursor: pointer;
    gap: 8px;
    margin-left: auto;
    padding: 4px 8px;
    border-radius: 14px;
    transition: background 0.2s;
    font-size: 14px;
    position: relative;
  }
  
  .user-profile-widget:hover {
    background: rgba(0,255,102,0.08);
  }
  
  .profile-pic {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #444;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 2px solid var(--neon);
    box-shadow: 0 0 5px rgba(0,255,102,0.3);
  }
  
  .profile-pic img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .user-menu {
    position: absolute;
    right: 6px;
    top: calc(100% + 8px);
    background: rgba(10, 10, 10, 0.95);
    color: var(--neon);
    border-radius: 8px;
    box-shadow: 0 8px 20px rgba(0,255,102,0.1);
    min-width: 140px;
    display: none;
    flex-direction: column;
    z-index: 4000;
    overflow: hidden;
    border: 1px solid rgba(0,255,102,0.2);
  }
  
  /* --- Skeleton Loading Placeholders --- */
  .skeleton { background: linear-gradient(90deg, #222 25%, #333 50%, #222 75%); background-size: 200% 100%; animation: shimmer 2s infinite; }
  @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
  .skeleton-card { width: 100%; height: 260px; border-radius: 16px; margin-bottom: 12px; }
  .skeleton-thumb { width: 100%; height: 200px; border-radius: 8px; margin-bottom: 8px; }
  .skeleton-title { width: 80%; height: 16px; border-radius: 4px; margin-bottom: 8px; }
  .skeleton-text { width: 60%; height: 12px; border-radius: 4px; margin-bottom: 6px; }
  .skeleton-buttons { display: flex; gap: 8px; height: 32px; }
  .skeleton-btn { flex: 1; height: 100%; border-radius: 6px; }

  .user-menu a {
    display: block;
    padding: 8px 12px;
    text-decoration: none;
    color: var(--neon);
    font-weight: 600;
  }
  
  .user-menu a:hover { 
    background: rgba(0,255,102,0.1); 
  }
  
  .user-menu.visible { 
    display: flex; 
  }
  
  .hidden {
    display: none !important;
  }

  /* WhatsApp button */
.whatsapp-btn {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background: #25D366; /* WhatsApp green */
  color: white;
  font-size: 28px; /* bigger */
  width: 64px;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  text-decoration: none;
  z-index: 1500; /* above content and dropdowns */
  box-shadow: 0 4px 20px rgba(0,0,0,0.4);
  animation: vibrate 1.2s infinite, glow 2.5s infinite alternate;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.whatsapp-btn:hover {
  transform: scale(1.15);
  box-shadow: 0 6px 28px rgba(0,0,0,0.5);
}

@keyframes vibrate {
  0%{transform:translate(0);}
  20%{transform:translate(-2px,2px);}
  40%{transform:translate(-2px,-2px);}
  60%{transform:translate(2px,2px);}
  80%{transform:translate(2px,-2px);}
  100%{transform:translate(0);}
}

@keyframes glow {
  0%{box-shadow:0 0 10px rgba(37,211,102,0.5);}
  100%{box-shadow:0 0 25px rgba(37,211,102,0.9);}
}

/* ---------- HERO / Showcase (new) ---------- */
.hero{
  position:relative;min-height:72vh;display:flex;align-items:center;padding:48px 60px;gap:40px;z-index:10;pointer-events:auto;
}
    .hero .hero-bg{display:none}
    .hero .hero-overlay{position:absolute;inset:0;background:linear-gradient(90deg, rgba(0,0,0,0.28) 0%, rgba(0,0,0,0.12) 60%);z-index:0}
.hero-meta{max-width:520px;color:var(--text);z-index:2}
  .hero-meta h1{
    font-size:56px;margin:0 0 12px;color:#fff;text-shadow:0 6px 30px rgba(0,0,0,0.6);
    background:linear-gradient(135deg, #fff, var(--neon), var(--accent));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    animation:gradientShift 4s ease-in-out infinite;transition:all .3s;
  }
  @keyframes gradientShift{
    0%{filter:hue-rotate(0deg);}
    50%{filter:hue-rotate(10deg);}
    100%{filter:hue-rotate(0deg);}
  }
.meta-row{display:flex;align-items:center;gap:12px;margin-bottom:14px}
.badge{background:var(--neon);color:#05220f;padding:6px 10px;border-radius:6px;font-weight:800}
.muted{color:rgba(255,255,255,0.75);font-weight:600}
.hero-meta p{color:rgba(255,255,255,0.82);line-height:1.45;margin-bottom:18px}
.hero-ctas{display:flex;gap:12px}
.btn{
  padding:14px 24px;border-radius:10px;font-weight:800;border:none;cursor:pointer;transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);position:relative;overflow:hidden;
}
.btn::before{
  content:'';position:absolute;inset:0;background:linear-gradient(135deg, transparent, rgba(255,255,255,0.2), transparent);transform:translateX(-100%);transition:transform .4s;
}
.btn:hover::before{
  transform:translateX(100%);
}
.btn.watch{
  background:linear-gradient(135deg, #ff3b2f, #ff5555);color:#fff;box-shadow:0 12px 35px rgba(255,59,47,0.3);transform:translateY(0);
}
.btn.watch:hover{
  transform:translateY(-4px);box-shadow:0 18px 45px rgba(255,59,47,0.45);letter-spacing:0.5px;
}
.btn.list{
  background:transparent;color:var(--text);border:1.5px solid rgba(0,255,102,0.3);transition:all .3s;
}
.btn.list:hover{
  background:rgba(0,255,102,0.1);border-color:rgba(0,255,102,0.6);color:#fff;transform:translateY(-4px);box-shadow:0 8px 25px rgba(0,255,102,0.2);
}
.watch-trailer{position:absolute;left:28px;bottom:28px;display:flex;align-items:center;gap:10px;color:var(--text);z-index:3}
.watch-trailer .play{width:44px;height:44px;border-radius:50%;border:2px solid rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center}

.hero-right{flex:1;display:flex;justify-content:center;align-items:center;z-index:2}
  .cards-panel{
    width:640px;height:260px;background:linear-gradient(135deg, rgba(3,3,3,0.55), rgba(3,3,3,0.35));backdrop-filter:blur(16px);border-radius:16px;padding:32px;border:1.5px solid rgba(0,255,102,0.1);
    box-shadow:0 25px 70px rgba(0,0,0,0.7);transition:all .3s;position:relative;overflow:hidden;
  }
  .cards-panel::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.05), transparent);opacity:0;transition:opacity .3s;
  }
  .cards-panel:hover{
    border-color:rgba(0,255,102,0.2);box-shadow:0 35px 90px rgba(0,255,102,0.2);
  }
  .cards-panel:hover::before{
    opacity:1;
  }
.poster-row{display:flex;gap:16px;align-items:center;justify-content:center}
.poster{
  width:150px;height:210px;border-radius:14px;background:#111;background-size:cover;background-position:center;box-shadow:0 12px 40px rgba(0,0,0,0.7);transform:scale(0.95) rotateY(-5deg);transition:all .35s cubic-bezier(0.34, 1.56, 0.64, 1);
  border:2px solid rgba(0,255,102,0.1);position:relative;overflow:hidden;cursor:pointer;
}
.poster::after{
  content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.2), transparent);opacity:0;transition:opacity .3s;
}
.poster.center{
  width:200px;height:260px;transform:scale(1.08) rotateY(0deg);box-shadow:0 30px 80px rgba(0,255,102,0.3);border-color:rgba(0,255,102,0.3);
}
.poster:hover{
  transform:scale(1.05) rotateY(8deg);box-shadow:0 20px 60px rgba(0,255,102,0.4);border-color:rgba(0,255,102,0.4);
}
.poster:hover::after{
  opacity:1;
}
.poster.center:hover{
  transform:scale(1.12) rotateY(0deg);box-shadow:0 40px 100px rgba(0,255,102,0.4);
}

@media (max-width:900px){
  .hero{flex-direction:column;padding:28px}
  .hero-meta h1{font-size:36px}
  .cards-panel{width:92%;height:220px}
}

<!-- Floating Back to Top Button */
#backToTop {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #fff;
    box-shadow: 0 8px 30px rgba(255, 107, 107, 0.4);
    z-index: 999;
    transition: all 0.3s ease;
}
#backToTop:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(255, 107, 107, 0.6);
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

  <!-- MATRIX CANVAS -->
  <canvas id="matrixCanvas"></canvas>
  <div class="matrix-overlay"></div>

  <!-- SCROLL TEXT -->
  <div class="scroll-text" data-en="Welcome to CS DREAM - Technology, Coding & Hack tricks"
       data-rw="Murakaza neza kuri CS DREAM - Ikoranabuhanga, Coding & Hack tricks"
       data-fr="Bienvenue à CS DREAM - Technologie, Codage & Astuces"
       data-lg="Tukusanyire ku CS DREAM - Technology, Coding & Hack tricks">
    Welcome to CS DREAM - Technology, Coding & Hack tricks
  </div>

  <!-- HEADER + TOP-TOOLS -->
  <header>
    <div class="top-tools">
      <select id="languageSelect">
        <option value="en">English</option>
        <option value="rw">Kinyarwanda</option>
        <option value="fr">French</option>
        <option value="lg">Luganda</option>
      </select>

      <input id="searchInput" type="text" placeholder="Search videos..." data-en="Search videos..." data-rw="Shakisha videwo..." data-fr="Rechercher des vidéos..." data-lg="Sanga Video...">

      <div class="dark-mode-switch">
        <label class="switch"><input id="ModeToggle" type="checkbox"><span class="slider round"></span></label>
        <span data-en="Dark Mode" data-rw="Dark Mode" data-fr="Mode Sombre" data-lg="Dark Mode">Dark Mode</span>
      </div>

      <button id="matrixToggleBtn" class="matrix-toggle" title="Toggle Matrix background">Matrix: <strong id="matrixState">On</strong></button>

      <div id="hamburgerBtn" class="hamburger-icon" aria-label="Open menu" title="Open menu">
        <div></div><div></div><div></div>
      </div>

      <div class="nav-right" id="authLinks">
        <a id="loginLink" href="login.php">Login</a>
        <a id="signupLink" href="register.php">Sign Up</a>
      </div>
      
      <div class="user-profile-widget hidden" id="userWidget" tabindex="0" aria-haspopup="true" aria-expanded="false">
        <div class="profile-pic">
          <img id="navProfilePic" src="https://via.placeholder.com/30/00ff66/000000?text=U" alt="Profile">
        </div>
        <span id="navUsername">Guest</span>
        <div class="user-menu" id="userMenu" role="menu" aria-hidden="true">
          <a href="setting.php" id="navProfileSettings" role="menuitem">Settings</a>
          <a href="#" id="navLogout" role="menuitem">Logout</a>
        </div>
      </div>
    </div>

    <nav class="nav-container" aria-label="Main navigation">
      <div class="nav-item"><a href="home.php" data-en="" data-rw="Ahabanza" data-fr="Accueil" data-lg="Oludda">Home</a></div>

      <div class="nav-item">
        <a href="#" data-en="News ▾" data-rw="Ibibazo ▾" data-fr="Actualités ▾" data-lg="Okutegeeza ▾">📰 News ▾</a>
        <div class="dropdown">
          <a href="#" data-en="School News" data-rw="Ibibazo by'Ishuri" data-fr="Actualités Scolaires" data-lg="Okutegeeza kwa Shuli">🎓 School News</a>
          <a href="#" data-en="Technology News" data-rw="Ibibazo by'Ikoranabuhanga" data-fr="Actualités Technologiques" data-lg="Okutegeeza okw'Ikoranabuhanga">💻 Technology News</a>
          <a href="#" data-en="Entertainment News" data-rw="Ibibazo by'Icyitegererezo" data-fr="Actualités Divertissement" data-lg="Okutegeeza kw'Okukubaganya">🎬 Entertainment News</a>
          <a href="#" data-en="World News" data-rw="Ibibazo by'Isi yose" data-fr="Actualités Mondiales" data-lg="Okutegeeza kwa Nsi yonna">🌍 World News</a>
        </div>
      </div>

      <div class="nav-item">
        <a href="#" data-en="Hack tricks ▾" data-rw="Ubuhanga ▾" data-fr="Astuces ▾" data-lg="Hack tricks ▾">Hack tricks ▾</a>
        <div class="dropdown">
          <a href="#" data-en="Telephone" data-rw="Telefoni" data-fr="Téléphone" data-lg="Telephone">Telephone</a>
          <a href="#" data-en="Applications" data-rw="Porogaramu" data-fr="Applications" data-lg="Applications">Applications</a>
          <a href="#" data-en="Computer tricks" data-rw="Ubuhanga bwa mudasobwa" data-fr="Astuces informatiques" data-lg="Computer tricks">Computer tricks</a>
          <a href="#" data-en="Computer tricks" data-rw="Ubuhanga bwa mudasobwa" data-fr="Astuces informatiques" data-lg="Computer tricks">All Combined</a>
        </div>
      </div>

      <div class="nav-item">
        <a href="#" data-en="Coding ▾" data-rw="Kwandika ▾" data-fr="Codage ▾" data-lg="Coding ▾">Coding ▾</a>
        <div class="dropdown">
          <a href="" data-en="ALL Combined" data-rw="Byose Hamwe" data-fr="JAVA" data-lg="JAVA">ALL Combined</a>
          <a href="#" data-en="C++" data-rw="C++" data-fr="C++" data-lg="C++">C++</a>
          <a href="#" data-en="HTML" data-rw="HTML" data-fr="HTML" data-lg="HTML">HTML</a>
          <a href="#" data-en="CSS" data-rw="CSS" data-fr="CSS" data-lg="CSS">CSS</a>
          <a href="#" data-en="HTML4&5" data-rw="HTML4&5" data-fr="HTML5" data-lg="HTML5">HTML5</a>
          <a href="#" data-en="HTML and CSS" data-rw="HTML na CSS" data-fr="HTML et CSS" data-lg="HTML and CSS">HTML and CSS</a>
          <a href="#" data-en="JAVA" data-rw="JAVA" data-fr="JAVA" data-lg="JAVA">JAVA</a>
        </div>
      </div>
    </nav>
  </header>

  <!-- LEFT SIDEBAR MENU (hidden by default) -->
  <div class="sidebar-menu" id="sidebarMenu" aria-hidden="true">
    <span class="close-btn" id="closeBtn">✖</span>

    <a href="home.php" data-en="Home" data-rw="Ahabanza" data-fr="Accueil" data-lg="Oludda">🏠 Home</a>

    <div class="sidebar-item">
      <a href="#" class="sidebar-toggle">📰 News ▾</a>
      <div class="sidebar-submenu">
        <a href="#">🎓 School News</a>
        <a href="#">💻 Technology News</a>
        <a href="#">🎬 Entertainment News</a>
        <a href="#">🌍 World News</a>
      </div>
    </div>

    <div class="sidebar-item">
      <a href="#" class="sidebar-toggle">Hack tricks ▾</a>
      <div class="sidebar-submenu">
        <a href="#">Telephone</a>
        <a href="#">Applications</a>
        <a href="#">Computer tricks</a>
      </div>
    </div>

    <div class="sidebar-item">
      <a href="#" class="sidebar-toggle">Coding ▾</a>
      <div class="sidebar-submenu">
        <a href="#">All CODING Platiform</a>
        <a href="#">C++</a>
        <a href="#">HTML</a>
        <a href="#">CSS</a>
        
      </div>
    </div>

    <a href="about.php">About</a>
    <a href="service.php">Services</a>
    <a href="contact.php">Contact</a>

    <h3 style="color:var(--neon);padding:10px 18px;margin:0;">Search</h3>
    <input id="sidebarSearch" type="text" placeholder="Search..." style="margin:10px;padding:8px;border-radius:6px;border:1px solid rgba(255,255,255,0.04);width:88%;color:var(--text);background:rgba(0,0,0,0.25)">

    <h3 style="color:var(--neon);padding:10px 18px;margin:0;">Connect</h3>
    <a href="https://wa.me/250795647344" target="_blank">WhatsApp</a>
    <a href="mailto:irumvakevin@19gmail.com">Email</a>
    <a href="#">YouTube</a>
    <a href="#">Facebook</a>
  </div>

  <!-- MAIN HERO SHOWCASE -->
  <section class="hero" aria-label="Showcase">
    <div class="hero-overlay"></div>

    <div class="hero-meta">
      <h1>65 <span style="font-weight:700;color:rgba(255,255,255,0.75);font-size:28px;margin-left:10px;">Hack tricks Videos</span></h1>
      <div class="meta-row">
        <div class="muted">2025</div>
        <div class="badge">5+</div>
       
      </div>

      <p> These are new videos I just uploaded. Click here on Watch or +List to see them all and enjoy, from CS Dream.
</p>

      <div class="hero-ctas">
        <a class="btn watch" href="ICT Tutorials.php" role="button">▶ WATCH</a>
        <a class="btn list" href="ICT Tutorials.php" role="button">+ MY LIST</a>
      </div>
    
      <div class="watch-trailer" aria-hidden="false">
        <div class="play">▶</div>
        <div class="muted">WATCH TRAILER</div>
      </div>
    </div>

    <div class="hero-right">
      <div class="cards-panel" role="region" aria-label="Recommendations">
        <div class="poster-row">
          <div class="poster" data-slot="1" style="background-image:url('https://via.placeholder.com/320x420/111/00ff66?text=Waiting+for+upload');"></div>
          <div class="poster center" data-slot="2" style="background-image:url('https://via.placeholder.com/320x420/111/00ff66?text=Waiting+for+upload');"></div>
          <div class="poster" data-slot="3" style="background-image:url('https://via.placeholder.com/320x420/111/00ff66?text=Waiting+for+upload');"></div>
          <div class="poster" data-slot="4" style="background-image:url('https://via.placeholder.com/320x420/111/00ff66?text=Waiting+for+upload');"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- HACK TRICKS VIDEO GRID REMOVED: using only the 4 hero cards now -->

  <!-- WhatsApp floating button -->
  <a href="https://wa.me/250795647344" class="whatsapp-btn" title="Chat on WhatsApp">💬</a>

  <!-- Footer -->
  <footer>
    <p>© 2025 CS DREAM. All Rights Reserved.</p>
  </footer>

<script src="auth.js"></script>
<script src="content-data.js"></script>
<script src="page-content.js"></script>
<script>
// Initialize hack videos on page load
window.addEventListener('DOMContentLoaded', async () => {
  await renderHackVideosOnTricksPage();
  setInterval(updateTimeAgoFields, 60000);
  
  // Watch for content changes from admin dashboard
  onContentChange(async () => {
    await renderHackVideosOnTricksPage();
  });
});

// Render hack videos specifically for hack tricks page - always show the latest 4
async function renderHackVideosOnTricksPage() {
  const hackVideos = getLatestHackVideos(4);

  const heroPosters = document.querySelectorAll('.hero-right .poster-row .poster');
  if (!heroPosters || heroPosters.length === 0) return;

  for (let index = 0; index < heroPosters.length; index++) {
    const poster = heroPosters[index];
    const video = hackVideos[index];
    if (!video) {
      // keep default hero images if no uploaded video
      poster.style.backgroundImage = poster.style.backgroundImage || 'url(https://via.placeholder.com/320x420?text=Waiting)';
      poster.innerHTML = `<div style="position:absolute;bottom:10px;left:10px;color:rgba(255,255,255,0.8);font-size:0.78rem">Waiting for video #${index + 1}</div>`;
      poster.style.cursor = 'default';
      poster.onclick = null;
      continue;
    }

    // Get blob URL for stored thumbnails
    let thumbnailUrl = video.thumbnailUrl || 'https://via.placeholder.com/320x420?text=No+Thumbnail';
    if (thumbnailUrl && thumbnailUrl.startsWith('uploads/')) {
      thumbnailUrl = await getFileUrl(thumbnailUrl);
    }

    poster.style.backgroundImage = `url('${thumbnailUrl}')`;
    poster.style.backgroundSize = 'cover';
    poster.style.backgroundPosition = 'center';
    poster.style.backgroundRepeat = 'no-repeat';
    poster.style.position = 'relative';
    poster.innerHTML = `
      <div style="position:absolute;left:0;bottom:0;width:100%;background:linear-gradient(180deg,rgba(0,0,0,0) 0%,rgba(0,0,0,0.75) 100%);padding:8px;">
        <h4 style="margin:0;font-size:0.95rem;color:#00ff9e;line-height:1.1;">${video.title || 'New Hack Video'}</h4>
        <span style="font-size:0.75rem;color:#c8e7ff;">Updated hack video</span>
      </div>
    `;

    poster.style.cursor = 'pointer';
    poster.onclick = () => {
      const params = new URLSearchParams({
        video: video.videoUrl || '',
        title: video.title || '',
        category: video.category || '',
        description: video.description || '',
        uploadDate: formatUploadTime(video.uploadTimestamp),
        views: video.views || 0,
        duration: video.duration || '00:00',
        page: video.page || 'hack'
      });
      const targetPlayer = 'video-player-2.php';
      window.location.href = `${targetPlayer}?${params.toString()}`;
    };
  }

  // no additional grid needed; all content shown with hero poster cards
}
/* ---------- MATRIX script (requestAnimationFrame, toggleable) ---------- */
(function(){
  const canvas = document.getElementById('matrixCanvas');
  const ctx = canvas.getContext('2d');
  let running = true;

  function resize(){
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%&*';
  const fontSize = 16;
  let columns = Math.floor(canvas.width / fontSize);
  let drops = new Array(columns).fill(1);

  function resetCols(){
    const newCols = Math.floor(canvas.width / fontSize);
    if(newCols !== columns){
      columns = newCols;
      drops = new Array(columns).fill(1);
    }
  }

  // draw frame
  function draw(){
    resetCols();
    // trail effect
    ctx.fillStyle = 'rgba(0,0,0,0.06)';
    ctx.fillRect(0,0,canvas.width,canvas.height);

    ctx.fillStyle = '#0F0';
    ctx.font = fontSize + 'px monospace';

    for(let i=0;i<drops.length;i++){
      const ch = letters.charAt(Math.floor(Math.random()*letters.length));
      ctx.fillText(ch, i*fontSize, drops[i]*fontSize);
      if(drops[i]*fontSize > canvas.height && Math.random()>0.98) drops[i]=0;
      drops[i]++;
    }
  }

  let last = 0;
  const fpsInterval = 1000/30;
  function frame(now){
    if(!running) return;
    requestAnimationFrame(frame);
    const elapsed = now - last;
    if(elapsed > fpsInterval){
      last = now - (elapsed % fpsInterval);
      draw();
    }
  }
  requestAnimationFrame(frame);

  // toggle button
  const matrixBtn = document.getElementById('matrixToggleBtn');
  const stateEl = document.getElementById('matrixState');
  matrixBtn.addEventListener('click', ()=>{
    running = !running;
    if(running){
      stateEl.textContent = 'On';
      // restart loop
      requestAnimationFrame((t)=>{ last = t; frame(t); });
      canvas.style.opacity = '1';
    } else {
      stateEl.textContent = 'Off';
      // clear canvas and stop drawing
      ctx.clearRect(0,0,canvas.width,canvas.height);
      canvas.style.opacity = '0.0';
    }
  });
})();

/* ---------- UI scripts (unchanged behavior) ---------- */
// Auth state
let isLoggedIn = false;
let userCredentials = {
  username: null,
  email: null,
  password: null,
  profilePicture: "https://via.placeholder.com/30/00ff66/000000?text=U"
};

// DOM Elements
const authLinks = document.getElementById('authLinks');
const userWidget = document.getElementById('userWidget');
const navUsername = document.getElementById('navUsername');
const navProfilePic = document.getElementById('navProfilePic');
const navLogout = document.getElementById('navLogout');
const userWidgetEl = document.getElementById('userWidget');
const userMenu = document.getElementById('userMenu');

// Update auth state
function updateAuthState(loggedIn, username) {
  isLoggedIn = loggedIn;
  if (loggedIn) {
    authLinks.classList.add('hidden');
    userWidget.classList.remove('hidden');
    navUsername.textContent = username;
    navProfilePic.src = userCredentials.profilePicture;
  } else {
    authLinks.classList.remove('hidden');
    userWidget.classList.add('hidden');
  }
}

// User menu toggle
function closeUserMenu() {
  if(userMenu) userMenu.classList.remove('visible');
  if(userWidgetEl) userWidgetEl.setAttribute('aria-expanded','false');
  if(userMenu) userMenu.setAttribute('aria-hidden','true');
}

function openUserMenu() {
  if(userMenu) userMenu.classList.add('visible');
  if(userWidgetEl) userWidgetEl.setAttribute('aria-expanded','true');
  if(userMenu) userMenu.setAttribute('aria-hidden','false');
}

// Toggle when clicking the header widget
userWidgetEl && userWidgetEl.addEventListener('click', (e)=>{
  e.stopPropagation();
  if(userMenu.classList.contains('visible')) closeUserMenu(); else openUserMenu();
});

// Close the menu when clicking outside
document.addEventListener('click', (e)=>{ if(userMenu && !userMenu.contains(e.target)) closeUserMenu(); });

// Logout from the header menu
navLogout && navLogout.addEventListener('click', (e)=>{
  e.preventDefault();
  try{ clearSession(); }catch(err){}
  updateAuthState(false, null);
  closeUserMenu();
  alert('Logged out successfully.');
});

// Initialize auth from session on page load
(function initAuthFromSession(){
  const session = readSession();
  if(session && session.username){
    userCredentials.profilePicture = profilePicFor(session.username);
    updateAuthState(true, session.username);
  } else {
    updateAuthState(false, null);
  }
})();

// Sidebar open/close
document.getElementById('hamburgerBtn').addEventListener('click',()=>document.getElementById('sidebarMenu').classList.add('active'));
document.getElementById('closeBtn').addEventListener('click',()=>document.getElementById('sidebarMenu').classList.remove('active'));

// Dark mode toggle
document.getElementById('darkModeToggle').addEventListener('change', ()=>document.body.classList.toggle('dark-mode'));

// Video search
document.getElementById('searchInput').addEventListener('input', ()=>{ 
  const val = document.getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.video-card').forEach(card=>{
    card.style.display = card.getAttribute('data-title').toLowerCase().includes(val) ? 'block' : 'none';
  });
});

// Sidebar submenu toggles
document.querySelectorAll('.sidebar-toggle').forEach(toggle=>{
  toggle.addEventListener('click',(e)=>{
    e.preventDefault();
    const submenu = toggle.nextElementSibling;
    submenu.style.display = (submenu.style.display === 'flex') ? 'none' : 'flex';
  });
});

// Sidebar search
document.getElementById('sidebarSearch').addEventListener('input', function(){
  const val = this.value.toLowerCase();
  document.querySelectorAll('.sidebar-submenu a, .sidebar-menu> a').forEach(item=>{
    item.style.display = item.textContent.toLowerCase().includes(val) ? 'block' : 'none';
  });
});

// Language switcher
document.getElementById('languageSelect').addEventListener('change', function(){
  const lang = this.value;
  document.querySelectorAll('[data-en]').forEach(el=>{
    el.textContent = el.getAttribute(`data-${lang}`);
  });
});

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

