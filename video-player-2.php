<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/cs dream.png" type="image/png">
  <title>CS DREAM - Video Player</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Lora:wght@400;700&display=swap" rel="stylesheet">
  
  <style>
    * { box-sizing: border-box; }
    html, body { height: 100%; margin: 0; padding: 0; }
    
    body {
      font-family: "Montserrat", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color: #d9f8d9;
      background-color: #04120b;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      animation: fadeInBody 0.6s ease-in-out;
    }

    @keyframes fadeInBody {
      from {
        opacity: 0;
        background-color: #020605;
      }
      to {
        opacity: 1;
        background-color: #04120b;
      }
    }

    /* Matrix background effect */
    body::before {
      content: "";
      position: fixed;
      inset: 0;
      background: 
        radial-gradient(circle at 10% 20%, rgba(24,72,44,0.12), transparent 10%),
        linear-gradient(180deg, rgba(12,30,18,0.9), rgba(6,12,9,0.9));
      z-index: -2;
      opacity: 1;
    }

    body::after {
      content: "";
      position: fixed;
      inset: 0;
      background: radial-gradient(circle at 90% 10%, rgba(0,255,120,0.02), transparent 5%),
                  linear-gradient(180deg, rgba(0,0,0,0.12), rgba(0,0,0,0.6));
      z-index: -1;
      pointer-events: none;
    }

    .page-wrapper {
      position: relative;
      z-index: 1;
    }

    /* Header */
    header {
      position: sticky;
      top: 0;
      z-index: 100;
      backdrop-filter: blur(6px);
      border-bottom: 1px solid rgba(12,60,36,0.45);
      background: linear-gradient(180deg, rgba(0,0,0,0.15), rgba(0,0,0,0.25));
      padding: 12px 0;
    }

    .header-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
      padding: 0 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .logo {
      display: flex;
      gap: 12px;
      align-items: center;
      text-decoration: none;
    }

    .logo-mark {
      width: 40px;
      height: 30px;
      border-radius: 6px;
      background: linear-gradient(180deg, #8fe08f, #2a6f3a);
      box-shadow: 0 1px 0 rgba(255,255,255,0.03) inset, 0 6px 14px rgba(0,0,0,0.5);
    }

    .logo-text {
      font-weight: 800;
      letter-spacing: 1px;
      font-size: 18px;
      color: #f1ffef;
    }

    .nav-items {
      display: flex;
      gap: 20px;
      align-items: center;
    }

    .nav-items a {
      color: #d9f8d9;
      text-decoration: none;
      transition: color 0.3s;
    }

    .nav-items a:hover {
      color: #00ff66;
    }

    .back-btn {
      background: rgba(0,255,102,0.1);
      color: #00ff66;
      border: 1px solid rgba(0,255,102,0.3);
      padding: 8px 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .back-btn:hover {
      background: rgba(0,255,102,0.2);
      border-color: rgba(0,255,102,0.6);
    }

    /* Main Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 30px 20px;
    }

    /* Video Player Section */
    .video-section {
      background: linear-gradient(135deg, rgba(0,255,102,0.05), rgba(0,0,0,0.3));
      border: 1px solid rgba(0,255,102,0.2);
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 30px;
      overflow: hidden;
    }

    .video-player-wrapper {
      position: relative;
      width: 100%;
      padding-bottom: 56.25%;
      height: 0;
      overflow: hidden;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 0 30px rgba(0, 255, 102, 0.15), inset 0 0 30px rgba(0, 0, 0, 0.3);
      background: #000;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .video-player-wrapper:hover {
      box-shadow: 0 0 40px rgba(0, 255, 102, 0.25), inset 0 0 30px rgba(0, 0, 0, 0.3);
      transform: translateY(-2px);
    }

    .video-player-wrapper video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: 8px;
      animation: fadeIn 0.8s ease-out 0.2s both;
      display: block;
    }

    /* Video Info */
    .video-info {
      background: rgba(0,0,0,0.3);
      padding: 20px;
      border-radius: 8px;
      border: 1px solid rgba(0,255,102,0.1);
    }

    .video-title {
      font-size: 28px;
      font-weight: 800;
      color: #00ff66;
      margin: 0 0 15px 0;
      animation: slideUp 0.6s ease-out 0.2s both;
      background: linear-gradient(135deg, #00ff66, #00d9ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .video-meta {
      display: flex;
      gap: 20px;
      margin-bottom: 15px;
      flex-wrap: wrap;
      animation: slideUp 0.6s ease-out 0.25s both;
    }

    .meta-item {
      display: flex;
      gap: 8px;
      align-items: center;
      color: #d9f8d9;
      font-size: 14px;
      padding: 6px 12px;
      background: rgba(0,255,102,0.08);
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    .meta-item:hover {
      background: rgba(0,255,102,0.15);
      transform: translateY(-2px);
    }

    .video-description {
      color: #9fe6a4;
      line-height: 1.8;
      margin-bottom: 20px;
      animation: slideUp 0.6s ease-out 0.3s both;
      letter-spacing: 0.3px;
    }

    /* Related Videos Grid */
    .related-section {
      margin-top: 40px;
    }

    .related-section h3 {
      color: #00ff66;
      font-size: 22px;
      margin-bottom: 20px;
    }

    .related-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
    }

    .related-card {
      background: linear-gradient(135deg, rgba(0,255,102,0.08), rgba(0,0,0,0.3));
      border: 1px solid rgba(0,255,102,0.15);
      border-radius: 12px;
      overflow: hidden;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
    }

    .related-card::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0,255,102,0.2), transparent);
      opacity: 0;
      transition: opacity 0.4s ease;
      z-index: 1;
      pointer-events: none;
    }

    .related-card:hover {
      transform: translateY(-8px);
      border-color: rgba(0,255,102,0.5);
      background: linear-gradient(135deg, rgba(0,255,102,0.18), rgba(0,0,0,0.5));
      box-shadow: 0 12px 30px rgba(0,255,102,0.15);
    }

    .related-card:hover::before {
      opacity: 1;
    }

    .related-thumbnail {
      position: relative;
      width: 100%;
      padding-bottom: 56.25%;
      overflow: hidden;
      background: linear-gradient(135deg, rgba(0,255,102,0.1), rgba(0,0,0,0.3));
      transition: all 0.4s ease;
    }

    .related-card:hover .related-thumbnail {
      transform: scale(1.05);
    }

    .related-thumbnail img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .play-icon {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 48px;
      opacity: 0.6;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      z-index: 2;
    }

    .related-card:hover .play-icon {
      opacity: 1;
      transform: translate(-50%, -50%) scale(1.2);
    }

    .related-info {
      padding: 15px;
    }

    .related-title {
      font-size: 15px;
      font-weight: 600;
      color: #d9f8d9;
      margin: 0 0 8px 0;
      line-height: 1.4;
      transition: color 0.3s ease;
    }

    .related-card:hover .related-title {
      color: #00ff66;
    }

    .related-category {
      display: inline-block;
      background: rgba(0,255,102,0.1);
      color: #00ff66;
      padding: 4px 10px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 600;
    }

    /* Video actions styling */
    .video-actions {
      display: flex;
      gap: 12px;
      margin: 20px 0;
      flex-wrap: wrap;
      animation: slideUp 0.6s ease-out 0.35s both;
    }

    .watch-btn, .download-btn, .like-btn, .share-btn {
      flex: 1;
      min-width: 120px;
      padding: 12px 16px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .watch-btn {
      background: linear-gradient(135deg, #00ff66, #00d9ff);
      color: #000;
    }

    .watch-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,255,102,0.3);
    }

    .download-btn, .like-btn, .share-btn {
      background: rgba(0,255,102,0.15);
      color: #00ff66;
      border: 1px solid rgba(0,255,102,0.3);
    }

    .download-btn:hover, .like-btn:hover, .share-btn:hover {
      background: rgba(0,255,102,0.25);
      border-color: rgba(0,255,102,0.6);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0,255,102,0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .header-inner {
        flex-wrap: wrap;
      }

      .video-title {
        font-size: 22px;
      }

      .related-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      }

      .container {
        padding: 20px 15px;
      }

      .video-actions {
        flex-direction: column;
      }

      .watch-btn, .download-btn, .like-btn, .share-btn {
        width: 100%;
      }
    }

    @media (max-width: 480px) {
      .video-title {
        font-size: 18px;
      }

      .video-meta {
        gap: 10px;
      }

      .related-grid {
        grid-template-columns: 1fr;
      }
    }

    /* Fallback for no video */
    .no-video {
      background: rgba(255, 51, 102, 0.1);
      border: 1px solid rgba(255, 51, 102, 0.3);
      padding: 40px;
      border-radius: 8px;
      text-align: center;
      color: #ff3366;
      animation: slideUp 0.6s ease-out;
    }

    /* Smooth animations */
    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes scaleIn {
      from {
        opacity: 0;
        transform: scale(0.92);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes pulse {
      0%, 100% {
        opacity: 1;
      }
      50% {
        opacity: 0.7;
      }
    }

    @keyframes shimmer {
      0%, 100% { background-position: -1000px 0; }
      100% { background-position: 1000px 0; }
    }

    .video-section {
      animation: slideUp 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s both;
    }

    .related-section {
      animation: slideUp 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
    }

    .related-card {
      animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      overflow: hidden;
      border-radius: 8px;
    }

    .related-card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 12px 24px rgba(0, 255, 102, 0.2), 0 0 20px rgba(0, 255, 102, 0.1);
    }

    .related-card:hover .related-thumbnail img {
      transform: scale(1.08);
      filter: brightness(1.1);
    }

    .related-thumbnail {
      position: relative;
      overflow: hidden;
      border-radius: 6px;
    }

    .related-thumbnail img {
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      display: block;
      width: 100%;
      height: 100%;
    }

    .action-btn {
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, rgba(0,255,102,0.15), rgba(0,255,102,0.05));
      border: 1px solid rgba(0,255,102,0.25);
    }

    .action-btn:hover {
      background: linear-gradient(135deg, rgba(0,255,102,0.25), rgba(0,255,102,0.15));
      border-color: rgba(0,255,102,0.4);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0,255,102,0.15);
    }

    .action-btn:active {
      transform: translateY(0);
    }

    .action-btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(0, 255, 102, 0.2);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }

    .action-btn:active::before {
      width: 300px;
      height: 300px;
    }

    /* Video loading skeleton */
    .video-loading {
      position: relative;
      overflow: hidden;
      background: linear-gradient(90deg, rgba(0,255,102,0.1), rgba(0,255,102,0.2), rgba(0,255,102,0.1));
      background-size: 200% 100%;
      animation: shimmer 2s infinite;
    }
  </style>
</head>
<body>
  <div class="page-wrapper">
    <!-- Header -->
    <header>
      <div class="header-inner">
        <a href="home.php" class="logo">
          <div class="logo-mark"></div>
          <div class="logo-text">CS DREAM</div>
        </a>
        <div class="nav-items">
          <a href="coding.php">Coding</a>
          <a href="home.php">Home</a>
          <a id="backBtn2" href="coding.php" class="back-btn">← Back to Coding</a>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <!-- Video Player -->
      <div class="video-section">
        <div class="video-player-wrapper">
          <video id="videoPlayer" controls autoplay muted playsinline controlsList="nodownload">
            <source src="" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>

        <!-- Video Information -->
        <div class="video-info">
          <h1 class="video-title" id="videoTitle">Video Title</h1>
          
          <div class="video-meta">
            <span class="meta-item">
              <span>📁</span>
              <span id="videoType">Coding</span>
            </span>
            <span class="meta-item">
              <span>🏷️</span>
              <span id="videoCategory">Programming</span>
            </span>
            <span class="meta-item">
              <span>⏱️</span>
              <span id="videoDuration">--:--</span>
            </span>
            <span class="meta-item">
              <span>📅</span>
              <span id="uploadDate">--</span>
            </span>
            <span class="meta-item">
              <span>👁️</span>
              <span id="viewCount">0</span>
            </span>
          </div>

          <p class="video-description" id="videoDescription">Video description goes here.</p>

          <div class="video-actions">
            <button class="action-btn watch-btn" id="playButton">▶️ Play</button>
            <button class="action-btn download-btn" id="downloadButton">⬇️ Download</button>
            <button class="action-btn like-btn" id="likeButton">❤️ Like</button>
            <button class="action-btn share-btn" id="shareButton">📤 Share</button>
          </div>

          <div class="comment-form" style="margin-top:16px;">
            <input type="text" id="commentAuthor" placeholder="Name" style="width:100%;margin-bottom:8px;padding:8px;border-radius:6px;border:1px solid rgba(255,255,255,0.2);background:rgba(0,0,0,0.25);color:#fff;" />
            <textarea id="commentText" placeholder="Add a comment..." rows="3" style="width:100%;padding:8px;border-radius:6px;border:1px solid rgba(255,255,255,0.2);background:rgba(0,0,0,0.25);color:#fff;"></textarea>
            <button id="submitCommentButton" style="margin-top:8px;padding:8px 12px;border-radius:6px;border:none;background:rgba(0,255,102,0.4);color:#000;font-weight:700;cursor:pointer;">Post Comment</button>
          </div>

          <div class="comments-list" id="commentsList" style="margin-top:12px;color:#d9f8d9;font-size:0.9rem;"></div>
        </div>
      </div>

      <!-- Related Videos -->
      <div class="related-section">
        <h3 id="relatedTitle">Related Videos</h3>
        <div class="related-grid" id="relatedGrid">
          <!-- Related videos will be populated here -->
        </div>
      </div>
    </div>
  </div>

  <script src="auth.js"></script>
  <script src="content-data.js"></script>
  <script>
    // Video library with metadata
    const videoLibrary = {
      coding: {
        'javascript-basics': {
          title: 'JavaScript Basics',
          description: 'Learn the fundamentals of JavaScript programming. This comprehensive tutorial covers variables, data types, functions, and more.',
          file: 'videos/all.mp4',
          duration: '45 min',
          category: 'JavaScript'
        },
        'python-beginners': {
          title: 'Python for Beginners',
          description: 'Start your Python journey with this beginner-friendly tutorial. Learn syntax, control flow, and basic programming concepts.',
          file: 'videos/cell phone.mp4',
          duration: '52 min',
          category: 'Python'
        },
        'html-css-crash': {
          title: 'HTML & CSS Crash Course',
          description: 'Master the fundamentals of web development. Build beautiful and responsive websites with HTML and CSS.',
          file: 'videos/highlight.mp4',
          duration: '60 min',
          category: 'Web Development'
        },
        'cpp-intro': {
          title: 'Intro to C++',
          description: 'Dive into object-oriented programming with C++. Learn classes, inheritance, and modern C++ features.',
          file: 'videos/fell.mp4',
          duration: '48 min',
          category: 'C++'
        },
        'css-advanced': {
          title: 'Advanced CSS Tricks',
          description: 'Take your CSS skills to the next level. Master flexbox, grid, animations, and advanced layouts.',
          file: 'videos/fo.mp4',
          duration: '55 min',
          category: 'CSS'
        },
        'java-development': {
          title: 'Java Development',
          description: 'Learn Java programming from basics to advanced concepts. Perfect for aspiring software developers.',
          file: 'videos/hacking aviator.mp4',
          duration: '65 min',
          category: 'Java'
        },
        'python-data-science': {
          title: 'Python Data Science Tutorial',
          description: 'Master data science with Python. Learn libraries like NumPy, Pandas, and Matplotlib for data analysis.',
          file: 'videos/videoplayback.mp4',
          duration: '58 min',
          category: 'Python'
        }
      },
      hacking: {
        'android-security': {
          title: 'Android Security Basics',
          description: 'Can Someone Track Your Phone Using Phone Number Only',
          file: 'videos/Can Someone Track Your Phone Using Phone Number Only_.mp4.mp4',
          duration: '28 min',
          category: 'Mobile Hacking'
        },
        'ios-vulnerabilities': {
          title: 'Mobile wifi password hacking',
          description: 'How to know a Wi-Fi password you don’t know and find it in an easy way.',
          file: 'videos/UKO WAMENYA PASSWORD YA WIFI UTAYIZI.mp4.mp4',
          duration: '7 min 38 sec',
          category: 'Mobile Hacking'
        },
        'sim-cloning': {
          title: 'SIM Cloning Techniques',
          description: 'Advanced SIM card cloning, 2FA bypass, and mobile interception methods explained.',
          file: 'videos/phone tracking.mp4',
          duration: '42 min',
          category: 'Phone Hacking'
        },
        'mobile-recovery': {
          title: 'Mobile Data Recovery',
          description: 'Recover deleted data from Android and iOS devices using forensic techniques.',
          file: 'videos/Android Data recovery_ How to Recover Lost Data on Android_ [2025].mp4.mp4',
          duration: '2 min 45 sec',
          category: 'Digital Forensics'
        },
        'network-hacking': {
          title: '6 dialer codes for network hacking',
          description: 'Learn 6 important dialer codes that can be used for network hacking and phone information gathering.',
          file: 'videos/code 6 utaruzi.mp4',
          duration: '7 min 36 sec',
          category: 'Network Hacking'
        },
        'mobile-forensics': {
          title: 'Mobile Forensics',
          description: ' Write on your phone using your voice || Keyboard Voice Typing ||',
          file: 'videos/andika kuri telephone yawe ukoresheje.mp4',
          duration: '45 min',
          category: 'Digital Forensics'
        },
        'windows-exploitation': {
          title: 'Windows Exploitation',
          description: 'Discover Windows vulnerabilities, exploits, and privilege escalation techniques in depth.',
          file: 'videos/all.mp4',
          duration: '40 min',
          category: 'Computer Hacking'
        },
        'linux-privilege': {
          title: 'Linux Privilege Escalation',
          description: 'Advanced Linux post-exploitation, privilege escalation chains, and defense mechanisms.',
          file: 'videos/hacking.mp4',
          duration: '44 min',
          category: 'Computer Hacking'
        },
        'network-attacks': {
          title: 'Network Attacks',
          description: 'Master ARP spoofing, MITM attacks, DNS hijacking, and network-level exploitation methods.',
          file: 'videos/phone tracking.mp4',
          duration: '36 min',
          category: 'Network Hacking'
        },
        'malware-analysis': {
          title: 'Malware Analysis',
          description: 'Analyze malware behavior, reverse engineer binaries, and understand malicious code patterns.',
          file: 'videos/hacking aviator.mp4',
          duration: '48 min',
          category: 'Computer Hacking'
        },
        'metasploit-framework': {
          title: 'Metasploit Framework',
          description: 'Master Metasploit for penetration testing, exploit development, and vulnerability assessment.',
          file: 'videos/cell phone.mp4',
          duration: '52 min',
          category: 'Computer Hacking'
        },
        'password-cracking': {
          title: 'Password Cracking',
          description: 'Learn password cracking techniques using Hashcat, John the Ripper, and other tools.',
          file: 'videos/fell.mp4',
          duration: '39 min',
          category: 'Computer Hacking'
        },
        'reverse-engineering': {
          title: 'Hacking AI IS TOO EASY⚠️😊',
          description: 'easy ways of hacking ai for your innovation learn how it works?.',
          file: 'videos/man.mp4',
          duration: '26 min 38 sec',
          category: 'Application Hacking'
        },
        'api-testing': {
          title: 'API Testing & Exploitation',
          description: 'REST API security, authentication bypass, data exposure vulnerabilities, and injection attacks.',
          file: 'videos/hacking.mp4',
          duration: '43 min',
          category: 'Application Hacking'
        },
        'mobile-app-security': {
          title: 'Mobile App Security',
          description: 'Advanced mobile app vulnerability testing, exploitation, and secure code practices.',
          file: 'videos/number tarcking.mp4',
          duration: '46 min',
          category: 'Application Hacking'
        },
        'web-app-security': {
          title: 'Web App Security',
          description: 'How To Get Frɛɛ Coins To Open (Aviator Predictor Version 1.0) Using Lucky Patcher',
          file: 'videos/How To Get Frɛɛ Coins To Open (Aviator Predictor Version 1.0) Using Lucky Patcher.mp4 (1).mp4',
          duration: '4 min 05 sec',
          category: 'Application Hacking'
        },
        'database-hacking': {
          title: 'Database Hacking',
          description: 'SQL injection, database enumeration, privilege escalation, and data extraction techniques.',
          file: 'videos/man.mp4',
          duration: '37 min',
          category: 'Application Hacking'
        },
        'authentication-bypass': {
          title: 'Authentication Bypass',
          description: 'Break authentication mechanisms, bypass login systems, and exploit authorization flaws.',
          file: 'videos/no.mp4',
          duration: '34 min',
          category: 'Application Hacking'
        }
      }
    };

    // Get query parameters from URL
    const urlParams = new URLSearchParams(window.location.search);
    const urlType = (urlParams.get('type') || 'coding').toLowerCase();
    const urlVideo = urlParams.get('video');

    function applyVideoData(videoData) {
      if (!videoData || !videoData.video) {
        console.warn('No video data provided:', videoData);
        return false;
      }

      const player = document.getElementById('videoPlayer');
      const sourceElement = player.querySelector('source') || (function() {
        const src = document.createElement('source');
        src.type = 'video/mp4';
        player.appendChild(src);
        return src;
      })();
      
      // Resolve video source with indexedDB-aware uploads path support
      const videoUrl = (videoData.video || videoData.file || '').trim();
      const setSourceAndPlay = async (url) => {
        let finalUrl = url;
        if (url && (url.startsWith('uploads/') || url.startsWith('./uploads/') || url.startsWith('/uploads/'))) {
          const blobUrl = await getFileUrl(url);
          if (blobUrl) {
            finalUrl = blobUrl;
          } else {
            console.warn('Uploaded video not found in storage, trying raw path:', url);
          }
        }

        sourceElement.src = finalUrl || '';

        // Load the video
        player.load();
      };

      // Set poster/thumbnail
      if (videoData.thumbnail) {
        player.setAttribute('poster', videoData.thumbnail);
      } else {
        player.removeAttribute('poster');
      }

      setSourceAndPlay(videoUrl).catch(err => console.error('Video source resolution failed', err));

      // Handle video loading with proper error handling
      player.onloadedmetadata = () => {
        console.log('Video metadata loaded:', videoUrl);
        player.autoplay = true;
        player.play().catch(err => console.warn('Autoplay prevented:', err));
      };
      
      player.onerror = () => {
        console.error('Video loading error:', player.error?.message || 'Unknown error');
      };

      // Display all video metadata with proper formatting
      const titleEl = document.getElementById('videoTitle');
      const descEl = document.getElementById('videoDescription');
      const typeEl = document.getElementById('videoType');
      const catEl = document.getElementById('videoCategory');
      const durEl = document.getElementById('videoDuration');
      const dateEl = document.getElementById('uploadDate');
      const viewEl = document.getElementById('viewCount');
      
      if (titleEl) titleEl.textContent = videoData.title || 'Untitled Video';
      if (descEl) descEl.textContent = videoData.description || 'No description available.';
      if (typeEl) typeEl.textContent = (videoData.page || videoData.source || videoData.type || 'Unknown').toString().replace(/^./, str => str.toUpperCase());
      if (catEl) catEl.textContent = videoData.category || 'General';
      if (durEl) durEl.textContent = videoData.duration || '00:00';
      if (dateEl) dateEl.textContent = videoData.uploadDate || 'Unknown';
      if (viewEl) viewEl.textContent = videoData.views ?? '0';
      
      // Store video data globally for use in related videos and back button
      window.currentVideoData = videoData;
      
      // Update time and day if available
      const uploadTimeEl = document.getElementById('uploadTime');
      if (uploadTimeEl && videoData.uploadTime) {
        uploadTimeEl.textContent = videoData.uploadTime;
      }
      
      const uploadDayEl = document.getElementById('uploadDay');
      if (uploadDayEl && videoData.uploadDay) {
        uploadDayEl.textContent = videoData.uploadDay;
      }
      
      // Update engagement metrics
      const likesEl = document.getElementById('likeCount');
      if (likesEl) likesEl.textContent = videoData.likes || 0;
      
      const commentsEl = document.getElementById('commentCount');
      if (commentsEl) commentsEl.textContent = videoData.comments || 0;
      
      const sharesEl = document.getElementById('shareCount');
      if (sharesEl) sharesEl.textContent = videoData.shares || 0;

      // Load related videos if page/type is available
      if (videoData.page || videoData.source || videoData.type) {
        const type = videoData.page || videoData.source || videoData.type || 'hacking';
        const idFromLibrary = Object.keys(videoLibrary[type] || {}).find(id => videoLibrary[type][id].title === videoData.title);
        if (idFromLibrary) {
          loadRelatedVideos(type, idFromLibrary);
        } else {
          loadRelatedVideos(type, Object.keys(videoLibrary[type] || {})[0]);
        }
      } else {
        loadRelatedVideos(urlType, Object.keys(videoLibrary[urlType] || {})[0]);
      }

      document.title = `${document.getElementById('videoTitle').textContent} - CS DREAM Video Player`;
      return true;
    }

    function loadVideo(type, id) {
      const video = videoLibrary[type]?.[id];
      if (!video) {
        console.warn('Video not found:', {type, id});
        document.querySelector('.video-section').innerHTML = '<div class="no-video" style="text-align:center; padding:60px 20px; color:#d9f8d9;"><h3>❌ Video not found</h3><p>Please select a valid video from a category page.</p><a href="home.php" style="color:#00ff66; text-decoration:underline;">← Go to Home</a></div>';
        return;
      }

      const videoData = {
        id: id,
        title: video.title,
        video: video.file,
        file: video.file,
        thumbnail: video.thumbnail || '',
        category: video.category,
        duration: video.duration,
        description: video.description,
        source: type,
        page: type,
        uploadDate: video.uploadDate || 'Unknown',
        views: video.views || '0'
      };
      
      applyVideoData(videoData);
      loadRelatedVideos(type, id);
    }

    function loadRelatedVideos(type, currentId) {
      const relatedGrid = document.getElementById('relatedGrid');
      relatedGrid.innerHTML = '';

      // Get current video's page/type (not just category)
      const currentVideo = window.currentVideoData;
      const videoType = currentVideo?.page || currentVideo?.source || type || 'coding';
      const currentCategory = currentVideo?.category || '';

      // Load from both video library AND admin database
      // But separate them by type: coding, hack, home, hacking
      const libraryVideos = videoLibrary[videoType] || videoLibrary[type] || {};
      
      const db = getAdminDb();
      const adminVideos = db.videos.filter(v =>
        v.status === 'Published' &&
        v.id !== currentVideo?.id &&
        (v.category === currentCategory || v.page === videoType || currentCategory === '')
      );

      let count = 0;
      const maxRelated = 6;
      const addedIds = new Set([currentId]);

      // First add admin videos from same category
      for (const video of adminVideos) {
        if (!addedIds.has(video.id) && count < maxRelated) {
          addedIds.add(video.id);
          const card = document.createElement('div');
          card.className = 'related-card';
          card.onclick = () => {
            sessionStorage.setItem('selectedVideo', JSON.stringify({
              id: video.id,
              title: video.title,
              video: video.videoUrl,
              thumbnail: video.thumbnailUrl,
              category: video.category,
              duration: video.duration || '00:00',
              description: video.description || '',
              uploadDate: formatUploadTime(video.uploadTimestamp),
              views: video.views || 0,
              source: video.page || currentCategory,
              page: video.page || currentCategory
            }));
            window.location.href = `video-player-2.php?video=${encodeURIComponent(video.id)}&type=${encodeURIComponent(video.page||video.source||video.category||'home')}`;
          };

          const thumbnailUrl = video.thumbnailUrl || 'https://via.placeholder.com/320x180?text=Video';
          const finalThumb = thumbnailUrl.startsWith('uploads/') ? thumbnailUrl : thumbnailUrl;

          card.innerHTML = `
            <div class="related-thumbnail">
              <img src="${finalThumb}" alt="${video.title}" style="width:100%; height:100%; object-fit:cover;" />
              <div class="play-icon">▶️</div>
            </div>
            <div class="related-info">
              <h4 class="related-title">${video.title}</h4>
              <span class="related-category">${video.category || currentCategory}</span>
            </div>
          `;

          relatedGrid.appendChild(card);
          count++;
        }
      }

      // Then add library videos from same type if we need more
      for (const [id, video] of Object.entries(libraryVideos)) {
        if (!addedIds.has(id) && count < maxRelated) {
          addedIds.add(id);
          const card = document.createElement('div');
          card.className = 'related-card';
          card.onclick = () => {
            sessionStorage.setItem('selectedVideo', JSON.stringify({
              id: id,
              title: video.title,
              video: video.file,
              thumbnail: video.thumbnail || '',
              category: video.category,
              duration: video.duration || '00:00',
              description: video.description || '',
              uploadDate: video.uploadDate || 'Unknown',
              views: video.views || 0,
              source: videoType,
              page: videoType,
              file: video.file
            }));
            window.location.href = `video-player-2.php?type=${encodeURIComponent(videoType)}&video=${encodeURIComponent(id)}`;
          };

          // Use actual thumbnail if available, otherwise use a solid color placeholder
          const thumbnailUrl = video.thumbnail || 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22320%22 height=%22180%22%3E%3Crect fill=%22%23224422%22 width=%22320%22 height=%22180%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2228%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23888%22%3E💻%3C/text%3E%3C/svg%3E';

          card.innerHTML = `
            <div class="related-thumbnail">
              <img src="${thumbnailUrl}" alt="${video.title}" style="width:100%; height:100%; object-fit:cover; background:#224422;" />
              <div class="play-icon">▶️</div>
            </div>
            <div class="related-info">
              <h4 class="related-title">${video.title}</h4>
              <span class="related-category">${video.category || 'Video'}</span>
            </div>
          `;

          relatedGrid.appendChild(card);
          count++;
        }
      }

      if (count === 0) {
        relatedGrid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; color:#d9f8d9; padding:40px 20px; opacity:0.7; font-size:0.95rem;">No related videos available. Check back soon!</div>';
      }
    }

    function setupPlayer() {
      const watchBtn = document.getElementById('playButton');
      const downloadBtn = document.getElementById('downloadButton');
      const likeBtn = document.getElementById('likeButton');
      const shareBtn = document.getElementById('shareButton');
      const commentsList = document.getElementById('commentsList');

      watchBtn.addEventListener('click', () => {
        const player = document.getElementById('videoPlayer');
        player.play().catch(() => {});
      });

      downloadBtn.addEventListener('click', () => {
        const videoUrl = document.getElementById('videoPlayer').src;
        if (!videoUrl) return;
        const link = document.createElement('a');
        link.href = videoUrl;
        link.download = `${document.getElementById('videoTitle').textContent}.mp4`;
        document.body.appendChild(link);
        link.click();
        link.remove();
      });

      let liked = false;
      likeBtn.addEventListener('click', () => {
        liked = !liked;
        likeBtn.textContent = liked ? '💚 Liked' : '❤️ Like';
      });

      shareBtn.addEventListener('click', () => {
        const url = window.location.href;
        navigator.clipboard?.writeText(url).catch(() => {});
        alert('Share link copied to clipboard!');
      });

      document.getElementById('submitCommentButton').addEventListener('click', () => {
        const author = document.getElementById('commentAuthor').value.trim();
        const text = document.getElementById('commentText').value.trim();
        if (!author || !text) {
          alert('Please enter name and comment.');
          return;
        }
        const item = document.createElement('div');
        item.className = 'comment-item';
        item.style.marginBottom = '8px';
        item.style.padding = '8px';
        item.style.background = 'rgba(0,255,102,0.08)';
        item.style.borderRadius = '6px';
        item.innerHTML = `<strong>${author}</strong><br/><span style='font-size:0.9rem;'>${text}</span>`;
        commentsList.prepend(item);
        document.getElementById('commentAuthor').value = '';
        document.getElementById('commentText').value = '';
      });
    }

    function updateBackButton2() {
      const backBtn = document.getElementById('backBtn2');
      if (!backBtn) return;

      // Determine the appropriate back page based on video category/page
      const currentVideo = window.currentVideoData;
      const page = currentVideo?.page || currentVideo?.source || 'home';

      const pageMap = {
        'coding': 'coding.php',
        'hack': 'ICT Tutorials.php',
        'hacking': 'ICT Tutorials.php',
        'home': 'home.php'
      };
      
      const backPage = pageMap[page] || 'home.php';
      const pageLabel = {
        'coding': 'Coding',
        'hack': 'Hacking Videos',
        'hacking': 'Hacking Videos',
        'home': 'Home'
      }[page] || 'Home';

      backBtn.href = backPage;
      backBtn.textContent = `← Back to ${pageLabel}`;
    }

    function initializeVideo() {
      // PRIORITY 1: Check for selected video from sessionStorage (user clicked any video)
      const selected = sessionStorage.getItem('selectedVideo');
      if (selected) {
        try {
          const data = JSON.parse(selected);
          if (applyVideoData(data)) {
            updateBackButton2();
            return;
          }
        } catch (e) {
          console.warn('Invalid selected video data', e);
        }
      }

      // PRIORITY 2: Check for admin database videos (from any dashboard upload)
      if (urlVideo) {
        const db = getAdminDb();
        const adminVideo = db.videos.find(v =>
          (v.id === urlVideo || v.videoUrl === urlVideo) &&
          v.status === 'Published'
        );

        if (adminVideo) {
          const videoUrl = adminVideo.videoUrl || adminVideo.video || '';
          const thumbnailUrl = adminVideo.thumbnailUrl || adminVideo.thumbnail || '';
          
          applyVideoData({
            id: adminVideo.id,
            title: adminVideo.title,
            video: videoUrl,
            file: videoUrl,
            thumbnail: thumbnailUrl,
            category: adminVideo.category,
            duration: adminVideo.duration || '00:00',
            description: adminVideo.description || '',
            uploadDate: formatUploadTime(adminVideo.uploadTimestamp),
            views: adminVideo.views || 0,
            source: adminVideo.page || 'general',
            page: adminVideo.page || 'general',
            uploadTime: new Date(adminVideo.uploadTimestamp).toLocaleTimeString(),
            uploadDay: new Date(adminVideo.uploadTimestamp).toLocaleDateString(undefined, { weekday: 'long' })
          });
          updateBackButton2();
          loadRelatedVideos(adminVideo.page || 'general', adminVideo.id);
          return;
        }
      }

      // PRIORITY 3: Check for library videos (from any category)
      const urlParams = new URLSearchParams(window.location.search);
      const requestedType = (urlParams.get('type') || urlType || 'coding').toLowerCase();

      // Try current type first, then others
      const typesToTry = [requestedType, 'coding', 'hack', 'home', 'hacking'];
      
      for (const category of typesToTry) {
        if (urlVideo && videoLibrary[category]?.[urlVideo]) {
          loadVideo(category, urlVideo);
          return;
        }
      }

      // PRIORITY 3b: If query provides a direct video URL or path, load it
      if (urlVideo) {
        const titleFromQuery = urlParams.get('title') || 'Selected Video';
        const descriptionFromQuery = urlParams.get('description') || 'No description available.';
        const thumbnailFromQuery = urlParams.get('thumbnail') || '';

        applyVideoData({
          id: urlVideo,
          title: titleFromQuery,
          video: urlVideo,
          file: urlVideo,
          thumbnail: thumbnailFromQuery,
          category: urlParams.get('category') || 'General',
          duration: urlParams.get('duration') || '00:00',
          description: descriptionFromQuery,
          uploadDate: urlParams.get('uploadDate') || 'Unknown',
          views: Number(urlParams.get('views')) || 0,
          source: urlType,
          page: urlType
        });

        updateBackButton2();
        loadRelatedVideos(requestedType, urlVideo);
        return;
      }

      // PRIORITY 4: Load default video from any available category
      const defaultTypes = ['coding', 'hack', 'home', 'hacking'];
      for (const category of defaultTypes) {
        const defaultId = Object.keys(videoLibrary[category] || {})[0];
        if (defaultId && videoLibrary[category]?.[defaultId]) {
          loadVideo(category, defaultId);
          return;
        }
      }

      // FALLBACK: Show helpful message
      document.querySelector('.video-section').innerHTML = '<div class="no-video" style="text-align:center; padding:60px 20px; color:#d9f8d9;"><h3>🔍 No videos available</h3><p>Please upload videos from the admin dashboard or select a video from a category page.</p></div>';
    }

    initializeVideo();
    setupPlayer();
  </script>
</body>
</html>

