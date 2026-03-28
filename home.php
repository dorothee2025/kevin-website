<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS DREAM - Entertainment, Computer Tutorials & Coding Hub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="manifest" href="manifest.json">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #0a0e27 0%, #0f1628 50%, #1a1f35 100%);
            color: #ffffff;
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(0, 255, 255, 0.05) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255, 153, 0, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        /* ==================== NAVBAR ==================== */
        .navbar {
            background: linear-gradient(135deg, rgba(15, 31, 53, 0.95) 0%, rgba(26, 47, 74, 0.95) 100%);
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(0, 255, 255, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 8px 32px rgba(0, 255, 255, 0.15);
            animation: navSlideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes navSlideDown {
            from {
                opacity: 0;
                transform: translateY(-100%);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 12px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 35px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 22px;
            font-weight: 900;
            background: linear-gradient(135deg, #00ffff, #00ff88);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 0px;
            cursor: pointer;
            white-space: nowrap;
            position: relative;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            animation: logoSlideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .logo::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #00ffff, #ff9900);
            transition: width 0.3s ease;
        }

        .logo:hover::before {
            width: 100%;
        }

        .logo i {
            font-size: 28px;
            background: linear-gradient(135deg, #00ffff, #00ff88);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 10px rgba(0, 255, 255, 0.3));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        @keyframes logoSlideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes navLinkSlideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes buttonPulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }

        @keyframes glowPulse {
            0%, 100% {
                box-shadow: 0 8px 32px rgba(0, 255, 255, 0.15);
            }
            50% {
                box-shadow: 0 12px 40px rgba(0, 255, 255, 0.25);
            }
        }

        .clock {
            font-size: 15px;
            color: #ff9900;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            min-width: 85px;
            background: rgba(255, 153, 0, 0.15);
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid rgba(255, 153, 0, 0.3);
            letter-spacing: 1px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .clock:hover {
            background: rgba(255, 153, 0, 0.25);
            border-color: rgba(255, 153, 0, 0.6);
            box-shadow: 0 0 15px rgba(255, 153, 0, 0.3);
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 45px;
            margin: 0;
            flex: 1;
            justify-content: center;
        }

        .nav-link {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 0;
            animation: navLinkSlideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) backwards;
        }

        .nav-link:nth-child(1) { animation-delay: 0.1s; }
        .nav-link:nth-child(2) { animation-delay: 0.2s; }
        .nav-link:nth-child(3) { animation-delay: 0.3s; }
        .nav-link:nth-child(4) { animation-delay: 0.4s; }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #00ffff, #ff9900);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }

        .nav-link:hover {
            color: #00ffff;
            text-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link.active {
            color: #00ffff;
            text-shadow: 0 0 20px rgba(0, 255, 255, 0.6);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: rgba(15, 31, 53, 0.6);
            border: 2px solid rgba(0, 255, 255, 0.2);
            border-radius: 25px;
            padding: 10px 18px;
            gap: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .search-bar:hover,
        .search-bar:focus-within {
            border-color: rgba(0, 255, 255, 0.6);
            background: rgba(0, 255, 255, 0.08);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.25), inset 0 0 10px rgba(0, 255, 255, 0.05);
        }

        .search-bar i {
            color: #00ffff;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .search-bar:focus-within i {
            color: #ff9900;
        }

        .search-bar input {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 15px;
            width: 180px;
            outline: none;
            font-family: inherit;
            font-weight: 500;
        }

        .search-bar input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .mode-toggle {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(255, 153, 0, 0.15));
            border: 2px solid rgba(0, 255, 255, 0.3);
            color: #00ffff;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 20px;
            position: relative;
            overflow: hidden;
        }

        .mode-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(0, 255, 255, 0.1);
            transition: left 0.3s ease;
        }

        .mode-toggle:hover {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.25), rgba(255, 153, 0, 0.25));
            border-color: rgba(0, 255, 255, 0.6);
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.4), inset 0 0 15px rgba(0, 255, 255, 0.1);
            transform: scale(1.05) rotate(10deg);
        }

        .mode-toggle:hover::before {
            left: 100%;
        }

        .mode-toggle i {
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .mode-toggle:hover i {
            color: #ff9900;
            transform: rotate(20deg);
        }

        .nav-buttons {
            display: flex;
            gap: 12px;
        }

        .nav-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: 20px;
        }

        .nav-controls a {
            color: #00ffff;
            font-size: 18px;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 6px;
            text-decoration: none;
            position: relative;
        }

        .nav-controls a:hover {
            color: #ff9900;
            background: rgba(0, 255, 255, 0.1);
            transform: scale(1.1);
        }

        .nav-controls a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 255, 255, 0.1);
            border-radius: 6px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .nav-controls a:hover::before {
            opacity: 1;
        }

        /* Admin login modal (hidden by default) */
        .admin-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.68);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .admin-modal {
            width: min(500px, 95%);
            background: linear-gradient(135deg, rgba(14,24,44,0.96), rgba(19,30,55,0.96));
            border: 1px solid rgba(0, 212, 255, 0.25);
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.4);
            padding: 22px;
            color: #eef5ff;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .admin-modal h2 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.35rem;
        }

        .admin-modal p {
            color: rgba(201, 224, 255, 0.9);
            margin-bottom: 12px;
        }

        .admin-modal input[type="password"] {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            background: rgba(0,0,0,0.25);
            color: #ffffff;
            font-size: 1rem;
            margin-bottom: 10px;
            outline: none;
        }

        .admin-modal button {
            width: 100%;
            border: none;
            background: linear-gradient(135deg, #00d4ff, #ffbb33);
            color: #07111f;
            font-weight: 700;
            padding: 11px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .admin-modal button:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(0, 212, 255, 0.35);
        }

        .admin-modal .error-message {
            color: #ff7777;
            font-size: 0.88rem;
            min-height: 18px;
            margin-bottom: 8px;
        }

        .admin-modal .hint {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.7);
            margin-top: 6px;
        }

        .btn-login {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border: 2px solid #ffffff;
            padding: 10px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #ffffff;
            transition: left 0.3s ease;
            z-index: 0;
        }

        .btn-login:hover {
            border-color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            color: #0a0e27;
        }

        .btn-signup {
            background: linear-gradient(135deg, #ff9900, #ffaa22);
            color: #000000;
            border: 2px solid #ff9900;
            padding: 10px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(255, 153, 0, 0.3);
        }

        .btn-signup::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn-signup:hover {
            background: linear-gradient(135deg, #ffaa22, #ffbb44);
            border-color: #ffaa22;
            box-shadow: 0 15px 35px rgba(255, 153, 0, 0.5);
            transform: translateY(-3px);
        }

        .btn-signup:hover::before {
            width: 300px;
            height: 300px;
        }

        /* ==================== USER PROFILE STYLES ==================== */
        .user-profile-widget {
            display: flex;
            align-items: center;
            color: #00ff88;
            font-weight: 700;
            cursor: pointer;
            gap: 8px;
            margin-left: auto;
            padding: 4px 8px;
            border-radius: 14px;
            transition: background 0.2s;
            font-size: 14px;
            position: relative;
            order: 10;
        }
        
        /* Ensure visible when not hidden */
        .user-profile-widget:not(.hidden) {
            display: flex !important;
        }
        
        .user-profile-widget:hover {
            background: rgba(0,255,136,0.08);
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
            border: 2px solid #00ff88;
            box-shadow: 0 0 5px rgba(0,255,136,0.3);
        }
        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        /* Small dropdown menu shown when clicking the profile in the header */
        .user-menu {
            /* Default is absolute, but JS will switch to fixed when opened to avoid stacking/context issues */
            position: absolute;
            right: 6px;
            top: calc(100% + 8px);
            background: rgba(10, 10, 10, 0.95);
            color: #00ff88;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,255,136,0.1);
            min-width: 140px;
            display: none;
            flex-direction: column;
            z-index: 100000; /* very high so it sits above fixed sidebars */
            overflow: hidden;
            border: 1px solid rgba(0,255,136,0.2);
            pointer-events: auto;
        }
        .user-menu a {
            display: block;
            padding: 8px 12px;
            text-decoration: none;
            color: #00ff88;
            font-weight: 600;
        }
        .user-menu a:hover { background: rgba(0,255,136,0.1); }
        .user-menu.visible { display: flex; }

        .user-points { margin-left:8px; font-weight:700; color:#00ff88; font-size:13px; }

        .hidden { display: none !important; }

        /* ==================== HERO SECTION ==================== */
        .hero {
            width: 100%;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 60px 40px 30px;
            text-align: center;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.08) 0%, rgba(255, 153, 0, 0.05) 100%),
                        radial-gradient(circle at 20% 30%, rgba(0, 255, 255, 0.08) 0%, transparent 50%);
            border-bottom: 2px solid rgba(0, 255, 255, 0.15);
            position: relative;
            overflow: visible;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite, glowBreathe 4s ease-in-out infinite;
        }

        @keyframes glowBreathe {
            0%, 100% { opacity: 0.6; filter: blur(0px); }
            50% { opacity: 1; filter: blur(20px); }
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 153, 0, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 10s ease-in-out infinite reverse, glowBreathe 5s ease-in-out infinite;
        }

        .hero-content {
            max-width: 1100px;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 60px;
            font-weight: 900;
            margin-bottom: 15px;
            line-height: 1.1;
            letter-spacing: -2px;
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: slideDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) backwards, titleGlow 3s ease-in-out infinite;
            animation-delay: 0.2s, 0.8s;
        }

        @keyframes titleGlow {
            0%, 100% {
                filter: drop-shadow(0 0 0px rgba(0, 255, 255, 0.2));
                text-shadow: 0 0 0px rgba(0, 255, 255, 0.1);
            }
            50% {
                filter: drop-shadow(0 0 15px rgba(0, 255, 255, 0.3));
                text-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .highlight {
            background: linear-gradient(135deg, #00ffff 0%, #00ff88 50%, #ff9900 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 1000;
            filter: drop-shadow(0 0 20px rgba(0, 255, 255, 0.4));
            position: relative;
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hero-subtitle {
            font-size: 32px;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 600;
            animation: slideDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) backwards, subtleColorShift 4s ease-in-out infinite;
            animation-delay: 0.3s, 0.9s;
        }

        @keyframes subtleColorShift {
            0%, 100% { color: rgba(255, 255, 255, 0.95); }
            50% { color: rgba(255, 255, 255, 1); }
        }

        .orange-text {
            color: #ff9900;
            font-weight: 800;
        }

        .hero-description {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.75);
            margin-bottom: 30px;
            letter-spacing: 0.5px;
            font-weight: 500;
            animation: slideDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) backwards, fadeInOut 5s ease-in-out infinite;
            animation-delay: 0.4s, 1s;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0.75; }
            50% { opacity: 0.9; }
        }

        .hero-buttons {
            display: flex;
            gap: 25px;
            justify-content: center;
            flex-wrap: wrap;
            animation: slideDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) backwards;
            animation-delay: 0.5s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff9900, #ffaa22);
            color: #000000;
            border: none;
            padding: 16px 48px;
            font-size: 17px;
            font-weight: 900;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 30px rgba(255, 153, 0, 0.35);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            animation: buttonPop 0.6s cubic-bezier(0.4, 0, 0.2, 1) backwards;
            animation-delay: 0.6s;
        }

        @keyframes buttonPop {
            from {
                opacity: 0;
                transform: scale(0.8) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 153, 0, 0.4);
            animation: buttonShine 1.5s ease-in-out infinite;
        }

        @keyframes buttonShine {
            0%, 100% { box-shadow: 0 10px 30px rgba(255, 153, 0, 0.4); }
            50% { box-shadow: 0 10px 35px rgba(255, 153, 0, 0.5); }
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary i {
            font-size: 19px;
        }

        .btn-secondary {
            background: rgba(0, 255, 255, 0.1);
            color: #00ffff;
            border: 3px solid #00ffff;
            padding: 14px 46px;
            font-size: 17px;
            font-weight: 900;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            animation: buttonPop 0.6s cubic-bezier(0.4, 0, 0.2, 1) backwards;
            animation-delay: 0.7s;
        }

        .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: #00ffff;
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
        }

        .btn-secondary:hover {
            color: #0a0e27;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.4);
            animation: buttonCyanShine 1.5s ease-in-out infinite;
        }

        @keyframes buttonCyanShine {
            0%, 100% { box-shadow: 0 10px 30px rgba(0, 255, 255, 0.4); }
            50% { box-shadow: 0 10px 35px rgba(0, 255, 255, 0.5); }
        }

        .btn-secondary:hover::before {
            width: 100%;
        }

        .btn-secondary i {
            font-size: 19px;
        }

        /* ==================== CATEGORIES SECTION ==================== */
        .categories {
            max-width: 1360px;
            margin: 30px auto 0;
            padding: 0 30px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            z-index: 2;
            width: 100%;
        }

        .category-card {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.08) 0%, rgba(255, 153, 0, 0.06) 100%);
            border: 2px solid rgba(0, 255, 255, 0.15);
            border-radius: 20px;
            padding: 25px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            animation: cardFadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) backwards, cardFloating 3.5s ease-in-out infinite;
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.08);
        }

        .category-card:nth-child(1) { animation-delay: 0.6s, 0s; }
        .category-card:nth-child(2) { animation-delay: 0.7s, 0.3s; }
        .category-card:nth-child(3) { animation-delay: 0.8s, 0.6s; }

        @keyframes cardFloating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        @keyframes cardFadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 255, 0.15), transparent);
            transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }

        .category-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0, 255, 255, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            transition: all 0.4s ease;
            z-index: 0;
        }

        .category-card:hover {
            border-color: rgba(0, 255, 255, 0.5);
            box-shadow: 0 20px 60px rgba(0, 255, 255, 0.3), 
                        inset 0 0 30px rgba(0, 255, 255, 0.1);
            transform: translateY(-18px) scale(1.02);
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.15) 0%, rgba(255, 153, 0, 0.1) 100%);
            animation: cardGlowPulse 1.5s ease-in-out infinite;
        }

        @keyframes cardGlowPulse {
            0%, 100% { box-shadow: 0 20px 60px rgba(0, 255, 255, 0.3), inset 0 0 30px rgba(0, 255, 255, 0.1); }
            50% { box-shadow: 0 25px 75px rgba(0, 255, 255, 0.45), inset 0 0 40px rgba(0, 255, 255, 0.15); }
        }

        .category-card:hover::before {
            left: 100%;
        }

        .category-card:hover::after {
            top: -20%;
            right: -20%;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .card-header i {
            color: #00ffff;
            font-size: 22px;
            animation: pulse 2.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.7; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.1); }
        }

        .badge {
            background: rgba(255, 153, 0, 0.25);
            color: #ffaa22;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            border: 1px solid rgba(255, 153, 0, 0.4);
        }

        .badge.latest {
            background: rgba(0, 200, 255, 0.25);
            color: #00d4ff;
            border-color: rgba(0, 200, 255, 0.4);
        }

        .badge.popular {
            background: rgba(255, 50, 50, 0.25);
            color: #ff6666;
            border-color: rgba(255, 50, 50, 0.4);
        }

        .badge.trending {
            background: rgba(255, 153, 0, 0.25);
            color: #ffaa22;
            border-color: rgba(255, 153, 0, 0.4);
        }

        .card-icon {
            font-size: 72px;
            margin-bottom: 25px;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.25), rgba(255, 153, 0, 0.25));
            width: 120px;
            height: 120px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00ffff;
            position: relative;
            z-index: 1;
            border: 2px solid rgba(0, 255, 255, 0.2);
            transition: all 0.4s ease;
            animation: iconBounce 2s ease-in-out infinite;
        }

        @keyframes iconBounce {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .category-card:hover .card-icon {
            color: #ff9900;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(255, 153, 0, 0.35));
            transform: scale(1.2) rotate(-8deg);
            border-color: rgba(255, 153, 0, 0.5);
            box-shadow: 0 0 40px rgba(255, 153, 0, 0.4), inset 0 0 20px rgba(255, 153, 0, 0.15);
            animation: iconGlow 1.5s ease-in-out infinite;
        }

        @keyframes iconGlow {
            0%, 100% { box-shadow: 0 0 40px rgba(255, 153, 0, 0.4), inset 0 0 20px rgba(255, 153, 0, 0.15); }
            50% { box-shadow: 0 0 60px rgba(255, 153, 0, 0.6), inset 0 0 30px rgba(255, 153, 0, 0.25); }
        }

        .card-title {
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
            color: #ffffff;
            letter-spacing: 0.5px;
            transition: all 0.4s ease;
        }

        .category-card:hover .card-title {
            transform: translateY(-5px);
        }

        .card-description {
            color: rgba(255, 255, 255, 0.68);
            margin-bottom: 35px;
            font-size: 16px;
            position: relative;
            z-index: 1;
            font-weight: 500;
            line-height: 1.5;
            transition: all 0.4s ease;
        }

        .category-card:hover .card-description {
            color: rgba(255, 255, 255, 0.85);
            transform: translateY(-3px);
        }

        .card-stats {
            display: flex;
            gap: 50px;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid rgba(0, 255, 255, 0.15);
            position: relative;
            z-index: 1;
        }

        .stat {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 900;
            background: linear-gradient(135deg, #00ffff, #00ff88);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.55);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #ff9900;
            text-decoration: none;
            font-weight: 800;
            font-size: 16px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            text-transform: uppercase;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) backwards;
        }

        .card-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #ff9900, #00ffff);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }

        .card-link:hover {
            color: #00ffff;
            gap: 18px;
            transform: translateX(5px);
            text-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
            animation: linkGlow 1.5s ease-in-out infinite;
        }

        @keyframes linkGlow {
            0%, 100% { text-shadow: 0 0 15px rgba(0, 255, 255, 0.3); }
            50% { text-shadow: 0 0 25px rgba(0, 255, 255, 0.5); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-link:hover::after {
            width: 100%;
        }

        .card-link i {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 18px;
            filter: drop-shadow(0 0 0px rgba(255, 153, 0, 0.3));
        }

        .card-link:hover i {
            transform: translateX(6px) rotate(15deg);
            filter: drop-shadow(0 0 10px rgba(255, 153, 0, 0.5));
        }

        /* ==================== FEATURED VIDEO BACKGROUND ==================== */
        .featured-video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 20px;
            overflow: hidden;
            z-index: 0;
            opacity: 0.95;
            transition: opacity 0.4s ease;
        }

        .featured-video-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .featured-video-bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .category-card:hover .featured-video-background {
            opacity: 1;
        }

        /* Ensure text content stays above the background */
        .category-card .card-header,
        .category-card .card-icon,
        .category-card .card-title,
        .category-card .card-description,
        .category-card .card-stats,
        .category-card .card-link,
        .category-card .featured-video-block {
            position: relative;
            z-index: 2;
        }

        /* Dark overlay on thumbnail for better text readability */
        .featured-video-background::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.6) 100%);
            z-index: 1;
        }

        /* ==================== CONTROLS SECTION ==================== */
        .controls-section {
            width: min(1400px, calc(100% - 40px));
            max-width: 1400px;
            margin: 20px auto 40px;
            padding: 20px 30px;
            background: linear-gradient(135deg, rgba(50, 80, 100, 0.4) 0%, rgba(45, 75, 95, 0.4) 100%);
            border: 1px solid rgba(100, 140, 160, 0.3);
            border-radius: 16px;
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            overflow: hidden;
        }

        .controls-left {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            flex: 1 1 auto;
            min-width: 280px;
        }

        .filter-btn {
            background: transparent;
            border: 1px solid rgba(100, 130, 150, 0.5);
            color: #d0d0d0;
            padding: 12px 24px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: capitalize;
            letter-spacing: 0.6px;
            position: relative;
            overflow: hidden;
            min-width: 120px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 150, 200, 0);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .filter-btn i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(0, 150, 200, 0.15);
            transition: left 0.4s ease;
            z-index: -1;
        }

        .filter-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(0, 150, 200, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .filter-btn:hover {
            background: rgba(0, 150, 200, 0.12);
            border-color: rgba(100, 150, 180, 0.9);
            box-shadow: 0 8px 25px rgba(0, 150, 200, 0.25), inset 0 0 15px rgba(0, 150, 200, 0.05);
            transform: translateY(-3px) scale(1.02);
            color: #e0e0e0;
        }

        .filter-btn:hover::before {
            left: 0;
        }

        .filter-btn:hover::after {
            opacity: 1;
        }

        .filter-btn:hover i {
            transform: scale(1.2);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #00bfff, #00d9ff);
            color: #000000;
            border-color: #00bfff;
            box-shadow: 0 8px 30px rgba(0, 191, 255, 0.4), inset 0 0 15px rgba(255, 255, 255, 0.15);
            transform: translateY(-2px) scale(1.03);
            animation: buttonGlow 2s ease-in-out infinite;
        }

        .filter-btn.active i {
            transform: scale(1.2) rotate(15deg);
            color: #000000;
        }

        @keyframes buttonGlow {
            0%, 100% { box-shadow: 0 8px 30px rgba(0, 191, 255, 0.4), inset 0 0 15px rgba(255, 255, 255, 0.15); }
            50% { box-shadow: 0 12px 40px rgba(0, 191, 255, 0.6), inset 0 0 20px rgba(255, 255, 255, 0.25); }
        }

        .controls-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 14px;
            flex-wrap: nowrap;
            flex: 0 0 auto;
        }

        .controls-right .stat-box {
            margin: 0;
            width: 150px;
            min-width: 120px;
            padding: 18px 16px;
            background: linear-gradient(135deg, rgba(70, 110, 140, 0.35) 0%, rgba(60, 100, 130, 0.35) 100%);
            border: 1px solid rgba(100, 140, 160, 0.4);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 150, 200, 0.05), inset 0 0 20px rgba(0, 150, 200, 0.02);
            animation: statBoxFloating 3s ease-in-out infinite;
        }

        .controls-right .stat-box::after {
            content: '';
            position: absolute;
            top: -100%;
            right: -100%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0, 191, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            transition: all 0.5s ease;
        }

        @keyframes statBoxFloating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        
        .controls-right .stat-box h3 {
            font-size: 34px;
            color: #ffffff;
            background: none;
            -webkit-background-clip: unset;
            -webkit-text-fill-color: unset;
            background-clip: unset;
            margin-bottom: 6px;
            font-weight: 800;
            letter-spacing: 0px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .controls-right .stat-box:hover h3 {
            font-size: 38px;
            color: #00ffff;
            text-shadow: 0 0 15px rgba(0, 255, 255, 0.4);
            transform: translateY(-3px);
        }
        
        .controls-right .stat-box p {
            font-size: 13px;
            color: rgba(220, 220, 220, 0.8);
            text-transform: capitalize;
            letter-spacing: 0.5px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .controls-right .stat-box:hover p {
            color: rgba(255, 255, 255, 0.95);
            letter-spacing: 0.8px;
            transform: translateY(-2px);
        }

        .controls-right .stat-box::before {
            display: none;
        }

        .controls-right .stat-box:hover {
            border-color: rgba(100, 140, 160, 0.8);
            box-shadow: 0 15px 50px rgba(0, 191, 255, 0.25), inset 0 0 25px rgba(0, 191, 255, 0.08);
            transform: translateY(-12px) scale(1.05);
            background: linear-gradient(135deg, rgba(80, 120, 150, 0.45) 0%, rgba(70, 110, 140, 0.45) 100%);
            animation: statBoxFloating 2s ease-in-out infinite;
        }

        .controls-right .stat-box:hover::after {
            opacity: 1;
            top: -50%;
            right: -50%;
        }

        .filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(0, 255, 255, 0.2);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .filter-btn:hover {
            background: rgba(0, 255, 255, 0.15);
            border-color: rgba(0, 255, 255, 0.5);
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.25);
            transform: translateY(-3px);
        }

        .filter-btn:hover::before {
            left: 0;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #00ffff, #00ff88);
            color: #0a0e27;
            border-color: #00ffff;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.5), 
                        inset 0 0 20px rgba(255, 255, 255, 0.1);
            font-weight: 900;
            transform: scale(1.05);
        }

        .filter-btn i {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .filter-btn:hover i,
        .filter-btn.active i {
            transform: rotate(15deg);
        }

        /* ==================== STATS SECTION ==================== */
        .stats {
            max-width: 1400px;
            margin: 80px auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
        }

        .stat-box {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.12) 0%, rgba(255, 153, 0, 0.08) 100%);
            border: 2px solid rgba(0, 255, 255, 0.2);
            padding: 50px 40px;
            border-radius: 20px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .stat-box::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            transition: all 0.4s ease;
        }

        .stat-box:hover {
            border-color: rgba(0, 255, 255, 0.5);
            box-shadow: 0 0 50px rgba(0, 255, 255, 0.3), 
                        inset 0 0 30px rgba(0, 255, 255, 0.08);
            transform: translateY(-15px);
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.16) 0%, rgba(255, 153, 0, 0.1) 100%);
        }

        .stat-box:hover::before {
            top: -20%;
            right: -20%;
        }

        .stat-box h3 {
            font-size: 56px;
            background: linear-gradient(135deg, #00ffff, #00ff88, #ff9900);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
            font-weight: 1000;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
        }

        .stat-box p {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.75);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        /* ==================== VIDEO CONTENT SECTION ==================== */
        .videos-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .videos-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .video-card {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.08) 0%, rgba(255, 153, 0, 0.05) 100%);
            border: 2px solid rgba(0, 255, 255, 0.15);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            backdrop-filter: blur(10px);
            animation: cardSlideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) backwards;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .video-card:nth-child(1) { animation-delay: 0.1s; }
        .video-card:nth-child(2) { animation-delay: 0.15s; }
        .video-card:nth-child(3) { animation-delay: 0.2s; }
        .video-card:nth-child(4) { animation-delay: 0.25s; }
        .video-card:nth-child(5) { animation-delay: 0.3s; }
        .video-card:nth-child(6) { animation-delay: 0.35s; }

        @keyframes cardSlideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .video-card:hover {
            border-color: rgba(0, 255, 255, 0.4);
            box-shadow: 0 15px 50px rgba(0, 255, 255, 0.25), inset 0 0 20px rgba(0, 255, 255, 0.05);
            transform: translateY(-8px);
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.12) 0%, rgba(255, 153, 0, 0.08) 100%);
        }

        .video-thumbnail {
            position: relative;
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.1) 0%, rgba(255, 153, 0, 0.1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid rgba(0, 255, 255, 0.1);
        }

        .video-thumbnail::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.05) 0%, transparent 50%, rgba(255, 153, 0, 0.05) 100%);
            pointer-events: none;
        }

        .play-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.3), rgba(255, 153, 0, 0.2));
            border: 3px solid rgba(0, 255, 255, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #00ffff;
            transition: all 0.3s ease;
            cursor: pointer;
            z-index: 2;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.2);
        }

        .video-card:hover .play-icon {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.5), rgba(255, 153, 0, 0.3));
            border-color: rgba(0, 255, 255, 0.8);
            box-shadow: 0 0 50px rgba(0, 255, 255, 0.4);
            transform: scale(1.15);
        }

        .duration {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.7);
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 255, 255, 0.2);
            z-index: 3;
        }

        .video-meta {
            padding: 16px;
            border-bottom: 1px solid rgba(0, 255, 255, 0.1);
        }

        .video-title {
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .video-card:hover .video-title {
            color: #00ffff;
            text-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }

        .video-info {
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            flex-wrap: wrap;
        }

        .channel-name {
            font-weight: 700;
            color: rgba(0, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .video-card:hover .channel-name {
            color: #00ffff;
        }

        .views,
        .date {
            color: rgba(255, 255, 255, 0.5);
        }

        .video-actions {
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            background: rgba(0, 0, 0, 0.2);
        }

        .action-btn {
            flex: 1;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(255, 153, 0, 0.1));
            border: 2px solid rgba(0, 255, 255, 0.2);
            color: #00ffff;
            padding: 12px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(0, 255, 255, 0.2);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.25), rgba(255, 153, 0, 0.15));
            border-color: rgba(0, 255, 255, 0.5);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3), inset 0 0 10px rgba(0, 255, 255, 0.1);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .action-btn:hover::before {
            left: 0;
        }

        .action-btn i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .action-btn:hover i {
            transform: scale(1.2) rotate(10deg);
        }

        .action-btn:active {
            transform: scale(0.95);
        }

        /* ==================== RIPPLE EFFECT ==================== */
        button {
            position: relative;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* ==================== DARK MODE (DEFAULT) ==================== */
        body {
            background: linear-gradient(135deg, #000000 0%, #0a0a0a 50%, #1a1a1a 100%);
            color: #ffffff;
        }

        body::before {
            background: radial-gradient(circle at 20% 50%, rgba(0, 255, 255, 0.03) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255, 153, 0, 0.03) 0%, transparent 50%);
        }

        .navbar {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.98) 0%, rgba(10, 10, 10, 0.98) 100%);
            border-bottom-color: rgba(0, 255, 255, 0.15);
        }

        .hero {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.95) 0%, rgba(10, 10, 10, 0.95) 100%),
                        radial-gradient(circle at 20% 30%, rgba(0, 255, 255, 0.05) 0%, transparent 50%);
        }

        /* ==================== LIGHT MODE ==================== */
        body.light-mode {
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 50%, #f0f0f0 100%);
            color: #1a1a1a;
        }

        body.light-mode::before {
            background: radial-gradient(circle at 20% 50%, rgba(0, 150, 200, 0.05) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255, 153, 0, 0.08) 0%, transparent 50%);
        }

        body.light-mode .navbar {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(245, 245, 245, 0.98) 100%);
            border-bottom: 2px solid rgba(0, 150, 200, 0.25);
        }

        body.light-mode .nav-link {
            color: #333333;
        }

        body.light-mode .nav-link:hover,
        body.light-mode .nav-link.active {
            color: #0096c8;
            text-shadow: 0 0 10px rgba(0, 150, 200, 0.3);
        }

        body.light-mode .nav-controls a {
            color: #0096c8;
        }

        body.light-mode .nav-controls a:hover {
            color: #ff8800;
            background: rgba(0, 150, 200, 0.1);
        }

        body.light-mode .clock {
            background: rgba(255, 153, 0, 0.1);
            border-color: rgba(255, 153, 0, 0.3);
            color: #ff8800;
        }

        body.light-mode .clock:hover {
            background: rgba(255, 153, 0, 0.2);
            border-color: rgba(255, 153, 0, 0.6);
        }

        body.light-mode .search-bar {
            background: rgba(200, 200, 200, 0.3);
            border-color: rgba(0, 150, 200, 0.25);
        }

        body.light-mode .search-bar:hover,
        body.light-mode .search-bar:focus-within {
            border-color: rgba(0, 150, 200, 0.6);
            background: rgba(200, 200, 200, 0.5);
        }

        body.light-mode .search-bar input {
            color: #1a1a1a;
        }

        body.light-mode .search-bar input::placeholder {
            color: rgba(0, 0, 0, 0.4);
        }

        body.light-mode .hero {
            background: linear-gradient(135deg, rgba(245, 245, 245, 0.95) 0%, rgba(230, 230, 230, 0.95) 100%),
                        radial-gradient(circle at 20% 30%, rgba(0, 150, 200, 0.08) 0%, transparent 50%);
        }

        body.light-mode .hero-title {
            background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        body.light-mode .hero-subtitle {
            color: rgba(0, 0, 0, 0.85);
        }

        body.light-mode .hero-description {
            color: rgba(0, 0, 0, 0.7);
        }

        body.light-mode .highlight {
            background: linear-gradient(135deg, #0096c8 0%, #00bb77 50%, #ff8800 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 15px rgba(0, 150, 200, 0.2));
        }

        body.light-mode .btn-primary {
            text-shadow: none;
        }

        body.light-mode .btn-secondary {
            background: rgba(0, 150, 200, 0.15);
            border-color: #0096c8;
            color: #0096c8;
        }

        body.light-mode .btn-secondary:hover::before {
            background: #0096c8;
        }

        body.light-mode .btn-secondary:hover {
            color: #ffffff;
        }

        body.light-mode .category-card {
            background: linear-gradient(135deg, rgba(220, 240, 250, 0.6) 0%, rgba(245, 230, 210, 0.4) 100%);
            border-color: rgba(0, 150, 200, 0.2);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        body.light-mode .category-card:hover {
            border-color: rgba(0, 150, 200, 0.4);
            background: linear-gradient(135deg, rgba(200, 230, 250, 0.7) 0%, rgba(240, 220, 190, 0.5) 100%);
        }

        body.light-mode .card-title {
            color: #1a1a1a;
        }

        body.light-mode .card-description {
            color: rgba(0, 0, 0, 0.7);
        }

        body.light-mode .card-link {
            color: #0096c8;
            border-color: rgba(0, 150, 200, 0.3);
        }

        body.light-mode .filter-btn {
            background: transparent;
            border-color: rgba(100, 130, 150, 0.5);
            color: #333333;
        }

        body.light-mode .filter-btn:hover {
            background: rgba(0, 150, 200, 0.1);
            border-color: rgba(0, 150, 200, 0.6);
            color: #0096c8;
        }

        body.light-mode .filter-btn.active {
            background: linear-gradient(135deg, #0096c8, #00bb77);
            color: #ffffff;
            border-color: #0096c8;
        }

        body.light-mode .stat-box {
            background: linear-gradient(135deg, rgba(200, 230, 250, 0.4) 0%, rgba(255, 200, 150, 0.3) 100%);
            border-color: rgba(0, 150, 200, 0.25);
        }

        body.light-mode .stat-box:hover {
            border-color: rgba(0, 150, 200, 0.5);
            background: linear-gradient(135deg, rgba(180, 220, 250, 0.5) 0%, rgba(255, 180, 120, 0.4) 100%);
        }

        body.light-mode .stat-box h3 {
            background: linear-gradient(135deg, #0096c8, #00bb77, #ff8800);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        body.light-mode .stat-box p {
            color: rgba(0, 0, 0, 0.75);
        }

        body.light-mode .video-card {
            background: linear-gradient(135deg, rgba(200, 230, 250, 0.5) 0%, rgba(255, 200, 150, 0.3) 100%);
            border-color: rgba(0, 150, 200, 0.25);
        }

        body.light-mode .video-card:hover {
            border-color: rgba(0, 150, 200, 0.4);
            background: linear-gradient(135deg, rgba(180, 220, 250, 0.6) 0%, rgba(255, 180, 120, 0.4) 100%);
        }

        body.light-mode .video-thumbnail {
            background: linear-gradient(135deg, rgba(0, 150, 200, 0.1) 0%, rgba(255, 153, 0, 0.1) 100%);
        }

        body.light-mode .video-title {
            color: #1a1a1a;
        }

        body.light-mode .video-card:hover .video-title {
            color: #0096c8;
            text-shadow: 0 0 15px rgba(0, 150, 200, 0.2);
        }

        body.light-mode .channel-name {
            color: rgba(0, 150, 200, 0.9);
        }

        body.light-mode .views,
        body.light-mode .date {
            color: rgba(0, 0, 0, 0.6);
        }

        body.light-mode .action-btn {
            background: linear-gradient(135deg, rgba(0, 150, 200, 0.15), rgba(255, 153, 0, 0.1));
            border-color: rgba(0, 150, 200, 0.25);
            color: #0096c8;
        }

        body.light-mode .action-btn:hover {
            background: linear-gradient(135deg, rgba(0, 150, 200, 0.25), rgba(255, 153, 0, 0.2));
            border-color: rgba(0, 150, 200, 0.5);
            color: #0096c8;
        }

        body.light-mode .controls-section {
            background: rgba(240, 240, 240, 0.5);
        }

        body.light-mode .video-actions {
            background: rgba(240, 240, 240, 0.3);
        }

        body.light-mode .video-meta {
            border-bottom-color: rgba(0, 150, 200, 0.1);
        }

        body.light-mode .video-thumbnail::before {
            background: linear-gradient(135deg, rgba(0, 150, 200, 0.02) 0%, transparent 50%, rgba(255, 153, 0, 0.02) 100%);
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 1200px) {
            .nav-container {
                padding: 14px 30px;
            }

            .nav-menu {
                gap: 30px;
            }

            .hero-title {
                font-size: 64px;
            }

            .hero-subtitle {
                font-size: 26px;
            }

            .categories {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 30px;
                margin: 60px auto;
            }

            .card-icon {
                width: 100px;
                height: 100px;
                font-size: 56px;
            }
        }

        @media (max-width: 1024px) {
            .nav-menu {
                gap: 20px;
                font-size: 14px;
            }

            .nav-link {
                font-size: 15px;
            }

            .hero {
                min-height: 500px;
                padding: 60px 30px;
            }

            .hero-title {
                font-size: 52px;
            }

            .hero-subtitle {
                font-size: 22px;
            }

            .hero-buttons {
                gap: 15px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 12px 32px;
                font-size: 15px;
            }

            .categories {
                grid-template-columns: 1fr;
                margin: 50px auto;
            }

            .card-icon {
                width: 90px;
                height: 90px;
                font-size: 48px;
            }

            .card-title {
                font-size: 28px;
            }

            .card-stats {
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-wrap: wrap;
                padding: 12px 20px;
                gap: 15px;
            }

            .nav-left {
                width: 100%;
                gap: 20px;
            }

            .nav-menu {
                display: none;
            }

            .nav-right {
                width: 100%;
                margin-left: 0;
                gap: 12px;
            }

            .search-bar {
                flex: 1;
            }

            .search-bar input {
                width: 100%;
            }

            .nav-buttons {
                gap: 8px;
            }

            .btn-login,
            .btn-signup {
                padding: 8px 16px;
                font-size: 13px;
            }

            .hero {
                padding: 50px 25px;
                min-height: 450px;
            }

            .hero-title {
                font-size: 40px;
                margin-bottom: 15px;
            }

            .hero-subtitle {
                font-size: 18px;
                margin-bottom: 12px;
            }

            .hero-description {
                font-size: 16px;
                margin-bottom: 30px;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 12px;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
                padding: 14px 24px;
                font-size: 14px;
            }

            .categories {
                margin: 40px auto;
                padding: 0 20px;
                gap: 25px;
            }

            .category-card {
                padding: 30px;
            }

            .card-icon {
                width: 80px;
                height: 80px;
                font-size: 40px;
                margin-bottom: 15px;
            }

            .card-title {
                font-size: 24px;
            }

            .card-description {
                font-size: 14px;
            }

            .card-stats {
                gap: 25px;
                margin-bottom: 20px;
            }

            .stat-number {
                font-size: 24px;
            }

            .filters {
                margin: 50px auto;
                padding: 30px 20px;
                gap: 12px;
            }

            .filter-btn {
                padding: 10px 18px;
                font-size: 13px;
            }

            .stats {
                margin: 50px auto;
                padding: 0 20px;
                gap: 25px;
            }

            .stat-box {
                padding: 35px 25px;
            }

            .stat-box h3 {
                font-size: 42px;
            }

            .stat-box p {
                font-size: 16px;
            }

            .videos-section {
                margin: 60px auto;
                padding: 0 20px;
            }

            .videos-container {
                gap: 24px;
            }

            .video-card {
                border-radius: 12px;
            }

            .video-thumbnail {
                height: 220px;
            }

            .play-icon {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }

            .video-meta {
                padding: 18px;
            }

            .video-title {
                font-size: 18px;
            }

            .video-info {
                font-size: 12px;
                gap: 12px;
            }

            .video-actions {
                padding: 12px 18px;
                gap: 8px;
            }

            .action-btn {
                font-size: 12px;
                padding: 10px 12px;
            }
        }

        @media (max-width: 480px) {
            .logo span {
                display: none;
            }

            .logo {
                font-size: 20px;
                gap: 8px;
            }

            .logo i {
                font-size: 24px;
            }

            .clock {
                font-size: 13px;
                min-width: 75px;
                padding: 6px 10px;
            }

            .hero {
                padding: 40px 15px;
                min-height: 400px;
            }

            .hero-title {
                font-size: 28px;
                margin-bottom: 12px;
                letter-spacing: -0.5px;
            }

            .hero-subtitle {
                font-size: 16px;
                margin-bottom: 10px;
            }

            .hero-description {
                font-size: 14px;
                margin-bottom: 20px;
            }

            .hero-buttons {
                gap: 10px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 12px 20px;
                font-size: 12px;
                gap: 8px;
            }

            .btn-primary i,
            .btn-secondary i {
                font-size: 16px;
            }

            .categories {
                margin: 30px auto;
                padding: 0 15px;
                gap: 20px;
            }

            .category-card {
                padding: 20px;
            }

            .card-header {
                gap: 10px;
                margin-bottom: 20px;
            }

            .card-icon {
                width: 70px;
                height: 70px;
                font-size: 32px;
                margin-bottom: 12px;
            }

            .card-title {
                font-size: 20px;
                margin-bottom: 8px;
            }

            .card-description {
                font-size: 13px;
                margin-bottom: 20px;
            }

            .card-stats {
                gap: 20px;
                margin-bottom: 15px;
                padding-bottom: 15px;
            }

            .stat-number {
                font-size: 22px;
            }

            .stat-label {
                font-size: 10px;
            }

            .card-link {
                font-size: 14px;
                gap: 8px;
            }

            .card-link i {
                font-size: 16px;
            }

            .controls-section {
                margin: 40px auto;
                padding: 20px 15px;
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .control-btn {
                width: 100%;
                padding: 10px 16px;
                font-size: 12px;
                justify-content: center;
            }

            .controls-right {
                justify-content: center;
                width: 100%;
            }

            .stat-box {
                padding: 30px 20px;
            }

            .stat-box h3 {
                font-size: 36px;
                margin-bottom: 8px;
            }

            .stat-box p {
                font-size: 14px;
                letter-spacing: 1px;
            }

            .videos-section {
                margin: 40px auto;
                padding: 0 15px;
            }

            .videos-container {
                gap: 16px;
            }

            .video-card {
                border-radius: 10px;
            }

            .video-thumbnail {
                height: 160px;
            }

            .play-icon {
                width: 50px;
                height: 50px;
                font-size: 24px;
            }

            .duration {
                bottom: 10px;
                right: 10px;
                padding: 5px 10px;
                font-size: 12px;
            }

            .video-meta {
                padding: 14px;
            }

            .video-title {
                font-size: 16px;
                margin-bottom: 8px;
            }

            .video-info {
                font-size: 11px;
                gap: 10px;
                flex-wrap: wrap;
            }

            .video-actions {
                padding: 10px 14px;
                gap: 6px;
                flex-wrap: wrap;
            }

            .action-btn {
                font-size: 11px;
                padding: 8px 10px;
                flex: 0 1 calc(50% - 3px);
            }

            .action-btn i {
                font-size: 14px;
            }
        }

        /* ------------------------------------------------------------------ */
        /* --- LOADING OVERLAY STYLES --- */
        /* ------------------------------------------------------------------ */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-out;
        }

        .loading-overlay.show {
            opacity: 1;
            pointer-events: all;
        }

        .loading-spinner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 30px;
        }

        .spinner {
            width: 80px;
            height: 80px;
            border: 6px solid rgba(255, 255, 255, 0.2);
            border-top: 6px solid #00d4ff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            color: #00d4ff;
            font-size: 1.2em;
            font-weight: 600;
            letter-spacing: 2px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        /* ------------------------------------------------------------------ */
        /* --- WELCOME INTRO OVERLAY STYLES --- */
        /* ------------------------------------------------------------------ */
        .intro-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0a4d5c 0%, #0d3a52 35%, #1a2e4a 70%, #0b1f35 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            animation: introFadeIn 0.8s ease-out;
            overflow: hidden;
        }

        .intro-overlay.hidden {
            animation: introFadeOut 0.8s ease-out forwards;
            pointer-events: none;
        }

        @keyframes introFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes introFadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        /* Decorative background circles */
        .intro-bg-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 1;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 150, 180, 0.15), transparent);
            filter: blur(40px);
        }

        .circle-1 {
            width: 400px;
            height: 400px;
            bottom: -100px;
            left: -50px;
            animation: floatCircle1 8s ease-in-out infinite;
        }

        .circle-2 {
            width: 300px;
            height: 300px;
            bottom: 50px;
            left: 100px;
            animation: floatCircle2 10s ease-in-out infinite;
            background: radial-gradient(circle, rgba(0, 200, 150, 0.1), transparent);
        }

        .circle-3 {
            width: 250px;
            height: 250px;
            bottom: 150px;
            left: 30px;
            animation: floatCircle3 12s ease-in-out infinite;
            background: radial-gradient(circle, rgba(0, 100, 200, 0.08), transparent);
        }

        @keyframes floatCircle1 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-30px, -30px); }
        }

        @keyframes floatCircle2 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
        }

        @keyframes floatCircle3 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-20px, 30px); }
        }

        .intro-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            width: 100%;
            padding: 60px 80px;
            gap: 80px;
            animation: introSlideUp 0.8s ease-out 0.2s backwards;
            position: relative;
            z-index: 10;
        }

        @keyframes introSlideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .intro-left {
            flex: 0 1 500px;
            animation: introLeftSlide 0.8s ease-out 0.3s backwards;
            z-index: 2;
        }

        @keyframes introLeftSlide {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .intro-welcome-text {
            font-size: 1.1em;
            color: #a8d8e8;
            margin: 0 0 8px 0;
            font-weight: 400;
            letter-spacing: 1px;
            animation: fadeInUp 0.8s ease-out 0.4s backwards;
        }

        .intro-title {
            font-size: 4.5em;
            font-weight: 900;
            margin: 0 0 20px 0;
            letter-spacing: 4px;
            line-height: 1.1;
            animation: fadeInUp 0.8s ease-out 0.5s backwards;
        }

        .cs-text {
            background: linear-gradient(135deg, #00d4ff 0%, #0099ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
        }

        .dream-text {
            color: #f0f0f0;
            display: inline-block;
        }

        .intro-subtitle {
            font-size: 1.15em;
            color: #d0d0d0;
            margin: 0 0 40px 0;
            line-height: 1.7;
            font-weight: 300;
            max-width: 500px;
            animation: fadeInUp 0.8s ease-out 0.6s backwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .intro-btn {
            padding: 13px 36px;
            border: 2px solid rgba(168, 216, 232, 0.5);
            border-radius: 50px;
            font-size: 1em;
            font-weight: 600;
            color: #a8d8e8;
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            text-transform: capitalize;
            box-shadow: 0 0 20px rgba(0, 150, 180, 0.15);
            animation: fadeInUp 0.8s ease-out 0.7s backwards;
            text-decoration: none;
            display: inline-block;
        }

        .intro-btn:hover {
            background: rgba(0, 150, 180, 0.15);
            border-color: rgba(168, 216, 232, 0.8);
            box-shadow: 0 0 30px rgba(0, 150, 180, 0.3);
            transform: translateY(-2px);
        }

        .intro-skip-btn {
            margin-left: 20px;
            padding: 13px 24px;
            border: 2px solid rgba(168, 216, 232, 0.3);
            border-radius: 50px;
            font-size: 1em;
            font-weight: 600;
            color: #a8d8e8;
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            text-transform: capitalize;
            box-shadow: 0 0 20px rgba(0, 150, 180, 0.1);
            animation: fadeInUp 0.8s ease-out 0.75s backwards;
        }

        .intro-skip-btn:hover {
            background: rgba(0, 150, 180, 0.1);
            border-color: rgba(168, 216, 232, 0.6);
            box-shadow: 0 0 30px rgba(0, 150, 180, 0.2);
            transform: translateY(-2px);
        }

        .intro-signin-message {
            padding: 13px 24px;
            border: 2px solid rgba(168, 216, 232, 0.5);
            border-radius: 50px;
            font-size: 1em;
            font-weight: 600;
            color: #a8d8e8;
            background: rgba(0, 150, 180, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            text-transform: capitalize;
            box-shadow: 0 0 20px rgba(0, 150, 180, 0.15);
            animation: fadeInUp 0.8s ease-out 0.8s backwards;
            opacity: 0;
            pointer-events: none;
        }

        .intro-signin-message.show {
            opacity: 1;
            pointer-events: all;
        }

        .intro-signin-message:hover {
            background: rgba(0, 150, 180, 0.2);
            border-color: rgba(168, 216, 232, 0.8);
            box-shadow: 0 0 30px rgba(0, 150, 180, 0.3);
            transform: translateY(-2px);
        }

        .intro-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: introRightSlide 0.8s ease-out 0.4s backwards;
            min-height: 500px;
        }

        @keyframes introRightSlide {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-card {
            position: relative;
            width: 100%;
            max-width: 450px;
            aspect-ratio: 1;
            background: linear-gradient(135deg, rgba(15, 50, 80, 0.6) 0%, rgba(30, 70, 100, 0.5) 100%);
            border-radius: 24px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid rgba(0, 150, 180, 0.2);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            animation: floatCard 4s ease-in-out infinite;
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        .hero-card-glow {
            position: absolute;
            inset: 0;
            border-radius: 24px;
            background: radial-gradient(circle at center, rgba(0, 212, 255, 0.1), transparent);
            pointer-events: none;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: drop-shadow(0 0 30px rgba(0, 150, 180, 0.2));
            animation: floatImage 5s ease-in-out infinite;
            position: relative;
            z-index: 2;
            transform: scale(1.08);
        }

        @keyframes floatImage {
            0%, 100% { transform: scale(1.08) translateY(0px); }
            50% { transform: scale(1.08) translateY(-15px); }
        }

        /* Hide admin button from navbar */
        #adminLink {
            display: none !important;
        }

        /* Back to Top Button */
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
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <div class="logo">
                    <i class="fas fa-cube"></i>
                    <span>CS DREAM</span>
                </div>
                <div class="clock" id="clock">10:54:45</div>
            </div>

            <ul class="nav-menu">
                <li><a href="#home" class="nav-link active">Home</a></li>
                <li>
                    <a href="news-section.php" class="nav-link">News <i class="fas fa-chevron-down"></i></a>
                </li>
                <li>
                    <a href="ICT Tutorials - Tricks.php" class="nav-link">ICT Tutorials <i class="fas fa-chevron-down"></i></a>
                </li>
                <li>
                    <a href="coding.php" class="nav-link">Coding <i class="fas fa-chevron-down"></i></a>
                </li>
            </ul>

            <div class="nav-right">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search Videos...">
                </div>
                <div class="mode-toggle" id="modeToggle" title="Toggle Dark/Light Mode">
                    <i class="fas fa-moon"></i>
                </div>
                <div class="nav-buttons">
                    <a href="login.php" class="btn-login">Login</a>
                    <a href="register.php" class="btn-signup">Sign Up</a>
                </div>

                <div class="nav-controls">
                    <a href="#" id="adminLink" title="Admin"><i class="fas fa-lock"></i></a>
                    <a href="https://wa.me/1234567890" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="ChatAI.py" title="AI Chat"><i class="fas fa-robot"></i></a>
                    <a href="setting.php" title="Settings"><i class="fas fa-cog"></i></a>
                </div>

                <div class="user-profile-widget hidden" id="userWidget" tabindex="0" aria-haspopup="true" aria-expanded="false">
                    <div class="profile-pic">
                        <img id="navProfilePic" src="https://via.placeholder.com/30/00ffff/000000?text=U" alt="Profile">
                    </div>
                    <span id="navUsername"></span>
                    <span id="userPoints" class="user-points">Pts: 0 (Lv 1)</span>
                    <div class="user-menu" id="userMenu" role="menu" aria-hidden="true">
                        <a href="setting.php" id="navProfileSettings" role="menuitem">Settings</a>
                        <a href="#" id="navLogout" role="menuitem">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div id="adminModalOverlay" class="admin-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="adminModalTitle">
        <div class="admin-modal">
            <h2 id="adminModalTitle">Admin Login</h2>
            <p>Enter password to access the Admin Dashboard (no username required).</p>
            <input id="adminModalPassword" type="password" placeholder="Password" autocomplete="current-password" aria-label="Admin password" />
            <div id="adminModalError" class="error-message" aria-live="assertive"></div>
            <button id="adminModalSubmit">Enter Admin</button>
            <p class="hint">3 wrong attempts will temporarily lock the form.</p>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1 class="hero-title">WELCOME TO <span class="highlight">CS DREAM</span></h1>
            <p class="hero-subtitle"><span class="orange-text">Entertainment</span>, Computer Tutorials & <span class="orange-text">Coding Hub</span> <i class="fas fa-rocket"></i></p>
            <p class="hero-description">Discover, Learn & Master Programming with Updated Videos Daily</p>
            <div class="hero-buttons">
                <button class="btn-primary">
                    <i class="fas fa-play"></i> Start Learning
                </button>
                <button class="btn-secondary">
                    <i class="fas fa-play"></i> Explore Videos
                </button>
            </div>
        </div>

        <div class="categories">
            <div class="category-card" data-feature-card="news">
                <div class="card-header">
                    <i class="fas fa-circle-dot"></i>
                    <span class="badge latest">Latest Updates</span>
                </div>
            <div class="card-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <h2 class="card-title">News</h2>
            <p class="card-description">Latest Tech & Programming News</p>
            <div class="card-stats">
                <div class="stat">
                    <span class="stat-number">24</span>
                    <span class="stat-label">New Videos</span>
                </div>
                <div class="stat">
                    <span class="stat-number">1.2K</span>
                    <span class="stat-label">Views Today</span>
                </div>
            </div>
            <a href="news-section.php" class="card-link">Watch Now <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="category-card" data-feature-card="hack">
            <div class="card-header">
                <i class="fas fa-circle-dot"></i>
                <span class="badge popular">Popular</span>
            </div>
            <div class="card-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h2 class="card-title">Hack Tricks</h2>
            <p class="card-description">Ethical Hacking & Cyber Security</p>
            <div class="card-stats">
                <div class="stat">
                    <span class="stat-number">18</span>
                    <span class="stat-label">New Videos</span>
                </div>
                <div class="stat">
                    <span class="stat-number">856</span>
                    <span class="stat-label">Views Today</span>
                </div>
            </div>
            <a href="ICT Tutorials - Tricks.php" class="card-link">Watch Now <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="category-card" data-feature-card="coding">
            <div class="card-header">
                <i class="fas fa-circle-dot"></i>
                <span class="badge trending">Trending</span>
            </div>
            <div class="card-icon">
                <i class="fas fa-code"></i>
            </div>
            <h2 class="card-title">Coding</h2>
            <p class="card-description">Programming Tutorials & Projects</p>
            <div class="card-stats">
                <div class="stat">
                    <span class="stat-number">32</span>
                    <span class="stat-label">New Videos</span>
                </div>
                <div class="stat">
                    <span class="stat-number">2.4K</span>
                    <span class="stat-label">Views Today</span>
                </div>
            </div>
            <a href="coding.php" class="card-link">Start Coding <i class="fas fa-arrow-right"></i></a>
        </div>
</div>
</section>

<!-- Secondary Content Section -->
<section class="controls-section">
    <div class="controls-left">
        <button class="filter-btn active"><i class="fas fa-play"></i> All Videos</button>
        <button class="filter-btn"><i class="fas fa-code"></i> Coding</button>
        <button class="filter-btn"><i class="fas fa-shield-alt"></i> Hacking</button>
        <button class="filter-btn"><i class="fas fa-newspaper"></i> News</button>
        <button class="filter-btn"><i class="fas fa-fire"></i> Trending</button>
    </div>
    <div class="controls-right">
        <div class="stat-box">
            <h3>1000+</h3>
            <p>Total Videos</p>
        </div>
        <div class="stat-box">
            <h3>50+</h3>
            <p>Playlists</p>
        </div>
        <div class="stat-box">
            <h3>Daily</h3>
            <p>New Content</p>
        </div>
    </div>
</section>

<!-- Video Content Section -->
<section class="videos-section">
    <div class="videos-container">
        <!-- Video Card 1 -->
        <div class="video-card">
            <div class="video-thumbnail">
                <div class="play-icon"><i class="fas fa-play"></i></div>
                <div class="duration">12:34</div>
            </div>
            <div class="video-meta">
                <h3 class="video-title">Complete Python Web Development Tutorial for Beginners</h3>
                <div class="video-info">
                    <span class="channel-name">Tech Academy</span>
                    <span class="views">245.5K views</span>
                    <span class="date">2 days ago</span>
                </div>
            </div>
            <div class="video-actions">
                <button class="action-btn"><i class="fas fa-thumbs-up"></i> Like</button>
                <button class="action-btn"><i class="fas fa-comment"></i> Comment</button>
                <button class="action-btn"><i class="fas fa-share"></i> Share</button>
                <button class="action-btn"><i class="fas fa-download"></i> Download</button>
            </div>
        </div>

        <!-- Video Card 2 -->
        <div class="video-card">
            <div class="video-thumbnail">
                <div class="play-icon"><i class="fas fa-play"></i></div>
                <div class="duration">18:45</div>
            </div>
            <div class="video-meta">
                <h3 class="video-title">Advanced JavaScript Concepts: Closures and Scope</h3>
                <div class="video-info">
                    <span class="channel-name">Code Masters</span>
                    <span class="views">189.2K views</span>
                    <span class="date">5 days ago</span>
                </div>
            </div>
            <div class="video-actions">
                <button class="action-btn"><i class="fas fa-thumbs-up"></i> Like</button>
                <button class="action-btn"><i class="fas fa-comment"></i> Comment</button>
                <button class="action-btn"><i class="fas fa-share"></i> Share</button>
                <button class="action-btn"><i class="fas fa-download"></i> Download</button>
            </div>
        </div>

        <!-- Video Card 3 -->
        <div class="video-card">
            <div class="video-thumbnail">
                <div class="play-icon"><i class="fas fa-play"></i></div>
                <div class="duration">22:15</div>
            </div>
            <div class="video-meta">
                <h3 class="video-title">React Hooks Deep Dive: useState, useEffect & Custom Hooks</h3>
                <div class="video-info">
                    <span class="channel-name">Frontend Pro</span>
                    <span class="views">312.8K views</span>
                    <span class="date">1 week ago</span>
                </div>
            </div>
            <div class="video-actions">
                <button class="action-btn"><i class="fas fa-thumbs-up"></i> Like</button>
                <button class="action-btn"><i class="fas fa-comment"></i> Comment</button>
                <button class="action-btn"><i class="fas fa-share"></i> Share</button>
                <button class="action-btn"><i class="fas fa-download"></i> Download</button>
            </div>
        </div>

        <!-- Video Card 4 -->
        <div class="video-card">
            <div class="video-thumbnail">
                <div class="play-icon"><i class="fas fa-play"></i></div>
                <div class="duration">15:32</div>
            </div>
            <div class="video-meta">
                <h3 class="video-title">Database Design Fundamentals: SQL & NoSQL Comparison</h3>
                <div class="video-info">
                    <span class="channel-name">Data Vault</span>
                    <span class="views">156.4K views</span>
                    <span class="date">3 days ago</span>
                </div>
            </div>
            <div class="video-actions">
                <button class="action-btn"><i class="fas fa-thumbs-up"></i> Like</button>
                <button class="action-btn"><i class="fas fa-comment"></i> Comment</button>
                <button class="action-btn"><i class="fas fa-share"></i> Share</button>
                <button class="action-btn"><i class="fas fa-download"></i> Download</button>
            </div>
        </div>

        <!-- Video Card 5 -->
        <div class="video-card">
            <div class="video-thumbnail">
                <div class="play-icon"><i class="fas fa-play"></i></div>
                <div class="duration">19:28</div>
            </div>
            <div class="video-meta">
                <h3 class="video-title">Cybersecurity Essentials: Protecting Your Web Applications</h3>
                <div class="video-info">
                    <span class="channel-name">Security Zone</span>
                    <span class="views">421.9K views</span>
                    <span class="date">1 day ago</span>
                </div>
            </div>
            <div class="video-actions">
                <button class="action-btn"><i class="fas fa-thumbs-up"></i> Like</button>
                <button class="action-btn"><i class="fas fa-comment"></i> Comment</button>
                <button class="action-btn"><i class="fas fa-share"></i> Share</button>
                <button class="action-btn"><i class="fas fa-download"></i> Download</button>
            </div>
        </div>

        <!-- Video Card 6 -->
        <div class="video-card">
            <div class="video-thumbnail">
                <div class="play-icon"><i class="fas fa-play"></i></div>
                <div class="duration">25:10</div>
            </div>
            <div class="video-meta">
                <h3 class="video-title">Machine Learning Basics: From Theory to Implementation</h3>
                <div class="video-info">
                    <span class="channel-name">AI Academy</span>
                    <span class="views">567.3K views</span>
                    <span class="date">4 days ago</span>
                </div>
            </div>
            <div class="video-actions">
                <button class="action-btn"><i class="fas fa-thumbs-up"></i> Like</button>
                <button class="action-btn"><i class="fas fa-comment"></i> Comment</button>
                <button class="action-btn"><i class="fas fa-share"></i> Share</button>
                <button class="action-btn"><i class="fas fa-download"></i> Download</button>
            </div>
        </div>

        </div>
    </div>
</section>

    <script>
        // ==================== MODE TOGGLE ====================
        const modeToggle = document.getElementById('modeToggle');
        const body = document.body;

        modeToggle.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            modeToggle.innerHTML = body.classList.contains('light-mode') 
                ? '<i class="fas fa-sun"></i>' 
                : '<i class="fas fa-moon"></i>';
            localStorage.setItem('theme', body.classList.contains('light-mode') ? 'light' : 'dark');
        });

        // Initialize theme - Dark mode is default
        // Load theme from localStorage
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            body.classList.add('light-mode');
            modeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
            // Dark mode is default
            body.classList.remove('light-mode');
            modeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            localStorage.setItem('theme', 'dark');
        }

        // ==================== CONTROL BUTTONS ====================
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });

        // ==================== SMOOTH SCROLL NAVIGATION ====================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            });
        });

        // ==================== NAVIGATION ACTIVE STATE ====================
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section');
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id') || '';
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.href.includes(current) && current !== '') {
                    link.classList.add('active');
                } else if (current === '' && link.href.includes('#home')) {
                    link.classList.add('active');
                }
            });
        });

        // ==================== ANIMATION ON SCROLL ====================
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe category cards
        document.querySelectorAll('.category-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // ==================== SEARCH BAR FUNCTIONALITY ====================
        const searchInput = document.querySelector('.search-bar input');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.style.boxShadow = '0 0 25px rgba(0, 255, 255, 0.3)';
            });

            searchInput.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.style.boxShadow = '0 0 20px rgba(0, 255, 255, 0.25)';
                }
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    console.log('Search for:', this.value);
                }
            });
        }

        // ==================== BUTTON RIPPLE EFFECT ====================
        function createRipple(event) {
            const button = event.currentTarget;
            
            const circle = document.createElement('span');
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = diameter + 'px';
            circle.style.left = (event.clientX - button.offsetLeft - radius) + 'px';
            circle.style.top = (event.clientY - button.offsetTop - radius) + 'px';
            circle.classList.add('ripple');

            const ripple = button.querySelector('.ripple');
            if (ripple) {
                ripple.remove();
            }
            button.appendChild(circle);
        }

        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', createRipple);
        });

        // ==================== CARD LINK HOVER EFFECT ====================
        document.querySelectorAll('.card-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // ==================== MOUSE FOLLOW EFFECT ON HERO ====================
        const hero = document.querySelector('.hero');
        if (hero) {
            document.addEventListener('mousemove', (e) => {
                const mouseX = e.clientX / window.innerWidth;
                const mouseY = e.clientY / window.innerHeight;
                
                const bgX = mouseX * 5;
                const bgY = mouseY * 5;
                
                hero.style.backgroundPosition = `${bgX}% ${bgY}%`;
            });
        }

        // ==================== INITIAL ANIMATIONS ====================
        window.addEventListener('load', () => {
            document.querySelectorAll('.hero-content > *').forEach((el, index) => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            });
        });

        // ==================== CLOCK UPDATE ====================
        function updateClock() {
            const clockElement = document.getElementById('clock');
            if (clockElement) {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                clockElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
        }

        // Update clock every second
        updateClock();
        setInterval(updateClock, 1000);
    </script>

    <!-- LOADING OVERLAY -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <div class="loading-text">LOADING...</div>
        </div>
    </div>

    <!-- WELCOME INTRO OVERLAY -->
    <div id="introOverlay" class="intro-overlay">
        <!-- Decorative background circles (bottom-left) -->
        <div class="intro-bg-shapes">
            <div class="bg-circle circle-1"></div>
            <div class="bg-circle circle-2"></div>
            <div class="bg-circle circle-3"></div>
        </div>

        <div class="intro-container">
            <!-- Left Content -->
            <div class="intro-left">
                <p class="intro-welcome-text" data-en="Welcome to our" data-rw="Murakaza neza kuri" data-fr="Bienvenue à notre">Welcome to our</p>
                <h1 class="intro-title" data-en="CS DREAM" data-rw="CS DREAM" data-fr="CS DREAM">
                    <span class="cs-text">CS</span>
                    <span class="dream-text">DREAM</span>
                </h1>
                <p class="intro-subtitle" data-en="Discover videos, tutorials and creative ideas — crafted for curious minds." data-rw="Getera videwo, amahigiro n'ibitekerezo bisigura — biteguwe kubuntu bivugwa ubwenge." data-fr="Découvrez des vidéos, des tutoriels et des idées créatives — conçues pour les esprits curieux.">Discover videos, tutorials and creative ideas — crafted for curious minds.</p>
                <div style="display: flex; flex-direction: column; gap: 16px; width: 100%; max-width: 500px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <a href="register.php" class="intro-btn" data-en="Sign Up" data-rw="Kwiyandikisha" data-fr="S'inscrire">
                            Sign Up
                        </a>
                        <button class="intro-skip-btn" id="introSkipBtn" data-en="Skip" data-rw="Kurengana" data-fr="Passer">
                            Skip
                        </button>
                    </div>
                    <button class="intro-signin-message" id="introSigninMessage" data-en="You have already signed in" data-rw="Wiyandikiye" data-fr="Vous êtes déjà connecté">
                        ✓ You have already signed in. Click here to continue.
                    </button>
                </div>
            </div>

            <!-- Right Content - Hero Card -->
            <div class="intro-right">
                <div class="hero-card">
                    <img src="images/cs dream.png" alt="CS DREAM Illustration" class="hero-image">
                    <div class="hero-card-glow"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="auth.js"></script>
    <script src="profile.js"></script>
    <script src="content-data.js"></script>
    <script src="page-content.js"></script>
    <script src="card-update-system.js"></script>
    <script>
        // Initialize the automatic card update system
        CardUpdateSystem.init();
        
        // Render dynamic home videos
        window.addEventListener('DOMContentLoaded', async () => {
            await renderHomeVideos();
            // Watch for content changes from admin dashboard
            onContentChange(async () => {
                await renderHomeVideos();
            });
        });
    </script>

    <script src="auth.js"></script>
    <script src="state-manager.js"></script>
    <script>
        // ------------------------------------------------------------------
        // --- WELCOME INTRO FUNCTIONALITY ---
        // ------------------------------------------------------------------

        const introOverlay = document.getElementById('introOverlay');
        const introSkipBtn = document.getElementById('introSkipBtn');
        const introSigninMessage = document.getElementById('introSigninMessage');
        const introSignupBtn = document.querySelector('a.intro-btn');
        const loadingOverlay = document.getElementById('loadingOverlay');

        // Flag to track if intro is closed (so scroll overlay only works on home page)
        let introIsClosed = false;

        // Function to close intro with animation
        function closeIntro() {
            introOverlay.classList.add('hidden');
            introIsClosed = true; // Set flag when intro closes
            setTimeout(() => {
                introOverlay.style.display = 'none';
            }, 800);
        }

        // Show loading overlay on initial page load
        function showInitialLoadingOverlay() {
            loadingOverlay.classList.add('show');
            // Hide loading overlay after 2 seconds, then show intro
            setTimeout(() => {
                loadingOverlay.classList.remove('show');
            }, 2000);
        }

        // Check if user is already signed in and handle intro state
        async function checkSignedInStatus() {
            try {
                // Check if user session exists via auth
                const isLoggedIn = document.body.dataset.authenticated === 'true';

                if (isLoggedIn) {
                    // User is signed in - check if they've seen the intro
                    const introSeen = await StateManager.checkIntroSeen();

                    if (introSeen) {
                        // They've already seen it, so hide the entire intro
                        closeIntro();
                        return true;
                    }

                    // First time seeing the message, show it
                    introSignupBtn.style.display = 'none';
                    introSkipBtn.style.display = 'none';
                    introSigninMessage.classList.add('show');
                    
                    // Mark that they've seen this message
                    await StateManager.markIntroSeen();
                    return true;
                }
            } catch (e) {
                console.error('Error checking intro status:', e);
            }
            return false;
        }

        // Show loading overlay first on page load (delay 2 seconds)
        setTimeout(showInitialLoadingOverlay, 2000);

        // Auto-close intro overlay after 4 seconds if user takes no action
        window.addEventListener('load', () => {
            setTimeout(() => {
                if (introOverlay && !introOverlay.classList.contains('hidden')) {
                    closeIntro();
                }
            }, 4000);
        });

        // Check signed-in status on page load
        checkSignedInStatus();

        // Event listener for skip button - closes immediately and stays on home page
        introSkipBtn.addEventListener('click', async () => {
            await StateManager.markIntroSeen();
            closeIntro();
        });

        // Event listener for continue button - shows loading screen for 5 seconds, then closes intro
        introSigninMessage.addEventListener('click', async () => {
            await StateManager.markIntroSeen();
            // First close the intro
            closeIntro();
            // Then show the loading overlay
            loadingOverlay.classList.add('show');
            // Hide loading overlay after 2 seconds (2000 milliseconds)
            setTimeout(() => {
                loadingOverlay.classList.remove('show');
            }, 2000);
        });

        // Allow ESC key to close intro
        document.addEventListener('keydown', async (e) => {
            if (e.key === 'Escape' && introOverlay && !introOverlay.classList.contains('hidden')) {
                await StateManager.markIntroSeen();
                closeIntro();
            }
        });
    </script>

    <script>
        // ------------------------------------------------------------------
        // --- AUTHENTICATION FUNCTIONALITY ---
        // ------------------------------------------------------------------

        // Global auth state variables
        let isLoggedIn = false;
        let userCredentials = { username: '', profilePicture: '' };

        // DOM elements
        const userWidget = document.getElementById('userWidget');
        const userMenu = document.getElementById('userMenu');
        const navUsername = document.getElementById('navUsername');
        const navProfilePic = document.getElementById('navProfilePic');
        const navLogout = document.getElementById('navLogout');

        function updateAuthState(loggedIn, username) {
            isLoggedIn = loggedIn;
            if (loggedIn) {
                // SHOW authenticated UI
                // Hide login/signup buttons
                const loginBtn = document.querySelector('.btn-login');
                const signupBtn = document.querySelector('.btn-signup');
                if(loginBtn) loginBtn.style.display = 'none';
                if(signupBtn) signupBtn.style.display = 'none';
                
                if(userWidget) {
                    userWidget.classList.remove('hidden');
                    userWidget.style.display = 'flex';
                }
                
                // Update widget data
                if(navUsername) navUsername.textContent = username;
                if(navProfilePic) navProfilePic.src = userCredentials.profilePicture;
                
            } else {
                // SHOW unauthenticated UI
                // Show login/signup buttons
                const loginBtn = document.querySelector('.btn-login');
                const signupBtn = document.querySelector('.btn-signup');
                if(loginBtn) loginBtn.style.display = 'inline-block';
                if(signupBtn) signupBtn.style.display = 'inline-block';
                
                if(userWidget) {
                    userWidget.classList.add('hidden');
                    userWidget.style.display = 'none';
                }
            }
        }

        // User menu toggle and logout handling
        function closeUserMenu(){
            if(!userMenu) return;
            userMenu.classList.remove('visible');
            userMenu.setAttribute('aria-hidden','true');
            if(userWidget) userWidget.setAttribute('aria-expanded','false');
            // reset any inline positioning applied when opened
            userMenu.style.position = '';
            userMenu.style.top = '';
            userMenu.style.left = '';
            userMenu.style.right = '';
            userMenu.style.zIndex = '';
        }

        function openUserMenu(){
            if(!userMenu || !userWidget) return;
            // Make the menu fixed so it escapes any stacking / overflow context
            userMenu.style.position = 'fixed';
            userMenu.style.zIndex = '100000';
            userMenu.classList.add('visible');
            userMenu.setAttribute('aria-hidden','false');
            userWidget.setAttribute('aria-expanded','true');

            // Position the menu under the avatar using viewport coordinates
            const rect = userWidget.getBoundingClientRect();
            // ensure the menu has been rendered so we can measure its width
            const menuRect = userMenu.getBoundingClientRect();
            const top = Math.round(rect.bottom + 8);
            let left = Math.round(rect.right - menuRect.width);
            if (left < 8) left = 8; // don't overflow the left edge
            userMenu.style.top = top + 'px';
            userMenu.style.left = left + 'px';
            userMenu.style.right = 'auto';
        }

        // Toggle when clicking the header widget
        if(userWidget) {
            userWidget.addEventListener('click', (e)=>{
                e.stopPropagation();
                if(userMenu.classList.contains('visible')) closeUserMenu(); else openUserMenu();
            });
        }

        // Close the menu when clicking outside
        document.addEventListener('click', (e)=>{ if(userMenu && !userMenu.contains(e.target)) closeUserMenu(); });

        // Logout from the header menu
        if(navLogout) {
            navLogout.addEventListener('click', (e)=>{
                e.preventDefault();
                try{ clearSession(); }catch(err){}
                // Reset intro flags so intro can appear again after logout
                introIsClosed = false;
                localStorage.removeItem('cs_intro_seen_signed_in');
                // revert UI
                updateAuthState(false, null);
                closeUserMenu();
                alert('Logged out successfully.');
            });
        }

        // Initialize the state when the page loads (use persisted session if present)
        (function initAuthFromSession(){
            const session = readSession();
            if(session && session.username){
                // populate profile image and username
                userCredentials.profilePicture = profilePicFor(session.username);
                updateAuthState(true, session.username);
            } else {
                updateAuthState(false, null);
            }
        })();

    </script>

    <script>
    (function(){
        // Check if required elements exist before running video functionality
        const videoGrid = document.getElementById('videoGrid');
        const trendingGrid = document.getElementById('trendingGrid');
        const continueList = document.getElementById('continueList');
        const bookmarksList = document.getElementById('bookmarksList');

        // Only run if at least some video elements exist
        if (!videoGrid && !trendingGrid && !continueList && !bookmarksList) {
            return; // Skip video functionality if elements don't exist
        }

        // Sample dataset (would be replaced by backend data)
        const videos = [
            {id:'v1', title:'Intro to Python', category:'coding', tags:['beginner'], duration:'12:45', thumb:'images/top3.png', views:12400, likes:820, comments:34, trending:true},
            {id:'v2', title:'Ethical Hacking Basics', category:'hacking', tags:['beginner'], duration:'18:20', thumb:'images/kase.png', views:56000, likes:4200, comments:212, trending:true},
            {id:'v3', title:'Weekly Tech News', category:'news', tags:['advanced'], duration:'8:12', thumb:'images/real madrid.png', views:8200, likes:120, comments:12, trending:false},
            {id:'v4', title:'Advanced Algorithms', category:'coding', tags:['advanced'], duration:'45:02', thumb:'images/top3.png', views:23000, likes:1400, comments:98, trending:false}
        ];

        // Helpers for localStorage
        const ls = {
            get(k, def){ try{ return JSON.parse(localStorage.getItem(k))||def }catch(e){return def} },
            set(k,v){ try{ localStorage.setItem(k, JSON.stringify(v)) }catch(e){} }
        };

        // Render helpers
        // Variables already declared above

        // Render skeletons then content
        function showSkeletons(container, n=3){ if(container){ container.innerHTML = ''; for(let i=0;i<n;i++){ const s=document.createElement('div'); s.className='skeleton-card skeleton'; container.appendChild(s);} } }

        // Build a video card
        function buildCard(v){
            const a = document.createElement('a'); a.className='video-card'; a.href = 'video-player-2.php?type='+encodeURIComponent(v.category || 'home')+'&video='+encodeURIComponent(v.id); a.setAttribute('data-id',v.id);
            const thumbWrap = document.createElement('div'); thumbWrap.className='video-thumb-wrap';
            const img = document.createElement('img'); img.className='video-thumb'; img.src=v.thumb; img.alt=v.title;
            const duration = document.createElement('div'); duration.className='duration-badge'; duration.textContent = v.duration;
            const star = document.createElement('div'); star.className='bookmark'; star.innerHTML='⭐'; star.title='Save'; star.tabIndex=0;
            thumbWrap.appendChild(img); thumbWrap.appendChild(duration); thumbWrap.appendChild(star);

            const meta = document.createElement('div'); meta.className='video-meta';
            const h4 = document.createElement('h4'); h4.textContent = v.title; meta.appendChild(h4);
            const metaSub = document.createElement('div'); metaSub.className='meta-sub'; metaSub.style.opacity='.9'; metaSub.textContent = `${(v.views||0).toLocaleString()} views • ${v.duration}`; meta.appendChild(metaSub);

            const controls = document.createElement('div'); controls.className='video-controls';
            const likeBtn = document.createElement('button'); likeBtn.className='control-btn'; likeBtn.innerHTML = '❤ <span class="count">'+(v.likes||0)+'</span>'; likeBtn.ariaPressed='false';
            const shareBtn = document.createElement('button'); shareBtn.className='control-btn'; shareBtn.innerHTML='🔗 Share';
            controls.appendChild(likeBtn); controls.appendChild(shareBtn);
            meta.appendChild(controls);

            a.appendChild(thumbWrap); a.appendChild(meta);

            // events
            star.addEventListener('click', (e)=>{ e.preventDefault(); toggleBookmark(v); star.classList.toggle('booked'); renderBookmarks(); });
            star.addEventListener('keydown', (ev)=>{ if(ev.key==='Enter') star.click(); });
            likeBtn.addEventListener('click', ()=>{ animateCounter(likeBtn.querySelector('.count')); });
            shareBtn.addEventListener('click', (ev)=>{ ev.preventDefault(); showShareMenu(v); });
            a.addEventListener('click', ()=>{ addContinue(v); });
            return a;
        }

        function renderVideos(list){
            if(!videoGrid) return;
            videoGrid.innerHTML='';
            if(!list.length){ document.getElementById('emptyState').classList.remove('hidden'); return; } else { document.getElementById('emptyState').classList.add('hidden'); }
            list.forEach(v=> videoGrid.appendChild(buildCard(v)));
            // animate counts
            document.querySelectorAll('.video-card .count').forEach(el=>animateCounter(el));
        }

        function renderTrending(){ if(trendingGrid){ trendingGrid.innerHTML=''; const tr = videos.filter(v=>v.trending); tr.forEach(v=> trendingGrid.appendChild(buildCard(v))); } }

        // Bookmarks
        function bookmarks(){ return ls.get('cs_bookmarks', []); }
        function toggleBookmark(v){ const b=bookmarks(); const idx=b.findIndex(x=>x.id===v.id); if(idx>-1){ b.splice(idx,1); } else { b.push({id:v.id,title:v.title,thumb:v.thumb}); } ls.set('cs_bookmarks', b); }
        function renderBookmarks(){ if(!bookmarksList) return; const b=bookmarks(); bookmarksList.innerHTML=''; if(!b.length){ bookmarksList.innerHTML='<div style="opacity:.8">No saved videos</div>'; return;} b.forEach(it=>{ const div=document.createElement('div'); div.style.display='flex'; div.style.gap='8px'; div.style.alignItems='center'; div.innerHTML=`<img src="${it.thumb}" style="width:48px;height:36px;object-fit:cover;border-radius:6px"><div style="flex:1">${it.title}</div><a href="video-player-2.php?video=${it.id}" style="color:#347">Watch</a>`; bookmarksList.appendChild(div); }); }

        // Continue watching
        function addContinue(v){ const c=ls.get('cs_continue',[]); const exists=c.find(x=>x.id===v.id); if(!exists) c.unshift({id:v.id,title:v.title,thumb:v.thumb,progress:Math.floor(Math.random()*60)}); if(c.length>8) c.pop(); ls.set('cs_continue', c); renderContinue(); }
        function renderContinue(){ if(!continueList) return; const c=ls.get('cs_continue',[]); continueList.innerHTML=''; if(!c.length){ continueList.innerHTML='<div style="opacity:.8">No recent activity</div>'; return;} c.forEach(it=>{ const d=document.createElement('div'); d.className='continue-card'; d.innerHTML=`<img src="${it.thumb}" style="width:64px;height:48px;object-fit:cover;border-radius:6px"><div style="flex:1"><strong style="display:block">${it.title}</strong><div style="font-size:13px;opacity:.8">${it.progress}% watched</div></div>`; continueList.appendChild(d); }); }

        // Search suggestions
        const suggestions = ['Intro to Python','Ethical Hacking Basics','Weekly Tech News','Advanced Algorithms','Hack tricks Intro','Coding Tutorial'];
        let suggestionsBox = null;
        function ensureSuggestionsBox(){ if(suggestionsBox) return; suggestionsBox=document.createElement('div'); suggestionsBox.className='search-suggestions'; suggestionsBox.id='searchSuggestions'; document.body.appendChild(suggestionsBox); }
        function positionSuggestions(){ const input = document.getElementById('searchInput'); if(!input||!suggestionsBox) return; const r=input.getBoundingClientRect(); suggestionsBox.style.left = (r.left)+'px'; suggestionsBox.style.top = (r.bottom+6+window.scrollY)+'px'; suggestionsBox.style.width = (r.width)+'px'; }
        document.getElementById('searchInput').addEventListener('input', function(e){ ensureSuggestionsBox(); const val=e.target.value.trim().toLowerCase(); if(!val){ suggestionsBox.style.display='none'; return; } const out = suggestions.filter(s=>s.toLowerCase().includes(val)).slice(0,6); suggestionsBox.innerHTML = '<ul>'+out.map(o=>`<li tabindex="0">${o}</li>`).join('')+'</ul>'; suggestionsBox.style.display='block'; positionSuggestions(); suggestionsBox.querySelectorAll('li').forEach(li=>{ li.addEventListener('click', ()=>{ document.getElementById('searchInput').value=li.textContent; suggestionsBox.style.display='none'; filterByQuery(li.textContent); }); li.addEventListener('keydown',(e)=>{ if(e.key==='Enter') li.click(); }); }); });
        window.addEventListener('resize', positionSuggestions); window.addEventListener('scroll', positionSuggestions);

        // Filtering
        function filterByCategory(cat){
            const pills=document.querySelectorAll('.category-pill');
            pills.forEach(p=>{
                const df = p.dataset.filter || p.textContent.trim().toLowerCase();
                p.classList.toggle('active', df===cat || (cat==='all' && p.classList.contains('active')));
            });
            if(cat==='all'){ renderVideos(videos); }
            else { renderVideos(videos.filter(v=> v.category===cat || (v.tags||[]).includes(cat) )); }
        }
        window.filterByCategory = filterByCategory; // keep existing onclicks functional
        function filterByQuery(q){ const ql=q.toLowerCase(); renderVideos(videos.filter(v=> v.title.toLowerCase().includes(ql) || (v.tags||[]).some(t=>t.includes(ql)) )); }

        // Notifications
        function loadNotifs(){ const n = ls.get('cs_notifs',[{id:1,msg:'New course: Advanced Web Security',time:'2h'},{id:2,msg:'You earned 50 points',time:'1d'}]); const notifDropdown = document.getElementById('notifDropdown') || document.getElementById('notifDropdownFloat'); if(notifDropdown) notifDropdown.innerHTML = n.map(it=>`<div class="notif-item">${it.msg}<div style="font-size:12px;opacity:.7">${it.time}</div></div>`).join(''); const notifCount = document.getElementById('notifCount') || document.getElementById('notifCountFloat'); if(notifCount) notifCount.textContent = n.length; }
        const notifBell = document.getElementById('notifBell') || document.getElementById('notifBellFloat');
        if(notifBell){ notifBell.addEventListener('click', ()=>{ const notifDropdown = document.getElementById('notifDropdown') || document.getElementById('notifDropdownFloat'); if(notifDropdown) notifDropdown.classList.toggle('visible'); notifBell.setAttribute('aria-expanded', String(notifDropdown.classList.contains('visible'))); }); }

        // Share
        function showShareMenu(v){ const menu = document.createElement('div'); menu.style.position='fixed'; menu.style.right='20px'; menu.style.top='80px'; menu.style.background='#fff'; menu.style.padding='8px'; menu.style.borderRadius='8px'; menu.style.boxShadow='0 8px 30px rgba(0,0,0,0.12)'; menu.innerHTML = `<div style="display:flex;flex-direction:column;gap:6px"><button id="copyLink">Copy Link</button><a href="https://wa.me/?text=${encodeURIComponent(location.origin+'/video-player-2.php?video='+v.id)}" target="_blank">WhatsApp</a><a href="https://twitter.com/intent/tweet?text=${encodeURIComponent(v.title+' '+location.origin+'/video-player-2.php?video='+v.id)}" target="_blank">X / Twitter</a></div>`;
            document.body.appendChild(menu);
            const rm = ()=> menu.remove(); setTimeout(()=>document.addEventListener('click', rm, {once:true}),120);
            menu.querySelector('#copyLink').addEventListener('click', ()=>{ navigator.clipboard?.writeText(location.origin+'/video-player-2.php?video='+v.id).then(()=>{ alert('Link copied'); rm(); }); });
        }

        // Simple counter animation
        function animateCounter(el){ const val = parseInt(el.textContent||'0',10)||0; const start=0; const duration=700; let startTS=null; function step(ts){ if(!startTS) startTS=ts; const progress = Math.min((ts-startTS)/duration,1); el.textContent = Math.floor(start + (val-start)*progress); if(progress<1) requestAnimationFrame(step); } requestAnimationFrame(step); }

        // Theme switcher and accessibility
        document.querySelectorAll('.theme-btn[data-theme]').forEach(btn=> btn.addEventListener('click', ()=>{ document.body.classList.remove('theme-blue','theme-purple','theme-green'); document.body.classList.add('theme-'+btn.dataset.theme); ls.set('cs_theme', btn.dataset.theme); }));
        const biggerBtn = document.getElementById('biggerTextBtn'); if(biggerBtn) biggerBtn.addEventListener('click', ()=>{ const bigger = document.body.classList.toggle('bigger-text'); biggerBtn.setAttribute('aria-pressed', String(bigger)); ls.set('cs_bigger', bigger); });

        // Initial render
        showSkeletons(videoGrid,4); setTimeout(()=>{ renderTrending(); renderVideos(videos); renderBookmarks(); renderContinue(); loadNotifs(); }, 700);

        // Load saved prefs
        try{ const th=ls.get('cs_theme'); if(th) document.body.classList.add('theme-'+th); if(ls.get('cs_bigger')) document.body.classList.add('bigger-text'); }catch(e){}

    })();
    </script>

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

    <script>
    // Small page-level handlers: subscribe & outside-click behaviors
    (function(){
        // Subscribe form
        const form = document.getElementById('subscribeForm');
        if(form){ form.addEventListener('submit', function(e){ e.preventDefault(); const email = document.getElementById('subscribeEmail').value.trim(); if(!email) return alert('Please enter an email'); try{ localStorage.setItem('cs_subscribe_email', email); }catch(e){} alert('Thanks — check your email!'); form.reset(); }); }

        // Click outside notifications / suggestions to close
        document.addEventListener('click', (e)=>{
            const notif = document.getElementById('notifDropdown'); const bell = document.getElementById('notifBell');
            if(notif && bell && !notif.contains(e.target) && !bell.contains(e.target)) notif.classList.remove('visible');
            const sug = document.getElementById('searchSuggestions'); if(sug && !sug.contains(e.target) && e.target.id !== 'searchInput') sug.style.display='none';
        });
    })();
    </script>

    <script>
        (function(){
            const ADMIN_PASSWORD = 'kevin@040';
            const ADMIN_AUTH_KEY = 'cs_dream_admin_auth_v1';
            const ADMIN_AUTH_EXP_KEY = 'cs_dream_admin_auth_exp_v1';
            const ADMIN_SESSION_TIMEOUT_MS = 30 * 60 * 1000; // 30 minutes
            const MAX_ATTEMPTS = 3;
            const LOCKOUT_DURATION_MS = 2 * 60 * 1000; // 2 minutes

            let wrongAttempts = 0;
            let lockoutUntil = 0;

            const adminLink = document.getElementById('adminLink');
            const overlay = document.getElementById('adminModalOverlay');
            const passwordInput = document.getElementById('adminModalPassword');
            const errorEl = document.getElementById('adminModalError');
            const submitBtn = document.getElementById('adminModalSubmit');

            function getAdminAuth() {
                try {
                    const data = JSON.parse(localStorage.getItem(ADMIN_AUTH_KEY));
                    if (data && data.auth === true && Number(data.expiry) > Date.now()) {
                        return true;
                    }
                } catch (err) {
                    // ignore parse
                }
                return false;
            }

            function setAdminAuth() {
                const expiry = Date.now() + ADMIN_SESSION_TIMEOUT_MS;
                localStorage.setItem(ADMIN_AUTH_KEY, JSON.stringify({ auth: true, expiry }));
            }

            function clearAdminAuth() {
                localStorage.removeItem(ADMIN_AUTH_KEY);
            }

            function updateError(message) {
                if (errorEl) errorEl.textContent = message;
            }

            function showModal() {
                if (!overlay) return;
                overlay.style.display = 'flex';
                passwordInput && passwordInput.focus();
            }

            function hideModal() {
                if (!overlay) return;
                overlay.style.display = 'none';
                updateError('');
                passwordInput && (passwordInput.value = '');
            }

            function checkLockout() {
                if (Date.now() < lockoutUntil) {
                    const seconds = Math.ceil((lockoutUntil - Date.now()) / 1000);
                    updateError(`Too many attempts. Try again in ${seconds} seconds.`);
                    return true;
                }
                return false;
            }

            function authorizeAndRedirect() {
                setAdminAuth();
                hideModal();
                window.location.href = 'admin.php';
            }

            if (adminLink) {
                adminLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (getAdminAuth()) {
                        window.location.href = 'admin.php';
                        return;
                    }
                    showModal();
                });
            }

            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (checkLockout()) return;

                    const attempt = passwordInput ? passwordInput.value.trim() : '';
                    if (attempt === ADMIN_PASSWORD) {
                        wrongAttempts = 0;
                        lockoutUntil = 0;
                        authorizeAndRedirect();
                    } else {
                        wrongAttempts += 1;
                        if (wrongAttempts >= MAX_ATTEMPTS) {
                            lockoutUntil = Date.now() + LOCKOUT_DURATION_MS;
                            updateError('Incorrect password. Locked for 2 minutes.');
                            return;
                        }
                        updateError('Incorrect password');
                        passwordInput && (passwordInput.value = '');
                        passwordInput && passwordInput.focus();
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) {
                        hideModal();
                    }
                });
            }

            if (passwordInput) {
                passwordInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        submitBtn.click();
                    }
                });
            }

            // Keep admin session current each load
            if (getAdminAuth()) {
                setAdminAuth();
            }

            // Add Ctrl+B keyboard shortcut to open admin modal
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
                    e.preventDefault();
                    // Check if already authenticated
                    if (getAdminAuth()) {
                        window.location.href = 'admin.php';
                    } else {
                        // Show password modal
                        showModal();
                    }
                }
            });
        })();
    </script>
    <script src="clock.js" defer></script>
</body>
</html>

