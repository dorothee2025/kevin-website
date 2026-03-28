// profile.js - User Profile Display Management
// Handles loading and displaying logged-in user information on navbar

const ProfileManager = {
    currentUser: null,
    isInitialized: false,

    /**
     * Initialize profile display on page load
     * Call this function once on each page that has a navbar
     */
    async init() {
        if (this.isInitialized) return;
        this.isInitialized = true;

        try {
            // Try to fetch current user
            const user = await this.getCurrentUser();
            
            if (user) {
                this.currentUser = user;
                this.displayUserProfile();
                this.attachEventListeners();
            } else {
                this.displayLoginButtons();
            }
        } catch (error) {
            console.error('Error initializing profile:', error);
            this.displayLoginButtons();
        }
    },

    /**
     * Fetch current logged-in user from backend
     */
    async getCurrentUser() {
        try {
            const res = await fetch('/api/user.php', {
                method: 'GET',
                credentials: 'include'
            });

            if (!res.ok) {
                if (res.status === 401) {
                    return null; // Not authenticated
                }
                throw new Error('Failed to fetch user');
            }

            const data = await res.json();
            return data.user || null;
        } catch (error) {
            console.error('Error fetching current user:', error);
            return null;
        }
    },

    /**
     * Display logged-in user profile in navbar
     */
    displayUserProfile() {
        const navButtons = document.querySelector('.nav-buttons');
        const userWidget = document.getElementById('userWidget');

        if (!userWidget) {
            console.warn('User profile widget (#userWidget) not found in DOM');
            return;
        }

        // Hide login/signup buttons
        if (navButtons) {
            navButtons.style.display = 'none';
        }

        // Show user profile widget
        userWidget.style.display = 'flex';

        // Populate user data
        const usernameEl = document.getElementById('navUsername');
        const profilePicEl = document.getElementById('navProfilePic');
        const pointsEl = document.getElementById('userPoints');

        if (usernameEl) {
            usernameEl.textContent = this.currentUser.username || 'User';
        }

        if (profilePicEl) {
            // Set profile picture with fallback to default avatar
            const imageUrl = this.currentUser.profile_image || 'https://via.placeholder.com/40?text=USER';
            profilePicEl.src = imageUrl;
            profilePicEl.alt = this.currentUser.username || 'User Avatar';
            
            // Handle image load errors
            profilePicEl.onerror = function() {
                this.src = 'https://via.placeholder.com/40?text=' + (ProfileManager.currentUser.username ? ProfileManager.currentUser.username.charAt(0).toUpperCase() : 'U');
            };
        }

        if (pointsEl) {
            // Try to get points from various sources (localStorage fallback for now)
            let points = this.currentUser.points || 0;
            if (!points && localStorage.getItem('userPoints')) {
                points = localStorage.getItem('userPoints');
            }
            pointsEl.textContent = points;
        }
    },

    /**
     * Display login/signup buttons when not authenticated
     */
    displayLoginButtons() {
        const navButtons = document.querySelector('.nav-buttons');
        const userWidget = document.getElementById('userWidget');

        if (navButtons) {
            navButtons.style.display = 'flex';
        }

        if (userWidget) {
            userWidget.style.display = 'none';
        }
    },

    /**
     * Attach event listeners to profile widget buttons
     */
    attachEventListeners() {
        const logoutBtn = document.getElementById('navLogout');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleLogout();
            });
        }

        // Handle user menu dropdown toggle
        const profilePic = document.getElementById('navProfilePic');
        if (profilePic) {
            profilePic.addEventListener('click', (e) => {
                e.stopPropagation();
                const userMenu = document.getElementById('userMenu');
                if (userMenu) {
                    userMenu.style.display = 
                        userMenu.style.display === 'none' ? 'block' : 'none';
                }
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', () => {
            const userMenu = document.getElementById('userMenu');
            if (userMenu) {
                userMenu.style.display = 'none';
            }
        });
    },

    /**
     * Handle user logout
     */
    async handleLogout() {
        try {
            const res = await fetch('/api/auth_logout.php', {
                method: 'POST',
                credentials: 'include'
            });

            if (res.ok) {
                // Logout successful - redirect to login or home
                window.location.href = '/login.php';
            } else {
                throw new Error('Logout failed');
            }
        } catch (error) {
            console.error('Logout error:', error);
            alert('Error logging out. Please try again.');
        }
    },

    /**
     * Update profile picture (optional - for future profile picture upload)
     */
    updateProfilePicture(imageUrl) {
        const profilePicEl = document.getElementById('navProfilePic');
        if (profilePicEl) {
            profilePicEl.src = imageUrl;
            if (this.currentUser) {
                this.currentUser.profile_image = imageUrl;
            }
        }
    },

    /**
     * Update username (optional - for future profile edit)
     */
    updateUsername(newUsername) {
        const usernameEl = document.getElementById('navUsername');
        if (usernameEl) {
            usernameEl.textContent = newUsername;
            if (this.currentUser) {
                this.currentUser.username = newUsername;
            }
        }
    }
};

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    ProfileManager.init();
});
