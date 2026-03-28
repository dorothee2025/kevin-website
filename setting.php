<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/cs dream.png" type="image/png">
    <title>CS DREAM website.com - Settings</title>
    <script src="https://cdn.jsdelivr.net/npm/react@18.0.0/umd/react.development.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/react-dom@18.0.0/umd/react-dom.development.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@babel/standalone/babel.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="auth.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .slider::-webkit-slider-thumb {
            appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #3B82F6;
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 0 2px rgba(0,0,0,0.3);
        }

        .slider::-moz-range-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #3B82F6;
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 0 2px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div id="root"></div>

    <script type="text/babel">
        // Toast Notification Component
        const ToastContainer = ({ toasts, removeToast }) => (
            <div className="fixed bottom-6 right-6 z-50 space-y-3">
                {toasts.map((toast, index) => (
                    <div
                        key={index}
                        className={`px-6 py-3 rounded-lg shadow-lg text-white flex items-center gap-3 animate-pulse ${
                            toast.type === 'success' ? 'bg-green-500' : 'bg-red-500'
                        }`}
                    >
                        <i className={`fas ${toast.type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}`}></i>
                        <span>{toast.message}</span>
                        <button onClick={() => removeToast(index)} className="ml-2 text-white hover:opacity-80">
                            <i className="fas fa-times"></i>
                        </button>
                    </div>
                ))}
            </div>
        );

        const ProfileSection = ({ settings, updateSetting }) => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">Profile</h3>
                <p className="text-sm text-gray-500 mb-4">Set your account details</p>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" value={settings.name} onChange={(e) => updateSetting('profile', 'name', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" value={settings.username} onChange={(e) => updateSetting('profile', 'username', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
                    </div>
                </div>

                <div className="mt-4">
                    <label className="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" value={settings.email} onChange={(e) => updateSetting('profile', 'email', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
                </div>
            </div>
        );

        const TimezoneSection = ({ settings, updateSetting }) => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">Timezone & preferences</h3>
                <p className="text-sm text-gray-500 mb-4">Let us know the time zone and format</p>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" value={settings.city} onChange={(e) => updateSetting('timezone', 'city', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                        <select value={settings.timezone} onChange={(e) => updateSetting('timezone', 'timezone', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option>UTC/GMT -12 hours</option>
                            <option>UTC/GMT -11 hours</option>
                            <option>UTC/GMT -10 hours</option>
                            <option>UTC/GMT -9 hours</option>
                            <option>UTC/GMT -8 hours</option>
                            <option>UTC/GMT -7 hours</option>
                            <option>UTC/GMT -6 hours</option>
                            <option>UTC/GMT -5 hours</option>
                            <option>UTC/GMT -4 hours</option>
                            <option>UTC/GMT -3 hours</option>
                            <option>UTC/GMT -2 hours</option>
                            <option>UTC/GMT -1 hours</option>
                            <option>UTC/GMT +0 hours</option>
                            <option>UTC/GMT +1 hours</option>
                            <option>UTC/GMT +2 hours</option>
                            <option>UTC/GMT +3 hours</option>
                            <option>UTC/GMT +4 hours</option>
                            <option>UTC/GMT +5 hours</option>
                            <option>UTC/GMT +6 hours</option>
                            <option>UTC/GMT +7 hours</option>
                            <option>UTC/GMT +8 hours</option>
                            <option>UTC/GMT +9 hours</option>
                            <option>UTC/GMT +10 hours</option>
                            <option>UTC/GMT +11 hours</option>
                            <option>UTC/GMT +12 hours</option>
                        </select>
                    </div>
                </div>

                <div className="mt-4">
                    <label className="block text-sm font-medium text-gray-700 mb-1">Date & Time format</label>
                    <select value={settings.dateTimeFormat} onChange={(e) => updateSetting('timezone', 'dateTimeFormat', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option>dd/mm/yyyy 00:00</option>
                        <option>mm/dd/yyyy 00:00</option>
                        <option>yyyy-mm-dd 00:00</option>
                        <option>dd-mm-yyyy 00:00</option>
                    </select>
                </div>
            </div>
        );

        const MotivationSection = ({ settings, updateSetting }) => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">Motivation & Performance setup</h3>
                <p className="text-sm text-gray-500 mb-4">Calibrate your desired activity levels</p>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <div className="flex justify-between items-center mb-2">
                            <span className="text-sm text-gray-700">Desired daily time utilization:</span>
                            <span className="text-sm font-medium text-gray-900">{settings.dailyTime} hrs</span>
                        </div>
                        <input type="range" min="0" max="24" step="0.5" value={settings.dailyTime} onChange={(e) => updateSetting('motivation', 'dailyTime', parseFloat(e.target.value))} className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider" />
                        <p className="text-xs text-gray-500 mt-2">Find the perfect allocation that suits your workflow and maximizes your potential.</p>
                    </div>

                    <div>
                        <div className="flex justify-between items-center mb-2">
                            <span className="text-sm text-gray-700">Desired daily core work range:</span>
                            <span className="text-sm font-medium text-gray-900">{Math.floor(settings.coreWorkRange)}-{Math.floor(settings.coreWorkRange) + 3} hrs</span>
                        </div>
                        <input type="range" min="0" max="10" step="0.5" value={settings.coreWorkRange} onChange={(e) => updateSetting('motivation', 'coreWorkRange', parseFloat(e.target.value))} className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider" />
                        <p className="text-xs text-gray-500 mt-2">Define the central hours you are dedicated to your most important tasks, ensuring a balanced focus and productivity during peak performance times.</p>
                    </div>
                </div>

                <div className="mt-4">
                    <a href="#" className="text-blue-600 text-sm hover:text-blue-700 transition duration-200">Learn more about work time classification <i className="fas fa-info-circle ml-1"></i></a>
                </div>
            </div>
        );

        const WorkSection = ({ settings, updateSetting }) => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">Your work</h3>
                <p className="text-sm text-gray-500 mb-4">Add info about your position</p>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">Function</label>
                        <input type="text" value={settings.function} onChange={(e) => updateSetting('work', 'function', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                        <input type="text" value={settings.jobTitle} onChange={(e) => updateSetting('work', 'jobTitle', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
                    </div>
                </div>

                <div className="mt-4">
                    <label className="block text-sm font-medium text-gray-700 mb-1">Responsibilities</label>
                    <textarea value={settings.responsibilities} onChange={(e) => updateSetting('work', 'responsibilities', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" rows="3"></textarea>
                </div>
            </div>
        );

        const App = () => {
            const [activeTab, setActiveTab] = React.useState('Account');
            const [toasts, setToasts] = React.useState([]);
            const [loading, setLoading] = React.useState(false);
            const [language, setLanguage] = React.useState(() => localStorage.getItem('appLanguage') || 'en');
            const [profileImage, setProfileImage] = React.useState(() => {
                const saved = localStorage.getItem('profileImageData');
                return saved ? saved : null;
            });
            const session = readSession();
            const user = session ? readUsers().find(u => u.id === session.userId) : null;

            const translations = {
                en: {
                    settings: 'Settings',
                    profile: 'Profile',
                    saveChanges: 'Save Changes',
                    lastLogin: 'Last Login Date',
                    lastPasswordChange: 'Last Password Change',
                    activityLog: 'Activity Log',
                    dangerZone: 'Danger Zone',
                    deleteAccount: 'Delete Account'
                },
                fr: {
                    settings: 'Paramètres',
                    profile: 'Profil',
                    saveChanges: 'Enregistrer les modifications',
                    lastLogin: 'Dernière connexion',
                    lastPasswordChange: 'Dernier changement de mot de passe',
                    activityLog: 'Journal d\'activité',
                    dangerZone: 'Zone de danger',
                    deleteAccount: 'Supprimer le compte'
                }
            };

            const t = (key) => translations[language][key] || key;

            const addToast = (message, type = 'success') => {
                const id = toasts.length;
                setToasts(prev => [...prev, { message, type, id }]);
                setTimeout(() => removeToast(id), 3000);
            };

            const removeToast = (id) => {
                setToasts(prev => prev.filter((_, index) => index !== id));
            };

            const handleProfileImageUpload = (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const imageData = event.target.result;
                        setProfileImage(imageData);
                        localStorage.setItem('profileImageData', imageData);
                        addToast('Profile picture updated successfully!', 'success');
                    };
                    reader.readAsDataURL(file);
                }
            };

            const [settings, setSettings] = React.useState({
                profile: {
                    name: user ? user.fullname || user.username : 'Guest',
                    username: user ? user.username : 'guest',
                    email: user ? user.email : 'guest@example.com'
                },
                timezone: {
                    city: 'New York',
                    timezone: 'UTC/GMT -4 hours',
                    dateTimeFormat: 'dd/mm/yyyy 00:00'
                },
                motivation: {
                    dailyTime: 7,
                    coreWorkRange: 4.5
                },
                work: {
                    function: 'Design',
                    jobTitle: 'Team Lead designer',
                    responsibilities: ''
                },
                notifications: {
                    email: true,
                    push: false,
                    sms: false
                },
                theme: localStorage.getItem('appTheme') || 'light',
                language: 'en',
                password: user ? '********' : '',
                twoFactorAuth: localStorage.getItem('twoFactorAuthEnabled') === 'true'
            });

            const updateSetting = (section, key, value) => {
                if (section === 'theme' || section === 'language') {
                    setSettings(prev => ({
                        ...prev,
                        [section]: value
                    }));
                    if (section === 'theme') {
                        localStorage.setItem('appTheme', value);
                        applyTheme(value);
                    }
                } else if (section === 'twoFactorAuth') {
                    setSettings(prev => ({
                        ...prev,
                        twoFactorAuth: value
                    }));
                    localStorage.setItem('twoFactorAuthEnabled', value);
                } else {
                    setSettings(prev => ({
                        ...prev,
                        [section]: {
                            ...prev[section],
                            [key]: value
                        }
                    }));
                }
            };

            const applyTheme = (theme) => {
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else if (theme === 'light') {
                    document.documentElement.classList.remove('dark');
                } else if (theme === 'auto') {
                    const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    if (isDark) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            };

            React.useEffect(() => {
                applyTheme(settings.theme);
            }, []);

            const saveSettings = () => {
                setLoading(true);
                setTimeout(() => {
                    // Update user data in localStorage
                    if (user) {
                        const users = readUsers();
                        const userIndex = users.findIndex(u => u.id === user.id);
                        if (userIndex !== -1) {
                            users[userIndex].fullname = settings.profile.name;
                            users[userIndex].username = settings.profile.username;
                            users[userIndex].email = settings.profile.email;
                            users[userIndex].lastPasswordChange = localStorage.getItem('lastPasswordChange') || new Date().toISOString();
                            saveUsers(users);
                            saveSession({ userId: user.id, username: settings.profile.username });
                        }
                    }
                    localStorage.setItem('taskPlannerSettings', JSON.stringify(settings));
                    localStorage.setItem('lastLogin', new Date().toISOString());
                    setLoading(false);
                    addToast('Settings saved successfully!', 'success');
                }, 2000);
            };

            const renderContent = () => {
                switch (activeTab) {
                    case 'Account':
                        return (
                            <>
                                <ProfileSection settings={settings.profile} updateSetting={updateSetting} />
                                <TimezoneSection settings={settings.timezone} updateSetting={updateSetting} />
                                <MotivationSection settings={settings.motivation} updateSetting={updateSetting} />
                                <WorkSection settings={settings.work} updateSetting={updateSetting} />
                            </>
                        );
                    case 'Security':
                        return <SecuritySection settings={settings} updateSetting={updateSetting} addToast={addToast} />;
                    case 'Team':
                        return <TeamSection />;
                    case 'Notifications':
                        return <NotificationsSection settings={settings.notifications} updateSetting={updateSetting} />;
                    case 'Sharing':
                        return <SharingSection />;
                    case 'AI Chart Bot':
                        return <AIChartBotSection addToast={addToast} />;
                    case 'Helper':
                        return <HelperSection />;
                    case 'Questions':
                        return <QuestionsSection />;
                    default:
                        return null;
                }
            };

            return (
                <div className="flex h-screen bg-gray-50">
                    <ToastContainer toasts={toasts} removeToast={removeToast} />
                    {/* Left Sidebar */}
                    <div className="w-64 bg-white border-r border-gray-200 flex flex-col">
                        {/* Header */}
                        <div className="p-6 border-b border-gray-200">
                            <h1 className="text-lg font-semibold text-gray-900">{user ? `Welcome, ${user.username}` : 'CS DREAM website.com'}</h1>
                        </div>

                        {/* Company Selection */}
                        <div className="px-6 py-4">
                            <div className="flex items-center space-x-3">
                                <img src="https://placehold.co/32x32/3B82F6/FFFFFF?text=NG" alt="Company logo" className="w-8 h-8 rounded-full" />
                                <div className="flex-1">
                                    <div className="text-sm font-medium text-gray-900">NiceGuys Co.</div>
                                    <i className="fas fa-chevron-down text-gray-400 text-xs mt-1"></i>
                                </div>
                            </div>
                        </div>

                        {/* Navigation */}
                        <nav className="flex-1 px-4">
                            <div className="space-y-1">
                                <a href="home.php" className="flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                    <div className="flex items-center space-x-3">
                                        <i className="fas fa-home w-5"></i>
                                        <span>HOME</span>
                                    </div>
                                </a>
                                <a href="about.php" className="flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                    <div className="flex items-center space-x-3">
                                        <i className="fas fa-info-circle w-5"></i>
                                        <span>About</span>
                                    </div>
                                </a>
                                <a href="coding.php" className="flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                    <div className="flex items-center space-x-3">
                                        <i className="fas fa-code w-5"></i>
                                        <span>Coding</span>
                                    </div>
                                </a>
                                <a href="service.php" className="flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                    <div className="flex items-center space-x-3">
                                        <i className="fas fa-cogs w-5"></i>
                                        <span>Services</span>
                                    </div>
                                </a>
                                <a href="contact.php" className="flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                    <div className="flex items-center space-x-3">
                                        <i className="fas fa-envelope w-5"></i>
                                        <span>CONTACT US</span>
                                    </div>
                                </a>
                                <NavItem icon="fas fa-cog" text="Settings" count="" active={true} />
                                <NavItem icon="fas fa-users" text="Team" count="" active={false} />
                            </div>
                        </nav>

                        {/* User Profile */}
                        <div className="p-4 border-t border-gray-200">
                            <div className="flex items-center space-x-3">
                                <img src={user ? profilePicFor(user.username, 32) : "https://placehold.co/32x32/6B7280/FFFFFF?text=U"} alt="User avatar" className="w-8 h-8 rounded-full" />
                                <div className="flex-1">
                                    <div className="text-sm font-medium text-gray-900">{user ? user.username : 'Guest'}</div>
                                    <div className="flex space-x-2 mt-1">
                                        <button className="text-gray-400 hover:text-gray-600 transition duration-200">
                                            <i className="fas fa-bell"></i>
                                        </button>
                                        <button className="text-gray-400 hover:text-gray-600 transition duration-200">
                                            <i className="fas fa-cog"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Main Content */}
                    <div className="flex-1 flex">
                        <div className="flex-1 overflow-auto">
                            {/* Settings Header */}
                            <div className="p-6 border-b border-gray-200">
                                <div className="flex items-center gap-2">
                                    <h2 className="text-2xl font-semibold text-gray-900">{t('settings')}</h2>
                                    <div className="group relative">
                                        <button className="text-gray-400 hover:text-gray-600 transition">
                                            <i className="fas fa-question-circle"></i>
                                        </button>
                                        <div className="absolute hidden group-hover:block bg-gray-800 text-white text-xs rounded py-2 px-3 whitespace-nowrap bottom-full left-0 mb-2 z-50">
                                            Manage your account settings, security, and preferences
                                        </div>
                                    </div>
                                </div>
                                <p className="text-sm text-gray-500 mt-1">Manage your account settings and preferences</p>
                            </div>

                            {/* Tabs */}
                            <div className="px-6 border-b border-gray-200">
                                <div className="flex space-x-8">
                                    <TabItem text="Account" active={activeTab === 'Account'} onClick={() => setActiveTab('Account')} />
                                    <TabItem text="Security" active={activeTab === 'Security'} onClick={() => setActiveTab('Security')} />
                                    <TabItem text="Team" active={activeTab === 'Team'} onClick={() => setActiveTab('Team')} />
                                    <TabItem text="Notifications" active={activeTab === 'Notifications'} onClick={() => setActiveTab('Notifications')} />
                                    <TabItem text="Sharing" active={activeTab === 'Sharing'} onClick={() => setActiveTab('Sharing')} />
                                    <TabItem text="AI Chart Bot" active={activeTab === 'AI Chart Bot'} onClick={() => setActiveTab('AI Chart Bot')} />
                                    <TabItem text="Helper" active={activeTab === 'Helper'} onClick={() => setActiveTab('Helper')} />
                                    <TabItem text="Questions" active={activeTab === 'Questions'} onClick={() => setActiveTab('Questions')} />
                                </div>
                            </div>

                            {/* Settings Content */}
                            <div className="p-6">
                                {renderContent()}
                                {activeTab === 'Account' && (
                                    <>
                                        <ActivityLogSection />
                                        <div className="bg-white shadow rounded-lg p-6 mb-6">
                                            <h3 className="text-lg font-medium text-gray-900 mb-1">Appearance</h3>
                                            <p className="text-sm text-gray-500 mb-4">Customize the look and feel</p>

                                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label className="block text-sm font-medium text-gray-700 mb-1">Theme</label>
                                                    <select value={settings.theme} onChange={(e) => updateSetting('theme', 'theme', e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                        <option value="light">Light</option>
                                                        <option value="dark">Dark</option>
                                                        <option value="auto">Auto</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label className="block text-sm font-medium text-gray-700 mb-1">Language</label>
                                                    <select value={language} onChange={(e) => {
                                                        setLanguage(e.target.value);
                                                        localStorage.setItem('appLanguage', e.target.value);
                                                    }} className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                        <option value="en">English</option>
                                                        <option value="fr">Français</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div className="bg-white shadow rounded-lg p-6 mb-6">
                                            <h3 className="text-lg font-medium text-gray-900 mb-1">Privacy</h3>
                                            <p className="text-sm text-gray-500 mb-4">Manage your privacy settings</p>

                                            <div className="space-y-4">
                                                <div className="flex items-center justify-between">
                                                    <div>
                                                        <h4 className="text-sm font-medium text-gray-900">Profile visibility</h4>
                                                        <p className="text-sm text-gray-500">Make your profile visible to others</p>
                                                    </div>
                                                    <label className="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" defaultChecked className="sr-only peer" />
                                                        <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                                    </label>
                                                </div>

                                                <div className="flex items-center justify-between">
                                                    <div>
                                                        <h4 className="text-sm font-medium text-gray-900">Data sharing</h4>
                                                        <p className="text-sm text-gray-500">Allow sharing of anonymized data for improvements</p>
                                                    </div>
                                                    <label className="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" defaultChecked className="sr-only peer" />
                                                        <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </>
                                )}
                                <div className="mt-8 flex justify-end">
                                    <button onClick={saveSettings} disabled={loading} className={`px-6 py-2 text-white rounded-md transition duration-200 flex items-center gap-2 ${loading ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'}`}>
                                        {loading && <i className="fas fa-spinner animate-spin"></i>}
                                        {loading ? 'Saving...' : t('saveChanges')}
                                    </button>
                                </div>
                            </div>
                        </div>

                        {/* Right Sidebar - Profile Photo */}
                        <div className="w-80 bg-white border-l border-gray-200 p-6">
                            <div className="flex flex-col items-center">
                                <div className="relative">
                                    <div className="absolute inset-0 bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-500 rounded-full animate-spin" style={{animationDuration: '3s'}}></div>
                                    <img src={profileImage || (user ? profilePicFor(user.username) : "https://placehold.co/120x120/6B7280/FFFFFF?text=U")} alt="Profile photo" className="w-30 h-30 rounded-full relative z-10 border-4 border-white" />
                                    <input type="file" id="profileImageInput" accept="image/*" onChange={handleProfileImageUpload} className="hidden" />
                                    <button onClick={() => document.getElementById('profileImageInput').click()} className="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-md hover:shadow-lg transition duration-200 z-20">
                                        <i className="fas fa-camera text-gray-600"></i>
                                    </button>
                                </div>
                                <div className="mt-4 text-sm text-gray-900 font-medium">{user ? user.username : 'Guest'}</div>
                            </div>
                        </div>
                    </div>
                </div>
            );
        };

        const NavItem = ({ icon, text, count, active }) => {
            return (
                <a href="#" className={`flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition duration-200 ${active ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'}`}>
                    <div className="flex items-center space-x-3">
                        <i className={`${icon} w-5`}></i>
                        <span>{text}</span>
                    </div>
                    {count && (
                        <span className="inline-flex items-center justify-center px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                            {count}
                        </span>
                    )}
                </a>
            );
        };

        const TabItem = ({ text, active, onClick }) => {
            return (
                <button onClick={onClick} className={`px-1 py-4 text-sm font-medium border-b-2 transition duration-200 ${active ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}`}>
                    {text}
                </button>
            );
        };

        const NotificationsSection = ({ settings, updateSetting }) => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">Notifications</h3>
                <p className="text-sm text-gray-500 mb-4">Choose how you want to be notified</p>

                <div className="space-y-4">
                    <div className="flex items-center justify-between">
                        <div>
                            <h4 className="text-sm font-medium text-gray-900">Email notifications</h4>
                            <p className="text-sm text-gray-500">Receive notifications via email</p>
                        </div>
                        <label className="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked={settings.email} onChange={(e) => updateSetting('notifications', 'email', e.target.checked)} className="sr-only peer" />
                            <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div className="flex items-center justify-between">
                        <div>
                            <h4 className="text-sm font-medium text-gray-900">Push notifications</h4>
                            <p className="text-sm text-gray-500">Receive push notifications on your device</p>
                        </div>
                        <label className="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked={settings.push} onChange={(e) => updateSetting('notifications', 'push', e.target.checked)} className="sr-only peer" />
                            <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div className="flex items-center justify-between">
                        <div>
                            <h4 className="text-sm font-medium text-gray-900">SMS notifications</h4>
                            <p className="text-sm text-gray-500">Receive notifications via SMS</p>
                        </div>
                        <label className="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked={settings.sms} onChange={(e) => updateSetting('notifications', 'sms', e.target.checked)} className="sr-only peer" />
                            <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        );

        const SharingSection = () => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">Sharing</h3>
                <p className="text-sm text-gray-500 mb-4">Manage your sharing preferences</p>
                <p className="text-gray-600">Sharing settings coming soon...</p>
            </div>
        );

        const AIChartBotSection = ({ addToast }) => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">AI Chart Bot</h3>
                <p className="text-sm text-gray-500 mb-4">Connect to our AI-powered chart generation tool</p>

                <div className="space-y-4">
                    <p className="text-gray-600">The AI Chart Bot is powered by our Python script (ChatAI.py) that provides intelligent chart creation and data visualization capabilities.</p>

                    <div className="bg-blue-50 p-4 rounded-lg">
                        <h4 className="text-sm font-semibold text-blue-900 mb-2">Features:</h4>
                        <ul className="text-sm text-blue-800 space-y-1">
                            <li>• Automated chart generation from data</li>
                            <li>• AI-powered insights and recommendations</li>
                            <li>• Multiple chart types and customization</li>
                            <li>• Real-time data processing</li>
                        </ul>
                    </div>

                    <div className="flex space-x-4">
                        <button onClick={() => window.open('ChatAI.py', '_blank')} className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                            Launch AI Chart Bot
                        </button>
                        <a href="ChatAI.py" download className="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-200">
                            Download Script
                        </a>
                    </div>

                    <p className="text-xs text-gray-500">Note: The AI Chart Bot requires Python environment to run. Click "Launch" to open the script or "Download" to save it locally.</p>
                </div>
            </div>
        );

        const HelperSection = () => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">Helper</h3>
                <p className="text-sm text-gray-500 mb-4">Manage your helper tools</p>
                <p className="text-gray-600">Helper settings coming soon...</p>
            </div>
        );

        const TeamSection = () => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">Our Team</h3>
                <p className="text-sm text-gray-500 mb-4">Meet the talented individuals behind CS DREAM website</p>

                <div className="space-y-6">
                    <div className="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                        <img src="https://via.placeholder.com/60/3B82F6/FFFFFF?text=UP" alt="Umukundwa Penuel Price" className="w-15 h-15 rounded-full" />
                        <div>
                            <h4 className="text-md font-semibold text-gray-900">Umukundwa Penuel Price</h4>
                            <p className="text-sm text-gray-600">Lead Developer & Project Manager</p>
                            <p className="text-sm text-gray-500 mt-1">2 years of coding experience</p>
                            <p className="text-sm text-green-600 font-medium">Certified Developer</p>
                            <p className="text-xs text-gray-400 mt-2">Specializes in full-stack development, UI/UX design, and team coordination. Passionate about creating innovative web solutions.</p>
                        </div>
                    </div>

                    <div className="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                        <img src="https://via.placeholder.com/60/10B981/FFFFFF?text=KT" alt="Kami Trevor" className="w-15 h-15 rounded-full" />
                        <div>
                            <h4 className="text-md font-semibold text-gray-900">Kami Trevor</h4>
                            <p className="text-sm text-gray-600">Backend Developer</p>
                            <p className="text-sm text-gray-500 mt-1">2 years of coding experience</p>
                            <p className="text-xs text-gray-400 mt-2">Expert in server-side technologies, database management, and API development. Focuses on building robust and scalable systems.</p>
                        </div>
                    </div>

                    <div className="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                        <img src="https://via.placeholder.com/60/F59E0B/FFFFFF?text=NP" alt="Ndikumana Pie" className="w-15 h-15 rounded-full" />
                        <div>
                            <h4 className="text-md font-semibold text-gray-900">Ndikumana Pie</h4>
                            <p className="text-sm text-gray-600">Frontend Developer</p>
                            <p className="text-sm text-gray-500 mt-1">1.5 years of coding experience</p>
                            <p className="text-sm text-green-600 font-medium">Certified Developer</p>
                            <p className="text-xs text-gray-400 mt-2">Specializes in modern frontend frameworks, responsive design, and user experience optimization. Loves creating beautiful interfaces.</p>
                        </div>
                    </div>

                    <div className="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                        <img src="https://via.placeholder.com/60/EF4444/FFFFFF?text=KB" alt="Kwizera Benny" className="w-15 h-15 rounded-full" />
                        <div>
                            <h4 className="text-md font-semibold text-gray-900">Kwizera Benny</h4>
                            <p className="text-sm text-gray-600">Full-Stack Developer & QA Tester</p>
                            <p className="text-sm text-gray-500 mt-1">3 years of coding experience</p>
                            <p className="text-sm text-green-600 font-medium">Certified Developer</p>
                            <p className="text-xs text-gray-400 mt-2">Experienced in both frontend and backend development with extensive testing expertise. Ensures high-quality, bug-free applications.</p>
                        </div>
                    </div>
                </div>

                <div className="mt-6 p-4 bg-blue-50 rounded-lg">
                    <h4 className="text-md font-semibold text-blue-900 mb-2">About CS DREAM</h4>
                    <p className="text-sm text-blue-700">CS DREAM is a collaborative project created by passionate developers committed to advancing technology education and providing valuable resources for coding enthusiasts worldwide.</p>
                </div>
            </div>
        );

        const SecuritySection = ({ settings, updateSetting, addToast }) => {
            const [showPassword, setShowPassword] = React.useState(false);
            const [changePassword, setChangePassword] = React.useState('');
            const [confirmPassword, setConfirmPassword] = React.useState('');
            const [verificationCode, setVerificationCode] = React.useState('');
            const [step, setStep] = React.useState(1); // 1: show password, 2: verify, 3: change
            const [twoFactorEnabled, setTwoFactorEnabled] = React.useState(settings.twoFactorAuth);

            const handleChangePassword = () => {
                if (step === 1) {
                    addToast('To change your password, you must wait 60 days or use the Forgot Password feature on the login page.', 'error');
                } else if (step === 2) {
                    if (verificationCode === '123456') { // dummy code
                        setStep(3);
                    } else {
                        addToast('Invalid verification code.', 'error');
                    }
                } else if (step === 3) {
                    if (changePassword.length < 8) {
                        addToast('Password must be at least 8 characters.', 'error');
                    } else if (changePassword !== confirmPassword) {
                        addToast('Passwords do not match.', 'error');
                    } else {
                        (async () => {
                            const hashed = await hashPassword(changePassword);
                            const users = readUsers();
                            const userIndex = users.findIndex(u => u.id === user.id);
                            if (userIndex !== -1) {
                                users[userIndex].password = hashed;
                                saveUsers(users);
                                localStorage.setItem('lastPasswordChange', new Date().toISOString());
                                addToast('Password changed successfully!', 'success');
                                setStep(1);
                                setChangePassword('');
                                setConfirmPassword('');
                                setVerificationCode('');
                            } else {
                                addToast('Error updating password.', 'error');
                            }
                        })();
                    }
                }
            };

            return (
                <>
                    <div className="bg-white shadow rounded-lg p-6 mb-6">
                        <h3 className="text-lg font-medium text-gray-900 mb-1">Security</h3>
                        <p className="text-sm text-gray-500 mb-4">Manage your account security</p>

                        <div className="space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <div className="relative">
                                    <input type={showPassword ? "text" : "password"} value={settings.password} readOnly className="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" />
                                    <button type="button" onClick={() => setShowPassword(!showPassword)} className="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i className={`fas ${showPassword ? 'fa-eye-slash' : 'fa-eye'} text-gray-400`}></i>
                                    </button>
                                </div>
                            </div>

                            {step === 1 && (
                                <button onClick={() => setStep(2)} className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Change Password
                                </button>
                            )}

                            {step === 2 && (
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Verification Code</label>
                                    <input type="text" value={verificationCode} onChange={(e) => setVerificationCode(e.target.value)} placeholder="Enter verification code" className="w-full px-3 py-2 border border-gray-300 rounded-md" />
                                    <button onClick={handleChangePassword} className="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        Verify
                                    </button>
                                </div>
                            )}

                            {step === 3 && (
                                <div className="space-y-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                        <input type="password" value={changePassword} onChange={(e) => setChangePassword(e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md" />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                        <input type="password" value={confirmPassword} onChange={(e) => setConfirmPassword(e.target.value)} className="w-full px-3 py-2 border border-gray-300 rounded-md" />
                                    </div>
                                    <button onClick={handleChangePassword} className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        Update Password
                                    </button>
                                </div>
                            )}
                        </div>
                    </div>

                    <div className="bg-white shadow rounded-lg p-6 mb-6">
                        <h3 className="text-lg font-medium text-gray-900 mb-4">Two-Factor Authentication</h3>
                        <div className="flex items-center justify-between">
                            <div>
                                <h4 className="text-sm font-medium text-gray-900">Enable 2FA</h4>
                                <p className="text-sm text-gray-500">Add an extra layer of security to your account</p>
                            </div>
                            <label className="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked={twoFactorEnabled} onChange={(e) => {
                                    setTwoFactorEnabled(e.target.checked);
                                    updateSetting('twoFactorAuth', 'enabled', e.target.checked);
                                }} className="sr-only peer" />
                                <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div className="bg-white border-4 border-red-300 rounded-lg p-6 mb-6">
                        <div className="flex items-start gap-4">
                            <i className="fas fa-exclamation-triangle text-red-600 text-2xl mt-1"></i>
                            <div className="flex-1">
                                <h4 className="text-lg font-bold text-red-600 mb-2">Danger Zone</h4>
                                <p className="text-sm text-gray-600 mb-4">Permanently delete your account and all associated data.</p>
                                <button onClick={() => {
                                    if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                                        const users = readUsers();
                                        const userIndex = users.findIndex(u => u.id === user.id);
                                        if (userIndex !== -1) {
                                            users.splice(userIndex, 1);
                                            saveUsers(users);
                                            clearSession();
                                            addToast('Account deleted successfully.', 'success');
                                            window.location.href = 'home.php';
                                        }
                                    }
                                }} className="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                                    Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </>
            );
        };

        const ActivityLogSection = () => {
            const lastLogin = localStorage.getItem('lastLogin');
            const lastPasswordChange = localStorage.getItem('lastPasswordChange');

            const formatDate = (dateString) => {
                if (!dateString) return 'Never';
                const date = new Date(dateString);
                return date.toLocaleString();
            };

            return (
                <div className="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Activity Log</h3>
                    <div className="space-y-4">
                        <div className="flex items-center justify-between pb-4 border-b border-gray-200">
                            <div>
                                <h4 className="text-sm font-medium text-gray-900">Last Login</h4>
                                <p className="text-sm text-gray-500">{formatDate(lastLogin)}</p>
                            </div>
                            <i className="fas fa-sign-in-alt text-blue-500"></i>
                        </div>
                        <div className="flex items-center justify-between">
                            <div>
                                <h4 className="text-sm font-medium text-gray-900">Last Password Change</h4>
                                <p className="text-sm text-gray-500">{formatDate(lastPasswordChange)}</p>
                            </div>
                            <i className="fas fa-lock text-green-500"></i>
                        </div>
                    </div>
                </div>
            );
        };

        const QuestionsSection = () => (
            <div className="bg-white shadow rounded-lg p-6 mb-6">
                <h3 className="text-lg font-medium text-gray-900 mb-1">Questions</h3>
                <p className="text-sm text-gray-500 mb-4">Frequently asked questions</p>
                <p className="text-gray-600">FAQ section coming soon...</p>
            </div>
        );

        ReactDOM.render(<App />, document.getElementById('root'));
    </script>
    <script>
        // Global Keyboard Shortcuts
        (function(){
            document.addEventListener('keydown', (e) => {
                // Ctrl+K or / to focus search (if available)
                if ((e.ctrlKey && e.key === 'k') || e.key === '/') {
                    e.preventDefault();
                    const searchInput = document.getElementById('searchInput');
                    if (searchInput) { searchInput.focus(); searchInput.select(); }
                }
                // Ctrl+Shift+D to toggle dark mode (if available)
                if (e.ctrlKey && e.shiftKey && e.key === 'D') {
                    e.preventDefault();
                    const modeToggle = document.getElementById('ModeToggle');
                    if (modeToggle) { modeToggle.click(); }
                }
                // Alt+H to go home
                if (e.altKey && e.key === 'h') {
                    e.preventDefault();
                    window.location.href = 'home.php';
                }

                // History navigation: '<' => back, '>' => forward
                // Skip when user is typing in an input/textarea or contenteditable
                const active = document.activeElement;
                const isTyping = active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA' || active.isContentEditable);
                if (!isTyping) {
                    if (e.key === '<') {
                        e.preventDefault();
                        window.history.back();
                    }
                    if (e.key === '>') {
                        e.preventDefault();
                        window.history.forward();
                    }
                }
            });
        })();
        // Navigation hint (dismissible)
        (function(){
            try { if (localStorage.getItem('historyHintDismissed')) return; } catch(e) {}
            const hint = document.createElement('div');
            hint.className = 'fixed bottom-4 left-4 bg-gray-900 text-white px-4 py-2 rounded shadow z-50';
            hint.style.opacity = '0';
            hint.style.transition = 'opacity 200ms ease';
            hint.innerHTML = `<span>Press '<' to go back, '>' to go forward</span>`;
            const btn = document.createElement('button');
            btn.className = 'ml-3 bg-gray-700 px-2 py-1 rounded text-sm';
            btn.innerText = 'Got it';
            btn.addEventListener('click', () => { try{ localStorage.setItem('historyHintDismissed','1'); }catch(e){}; hint.remove(); });
            hint.appendChild(btn);
            document.addEventListener('DOMContentLoaded', () => { document.body.appendChild(hint); setTimeout(()=> hint.style.opacity='1', 120); });
            if (document.readyState === 'complete' || document.readyState === 'interactive') { document.body.appendChild(hint); setTimeout(()=> hint.style.opacity='1', 120); }
        })();
    </script>
    <style>
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #3B82F6, #06b6d4);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            box-shadow: 0 8px 30px rgba(59, 130, 246, 0.4);
            z-index: 999;
            transition: all 0.3s ease;
        }
        #backToTop:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(59, 130, 246, 0.6);
        }
        #backToTop.show {
            display: flex;
        }
        @media (max-width: 768px) {
            #backToTop {
                width: 45px;
                height: 45px;
                bottom: 20px;
                right: 20px;
                font-size: 20px;
            }
        }
    </style>
    <button id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <script>
        (function(){
            const backToTopBtn = document.getElementById('backToTop');
            
            const scrollToTop = () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            };
            
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            });
            
            backToTopBtn.addEventListener('click', scrollToTop);
            
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Home') {
                    e.preventDefault();
                    scrollToTop();
                }
            });
        })();
    </script>
<script src="clock.js" defer></script>
</body>
</html>
