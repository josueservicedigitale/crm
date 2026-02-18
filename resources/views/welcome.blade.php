<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVESTCALORIS • Gestion documentaire intelligente</title>
    
    <!-- Tailwind CSS avec configuration personnalisée -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f5ff',
                            100: '#e5efff',
                            200: '#cddfff',
                            300: '#b4cfff',
                            400: '#8cb0ff',
                            500: '#5c7cff',
                            600: '#3b5bdb',
                            700: '#2f4bb7',
                            800: '#253b93',
                            900: '#1a2b6f',
                        },
                        invest: {
                            50: '#fff9e6',
                            100: '#fff2cc',
                            200: '#ffe599',
                            300: '#ffd966',
                            400: '#ffcc33',
                            500: '#ffb700',
                            600: '#cc9200',
                            700: '#996e00',
                            800: '#664900',
                            900: '#332500',
                        }
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'slide-down': 'slideDown 0.6s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'gradient': 'gradient 8s ease infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        gradient: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' },
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts Inter et Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, #f6f8fc 0%, #f0f4fa 50%, #e8eff7 100%);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 91, 219, 0.1);
        }
        
        /* Gradient animations */
        .gradient-bg {
            background: linear-gradient(-45deg, #1a2b6f, #2f4bb7, #3b5bdb, #5c7cff);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        .invest-gradient {
            background: linear-gradient(135deg, #ffb700 0%, #ffcc33 50%, #ffe599 100%);
        }
        
        /* Card hover effects */
        .card-3d {
            transition: all 0.3s ease;
            transform-style: preserve-3d;
            perspective: 1000px;
        }
        
        .card-3d:hover {
            transform: rotateX(2deg) rotateY(2deg) translateY(-10px);
            box-shadow: 20px 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Shine effect */
        .shine {
            position: relative;
            overflow: hidden;
        }
        
        .shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.1) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            transition: transform 0.6s ease;
        }
        
        .shine:hover::after {
            transform: rotate(30deg) translate(50%, 50%);
        }
        
        /* Navbar link animation */
        .nav-link {
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: linear-gradient(90deg, #ffb700, #5c7cff);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Floating animation */
        .float {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Counter animation */
        .counter {
            transition: all 0.3s ease;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3b5bdb, #ffb700);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #2f4bb7, #cc9200);
        }
    </style>
</head>
<body class="antialiased">

    <!-- ==================== -->
    <!-- NAVIGATION ÉLÉGANTE -->
    <!-- ==================== -->
    <nav class="fixed w-full z-50 transition-all duration-500" id="navbar">
        <div class="container mx-auto px-6 py-4">
            <div class="glass rounded-2xl px-6 py-3 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-600 to-invest-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-invoice-dollar text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-primary-700 to-invest-600 bg-clip-text text-transparent">
                            360<span class="text-invest-500">INVEST</span>
                        </h1>
                        <p class="text-xs text-primary-500 font-medium">by INVESTCALORIS</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#accueil" class="nav-link text-primary-800 font-semibold hover:text-primary-600 transition">Accueil</a>
                    <a href="#services" class="nav-link text-primary-800 font-semibold hover:text-primary-600 transition">Solutions</a>
                    <a href="#documents" class="nav-link text-primary-800 font-semibold hover:text-primary-600 transition">Documents</a>
                    <a href="#societes" class="nav-link text-primary-800 font-semibold hover:text-primary-600 transition">Sociétés</a>
                    <a href="#contact" class="nav-link text-primary-800 font-semibold hover:text-primary-600 transition">Contact</a>
                    
                    <!-- Auth Buttons -->
                    <div class="flex items-center gap-3 ml-4">
                        @if (\Illuminate\Support\Facades\Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   class="px-5 py-2.5 bg-gradient-to-r from-primary-600 to-invest-500 hover:from-primary-700 hover:to-invest-600 text-white font-semibold rounded-xl shadow-md hover:shadow-xl transition-all duration-300 flex items-center">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-5 py-2.5 text-primary-600 font-semibold border-2 border-primary-200 hover:border-primary-300 hover:bg-primary-50 rounded-xl transition-all duration-300 flex items-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Connexion
                                </a>
                                
                                @if (\Illuminate\Support\Facades\Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="px-5 py-2.5 bg-gradient-to-r from-primary-600 to-invest-500 hover:from-primary-700 hover:to-invest-600 text-white font-semibold rounded-xl shadow-md hover:shadow-xl transition-all duration-300 flex items-center">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Inscription
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button class="lg:hidden text-primary-600 hover:text-primary-700 transition" id="menuBtn">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="lg:hidden hidden glass mx-6 mt-2 rounded-2xl p-4" id="mobileMenu">
            <div class="flex flex-col space-y-3">
                <a href="#accueil" class="px-4 py-3 text-primary-800 hover:bg-primary-50 rounded-xl transition">Accueil</a>
                <a href="#services" class="px-4 py-3 text-primary-800 hover:bg-primary-50 rounded-xl transition">Solutions</a>
                <a href="#documents" class="px-4 py-3 text-primary-800 hover:bg-primary-50 rounded-xl transition">Documents</a>
                <a href="#societes" class="px-4 py-3 text-primary-800 hover:bg-primary-50 rounded-xl transition">Sociétés</a>
                <a href="#contact" class="px-4 py-3 text-primary-800 hover:bg-primary-50 rounded-xl transition">Contact</a>
                <div class="pt-3 border-t border-primary-100 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="px-4 py-3 text-primary-600 font-semibold border-2 border-primary-200 rounded-xl text-center">Connexion</a>
                    <a href="{{ route('register') }}" class="px-4 py-3 bg-gradient-to-r from-primary-600 to-invest-500 text-white font-semibold rounded-xl text-center">Inscription</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== -->
    <!-- HERO SECTION - ACCUEIL -->
    <!-- ==================== -->
    <section id="accueil" class="relative min-h-screen flex items-center justify-center overflow-hidden pt-24">
        <!-- Animated background -->
        <div class="absolute inset-0 w-full h-full">
            <div class="absolute top-0 left-0 w-96 h-96 bg-primary-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-invest-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-primary-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-float" style="animation-delay: 4s"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-5xl mx-auto text-center" data-aos="fade-up" data-aos-duration="1000">
                <!-- Badge -->
                <div class="inline-flex items-center justify-center p-1 bg-gradient-to-r from-primary-100 to-invest-100 rounded-full mb-8">
                    <span class="px-4 py-2 bg-white text-primary-600 font-semibold rounded-full shadow-sm">
                        <i class="fas fa-bolt mr-2 text-invest-500"></i>
                        INVESTCALORIS by 360INVEST
                    </span>
                </div>

                <!-- Main Title -->
                <h1 class="text-5xl md:text-7xl font-bold mb-8 leading-tight">
                    <span class="bg-gradient-to-r from-primary-700 via-primary-600 to-invest-500 bg-clip-text text-transparent">
                        Gestion documentaire
                    </span>
                    <br>
                    <span class="text-primary-800">intelligente pour</span>
                    <br>
                    <span class="bg-gradient-to-r from-invest-600 to-primary-600 bg-clip-text text-transparent">
                        vos dossiers administratifs
                    </span>
                </h1>

                <!-- Description -->
                <p class="text-xl text-primary-700 mb-12 max-w-3xl mx-auto leading-relaxed">
                    La plateforme complète pour gérer vos sociétés, activités et documents. 
                    <span class="font-semibold text-primary-800">Devis, factures, attestations, rapports</span> — tout centralisé en un seul endroit.
                </p>

                <!-- Stats Counter -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
                    <div class="glass-card rounded-2xl p-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="text-4xl font-bold text-primary-600 mb-2 counter" data-target="1500">0</div>
                        <div class="text-primary-800 font-medium">Documents traités</div>
                    </div>
                    <div class="glass-card rounded-2xl p-6" data-aos="zoom-in" data-aos-delay="200">
                        <div class="text-4xl font-bold text-invest-500 mb-2 counter" data-target="3">0</div>
                        <div class="text-primary-800 font-medium">Sociétés actives</div>
                    </div>
                    <div class="glass-card rounded-2xl p-6" data-aos="zoom-in" data-aos-delay="300">
                        <div class="text-4xl font-bold text-primary-600 mb-2 counter" data-target="2">0</div>
                        <div class="text-primary-800 font-medium">Activités</div>
                    </div>
                    <div class="glass-card rounded-2xl p-6" data-aos="zoom-in" data-aos-delay="400">
                        <div class="text-4xl font-bold text-invest-500 mb-2 counter" data-target="6">0</div>
                        <div class="text-primary-800 font-medium">Types documents</div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{ route('register') }}" 
                       class="group px-8 py-5 bg-gradient-to-r from-primary-600 to-invest-500 hover:from-primary-700 hover:to-invest-600 text-white font-bold rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-1 flex items-center text-lg shine">
                        <i class="fas fa-rocket mr-3 group-hover:animate-bounce"></i>
                        Commencer maintenant
                    </a>
                    <a href="#solutions" 
                       class="group px-8 py-5 bg-white text-primary-600 font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center text-lg border-2 border-primary-100">
                        <i class="fas fa-play-circle mr-3 text-invest-500 group-hover:scale-110 transition"></i>
                        Voir les solutions
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <div class="w-10 h-16 border-2 border-primary-300 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-gradient-to-b from-primary-500 to-invest-500 rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- SOCIÉTÉS SECTION -->
    <!-- ==================== -->
    <section id="societes" class="py-24 bg-gradient-to-b from-primary-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-invest-500 font-semibold text-sm uppercase tracking-wider">Nos entités</span>
                <h2 class="text-4xl md:text-5xl font-bold text-primary-800 mt-4 mb-6">Sociétés partenaires</h2>
                <p class="text-xl text-primary-600 max-w-3xl mx-auto">Gérez l'ensemble de vos sociétés avec une isolation parfaite des données</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Énergie Nova -->
                <div class="group bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-100 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-150 transition duration-700"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-bolt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-primary-800 mb-3">Énergie Nova</h3>
                        <p class="text-primary-600 mb-6">Spécialiste en solutions énergétiques et performance thermique</p>
                        <div class="flex items-center text-sm text-primary-500 mb-4">
                            <i class="fas fa-file-alt mr-2"></i>
                            <span>1,247 documents</span>
                        </div>
                        <div class="w-full bg-primary-100 rounded-full h-2 mb-6">
                            <div class="bg-primary-500 h-2 rounded-full" style="width: 65%"></div>
                        </div>
                        <a href="#" class="inline-flex items-center text-primary-600 font-semibold group-hover:text-primary-700">
                            Voir l'espace <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                        </a>
                    </div>
                </div>

                <!-- MyHouse Solutions -->
                <div class="group bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-invest-100 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-150 transition duration-700"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-invest-400 to-invest-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-home text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-primary-800 mb-3">MyHouse Solutions</h3>
                        <p class="text-primary-600 mb-6">Solutions résidentielles innovantes pour l'habitat</p>
                        <div class="flex items-center text-sm text-primary-500 mb-4">
                            <i class="fas fa-file-alt mr-2"></i>
                            <span>892 documents</span>
                        </div>
                        <div class="w-full bg-primary-100 rounded-full h-2 mb-6">
                            <div class="bg-invest-500 h-2 rounded-full" style="width: 48%"></div>
                        </div>
                        <a href="#" class="inline-flex items-center text-invest-500 font-semibold group-hover:text-invest-600">
                            Voir l'espace <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                        </a>
                    </div>
                </div>

                <!-- Patrimoine Immobilier -->
                <div class="group bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 relative overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-100 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-150 transition duration-700"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-400 to-primary-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-landmark text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-primary-800 mb-3">Patrimoine Immobilier</h3>
                        <p class="text-primary-600 mb-6">Gestion patrimoniale et suivi de travaux</p>
                        <div class="flex items-center text-sm text-primary-500 mb-4">
                            <i class="fas fa-file-alt mr-2"></i>
                            <span>563 documents</span>
                        </div>
                        <div class="w-full bg-primary-100 rounded-full h-2 mb-6">
                            <div class="bg-primary-400 h-2 rounded-full" style="width: 32%"></div>
                        </div>
                        <a href="#" class="inline-flex items-center text-primary-500 font-semibold group-hover:text-primary-600">
                            Voir l'espace <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('back.societes.index') }}" 
                   class="inline-flex items-center px-8 py-4 bg-primary-50 text-primary-600 font-semibold rounded-xl hover:bg-primary-100 transition-all duration-300">
                    <i class="fas fa-building mr-2"></i>
                    Voir toutes les sociétés
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- ACTIVITÉS SECTION -->
    <!-- ==================== -->
    <section id="activites" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Expertise métier</span>
                <h2 class="text-4xl md:text-5xl font-bold text-primary-800 mt-4 mb-6">Nos activités</h2>
                <p class="text-xl text-primary-600 max-w-3xl mx-auto">Deux domaines d'expertise pour une gestion documentaire spécialisée</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Désembouage -->
                <div class="group bg-gradient-to-br from-primary-50 to-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-500" data-aos="fade-right">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition duration-300">
                            <i class="fas fa-water text-white text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-primary-800 mb-3">Désembouage</h3>
                            <p class="text-primary-600 mb-4 text-lg">Nettoyage et désembouage des circuits de chauffage</p>
                            <div class="flex items-center gap-4 text-sm">
                                <span class="px-3 py-1 bg-primary-100 text-primary-600 rounded-full">1,450 documents</span>
                                <span class="px-3 py-1 bg-primary-100 text-primary-600 rounded-full">842 devis</span>
                                <span class="px-3 py-1 bg-primary-100 text-primary-600 rounded-full">608 factures</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rééquilibrage -->
                <div class="group bg-gradient-to-br from-invest-50 to-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-500" data-aos="fade-left">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-invest-400 to-invest-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition duration-300">
                            <i class="fas fa-balance-scale text-white text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-primary-800 mb-3">Rééquilibrage</h3>
                            <p class="text-primary-600 mb-4 text-lg">Équilibrage des circuits hydrauliques</p>
                            <div class="flex items-center gap-4 text-sm">
                                <span class="px-3 py-1 bg-invest-100 text-invest-600 rounded-full">892 documents</span>
                                <span class="px-3 py-1 bg-invest-100 text-invest-600 rounded-full">406 devis</span>
                                <span class="px-3 py-1 bg-invest-100 text-invest-600 rounded-full">486 factures</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- DOCUMENTS SECTION -->
    <!-- ==================== -->
    <section id="documents" class="py-24 bg-gradient-to-b from-primary-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-invest-500 font-semibold text-sm uppercase tracking-wider">Gestion documentaire</span>
                <h2 class="text-4xl md:text-5xl font-bold text-primary-800 mt-4 mb-6">Types de documents</h2>
                <p class="text-xl text-primary-600 max-w-3xl mx-auto">Une chaîne documentaire complète pour vos dossiers administratifs</p>
            </div>

            <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Devis -->
                <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="flip-left" data-aos-delay="100">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-invoice-dollar text-primary-500 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-primary-800">Devis</h4>
                    <p class="text-xs text-primary-500 mt-2">1,248 documents</p>
                </div>

                <!-- Facture -->
                <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="flip-left" data-aos-delay="200">
                    <div class="w-16 h-16 bg-success-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-invoice text-green-500 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-primary-800">Factures</h4>
                    <p class="text-xs text-primary-500 mt-2">1,094 documents</p>
                </div>

                <!-- Attestation réalisation -->
                <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="flip-left" data-aos-delay="300">
                    <div class="w-16 h-16 bg-warning-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-yellow-500 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-primary-800">Attestation réal.</h4>
                    <p class="text-xs text-primary-500 mt-2">456 documents</p>
                </div>

                <!-- Attestation signataire -->
                <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="flip-left" data-aos-delay="400">
                    <div class="w-16 h-16 bg-info-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-check text-blue-400 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-primary-800">Attestation sign.</h4>
                    <p class="text-xs text-primary-500 mt-2">234 documents</p>
                </div>

                <!-- Rapport -->
                <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="flip-left" data-aos-delay="500">
                    <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-gray-500 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-primary-800">Rapports</h4>
                    <p class="text-xs text-primary-500 mt-2">178 documents</p>
                </div>

                <!-- Cahier des charges -->
                <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="flip-left" data-aos-delay="600">
                    <div class="w-16 h-16 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-gray-700 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-primary-800">Cahier charges</h4>
                    <p class="text-xs text-primary-500 mt-2">89 documents</p>
                </div>
            </div>

            <!-- Cycle documentaire -->
            <div class="mt-16 bg-white rounded-3xl p-10 shadow-xl" data-aos="fade-up">
                <h3 class="text-2xl font-bold text-primary-800 text-center mb-8">Cycle de vie documentaire</h3>
                <div class="flex flex-wrap justify-center items-center gap-4">
                    <span class="px-4 py-2 bg-primary-100 text-primary-600 rounded-full font-semibold">Devis</span>
                    <i class="fas fa-arrow-right text-primary-300"></i>
                    <span class="px-4 py-2 bg-success-100 text-success-600 rounded-full font-semibold">Facture</span>
                    <i class="fas fa-arrow-right text-primary-300"></i>
                    <span class="px-4 py-2 bg-warning-100 text-warning-600 rounded-full font-semibold">Attestation</span>
                    <i class="fas fa-arrow-right text-primary-300"></i>
                    <span class="px-4 py-2 bg-info-100 text-info-600 rounded-full font-semibold">Rapport</span>
                </div>
                <p class="text-center text-primary-600 mt-6">Liens parent-enfant pour une traçabilité complète</p>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- SOLUTIONS SECTION -->
    <!-- ==================== -->
    <section id="solutions" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Fonctionnalités</span>
                <h2 class="text-4xl md:text-5xl font-bold text-primary-800 mt-4 mb-6">Une plateforme complète</h2>
                <p class="text-xl text-primary-600 max-w-3xl mx-auto">Tous les outils pour gérer efficacement vos dossiers administratifs</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Dashboard -->
                <div class="group bg-gradient-to-br from-primary-50 to-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-3d" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-tachometer-alt text-primary-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary-800 mb-4">Dashboard intelligent</h3>
                    <p class="text-primary-600 mb-6">KPI en temps réel, graphiques d'évolution, documents récents</p>
                    <a href="#" class="text-primary-500 font-semibold flex items-center group-hover:text-primary-600">
                        En savoir plus <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                    </a>
                </div>

                <!-- Générateur PDF -->
                <div class="group bg-gradient-to-br from-primary-50 to-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-3d" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-invest-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-file-pdf text-invest-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary-800 mb-4">Générateur PDF</h3>
                    <p class="text-primary-600 mb-6">Templates personnalisables par société, prévisualisation instantanée</p>
                    <a href="#" class="text-invest-500 font-semibold flex items-center group-hover:text-invest-600">
                        En savoir plus <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                    </a>
                </div>

                <!-- Messagerie -->
                <div class="group bg-gradient-to-br from-primary-50 to-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-3d" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-info-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-comments text-info-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary-800 mb-4">Messagerie intégrée</h3>
                    <p class="text-primary-600 mb-6">Conversations, upload de fichiers, présence en temps réel</p>
                    <a href="#" class="text-info-500 font-semibold flex items-center group-hover:text-info-600">
                        En savoir plus <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                    </a>
                </div>

                <!-- Recherche globale -->
                <div class="group bg-gradient-to-br from-primary-50 to-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-3d" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 bg-success-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-search text-success-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary-800 mb-4">Recherche globale</h3>
                    <p class="text-primary-600 mb-6">Recherche multi-critères sur tous les documents et entités</p>
                    <a href="#" class="text-success-500 font-semibold flex items-center group-hover:text-success-600">
                        En savoir plus <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                    </a>
                </div>

                <!-- Gestion multi-sociétés -->
                <div class="group bg-gradient-to-br from-primary-50 to-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-3d" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-14 h-14 bg-warning-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-building text-warning-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary-800 mb-4">Multi-sociétés</h3>
                    <p class="text-primary-600 mb-6">Isolation des données par société, personnalisation avancée</p>
                    <a href="#" class="text-warning-500 font-semibold flex items-center group-hover:text-warning-600">
                        En savoir plus <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                    </a>
                </div>

                <!-- Corbeille intelligente -->
                <div class="group bg-gradient-to-br from-primary-50 to-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-3d" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-14 h-14 bg-danger-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-trash-alt text-danger-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary-800 mb-4">Corbeille</h3>
                    <p class="text-primary-600 mb-6">Suppression avec expiration, restauration possible</p>
                    <a href="#" class="text-danger-500 font-semibold flex items-center group-hover:text-danger-600">
                        En savoir plus <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- CTA SECTION - AUTH -->
    <!-- ==================== -->
    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 gradient-bg opacity-90"></div>
        <div class="absolute inset-0 bg-black opacity-20"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="zoom-in">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-8 leading-tight">
                    Prêt à optimiser votre<br>gestion documentaire ?
                </h2>
                <p class="text-xl text-white/90 mb-12 max-w-2xl mx-auto">
                    Rejoignez 360INVEST et découvrez comment INVESTCALORIS peut transformer votre gestion de dossiers administratifs.
                </p>

                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-10 border border-white/20">
                    <h3 class="text-2xl font-bold text-white mb-8">Commencez dès maintenant</h3>
                    
                    @if (\Illuminate\Support\Facades\Route::has('login'))
                        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   class="group px-10 py-5 bg-white text-primary-600 font-bold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 flex items-center text-lg">
                                    <i class="fas fa-rocket mr-3 group-hover:animate-bounce"></i>
                                    Accéder au Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-10 py-5 bg-white/90 text-primary-600 font-bold rounded-2xl hover:bg-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 flex items-center text-lg">
                                    <i class="fas fa-sign-in-alt mr-3"></i>
                                    Se connecter
                                </a>
                                
                                @if (\Illuminate\Support\Facades\Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="px-10 py-5 bg-transparent border-2 border-white text-white font-bold rounded-2xl hover:bg-white/10 transition-all duration-300 transform hover:scale-105 flex items-center text-lg">
                                        <i class="fas fa-user-plus mr-3"></i>
                                        Créer un compte
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                    
                    <p class="text-white/70 mt-8 text-sm flex items-center justify-center">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Sécurisé et conforme RGPD • Essai gratuit de 14 jours
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- FOOTER -->
    <!-- ==================== -->
    <footer class="bg-primary-900 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-10 mb-12">
                <!-- Logo -->
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-invest-400 rounded-xl flex items-center justify-center">
                            <i class="fas fa-file-invoice-dollar text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">360INVEST</h3>
                            <p class="text-primary-300 text-sm">by INVESTCALORIS</p>
                        </div>
                    </div>
                    <p class="text-primary-300 text-sm leading-relaxed">
                        La plateforme complète de gestion documentaire pour vos dossiers administratifs.
                    </p>
                </div>

                <!-- Liens rapides -->
                <div>
                    <h4 class="font-bold text-lg mb-6">Solutions</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-primary-300 hover:text-white transition">Dashboard</a></li>
                        <li><a href="#" class="text-primary-300 hover:text-white transition">Gestion documents</a></li>
                        <li><a href="#" class="text-primary-300 hover:text-white transition">Sociétés</a></li>
                        <li><a href="#" class="text-primary-300 hover:text-white transition">Activités</a></li>
                    </ul>
                </div>

                <!-- Ressources -->
                <div>
                    <h4 class="font-bold text-lg mb-6">Ressources</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-primary-300 hover:text-white transition">Documentation</a></li>
                        <li><a href="#" class="text-primary-300 hover:text-white transition">Support</a></li>
                        <li><a href="#" class="text-primary-300 hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="text-primary-300 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-6">Contact</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center text-primary-300">
                            <i class="fas fa-envelope mr-3 w-5"></i>
                            contact@360invest.com
                        </li>
                        <li class="flex items-center text-primary-300">
                            <i class="fas fa-phone mr-3 w-5"></i>
                            +33 1 23 45 67 89
                        </li>
                        <li class="flex items-center text-primary-300">
                            <i class="fas fa-map-marker-alt mr-3 w-5"></i>
                            Paris, France
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Social & Copyright -->
            <div class="border-t border-primary-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="flex space-x-6 mb-4 md:mb-0">
                    <a href="#" class="text-primary-300 hover:text-white transition text-xl">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-primary-300 hover:text-white transition text-xl">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-primary-300 hover:text-white transition text-xl">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
                <p class="text-primary-400 text-sm text-center">
                    &copy; 2024 360INVEST - INVESTCALORIS. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-lg');
            } else {
                navbar.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-lg');
            }
        });

        // Mobile menu toggle
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Counter animation
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const animateCounter = () => {
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const increment = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCount, 10);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                };
                updateCount();
            });
        };

        // Observer pour lancer l'animation quand les compteurs sont visibles
        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.counter').forEach(counter => {
            observer.observe(counter);
        });

        // Smooth scroll pour les ancres
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>