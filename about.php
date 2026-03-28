<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="icon" href="images/cs dream.png" type="image/png">
	<!doctype html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>About — CS DREAM - Technology, Coding & Hack Tricks</title>
		<link rel="stylesheet" href="styles.css">
		<meta name="description" content="About CS DREAM — Empowering the next generation of tech innovators through education and practical coding skills.">
		<style>
			/* Enhanced animations and styling */
			* { box-sizing: border-box; }
		
			body {
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
				background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
				margin: 0;
				padding: 0;
			}

			.header {
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				padding: 20px 0;
				box-shadow: 0 4px 20px rgba(0,0,0,0.1);
				position: sticky;
				top: 0;
				z-index: 100;
			}

			.container {
				max-width: 1200px;
				margin: 0 auto;
				padding: 0 20px;
			}

			.nav {
				display: flex;
				align-items: center;
				justify-content: space-between;
				gap: 30px;
				flex-wrap: wrap;
			}

			.brand {
				font-size: 24px;
				font-weight: bold;
				color: white;
				text-decoration: none;
				display: flex;
				align-items: center;
				gap: 8px;
			}

			.nav-links {
				display: flex;
				gap: 25px;
				flex: 1;
			}

			.nav-links a {
				color: white;
				text-decoration: none;
				font-weight: 500;
				transition: all 0.3s ease;
				position: relative;
			}

			.nav-links a::after {
				content: '';
				position: absolute;
				width: 0;
				height: 2px;
				bottom: -5px;
				left: 0;
				background: #ffd700;
				transition: width 0.3s ease;
			}

			.nav-links a:hover::after {
				width: 100%;
			}

			.btn {
				background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
				color: white !important;
				padding: 10px 20px;
				border-radius: 25px;
				text-decoration: none;
				font-weight: 600;
				transition: all 0.3s ease;
			}

			.btn:hover {
				transform: translateY(-2px);
				box-shadow: 0 8px 15px rgba(245, 87, 108, 0.3);
			}

			.hero {
				display: grid;
				grid-template-columns: 2fr 1fr;
				gap: 40px;
				align-items: start;
				padding: 60px 0;
			}

			.hero h1 {
				font-size: 48px;
				font-weight: 800;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent;
				background-clip: text;
				margin: 0 0 20px 0;
				animation: slideInLeft 0.8s ease;
			}

			@keyframes slideInLeft {
				from {
					opacity: 0;
					transform: translateX(-30px);
				}
				to {
					opacity: 1;
					transform: translateX(0);
				}
			}

			@keyframes slideInRight {
				from {
					opacity: 0;
					transform: translateX(30px);
				}
				to {
					opacity: 1;
					transform: translateX(0);
				}
			}

			@keyframes fadeInUp {
				from {
					opacity: 0;
					transform: translateY(20px);
				}
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			.hero > div > p {
				animation: fadeInUp 0.8s ease 0.2s both;
			}

			.hero .card {
				animation: fadeInUp 0.8s ease 0.4s both;
			}

			.card {
				background: white;
				padding: 30px;
				border-radius: 15px;
				box-shadow: 0 8px 25px rgba(0,0,0,0.08);
				transition: all 0.3s ease;
			}

			.card:hover {
				transform: translateY(-5px);
				box-shadow: 0 15px 35px rgba(0,0,0,0.12);
			}

			.card h2, .card h3 {
				color: #333;
				margin-top: 0;
			}

			.card p {
				color: #666;
				line-height: 1.6;
			}

			.small {
				font-size: 14px;
			}

			.muted {
				color: #999;
			}

			.center {
				text-align: center;
			}

			.features-grid {
				display: grid;
				grid-template-columns: repeat(3, 1fr);
				gap: 25px;
				margin: 40px 0;
			}

			.feature-card {
				background: white;
				padding: 30px;
				border-radius: 15px;
				box-shadow: 0 8px 25px rgba(0,0,0,0.08);
				text-align: center;
				transition: all 0.3s ease;
				animation: fadeInUp 0.8s ease both;
			}

			.feature-card:nth-child(2) {
				animation-delay: 0.1s;
			}

			.feature-card:nth-child(3) {
				animation-delay: 0.2s;
			}

			.feature-card:hover {
				transform: translateY(-10px);
				box-shadow: 0 15px 35px rgba(0,0,0,0.12);
				border-top: 4px solid #667eea;
			}

			.feature-icon {
				font-size: 40px;
				margin-bottom: 15px;
			}

			.feature-card h3 {
				color: #333;
				margin: 0 0 10px 0;
			}

			.stats-section {
				display: grid;
				grid-template-columns: repeat(4, 1fr);
				gap: 20px;
				margin: 50px 0;
			}

			.stat-box {
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				color: white;
				padding: 30px;
				border-radius: 15px;
				text-align: center;
				animation: fadeInUp 0.8s ease both;
			}

			.stat-box:nth-child(2) {
				animation-delay: 0.1s;
			}

			.stat-box:nth-child(3) {
				animation-delay: 0.2s;
			}

			.stat-box:nth-child(4) {
				animation-delay: 0.3s;
			}

			.stat-number {
				font-size: 36px;
				font-weight: 800;
				margin: 0;
			}

			.stat-label {
				font-size: 14px;
				margin-top: 10px;
			}

			.team-section {
				margin: 60px 0;
			}

			.team-section h2 {
				font-size: 36px;
				color: #333;
				text-align: center;
				margin-bottom: 15px;
				animation: fadeInUp 0.8s ease;
			}

			.team-intro {
				text-align: center;
				color: #666;
				margin-bottom: 50px;
				animation: fadeInUp 0.8s ease 0.1s both;
			}

			.team-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
				gap: 30px;
			}

			.team-member {
				background: white;
				border-radius: 15px;
				overflow: hidden;
				box-shadow: 0 8px 25px rgba(0,0,0,0.08);
				transition: all 0.4s ease;
				animation: fadeInUp 0.8s ease both;
			}

			.team-member:nth-child(1) { animation-delay: 0.1s; }
			.team-member:nth-child(2) { animation-delay: 0.2s; }
			.team-member:nth-child(3) { animation-delay: 0.3s; }
			.team-member:nth-child(4) { animation-delay: 0.4s; }

			.team-member:hover {
				transform: translateY(-15px);
				box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
			}

			.member-image {
				width: 100%;
				height: 250px;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				display: flex;
				align-items: center;
				justify-content: center;
				font-size: 80px;
				color: white;
				transition: transform 0.4s ease;
			}

			.team-member:hover .member-image {
				transform: scale(1.05);
			}

			.member-info {
				padding: 25px;
				text-align: center;
			}

			.member-name {
				font-size: 20px;
				font-weight: 700;
				color: #333;
				margin: 0 0 5px 0;
			}

			.member-role {
				color: #667eea;
				font-weight: 600;
				margin: 0 0 15px 0;
				font-size: 14px;
			}

			.member-bio {
				color: #666;
				font-size: 14px;
				line-height: 1.6;
				margin: 0;
			}

			.member-socials {
				display: flex;
				gap: 15px;
				justify-content: center;
				margin-top: 15px;
				padding-top: 15px;
				border-top: 1px solid #eee;
			}

			.social-link {
				width: 36px;
				height: 36px;
				border-radius: 50%;
				background: #f0f0f0;
				display: flex;
				align-items: center;
				justify-content: center;
				text-decoration: none;
				color: #667eea;
				transition: all 0.3s ease;
			}

			.social-link:hover {
				background: #667eea;
				color: white;
				transform: translateY(-3px);
			}

			.values-section {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				gap: 25px;
				margin: 50px 0;
			}

			.value-card {
				background: white;
				padding: 30px;
				border-radius: 15px;
				box-shadow: 0 8px 25px rgba(0,0,0,0.08);
				border-left: 4px solid #667eea;
				animation: fadeInUp 0.8s ease both;
			}

			.value-card:nth-child(2) {
				animation-delay: 0.1s;
			}

			.value-card:nth-child(3) {
				animation-delay: 0.2s;
			}

			.value-card:nth-child(4) {
				animation-delay: 0.3s;
			}

			.value-card:hover {
				border-left: 4px solid #f5576c;
				transform: translateX(5px);
			}

			.value-title {
				font-size: 20px;
				font-weight: 700;
				color: #333;
				margin: 0 0 10px 0;
			}

			.value-desc {
				color: #666;
				margin: 0;
				font-size: 14px;
				line-height: 1.6;
			}

			.footer {
				margin-top: 60px;
				padding: 30px 0;
			}

			.footer-content {
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				color: white;
				padding: 30px;
				border-radius: 15px;
				text-align: center;
			}

			.footer-content p {
				margin: 0;
			}

			@media (max-width: 768px) {
				.hero {
					grid-template-columns: 1fr;
				}

				.hero h1 {
					font-size: 32px;
				}

				.features-grid {
					grid-template-columns: 1fr;
				}

				.stats-section {
					grid-template-columns: repeat(2, 1fr);
				}

				.team-grid {
					grid-template-columns: 1fr;
				}

				.values-section {
					grid-template-columns: 1fr;
				}

				.nav-links {
					order: 3;
					width: 100%;
					flex-direction: column;
					gap: 10px;
				}
			}

			/* Global map wrapper - responsive for all devices */
			.map-wrapper {
				position: relative;
				padding-bottom: 56.25%; /* 16:9 */
				height: 0;
				overflow: hidden;
				border-radius: 16px;
				box-shadow: 0 12px 45px rgba(0,0,0,0.15);
				margin: 30px auto;
				max-width: 1200px;
				min-height: 350px;
			}

			.map-wrapper iframe {
				position: absolute;
				inset: 0;
				width: 100%;
				height: 100%;
				border: 0;
				border-radius: 16px;
			}

			@media (min-width: 768px) {
				.map-wrapper {
					padding-bottom: 50%;
					min-height: 500px;
				}
			}

			@media (min-width: 1024px) {
				.map-wrapper {
					padding-bottom: 45%;
					min-height: 620px;
				}
			}
		</style>
	</head>
	<body>
		<header class="header">
			<div class="container nav">
				<a class="brand" href="home.php">
					<span style="font-size:24px;">💻</span>
					<span data-en="CS DREAM" data-rw="CS DREAM" data-fr="CS DREAM" data-lg="CS DREAM">CS DREAM</span>
				</a>
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
					<a class="btn" href="register.php" data-en="Sign up" data-rw="Kwiyandikisha" data-fr="S'inscrire" data-lg="Sign up">Sign up</a>
				</div>
			</div>
		</header>

		<main class="container">
			<section class="hero">
				<div>
					<h1 data-en="About CS DREAM" data-rw="Ibyerekeye CS DREAM" data-fr="À propos de CS DREAM" data-lg="Ibyerekeye CS DREAM">About CS DREAM</h1>
					<p class="small" style="font-size:18px; color: #555; line-height: 1.8;" data-en="CS DREAM is a premier educational platform dedicated to empowering the next generation of technology innovators. We provide comprehensive coding education, hacking tutorials, and practical tech skills to students and professionals worldwide." data-rw="CS DREAM ni inkubiro y'ikoranabuhanga." data-fr="CS DREAM est une plateforme éducative de premier plan." data-lg="CS DREAM ni inkubiro y'ikoranabuhanga.">CS DREAM is a premier educational platform dedicated to empowering the next generation of technology innovators. We provide comprehensive coding education, hacking tutorials, and practical tech skills to students and professionals worldwide.</p>

					<div class="card" style="margin-top:30px; border-top: 4px solid #667eea;">
						<h2 data-en="Our Mission" data-rw="Inzira yacu" data-fr="Notre mission" data-lg="Inzira yacu">Our Mission</h2>
						<p data-en="To democratize tech education and make high-quality coding knowledge accessible to everyone, regardless of background. We believe in learning by doing, real-world applications, and fostering a community of passionate tech enthusiasts." data-rw="Gutubwisha ubwenge bwacu." data-fr="Démocratiser l'éducation technologique." data-lg="Gutubwisha ubwenge bwacu.">To democratize tech education and make high-quality coding knowledge accessible to everyone, regardless of background. We believe in learning by doing, real-world applications, and fostering a community of passionate tech enthusiasts.</p>
					</div>
				</div>

				<aside class="card" style="animation: slideInRight 0.8s ease;">
					<h3 class="center" data-en="Quick Facts" data-rw="Ibihe" data-fr="Faits rapides" data-lg="Ibihe">Quick Facts</h3>
					<ul style="list-style: none; padding: 0;">
						<li style="padding: 10px 0; border-bottom: 1px solid #eee;">
							<strong data-en="Founded" data-rw="Yatemiwe" data-fr="Fondé" data-lg="Yatemiwe">Founded</strong><br>
							<span data-en="2024" data-rw="2024" data-fr="2024" data-lg="2024">2024</span>
						</li>
						<li style="padding: 10px 0; border-bottom: 1px solid #eee;">
							<strong data-en="Expertise" data-rw="Ubwenge" data-fr="Expertise" data-lg="Ubwenge">Expertise</strong><br>
							<span data-en="Web Design, Coding, Hacking" data-rw="Coding n'Ikoranabuhanga" data-fr="Design Web, Codage" data-lg="Coding n'Ikoranabuhanga">Web Design, Coding, Hacking</span>
						</li>
						<li style="padding: 10px 0;">
							<strong data-en="Users" data-rw="Abakoresha" data-fr="Utilisateurs" data-lg="Abakoresha">Users</strong><br>
							<span data-en="Global Community" data-rw="Inyumba y'Isi" data-fr="Communauté mondiale" data-lg="Inyumba y'Isi">Global Community</span>
						</li>
					</ul>
				</aside>
			</section>

			<!-- Features Section -->
			<section style="margin: 60px 0;">
				<h2 style="text-align: center; font-size: 32px; color: #333; margin-bottom: 40px;" data-en="What We Offer" data-rw="Icyo dusaba" data-fr="Ce que nous offrons" data-lg="Icyo dusaba">What We Offer</h2>
				<div class="features-grid">
					<div class="feature-card">
						<div class="feature-icon">📚</div>
						<h3 data-en="Comprehensive Courses" data-rw="Amasomo atandukanye" data-fr="Cours complets" data-lg="Amasomo atandukanye">Comprehensive Courses</h3>
						<p class="muted" data-en="From beginner to advanced, covering all major programming languages and frameworks." data-rw="Iguruduka ry'ikoranabuhanga." data-fr="Du débutant au avancé." data-lg="Iguruduka ry'ikoranabuhanga.">From beginner to advanced, covering all major programming languages and frameworks.</p>
					</div>
					<div class="feature-card">
						<div class="feature-icon">🔐</div>
						<h3 data-en="Security & Hacking" data-rw="Umutekano" data-fr="Sécurité & Piratage" data-lg="Umutekano">Security & Hacking</h3>
						<p class="muted" data-en="Learn ethical hacking, cybersecurity, and practical security techniques." data-rw="Injizira ubwenge bw'umutekano." data-fr="Apprenez le piratage éthique." data-lg="Injizira ubwenge bw'umutekano.">Learn ethical hacking, cybersecurity, and practical security techniques.</p>
					</div>
					<div class="feature-card">
						<div class="feature-icon">🎬</div>
						<h3 data-en="Video Tutorials" data-rw="Amashusho" data-fr="Tutoriels vidéo" data-lg="Amashusho">Video Tutorials</h3>
						<p class="muted" data-en="Interactive step-by-step video guides for hands-on learning." data-rw="Amashusho y'iterambere." data-fr="Guides vidéo interactifs." data-lg="Amashusho y'iterambere.">Interactive step-by-step video guides for hands-on learning.</p>
					</div>
				</div>
			</section>

			<!-- Stats Section -->
			<section style="margin: 60px 0;">
				<div class="stats-section">
					<div class="stat-box">
						<p class="stat-number">10K+</p>
						<p class="stat-label" data-en="Active Users" data-rw="Abakoresha" data-fr="Utilisateurs actifs" data-lg="Abakoresha">Active Users</p>
					</div>
					<div class="stat-box">
						<p class="stat-number">100+</p>
						<p class="stat-label" data-en="Courses" data-rw="Amasomo" data-fr="Cours" data-lg="Amasomo">Courses</p>
					</div>
					<div class="stat-box">
						<p class="stat-number">500+</p>
						<p class="stat-label" data-en="Videos" data-rw="Amashusho" data-fr="Vidéos" data-lg="Amashusho">Videos</p>
					</div>
					<div class="stat-box">
						<p class="stat-number">24/7</p>
						<p class="stat-label" data-en="Support" data-rw="Inzira" data-fr="Support" data-lg="Inzira">Support</p>
					</div>
				</div>
			</section>

			<!-- Values Section -->
			<section style="margin: 60px 0;">
				<h2 style="text-align: center; font-size: 32px; color: #333; margin-bottom: 40px;" data-en="Our Core Values" data-rw="Ibintu byacu" data-fr="Nos valeurs fondamentales" data-lg="Ibintu byacu">Our Core Values</h2>
				<div class="values-section">
					<div class="value-card">
						<p class="value-title" data-en="🎯 Excellence" data-rw="🎯 Ubwenge" data-fr="🎯 Excellence" data-lg="🎯 Ubwenge">🎯 Excellence</p>
						<p class="value-desc" data-en="We strive for the highest quality in every course, tutorial, and resource we create." data-rw="Dutanganya mu mategeko." data-fr="Nous visons la qualité." data-lg="Dutanganya mu mategeko.">We strive for the highest quality in every course, tutorial, and resource we create.</p>
					</div>
					<div class="value-card">
						<p class="value-title" data-en="🤝 Community" data-rw="🤝 Ubwiyunge" data-fr="🤝 Communauté" data-lg="🤝 Ubwiyunge">🤝 Community</p>
						<p class="value-desc" data-en="Building a supportive community where learners help each other grow and succeed." data-rw="Tukanamubwiyunge." data-fr="Créer une communauté." data-lg="Tukanamubwiyunge.">Building a supportive community where learners help each other grow and succeed.</p>
					</div>
					<div class="value-card">
						<p class="value-title" data-en="💡 Innovation" data-rw="💡 Ubwenge" data-fr="💡 Innovation" data-lg="💡 Ubwenge">💡 Innovation</p>
						<p class="value-desc" data-en="Constantly evolving our content to reflect the latest trends in technology." data-rw="Dutanga amahoro." data-fr="Évoluer constamment." data-lg="Dutanga amahoro.">Constantly evolving our content to reflect the latest trends in technology.</p>
					</div>
					<div class="value-card">
						<p class="value-title" data-en="🌍 Accessibility" data-rw="🌍 Ubwiyunge" data-fr="🌍 Accessibilité" data-lg="🌍 Ubwiyunge">🌍 Accessibility</p>
						<p class="value-desc" data-en="Making quality tech education affordable and accessible to everyone globally." data-rw="Gutubwisha ubwiyunge." data-fr="Rendre accessible." data-lg="Gutubwisha ubwiyunge.">Making quality tech education affordable and accessible to everyone globally.</p>
					</div>
				</div>
			</section>

			<!-- Team Section -->
			<section class="team-section">
				<h2 data-en="Meet Our Team" data-rw="Reba itsinda ryacu" data-fr="Rencontrez notre équipe" data-lg="Reba itsinda ryacu">Meet Our Team</h2>
				<p class="team-intro muted" data-en="A passionate group of educators, developers, and designers dedicated to transforming tech education." data-rw="Itsinda ry'abarimu n'abakozi." data-fr="Une équipe passionnée." data-lg="Itsinda ry'abarimu n'abakozi.">A passionate group of educators, developers, and designers dedicated to transforming tech education.</p>
			
				<div class="team-grid">
					<div class="team-member">
						<div class="member-image">👨‍💼</div>
						<div class="member-info">
							<p class="member-name" data-en="Kevin Irumva" data-rw="Kevin Irumva" data-fr="Kevin Irumva" data-lg="Kevin Irumva">Kevin Irumva</p>
							<p class="member-role" data-en="Founder & CEO" data-rw="Umuyobozi" data-fr="Fondateur & PDG" data-lg="Umuyobozi">Founder & CEO</p>
							<p class="member-bio" data-en="Visionary leader with passion for tech education and community building." data-rw="Umuntu w'ikoranabuhanga." data-fr="Leader visionnaire." data-lg="Umuntu w'ikoranabuhanga.">Visionary leader with passion for tech education and community building.</p>
							<div class="member-socials">
								<a href="#" class="social-link" title="Twitter">𝕏</a>
								<a href="#" class="social-link" title="LinkedIn">in</a>
								<a href="#" class="social-link" title="GitHub">⚙️</a>
							</div>
						</div>
					</div>

					<div class="team-member">
						<div class="member-image">👨‍🏫</div>
						<div class="member-info">
							<p class="member-name" data-en="Kami Trevor" data-rw="Kami Trevor" data-fr="Kami Trevor" data-lg="Kami Trevor">Kami Trevor</p>
							<p class="member-role" data-en="Lead Instructor" data-rw="Umwalimu" data-fr="Instructeur en chef" data-lg="Umwalimu">Penuel Prince</p>
							<p class="member-bio" data-en="Expert in full-stack development with 8+ years of industry experience." data-rw="Umuntu w'ikoranabuhanga." data-fr="Expert en développement." data-lg="Umuntu w'ikoranabuhanga.">Expert in full-stack development with 8+ years of industry experience.</p>
							<div class="member-socials">
								<a href="#" class="social-link" title="Twitter">𝕏</a>
								<a href="#" class="social-link" title="LinkedIn">in</a>
								<a href="#" class="social-link" title="GitHub">⚙️</a>
							</div>
						</div>
					</div>

					<div class="team-member">
						<div class="member-image">👩‍💻</div>
						<div class="member-info">
							<p class="member-name" data-en="Ndikumana Pie" data-rw="Ndikumana Pie" data-fr="Ndikumana Pie" data-lg="Ndikumana Pie">Ndikumana Pie</p>
							<p class="member-role" data-en="Security Specialist" data-rw="Umwanditsi" data-fr="Spécialiste en sécurité" data-lg="Umwanditsi">Security Specialist</p>
							<p class="member-bio" data-en="Cybersecurity expert specializing in ethical hacking and penetration testing." data-rw="Umuntu w'umutekano." data-fr="Expert en cybersécurité." data-lg="Umuntu w'umutekano.">Cybersecurity expert specializing in ethical hacking and penetration testing.</p>
							<div class="member-socials">
								<a href="#" class="social-link" title="Twitter">𝕏</a>
								<a href="#" class="social-link" title="LinkedIn">in</a>
								<a href="#" class="social-link" title="GitHub">⚙️</a>
							</div>
						</div>
					</div>

					<div class="team-member">
						<div class="member-image">👨‍🎨</div>
						<div class="member-info">
							<p class="member-name" data-en="Kwizera Ben" data-rw="Kwizera Ben" data-fr="Kwizera Ben" data-lg="Kwizera Ben">Kwizera Ben</p>
							<p class="member-role" data-en="UI/UX Designer" data-rw="Umuyerekeranye" data-fr="Designer UI/UX" data-lg="Umuyerekeranye">UI/UX Designer</p>
							<p class="member-bio" data-en="Creative designer focused on creating beautiful, intuitive user experiences." data-rw="Umuntu w'inyandiko." data-fr="Designer créatif." data-lg="Umuntu w'inyandiko.">Creative designer focused on creating beautiful, intuitive user experiences.</p>
							<div class="member-socials">
								<a href="#" class="social-link" title="Twitter">𝕏</a>
								<a href="#" class="social-link" title="LinkedIn">in</a>
								<a href="#" class="social-link" title="GitHub">⚙️</a>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!-- Location Section -->
			<section style="margin: 60px 0;">
				<h2 style="text-align: center; font-size: 40px; color: #333; margin-bottom: 18px;" data-en="Our Location" data-rw="Aho turi" data-fr="Notre emplacement" data-lg="Aho turi">Our Location</h2>
				<p class="muted" style="text-align:center; max-width:900px; margin:0 auto 22px; font-size:20px; color:#444;" data-en="Find us at U MULINDI WINTWARI in Gicumbi district, Northern Province. See our exact location on the map below." data-rw="Tuboneka kuri U MULINDI WINTWARI muri Gicumbi." data-fr="Trouvez-nous à U MULINDI WINTWARI à Gicumbi." data-lg="Tuboneka kuri U MULINDI WINTWARI muri Gicumbi.">Find us at U MULINDI WINTWARI in Gicumbi district, Northern Province. See our exact location on the map below.</p>
				<div class="map-wrapper">
				<iframe src="https://www.google.com/maps?q=U%20MULINDI%20WINTWARI%20Gicumbi%20Northern%20Province%20Rwanda&output=embed" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" aria-label="Map showing U MULINDI WINTWARI in Gicumbi district, Northern Province, Rwanda"></iframe>
				</div>
			</section>

			<!-- CTA Section -->
			<section style="margin: 60px 0; padding: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; text-align: center; animation: fadeInUp 0.8s ease;">
				<h2 style="color: white; font-size: 32px; margin-top: 0;" data-en="Ready to Start Learning?" data-rw="Wandaka kwiga?" data-fr="Prêt à commencer?" data-lg="Wandaka kwiga?">Ready to Start Learning?</h2>
				<p style="color: rgba(255,255,255,0.9); font-size: 18px; margin-bottom: 30px;" data-en="Join thousands of learners worldwide and start your tech journey with CS DREAM today." data-rw="Injira hasi na tutubwishe." data-fr="Rejoignez-nous aujourd'hui." data-lg="Injira hasi na tutubwishe.">Join thousands of learners worldwide and start your tech journey with CS DREAM today.</p>
				<a class="btn" href="register.php" style="background: white; color: #667eea; font-size: 16px; padding: 12px 30px;" data-en="Get Started Now" data-rw="Tandika Hasi" data-fr="Commencer maintenant" data-lg="Tandika Hasi">Get Started Now</a>
			</section>
		</main>

		<footer class="container footer">
			<div class="footer-content">
				<p>&copy; <span id="year"></span> <strong data-en="CS DREAM" data-rw="CS DREAM" data-fr="CS DREAM" data-lg="CS DREAM">CS DREAM</strong> — <span data-en="Empowering Tech Innovators Worldwide" data-rw="Turizeza abarabushakuza" data-fr="Autonomiser les innovateurs tech" data-lg="Turizeza abarabushakuza">Empowering Tech Innovators Worldwide</span></p>
			</div>
		</footer>

		<script src="translations.js"></script>
		<script src="auth.js"></script>
		<script src="state-manager.js"></script>
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
					// Alt+H to go home (if available)
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
				async function initHint() {
					// Check if hint was dismissed (uses backend state)
					const dismissed = await StateManager.getPreference('historyHintDismissed', false);
					if (dismissed) return;

					const hint = document.createElement('div');
					hint.className = 'fixed bottom-4 left-4 bg-gray-900 text-white px-4 py--2 rounded shadow z-50';
					hint.style.opacity = '0';
					hint.style.transition = 'opacity 200ms ease';
					hint.innerHTML = `<span>Press '<' to go back, '>' to go forward</span>`;
					const btn = document.createElement('button');
					btn.className = 'ml-3 bg-gray-700 px-2 py-1 rounded text-sm';
					btn.innerText = 'Got it';
					btn.addEventListener('click', async () => {
						await StateManager.setPreference('historyHintDismissed', true);
						hint.remove();
					});
					hint.appendChild(btn);
					document.body.appendChild(hint);
					setTimeout(() => hint.style.opacity = '1', 120);
				}

				if (document.readyState === 'loading') {
					document.addEventListener('DOMContentLoaded', initHint);
				} else {
					initHint();
				}
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
				background: linear-gradient(135deg, #667eea, #764ba2);
				border: none;
				border-radius: 50%;
				cursor: pointer;
				display: none;
				align-items: center;
				justify-content: center;
				font-size: 24px;
				color: #fff;
				box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
				z-index: 999;
				transition: all 0.3s ease;
			}
			#backToTop:hover {
				transform: translateY(-5px);
				box-shadow: 0 12px 40px rgba(102, 126, 234, 0.6);
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
	<script src="clock.js" defer></script>
	</body>
	</html>


