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
    --danger:#ff3366;  /* red accent */
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

  /* HERO SECTION */
  .hero-banner{
    background:linear-gradient(135deg, rgba(0,255,102,0.1), rgba(255,51,102,0.05));border:2px solid rgba(0,255,102,0.15);border-radius:18px;padding:45px;margin-bottom:30px;
    box-shadow:0 0 30px rgba(0,255,102,0.15);text-align:center;transition:all .3s;position:relative;overflow:hidden;
  }
  .hero-banner::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.05), transparent);opacity:0;transition:opacity .3s;z-index:-1;
  }
  .hero-banner:hover{
    border-color:rgba(0,255,102,0.25);box-shadow:0 0 40px rgba(0,255,102,0.25);
  }
  .hero-banner:hover::before{
    opacity:1;
  }
  .hero-banner h1{
    font-size:2.5em;margin:0 0 10px 0;color:var(--neon);text-shadow:0 0 20px rgba(0,255,102,0.4);
    background:linear-gradient(135deg, var(--neon), var(--accent));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  }
  .hero-banner .subtitle{font-size:1.2em;color:var(--accent);margin-bottom:15px;font-weight:600;transition:all .3s;}
  .hero-banner:hover .subtitle{color:#fff;text-shadow:0 0 10px rgba(0,255,102,0.2);}
  .hero-banner p{color:var(--text);line-height:1.6;max-width:800px;margin:0 auto 20px;font-size:1em;}
  .stats-row{display:flex;justify-content:center;gap:40px;flex-wrap:wrap;margin-top:25px;}
  .stat-box{text-align:center;}
  .stat-number{font-size:2em;color:var(--neon);font-weight:800;}
  .stat-label{color:var(--text);font-size:0.9em;margin-top:5px;}

  /* DIFFICULTY FILTER TABS */
  .difficulty-filter{display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;}
  .difficulty-btn{
    padding:10px 18px;border-radius:10px;border:1.5px solid rgba(0,255,102,0.2);background:transparent;color:var(--text);cursor:pointer;transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);font-weight:600;position:relative;overflow:hidden;
  }
  .difficulty-btn::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.1), transparent);opacity:0;transition:opacity .3s;z-index:-1;
  }
  .difficulty-btn:hover, .difficulty-btn.active{
    background:rgba(0,255,102,0.15);color:var(--neon);border-color:var(--neon);box-shadow:0 4px 15px rgba(0,255,102,0.2);transform:translateY(-2px);
  }
  .difficulty-btn:hover::before{
    opacity:1;
  }

  /* COURSE CARDS GRID */
  .courses-grid{display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:20px;margin-bottom:30px;}
  .course-card{
    background:linear-gradient(135deg, rgba(0,255,102,0.02), rgba(127,255,212,0.01));border:1.5px solid rgba(0,255,102,0.1);border-radius:16px;padding:0;overflow:hidden;
    transition:all .35s cubic-bezier(0.34, 1.56, 0.64, 1);cursor:pointer;position:relative;isolation:isolate;
  }
  .course-card::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.1), rgba(127,255,212,0.05));opacity:0;transition:opacity .3s;z-index:-1;
  }
  .course-card:hover{
    transform:translateY(-10px) scale(1.02);box-shadow:0 25px 60px rgba(0,255,102,0.2);border-color:rgba(0,255,102,0.2);
  }
  .course-card:hover::before{
    opacity:1;
  }
  .course-header{
    background:linear-gradient(135deg, rgba(0,255,102,0.12), rgba(255,51,102,0.08));padding:22px;border-bottom:1.5px solid rgba(0,255,102,0.15);
    min-height:60px;display:flex;align-items:center;transition:all .3s;
  }
  .course-header:hover{
    background:linear-gradient(135deg, rgba(0,255,102,0.18), rgba(255,51,102,0.12));
  }
  .course-icon{font-size:2em;margin-right:12px;}
  .course-title{color:var(--neon);font-weight:700;font-size:1.1em;}
  .course-body{padding:16px;}
  .course-description{color:var(--text);font-size:0.95em;margin-bottom:12px;line-height:1.5;}
  .course-meta{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;font-size:0.85em;}
  .difficulty-badge{padding:4px 10px;border-radius:4px;font-weight:600;font-size:0.8em;}
  .difficulty-beginner{background:rgba(34,139,34,0.3);color:#4caf50;}
  .difficulty-intermediate{background:rgba(255,165,0,0.3);color:#ffa500;}
  .difficulty-advanced{background:rgba(220,20,60,0.3);color:#ff6b6b;}
  .progress-bar{width:100%;height:4px;background:rgba(255,255,255,0.1);border-radius:2px;overflow:hidden;margin-bottom:10px;}
  .progress-fill{height:100%;background:var(--neon);width:65%;}
  .course-footer{padding:12px 16px;background:rgba(0,0,0,0.2);border-top:1px solid rgba(0,255,102,0.05);display:flex;justify-content:space-between;align-items:center;}
  .course-btn{
    padding:8px 14px;background:linear-gradient(135deg, var(--neon), var(--accent));color:#000;border:none;border-radius:8px;cursor:pointer;font-weight:700;transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);position:relative;overflow:hidden;font-size:0.9em;
  }
  .course-btn::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, transparent, rgba(255,255,255,0.3), transparent);transform:translateX(-100%);transition:transform .4s;opacity:0;
  }
  .course-btn:hover::before{
    transform:translateX(100%);opacity:1;
  }
  .course-btn:hover{
    transform:translateY(-3px);box-shadow:0 8px 20px rgba(0,255,102,0.3);letter-spacing:0.5px;
  }

  /* LEARNING PATHS */
  .learning-paths{
    background:linear-gradient(135deg, rgba(0,0,0,0.35), rgba(0,0,0,0.15));border:1.5px solid rgba(0,255,102,0.12);border-radius:14px;padding:28px;margin-bottom:30px;
    transition:all .3s;position:relative;
  }
  .learning-paths:hover{
    border-color:rgba(0,255,102,0.2);box-shadow:0 12px 40px rgba(0,255,102,0.15);
  }
  .learning-paths h3{color:var(--neon);margin-top:0;text-shadow:0 0 12px rgba(0,255,102,0.15);}
  .path-timeline{display:flex;flex-direction:column;gap:20px;}
  .path-step{display:flex;gap:20px;align-items:flex-start;}
  .step-number{
    width:40px;height:40px;background:var(--neon);color:#000;border-radius:50%;
    display:flex;align-items:center;justify-content:center;font-weight:800;flex-shrink:0;
  }
  .step-content h4{margin:0 0 8px 0;color:var(--neon);}
  .step-content p{margin:0;color:var(--text);font-size:0.95em;line-height:1.5;}

  /* TOPICS SECTION */
  .topics-section{margin-bottom:30px;}
  .topics-grid{display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:12px;margin-top:15px;}
  .topic-btn{
    padding:14px;border-radius:10px;background:linear-gradient(135deg, rgba(0,255,102,0.1), rgba(0,255,102,0.03));border:1.5px solid rgba(0,255,102,0.2);color:var(--neon);cursor:pointer;font-weight:600;
    transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);text-align:center;position:relative;overflow:hidden;
  }
  .topic-btn::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.15), rgba(0,255,102,0.05));opacity:0;transition:opacity .3s;z-index:-1;
  }
  .topic-btn:hover{
    background:linear-gradient(135deg, rgba(0,255,102,0.18), rgba(0,255,102,0.08));border-color:var(--neon);box-shadow:0 8px 25px rgba(0,255,102,0.25);transform:translateY(-3px);
  }
  .topic-btn:hover::before{
    opacity:1;
  }

  /* FEATURED SECTION */
  .featured-section{
    background:linear-gradient(135deg, rgba(0,255,102,0.12), rgba(255,51,102,0.06));border:2px solid rgba(0,255,102,0.18);border-radius:14px;padding:28px;margin-bottom:30px;
    transition:all .3s;position:relative;overflow:hidden;
  }
  .featured-section::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.08), transparent);opacity:0;transition:opacity .3s;z-index:-1;
  }
  .featured-section:hover{
    border-color:rgba(0,255,102,0.3);box-shadow:0 15px 50px rgba(0,255,102,0.15);
  }
  .featured-section:hover::before{
    opacity:1;
  }
  .featured-section h3{color:var(--neon);margin-top:0;text-shadow:0 0 12px rgba(0,255,102,0.15);}
  .featured-courses{display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:15px;}

  /* TESTIMONIALS */
  .testimonials-section{margin-bottom:30px;}
  .testimonials-grid{display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:15px;margin-top:15px;}
  .testimonial-card{
    background:linear-gradient(135deg, rgba(255,255,255,0.04), rgba(255,255,255,0.01));border:1.5px solid rgba(0,255,102,0.12);border-radius:12px;padding:18px;
    transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);position:relative;overflow:hidden;
  }
  .testimonial-card::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.08), transparent);opacity:0;transition:opacity .3s;z-index:-1;
  }
  .testimonial-card:hover{
    border-color:rgba(0,255,102,0.2);transform:translateY(-6px);box-shadow:0 12px 35px rgba(0,255,102,0.15);
  }
  .testimonial-card:hover::before{
    opacity:1;
  }
  .testimonial-header{display:flex;align-items:center;gap:10px;margin-bottom:12px;}
  .testimonial-avatar{width:40px;height:40px;border-radius:50%;background:var(--neon);display:flex;align-items:center;justify-content:center;color:#000;font-weight:700;}
  .testimonial-name{color:var(--neon);font-weight:600;}
  .testimonial-role{color:var(--text);font-size:0.85em;}
  .testimonial-text{color:var(--text);font-size:0.95em;line-height:1.5;font-style:italic;}
  .stars{color:#ffc107;margin-top:8px;}

  /* RESOURCES SECTION */
  .resources-section{
    background:linear-gradient(135deg, rgba(0,0,0,0.35), rgba(0,0,0,0.15));border:1.5px solid rgba(0,255,102,0.12);border-radius:14px;padding:28px;margin-bottom:30px;
    transition:all .3s;position:relative;
  }
  .resources-section:hover{
    border-color:rgba(0,255,102,0.2);box-shadow:0 12px 40px rgba(0,255,102,0.15);
  }
  .resources-grid{display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:15px;margin-top:15px;}
  .resource-item{
    background:linear-gradient(135deg, rgba(0,255,102,0.1), rgba(0,255,102,0.03));border:1.5px solid rgba(0,255,102,0.15);border-radius:10px;padding:18px;text-align:center;
    transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);cursor:pointer;position:relative;overflow:hidden;
  }
  .resource-item::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.15), transparent);opacity:0;transition:opacity .3s;z-index:-1;
  }
  .resource-item:hover{
    background:linear-gradient(135deg, rgba(0,255,102,0.15), rgba(0,255,102,0.08));border-color:var(--neon);transform:translateY(-5px);box-shadow:0 10px 30px rgba(0,255,102,0.2);
  }
  .resource-item:hover::before{
    opacity:1;
  }
  .resource-icon{font-size:2em;margin-bottom:10px;}
  .resource-title{color:var(--neon);font-weight:600;margin-bottom:8px;}
  .resource-desc{color:var(--text);font-size:0.85em;}

  /* --- Skeleton Loading Placeholders --- */
  .skeleton { background: linear-gradient(90deg, #222 25%, #333 50%, #222 75%); background-size: 200% 100%; animation: shimmer 2s infinite; }
  @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
  .skeleton-card { width: 100%; height: 260px; border-radius: 16px; margin-bottom: 12px; }
  .skeleton-thumb { width: 100%; height: 200px; border-radius: 8px; margin-bottom: 8px; }
  .skeleton-title { width: 80%; height: 16px; border-radius: 4px; margin-bottom: 8px; }
  .skeleton-text { width: 60%; height: 12px; border-radius: 4px; margin-bottom: 6px; }
  .skeleton-buttons { display: flex; gap: 8px; height: 32px; }
  .skeleton-btn { flex: 1; height: 100%; border-radius: 6px; }

  /* FAQ SECTION */
  .faq-section{margin-bottom:30px;}
  .faq-item{
    background:linear-gradient(135deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));border:1.5px solid rgba(0,255,102,0.1);border-radius:10px;margin-bottom:12px;
    transition:all .3s;position:relative;overflow:hidden;
  }
  .faq-item::before{
    content:'';position:absolute;left:0;top:0;width:3px;height:100%;background:linear-gradient(180deg, var(--neon), var(--accent));opacity:0;transition:opacity .2s;
  }
  .faq-item:hover{
    border-color:rgba(0,255,102,0.2);background:linear-gradient(135deg, rgba(0,255,102,0.06), rgba(0,255,102,0.02));
  }
  .faq-item:hover::before{
    opacity:1;
  }
  .faq-question{
    padding:18px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;color:var(--neon);font-weight:600;transition:all .2s;
  }
  .faq-question:hover{
    color:#fff;text-shadow:0 0 8px rgba(0,255,102,0.2);
  }
  .faq-toggle{transition:transform .3s cubic-bezier(0.34, 1.56, 0.64, 1);}
  .faq-answer{padding:0 18px;max-height:0;overflow:hidden;transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);color:var(--text);line-height:1.6;}
  .faq-item.active .faq-answer{padding:0 18px 18px;max-height:500px;}
  .faq-item.active .faq-toggle{transform:rotate(180deg);}

  /* CALL TO ACTION */
  .cta-section{
    background:linear-gradient(135deg, rgba(0,255,102,0.12), rgba(255,51,102,0.08));border:2px solid rgba(0,255,102,0.2);border-radius:14px;padding:35px;text-align:center;margin-bottom:30px;
    transition:all .3s;position:relative;overflow:hidden;
  }
  .cta-section::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.05), transparent);opacity:0;transition:opacity .3s;z-index:-1;
  }
  .cta-section:hover{
    border-color:rgba(0,255,102,0.35);box-shadow:0 20px 60px rgba(0,255,102,0.2);
  }
  .cta-section:hover::before{
    opacity:1;
  }
  .cta-section h3{color:var(--neon);font-size:1.5em;margin-bottom:15px;text-shadow:0 0 12px rgba(0,255,102,0.15);}
  .cta-section p{color:var(--text);margin-bottom:20px;font-size:1.05em;line-height:1.6;}
  .cta-btn{
    padding:14px 32px;background:linear-gradient(135deg, var(--neon), var(--accent));color:#000;border:none;border-radius:10px;font-weight:700;cursor:pointer;font-size:1em;transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);position:relative;overflow:hidden;
  }
  .cta-btn::before{
    content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:rgba(255,255,255,0.25);transition:left .5s;z-index:-1;
  }
  .cta-btn:hover::before{
    left:100%;
  }
  .cta-btn:hover{
    transform:translateY(-4px);box-shadow:0 12px 35px rgba(0,255,102,0.3);letter-spacing:0.5px;
  }

  /* CERTIFICATIONS */
  .certifications-section{margin-bottom:30px;}
  .cert-grid{display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:15px;margin-top:15px;}
  .cert-badge{
    background:linear-gradient(135deg, rgba(255,215,0,0.12), rgba(255,215,0,0.06));border:2px solid rgba(255,215,0,0.35);border-radius:12px;padding:22px;text-align:center;
    transition:all .3s cubic-bezier(0.34, 1.56, 0.64, 1);position:relative;overflow:hidden;
  }
  .cert-badge::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(255,215,0,0.1), transparent);opacity:0;transition:opacity .3s;z-index:-1;
  }
  .cert-badge:hover{
    border-color:rgba(255,215,0,0.5);transform:translateY(-6px);box-shadow:0 12px 30px rgba(255,215,0,0.2);
  }
  .cert-badge:hover::before{
    opacity:1;
  }
  .cert-icon{font-size:3em;margin-bottom:10px;}
  .cert-name{color:var(--neon);font-weight:600;margin-bottom:5px;}
  .cert-time{color:var(--text);font-size:0.85em;}

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

  /* UPLOAD AREA ANIMATIONS */
  .upload-area{animation:uploadGlow 2s ease-in-out infinite;}
  .upload-area:hover{background:linear-gradient(180deg, rgba(0,0,0,0.3), rgba(0,0,0,0.15)) !important;border-color:var(--neon) !important;transform:scale(1.02);box-shadow:0 0 20px rgba(0,255,102,0.2);}
  @keyframes uploadGlow{0%{box-shadow:0 0 0 rgba(0,255,102,0.1);}50%{box-shadow:0 0 15px rgba(0,255,102,0.15);}100%{box-shadow:0 0 0 rgba(0,255,102,0.1);}}

  /* COURSE CARD ADVANCED ANIMATIONS */
  .course-card{animation:cardFloat 3s ease-in-out infinite;}
  .course-card:nth-child(2){animation-delay:0.3s;}
  .course-card:nth-child(3){animation-delay:0.6s;}
  @keyframes cardFloat{0%, 100%{transform:translateY(0);}50%{transform:translateY(-8px);}}

  .course-card:hover{animation:none;}
  .course-icon{display:inline-block;animation:bounce 2s ease-in-out infinite;}
  @keyframes bounce{0%, 100%{transform:translateY(0);}50%{transform:translateY(-8px);}}

  /* VIDEO CARD HOVER EFFECTS */
  .video-card:hover .image-scroll{filter:brightness(1.2);animation:videoGlow 0.3s ease;}
  @keyframes videoGlow{0%{filter:brightness(1);}100%{filter:brightness(1.2) saturate(1.3);}}

  .video-card:hover h4{background:linear-gradient(90deg, var(--neon), rgba(0,255,102,0.6));color:#000;font-weight:800;}

  /* STATS COUNTER ANIMATION */
  .stat-number{animation:countUp 2s ease-out;}
  @keyframes countUp{0%{opacity:0;transform:scale(0.5);}50%{opacity:0.8;}100%{opacity:1;transform:scale(1);}}

  /* MODULE SECTION ENTRANCE ANIMATION */
  #phone-hacking, #computer-hacking, #app-hacking{animation:slideInUp 0.6s ease-out;}
  @keyframes slideInUp{0%{opacity:0;transform:translateY(30px);}100%{opacity:1;transform:translateY(0);}}
  #computer-hacking{animation-delay:0.1s;}
  #app-hacking{animation-delay:0.2s;}

  /* BUTTON ANIMATIONS */
  .course-btn{position:relative;overflow:hidden;}
  .course-btn::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;background:rgba(255,255,255,0.3);border-radius:50%;transform:translate(-50%, -50%);transition:width 0.6s, height 0.6s;}
  .course-btn:hover::before{width:300px;height:300px;}
  .course-btn:active{transform:scale(0.98);}

  .cta-btn{position:relative;overflow:hidden;}
  .cta-btn::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:rgba(255,255,255,0.2);transition:left 0.5s;}
  .cta-btn:hover::before{left:100%;}

  /* SCROLL ANIMATION FOR SECTIONS */
  .course-body, .course-footer{animation:fadeInDelay 0.6s ease-out;}
  @keyframes fadeInDelay{0%{opacity:0;}100%{opacity:1;}}

  /* DIFFICULTY BADGE GLOW */
  .difficulty-badge{box-shadow:0 0 0 rgba(0,255,102,0.3);animation:badgeGlow 2s ease-in-out infinite;}
  .difficulty-beginner{animation:badgeGlow 2s ease-in-out infinite;}
  .difficulty-intermediate{animation:badgeGlowOrange 2s ease-in-out infinite;}
  .difficulty-advanced{animation:badgeGlowRed 2s ease-in-out infinite;}
  @keyframes badgeGlow{0%{box-shadow:0 0 0 rgba(76,175,80,0.3);}50%{box-shadow:0 0 8px rgba(76,175,80,0.5);}100%{box-shadow:0 0 0 rgba(76,175,80,0.3);}}
  @keyframes badgeGlowOrange{0%{box-shadow:0 0 0 rgba(255,165,0,0.3);}50%{box-shadow:0 0 8px rgba(255,165,0,0.5);}100%{box-shadow:0 0 0 rgba(255,165,0,0.3);}}
  @keyframes badgeGlowRed{0%{box-shadow:0 0 0 rgba(255,107,107,0.3);}50%{box-shadow:0 0 8px rgba(255,107,107,0.5);}100%{box-shadow:0 0 0 rgba(255,107,107,0.3);}}

  /* PROGRESS BAR ANIMATION */
  .progress-fill{animation:progress 2s ease-out;}
  @keyframes progress{0%{width:0;}100%{width:100%;}}

  /* SIDEBAR LINK HOVER */
  .sidebar a{position:relative;}
  .sidebar a::before{content:'';position:absolute;left:0;bottom:0;width:0;height:2px;background:var(--neon);transition:width 0.3s;}
  .sidebar a:hover::before{width:100%;}

  /* TEXT GLOW EFFECT */
  h1, h2, h3{position:relative;}
  h1{text-shadow:0 0 10px rgba(0,255,102,0.2), 0 0 20px rgba(0,255,102,0.1);}
  h2{text-shadow:0 0 8px rgba(0,255,102,0.15);}

  /* HACKING CARD GRID */
  .hacking-grid{display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:20px;margin-bottom:30px;}
  
  /* HACKING CARD COMPONENT */
  .hacking-card{
    background:linear-gradient(135deg, rgba(0,255,102,0.02), rgba(127,255,212,0.01));border:1.5px solid rgba(0,255,102,0.1);border-radius:16px;overflow:hidden;cursor:pointer;
    transition:all .35s cubic-bezier(0.34, 1.56, 0.64, 1);display:flex;flex-direction:column;position:relative;isolation:isolate;
  }
  .hacking-card::before{
    content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(0,255,102,0.1), transparent);opacity:0;transition:opacity .3s;z-index:-1;
  }
  .hacking-card:hover{
    transform:translateY(-12px) scale(1.02);box-shadow:0 28px 70px rgba(0,255,102,0.25);border-color:rgba(0,255,102,0.2);
  }
  .hacking-card:hover::before{
    opacity:1;
  }

  .card-image{
    width:100%;height:200px;background:linear-gradient(135deg, rgba(0,0,0,0.3), rgba(0,0,0,0.1));overflow:hidden;position:relative;display:flex;align-items:center;justify-content:center;
  }
  .card-image img{
    width:100%;height:100%;object-fit:cover;transition:transform .35s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  .hacking-card:hover .card-image img{
    transform:scale(1.12);
  }

  .play-button{
    position:absolute;font-size:3em;opacity:0.7;transition:all .35s cubic-bezier(0.34, 1.56, 0.64, 1);filter:drop-shadow(0 0 12px rgba(0,255,102,0.4));
  }
  .hacking-card:hover .play-button{
    opacity:1;font-size:3.8em;filter:drop-shadow(0 0 24px rgba(0,255,102,0.7));transform:scale(1.1);
  }

  .card-content{
    padding:16px;
    flex:1;
    display:flex;
    flex-direction:column;
  }

  .card-content h3{
    color:var(--neon);
    font-weight:700;
    margin:0 0 10px 0;
    font-size:1.05em;
  }

  .card-content p{
    color:var(--text);
    font-size:0.9em;
    line-height:1.5;
    margin:0 0 12px 0;
    flex:1;
  }

  .card-meta{
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:0.85em;
    color:var(--text);
    padding-top:12px;
    border-top:1px solid rgba(0,255,102,0.1);
  }

  .card-meta span{
    display:flex;
    align-items:center;
    gap:5px;
  }

  /* DESCRIPTION TEXT FADE-IN */
  .course-description{animation:fadeIn 0.8s ease-out;}
  @keyframes fadeIn{0%{opacity:0;transform:translateY(5px);}100%{opacity:1;transform:translateY(0);}}

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

/* Floating Back to Top Button */
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
        <label class="switch"><input id="darkModeToggle" type="checkbox"><span class="slider round"></span></label>
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
          <a href="#" data-en="HTML5" data-rw="HTML5" data-fr="HTML5" data-lg="HTML5">HTML5</a>
          <a href="#" data-en="HTML and CSS" data-rw="HTML na CSS" data-fr="HTML et CSS" data-lg="HTML and CSS">HTML and CSS</a>
          <a href="#" data-en="JAVA" data-rw="JAVA" data-fr="JAVA" data-lg="JAVA">JAVA</a>
        </div>
      </div>
    </nav>
  </header>

  <!-- LEFT SIDEBAR MENU (hidden by default) -->
  <div class="sidebar-menu" id="sidebarMenu" aria-hidden="true">
    <span class="close-btn" id="closeBtn">✖</span>

    <a href="index.php" data-en="Home" data-rw="Ahabanza" data-fr="Accueil" data-lg="Oludda">🏠 Home</a>

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

  <!-- MAIN CONTENT -->
  <div class="container">
    <aside class="sidebar">
      <h3>🔥 Trending Videos</h3>
      <ul style="padding-left:12px;">
        <li><a href="#">Football Highlights</a></li>
        <li><a href="#">C++ Beginner Tutorial</a></li>
        <li><a href="#">Top Mobile Hack Tricks</a></li>
        <li><a href="#">Music Video of the Week</a></li>
      </ul>

      <h3 style="margin-top:12px;">⭐ Recommended</h3>
      <ul style="padding-left:12px;">
        <li><a href="#">Video of the Day</a></li>
        <li><a href="#">Editor’s Choice</a></li>
      </ul>

      <h3 style="margin-top:12px;">⚡ Quick Actions</h3>
      <ul style="padding-left:12px;">
        <li><a href="#">Watch Now</a></li>
        <li><a href="#">Learn Coding Today</a></li>
      </ul>
    </aside>

    <main class="content">
      <!-- HERO BANNER -->
      <div class="hero-banner">
        <h1>🛡️ Learn hacking tricks</h1>
        <p class="subtitle">Phone • Computer • Applications</p>
        <p>Learn  hacking tricks through hands-on labs, real-world scenarios, and practical demonstrations. Master security hacking tricks vulnerabilities and become a certified  hacker ticker.</p>
      </div>

      <!-- STATISTICS -->
      <div class="stats-section" style="background:linear-gradient(135deg, rgba(0,255,102,0.08), rgba(255,51,102,0.04));border:1px solid rgba(0,255,102,0.1);border-radius:12px;padding:25px;margin-bottom:30px;display:grid;grid-template-columns:repeat(auto-fit, minmax(150px, 1fr));gap:20px;text-align:center;">
        <div><div style="font-size:2em;color:var(--neon);font-weight:800;">0</div><div style="color:var(--text);margin-top:5px;">Video Tutorials</div></div>
        <div><div style="font-size:2em;color:var(--neon);font-weight:800;">0+</div><div style="color:var(--text);margin-top:5px;">Hands-on Labs</div></div>
        <div><div style="font-size:2em;color:var(--neon);font-weight:800;">0+</div><div style="color:var(--text);margin-top:5px;">Active Students</div></div>
        <div><div style="font-size:2em;color:var(--neon);font-weight:800;">0%</div><div style="color:var(--text);margin-top:5px;">Certification Rate</div></div>
      </div>

      <!-- PHONE HACKING SECTION -->
      <div id="phone-section" style="margin-bottom:40px;">
        <h2 style="color:var(--neon);margin-bottom:25px;display:flex;align-items:center;gap:10px;"><span>📱</span> Phone Hacking Tutorials</h2>
        <div class="hacking-grid"></div>
      </div>

      <!-- COMPUTER HACKING MODULE -->
      <div id="computer-hacking" style="margin-bottom:30px;">
        <h2 style="color:var(--neon);display:flex;align-items:center;gap:10px;"><span>💻</span> Computer Hacking Module</h2>
        <div style="background:linear-gradient(135deg, rgba(255,51,102,0.06), rgba(255,51,102,0.02));border-left:4px solid var(--danger);padding:15px;margin-bottom:20px;border-radius:8px;">
          <p style="margin:0;color:var(--text);">Learn Windows and Linux exploitation, privilege escalation, network attacks, and malware analysis. Strengthen your offensive security skills with proven techniques.</p>
        </div>
        <div class="hacking-grid"></div>
      </div>

      <!-- APPLICATION HACKING MODULE -->
      <div id="app-hacking" style="margin-bottom:30px;">
        <h2 style="color:var(--neon);display:flex;align-items:center;gap:10px;"><span>⚙️</span> Application Hacking Module</h2>
        <div style="background:linear-gradient(135deg, rgba(127,255,212,0.06), rgba(127,255,212,0.02));border-left:4px solid var(--accent);padding:15px;margin-bottom:20px;border-radius:8px;">
          <p style="margin:0;color:var(--text);">Master web and mobile application security testing, API exploitation, and reverse engineering. Discover critical vulnerabilities and protect applications.</p>
        </div>
        
        <div class="hacking-grid">
          <div class="hacking-card" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=hacking&video=reverse-engineering';">
            <div class="card-image">
              <!-- PLACEHOLDER: Upload your reverse engineering video thumbnail here -->
              <img src="images/hacking ai is too easy.png" alt="Reverse Engineering" style="width:100%;height:100%;object-fit:cover;background:linear-gradient(135deg, rgba(127,255,212,0.1), rgba(0,0,0,0.3));">
              <div class="play-button">▶️</div>
            </div>
            <div class="card-content">
              <h3>Reverse Engineering</h3>
              <p> Learn how to hack with an AI tips in an easy way, and it is good to know it. Watch the video and enjoy it.”</p>
              <div class="card-meta">
                <span>🔙 Decompile</span>
                <span>⏱️ 26 min 38 sec</span>
              </div>
            </div>
          </div>

          <div class="hacking-card" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=hacking&video=api-testing';">
            <div class="card-image">
              <!-- PLACEHOLDER: Upload your API testing video thumbnail here -->
              <img src="images/how to unlock bet on air.png" alt="API Testing & Exploitation" style="width:100%;height:100%;object-fit:cover;background:linear-gradient(135deg, rgba(127,255,212,0.1), rgba(0,0,0,0.3));">
              <div class="play-button">▶️</div>
            </div>
            <div class="card-content">
              <h3>Lucky putcher tool</h3>
              <p>Learn how to hack any betting company applications and get sure football or other matches for free without paying.”</p>
              <div class="card-meta">
                <span>🔌 TS</span>
                <span>⏱️ 43 min</span>
              </div>
            </div>
          </div>

          <div class="hacking-card" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=hacking&video=mobile-app-security';">
            <div class="card-image">
              <!-- PLACEHOLDER: Upload your mobile app security video thumbnail here -->
              <img src="images/vpn itanga mega zubuntu.png" alt="Mobile App Security" style="width:100%;height:100%;object-fit:cover;background:linear-gradient(135deg, rgba(127,255,212,0.1), rgba(0,0,0,0.3));">
              <div class="play-button">▶️</div>
            </div>
            <div class="card-content">
              <h3>Free VPN for MTN & Tigo</h3>
              <p>Learn how to use a free VPN to access on MTN and Tigo restricted content and protect your online privacy</p>
              <div class="card-meta">
                <span>📲 Mobile</span>
                <span>⏱️ 46 min</span>
              </div>
            </div>
          </div>

          <div class="hacking-card" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=hacking&video=web-app-security';">
            <div class="card-image">
              <!-- PLACEHOLDER: Upload your web app security video thumbnail here -->
              <img src="images/luck patcher aviator.png" alt="Web App Security" style="width:100%;height:100%;object-fit:cover;background:linear-gradient(135deg, rgba(127,255,212,0.1), rgba(0,0,0,0.3));">
              <div class="play-button">▶️</div>
            </div>
            <div class="card-content">
              <h3>Web App Security</h3>
              <p> How To Get Frɛɛ Coins To Open (Aviator Predictor Version 1.0) Using Lucky Patcher</p>
              <div class="card-meta">
                <span>🌐 Web</span>
                <span>⏱️ 50 min</span>
              </div>
            </div>
          </div>

          <div class="hacking-card" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=hacking&video=database-hacking';">
            <div class="card-image">
              <!-- PLACEHOLDER: Upload your database hacking video thumbnail here -->
              <img src="images/how to download  lucky patcher.png" alt="Database Hacking" style="width:100%;height:100%;object-fit:cover;background:linear-gradient(135deg, rgba(127,255,212,0.1), rgba(0,0,0,0.3));">
              <div class="play-button">▶️</div>
            </div>
            <div class="card-content">
              <h3>install lucky patcher</h3>
              <p>SQL injection, database enumeration, privilege escalation, and data extraction techniques.</p>
              <div class="card-meta">
                <span>luck patcher😊</span>
                <span>⏱️ 37 min</span>
              </div>
            </div>
          </div>

          <div class="hacking-card" style="cursor:pointer;" onclick="window.location.href='video-player-2.php?type=hacking&video=authentication-bypass';">
            <div class="card-image">
              <!-- PLACEHOLDER: Upload your authentication bypass video thumbnail here -->
              <img src="images/how to insatll MT manager.png" alt="Authentication Bypass" style="width:100%;height:100%;object-fit:cover;background:linear-gradient(135deg, rgba(127,255,212,0.1), rgba(0,0,0,0.3));">
              <div class="play-button">▶️</div>
            </div>
            <div class="card-content">
              <h3>MT manager</h3>
              <p>Break authentication mechanisms, bypass login systems, and exploit authorization flaws.</p>
              <div class="card-meta">
                <span>🔑 Auth</span>
                <span>⏱️ 34 min</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- VIDEO GALLERY SECTION -->
      <div style="margin-top:40px;">
        <h2 style="color:var(--neon);">📹 Latest Tutorial Videos</h2>
        <div class="video-grid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(260px, 1fr));gap:15px;"></div>
      </div>

      <!-- CALL TO ACTION -->
      <div class="cta-section">
        <h3>🚀 Ready to Master Ethical Hacking?</h3>
        <p>Join thousands of ethical hackers. Start learning today with hands-on labs and real-world scenarios.</p>
        <button class="cta-btn" onclick="alert('Enrollment feature coming soon!')">Start Free Trial →</button>
      </div>
    </main>
  </div>

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

/* NEW HACKING ACADEMY FEATURES */

// Filter courses by difficulty
function filterCourses(difficulty) {
  document.querySelectorAll('.course-card').forEach(card => {
    if (difficulty === 'all' || card.getAttribute('data-difficulty') === difficulty) {
      card.style.display = 'block';
      card.style.animation = 'slideInUp 0.5s ease-out';
    } else {
      card.style.display = 'none';
    }
  });
}

// Upload area drag and drop
document.querySelectorAll('.upload-area').forEach(area => {
  area.addEventListener('dragover', (e) => {
    e.preventDefault();
    area.style.background = 'linear-gradient(180deg, rgba(0,255,102,0.15), rgba(0,255,102,0.08))';
    area.style.borderColor = 'var(--neon)';
  });
  
  area.addEventListener('dragleave', () => {
    area.style.background = '';
    area.style.borderColor = '';
  });
  
  area.addEventListener('drop', (e) => {
    e.preventDefault();
    const files = e.dataTransfer.files;
    alert(`📁 ${files.length} file(s) ready for upload:\n${Array.from(files).map(f => f.name).join('\n')}\n\nUpload functionality coming soon!`);
    area.style.background = '';
    area.style.borderColor = '';
  });
});

// Course enrollment simulation
document.querySelectorAll('.course-btn').forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.target.style.background = 'var(--accent)';
    e.target.textContent = '✓ Enrolled';
    setTimeout(() => {
      e.target.style.background = 'var(--neon)';
      e.target.textContent = 'Learn →';
    }, 2000);
  });
});

// Smooth scroll to sections
document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener('click', (e) => {
    const targetId = link.getAttribute('href');
    const target = document.querySelector(targetId);
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      target.style.animation = 'fadeIn 0.6s ease-out';
    }
  });
});

// Course card click to show details
document.querySelectorAll('.course-card').forEach(card => {
  card.style.cursor = 'pointer';
  card.addEventListener('click', () => {
    const title = card.querySelector('.course-title').textContent;
    const description = card.querySelector('.course-description').textContent;
    alert(`📚 ${title}\n\n${description}\n\nClick "Learn" button to enroll in this course.`);
  });
});

// Animated progress bars
window.addEventListener('load', () => {
  document.querySelectorAll('.progress-fill').forEach(bar => {
    const width = bar.style.width;
    bar.style.width = '0';
    setTimeout(() => {
      bar.style.transition = 'width 1.5s ease-out';
      bar.style.width = width;
    }, 100);
  });
});

// Video card play button functionality
document.querySelectorAll('.video-card').forEach(card => {
  const title = card.querySelector('h4').textContent;
  card.addEventListener('click', () => {
    alert(`🎬 Now playing: ${title}\n\nVideo player feature coming soon!`);
  });
});

// Scroll reveal animation for modules
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.animation = 'slideInUp 0.6s ease-out forwards';
      observer.unobserve(entry.target);
    }
  });
}, observerOptions);

document.querySelectorAll('#phone-section, #computer-hacking, #app-hacking').forEach(el => {
  observer.observe(el);
});

console.log('🛡️ Ethical Hacking Academy loaded successfully!');

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

