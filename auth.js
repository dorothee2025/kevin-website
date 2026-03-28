// auth.js - API based authentication for CS Dream (PHP Sessions Backend)
const API_BASE = '/api';

// Note: Authentication is now handled via PHP sessions
// No localStorage needed - backend handles all auth state

function isLoggedIn() {
    return document.body.dataset.authenticated === 'true';
}

function authHeaders() {
    // Sessions handle auth - no token headers needed
    return {};
}

async function login(usernameOrEmail, password) {
    const res = await fetch(API_BASE + '/auth_login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username: usernameOrEmail, password }),
        credentials: 'include',
    });

    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error || 'Login failed');
    }

    const data = await res.json();
    // No need to store token - PHP session handles it
    return data.user;
}

async function register(username, email, password) {
    const res = await fetch(API_BASE + '/auth_register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, email, password }),
        credentials: 'include',
    });

    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error || 'Registration failed');
    }

    const data = await res.json();
    return data.user;
}

async function getMe() {
    const res = await fetch(API_BASE + '/auth_me.php', {
        method: 'GET',
        headers: { ...authHeaders() },
        credentials: 'include',
    });

    if (!res.ok) {
        return null;
    }
    const data = await res.json();
    return data.user;
}

async function logout() {
    try {
        await fetch(API_BASE + '/auth_logout.php', {
            method: 'POST',
            credentials: 'include'
        });
    } catch (e) {
        console.error('Logout error:', e);
    }
    window.location.href = '/login.php';
}

async function fetchNews(options = {}) {
    const query = new URLSearchParams(options).toString();
    const res = await fetch(API_BASE + '/news.php?' + query, {
        method: 'GET',
        headers: { ...authHeaders() },
        credentials: 'include',
    });
    if (!res.ok) {
        throw new Error('Failed to fetch news');
    }
    return res.json();
}

async function createNews(payload) {
    const res = await fetch(API_BASE + '/news.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            ...authHeaders(),
        },
        credentials: 'include',
        body: JSON.stringify(payload),
    });
    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error || 'Create news failed');
    }
    return res.json();
}

async function updateNews(payload) {
    const res = await fetch(API_BASE + '/news.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            ...authHeaders(),
        },
        credentials: 'include',
        body: JSON.stringify(payload),
    });
    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error || 'Update news failed');
    }
    return res.json();
}

async function deleteNews(newsId) {
    const res = await fetch(API_BASE + '/news.php?id=' + encodeURIComponent(newsId), {
        method: 'DELETE',
        headers: { ...authHeaders() },
        credentials: 'include',
    });
    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error || 'Delete news failed');
    }
    return res.json();
}

async function fetchVideos(options = {}) {
    const query = new URLSearchParams(options).toString();
    const res = await fetch(API_BASE + '/videos.php?' + query, {
        method: 'GET',
        headers: { ...authHeaders() },
        credentials: 'include',
    });
    if (!res.ok) {
        throw new Error('Failed to fetch videos');
    }
    return res.json();
}

async function createVideo(payload) {
    const res = await fetch(API_BASE + '/videos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            ...authHeaders(),
        },
        credentials: 'include',
        body: JSON.stringify(payload),
    });
    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error || 'Create video failed');
    }
    return res.json();
}

async function updateVideo(payload) {
    const res = await fetch(API_BASE + '/videos.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            ...authHeaders(),
        },
        credentials: 'include',
        body: JSON.stringify(payload),
    });
    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error || 'Update video failed');
    }
    return res.json();
}

async function deleteVideo(videoId) {
    const res = await fetch(API_BASE + '/videos.php?id=' + encodeURIComponent(videoId), {
        method: 'DELETE',
        headers: { ...authHeaders() },
        credentials: 'include',
    });
    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error || 'Delete video failed');
    }
    return res.json();
}

async function fetchComments(contentType, contentId) {
    const query = new URLSearchParams({ content_type: contentType, content_id: contentId }).toString();
    const res = await fetch(API_BASE + '/comments.php?' + query, { method: 'GET', headers: { ...authHeaders() } });
    if (!res.ok) {
        throw new Error('Failed to fetch comments');
    }
    return res.json();
}

async function addComment(contentType, contentId, commentText) {
    const res = await fetch(API_BASE + '/comments.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', ...authHeaders() },
        body: JSON.stringify({ content_type: contentType, content_id: contentId, comment_text: commentText }),
    });
    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error ; 'Add comment failed');
    }
    return res.json();
}

async function likeContent(contentType, contentId) {
    const res = await fetch(API_BASE + '/likes.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', ...authHeaders() },
        body: JSON.stringify({ content_type: contentType, content_id: contentId }),
    });
    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error ; 'Like failed');
    }
    return res.json();
}

async function unlikeContent(contentType, contentId) {
    const res = await fetch(API_BASE + '/likes.php?content_type=' + encodeURIComponent(contentType) + '&content_id=' + encodeURIComponent(contentId), {
        method: 'DELETE',
        headers: { ...authHeaders() },
    });
    if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error ; 'Unlike failed');
    }
    return res.json();
}

async function getLikeCount(contentType, contentId) {
    const res = await fetch(API_BASE + '/likes.php?content_type=' + encodeURIComponent(contentType) + '&content_id=' + encodeURIComponent(contentId), {
        method: 'GET',
        headers: { ...authHeaders() },
    });
    if (!res.ok) {
        throw new Error('Get like count failed');
    }
    return res.json();
}

function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]);
}
