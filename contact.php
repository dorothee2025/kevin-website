<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="icon" href="images/cs dream.png" type="image/png">
	<title>Contact — Kevin Website</title>
	<link rel="stylesheet" href="styles.css">
	<link rel="manifest" href="manifest.json">
	<meta name="theme-color" content="#0ea5a4">

	<style>
/* Enhanced Contact & Service Styles - lightweight, page-scoped */
.contact-hero{background:linear-gradient(135deg,#0ea5a4 0%,#0369a1 100%);color:#fff;padding:56px 20px;border-radius:12px;box-shadow:0 12px 40px rgba(2,6,23,0.45);margin-bottom:28px}
.contact-hero .inner{max-width:1100px;margin:0 auto;display:flex;gap:28px;align-items:center}
.contact-hero h1{font-size:34px;margin:0 0 8px;line-height:1.05}
.contact-hero p{opacity:.95;margin:0}
.contact-grid{display:grid;grid-template-columns:1fr 420px;gap:24px;align-items:start}
.card{background:#fff;border-radius:12px;padding:20px;box-shadow:0 8px 30px rgba(2,6,23,0.06);color:#111}
.contact-methods{display:flex;flex-direction:column;gap:12px}
.method{display:flex;gap:12px;align-items:center}
.method .icon{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
.icon-mail{background:linear-gradient(135deg,#7c3aed,#06b6d4)}
.icon-phone{background:linear-gradient(135deg,#ef4444,#f97316)}
.icon-visit{background:linear-gradient(135deg,#10b981,#06b6d4)}
.contact-form label{display:block;font-size:13px;margin-bottom:6px;color:#334155}
.contact-form input,.contact-form textarea{width:100%;padding:12px;border-radius:10px;border:1px solid #e6e9ef;box-sizing:border-box}
.contact-form .row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.map-placeholder{height:260px;border-radius:10px;overflow:hidden}
.cta{display:inline-block;padding:10px 16px;background:#0ea5a4;color:#fff;border-radius:10px;text-decoration:none;font-weight:700;box-shadow:0 8px 20px rgba(14,165,164,0.18)}
.faq .q{cursor:pointer;padding:12px;border-radius:8px;background:linear-gradient(180deg,#fff,#f8fafc);margin-bottom:8px;border:1px solid #eef2ff}
.faq .a{padding:12px 16px;margin-bottom:10px;background:#fff;border-radius:8px;border:1px solid #f1f5f9;display:none}

@media (max-width:960px){.contact-grid{grid-template-columns:1fr}.contact-hero .inner{flex-direction:column;align-items:flex-start}.contact-hero h1{font-size:28px}}

/* small animation touches */
.card{transition:transform .28s,box-shadow .28s}
.card:hover{transform:translateY(-6px);box-shadow:0 20px 40px rgba(2,6,23,0.08)}
.pulse{animation:pulse 2.6s infinite}
@keyframes pulse{0%{transform:scale(1)}50%{transform:scale(1.02)}100%{transform:scale(1)}}
	</style>
	<meta name="description" content="Contact Kevin Website">
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
				<a class="btn" href="login.php" data-en="Login" data-rw="Kwinjira" data-fr="Connexion" data-lg="Login">Login</a>
			</div>
		</div>
	</header>

	<main class="container">
		<section style="padding:12px 0">
			<div class="contact-hero">
				<div class="inner">
					<div style="flex:1">
						<h1 data-en="Contact" data-rw="Hamagara">Get in touch with CS DREAM</h1>
						<p>Questions, partnerships or custom work? Send us a message and we'll reply within 1 business day.</p>
						<p style="margin-top:12px"><a class="cta" href="#contactForm">Send a message</a></p>
					</div>
					<div style="width:320px;text-align:right">
						<div class="card pulse" style="color:#fff;background:transparent;box-shadow:none;padding:12px;">
							<strong>Office hours</strong>
							<p style="margin:6px 0 0;">Mon - Fri: 8:00 — 18:00</p>
							<p style="margin:6px 0 0;">Sat: 9:00 — 13:00</p>
						</div>
					</div>
				</div>
			</div>

			<div class="contact-grid" style="margin-top:18px">
				<div>
					<div class="card">
						<h3>Send us a message</h3>
						<form id="contactForm" class="contact-form" onsubmit="handleSubmit(event)" style="margin-top:12px">
							<div class="row">
								<div>
									<label for="name">Your name</label>
									<input id="name" name="name" placeholder="Jane Doe" required>
								</div>
								<div>
									<label for="email">Email</label>
									<input id="email" name="email" type="email" placeholder="you@domain.com" required>
								</div>
							</div>
							<div style="margin-top:12px">
								<label for="subject">Subject</label>
								<input id="subject" name="subject" placeholder="How can we help?">
							</div>
							<div style="margin-top:12px">
								<label for="message">Message</label>
								<textarea id="message" name="message" rows="6" placeholder="Write your message here..." required></textarea>
							</div>
							<div style="display:flex;gap:12px;align-items:center;margin-top:12px">
								<button type="submit" class="cta">Send message</button>
								<button type="button" class="link-ghost" onclick="clearForm()">Clear</button>
								<div id="status" class="small muted" aria-live="polite"></div>
							</div>
						</form>
					</div>

					<div class="card" style="margin-top:16px">
						<h3>Contact methods</h3>
						<div class="contact-methods" style="margin-top:10px">
							<div class="method">
								<div class="icon icon-mail">✉</div>
								<div>
									<strong>Email</strong>
									<p style="margin:4px 0 0;color:#64748b">csdream92@gmail.com</p>
								</div>
							</div>
							<div class="method">
								<div class="icon icon-phone">☎</div>
								<div>
									<strong>Phone</strong>
									<p style="margin:4px 0 0;color:#64748b">+250 795647344</p>
								</div>
							</div>
							<div class="method">
								<div class="icon icon-visit">📍</div>
								<div>
									<strong>Visit</strong>
									<p style="margin:4px 0 0;color:#64748b">Gicumbi District, Rwanda</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<aside>
					<div class="card">
						<h3>Find us</h3>
						<div class="map-placeholder" style="margin-top:12px;background:#e6eef6;display:flex;align-items:center;justify-content:center;color:#0f172a">Map placeholder (add iframe here)</div>
						<p class="small muted" style="margin-top:12px">Open hours, directions, and parking info available on request.</p>
					</div>

					<div class="card" style="margin-top:16px">
						<h3>FAQ</h3>
						<div class="faq" style="margin-top:10px">
							<div class="q">How long until I receive a reply?</div>
							<div class="a">We respond within 1 business day for most requests.</div>
							<div class="q">Do you offer custom training?</div>
							<div class="a">Yes — we provide tailored workshops and materials. Tell us your goals.</div>
						</div>
					</div>
				</aside>
			</div>
		</section>
	</main>

	<footer class="container footer">
		<div class="card center small">
			<p>&copy; <span id="year"></span> CS-DREAM Website</p>
		</div>
	</footer>

	<script src="translations.js"></script>
	<script>
		initializeLanguageSystem();
		
		function clearForm(){document.getElementById('contactForm').reset(); document.getElementById('status').textContent='';}
		function handleSubmit(e){
			e.preventDefault();
			const name = document.getElementById('name').value.trim();
			const email = document.getElementById('email').value.trim();
			const subject = document.getElementById('subject').value.trim();

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
			const message = document.getElementById('message').value.trim();
			if(!name || !email || !message){ document.getElementById('status').textContent = 'Please fill required fields.'; return; }
			// Mailto fallback - replace the email address below with your real address
			const to = 'you@example.com';
			const body = `Name: ${name}%0D%0AEmail: ${email}%0D%0A%0D%0A${encodeURIComponent(message)}`;
			const mailto = `mailto:${to}?subject=${encodeURIComponent(subject || 'Contact from website')}&body=${body}`;
			window.location.href = mailto;
			document.getElementById('status').textContent = 'Opening email client...';
		}
		document.getElementById('year').textContent = new Date().getFullYear();
	</script>
	<script src="clock.js" defer></script>
	<script src="sw-register.js" defer></script>
</body>
</html>

<script>
// simple FAQ toggle
document.querySelectorAll('.faq .q').forEach(q=>{
	q.addEventListener('click', ()=>{
		const a = q.nextElementSibling;
		if(!a) return;
		const visible = a.style.display === 'block';
		a.style.display = visible ? 'none' : 'block';
	});
});

// small form handler uses existing handleSubmit; keep status messaging consistent
function clearForm(){
	const form = document.getElementById('contactForm'); if(form) form.reset();
	const st = document.getElementById('status'); if(st) st.textContent='';
}

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
	background: linear-gradient(135deg, #0ea5a4, #0369a1);
	border: none;
	border-radius: 50%;
	cursor: pointer;
	display: none;
	align-items: center;
	justify-content: center;
	font-size: 24px;
	color: #fff;
	box-shadow: 0 8px 30px rgba(14, 165, 164, 0.4);
	z-index: 999;
	transition: all 0.3s ease;
}
#backToTop:hover {
	transform: translateY(-5px);
	box-shadow: 0 12px 40px rgba(14, 165, 164, 0.6);
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


