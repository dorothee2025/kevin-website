<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CS DREAM Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    :root { --primary:#00d4ff; --secondary:#1f2b49; --accent:#ffbb33; --bg:#0f172a; --card:#141f36; --text:#e9edf7; --muted:#b4c5e0; }
    * { box-sizing:border-box; }
    body { margin:0; font-family:'Segoe UI',Roboto,Arial,sans-serif; background:linear-gradient(135deg,#090e1e 0%,#121a33 100%); color:var(--text); }
    a { color:var(--primary); text-decoration:none; }
    .dashboard-layout { display:grid; grid-template-columns:260px 1fr; min-height:100vh; }
    .sidebar { background:var(--card); border-right:1px solid rgba(255,255,255,0.08); padding:20px; display:flex; flex-direction:column; }
    .sidebar h2 { margin:0 0 14px; font-size:1.22rem; color:#fff; }
    .sidebar .nav-link { display:flex; align-items:center; gap:12px; margin-bottom:10px; padding:11px 12px; border-radius:10px; color:#cfd8ee; font-size:0.92rem; border:1px solid transparent; cursor:pointer; transition:all 0.2s ease; }
    .sidebar .nav-link.active, .sidebar .nav-link:hover { background:rgba(0,212,255,0.12); border-color:rgba(0,212,255,0.2); color:#fff; }
    .sidebar .nav-bottom { margin-top:auto; display:flex; flex-direction:column; gap:8px; }
    .sidebar button { background:transparent; border:1px solid rgba(255,255,255,0.12); border-radius:8px; color:#cfd8ee; padding:8px 12px; cursor:pointer; }
    .main { padding:18px; overflow:auto; }
    .top-bar { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
    .top-bar h1 { margin:0; font-size:1.6rem; letter-spacing:0.5px; }
    .top-bar .top-actions { display:flex; align-items:center; gap:10px; }
    .top-actions a { color:#8be3ff; background:rgba(0,0,0,0.3); border-radius:8px; border:1px solid rgba(0,212,255,0.3); padding:8px 12px; font-weight:600; text-transform:uppercase; font-size:0.8rem; }
    .logout-btn { color:#ff6868; background:rgba(255,100,100,0.15); border-radius:8px; border:1px solid rgba(255,100,100,0.4); padding:8px 12px; font-weight:600; text-transform:uppercase; font-size:0.8rem; cursor:pointer; transition:all 0.2s ease; }
    .logout-btn:hover { background:rgba(255,100,100,0.25); border-color:rgba(255,100,100,0.6); }
    .card-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; margin-bottom:20px; }
    .stat-card { background:rgba(12,19,35,0.9); border:1px solid rgba(0,212,255,0.2); border-radius:14px; padding:14px; display:flex; flex-direction:column; gap:8px; }
    .stat-card .label { color:var(--muted); font-size:0.82rem; text-transform:uppercase; letter-spacing:0.72px; }
    .stat-card .value { color:#fff; font-size:1.4rem; font-weight:700; }
    .panel { background:rgba(15,24,44,0.95); border:1px solid rgba(0,212,255,0.2); border-radius:14px; padding:16px; margin-bottom:18px; }
    .panel h3 { margin:0 0 12px; font-size:1.1rem; }
    .layer { display:none; }
    .layer.active { display:block; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .form-grid .full { grid-column:1/-1; }
    label { display:block; margin-bottom:6px; color:#bed6ff; font-size:0.9rem; }
    input, select, textarea { width:100%; border:1px solid rgba(255,255,255,0.2); border-radius:8px; background:#0e1a34; color:#eef5ff; padding:10px 11px; outline:none; }
    input:focus, select:focus, textarea:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(0,212,255,0.18); }
    button.primary { background:linear-gradient(135deg,var(--primary),var(--accent)); border:none; color:#0a0e19; font-weight:700; border-radius:10px; padding:10px 14px; cursor:pointer; }
    button.secondary { border:1px solid rgba(222,230,255,0.3); background:transparent; color:#d8e7ff; }
    .content-table { width:100%; border-collapse:collapse; margin-top:10px; }
    .content-table th, .content-table td { border:1px solid rgba(255,255,255,0.1); padding:10px 8px; text-align:left; font-size:0.9rem; }
    .content-table th { background:rgba(0,212,255,0.08); color:#ecf4ff; }
    .content-table tbody tr:nth-child(odd){ background:rgba(255,255,255,0.02); }
    .action-btn { border:none; border-radius:7px; padding:5px 8px; font-size:0.78rem; cursor:pointer; }
    .action-btn.edit { background:#2a7cff; color:#fff; }
    .action-btn.delete { background:#ff4a4a; color:#fff; }
    .action-btn.preview { background:#58d9a2; color:#061e33; }
    .action-btn.update { background:#ffb300; color:#0e2240; }
    .tag { background:rgba(34,137,255,0.18); color:#a4d9ff; border-radius:6px; padding:2px 8px; font-size:0.78rem; }
    .textarea-resize { resize:vertical; min-height:76px; }
    .split { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:14px; align-items:center; }
    .split input, .split select{ flex:1; min-width:160px; }
    .hero-tag { text-transform:uppercase; letter-spacing:0.6px; color:#9cccff; font-weight:700; }
    .realtime-tile { border:1px dashed rgba(0,212,255,0.35); padding:10px; border-radius:10px; background:rgba(0,0,0,0.2); }
    .realtime-list{max-height:220px;overflow:auto;margin-top:8px;}
    .realtime-item{background:rgba(255,255,255,0.04);border-radius:6px;padding:8px;margin:4px 0;display:flex;justify-content:space-between;align-items:center;}
    .realtime-item small{opacity:.7;}

    @media (max-width:1100px) { .dashboard-layout { grid-template-columns:1fr; } .sidebar{flex-direction:row;overflow-x:auto;position:sticky;top:0;z-index:20; } .sidebar h2{display:none;} .sidebar .nav-link{white-space:nowrap;} .main{padding:12px;} }
  </style>
</head>
<body>
  <div id="adminLockScreen" style="position:fixed;inset:0;z-index:9999;background:rgba(7,12,23,0.92);display:flex;align-items:center;justify-content:center;">
    <div style="width:min(460px,90%);background:linear-gradient(135deg,rgba(13,27,51,0.95),rgba(8,12,22,0.96));border:1px solid rgba(0,212,255,0.3);border-radius:16px;padding:28px;color:#f0f5ff;box-shadow:0 18px 38px rgba(0,0,0,0.45);">
      <h2 style="margin-top:0;margin-bottom:12px;font-size:1.7rem;letter-spacing:0.7px;">Admin Login</h2>
      <p style="margin:0 0 18px;color:#accbff;">Enter password to access the dashboard.</p>
      <input id="adminPasswordInput" type="password" placeholder="Password" style="width:100%;padding:12px;border-radius:10px;border:1px solid rgba(255,255,255,0.25);background:rgba(9,20,40,0.9);color:#fff;font-size:1rem;outline:none;" autocomplete="current-password" />
      <div id="adminPasswordError" style="margin-top:8px;color:#ff6868;font-size:0.88rem;min-height:18px;"></div>
      <button id="adminPasswordBtn" style="margin-top:16px;width:100%;padding:12px;border:none;border-radius:10px;background:linear-gradient(135deg,#00d4ff,#ffbb33);color:#0a0e19;font-weight:700;cursor:pointer;letter-spacing:0.3px;">Unlock</button>
    </div>
  </div>

  <div class="dashboard-layout">
    <aside class="sidebar" role="navigation" aria-label="Admin navigation">
      <h2><i class="fas fa-lock"></i> Admin</h2>
      <div class="nav-link active" data-tab="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</div>
      <div class="nav-link" data-tab="upload"><i class="fas fa-upload"></i> Upload</div>
      <div class="nav-link" data-tab="manage"><i class="fas fa-table"></i> Manage Content</div>
      <div class="nav-link" data-tab="analytics"><i class="fas fa-chart-line"></i> Analytics</div>
      <div class="nav-link" data-tab="settings"><i class="fas fa-cogs"></i> Settings</div>
      <div class="nav-bottom">
        <a class="primary" href="home.php"><i class="fas fa-home"></i> Back to Home</a>
      </div>
    </aside>

    <main class="main" aria-label="Admin main content">
      <div class="top-bar">
        <div><h1>CS DREAM Admin Dashboard</h1><div class="hero-tag">Connected automatically to Home / Hack / Coding / News</div></div>
        <div class="top-actions">
          <a href="home.php" target="_blank">Home</a>
          <a href="ICT Tutorials.php" target="_blank">ICT Tutorials</a>
          <a href="coding.php" target="_blank">Coding</a>
          <a href="news-section.php" target="_blank">News</a>
          <a href="video-player-2.php" target="_blank">Video Player</a>
          <button id="logoutBtn" class="logout-btn">Logout</button>
        </div>
      </div>

      <section id="dashboard" class="layer active">
        <div class="card-grid" id="statCards"></div>
        <div class="panel">
          <h3>Latest uploads</h3>
          <div id="latestUploads" class="realtime-list"></div>
        </div>
        <div class="panel">
          <h3>Quick stats & recent activity</h3>
          <div id="recentActivity" class="realtime-list"></div>
        </div>
      </section>

      <section id="upload" class="layer">
        <div class="panel">
          <h3>Video Upload</h3>
          <div class="form-grid">
            <div>
              <label for="videoFile">Video file</label>
              <input id="videoFile" type="file" accept="video/*" />
            </div>
            <div>
              <label for="videoTitle">Title</label>
              <input id="videoTitleField" type="text" placeholder="Video title" />
            </div>
            <div>
              <label for="videoThumbnail">Optional thumbnail image</label>
              <input id="videoThumbnail" type="file" accept="image/*" />
            </div>
            <div>
              <label for="videoPage">Destination page</label>
              <select id="videoPage">
                <option value="home">Home page</option>
                <option value="hack">Hack videos page</option>
                <option value="coding">Coding page</option>
                <option value="news">News section</option>
              </select>
            </div>
            <div>
              <label for="videoSection">Section</label>
              <select id="videoSection"></select>
            </div>
            <div>
              <label for="videoCategory">Category</label>
              <input id="videoCategory" type="text" placeholder="Example: Tech, Security, ML" />
            </div>
            <div class="full">
              <label for="videoDescription">Description</label>
              <textarea id="videoDescription" class="textarea-resize" placeholder="Video description"></textarea>
            </div>
            <div class="full">
              <button id="uploadVideoBtn" class="primary">Upload Video</button>
            </div>
          </div>
        </div>

        <div class="panel" style="margin-top:12px;">
          <h3>Image Upload</h3>
          <div class="form-grid">
            <div>
              <label for="imageFile">Image file</label>
              <input id="imageFile" type="file" accept="image/*" />
              <img id="imagePreview" style="max-width: 200px; max-height: 200px; display: none; margin-top: 10px; border: 1px solid #ccc;" alt="Image preview" />
            </div>
            <div>
              <label for="imageTitle">Title</label>
              <input id="imageTitle" type="text" placeholder="Image title" />
            </div>
            <div>
              <label for="imagePage">Destination page</label>
              <select id="imagePage">
                <option value="home">Home page</option>
                <option value="hack">Hack videos page</option>
                <option value="coding">Coding page</option>
                <option value="news">News section</option>
              </select>
            </div>
            <div>
              <label for="imageCategory">Category</label>
              <select id="imageCategory">
                <option value="sport">Sports</option>
                <option value="school">School News</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="full">
              <label for="imageDescription">Alt / Caption</label>
              <textarea id="imageDescription" class="textarea-resize" placeholder="Image description or caption"></textarea>
            </div>
            <div class="full">
              <button id="uploadImageBtn" class="primary">Upload Image</button>
            </div>
          </div>
        </div>
      </section>

      <section id="manage" class="layer">
        <div class="split">
          <input id="searchInput" type="search" placeholder="Search by title, page, category" />
          <select id="filterType"><option value="all">All media</option><option value="videos">Videos</option><option value="news">News/Images</option></select>
          <select id="filterOrder"><option value="newest">Newest first</option><option value="oldest">Oldest first</option></select>
        </div>
        <div class="panel" style="padding:4px;">
          <table class="content-table">
            <thead><tr><th>Type</th><th>Title</th><th>Page</th><th>Section</th><th>Uploaded</th><th>Views</th><th>Likes</th><th>Comments</th><th>Actions</th></tr></thead>
            <tbody id="contentTableBody"></tbody>
          </table>
        </div>
      </section>

      <section id="analytics" class="layer">
        <div class="panel">
          <h3>Top summary</h3>
          <div id="analyticsSummary" class="card-grid"></div>
        </div>
        <div class="panel">
          <h3>Recent trends</h3>
          <div class="realtime-list" id="analyticsTrends"></div>
        </div>
      </section>

      <section id="settings" class="layer">
        <div class="panel">
          <h3>Settings</h3>
          <div class="split">
            <label><input type="checkbox" id="autoRefresh" /> Auto-refresh dashboard every 20s</label>
            <label><input type="checkbox" id="notifyUploads" checked /> Show upload notifications</label>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script src="content-data.js"></script>
  <script>
  // Utilities
  const adminState = { selectedItemId: null, selectedType: null, autoRefresh: true, notifyUploads: true };
  const hackSections = [
    { value: 'phone', label: '📱 Phone Hacking Tutorials' },
    { value: 'computer', label: '💻 Computer Hacking Module' },
    { value: 'latest', label: '🆕 Latest Tutorial Videos' }
  ];
  const newsCategories = [
    { value: 'sports', label: 'Sports' },
    { value: 'school', label: 'School News' },
    { value: 'other', label: 'Other categories' }
  ];

  function currentTimestamp() { return Date.now(); }

  async function chooseSectionOptions(page) {
    const el = document.getElementById('videoSection');
    el.innerHTML = '';
    if (page === 'hack') {
      hackSections.forEach((item) => el.insertAdjacentHTML('beforeend', `<option value="${item.value}">${item.label}</option>`));
    } else if (page === 'news') {
      newsCategories.forEach((item) => el.insertAdjacentHTML('beforeend', `<option value="${item.value}">${item.label}</option>`));
    } else {
      el.insertAdjacentHTML('beforeend', `<option value="latest">Latest</option><option value="featured">Featured</option><option value="general">General</option>`);
    }
  }

  function notification(message, type = 'info') {
    if (!adminState.notifyUploads) return;
    const toast = document.createElement('div');
    toast.style.cssText = 'position:fixed;bottom:18px;right:18px;background:rgba(11,18,35,0.92);color:#fff;padding:10px 14px;border:1px solid rgba(0,212,255,0.4);border-radius:10px;box-shadow:0 6px 15px rgba(0,0,0,0.45);z-index:999;';
    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2800);
  }

  function _adminNotificationStorageKey() { return 'cs_dream_new_content_notifications'; }
  function _adminNotificationSeenKey() { return 'cs_dream_new_content_seen'; }

  async function registerNewContentNotification(item) {
    // Push notification to backend
    try {
      await fetch('/api/notifications.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'include',
        body: JSON.stringify({
          content_type: item.contentType,
          content_id: item.content_id,
          title: item.title || 'Untitled'
        })
      });
    } catch (err) {
      console.warn('Notification register failed', err);
    }
  }

  async function markNewContentSeen(id) {
    // Mark notification as seen on backend
    try {
      if (!id) return;
      await fetch('/api/mark_notifications_seen.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'include',
        body: JSON.stringify({ notification_ids: [id] })
      });
    } catch (err) {
      console.warn('Mark notification seen failed', err);
    }
  }

  function updateDashboard() {
    const db = getAdminDb();
    const totalVideos = db.videos.length;
    const totalImages = db.news.length;
    const data = [
      {label:'Total videos', value:totalVideos, icon:'fas fa-film'},
      {label:'Total images', value:totalImages, icon:'fas fa-image'},
      {label:'All content', value:totalVideos + totalImages, icon:'fas fa-layer-group'},
      {label:'Latest activity', value:db.videos.length? 'Video':'Idle', icon:'fas fa-history'}
    ];

    const cardsContainer = document.getElementById('statCards');
    cardsContainer.innerHTML = '';
    data.forEach(item => {
      const card = document.createElement('article');
      card.className = 'stat-card';
      card.innerHTML = `<div style="display:flex;justify-content:space-between;align-items:center;"><span class="label">${item.label}</span><i class="${item.icon}" style="color:var(--primary);"></i></div><div class="value">${item.value}</div>`;
      cardsContainer.appendChild(card);
    });

    const latestContainer = document.getElementById('latestUploads');
    latestContainer.innerHTML = '';
    const latest = [...db.videos, ...db.news].sort((a,b)=>b.uploadTimestamp-a.uploadTimestamp).slice(0,8);
    latest.forEach(item => {
      const type = item.videoUrl ? 'Video' : 'News/Image';
      const el = document.createElement('div');
      el.className='realtime-item';
      el.innerHTML = `<span>${type} • ${item.title || item.title || 'Untitled'}</span><small>${new Date(item.uploadTimestamp).toLocaleString()}</small>`;
      latestContainer.appendChild(el);
    });

    const activity = document.getElementById('recentActivity');
    activity.innerHTML='';
    [...db.videos, ...db.news].sort((a,b)=>b.uploadTimestamp-a.uploadTimestamp).slice(0,6).forEach(item => {
      const type = item.videoUrl ? '📹' : '📰';
      const line = document.createElement('div');
      line.className='realtime-item';
      line.innerHTML = `<span>${type} ${item.title || item.name || 'Untitled'} (${item.page || item.category || 'N/A'})</span><small>${getAgo(item.uploadTimestamp)}</small>`;
      activity.appendChild(line);
    });
  }

  async function saveFile(pathFolder, fileInput) {
    if (!fileInput || fileInput.files.length === 0) return '';
    const file = fileInput.files[0];
    const path = `${pathFolder}/${Date.now()}-${file.name}`.replace(/\s+/g,'-').toLowerCase();
    try {
      await saveFileBlob(path, file);
      return path;
    } catch (err) {
      console.warn('file save failed', err);
      return path;
    }
  }

  async function runUploadVideo() {
    const videoFileInput = document.getElementById('videoFile');
    const url = await saveFile('uploads/videos', videoFileInput);
    const videoThumbnailInput = document.getElementById('videoThumbnail');
    const thumbPath = await saveFile('uploads/images', videoThumbnailInput);

    const entry = {
      title:document.getElementById('videoTitleField').value.trim() || 'Untitled Video',
      description:document.getElementById('videoDescription').value.trim() || 'No description',
      page:document.getElementById('videoPage').value,
      section:document.getElementById('videoSection').value || 'latest',
      videoUrl: url || '',
      thumbnailUrl: thumbPath || '',
      uploadTimestamp: Date.now(),
      views:0,likes:0,comments:[],shares:0,
      category: document.getElementById('videoCategory').value.trim() || document.getElementById('videoSection').value || 'general',
      status:'Published'
    };

    if (!entry.videoUrl) {
      notification('⚠️ Select a video file before upload', 'warn');
      return;
    }

    const saved = addVideoEntry(entry);
    notification(`✅ Video uploaded: ${saved.title}`);
    registerNewContentNotification({
      id: `video_${saved.id || Date.now()}`,
      contentType: 'video',
      title: saved.title,
      message: 'New tutorial video uploaded',
      thumbnailUrl: saved.thumbnailUrl || saved.videoUrl || '',
      page: saved.page,
      section: saved.section,
      url: `video-player-2.php?video=${encodeURIComponent(saved.videoUrl)}&title=${encodeURIComponent(saved.title)}`,
      timestamp: Date.now(),
    });
    clearUploadFields('video');
    updateDashboard();
    renderManageTable();
  }

  async function runUploadImage() {
    const imageFileInput = document.getElementById('imageFile');
    const path = await saveFile('uploads/images', imageFileInput);

    if (!path) { notification('⚠️ Select an image file', 'warn'); return; }

    const entry = {
      title:document.getElementById('imageTitle').value.trim() || 'Untitled Image',
      description:document.getElementById('imageDescription').value.trim() || 'No description available',
      imageUrl:path,
      category:document.getElementById('imageCategory').value,
      page:'news', // force news section only to avoid home/all videos picks
      uploadTimestamp:Date.now(),
      status:'Published'
    };

    addNewsEntry(entry);
    notification(`✅ Image uploaded: ${entry.title}`);
    registerNewContentNotification({
      id: `image_${Date.now()}`,
      contentType: 'image',
      title: entry.title,
      message: 'New image added to news section',
      thumbnailUrl: entry.imageUrl,
      page: entry.page,
      section: entry.category || '',
      url: entry.page === 'news' ? 'news-section.php' : (entry.page === 'home' ? 'home.php' : 'news-section.php'),
      timestamp: Date.now(),
    });
    clearUploadFields('image');
    updateDashboard();
    renderManageTable();
  }

  function clearUploadFields(type) {
    if (type === 'video') {
      document.getElementById('videoFile').value=''; document.getElementById('videoTitleField').value='';
      document.getElementById('videoThumbnail').value=''; document.getElementById('videoDescription').value='';
      document.getElementById('videoCategory').value='';
    } else {
      document.getElementById('imageFile').value=''; document.getElementById('imageTitle').value='';
      document.getElementById('imageDescription').value='';
    }
  }

  function previewItem(item) {
    if (item.videoUrl) {
      const url = item.videoUrl;
      const player = 'video-player-2.php';
      const params = new URLSearchParams({ video: url, title: item.title, category: item.category || '', description: item.description || '', uploadDate: formatUploadTime(item.uploadTimestamp), views: item.views||0, duration: item.duration || '00:00', page: item.page });
      window.open(`${player}?${params.toString()}`,'_blank');
    } else {
      alert('Preview for image content is available on target pages where image cards are shown.');
    }
  }

  function populateEditFields(item, type) {
    if (type === 'video') {
      document.getElementById('videoTitleField').value = item.title;
      document.getElementById('videoDescription').value = item.description;
      document.getElementById('videoPage').value = item.page;
      document.getElementById('videoSection').value = item.section;
      document.getElementById('videoCategory').value = item.category || item.section || '';
      adminState.selectedItemId = item.id;
      adminState.selectedType = 'video';
      document.getElementById('uploadVideoBtn').textContent = 'Update Video';
    } else {
      document.getElementById('imageTitle').value = item.title;
      document.getElementById('imageDescription').value = item.description || '';
      document.getElementById('imagePage').value = item.page;
      document.getElementById('imageCategory').value = item.category;
      adminState.selectedItemId = item.id;
      adminState.selectedType = 'news';
      document.getElementById('uploadImageBtn').textContent = 'Update Image';
    }
  }

  async function applyUpdate() {
    const type = adminState.selectedType;
    const id = adminState.selectedItemId;
    if (!type || !id) return;

    if (type === 'video') {
      const existing = getAdminDb().videos.find(v=>v.id===id);
      if (!existing) return;
      const updated = {
        title:document.getElementById('videoTitleField').value.trim() || existing.title,
        description:document.getElementById('videoDescription').value.trim() || existing.description,
        page:document.getElementById('videoPage').value,
        section:document.getElementById('videoSection').value,
        category:document.getElementById('videoCategory').value.trim() || document.getElementById('videoSection').value || existing.category,
        uploadTimestamp:existing.uploadTimestamp,
      };
      updateVideoEntry(id, updated);
      notification('🛠️ Video updated successfully');
      adminState.selectedItemId = null; adminState.selectedType = null;
      document.getElementById('uploadVideoBtn').textContent = 'Upload Video';
    } else {
      const existing = getAdminDb().news.find(n=>n.id===id);
      if (!existing) return;
      updateNewsEntry(id, {
        title:document.getElementById('imageTitle').value.trim() || existing.title,
        category:document.getElementById('imageCategory').value,
        page:document.getElementById('imagePage').value,
        imageUrl:existing.imageUrl,
      });
      notification('🛠️ Image metadata updated');
      adminState.selectedItemId = null; adminState.selectedType = null;
      document.getElementById('uploadImageBtn').textContent = 'Upload Image';
    }

    updateDashboard();
    renderManageTable();
  }

  function deleteEntry(id, type) {
    if (!confirm('Delete this content?')) return;
    if (type === 'video') deleteVideoEntry(id); else deleteNewsEntry(id);
    renderManageTable();
    updateDashboard();
    notification('🗑️ Content deleted');
  }

  function renderManageTable() {
    const db = getAdminDb();
    const query = document.getElementById('searchInput').value.toLowerCase();
    const filterType = document.getElementById('filterType').value;
    const order = document.getElementById('filterOrder').value;

    let entries = [];
    if (filterType !== 'news') entries = entries.concat(db.videos.map(v=>({ ...v, contentType:'video' })));
    if (filterType !== 'videos') entries = entries.concat(db.news.map(n=>({ ...n, contentType:'news' })));

    entries = entries.filter(item => {
      if (!query) return true;
      return (item.title && item.title.toLowerCase().includes(query)) ||
             (item.page && item.page.toLowerCase().includes(query)) ||
             (item.category && item.category.toLowerCase().includes(query));
    });

    entries.sort((a,b)=> order==='newest' ? b.uploadTimestamp-a.uploadTimestamp : a.uploadTimestamp-b.uploadTimestamp);

    const body = document.getElementById('contentTableBody');
    body.innerHTML = '';

    if (entries.length === 0) {
      body.innerHTML = '<tr><td colspan="9" style="text-align:center;opacity:.8;">No content found.</td></tr>';
      return;
    }

    entries.forEach(item => {
      const row = document.createElement('tr');
      const type = item.contentType === 'video' ? 'Video' : 'Image';
      const section = item.section || item.category || '-';
      const uploaded = new Date(item.uploadTimestamp).toLocaleString();
      const views = item.views || '-';
      const likes = item.likes || '-';
      const comments = item.comments ? item.comments.length : '-';

      row.innerHTML = `
        <td>${type}</td>
        <td>${item.title || 'Untitled'}</td>
        <td>${item.page || '-'}</td>
        <td>${section}</td>
        <td>${uploaded}</td>
        <td>${views}</td>
        <td>${likes}</td>
        <td>${comments}</td>
        <td>
          <button class="action-btn preview" data-id="${item.id}">Preview</button>
          <button class="action-btn edit" data-id="${item.id}">Edit</button>
          <button class="action-btn update" data-id="${item.id}">Update</button>
          <button class="action-btn delete" data-id="${item.id}">Delete</button>
        </td>
      `;

      body.appendChild(row);

      row.querySelector('.preview').addEventListener('click', () => previewItem(item));
      row.querySelector('.edit').addEventListener('click', () => populateEditFields(item, item.contentType));
      row.querySelector('.update').addEventListener('click', () => { adminState.selectedItemId = item.id; adminState.selectedType = item.contentType; applyUpdate(); });
      row.querySelector('.delete').addEventListener('click', () => deleteEntry(item.id, item.contentType));
    });
  }

  function renderAnalytics() {
    const db = getAdminDb();
    const totalVideos = db.videos.length;
    const totalNews = db.news.length;
    const totalViews = db.videos.reduce((sum,v)=>sum+(Number(v.views)||0),0);
    const topVideo = [...db.videos].sort((a,b)=> Number(b.views||0) - Number(a.views||0))[0] || null;

    const summary = document.getElementById('analyticsSummary');
    summary.innerHTML = '';
    const items = [
      { label:'Total videos', value:totalVideos },
      { label:'Total images', value:totalNews },
      { label:'Total views', value:totalViews },
      { label:'Top video', value:topVideo ? topVideo.title : 'N/A' }
    ];
    items.forEach(item => {
      const c = document.createElement('div'); c.className='stat-card'; c.innerHTML = `<div class="label">${item.label}</div><div class="value">${item.value}</div>`;
      summary.appendChild(c);
    });

    const trends = document.getElementById('analyticsTrends');
    trends.innerHTML = '';

    const newest = [...db.videos, ...db.news].sort((a,b)=>b.uploadTimestamp-a.uploadTimestamp).slice(0,5);
    newest.forEach(item => {
      const it = document.createElement('div'); it.className='realtime-item'; it.innerHTML=`<span>${item.title || 'Untitled'} <span class="tag">${item.contentType=== 'video' ? 'Video' : 'News'}</span></span><small>${getAgo(item.uploadTimestamp)}</small>`;
      trends.appendChild(it);
    });
  }

  function switchTab(tabId) {
    document.querySelectorAll('.layer').forEach(layer => layer.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    document.querySelectorAll('.sidebar .nav-link').forEach(link => link.classList.toggle('active', link.dataset.tab === tabId));
    if (tabId === 'analytics') renderAnalytics();
  }

  document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    link.addEventListener('click', () => switchTab(link.dataset.tab));
  });

  document.getElementById('videoPage').addEventListener('change', (e)=>chooseSectionOptions(e.target.value));
  document.getElementById('uploadVideoBtn').addEventListener('click', async (e) => {
    e.preventDefault();
    if (adminState.selectedItemId && adminState.selectedType === 'video') {
      await applyUpdate();
    } else {
      await runUploadVideo();
    }
  });
  document.getElementById('imageFile').addEventListener('change', (e) => {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      preview.style.display = 'none';
    }
  });

  document.getElementById('uploadImageBtn').addEventListener('click', async (e) => {
    e.preventDefault();
    if (adminState.selectedItemId && adminState.selectedType === 'news') {
      await applyUpdate();
    } else {
      await runUploadImage();
    }
  });

  ['searchInput','filterType','filterOrder'].forEach(id => {
    document.getElementById(id).addEventListener('input', renderManageTable);
  });

  document.getElementById('autoRefresh').addEventListener('change', (e)=> adminState.autoRefresh = e.target.checked);
  document.getElementById('notifyUploads').addEventListener('change', (e)=> adminState.notifyUploads = e.target.checked);

  function setupPeriodicRefresh() {
    setInterval(() => {
      if (adminState.autoRefresh) { updateDashboard(); renderManageTable(); renderAnalytics(); }
    }, 20000);
  }

  // Admin Authentication (PHP Session Based)
  async function checkAdminAuth() {
    try {
      const res = await fetch('/api/admin_check.php', {
        method: 'GET',
        credentials: 'include'
      });
      return res.ok;
    } catch (e) {
      return false;
    }
  }

  async function authenticateAdmin(password) {
    try {
      const res = await fetch('/api/admin_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'include',
        body: JSON.stringify({ password })
      });

      if (!res.ok) {
        return { success: false, error: 'Invalid password' };
      }

      const data = await res.json();
      return { success: true, message: 'Authenticated' };
    } catch (e) {
      return { success: false, error: 'Authentication error' };
    }
  }

  async function logoutAdmin() {
    try {
      await fetch('/api/admin_logout.php', {
        method: 'POST',
        credentials: 'include'
      });
    } catch (e) {
      console.error('Logout error', e);
    }
    window.location.href = 'home.php';
  }

  function lockAdminScreen(on) {
    const lock = document.getElementById('adminLockScreen');
    if (!lock) return;
    lock.style.display = on ? 'flex' : 'none';
  }

  async function requireAdminAuth() {
    const authenticated = await checkAdminAuth();
    if (authenticated) {
      lockAdminScreen(false);
      return true;
    }
    lockAdminScreen(true);
    return false;
  }

  document.getElementById('adminPasswordBtn').addEventListener('click', async () => {
    const input = document.getElementById('adminPasswordInput');
    const error = document.getElementById('adminPasswordError');
    const value = input.value.trim();

    const result = await authenticateAdmin(value);
    if (result.success) {
      error.textContent = '';
      input.value = '';
      lockAdminScreen(false);
      updateDashboard();
      renderManageTable();
      renderAnalytics();
    } else {
      error.textContent = result.error || 'Incorrect password';
      input.value = '';
      input.focus();
    }
  });

  async function initAdminPage() {
    if (!await requireAdminAuth()) return;
    chooseSectionOptions(document.getElementById('videoPage').value);
    updateDashboard();
    renderManageTable();
    renderAnalytics();
    setupPeriodicRefresh();
  }

  window.addEventListener('DOMContentLoaded', initAdminPage);

  // Logout button handler
  document.getElementById('logoutBtn').addEventListener('click', logoutAdmin);
  </script>
</body>
</html>
