<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" href="images/cs dream.png" type="image/png">
  <title>CS Dream - Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #3d3d3d 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      background: linear-gradient(135deg, rgba(26, 26, 26, 0.95) 0%, rgba(45, 45, 45, 0.95) 100%);
      border-radius: 20px;
      border: 2px solid rgba(212, 175, 55, 0.3);
      box-shadow: 0 0 50px rgba(212, 175, 55, 0.3), inset 0 1px 1px rgba(255, 255, 255, 0.1);
      width: 100%;
      max-width: 1000px;
      display: flex;
      position: relative;
      overflow: hidden;
    }

    .sign-in-section {
      flex: 1;
      padding: 50px 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-right: 2px solid rgba(212, 175, 55, 0.2);
    }

    .sign-up-card {
      flex: 1;
      background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(240, 213, 126, 0.1) 100%);
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .logo-container {
      position: relative;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      max-width: 350px;
      max-height: 350px;
    }

    .logo-container::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg, transparent 30%, rgba(212, 175, 55, 0.4) 50%, transparent 70%);
      animation: goldShimmerLogo 3s infinite;
      pointer-events: none;
    }

    .logo-img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      filter: drop-shadow(0 0 30px rgba(212, 175, 55, 0.5)) brightness(1.1);
      transition: all 0.3s ease;
      position: relative;
      z-index: 1;
    }

    .logo-img:hover {
      filter: drop-shadow(0 0 40px rgba(212, 175, 55, 0.8)) brightness(1.2);
      transform: scale(1.05);
    }

    .card-title {
      color: #d4af37;
      font-size: 32px;
      font-weight: 600;
      margin-bottom: 25px;
      text-shadow: 0 0 20px rgba(212, 175, 55, 0.6);
    }

    .card-description {
      color: rgba(212, 175, 55, 0.8);
      font-size: 15px;
      margin-bottom: 35px;
      line-height: 1.6;
      max-width: 280px;
    }

    .sign-up-btn {
      background: transparent;
      color: #d4af37;
      border: 2px solid #d4af37;
      padding: 12px 40px;
      border-radius: 25px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 1px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .sign-up-btn:hover {
      background: rgba(212, 175, 55, 0.2);
      transform: translateY(-2px);
      box-shadow: 0 10px 40px rgba(212, 175, 55, 0.5);
    }

    .sign-up-btn:active {
      transform: translateY(0);
    }

    form {
      background: transparent;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 100%;
      text-align: center;
    }

    h1 {
      color: #d4af37;
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 20px;
      text-shadow: 0 0 20px rgba(212, 175, 55, 0.6);
      animation: goldGlow 2s ease-in-out infinite;
    }

    .social-icons {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin: 20px 0;
    }

    .social-icon {
      width: 40px;
      height: 40px;
      border: 2px solid #d4af37;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      text-decoration: none;
      color: #d4af37;
      transition: all 0.3s ease;
      background: rgba(212, 175, 55, 0.1);
    }

    .social-icon:hover {
      background: rgba(212, 175, 55, 0.25);
      transform: scale(1.1);
      box-shadow: 0 0 20px rgba(212, 175, 55, 0.6);
    }

    .email-text {
      color: rgba(212, 175, 55, 0.7);
      font-size: 13px;
      margin: 15px 0 20px 0;
      display: block;
    }

    input {
      background: rgba(212, 175, 55, 0.1);
      border: 2px solid rgba(212, 175, 55, 0.3);
      padding: 14px 16px;
      margin: 8px 0;
      width: 100%;
      border-radius: 8px;
      font-size: 14px;
      color: #fff;
      transition: all 0.3s ease;
    }

    input:focus {
      outline: none;
      background: rgba(212, 175, 55, 0.15);
      border-color: #d4af37;
      box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
    }

    input::placeholder {
      color: rgba(212, 175, 55, 0.5);
    }

    .forgot-password {
      color: #d4af37;
      text-decoration: none;
      font-size: 13px;
      margin-top: 10px;
      align-self: flex-end;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .forgot-password:hover {
      color: #f0d57e;
      text-shadow: 0 0 10px rgba(212, 175, 55, 0.6);
    }

    .sign-in-btn {
      background: linear-gradient(135deg, #d4af37 0%, #f0d57e 100%);
      color: #1a1a1a;
      border: none;
      padding: 12px 50px;
      border-radius: 25px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 1px;
      cursor: pointer;
      margin-top: 20px;
      transition: all 0.3s ease;
      box-shadow: 0 0 30px rgba(212, 175, 55, 0.5);
      position: relative;
      overflow: hidden;
    }

    .sign-in-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      animation: goldShimmer 2s infinite;
    }

    .sign-in-btn:hover {
      background: linear-gradient(135deg, #f0d57e 0%, #ffd700 100%);
      transform: translateY(-2px);
      box-shadow: 0 10px 40px rgba(212, 175, 55, 0.7);
    }

    .sign-in-btn:active {
      transform: translateY(0);
    }

    .form-switch {
      margin-top: 15px;
      font-size: 13px;
      color: rgba(212, 175, 55, 0.6);
    }

    .field-wrapper {
      position: relative;
      width: 100%;
      margin: 8px 0;
    }

    .field-error {
      font-size: 12px;
      color: #ff6b6b;
      margin-top: 4px;
      text-align: left;
      display: none;
      min-height: 16px;
    }

    .field-error.show {
      display: block;
    }

    .input-group {
      position: relative;
      display: flex;
      align-items: center;
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      background: transparent;
      border: none;
      color: #d4af37;
      cursor: pointer;
      font-size: 16px;
      padding: 8px;
    }

    input.error {
      border-color: #ff6b6b !important;
      background: rgba(255, 107, 107, 0.08) !important;
    }

    input.success {
      border-color: #2ee07a !important;
    }

    .error-message {
      color: #ff6b6b;
      font-size: 13px;
      margin-top: 10px;
      text-align: center;
      display: none;
    }

    .error-message.show {
      display: block;
    }

    .success-message {
      color: #2ee07a;
      font-size: 13px;
      margin-top: 10px;
      text-align: center;
      display: none;
    }

    .success-message.show {
      display: block;
    }

    .sign-in-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .sign-up-link {
      color: #d4af37;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .sign-up-link:hover {
      color: #f0d57e;
      text-shadow: 0 0 10px rgba(212, 175, 55, 0.6);
      text-decoration: underline;
    }

    .remember-forgot {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      margin: 12px 0;
      gap: 12px;
      font-size: 13px;
    }

    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      color: rgba(212, 175, 55, 0.7);
    }

    @media (max-width: 768px) {
      .container {
        max-width: 100%;
        flex-direction: column;
      }

      .sign-in-section {
        border-right: none;
        border-bottom: 2px solid rgba(212, 175, 55, 0.2);
        padding: 30px 20px;
      }

      .sign-up-card {
        padding: 30px 20px;
      }

      h1 {
        font-size: 24px;
      }

      .card-title {
        font-size: 24px;
      }
    }

    @keyframes goldGlow {
      0%, 100% {
        text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
      }
      50% {
        text-shadow: 0 0 30px rgba(212, 175, 55, 0.8);
      }
    }

    @keyframes goldShimmer {
      0% {
        left: -100%;
      }
      100% {
        left: 100%;
      }
    }

    @keyframes goldShimmerLogo {
      0% {
        transform: translate(-50%, -50%) rotate(0deg);
      }
      100% {
        transform: translate(-50%, -50%) rotate(360deg);
      }
    }
    /* Floating Back to Top Button */
    #backToTop {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #d4af37, #f0d500);
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #fff;
        box-shadow: 0 8px 30px rgba(212, 175, 55, 0.4);
        z-index: 999;
        transition: all 0.3s ease;
    }
    #backToTop:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(212, 175, 55, 0.6);
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

<div class="container">
  <div class="sign-in-section">
    <form id="loginForm" class="sign-in-form" onsubmit="event.preventDefault(); login()">
      <h1>Login</h1>

      <div class="social-icons">
        <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
      </div>

      <span class="email-text">or use your email account</span>
      
      <div class="field-wrapper">
        <input type="text" id="loginUsername" placeholder="Email or Username" required />
        <div class="field-error" id="loginUsernameError"></div>
      </div>

      <div class="field-wrapper">
        <div class="input-group">
          <input type="password" id="loginPassword" placeholder="Password" required />
          <button type="button" class="password-toggle" id="togglePassword" onclick="togglePasswordVisibility('loginPassword', this)">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <div class="field-error" id="loginPasswordError"></div>
      </div>

      <div class="remember-forgot">
        <label class="remember"><input id="rememberMe" type="checkbox"> Remember me</label>
        <a href="#" class="forgot-password" onclick="showForm('forgotForm'); return false;">Forgot your password?</a>
      </div>
      <div id="loginMessage"></div>
      <button type="submit" class="sign-in-btn" id="loginBtn">LOGIN</button>
      <p class="form-switch"><span>Don't have an account?</span> <a href="#" class="sign-up-link" onclick="showForm('signupForm'); return false;">Sign Up</a></p>
    </form>

    <form id="signupForm" class="sign-in-form" onsubmit="event.preventDefault(); signup()" style="display:none">
      <h1>Create Account</h1>

      <div class="social-icons">
        <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
      </div>

      <span class="email-text">or use your email account</span>
      
      <div class="field-wrapper">
        <input type="text" id="signupUsername" placeholder="Choose username" minlength="3" required />
        <div class="field-error" id="signupUsernameError"></div>
      </div>

      <div class="field-wrapper">
        <input type="text" id="signupName" placeholder="Your full name" required />
        <div class="field-error" id="signupNameError"></div>
      </div>

      <div class="field-wrapper">
        <input type="email" id="signupEmail" placeholder="you@example.com" required />
        <div class="field-error" id="signupEmailError"></div>
      </div>

      <div class="field-wrapper">
        <div class="input-group">
          <input type="password" id="signupPassword" placeholder="Min 6 characters" minlength="6" required />
          <button type="button" class="password-toggle" onclick="togglePasswordVisibility('signupPassword', this)">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <div class="field-error" id="signupPasswordError"></div>
      </div>

      <div id="signupMessage"></div>
      <button type="submit" class="sign-in-btn">REGISTER</button>
      <p class="form-switch"><span>Already have an account?</span> <a href="#" class="sign-up-link" onclick="showForm('loginForm'); return false;">Sign In</a></p>
    </form>

    <form id="forgotForm" class="sign-in-form" onsubmit="event.preventDefault(); requestReset()" style="display:none">
      <h1>Forgot Password</h1>

      <span class="email-text">Enter your account email</span>
      
      <div class="field-wrapper">
        <input type="email" id="forgotEmail" placeholder="you@example.com" required />
        <div class="field-error" id="forgotEmailError"></div>
      </div>

      <div id="forgotMessage"></div>
      <button type="submit" class="sign-in-btn">SEND RESET CODE</button>
      <p class="form-switch"><a href="#" class="sign-up-link" onclick="showForm('loginForm'); return false;">Back to Login</a></p>
    </form>

    <form id="otpForm" class="sign-in-form" onsubmit="event.preventDefault(); verifyOTP()" style="display:none">
      <h1>Verify Code</h1>

      <span class="email-text" id="otpEmailText"></span>
      
      <div class="field-wrapper">
        <input type="text" id="otpCode" placeholder="Enter 6-digit code" maxlength="6" required />
        <div class="field-error" id="otpCodeError"></div>
      </div>

      <div id="otpMessage"></div>
      <button type="submit" class="sign-in-btn">VERIFY CODE</button>
      <p class="form-switch"><a href="#" class="sign-up-link" onclick="showForm('loginForm'); return false;">Back to Login</a></p>
    </form>

    <form id="resetForm" class="sign-in-form" onsubmit="event.preventDefault(); resetPassword()" style="display:none">
      <h1>Reset Password</h1>

      <span class="email-text">Enter your new password</span>
      
      <div class="field-wrapper">
        <div class="input-group">
          <input type="password" id="newPassword" placeholder="New password (min 6 characters)" minlength="6" required />
          <button type="button" class="password-toggle" onclick="togglePasswordVisibility('newPassword', this)">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <div class="field-error" id="newPasswordError"></div>
      </div>

      <div class="field-wrapper">
        <div class="input-group">
          <input type="password" id="confirmPassword" placeholder="Confirm password" minlength="6" required />
          <button type="button" class="password-toggle" onclick="togglePasswordVisibility('confirmPassword', this)">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <div class="field-error" id="confirmPasswordError"></div>
      </div>

      <div id="resetMessage"></div>
      <button type="submit" class="sign-in-btn">RESET PASSWORD</button>
      <p class="form-switch"><a href="#" class="sign-up-link" onclick="showForm('loginForm'); return false;">Back to Login</a></p>
    </form>
  </div>

  <div class="sign-up-card">
    <div class="logo-container">
      <img src="images/logo.png" alt="CS Dream Logo" class="logo-img" />
    </div>
  </div>
</div>

  <script>
    const SESSION_KEY = 'cs_session';
    const USERS_KEY = 'cs_users';
    const THEME_KEY = 'cs_theme';

    function showForm(id){
      ['loginForm','signupForm','forgotForm','otpForm','resetForm'].forEach(x=>{
        const el = document.getElementById(x);
        if(el) el.style.display = (x === id) ? 'block' : 'none';
      });
      ['loginMessage','signupMessage','forgotMessage','otpMessage','resetMessage'].forEach(m=>{
        const el = document.getElementById(m);
        if(el){ el.innerText=''; el.className=''; }
      });
    }

    function readUsers(){ try{ return JSON.parse(localStorage.getItem(USERS_KEY) || '[]'); }catch(e){ return []; } }
    function saveUsers(u){ localStorage.setItem(USERS_KEY, JSON.stringify(u)); }
    function saveSession(obj){
      const expiry = Date.now() + (30 * 24 * 60 * 60 * 1000);
      const payload = { ...obj, expires: expiry };
      localStorage.setItem(SESSION_KEY, JSON.stringify(payload));
    }
    function readSession(){
      try{
        const s = JSON.parse(localStorage.getItem(SESSION_KEY));
        if(!s) return null;
        if(Date.now() > s.expires){ localStorage.removeItem(SESSION_KEY); return null; }
        return s;
      }catch(e){ return null; }
    }
    function clearSession(){ localStorage.removeItem(SESSION_KEY); }
    
    async function hashPassword(pw){
      if(window.crypto && crypto.subtle && crypto.subtle.digest){
        const enc = new TextEncoder();
        const data = enc.encode(pw);
        const hash = await crypto.subtle.digest('SHA-256', data);
        return Array.from(new Uint8Array(hash)).map(b=>b.toString(16).padStart(2,'0')).join('');
      } else {
        return 'plain:'+pw;
      }
    }
    
    function escapeHtml(s){ return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }
    
    function togglePasswordVisibility(inputId, btn) {
      const input = document.getElementById(inputId);
      if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
      } else {
        input.type = 'password';
        btn.innerHTML = '<i class="fas fa-eye"></i>';
      }
    }

    function showFieldError(fieldId, message) {
      const field = document.getElementById(fieldId);
      const errorEl = document.getElementById(fieldId + 'Error');
      if(field) {
        field.classList.add('error');
        field.classList.remove('success');
      }
      if(errorEl) {
        errorEl.textContent = message;
        errorEl.classList.add('show');
      }
    }

    function showFieldSuccess(fieldId) {
      const field = document.getElementById(fieldId);
      const errorEl = document.getElementById(fieldId + 'Error');
      if(field) {
        field.classList.add('success');
        field.classList.remove('error');
      }
      if(errorEl) errorEl.classList.remove('show');
    }

    function validateEmailOrUsername(emailOrUsername) {
      emailOrUsername = emailOrUsername.trim();
      if(!emailOrUsername) return { valid: false, message: 'Email or username is required' };
      return { valid: true };
    }

    function validatePassword(password) {
      if(!password) return { valid: false, message: 'Password is required' };
      return { valid: true };
    }

    // Real-time validation on blur
    document.getElementById('loginUsername').addEventListener('blur', function() {
      const result = validateEmailOrUsername(this.value);
      if(!result.valid) {
        showFieldError('loginUsername', result.message);
      } else {
        showFieldSuccess('loginUsername');
      }
    });

    document.getElementById('loginPassword').addEventListener('blur', function() {
      const result = validatePassword(this.value);
      if(!result.valid) {
        showFieldError('loginPassword', result.message);
      } else {
        showFieldSuccess('loginPassword');
      }
    });

    async function login(){
      const idOrEmail = document.getElementById('loginUsername').value.trim().toLowerCase();
      const pw = document.getElementById('loginPassword').value;
      const remember = document.getElementById('rememberMe').checked;
      const msg = document.getElementById('loginMessage');
      
      // Clear previous messages
      msg.innerHTML = '';
      msg.className = '';

      // Validate fields
      const emailResult = validateEmailOrUsername(idOrEmail);
      const passwordResult = validatePassword(pw);

      let hasErrors = false;

      if(!emailResult.valid) {
        showFieldError('loginUsername', emailResult.message);
        hasErrors = true;
      } else {
        showFieldSuccess('loginUsername');
      }

      if(!passwordResult.valid) {
        showFieldError('loginPassword', passwordResult.message);
        hasErrors = true;
      } else {
        showFieldSuccess('loginPassword');
      }

      if(hasErrors) return;

      const users = readUsers();
      const user = users.find(u => u.username.toLowerCase() === idOrEmail || u.email === idOrEmail);
      
      if(!user) {
        msg.innerHTML = '<span style="color:#ff6b6b">Invalid email/username or password</span>';
        showFieldError('loginUsername', 'User not found');
        return;
      }

      const hashed = await hashPassword(pw);
      if(hashed === user.password) {
        showFieldSuccess('loginUsername');
        showFieldSuccess('loginPassword');
        msg.innerHTML = '<span style="color:#2ee07a">Login successful! Redirecting...</span>';
        saveSession({ userId: user.id, username: user.username });
        setTimeout(() => { location.href = 'home.php'; }, 700);
      } else {
        msg.innerHTML = '<span style="color:#ff6b6b">Invalid email/username or password</span>';
        showFieldError('loginPassword', 'Incorrect password');
      }
    }

    async function signup(){
      const u = document.getElementById('signupUsername').value.trim();
      const name = document.getElementById('signupName').value.trim();
      const email = document.getElementById('signupEmail').value.trim().toLowerCase();
      const pw = document.getElementById('signupPassword').value;
      const msg = document.getElementById('signupMessage');
      if(u.length < 3){ msg.innerText='Username too short'; msg.style.color='#ff6b6b'; return; }
      if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){ msg.innerText='Invalid email'; msg.style.color='#ff6b6b'; return; }
      if(pw.length < 6){ msg.innerText='Password must be 6+ chars'; msg.style.color='#ff6b6b'; return; }
      const users = readUsers();
      if(users.some(x=> x.username.toLowerCase()===u.toLowerCase())){ msg.innerText='Username taken'; msg.style.color='#ff6b6b'; return; }
      if(users.some(x=> x.email === email)){ msg.innerText='Email already used'; msg.style.color='#ff6b6b'; return; }
      const hashed = await hashPassword(pw);
      const newUser = { id: Date.now(), username: u, fullname: name, email, password: hashed, created_at: new Date().toISOString() };
      users.push(newUser);
      saveUsers(users);
      msg.innerText='Account created — redirecting to login...';
      msg.style.color='#2ee07a';
      try{ localStorage.setItem('cs_prefill', newUser.username); }catch(e){}
      setTimeout(()=> { location.href = 'login.php'; }, 800);
    }

    function generateCode(){ return String(Math.floor(100000 + Math.random()*900000)); }
    
    function simulateSendCode(email, code){ 
      localStorage.setItem('reset_'+email, JSON.stringify({ code, expires: Date.now() + 15*60*1000 })); 
      return code; 
    }
    
    function requestReset(){
      const email = document.getElementById('forgotEmail').value.trim().toLowerCase();
      const msg = document.getElementById('forgotMessage');
      msg.innerHTML = '';
      msg.className = '';
      
      if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){ 
        showFieldError('forgotEmail', 'Invalid email');
        msg.innerHTML = '<span style="color:#ff6b6b">Invalid email address</span>';
        return; 
      }
      
      const users = readUsers();
      const user = users.find(u => u.email === email);
      
      if(!user){ 
        showFieldError('forgotEmail', 'Email not found');
        msg.innerHTML = '<span style="color:#ff6b6b">No account with that email</span>';
        return; 
      }
      
      const code = generateCode();
      simulateSendCode(email, code);
      
      // Store email for OTP verification
      localStorage.setItem('reset_email', email);
      
      // Display code for testing (works offline)
      console.log('%c🔐 PASSWORD RESET CODE: ' + code, 'color: #d4af37; font-size: 16px; font-weight: bold; background: #1a1a1a; padding: 10px;');
      
      msg.innerHTML = '<span style="color:#2ee07a">✓ Code sent to ' + escapeHtml(email) + '</span><br><br>' +
        '<span style="color:#d4af37; font-size: 14px; font-weight: bold; background: rgba(212,175,55,0.2); padding: 12px; border-radius: 8px; display: inline-block; margin: 10px 0;">📧 YOUR CODE: <strong>' + code + '</strong></span><br><br>' +
        '<span style="color: rgba(212,175,55,0.8); font-size: 12px;">Copy this code and enter it below</span>';
      msg.style.color='#2ee07a';
      
      // Move to OTP verification form
      setTimeout(() => {
        showForm('otpForm');
        document.getElementById('otpEmailText').innerText = 'Code: ' + code + ' (Code expires in 15 minutes)';
        document.getElementById('otpCode').focus();
      }, 800);
    }
    
    function verifyOTP(){
      const email = localStorage.getItem('reset_email');
      const code = document.getElementById('otpCode').value.trim();
      const msg = document.getElementById('otpMessage');
      msg.innerHTML = '';
      msg.className = '';
      
      if(!email){ 
        msg.innerHTML = '<span style="color:#ff6b6b">Session expired. Start again.</span>';
        showForm('forgotForm');
        return; 
      }
      
      if(!code || code.length !== 6){ 
        showFieldError('otpCode', 'Please enter 6-digit code');
        msg.innerHTML = '<span style="color:#ff6b6b">Code must be 6 digits</span>';
        return; 
      }
      
      const raw = localStorage.getItem('reset_'+email);
      
      if(!raw){ 
        showFieldError('otpCode', 'No reset request found');
        msg.innerHTML = '<span style="color:#ff6b6b">No reset request found. Start again.</span>';
        return; 
      }
      
      const obj = JSON.parse(raw);
      
      if(Date.now() > obj.expires){ 
        showFieldError('otpCode', 'Code expired');
        msg.innerHTML = '<span style="color:#ff6b6b">Reset code expired. Request a new one.</span>';
        return; 
      }
      
      if(obj.code !== code){ 
        showFieldError('otpCode', 'Code does not match');
        msg.innerHTML = '<span style="color:#ff6b6b">✗ Code does not match. Please try again.</span>';
        return; 
      }
      
      // Code is correct
      showFieldSuccess('otpCode');
      msg.innerHTML = '<span style="color:#2ee07a">✓ Code verified! Enter your new password.</span>';
      
      // Move to reset password form
      setTimeout(() => {
        showForm('resetForm');
        document.getElementById('newPassword').focus();
      }, 800);
    }
    
    async function resetPassword(){
      const newPass = document.getElementById('newPassword').value;
      const confirmPass = document.getElementById('confirmPassword').value;
      const email = localStorage.getItem('reset_email');
      const msg = document.getElementById('resetMessage');
      msg.innerHTML = '';
      msg.className = '';
      
      // Validation
      if(!newPass || newPass.length < 6){ 
        showFieldError('newPassword', 'Password must be at least 6 characters');
        msg.innerHTML = '<span style="color:#ff6b6b">Password must be at least 6 characters</span>';
        return; 
      }
      
      if(newPass !== confirmPass){ 
        showFieldError('confirmPassword', 'Passwords do not match');
        msg.innerHTML = '<span style="color:#ff6b6b">Passwords do not match</span>';
        return; 
      }
      
      if(!email){ 
        msg.innerHTML = '<span style="color:#ff6b6b">Session expired. Start again.</span>';
        return; 
      }
      
      const users = readUsers();
      const userIdx = users.findIndex(u => u.email === email);
      
      if(userIdx === -1){ 
        msg.innerHTML = '<span style="color:#ff6b6b">User not found</span>';
        return; 
      }
      
      // Update password
      const hashedPassword = await hashPassword(newPass);
      users[userIdx].password = hashedPassword;
      saveUsers(users);
      
      // Cleanup
      localStorage.removeItem('reset_'+email);
      localStorage.removeItem('reset_email');
      
      msg.innerHTML = '<span style="color:#2ee07a">✓ Password reset successfully! Redirecting to login...</span>';
      
      setTimeout(() => { 
        showForm('loginForm');
        document.getElementById('loginUsername').value = users[userIdx].username;
        document.getElementById('loginPassword').value = '';
        const lm = document.getElementById('loginMessage');
        lm.innerHTML = '<span style="color:#2ee07a">Password updated successfully. Please login with your new password.</span>';
      }, 1000);
    }

    (function init(){
      const session = readSession();
      if(session){
        location.href = 'home.php';
        return;
      }
      showForm('loginForm');
    })();
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

