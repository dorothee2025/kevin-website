// state-manager.js - Session & Database backed state management
// Replaces localStorage with backend persistence

const StateManager = (() => {
    const API_BASE = '/api';
    
    // Cache for session to minimize API calls
    const cache = {
        state: null,
        notifications: null,
        lastUpdate: 0,
        CACHE_TTL: 60000 // 1 minute
    };

    // Get user state from backend
    async function getState() {
        // Use cache if fresh
        if (cache.state && Date.now() - cache.lastUpdate < cache.CACHE_TTL) {
            return cache.state;
        }

        try {
            const res = await fetch(API_BASE + '/state.php', {
                method: 'GET',
                credentials: 'include'
            });

            if (!res.ok) {
                // Not authenticated or error
                return null;
            }

            const data = await res.json();
            cache.state = data.state;
            cache.lastUpdate = Date.now();
            return data.state;

        } catch (e) {
            console.error('Failed to get state:', e);
            return null;
        }
    }

    // Update user state on backend
    async function setState(updates) {
        try {
            const res = await fetch(API_BASE + '/state.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'include',
                body: JSON.stringify(updates)
            });

            if (!res.ok) {
                console.error('Failed to set state');
                return false;
            }

            // Invalidate cache
            cache.state = null;
            cache.lastUpdate = 0;
            return true;

        } catch (e) {
            console.error('Failed to set state:', e);
            return false;
        }
    }

    // Get intro seen status
    async function checkIntroSeen() {
        try {
            const res = await fetch(API_BASE + '/intro.php', {
                method: 'GET',
                credentials: 'include'
            });

            if (!res.ok) {
                return false;
            }

            const data = await res.json();
            return data.intro_seen || false;

        } catch (e) {
            console.error('Failed to check intro status:', e);
            return false;
        }
    }

    // Mark intro as seen
    async function markIntroSeen() {
        try {
            const res = await fetch(API_BASE + '/intro.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'include',
                body: JSON.stringify({ seen: true })
            });

            return res.ok;

        } catch (e) {
            console.error('Failed to mark intro seen:', e);
            return false;
        }
    }

    // Get notifications
    async function getNotifications(limit = 40) {
        try {
            const res = await fetch(API_BASE + '/notifications.php?limit=' + limit, {
                method: 'GET',
                credentials: 'include'
            });

            if (!res.ok) {
                return [];
            }

            const data = await res.json();
            return data.notifications || [];

        } catch (e) {
            console.error('Failed to get notifications:', e);
            return [];
        }
    }

    // Mark notifications as seen
    async function markNotificationsSeen(notificationIds) {
        try {
            const res = await fetch(API_BASE + '/mark_notifications_seen.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'include',
                body: JSON.stringify({ notification_ids: notificationIds })
            });

            return res.ok;

        } catch (e) {
            console.error('Failed to mark notifications seen:', e);
            return false;
        }
    }

    // Update preferences
    async function setPreference(key, value) {
        const state = await getState();
        if (!state) {
            return false;
        }

        const prefs = state.preferences || {};
        prefs[key] = value;

        return setState({ preferences: prefs });
    }

    // Get preference
    async function getPreference(key, defaultValue = null) {
        const state = await getState();
        if (!state || !state.preferences) {
            return defaultValue;
        }

        return state.preferences[key] !== undefined ? state.preferences[key] : defaultValue;
    }

    // Public API
    return {
        getState,
        setState,
        checkIntroSeen,
        markIntroSeen,
        getNotifications,
        markNotificationsSeen,
        setPreference,
        getPreference,
        // Legacy support
        setItem: setPreference,
        getItem: getPreference,
        removeItem: (key) => setPreference(key, null)
    };
})();

// For global access
if (typeof window !== 'undefined') {
    window.StateManager = StateManager;
}
