# User Profile Display System - Complete Implementation Guide

## Overview
User profile information (username and profile picture) now appears in the navbar after login. This appears on the home page and can be extended to all other pages.

## Files Created/Modified

### Created Files
1. **`profile.js`** - Frontend JavaScript module that handles user profile display
   - Auto-initializes on page load
   - Fetches current user from `/api/user.php`
   - Toggles between login/signup buttons and profile widget
   - Handles logout functionality

### Modified Backend Files
1. **`/api/auth_login.php`** - Now sets PHP session and returns profile_image
2. **`/api/auth_register.php`** - Sets session on new user creation
3. **`/api/auth_logout.php`** - Properly destroys session and returns authenticated: false
4. **`/api/user.php`** - Already created, serves as auth verification endpoint

### Modified HTML Files
1. **`home.php`** - Added:
   - Script tag: `<script src="profile.js"></script>`
   - CSS class: `.hidden { display: none !important; }`

## System Architecture

### Frontend Flow

```
Page Load
    ↓
profile.js initializes (DOMContentLoaded)
    ↓
ProfileManager.init() runs
    ↓
ProfileManager.getCurrentUser()
    ├─→ fetch('/api/user.php')
    └─→ Returns current user or null
        ↓
    ├─→ If user exists → displayUserProfile()
    │   ├─→ Hide .nav-buttons (Login/Signup)
    │   ├─→ Show #userWidget (Profile)
    │   ├─→ Populate #navUsername
    │   ├─→ Populate #navProfilePic
    │   ├─→ Attach logout listener
    │   └─→ Attach dropdown menu handler
    │
    └─→ If no user → displayLoginButtons()
        ├─→ Show .nav-buttons
        └─→ Hide #userWidget
```

### Backend Flow (Login)

```
POST /api/auth_login.php
    ↓
Verify credentials with bcrypt
    ↓
If valid:
    ├─→ Set 4 session variables:
    │   ├─→ $_SESSION['user_id']
    │   ├─→ $_SESSION['username']
    │   ├─→ $_SESSION['email']
    │   ├─→ $_SESSION['role']
    │
    └─→ Return JSON:
        ├─→ authenticated: true
        └─→ user object (including profile_image)
    ↓
Browser stores PHPSESSID cookie
    ↓
Frontend receives user data, displays profile
```

## HTML Structure

```html
<!-- Login/Signup Buttons (shown when not logged in) -->
<div class="nav-buttons">
    <a href="login.php" class="btn-login">Login</a>
    <a href="register.php" class="btn-signup">Sign Up</a>
</div>

<!-- User Profile Widget (shown when logged in, hidden by default) -->
<div class="user-profile-widget hidden" id="userWidget">
    <div class="profile-pic">
        <img id="navProfilePic" src="..." alt="Profile">
    </div>
    <span id="navUsername"></span>
    <span id="userPoints" class="user-points">Pts: 0 (Lv 1)</span>
    <div class="user-menu" id="userMenu">
        <a href="setting.php" id="navProfileSettings">Settings</a>
        <a href="#" id="navLogout">Logout</a>
    </div>
</div>
```

## JavaScript API - ProfileManager

### Public Methods

#### `ProfileManager.init()`
- **Purpose**: Initialize profile display system
- **When**: Automatically called on DOMContentLoaded
- **Returns**: Promise (async)
- **Example**: `await ProfileManager.init();`

#### `ProfileManager.getCurrentUser()`
- **Purpose**: Fetch current logged-in user from backend
- **Endpoint**: GET `/api/user.php`
- **Returns**: User object or null
- **Example**: `const user = await ProfileManager.getCurrentUser();`

#### `ProfileManager.displayUserProfile()`
- **Purpose**: Show profile widget and populate with user data
- **Precondition**: `this.currentUser` must be set
- **Updates**: DOM elements with user data

#### `ProfileManager.displayLoginButtons()`
- **Purpose**: Show login/signup buttons and hide profile widget
- **Precondition**: User is not authenticated

#### `ProfileManager.handleLogout()`
- **Purpose**: Post to logout endpoint and redirect
- **Endpoint**: POST `/api/auth_logout.php`
- **Redirects**: `/login.php` on success

#### `ProfileManager.updateProfilePicture(imageUrl)`
- **Purpose**: Update profile picture (for future profile upload)
- **Parameter**: URL string

#### `ProfileManager.updateUsername(newUsername)`
- **Purpose**: Update displayed username (for future profile edit)
- **Parameter**: Username string

## API Endpoints

### GET `/api/user.php`
Retrieve current logged-in user's profile

**Authentication**: PHP Session (via `$_SESSION['user_id']`)

**Response on Success (200)**:
```json
{
    "authenticated": true,
    "user": {
        "user_id": 1,
        "username": "john_doe",
        "email": "john@example.com",
        "profile_image": "path/to/image.jpg",
        "role": "user"
    }
}
```

**Response on Failure (401)**:
```json
{
    "error": "Not authenticated"
}
```

### POST `/api/auth_login.php`
Authenticate user and create session

**Request**:
```json
{
    "username": "john_doe",
    "password": "password123"
}
```

**Response on Success (200)**:
```json
{
    "success": true,
    "authenticated": true,
    "user": {
        "user_id": 1,
        "username": "john_doe",
        "email": "john@example.com",
        "profile_image": "path/to/image.jpg",
        "role": "user"
    }
}
```

### POST `/api/auth_logout.php`
Destroy user session

**Authentication**: PHP Session

**Response on Success (200)**:
```json
{
    "success": true,
    "authenticated": false,
    "message": "Logged out successfully"
}
```

## Testing Checklist

### Step 1: Clear Browser Data
- [ ] Open DevTools
- [ ] Go to Application → Cookies → Delete PHPSESSID
- [ ] Refresh page

### Step 2: Verify Login/Register States
- [ ] Home page loads with Login/Signup buttons visible
- [ ] No profile widget visible

### Step 3: Test Login
- [ ] Click "Login"
- [ ] Enter valid credentials
- [ ] After login:
  - [ ] Redirected to home page
  - [ ] Login/Signup buttons disappear
  - [ ] Profile widget appears with username
  - [ ] Profile picture displays
  - [ ] Points display (if available)

### Step 4: Test Profile Interactions
- [ ] Click on profile picture
- [ ] Dropdown menu appears with Settings and Logout
- [ ] Click on "Settings" - should navigate to settings.php
- [ ] Click on "Logout" - should redirect to login.php

### Step 5: Test Session Persistence
- [ ] After login, refresh page (F5)
- [ ] Profile should still be displayed (session persists)
- [ ] Navigate to other pages (if profile.js added)
- [ ] Profile should persist

### Step 6: Test Logout
- [ ] Click Logout
- [ ] Should redirect to login.php
- [ ] Refresh target page
- [ ] Should show Login/Signup buttons (session cleared)

## Extending to Other Pages

To add user profile display to other pages:

1. **Add HTML elements** (if not present):
   ```html
   <div class="nav-buttons">
       <a href="login.php" class="btn-login">Login</a>
       <a href="register.php" class="btn-signup">Sign Up</a>
   </div>
   
   <div class="user-profile-widget hidden" id="userWidget">
       <!-- profile widget HTML -->
   </div>
   ```

2. **Add script tag** before closing `</body>`:
   ```html
   <script src="profile.js"></script>
   ```

3. **Add CSS** to page's style section:
   ```css
   .hidden { display: none !important; }
   .user-profile-widget { /* existing styles */ }
   .profile-pic { /* existing styles */ }
   .user-menu { /* existing styles */ }
   ```

**Affected Pages** (to be updated):
- admin.php
- about.php
- coding.php
- ICT Tutorials.php
- news-section.php
- video-player-2.php
- register.php
- login.php
- setting.php

## Troubleshooting

### Issue: Profile not showing after login
**Possible Cause**: Session not being created
**Solution**:
1. Run `/api/auth_login.php` manually with POST request
2. Check PHP logs for errors
3. Verify `session_start()` is called in auth_login.php

### Issue: Profile picture not loading
**Possible Cause**: profile_image is NULL in database
**Solution**:
1. Verify users table has profile_image column
2. Update user with valid image URL
3. Placeholder image will show as fallback

### Issue: Logout not working
**Possible Cause**: `/api/auth_logout.php` not accessible
**Solution**:
1. Check file exists at correct path
2. Verify POST method is allowed
3. Check browser console for fetch errors

### Issue: Profile not persisting on refresh
**Possible Cause**: PHPSESSID cookie not being sent
**Solution**:
1. Verify `credentials: 'include'` in all fetch calls
2. Check browser cookie storage settings
3. Verify Apache/PHP session configuration

## Database Requirements

Must have `profile_image` column in `users` table (nullable):

```sql
ALTER TABLE users ADD COLUMN profile_image VARCHAR(255) NULL;
```

## Security Considerations

✅ **Implemented**:
- Session-based authentication (no tokens in localStorage)
- HttpOnly session cookies (cannot be accessed by JavaScript)
- Password hashing with bcrypt
- Session validation on every request to `/api/user.php`
- Inactive user check on login

⚠️ **Recommended**:
- CSRF token for logout endpoint (optional for GET-only initial requests)
- Profile picture upload validation (file type, size)
- Rate limiting on auth endpoints
- HTTPS in production

## Performance Notes

- `/api/user.php` call is made once on page load
- ProfileManager caches current user in memory
- No repeated calls unless page is reloaded
- Profile picture lazy loading (browser handles)

## Future Enhancements

1. **Profile Picture Upload**
   - Add `/api/user-profile-picture-upload.php`
   - Handle file validation and storage
   - Update profile widget dynamically

2. **User Settings**
   - Create `/setting.php` with user profile edit form
   - Allow username/email changes
   - Allow profile picture changes

3. **Points/Achievements System**
   - Store user points in database
   - Display current points in profile widget
   - Show level/badges from points

4. **Extended Profile**
   - Show user profile page (bio, activity, etc.)
   - Add friends/follow system
   - Show recent activities

5. **Mobile Responsive**
   - Optimize profile widget for mobile
   - Adjust dropdown menu positioning
   - Touch-friendly profile picture click area
