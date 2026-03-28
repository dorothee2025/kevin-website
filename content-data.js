// content-data.js - API backed content operations (PHP + Session backend)
// Uses API endpoints and auth.js helpers (fetchNews, createNews, updateNews, deleteNews, fetchVideos, createVideo, updateVideo, deleteVideo)
// No localStorage - all state stored in database

async function getAdminDb() {
  const newsResponse = await fetchNews({ status: 'Published', limit: 1000 }).catch(() => ({ news: [] }));
  const videosResponse = await fetchVideos({ status: 'Published', limit: 1000 }).catch(() => ({ videos: [] }));
  return {
    news: Array.isArray(newsResponse.news) ? newsResponse.news : [],
    videos: Array.isArray(videosResponse.videos) ? videosResponse.videos : [],
  };
}

async function saveAdminDb() {
  console.warn('saveAdminDb is now no-op; use API actions directly.');
}

function ensureVideoDefaults(v) {
  return {
    video_id: v.video_id != null ? v.video_id : null,
    title: (v.title != null ? String(v.title) : '').trim() ? (v.title != null ? String(v.title) : '').trim() : 'Untitled Video',
    description: (v.description != null ? String(v.description) : '').trim() ? (v.description != null ? String(v.description) : '').trim() : 'No description available',
    video_file: v.video_file != null ? v.video_file : '',
    thumbnail: v.thumbnail != null ? v.thumbnail : 'https://via.placeholder.com/640x360?text=No+Thumbnail',
    category_id: v.category_id != null ? v.category_id : null,
    video_type: v.video_type != null ? v.video_type : 'general',
    views: Number(v.views != null ? v.views : 0),
    likes: Number(v.likes != null ? v.likes : 0),
    comments_count: Number(v.comments_count != null ? v.comments_count : 0),
    status: v.status != null ? v.status : 'Published',
    duration: Number(v.duration != null ? v.duration : 0),
    featured: v.featured ? 1 : 0,
    uploader_id: v.uploader_id != null ? v.uploader_id : null,
  };
}

function ensureNewsDefaults(n) {
  return {
    news_id: n.news_id != null ? n.news_id : null,
    title: (n.title != null ? String(n.title) : '').trim() ? (n.title != null ? String(n.title) : '').trim() : 'Untitled News',
    description: (n.description != null ? String(n.description) : '').trim() ? (n.description != null ? String(n.description) : '').trim() : 'No description available',
    category_id: n.category_id != null ? n.category_id : null,
    image_url: n.image_url != null ? n.image_url : 'https://via.placeholder.com/640x360?text=No+Image',
    author_id: n.author_id != null ? n.author_id : null,
    status: n.status != null ? n.status : 'Published',
    views: Number(n.views != null ? n.views : 0),
    featured: n.featured ? 1 : 0,
  };
}

async function addVideoEntry(video) {
  const entry = ensureVideoDefaults(video);
  if (!entry.title || !entry.video_file) throw new Error('Video title and video_file are required');
  return createVideo(entry);
}

async function updateVideoEntry(id, updates) {
  const entry = ensureVideoDefaults(Object.assign({}, updates, { video_id: id }));
  return updateVideo(Object.assign({}, entry, { video_id: id }));
}

async function deleteVideoEntry(id) {
  return deleteVideo(id);
}

async function addNewsEntry(news) {
  const entry = ensureNewsDefaults(news);
  if (!entry.title || !entry.description) throw new Error('News title and description are required');
  return createNews(entry);
}

async function updateNewsEntry(id, updates) {
  const entry = ensureNewsDefaults(Object.assign({}, updates, { news_id: id }));
  return updateNews(Object.assign({}, entry, { news_id: id }));
}

async function deleteNewsEntry(id) {
  return deleteNews(id);
}

function formatUploadTime(ts) {
  const d = new Date(ts);
  const date = d.toLocaleDateString();
  const time = d.toLocaleTimeString();
  const day = d.toLocaleDateString(undefined, { weekday: 'long' });
  return `${date} • ${time} • ${day}`;
}

function getAgo(ts) {
  const distance = Date.now() - ts;
  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
  const minutes = Math.floor((distance / (1000 * 60)) % 60);
  if (days > 0) return `${days} day${days === 1 ? '' : 's'} ago`;
  if (hours > 0) return `${hours} hour${hours === 1 ? '' : 's'} ago`;
  if (minutes > 0) return `${minutes} minute${minutes === 1 ? '' : 's'} ago`;
  return 'just now';
}
