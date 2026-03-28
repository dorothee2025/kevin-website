// =================================================================
// Language Translation System
// Shared utility for all pages
// Supported languages: en, rw, fr, lg, lk
// =================================================================

const DEFAULT_LANGUAGE = 'en';

/**
 * Initialize language translation system for the page
 * Should be called after DOM is loaded
 */
function initializeLanguageSystem() {
    const languageSelect = document.getElementById('languageSelect');
    if (languageSelect) {
        languageSelect.addEventListener('change', function() {
            setLanguage(this.value);
        });
        
        // Load saved language preference
        const savedLanguage = localStorage.getItem('cs_language') || DEFAULT_LANGUAGE;
        languageSelect.value = savedLanguage;
        setLanguage(savedLanguage);
    }
}

/**
 * Set the language for all elements with data-{lang} attributes
 * @param {string} lang - Language code (en, rw, fr, lg, lk)
 */
function setLanguage(lang) {
    // Save language preference
    localStorage.setItem('cs_language', lang);
    
    // Update all elements with data attributes
    document.querySelectorAll('[data-en]').forEach(el => {
        const dataAttribute = el.getAttribute(`data-${lang}`);
        if (dataAttribute) {
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.placeholder = dataAttribute;
            } else {
                el.textContent = dataAttribute;
            }
        }
    });
}

/**
 * Get the currently selected language
 * @returns {string} Current language code
 */
function getCurrentLanguage() {
    const languageSelect = document.getElementById('languageSelect');
    return languageSelect ? languageSelect.value : (localStorage.getItem('cs_language') || DEFAULT_LANGUAGE);
}

/**
 * Apply saved language on page load
 */
document.addEventListener('DOMContentLoaded', function() {
    const savedLanguage = localStorage.getItem('cs_language') || DEFAULT_LANGUAGE;
    setLanguage(savedLanguage);
});
