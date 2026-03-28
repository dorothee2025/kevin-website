// Shared rendering utilities for home/hack/coding/news pages
async function createHomeVideoCard(video) {
  // Get blob URL for stored thumbnails
  let thumbnailUrl = video.thumbnailUrl || 'https://via.placeholder.com/320x180?text=No+Thumbnail';
  if (thumbnailUrl && thumbnailUrl.startsWith('uploads/')) {
    thumbnailUrl = await getFileUrl(thumbnailUrl);
  }

  const card = document.createElement('article');
  card.className = 'video-card';
  card.innerHTML = `
    <div class="image-scroll" style="height:180px;position:relative;overflow:hidden;">
      <img src="${thumbnailUrl}" alt="${video.title}" style="width:100%;height:100%;object-fit:cover;" />
      <div style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);font-size:2rem; color:#00ff66; text-shadow:0 0 12px rgba(0,255,102,0.9);">▶️</div>
    </div>
    <h4>${video.title}</h4>
    <p style="color:#ccc;font-size:0.88rem;margin:6px 8px 0;">${video.description.substring(0, 76)}...</p>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 8px 0; font-size:0.8rem; color:#bbb;">
      <span>${formatUploadTime(video.uploadTimestamp)}</span>
      <span data-ago="${video.uploadTimestamp}" class="time-ago">${getAgo(video.uploadTimestamp)}</span>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px;">
      <div style="display:flex;gap:8px;align-items:center;font-size:0.8rem;color:#ddd;">
        <span>Category: ${video.category || 'general'}</span>
        <span>👁️ ${video.views}</span>
        <span>❤️ ${video.likes}</span>
        <span>💬 ${video.comments.length}</span>
        <span>🔁 ${video.shares}</span>
      </div>
      <button class="watch-btn" data-id="${video.id}" style="padding:6px 12px;border:none;border-radius:8px;background:linear-gradient(135deg,#00ff66,#0bdde5);color:#000;cursor:pointer;font-weight:600;">Watch</button>
    </div>
    <div style="display:flex;justify-content:space-around;gap:6px;padding:6px;">
      <button class="like-btn" data-id="${video.id}" style="flex:1;padding:6px;border:none;border-radius:8px;background:rgba(0,255,102,0.15);color:#00ff99;cursor:pointer;">Like</button>
      <button class="comment-btn" data-id="${video.id}" style="flex:1;padding:6px;border:none;border-radius:8px;background:rgba(0,180,255,0.14);color:#7fd9ff;cursor:pointer;">Comment</button>
      <button class="share-btn" data-id="${video.id}" style="flex:1;padding:6px;border:none;border-radius:8px;background:rgba(255,153,0,0.16);color:#ffd566;cursor:pointer;">Share</button>
      <button class="download-btn" data-url="${video.videoUrl}" style="flex:1;padding:6px;border:none;border-radius:8px;background:rgba(255,0,0,0.15);color:#ffb2b2;cursor:pointer;">Download</button>
    </div>
  `;
  return card;
}

async function createHackCard(video) {
  // Get blob URL for stored thumbnails
  let thumbnailUrl = video.thumbnailUrl || 'https://via.placeholder.com/320x180?text=No+Thumbnail';
  if (thumbnailUrl && thumbnailUrl.startsWith('uploads/')) {
    thumbnailUrl = await getFileUrl(thumbnailUrl);
  }

  const card = document.createElement('article');
  card.className = 'hacking-card';
  card.style.cursor = 'pointer';
  card.innerHTML = `
    <div class="card-image">
      <img src="${thumbnailUrl}" alt="${video.title}" style="width:100%;height:100%;object-fit:cover;" />
      <div class="play-button">▶️</div>
    </div>
    <div class="card-content">
      <h3>${video.title}</h3>
      <p>${video.description.substring(0, 80)}...</p>
      <div class="card-meta" style="justify-content:space-between;font-size:0.75rem;">
        <span>${getAgo(video.uploadTimestamp)}</span>
        <span>${video.views} views</span>
      </div>
      <div style="display:flex;justify-content:space-between;margin-top:10px;">
        <button class="watch-btn" data-id="${video.id}" style="padding:7px 10px;border:none;border-radius:7px;background:rgba(0,255,102,0.2);color:#000;">Watch</button>
        <button class="like-btn" data-id="${video.id}" style="padding:7px 10px;border:none;border-radius:7px;background:rgba(0,255,102,0.16);color:#00ff66;">Like ${video.likes}</button>
      </div>
    </div>
  `;
  return card;
}

async function createNewsCard(news) {
  const card = document.createElement('article');
  card.className = 'news-card news-card-fixed';
  const imgSrc = news.imageUrl && news.imageUrl.startsWith('uploads/') ? await getFileUrl(news.imageUrl) : news.imageUrl;
  card.innerHTML = `
    <div class="news-image"><img src="${imgSrc}" alt="${news.title}" /></div>
    <div class="news-content">
      <div class="news-title">${news.title}</div>
      <div class="news-description">${news.description}</div>
      <div class="news-source">${news.category} • ${formatUploadTime(news.uploadTimestamp)}</div>
    </div>
  `;

  // Fade-in animation (optional enhancement)
  card.style.opacity = '0';
  card.style.transform = 'translateY(10px)';
  card.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
  requestAnimationFrame(() => {
    card.style.opacity = '1';
    card.style.transform = 'translateY(0)';
  });

  return card;
}

function updateTimeAgoFields() {
  document.querySelectorAll('[data-ago]').forEach((el) => {
    const ts = Number(el.getAttribute('data-ago'));
    if (!Number.isNaN(ts)) el.textContent = getAgo(ts);
  });
}

function downloadVideo(url, name) {
  if (!url) return alert('Video not available for download.');
  const link = document.createElement('a');
  link.href = url;
  link.download = name || 'cs-dream-video.mp4';
  document.body.appendChild(link);
  link.click();
  link.remove();
}

function openVideoOverlay(video) {
  let overlay = document.getElementById('dynamicVideoPlayerOverlay');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.id = 'dynamicVideoPlayerOverlay';
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.94);display:flex;align-items:center;justify-content:center;z-index:9999;padding:18px;';
    overlay.innerHTML = `
      <div style="position:relative;max-width:1100px;width:100%;max-height:90%;background:#111;border-radius:12px;padding:8px;box-shadow:0 0 34px rgba(0,0,0,0.65);">
        <button id="closeDynamicVideo" style="position:absolute;top:10px;right:10px;padding:8px 10px;border:none;border-radius:6px;background:#ff5f5f;color:white;cursor:pointer;">Close</button>
        <video id="dynamicVideoPlayer" controls autoplay style="width:100%;height:calc(100%-36px);border-radius:10px;background:#000;"></video>
        <div id="dynamicVideoDetails" style="margin-top:10px;color:#fff;font-size:0.9rem;"></div>
      </div>
    `;
    document.body.appendChild(overlay);
    overlay.querySelector('#closeDynamicVideo').addEventListener('click', () => overlay.remove());
  }
  const vEl = overlay.querySelector('#dynamicVideoPlayer');
  vEl.src = video.videoUrl;
  overlay.querySelector('#dynamicVideoDetails').innerHTML = `
    <h3 style="margin:0;">${video.title}</h3>
    <p style="margin:0.25rem 0;color:#999;">${formatUploadTime(video.uploadTimestamp)} • ${getAgo(video.uploadTimestamp)}</p>
    <p style="margin:0.25rem 0;color:#bbb;">${video.description}</p>
  `;
}

function attachVideoCardHandlers(container) {
  if (!container) return;
  container.querySelectorAll('.watch-btn').forEach((btn) => {
    btn.addEventListener('click', (event) => {
      event.stopPropagation();
      const id = btn.dataset.id;
      const db = getAdminDb();
      const video = db.videos.find((v) => v.id === id);
      if (!video) {
        alert('Video not found');
        return;
      }
      markVideoView(id);
      
      // Prepare comprehensive video data with all required fields
      const uploadDateObj = new Date(video.uploadTimestamp);
      const videoUrl = video.videoUrl || '';
      const thumbUrl = video.thumbnailUrl || 'https://via.placeholder.com/640x360?text=No+Thumbnail';
      const videoTitle = video.title || 'Untitled Video';
      const videoDesc = video.description || 'No description';
      const videoCategory = video.category || 'general';
      const uploadDateFormatted = formatUploadTime(video.uploadTimestamp);
      const uploadTime = uploadDateObj.toLocaleTimeString();
      const uploadDay = uploadDateObj.toLocaleDateString(undefined, { weekday: 'long' });
      
      // Determine player based on video.page field (all use video-player-2 now)
      let targetPlayer = 'video-player-2.html';
      let sourcePage = video.page || 'home';

      // Prepare complete video data object
      const videoData = {
        id: video.id,
        title: videoTitle,
        description: videoDesc,
        video: videoUrl,
        thumbnail: thumbUrl,
        category: videoCategory,
        uploadDate: uploadDateFormatted,
        uploadTime: uploadTime,
        uploadDay: uploadDay,
        views: video.views || 0,
        likes: video.likes || 0,
        comments: (video.comments || []).length,
        shares: video.shares || 0,
        duration: video.duration || '00:00',
        page: sourcePage,
        section: video.section || 'latest'
      };
      
      // Store in sessionStorage (primary method)
      sessionStorage.setItem('selectedVideo', JSON.stringify(videoData));
      
      // Also build URL parameters as backup
      const params = new URLSearchParams(videoData);
      
      // Navigate to video player
      window.location.href = `${targetPlayer}?${params.toString()}`;
    });
  });
  container.querySelectorAll('.like-btn').forEach((btn) => {
    btn.addEventListener('click', async (event) => {
      event.stopPropagation();
      const id = btn.dataset.id;
      markVideoLike(id);
      await renderAllPages();
    });
  });
  container.querySelectorAll('.comment-btn').forEach((btn) => {
    btn.addEventListener('click', async (event) => {
      event.stopPropagation();
      const id = btn.dataset.id;
      const text = prompt('Enter comment text:');
      if (!text) return;
      addVideoComment(id, text);
      await renderAllPages();
    });
  });
  container.querySelectorAll('.share-btn').forEach((btn) => {
    btn.addEventListener('click', async (event) => {
      event.stopPropagation();
      const id = btn.dataset.id;
      markVideoShare(id);
      alert('Share link copied to clipboard.');
      navigator.clipboard?.writeText(window.location.href + '#video-' + id).catch(() => {});
      await renderAllPages();
    });
  });
  container.querySelectorAll('.download-btn').forEach((btn) => {
    const url = btn.dataset.url;
    const title = btn.closest('.video-card')?.querySelector('h4')?.textContent || 'video';
    btn.addEventListener('click', (event) => {
      event.stopPropagation();
      downloadVideo(url, `${title}.mp4`);
    });
  });
}

// Guard against multiple simultaneous renders
let _homeVideosRenderingInProgress = false;

async function renderHomeVideos() {
  // Prevent duplicate render cycles
  if (_homeVideosRenderingInProgress) return;
  _homeVideosRenderingInProgress = true;

  try {
    const container = document.querySelector('.video-grid') || document.querySelector('.videos-container');
    if (!container) return;
    
    // Clear container first - THIS IS CRITICAL
    container.innerHTML = '';

    const db = getAdminDb();
    const videos = db.videos.slice().sort((a, b) => b.uploadTimestamp - a.uploadTimestamp);

    // Deduplicate videos by id and source URL to avoid duplicate card render
    const uniqueVideos = [];
    const seenIds = new Set();
    const seenVideoUrls = new Set();

    for (const video of videos) {
      if (!video || !video.id) continue;

      const normalizedUrl = (video.videoUrl || '').trim();
      
      // Skip if we've already seen this video by ID
      if (seenIds.has(video.id)) {
        console.warn(`Skipping duplicate video with id: ${video.id}`);
        continue;
      }
      
      // Skip if we've already seen this video by URL
      if (normalizedUrl && seenVideoUrls.has(normalizedUrl)) {
        console.warn(`Skipping duplicate video with url: ${normalizedUrl}`);
        continue;
      }

      seenIds.add(video.id);
      if (normalizedUrl) seenVideoUrls.add(normalizedUrl);
      uniqueVideos.push(video);
    }

    if (uniqueVideos.length === 0) {
      container.innerHTML = '<div style="color:#ccc;padding:14px;background:rgba(255,255,255,0.05);border-radius:10px;">No uploaded videos yet. Use admin panel to add one.</div>';
      return;
    }

    // Build all cards before appending
    const cardElements = [];
    for (const video of uniqueVideos) {
      const card = await createHomeVideoCard(video);
      cardElements.push(card);
    }

    // Append all cards to container in one operation
    cardElements.forEach(card => container.appendChild(card));

    // Attach event handlers to container
    attachVideoCardHandlers(container);
  } finally {
    _homeVideosRenderingInProgress = false;
  }
}

// Guard against multiple simultaneous renders
let _hackVideosRenderingInProgress = false;

async function renderHackVideos() {
  if (_hackVideosRenderingInProgress) return;
  _hackVideosRenderingInProgress = true;

  try {
    const db = getAdminDb();

    const phoneGrid = document.querySelector('#phone-section .hacking-grid');
    const compGrid = document.querySelector('#computer-hacking .hacking-grid');
    const appGrid = document.querySelector('#app-hacking .hacking-grid');
    const latestGrid = document.querySelector('.video-grid');

    // Clear ALL containers first
    [phoneGrid, compGrid, appGrid, latestGrid].forEach((grid) => {
      if (!grid) return;
      grid.innerHTML = '';
    });

    const hackVideos = db.videos.filter((video) => video.page === 'hack').sort((a,b)=>b.uploadTimestamp-a.uploadTimestamp);
    
    // Deduplicate by id
    const seenIds = new Set();
    const uniqueHackVideos = hackVideos.filter(video => {
      if (seenIds.has(video.id)) return false;
      seenIds.add(video.id);
      return true;
    });

    if (uniqueHackVideos.length === 0) {
      if (latestGrid) latestGrid.innerHTML = '<div style="color:#ccc;padding:14px;background:rgba(255,255,255,0.05);border-radius:10px;">No uploaded hack videos yet. Upload one via Admin panel.</div>';
      return;
    }

    for (const video of uniqueHackVideos) {
      const card = await createHackCard(video);
      if (video.section === 'phone') phoneGrid?.appendChild(card);
      else if (video.section === 'computer') compGrid?.appendChild(card);
      else if (video.section === 'app') appGrid?.appendChild(card);
      else latestGrid?.appendChild(card);
    }

    attachVideoCardHandlers(phoneGrid);
    attachVideoCardHandlers(compGrid);
    attachVideoCardHandlers(appGrid);
    attachVideoCardHandlers(latestGrid);

    [phoneGrid, compGrid, appGrid].forEach((grid) => attachVideoCardHandlers(grid));
  } finally {
    _hackVideosRenderingInProgress = false;
  }
}

// Guard against multiple simultaneous renders
let _codingVideosRenderingInProgress = false;

async function renderCodingVideos() {
  if (_codingVideosRenderingInProgress) return;
  _codingVideosRenderingInProgress = true;

  try {
    const grid = document.querySelector('.video-grid');
    if (!grid) return;
    
    // Clear grid first
    grid.innerHTML = '';
    
    const videos = getAdminDb().videos.filter((v) => v.page === 'coding' || v.page === 'home').sort((a,b)=>b.uploadTimestamp-a.uploadTimestamp);
    
    // Deduplicate by id
    const seenIds = new Set();
    const uniqueVideos = videos.filter(video => {
      if (seenIds.has(video.id)) return false;
      seenIds.add(video.id);
      return true;
    });

    if (uniqueVideos.length === 0) {
      grid.innerHTML = '<div style="color:#ccc;padding:14px;background:rgba(255,255,255,0.05);border-radius:10px;">No coding videos yet.</div>';
      return;
    }

    for (const video of uniqueVideos) {
      const card = await createHomeVideoCard(video);
      grid.appendChild(card);
    }

    attachVideoCardHandlers(grid);
  } finally {
    _codingVideosRenderingInProgress = false;
  }
}

// Guard against multiple simultaneous renders
let _newsRenderingInProgress = false;

async function renderNews() {
  if (_newsRenderingInProgress) return;
  _newsRenderingInProgress = true;

  try {
    const newsItems = getLatestNews(100); // only news entries then
    const byCategory = { sport: [], school: [], entertainment: [], other: [] };
    
    newsItems.forEach((item) => {
      if (!item || (item.page && item.page !== 'news')) return; // enforce news-only
      const c = (item.category || 'other').toLowerCase();
      if (byCategory[c]) byCategory[c].push(item); else byCategory.other.push(item);
    });

    const sectionMap = [
      {id: 'Sport', key: 'sport'},
      {id: 'school-news', key: 'school'},
      {id: 'entertainment', key: 'entertainment'}
    ];

    for (const entry of sectionMap) {
      const gridClass = entry.id === 'Sport' ? '.featured-grid' : '.news-grid';
      const container = document.querySelector(`#${entry.id} ${gridClass}`);
      if (!container) continue;
      
      // Clear container first
      container.innerHTML = '';
      
      let items = byCategory[entry.key] || [];
      if (items.length === 0) {
        container.innerHTML = '<div style="color:#ccc;padding:12px;">No news content in this category yet.</div>';
        continue;
      }

      // Ensure newest appear first
      items = items.slice().sort((a,b) => b.uploadTimestamp - a.uploadTimestamp);

      for (const news of items) {
        const card = await createNewsCard(news);
        container.appendChild(card);
      }
    }
  } finally {
    _newsRenderingInProgress = false;
  }
}

function getLatestVideoByPage(pageKey) {
  const db = getAdminDb();
  return db.videos
    .filter((video) => video.page === pageKey)
    .sort((a, b) => b.uploadTimestamp - a.uploadTimestamp)[0] || null;
}

function renderHomepageFeatureCards() {
  const mapping = [
    { page: 'news', cardSelector: '.category-card[data-feature-card="news"]', linkHref: 'news-section.html', sectionName: 'News' },
    { page: 'hack', cardSelector: '.category-card[data-feature-card="hack"]', linkHref: 'ICT Tutorials - Tricks.html', sectionName: 'ICT Tutorials' },
    { page: 'coding', cardSelector: '.category-card[data-feature-card="coding"]', linkHref: 'coding.html', sectionName: 'Coding' },
  ];

  mapping.forEach(({ page, cardSelector, linkHref, sectionName }) => {
    const card = document.querySelector(cardSelector);
    if (!card) return;

    const latestVideo = getLatestVideoByPage(page);
    const titleEl = card.querySelector('.card-title');
    const descEl = card.querySelector('.card-description');
    const iconEl = card.querySelector('.card-icon');
    const linkEl = card.querySelector('.card-link');
    
    // Remove old background container if exists
    let bgContainer = card.querySelector('.featured-video-background');
    if (bgContainer) bgContainer.remove();

    // Keep base card label
    if (titleEl) { titleEl.textContent = sectionName; }
    if (linkEl) {
      linkEl.href = linkHref;
      linkEl.innerHTML = 'Watch Now <i class="fas fa-arrow-right"></i>';
    }

    if (!latestVideo) {
      if (descEl) descEl.textContent = `No ${sectionName} upload yet.`;
      if (iconEl) {
        iconEl.style.backgroundImage = '';
        iconEl.style.color = '';
        iconEl.innerHTML = '<i class="fas fa-play"></i>';
      }
      return;
    }

    // Create full-card background with video element showing first frame
    bgContainer = document.createElement('div');
    bgContainer.className = 'featured-video-background';
    
    // Create video element that displays first frame without playing
    const video = document.createElement('video');
    video.className = 'featured-video-bg';
    video.muted = true;
    video.preload = 'metadata';
    video.playsinline = true;
    video.src = latestVideo.videoUrl || latestVideo.thumbnailUrl;
    video.alt = latestVideo.title;
    
    // If thumbnail exists as fallback, use it as poster
    if (latestVideo.thumbnailUrl) {
      video.poster = latestVideo.thumbnailUrl;
    }
    
    bgContainer.appendChild(video);
    card.insertBefore(bgContainer, card.firstChild);

    // Update card description with video info
    if (descEl) {
      descEl.textContent = `${latestVideo.category || 'General'} • ${latestVideo.title}`;
    }

    // Keep icon styled with play button
    if (iconEl) {
      iconEl.style.backgroundImage = '';
      iconEl.style.color = 'rgba(255,255,255,0.95)';
      iconEl.innerHTML = '<i class="fas fa-play" style="font-size:28px;text-shadow:0 0 14px rgba(0,0,0,0.8);"></i>';
    }
  });
}

// Global guard for renderAllPages
let _renderAllPagesInProgress = false;

async function renderAllPages() {
  // Skip if already rendering to prevent accumulation
  if (_renderAllPagesInProgress) {
    console.warn('renderAllPages is already in progress, skipping duplicate call');
    return;
  }
  
  _renderAllPagesInProgress = true;
  try {
    await renderHomeVideos();
    await renderHackVideos();
    await renderCodingVideos();
    await renderNews();
    renderHomepageFeatureCards();
    updateTimeAgoFields();
    processNewContentNotifications();
  } catch (error) {
    console.error('Error in renderAllPages:', error);
  } finally {
    _renderAllPagesInProgress = false;
  }
}

function _userNotificationStorageKey() { return 'cs_dream_new_content_notifications'; }
function _userNotificationSeenKey() { return 'cs_dream_new_content_seen'; }

function _createNotificationContainer() {
  let container = document.querySelector('#userNotificationContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'userNotificationContainer';
    container.style.cssText = 'position:fixed;bottom:16px;right:16px;z-index:9999;display:flex;flex-direction:column;gap:10px;max-width:340px;pointer-events:none;';
    document.body.appendChild(container);
  }
  return container;
}

function _ensureNotificationStyles() {
  if (document.getElementById('userNotificationStyles')) return;
  const style = document.createElement('style');
  style.id = 'userNotificationStyles';
  style.textContent = `
    .content-notify-card { pointer-events:auto; width:320px; background:#0b1320; color:#f3faff; border-radius:12px; box-shadow:0 14px 32px rgba(0,0,0,0.45); overflow:hidden; border:1px solid rgba(0,255,102,0.2); transform:translateY(16px); opacity:0; transition:opacity .25s ease, transform .25s ease; font-family:Inter,system-ui,sans-serif; }
    .content-notify-card.show { opacity:1; transform:translateY(0); }
    .content-notify-grid { display:grid; grid-template-columns:70px 1fr; gap:10px; padding:10px; }
    .content-notify-thumb{width:70px;height:70px;border-radius:8px;background:#111;background-size:cover;background-position:center;}
    .content-notify-meta{display:flex;flex-direction:column;justify-content:center;gap:4px;}
    .content-notify-meta h4{font-size:0.92rem;margin:0;font-weight:700;}
    .content-notify-meta p{font-size:0.8rem;margin:0;color:#a6c8ff;}
    .content-notify-actions{display:flex;align-items:center;justify-content:space-between;padding:8px 10px 10px;}
    .content-notify-actions button{border:none;border-radius:8px;padding:6px 9px;font-size:0.75rem;font-weight:700;cursor:pointer;transition:.2s;}
    .content-notify-view{background:linear-gradient(135deg,#00ff72,#12d8ff);color:#021a18;}
    .content-notify-close{background:rgba(255,255,255,0.1);color:#fff;}
  `;
  document.head.appendChild(style);
}

function _readNotificationQueue() {
  try { return JSON.parse(localStorage.getItem(_userNotificationStorageKey()) || '[]'); } catch (err) { return []; }
}
function _readSeenNotifications() {
  try { return new Set(JSON.parse(localStorage.getItem(_userNotificationSeenKey()) || '[]')); } catch (err) { return new Set(); }
}
function _markSeenNotification(id) {
  const seen = _readSeenNotifications();
  seen.add(id);
  localStorage.setItem(_userNotificationSeenKey(), JSON.stringify(Array.from(seen)));
}

function processNewContentNotifications() {
  const queue = _readNotificationQueue();
  const seen = _readSeenNotifications();
  const pending = queue.filter((item) => item && item.id && !seen.has(item.id)).sort((a,b)=>a.timestamp-b.timestamp);
  if (!pending.length) return;
  _ensureNotificationStyles();
  const container = _createNotificationContainer();

  pending.forEach((item, index) => {
    setTimeout(() => { showUserContentNotification(item); _markSeenNotification(item.id); }, index * 1000);
  });
}

function showUserContentNotification(item) {
  if (!item || !item.id) return;
  const container = _createNotificationContainer();

  const card = document.createElement('div');
  card.className = 'content-notify-card';
  card.innerHTML = `
    <div class="content-notify-grid">
      <div class="content-notify-thumb" style="background-image:url('${item.thumbnailUrl || 'https://via.placeholder.com/80?text=No+Image'}');"></div>
      <div class="content-notify-meta">
        <h4>${item.title || 'New content available'}</h4>
        <p>${item.message || (item.contentType === 'video' ? 'New updated video available' : 'New image content available')}</p>
        <p style="font-size:0.74rem;color:#6cc4ff;">${item.contentType === 'video' ? 'Video' : 'Image/News'}</p>
      </div>
    </div>
    <div class="content-notify-actions">
      <button class="content-notify-view">View Now</button>
      <button class="content-notify-close">×</button>
    </div>
  `;

  const viewButton = card.querySelector('.content-notify-view');
  const closeButton = card.querySelector('.content-notify-close');

  const targetUrl = item.url || (item.contentType === 'video' ? 'video-player-2.html' : 'news-section.html');
  const openUrl = () => {
    if (item.contentType === 'video') {
      window.location.href = targetUrl;
    } else if (item.contentType === 'image') {
      window.location.href = targetUrl;
    } else {
      window.location.href = targetUrl;
    }
  };

  viewButton.addEventListener('click', (e) => { e.stopPropagation(); openUrl(); });
  card.addEventListener('click', openUrl);
  closeButton.addEventListener('click', (e) => { e.stopPropagation(); card.remove(); });

  container.appendChild(card);
  setTimeout(() => card.classList.add('show'), 20);
  setTimeout(() => { card.classList.remove('show'); setTimeout(() => card.remove(), 280); }, 7000);
}

window.addEventListener('DOMContentLoaded', async () => {
  await renderAllPages();
  setInterval(updateTimeAgoFields, 60000);
});
