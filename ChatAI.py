import sys
try:
    from flask import Flask, request, jsonify
    from flask_cors import CORS
except ModuleNotFoundError as e:
    missing = e.name if hasattr(e, 'name') else str(e)
    print(f"Missing Python package: {missing}\nInstall dependencies with:\n    python -m pip install -r requirements.txt")
    sys.exit(1)
import json
import time
import re
from pathlib import Path
from datetime import datetime

APP_DIR = Path(__file__).parent
TEMPLATES_FILE = APP_DIR / 'faq_templates.json'
HISTORY_FILE = APP_DIR / 'chat_history.json'

app = Flask(__name__)
CORS(app)


def load_templates():
    if not TEMPLATES_FILE.exists():
        return []
    with open(TEMPLATES_FILE, 'r', encoding='utf-8') as f:
        return json.load(f)


def log_history(entry):
    try:
        hist = []
        if HISTORY_FILE.exists():
            with open(HISTORY_FILE, 'r', encoding='utf-8') as hf:
                hist = json.load(hf)
        hist.append(entry)
        with open(HISTORY_FILE, 'w', encoding='utf-8') as hf:
            json.dump(hist, hf, ensure_ascii=False, indent=2)
    except Exception:
        pass


def detect_language(message):
    """Simple language detection based on common words and patterns"""
    m = message.lower()

    # Kinyarwanda indicators
    kinyarwanda_words = ['murakaza', 'neza', 'kuri', 'ni', 'uyu', 'umunsi', 'amashuri', 'kwandika', 'ubuhanga']
    if any(word in m for word in kinyarwanda_words):
        return 'rw'

    # French indicators
    french_words = ['bonjour', 'comment', 'ça va', 'merci', 's\'il vous plaît', 'aide', 'connexion']
    if any(word in m for word in french_words):
        return 'fr'

    # Luganda indicators
    luganda_words = ['olusoga', 'oli otya', 'webale', 'nsaba', 'okuyigga', 'okwandika']
    if any(word in m for word in luganda_words):
        return 'lg'

    # Default to English
    return 'en'

def simple_match(message, templates, lang='en'):
    """Enhanced matching with language support"""
    m = (message or '').lower()

    # First try exact keyword matching
    for t in templates:
        kws = t.get('keywords', {}).get(lang, t.get('keywords', {}).get('en', []))
        for kw in kws:
            if kw.lower() in m:
                return t, lang

    # Try title matching
    for t in templates:
        title = t.get('title', {}).get(lang, t.get('title', {}).get('en', ''))
        if title and title.lower() in m:
            return t, lang

    # Try cross-language matching if no match found
    for t in templates:
        for lang_code, keywords in t.get('keywords', {}).items():
            for kw in keywords:
                if kw.lower() in m:
                    return t, lang_code

    return None, lang

def get_response_text(template, lang):
    """Get response text in the appropriate language"""
    if isinstance(template.get('answer'), dict):
        return template['answer'].get(lang, template['answer'].get('en', 'I apologize, but I don\'t have a response in your language yet.'))

    return template.get('answer', 'I apologize, but I don\'t have a response for this query.')

def get_next_options(template, lang):
    """Get next options in the appropriate language"""
    if isinstance(template.get('next_options'), dict):
        return template['next_options'].get(lang, template['next_options'].get('en', []))

    return template.get('next_options', [])


@app.route('/api/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'timestamp': datetime.now().isoformat(),
        'version': '2.0',
        'languages': ['en', 'rw', 'fr', 'lg'],
        'features': ['multilingual', 'faq', 'intelligent_matching']
    })

@app.route('/api/stats', methods=['GET'])
def get_stats():
    """Get chat statistics"""
    try:
        if HISTORY_FILE.exists():
            with open(HISTORY_FILE, 'r', encoding='utf-8') as f:
                history = json.load(f)
        else:
            history = []

        total_chats = len(history)
        languages = {}
        recent_chats = history[-10:] if history else []

        for entry in history:
            lang = entry.get('detected_language', 'unknown')
            languages[lang] = languages.get(lang, 0) + 1

        return jsonify({
            'total_chats': total_chats,
            'language_distribution': languages,
            'recent_activity': recent_chats
        })
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/api/chat', methods=['POST'])
def chat_api():
    data = request.get_json(force=True, silent=True) or {}
    msg = data.get('message','')

    # basic input validation
    if not isinstance(msg, str) or not msg.strip():
        return jsonify({'error':'empty message'}), 400
    if len(msg) > 2000:
        return jsonify({'error':'message too long'}), 400

    # sanitise (remove control chars)
    sanitized = ''.join(ch for ch in msg if ord(ch) >= 32)

    # Detect language
    detected_lang = detect_language(sanitized)

    templates = load_templates()
    matched, response_lang = simple_match(sanitized, templates, detected_lang)

    if matched:
        answer = get_response_text(matched, response_lang)
        options = get_next_options(matched, response_lang)
    else:
        # Enhanced fallback logic with multilingual support
        answer, options = get_fallback_response(sanitized, detected_lang)

    resp = {'answer': answer, 'next_options': options, 'language': response_lang}

    # log
    try:
        log_history({
            'timestamp': time.time(),
            'message': sanitized,
            'detected_language': detected_lang,
            'response_language': response_lang,
            'response': resp
        })
    except Exception:
        pass

    return jsonify(resp)

def get_fallback_response(message, lang):
    """Enhanced fallback responses with multilingual support and intelligent pattern matching"""
    lw = message.lower()

    # Multilingual responses
    responses = {
        'en': {
            'logout': 'To logout: click the profile avatar at the top right, open the menu and choose "Logout".',
            'password': 'To change your password: go to Settings → Security → Change Password. Choose a strong password and save.',
            'signup': 'To sign up: click Sign Up in the header, fill out the form and submit. Password must be at least 8 characters.',
            'help': 'I can help you with: login/logout, password changes, navigation, content, and general questions about CS DREAM.',
            'navigation': 'Use the navigation menu: Home, About, Services, Contact. Check the sidebar for quick links and trending content.',
            'content': 'Browse our categories: Sport videos, Hack tricks tutorials, Coding lessons, School news, and Entertainment.',
            'contact': 'Contact us via WhatsApp: +250 795 647 344 or email: irumvakevin@19gmail.com',
            'default': 'I\'m here to help! Try asking about: login, signup, password, navigation, content, or contact information.'
        },
        'rw': {
            'logout': 'Kugira usoze: kanda avatar ya profayili hejuru iburyo, fungura menu uhitemo "Logout".',
            'password': 'Kugira uhindure ijambo ry\'ibanga: jya muri Settings → Security → Change Password. Hitamo ijambo ry\'ibanga rikomeye ubike.',
            'signup': 'Kugira wandikishe: kanda "Sign Up" mu mutwe, uzuze form ubyohereze. Ijambo ry\'ibanga rigomba kuba byibura inyuguti 8.',
            'help': 'Nshobora kukufasha: kwinjira/gusohoka, guhindura ijambo ry\'ibanga, kuyobora, ibikubiye, n\'ibibazo rusange kuri CS DREAM.',
            'navigation': 'Koresha menu yo kuyobora: Home, About, Services, Contact. Reba sidebar kugira ubone amakuru yihuse n\'ibikubiye bikunzwe.',
            'content': 'Rondera amatsinda yacu: Videwo za Sport, Amasomo ya Hack tricks, Amasomo yo gukora kode, Amakuru y\'amashuri, n\'Ibiterane.',
            'contact': 'Twandikire kuri WhatsApp: +250 795 647 344 cyangwa email: irumvakevin@19gmail.com',
            'default': 'Ndahari kukufasha! Gerageza kubaza: kwinjira, kwiyandikisha, ijambo ry\'ibanga, kuyobora, ibikubiye, cyangwa amakuru yo guhamagara.'
        },
        'fr': {
            'logout': 'Pour vous déconnecter: cliquez sur l\'avatar de profil en haut à droite, ouvrez le menu et choisissez "Logout".',
            'password': 'Pour changer votre mot de passe: allez dans Settings → Security → Change Password. Choisissez un mot de passe fort et sauvegardez.',
            'signup': 'Pour vous inscrire: cliquez sur "Sign Up" dans l\'en-tête, remplissez le formulaire et soumettez. Le mot de passe doit contenir au moins 8 caractères.',
            'help': 'Je peux vous aider avec: connexion/déconnexion, changement de mot de passe, navigation, contenu, et questions générales sur CS DREAM.',
            'navigation': 'Utilisez le menu de navigation: Home, About, Services, Contact. Vérifiez la barre latérale pour les liens rapides et le contenu tendance.',
            'content': 'Parcourez nos catégories: vidéos sportives, tutoriels de piratage, leçons de codage, actualités scolaires et divertissement.',
            'contact': 'Contactez-nous via WhatsApp: +250 795 647 344 ou email: irumvakevin@19gmail.com',
            'default': 'Je suis là pour aider! Essayez de demander: connexion, inscription, mot de passe, navigation, contenu ou informations de contact.'
        },
        'lg': {
            'logout': 'Okusobola okufuluma: nyiga avatar eya profile waggulu w\'eddali, ggula menu olonde "Logout".',
            'password': 'Okukyusa password: genda mu Settings → Security → Change Password. Londa password ey\'omunda obike.',
            'signup': 'Okusobola okuweereza: nyiga "Sign Up" mu header, jjuza form osobole. Password erina okuba na ennukuta 8 obutakka.',
            'help': 'Nsobola kukuyamba: okuyingira/okufufuluma, okukyusa password, navigation, content, n\'ebibuzo ebitali bimu ku CS DREAM.',
            'navigation': 'Kozesa menu eya navigation: Home, About, Services, Contact. Kebera sidebar ku links ez\'amangu n\'content ezikula.',
            'content': 'Noonya ku categories zaffe: videos za sport, tutorials za hack tricks, lessons za coding, news za school, n\'entertainment.',
            'contact': 'Tulangako ku WhatsApp: +250 795 647 344 oba email: irumvakevin@19gmail.com',
            'default': 'Ndi wano okuyamba! Geza okubuuza: kuyingira, kuyeereza, password, navigation, content oba information eya contact.'
        }
    }

    # Get responses for detected language, fallback to English
    lang_responses = responses.get(lang, responses['en'])

    # Pattern matching for different types of queries
    patterns = {
        'logout': ['logout', 'log out', 'sign out', 'sohoka', 'fuluma', 'déconnecter', 'fufuluma'],
        'password': ['password', 'change password', 'ijambo', 'mot de passe', 'kyusa'],
        'signup': ['signup', 'sign up', 'register', 'iyandikishe', 'inscription', 'weereza'],
        'help': ['help', 'aide', 'fasha', 'yamba', 'saad', 'aid'],
        'navigation': ['navigation', 'menu', 'how to navigate', 'kuyobora', 'naviguer', 'okutambula'],
        'content': ['content', 'videos', 'what\'s available', 'ibikubiye', 'contenu', 'ekiri'],
        'contact': ['contact', 'reach', 'hamagara', 'contacter', 'langako']
    }

    for response_type, keywords in patterns.items():
        if any(keyword in lw for keyword in keywords):
            next_options = {
                'logout': ['How to change password?', 'How to login?'],
                'password': ['How to logout?', 'How to reset password?'],
                'signup': ['How to login?', 'How to change password?'],
                'help': ['How to login?', 'What content is available?'],
                'navigation': ['How to search?', 'What content is available?'],
                'content': ['How to download videos?', 'How to watch videos?'],
                'contact': ['How to login?', 'What is CS DREAM?']
            }
            return lang_responses[response_type], next_options.get(response_type, [])

    # Greeting patterns
    greetings = ['hello', 'hi', 'hey', 'muraho', 'bonjour', 'olusoga', 'mwaramutse']
    if any(greeting in lw for greeting in greetings):
        greeting_responses = {
            'en': 'Hello! Welcome to CS DREAM. How can I help you today?',
            'rw': 'Muraho! Murakaza neza kuri CS DREAM. Nshobora kukufasha iki?',
            'fr': 'Bonjour! Bienvenue sur CS DREAM. Comment puis-je vous aider?',
            'lg': 'Olusoga! Tukusanyire ku CS DREAM. Nsobola kukuyamba ki?'
        }
        return greeting_responses.get(lang, greeting_responses['en']), ['What content is available?', 'How to login?']

    # Default response
    return lang_responses['default'], ['How to login?', 'How to change password?', 'What is CS DREAM?']


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=False)

