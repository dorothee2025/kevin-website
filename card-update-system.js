/* ==================== AUTOMATIC HOME PAGE CARD UPDATE SYSTEM ==================== */
/* This system automatically updates the three cards (News, Hack Tricks, Coding) 
   with the latest content from the shared admin database. Updates happen in real-time. */

const CardUpdateSystem = (() => {
  const CARD_CONFIG = {
    news: {
      cardSelector: '[data-feature-card="news"]',
      // Keep the news tile on home static; news posts display only in news-section.html
      contentGetter: () => [],
      imageKey: 'imageUrl',
      titleKey: 'title',
      statsSelector: '.stat-number',
      statsFormatter: (content) => content.length,
      getTitle: (item) => item.title,
    },
    hack: {
      cardSelector: '[data-feature-card="hack"]',
      contentGetter: () => getLatestHackVideos(4),
      imageKey: 'thumbnailUrl',
      titleKey: 'title',
      statsSelector: '.stat-number',
      statsFormatter: (content) => content.length,
      getTitle: (item) => item.title,
    },
    coding: {
      cardSelector: '[data-feature-card="coding"]',
      contentGetter: () => getLatestCodingVideos(1),
      imageKey: 'thumbnailUrl',
      titleKey: 'title',
      statsSelector: '.stat-number',
      statsFormatter: (content) => content.length,
      getTitle: (item) => item.title,
    },
  };

  async function updateCardBackground(card, imageUrl) {
    if (!card) return;
    
    let bgContainer = card.querySelector('.featured-video-background');
    if (!bgContainer) {
      bgContainer = document.createElement('div');
      bgContainer.className = 'featured-video-background';
      card.insertBefore(bgContainer, card.firstChild);
    }

    // For stored files, get the blob URL
    let finalUrl = imageUrl;
    if (imageUrl && imageUrl.startsWith('uploads/')) {
      finalUrl = await getFileUrl(imageUrl);
    }

    bgContainer.style.backgroundImage = `url('${finalUrl}')`;
    bgContainer.style.backgroundSize = 'cover';
    bgContainer.style.backgroundPosition = 'center';
    bgContainer.style.backgroundRepeat = 'no-repeat';
    bgContainer.style.position = 'absolute';
    bgContainer.style.top = '0';
    bgContainer.style.left = '0';
    bgContainer.style.width = '100%';
    bgContainer.style.height = '100%';
    bgContainer.style.borderRadius = '20px';
    bgContainer.style.overflow = 'hidden';
    bgContainer.style.zIndex = '1';
    bgContainer.style.opacity = '0.95';
    bgContainer.style.transition = 'opacity 0.4s ease';
  }

  function updateCardStats(card, formattedValue) {
    if (!card) return;
    const statNumbers = card.querySelectorAll('.stat-number');
    if (statNumbers.length > 0) {
      statNumbers[0].textContent = formattedValue;
    }
  }

  async function updateCard(cardType) {
    const config = CARD_CONFIG[cardType];
    if (!config) return;

    const card = document.querySelector(config.cardSelector);
    if (!card) return;

    try {
      const content = config.contentGetter();
      if (!content || content.length === 0) return;

      const latestItem = content[0];
      const imageUrl = latestItem[config.imageKey];
      
      if (imageUrl) {
        await updateCardBackground(card, imageUrl);
      }

      const stats = config.statsFormatter(content);
      updateCardStats(card, stats);
    } catch (e) {
      console.error(`Error updating ${cardType} card:`, e);
    }
  }

  async function initAllCards() {
    const promises = Object.keys(CARD_CONFIG).map(cardType => updateCard(cardType));
    await Promise.all(promises);
  }

  function watchForChanges() {
    // No longer watching localStorage - polling via API only
    // Poll for latest content updates from backend
    setInterval(async () => {
      try {
        await initAllCards();
      } catch (e) {
        console.error('Periodic card update error:', e);
      }
    }, 2000);
  }

  return {
    init: async function() {
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', async () => {
          await initAllCards();
          watchForChanges();
        });
      } else {
        await initAllCards();
        watchForChanges();
      }
    },
    updateCard,
    updateAllCards: initAllCards,
  };
})();

// Initialize the system when the script loads
CardUpdateSystem.init();
