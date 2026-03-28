<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/cs dream.png" type="image/png">
    <title>CS DREAM - News</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #0a0a0a;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Header Styles */
        header {
            background-color: #1a1a1a;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 36px;
            font-weight: 800;
            background: linear-gradient(135deg, #00d4ff, #0099cc, #00ffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 3px;
            animation: glowAnimation 2s ease-in-out infinite;
        }

        @keyframes glowAnimation {
            0%, 100% {
                text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
                filter: brightness(1);
            }
            50% {
                text-shadow: 0 0 20px rgba(0, 212, 255, 0.8);
                filter: brightness(1.2);
            }
        }

        nav {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        nav a {
            color: #ccc;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: color 0.3s, border-bottom 0.3s;
            padding-bottom: 5px;
            border-bottom: 2px solid transparent;
        }

        nav a:hover {
            color: #fff;
            border-bottom: 2px solid #00d4ff;
        }

        nav a.active {
            color: #00d4ff;
            border-bottom: 2px solid #00d4ff;
        }

        /* Main Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* News Grid */
        .news-section {
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #fff;
            letter-spacing: 1px;
        }

        .news-grid,
        .featured-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .news-card {
            background-color: #1a1a1a;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #333;
            opacity: 1;
            transform: translateY(0);
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 420px;
            min-height: 420px;
            max-height: 420px;
        }

        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.2);
        }

        .news-description {
            color: #ddd;
            font-size: 0.9rem;
            margin: 8px 0;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .news-image {
            width: 100%;
            height: 190px;
            min-height: 190px;
            max-height: 190px;
            background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }

        .news-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
            display: block;
        }

        .news-card:hover .news-image img {
            transform: scale(1.05);
        }

        .news-content {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            overflow: hidden;
        }

        .news-title {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
            max-height: 2.4em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            word-break: break-word;
        }

        .news-source {
            font-size: 12px;
            color: #888;
            margin-top: auto;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .news-card-fixed {
            width: 100%;
            max-width: 360px;
            min-width: 300px;
            margin: 0 auto;
        }

        /* --- Skeleton Loading Placeholders --- */
        .skeleton { background: linear-gradient(90deg, #1a1a1a 25%, #2a2a2a 50%, #1a1a1a 75%); background-size: 200% 100%; animation: shimmer 2s infinite; }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        .skeleton-card { width: 100%; height: 260px; border-radius: 16px; margin-bottom: 12px; }
        .skeleton-thumb { width: 100%; height: 200px; border-radius: 8px; margin-bottom: 8px; }
        .skeleton-title { width: 80%; height: 16px; border-radius: 4px; margin-bottom: 8px; }
        .skeleton-text { width: 60%; height: 12px; border-radius: 4px; margin-bottom: 6px; }
        .skeleton-buttons { display: flex; gap: 8px; height: 32px; }
        .skeleton-btn { flex: 1; height: 100%; border-radius: 6px; }

        /* Featured News Grid */
        .featured-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-bottom: 40px;
        }

        @media (max-width: 1400px) {
            .featured-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .featured-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .featured-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            nav {
                gap: 20px;
            }

            nav a {
                font-size: 14px;
            }

            header {
                padding: 15px 20px;
            }

            .logo {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .featured-grid {
                grid-template-columns: 1fr;
            }

            nav {
                gap: 15px;
                flex-direction: column;
                align-items: flex-start;
            }

            .section-title {
                font-size: 24px;
            }
        }

        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #333, transparent);
            margin: 60px 0;
        }

        /* Footer */
        footer {
            background-color: #1a1a1a;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #333;
            color: #888;
            margin-top: 60px;
        }

        /* Dark Mode Support */
        .-mode body {
            background-color: #0a0a0a;
        }

        .-mode header {
            background-color: #1a1a1a;
        }

        .-mode .news-card {
            background-color: #1a1a1a;
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
    <!-- Header -->
    <header>
        <div class="logo">CS DREAM</div>
        <nav>
            <a href="home.php" class="nav-link" data-en="Home" data-rw="Ahabanza" data-fr="Accueil" data-lg="Oludda">Home</a>
            <a href="coding.php" class="nav-link" data-en="Coding" data-rw="Kwandika" data-fr="Codage" data-lg="Coding">Coding</a>
            <a href="#sports" class="nav-link" data-en="Sport" data-rw="Imikino" data-fr="Sport" data-lg="Sport">Sport</a>
            <a href="#school-news" class="nav-link" data-en="School News" data-rw="Amakuru y'Ishuri" data-fr="Actualités Scolaires" data-lg="Amakuru y'Ishuri">School News</a>
            <a href="#entertainment" class="nav-link active" data-en="Entertainment" data-rw="Imidushi" data-fr="Divertissement" data-lg="Imidushi">Entertainment</a>
            <select id="languageSelect" style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;background-color:#1a1a1a;color:#fff;cursor:pointer;">
                <option value="en" data-en="English" data-rw="Icyongereza" data-fr="Anglais" data-lg="Lungereza">English</option>
                <option value="rw" data-en="Kinyarwanda" data-rw="Kinyarwanda" data-fr="Kinyarwanda" data-lg="Kinyarwanda">Kinyarwanda</option>
                <option value="fr" data-en="French" data-rw="Igifaranga" data-fr="Français" data-lg="Igifaranga">French</option>
                <option value="lg" data-en="Luganda" data-rw="Luganda" data-fr="Luganda" data-lg="Luganda">Luganda</option>
            </select>
        </nav>
    </header>

    <!-- Main Container -->
    <div class="container">
        <div class="news-section" id="Sport">
            <h2 class="section-title" data-en="Sport" data-rw="Imikino" data-fr="Sport" data-lg="Imikino">Sport</h2>
        <!-- Featured News Section -->
        <div class="news-section">
            <div class="featured-grid">
            </div>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- School News Section -->
        <div class="news-section" id="school-news">
            <h2 class="section-title" data-en="School News" data-rw="Amakuru y'Ishuri" data-fr="Actualités Scolaires" data-lg="Amakuru y'Ishuri">School News</h2>
            <div class="news-grid">
                <!-- School News 1 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=School+News+1" alt="School News">
                    </div>
                    <div class="news-content">
                        <div class="news-title">E.S JURU TSS with naturing competence have bulit new classes of BDC,ELC and CSA.see how students in JURU TSS happy for the new combination have sent</div>
                        <div class="news-source">ES JURU TSS</div>
                    </div>
                </div>

                <!-- School News 2 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=School+News+2" alt="School Events">
                    </div>
                    <div class="news-content">
                        <div class="news-title">See another school of G.S MULINDI IN GICUMBI DISTRICT FROM Northern province,how life of students is</div>
                        <div class="news-source">CS DREAM Academy</div>
                    </div>
                </div>

                <!-- School News 3 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=School+News+3" alt="Student Achievements">
                    </div>
                    <div class="news-content">
                        <div class="news-title">Student Achievements and Recognition Programs</div>
                        <div class="news-source">CS DREAM Academy</div>
                    </div>
                </div>

                <!-- School News 4 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=School+News+4" alt="Curriculum Updates">
                    </div>
                    <div class="news-content">
                        <div class="news-title">New Curriculum Updates and Learning Resources</div>
                        <div class="news-source">CS DREAM Academy</div>
                    </div>
                </div>

                <!-- School News 5 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=School+News+5" alt="Facilities">
                    </div>
                    <div class="news-content">
                        <div class="news-title">Campus Improvements and New Facilities Opening</div>
                        <div class="news-source">CS DREAM Academy</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Entertainment Section -->
        <div class="news-section" id="entertainment">
            <h2 class="section-title" data-en="Entertainment" data-rw="Imidushi" data-fr="Divertissement" data-lg="Imidushi">Entertainment</h2>
            <div class="news-grid">
                <!-- Entertainment 1 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=Entertainment+1" alt="Entertainment News">
                    </div>
                    <div class="news-content">
                        <div class="news-title">Latest Entertainment Industry News and Updates</div>
                        <div class="news-source">Entertainment Today</div>
                    </div>
                </div>

                <!-- Entertainment 2 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=Entertainment+2" alt="Movies">
                    </div>
                    <div class="news-content">
                        <div class="news-title">Upcoming Movie Releases and Box Office Updates</div>
                        <div class="news-source">Box Office Pro</div>
                    </div>
                </div>

                <!-- Entertainment 3 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=Entertainment+3" alt="Music">
                    </div>
                    <div class="news-content">
                        <div class="news-title">Music News: New Releases and Artist Collaborations</div>
                        <div class="news-source">Music Week</div>
                    </div>
                </div>

                <!-- Entertainment 4 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=Entertainment+4" alt="Celebrity">
                    </div>
                    <div class="news-content">
                        <div class="news-title">Celebrity News and Red Carpet Events Coverage</div>
                        <div class="news-source">Celebrity Gossip</div>
                    </div>
                </div>

                <!-- Entertainment 5 -->
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://via.placeholder.com/300x200?text=Entertainment+5" alt="TV Shows">
                    </div>
                    <div class="news-content">
                        <div class="news-title">Trending TV Shows and Streaming Series Reviews</div>
                        <div class="news-source">TV Reviews Daily</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 CS DREAM. All Rights Reserved.</p>
    </footer>

    <script src="translations.js"></script>
    <script src="content-data.js"></script>
    <script src="page-content.js"></script>
    <script>
        // Initialize language system
        initializeLanguageSystem();

        // Navigation Active State
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Dark Mode Support
        const isDarkMode = localStorage.getItem('-mode') === 'dark';
        if (isDarkMode) {
            document.body.classList.add('-mode');
        }

        // Skeleton loading placeholders
        (function(){
            document.addEventListener('DOMContentLoaded', async () => {
                await renderNews();
                onContentChange(async () => {
                  await renderNews();
                });
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

