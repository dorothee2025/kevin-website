<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="icon" href="images/cs dream.png" type="image/png">
	<title>Services — Kevin Website</title>
	<link rel="stylesheet" href="styles.css">
	<link rel="manifest" href="manifest.json">
	<meta name="theme-color" content="#0ea5a4">

	<style>
/* Service page enhancements */
.services-hero{background:linear-gradient(135deg,#7c3aed 0%,#06b6d4 100%);color:#fff;padding:56px 20px;border-radius:12px;box-shadow:0 12px 40px rgba(2,6,23,0.45);margin-bottom:28px}
.services-hero .inner{max-width:1100px;margin:0 auto;display:flex;gap:28px;align-items:center}
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:20px}
.feature{background:#fff;padding:20px;border-radius:12px;box-shadow:0 8px 30px rgba(2,6,23,0.06);transition:transform .28s,box-shadow .28s}
.feature:hover{transform:translateY(-8px);box-shadow:0 24px 40px rgba(2,6,23,0.09)}
.feature h4{margin:0 0 8px}
.pricing{display:flex;gap:18px;margin-top:24px}
.price-card{flex:1;background:linear-gradient(180deg,#fff,#f8fafc);padding:20px;border-radius:12px;border:1px solid #eef2ff}
.testimonial{background:#fff;padding:18px;border-radius:12px;box-shadow:0 8px 30px rgba(2,6,23,0.06)}
@media (max-width:1000px){.features-grid{grid-template-columns:repeat(2,1fr)}.pricing{flex-direction:column}}
	</style>
	<meta name="description" content="Services provided by Kevin Website">
</head>
<body>
	<header class="header">
		<div class="container nav">
			<a class="brand" href="home.php"><span class="logo" aria-hidden="true"></span>Kevin</a>
			<nav class="nav-links" aria-label="Main Navigation">
				<a href="home.php" data-en="Home" data-rw="Ahabanza" data-fr="Accueil" data-lg="Oludda">Home</a>
				<a href="about.php" data-en="About" data-rw="Ibyerekeye" data-fr="À propos" data-lg="About">About</a>
				<a href="coding.php" data-en="Coding" data-rw="Kwandika" data-fr="Codage" data-lg="Coding">Coding</a>
				<a href="service.php" data-en="Services" data-rw="Serivisi" data-fr="Services" data-lg="Services">Services</a>
				<a href="news-section.php" data-en="News" data-rw="Amakuru" data-fr="Actualités" data-lg="Amakuru">News</a>
				<a href="contact.php" data-en="Contact" data-rw="Hamagara" data-fr="Contact" data-lg="Contact">Contact</a>
			</nav>
			<div style="display:flex;gap:10px;align-items:center;">
				<select id="languageSelect" style="padding:6px 10px;border-radius:4px;border:1px solid #ddd;cursor:pointer;">
					<option value="en">English</option>
					<option value="rw">Kinyarwanda</option>
					<option value="fr">French</option>
					<option value="lg">Luganda</option>
				</select>
				<a class="btn" href="register.php" data-en="Get started" data-rw="Tandika" data-fr="Commencer" data-lg="Tandika">Get started</a>
			</div>
		</div>
	</header>

	<main class="container">
		<section style="padding:12px 0">
			<div class="services-hero">
				<div class="inner">
					<div style="flex:1">
						<h1>Professional Services — Build, Optimize, Grow</h1>
						<p>Modern web development, performance tuning, and training designed to elevate your project.</p>
						<p style="margin-top:12px"><a class="cta" href="contact.php">Request a proposal</a></p>
					</div>
					<div style="width:320px;text-align:right;color:rgba(255,255,255,0.95)">
						<strong style="display:block;font-size:14px">Trusted by creators & startups</strong>
						<p style="margin-top:8px;opacity:0.95">Production-ready code, guided onboarding, and continuous support.</p>
					</div>
				</div>
			</div>

			<section>
				<h2>What we offer</h2>
				<div class="features-grid">
					<div class="feature">
						<h4>Custom Web Apps</h4>
						<p>Robust single-page apps and server-rendered sites using modern toolchains.</p>
					</div>
					<div class="feature">
						<h4>UI/UX & Branding</h4>
						<p>Design systems, prototypes, and polished interfaces that convert.</p>
					</div>
					<div class="feature">
						<h4>Performance & SEO</h4>
						<p>Optimizations to reduce load times, improve Core Web Vitals and visibility.</p>
					</div>
				</div>

				<div class="pricing">
					<div class="price-card">
						<h3>Starter</h3>
						<p class="small muted">Good for portfolios and small projects</p>
						<ul>
							<li>Landing page</li>
							<li>Basic SEO</li>
							<li>Email support</li>
						</ul>
					</div>
					<div class="price-card">
						<h3>Business</h3>
						<p class="small muted">For growing products and teams</p>
						<ul>
							<li>Custom app</li>
							<li>Analytics & SEO</li>
							<li>2 months support</li>
						</ul>
					</div>
					<div class="price-card">
						<h3>Enterprise</h3>
						<p class="small muted">SLA, security and integrations</p>
						<ul>
							<li>Dedicated team</li>
							<li>Performance SLA</li>
							<li>On-site workshops</li>
						</ul>
					</div>
				</div>

				<div style="margin-top:20px;display:grid;grid-template-columns:1fr 320px;gap:18px;align-items:start">
					<div>
						<h3>Why choose us</h3>
						<p>We combine pragmatic engineering with user-centered design — delivering code that is maintainable and delightful.</p>
					</div>
					<div>
						<div class="testimonial">
							<strong>“Great team — shipped faster than expected.”</strong>
							<p style="margin-top:8px" class="small muted">— Product lead, Startup</p>
						</div>
					</div>
				</div>
			</section>
		</section>
	</main>

	<footer class="container footer">
		<div class="card center small">
			<p>&copy; <span id="year"></span> CS-DREAM Production</p>
		</div>
	</footer>

	<script src="translations.js"></script>
	<script>
		initializeLanguageSystem();
		document.getElementById('year').textContent = new Date().getFullYear();
	</script>
	<script>
		// Global Keyboard Shortcuts
		(function(){
			document.addEventListener('keydown', (e) => {
				// Ctrl+K or / to focus search (if available)
				if ((e.ctrlKey && e.key === 'k') || e.key === '/') {
					e.preventDefault();
					const searchInput = document.getElementById('searchInput');
					if (searchInput) { searchInput.focus(); searchInput.select(); }
				}
				// Ctrl+Shift+D to toggle dark mode (if available)
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
	<style>
		/* Floating Back to Top Button */
		#backToTop {
			position: fixed;
			bottom: 30px;
			right: 30px;
			width: 50px;
			height: 50px;
			background: linear-gradient(135deg, #7c3aed, #06b6d4);
			border: none;
			border-radius: 50%;
			cursor: pointer;
			display: none;
			align-items: center;
			justify-content: center;
			font-size: 24px;
			color: #fff;
			box-shadow: 0 8px 30px rgba(124, 58, 237, 0.4);
			z-index: 999;
			transition: all 0.3s ease;
		}
		#backToTop:hover {
			transform: translateY(-5px);
			box-shadow: 0 12px 40px rgba(124, 58, 237, 0.6);
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
	<button id="backToTop" aria-label="Back to top">
		<i class="fas fa-arrow-up"></i>
	</button>
	<script>
		(function(){
			const backToTopBtn = document.getElementById('backToTop');
			
			const scrollToTop = () => {
				window.scrollTo({ top: 0, behavior: 'smooth' });
			};
			
			window.addEventListener('scroll', () => {
				if (window.pageYOffset > 300) {
					backToTopBtn.classList.add('show');
				} else {
					backToTopBtn.classList.remove('show');
				}
			});
			
			backToTopBtn.addEventListener('click', scrollToTop);
			
			document.addEventListener('keydown', (e) => {
				if (e.key === 'Home') {
					e.preventDefault();
					scrollToTop();
				}
			});
		})();
	</script>

