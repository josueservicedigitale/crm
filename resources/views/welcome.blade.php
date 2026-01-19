<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue | Rééquilibrage Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 50%, #d6f0ff 100%);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(30, 64, 175, 0.1);
        }
        
        .nav-link {
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-blue-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-400 rounded-lg flex items-center justify-center">
                        <i class="fas fa-balance-scale text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">
                            360<span class="font-semibold text-blue-500">INVEST</span>
                        </h1>
                        <p class="text-xs text-blue-400">Solutions professionnelles</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="nav-link text-blue-800 font-medium hover:text-blue-600">Accueil</a>
                    <a href="#" class="nav-link text-blue-800 font-medium hover:text-blue-600">Services</a>
                    <a href="#" class="nav-link text-blue-800 font-medium hover:text-blue-600">Solutions</a>
                    <a href="#" class="nav-link text-blue-800 font-medium hover:text-blue-600">Contact</a>
                    
                    <!-- Vos liens d'authentification intégrés -->
                    <div class="ml-4">
                        @if (\Illuminate\Support\Facades\Route::has('login'))

                            <nav class="flex items-center gap-4">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="inline-block px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300"
                                    >
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="inline-block px-5 py-2.5 text-blue-600 font-medium border border-blue-200 hover:border-blue-300 hover:bg-blue-50 rounded-lg transition-all duration-300"
                                    >
                                        <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                                    </a>

                                    @if (\Illuminate\Support\Facades\Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="inline-block px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                            <i class="fas fa-user-plus mr-2"></i>Inscription
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button class="md:hidden text-blue-700">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white">
        <div class="container mx-auto px-6 py-20">
            <div class="max-w-3xl mx-auto text-center">
                <div class="inline-flex items-center justify-center p-3 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                    <span class="text-sm font-semibold"> Nouvelle version disponible</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Rééquilibrage <span class="text-blue-200">Intelligent</span>
                </h1>
                <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                    Découvrez notre solution complète pour optimiser vos processus de rééquilibrage avec précision et efficacité.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="px-8 py-4 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-play-circle mr-3"></i>Voir la démo
                    </a>
                    <a href="#" class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition-all duration-300">
                        <i class="fas fa-book-open mr-3"></i>En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-blue-900 mb-4">Fonctionnalités principales</h2>
                <p class="text-blue-600 max-w-2xl mx-auto">Des outils puissants pour gérer efficacement vos opérations de rééquilibrage</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover border border-blue-50">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-900 mb-4">Analyse en temps réel</h3>
                    <p class="text-blue-700 mb-6">Surveillez et analysez les données de rééquilibrage avec des tableaux de bord interactifs.</p>
                    <a href="#" class="text-blue-500 font-semibold flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover border border-blue-50">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-cogs text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-900 mb-4">Automatisation intelligente</h3>
                    <p class="text-blue-700 mb-6">Automatisez les processus répétitifs et gagnez du temps sur vos interventions.</p>
                    <a href="#" class="text-blue-500 font-semibold flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover border border-blue-50">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-users text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-900 mb-4">Gestion collaborative</h3>
                    <p class="text-blue-700 mb-6">Travaillez en équipe avec des outils de partage et de coordination avancés.</p>
                    <a href="#" class="text-blue-500 font-semibold flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-3xl p-12 shadow-2xl">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-4xl font-bold text-white mb-6">Prêt à transformer votre approche du rééquilibrage ?</h2>
                    <p class="text-blue-100 text-xl mb-10">Rejoignez des centaines de professionnels qui optimisent déjà leurs processus avec notre solution.</p>
                    
                    <!-- Section d'authentification stylisée -->
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-8 border border-white/30">
                        <h3 class="text-2xl font-bold text-white mb-6">Commencez dès maintenant</h3>
                        
                        @if (\Illuminate\Support\Facades\Route::has('login'))

                            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="px-10 py-4 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center"
                                    >
                                        <i class="fas fa-rocket mr-3 text-lg"></i>
                                        Accéder au Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="px-10 py-4 bg-white/90 text-blue-600 font-bold rounded-xl hover:bg-white shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center"
                                    >
                                        <i class="fas fa-sign-in-alt mr-3 text-lg"></i>
                                        Se connecter
                                    </a>
                                    
                                    @if (\Illuminate\Support\Facades\Route::has('register'))

                                        <a
                                            href="{{ route('register') }}"
                                            class="px-10 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300 transform hover:scale-105 flex items-center">
                                            <i class="fas fa-user-plus mr-3 text-lg"></i>
                                            Créer un compte
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                        
                        <p class="text-blue-100 mt-8 text-sm">
                            <i class="fas fa-shield-alt mr-2"></i>Sécurisé et conforme RGPD • Essai gratuit de 14 jours
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-8 md:mb-0">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-300 rounded-lg flex items-center justify-center">
                            <i class="fas fa-balance-scale text-white text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold">Rééquilibrage<span class="text-blue-300">Pro</span></h2>
                    </div>
                    <p class="text-blue-300">Solutions professionnelles depuis 2024</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-6">
                    <a href="#" class="text-blue-200 hover:text-white transition-colors">
                        <i class="fab fa-twitter mr-2"></i>Twitter
                    </a>
                    <a href="#" class="text-blue-200 hover:text-white transition-colors">
                        <i class="fab fa-linkedin mr-2"></i>LinkedIn
                    </a>
                    <a href="#" class="text-blue-200 hover:text-white transition-colors">
                        <i class="fab fa-github mr-2"></i>GitHub
                    </a>
                </div>
            </div>
            
            <div class="border-t border-blue-800 mt-10 pt-8 text-center text-blue-400 text-sm">
                <p>&copy; 360INVEST. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Script pour le menu mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('button[class*="md:hidden"]');
            const navLinks = document.querySelector('.hidden.md\\:flex');
            
            menuButton.addEventListener('click', function() {
                // Ici vous pouvez ajouter la logique pour afficher/masquer le menu mobile
                alert('Menu mobile - À implémenter selon vos besoins');
            });
            
            // Animation au défilement
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Observer les cartes de fonctionnalités
            document.querySelectorAll('.card-hover').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>