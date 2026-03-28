# Migration Guide: localStorage → PHP Session + MySQL Backend

## Overview
This migration completely removes all localStorage and IndexedDB usage, replacing it with PHP session-based state management and MySQL backend persistence.

## What Changed

### **Before: localStorage-based**
```javascript
// Old way - insecure, browser-dependent
localStorage.setItem('cs_auth_token', token);
localStorage.setItem('seenIntro', true);
localStorage.setItem('historyHintDismissed', true);
```

### **After: PHP Session + Database**
```javascript
// New way - secure, backend-managed
StateManager.markIntroSeen();
StateManager.setPreference('key', value);
```

## Database Setup

### 1. Run Schema Migration
Execute the SQL file to add new tables:

```bash
mysql -u kvevn_user -p kevin_website < /path/to/api/schema_migration.sql
```

Or paste the contents of `schema_migration.sql` into your MySQL client directly.

### 2. Tables Created
- **user_state**: Stores intro_seen, preferences, and feature flags per user
- **admin_sessions**: Tracks admin login sessions with timeout
- **notification_log**: Central notification feed
- **notification_seen**: Tracks which notifications admin has seen

## API Endpoints

### User State Management
**GET/POST** `/api/state.php`
- Returns: `{ state: { intro_seen, history_hint_dismissed, preferences } }`
- Requires: Active user session

### Intro Management
**GET/POST** `/api/intro.php`
- GET: Check if user has seen intro
- POST: Mark intro as seen
- Works for authenticated and unauthenticated users

### Admin Authentication
- **POST** `/api/admin_login.php` - Authenticate admin with password
- **GET** `/api/admin_check.php` - Verify admin session
- **POST** `/api/admin_logout.php` - Logout admin

### Notifications
- **GET/POST** `/api/notifications.php` - Get/create notifications
- **POST** `/api/mark_notifications_seen.php` - Mark as seen

## Frontend Changes

### StateManager API
Use the global `StateManager` object for all state operations:

```javascript
// Check if intro has been seen
const seen = await StateManager.checkIntroSeen();

// Mark intro as seen
await StateManager.markIntroSeen();

// Get all user state
const state = await StateManager.getState();

// Set preferences
await StateManager.setPreference('theme', 'dark');

// Get preference
const theme = await StateManager.getPreference('theme', 'dark');

// Get notifications
const notifications = await StateManager.getNotifications(40);

// Mark notifications seen
await StateManager.markNotificationsSeen([1, 2, 3]);
```

## File Changes

### JavaScript Files Updated
- **auth.js**: Removed localStorage keys, uses PHP sessions
- **state-manager.js**: NEW - Session-based state management
- **admin.php**: Replaced localStorage auth with PHP session API calls
- **home.php**: Intro logic now uses StateManager
- **about.php**: History hint uses StateManager
- **content-data.js**: Removed localStorage comment

### CSS & HTML
- All animations remain unchanged
- All HTML structure remains unchanged
- Only JS layer modified

## Key Features Preserved

✅ Intro animations on page load
✅ Skip intro button
✅ Signup/login flows
✅ Conditional UI rendering
✅ User preference storage
✅ Admin notifications
✅ Feature flag management
✅ Session timeouts

## Implementation Checklist

- [ ] Database tables created (run schema_migration.sql)
- [ ] All .php API files in place
- [ ] auth.js updated
- [ ] state-manager.js added to project
- [ ] admin.php updated
- [ ] home.php updated
- [ ] about.php updated  
- [ ] PHP sessions enabled in php.ini
- [ ] MySQL credentials configured in api/config.php
- [ ] Test intro flow: unloggedIn user sees intro, then marked as seen in DB
- [ ] Test admin login: uses PHP session, can logout
- [ ] Test preferences: can save and retrieve from DB

## Testing Checklist

```javascript
// Test 1: Check intro status
const introSeen = await StateManager.checkIntroSeen();
console.log('Intro seen:', introSeen);

// Test 2: Mark intro seen
await StateManager.markIntroSeen();
const newStatus = await StateManager.checkIntroSeen();
console.log('After marking:', newStatus); // Should be true

// Test 3: Set preference
await StateManager.setPreference('lastVisit', new Date().toISOString());
const lastVisit = await StateManager.getPreference('lastVisit');
console.log('Last visit:', lastVisit);

// Test 4: Admin login
// Navigate to admin.php and test password input

// Test 5: Check DB
mysql> SELECT * FROM user_state WHERE user_id = 1;
mysql> SELECT * FROM admin_sessions;
```

## Troubleshooting

**Problem**: StateManager not found
**Solution**: Add `<script src="state-manager.js"></script>` to page before using

**Problem**: `intro_seen` not persisting
**Solution**: Verify user is logged in (session exists) and MySQL tables are created

**Problem**: Admin login fails
**Solution**: Check that api/admin_login.php session_token is being set correctly

**Problem**: CORS errors
**Solution**: Credentials are set to 'include' in fetch calls - ensure same-origin

## Security Notes

✅ Passwords hashed with bcrypt (password_verify)
✅ Admin sessions use random tokens
✅ Session timeout after 30 minutes inactivity
✅ All state persisted server-side (no client exposure)
✅ No sensitive data in cookies

## Migration from Legacy System

If migrating from old project:

1. Backup existing MySQL database
2. Create new tables: `mysql ... < schema_migration.sql`
3. Replace JS files with new versions
4. Clear browser localStorage (it will no longer be used)
5. Test all flows: signup, login, intro, preferences
6. Verify admin dashboard works with new auth

## Support

For issues:
- Check browser console for StateManager errors
- Check MySQL error logs
- Verify PHP session.save_path is writable
- Confirm MySQL user has proper permissions

