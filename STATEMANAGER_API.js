// StateManager API Reference
// Use this global API for all state management operations
// No localStorage needed!

/**
 * CHECK IF INTRO HAS BEEN SEEN
 * @returns {Promise<boolean>}
 */
async function example1() {
    const introSeen = await StateManager.checkIntroSeen();
    console.log('User has seen intro:', introSeen);
    
    if (introSeen) {
        // Hide intro, show main content
        document.getElementById('intro').style.display = 'none';
    }
}

/**
 * MARK INTRO AS SEEN
 * Call this when user skips intro or completes signup
 * @returns {Promise<boolean>}
 */
async function example2() {
    const success = await StateManager.markIntroSeen();
    console.log('Marked intro as seen:', success);
}

/**
 * GET ALL USER STATE
 * Returns: { intro_seen, history_hint_dismissed, preferences }
 * @returns {Promise<Object>}
 */
async function example3() {
    const state = await StateManager.getState();
    console.log('User state:', state);
    // {
    //   intro_seen: true,
    //   history_hint_dismissed: false,
    //   preferences: { theme: 'dark', language: 'en' }
    // }
}

/**
 * UPDATE MULTIPLE STATE FIELDS
 * @param {Object} updates - { intro_seen, history_hint_dismissed, preferences }
 * @returns {Promise<boolean>}
 */
async function example4() {
    const success = await StateManager.setState({
        intro_seen: true,
        history_hint_dismissed: true,
        preferences: { theme: 'light', language: 'fr' }
    });
    console.log('State updated:', success);
}

/**
 * SET A PREFERENCE
 * Store any key-value preference in user's preferences JSON
 * @param {string} key
 * @param {*} value
 * @returns {Promise<boolean>}
 */
async function example5() {
    // Set single preference
    await StateManager.setPreference('lastVisitedPage', 'coding');
    await StateManager.setPreference('theme', 'dark');
    await StateManager.setPreference('sidebarCollapsed', true);
    await StateManager.setPreference('notificationVolume', 0.8);
}

/**
 * GET A PREFERENCE
 * Retrieve a preference with optional default value
 * @param {string} key
 * @param {*} defaultValue - returned if preference not found
 * @returns {Promise<*>}
 */
async function example6() {
    const theme = await StateManager.getPreference('theme', 'dark');
    console.log('Current theme:', theme);
    
    const lastPage = await StateManager.getPreference('lastVisitedPage', 'home');
    console.log('Last visited:', lastPage);
}

/**
 * GET NOTIFICATIONS
 * Fetch recent notifications for admin dashboard
 * @param {number} limit - max 100, default 40
 * @returns {Promise<Array>}
 */
async function example7() {
    const notifications = await StateManager.getNotifications(40);
    console.log('Recent notifications:', notifications);
    // Returns array of:
    // {
    //   id: 123,
    //   contentType: 'video' | 'news',
    //   content_id: 456,
    //   title: 'New Video: JavaScript Basics',
    //   uploadTimestamp: 1698765432000
    // }
}

/**
 * MARK NOTIFICATIONS AS SEEN
 * Tell backend which notifications admin has viewed
 * @param {Array<number>} notificationIds
 * @returns {Promise<boolean>}
 */
async function example8() {
    const notificationIds = [1, 2, 3, 4, 5];
    const success = await StateManager.markNotificationsSeen(notificationIds);
    console.log('Marked as seen:', success);
}

// ============================================================
// PRACTICAL EXAMPLES
// ============================================================

/**
 * Example: Auto-hide intro for returning users
 */
async function autoHideIntro() {
    const introSeen = await StateManager.checkIntroSeen();
    
    if (introSeen) {
        document.getElementById('introOverlay').style.display = 'none';
        // Show main page content
        document.getElementById('mainContent').style.display = 'block';
    }
}

/**
 * Example: Save sidebar collapsed state
 */
function setupSidebarToggle() {
    const toggleButton = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    // Load saved state on page load
    (async () => {
        const collapsed = await StateManager.getPreference('sidebarCollapsed', false);
        if (collapsed) {
            sidebar.classList.add('collapsed');
        }
    })();
    
    // Save state when user clicks toggle
    toggleButton.addEventListener('click', async () => {
        const isCollapsed = sidebar.classList.toggle('collapsed');
        await StateManager.setPreference('sidebarCollapsed', isCollapsed);
    });
}

/**
 * Example: Theme switcher
 */
function setupThemeSwitcher() {
    const themeButtons = document.querySelectorAll('[data-theme]');
    
    // Load saved theme on startup
    (async () => {
        const savedTheme = await StateManager.getPreference('theme', 'dark');
        document.body.dataset.theme = savedTheme;
        document.querySelector(`[data-theme="${savedTheme}"]`)?.classList.add('active');
    })();
    
    // Save theme when user clicks button
    themeButtons.forEach(btn => {
        btn.addEventListener('click', async () => {
            const theme = btn.dataset.theme;
            document.body.dataset.theme = theme;
            await StateManager.setPreference('theme', theme);
            themeButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
}

/**
 * Example: Track last visited page
 */
function trackPageVisit() {
    const pageName = document.body.dataset.page || 'unknown';
    StateManager.setPreference('lastVisitedPage', pageName);
}

/**
 * Example: Admin notification dashboard
 */
async function renderNotificationDashboard() {
    const notifications = await StateManager.getNotifications(20);
    const container = document.getElementById('notificationsList');
    
    notifications.forEach(notif => {
        const item = document.createElement('div');
        item.className = 'notification-item';
        item.innerHTML = `
            <h4>${notif.title}</h4>
            <p>${notif.contentType} - ${new Date(notif.uploadTimestamp).toLocaleString()}</p>
        `;
        container.appendChild(item);
    });
    
    // Mark all as seen
    const allIds = notifications.map(n => n.id);
    if (allIds.length > 0) {
        await StateManager.markNotificationsSeen(allIds);
    }
}

/**
 * Example: Dismiss hint with persistence
 */
function dismissHint() {
    const hintElement = document.querySelector('.dismissible-hint');
    const hintId = hintElement.dataset.hintId; // e.g., 'historyHintDismissed'
    
    hintElement.querySelector('.dismiss-btn').addEventListener('click', async () => {
        // Save that this hint was dismissed
        await StateManager.setPreference(hintId, true);
        // Animate out and remove
        hintElement.classList.add('fade-out');
        setTimeout(() => hintElement.remove(), 300);
    });
    
    // On page load, hide hint if already dismissed
    (async () => {
        const dismissed = await StateManager.getPreference(hintId, false);
        if (dismissed) {
            hintElement.style.display = 'none';
        }
    })();
}

// ============================================================
// ERROR HANDLING
// ============================================================

/**
 * Example: Proper error handling
 */
async function safeStateUpdate() {
    try {
        const success = await StateManager.setPreference('someKey', 'someValue');
        
        if (!success) {
            console.error('Failed to update preference');
            // Could be network error or user not authenticated
            // Show user-friendly message
            alert('Could not save preference. Please try again.');
            return;
        }
        
        console.log('Preference saved successfully');
    } catch (error) {
        console.error('Error updating state:', error);
        // Network error or other exception
        alert('Network error. Please check your connection.');
    }
}

/**
 * Example: Fallback for unauthenticated users
 */
async function checkAuthStatus() {
    try {
        const state = await StateManager.getState();
        
        if (!state) {
            // User is not authenticated
            console.log('User not logged in');
            window.location.href = '/login.php';
            return;
        }
        
        console.log('User authenticated');
    } catch (error) {
        console.error('Auth check failed:', error);
    }
}

// ============================================================
// USAGE IN HTML
// ============================================================

/**
 * Make sure to include these scripts in order:
 * 
 * <script src="auth.js"></script>
 * <script src="state-manager.js"></script>
 * 
 * Then you can use StateManager globally:
 * 
 * <script>
 *   // Call StateManager functions anywhere
 *   StateManager.checkIntroSeen().then(seen => {
 *     console.log('Intro seen:', seen);
 *   });
 * </script>
 */

// ============================================================
// LEGACY SUPPORT (for compatibility)
// ============================================================

/**
 * StateManager also supports legacy localStorage-like interface:
 * This is primarily for migration compatibility
 */
async function legacyExample() {
    // These work like old localStorage methods:
    
    // Set item (actually sets a preference)
    await StateManager.setItem('myKey', 'myValue');
    
    // Get item (returns preference value)
    const value = await StateManager.getItem('myKey');
    
    // Remove item (sets to null)
    await StateManager.removeItem('myKey');
}
