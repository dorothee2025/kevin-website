# Video Player Customization Guide

## 🎥 How to Customize Videos

### Option 1: Change Default Video (Quick)

Edit line in `video-player-2.html` where the default video loads:

```html
<h1 class="video-title" id="videoTitle">Advanced Coding Techniques & Web Development</h1>
```

Change the text to your video title.

---

### Option 2: Add Your Own Videos (Recommended)

**Step 1:** Add your video thumbnails to the `photos/` folder

**Step 2:** Update the Related Videos in the sidebar

Find this section in `video-player-2.html`:
```html
<div class="related-video-item" onclick="loadVideo('React Hooks Deep Dive', 'photos/vv.jpg', 'CODING', '3 weeks ago', '28.5K', '18:45', 'Master React Hooks...')">
```

Replace with your video info:
```html
<div class="related-video-item" onclick="loadVideo('Your Video Title', 'photos/your-image.jpg', 'CATEGORY', 'upload date', 'view count', 'duration', 'your description')">
```

**Parameters:**
- `'Your Video Title'` - Display name of the video
- `'photos/your-image.jpg'` - Path to thumbnail image
- `'CATEGORY'` - Category (CODING, HACKING, SPORTS, etc.)
- `'upload date'` - When uploaded (e.g., "2 weeks ago")
- `'view count'` - Number of views (e.g., "45.2K")
- `'duration'` - Video length (e.g., "15:32")
- `'your description'` - Full description text

---

### Option 3: Add Actual Video Files

To play real videos instead of images:

**Replace this:**
```html
<div class="video-player">
    <img id="videoThumbnail" src="photos/download.jpg" alt="Video Thumbnail">
</div>
```

**With this:**
```html
<div class="video-player">
    <video id="videoPlayer" controls width="100%" height="100%">
        <source src="videos/your-video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
```

**Then update the JavaScript:**
```javascript
document.querySelector('.watch-btn').addEventListener('click', function() {
    document.getElementById('videoPlayer').play();
});
```

---

## 📝 Example: Complete Video Setup

### HTML (video-player-2.html)
```html
<!-- Change the default video info -->
<h1 class="video-title" id="videoTitle">Web Development Masterclass 2025</h1>
<span id="viewCount">125.5K</span> views
<span id="uploadDate">3 days ago</span>
<span id="duration">45:20</span>
<span class="category-badge" id="categoryBadge">WEB DEVELOPMENT</span>
<p class="video-description" id="videoDescription">
    Complete guide to modern web development with HTML, CSS, JavaScript, and frameworks...
</p>
```

### Add Related Video Example
```html
<div class="related-video-item" onclick="loadVideo('React.js Advanced Patterns', 'photos/react-advanced.jpg', 'WEB DEVELOPMENT', '1 week ago', '89.3K', '52:15', 'Learn advanced React patterns and optimization techniques for production applications.')">
    <img src="photos/react-advanced.jpg" alt="React Video" class="related-thumbnail">
    <div class="related-info">
        <div class="related-title">React.js Advanced Patterns</div>
        <div class="related-views">89.3K views • 1 week ago</div>
    </div>
</div>
```

---

## 🎨 Popular Video Categories

Use these for your category badges:
- 🖥️ `WEB DEVELOPMENT`
- 📱 `MOBILE APPS`
- 🔧 `HACKING TRICKS`
- ⚽ `SPORTS`
- 🎵 `MUSIC`
- 🎓 `TUTORIALS`
- 🚀 `ADVANCED CODING`
- 💡 `TIPS & TRICKS`
- 🔒 `CYBERSECURITY`
- 🎮 `GAMING`

---

## 💾 Best Practices

### Image Optimization
- Use JPG for photos (smaller file size)
- Use PNG for graphics (better quality)
- Recommended size: 1280x720 pixels or 16:9 aspect ratio
- File size: Keep under 500KB per image

### Video Files
- Use MP4 format (widely supported)
- Resolution: 1080p or 720p recommended
- Bitrate: 2500-5000 kbps
- Host on dedicated server or CDN

### Thumbnail Design
- Make them eye-catching
- Include text overlay if possible
- Maintain consistent style
- Use bright, contrasting colors

---

## 🔄 Dynamic Video Loading

The `loadVideo()` function automatically updates:
- Title
- Thumbnail
- Category
- Upload date
- View count
- Duration
- Description

Just click a related video and it all updates instantly!

---

## 🚀 Next Steps

1. ✅ Add your actual video files to `videos/` folder
2. ✅ Add thumbnails to `photos/` folder
3. ✅ Update video titles and descriptions
4. ✅ Customize categories
5. ✅ Test on different devices
6. ✅ Enable dark mode and verify styling

---

**Your video player is ready! Start adding content today! 🎬**
