<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MyStudi') }} - Gestion Scolaire Moderne</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>

<body
    class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased overflow-x-hidden selection:bg-indigo-500 selection:text-white">

    <!-- Background Decoration -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob">
        </div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"
            style="animation-delay: 2s"></div>
        <div class="absolute -bottom-32 left-1/2 w-96 h-96 bg-amber-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"
            style="animation-delay: 4s"></div>
    </div>

    <!-- Navigation -->
    <nav class="absolute top-0 left-0 right-0 z-10 w-full animate-fade-in-up">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <!-- Logo -->
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-emerald-400 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/30">
                    MS
                </div>
                <span
                    class="text-2xl font-black tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
                    MyStudi
                </span>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-sm font-semibold hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Tableau
                        de bord</a>
                @else
                    <a href="{{ url('/dashboard/login') }}"
                        class="hidden sm:inline-block text-sm font-semibold hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Se
                        connecter</a>
                    <a href="{{ route('auth.google') }}"
                        class="disable inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md hover:border-gray-300 dark:hover:border-gray-600 transition-all font-medium text-sm">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span>Google</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative flex flex-col justify-center min-h-[90vh] pt-20 px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">

            <!-- Left Text Content -->
            <div class="max-w-2xl animate-fade-in-up" style="animation-delay: 0.1s">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-sm font-medium mb-6 ring-1 ring-inset ring-indigo-500/20">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Gestion Scolaire 2.0
                </div>
                <h1
                    class="text-5xl lg:text-7xl font-black tracking-tight text-gray-900 dark:text-white leading-[1.1] mb-6">
                    Pilotez votre <br />
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-emerald-400">Établissement</span>
                </h1>
                <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-300 mb-10 leading-relaxed max-w-xl">
                    Une plateforme unifiée et sécurisée pour gérer vos élèves, enseignants, notes et finances.
                    Simplifiez l'administration scolaire dès aujourd'hui.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ url('/dashboard/login') }}"
                        class="inline-flex justify-center items-center gap-2 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 transition-all font-semibold text-lg">
                        Commencer gratuitement
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <div class="mt-10 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 font-medium">
                    <div class="flex -space-x-2">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 border-2 border-white dark:border-gray-900">
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 border-2 border-white dark:border-gray-900">
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-gray-400 dark:bg-gray-500 border-2 border-white dark:border-gray-900 flex items-center justify-center text-xs text-white">
                            +</div>
                    </div>
                    <span>Déjà adopté par des dizaines d'écoles</span>
                </div>
            </div>

            <!-- Right Image/Illustration -->
            <div class="relative lg:h-full flex items-center justify-center animate-fade-in-up"
                style="animation-delay: 0.3s">
                <div class="relative w-full max-w-lg aspect-square lg:aspect-auto lg:h-150 animate-float">
                    <img src="{{ asset('images/hero.png') }}" alt="School Management Dashboard"
                        class="w-full h-full object-contain filter drop-shadow-2xl"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    <div
                        class="hidden absolute inset-0 flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-3xl bg-gray-50/50 dark:bg-gray-800/50 backdrop-blur-sm">
                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="text-sm font-medium">Illustration 3D MyStudi</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Features Section -->
    <section
        class="py-24 bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl border-y border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 animate-fade-in-up" style="animation-delay: 0.2s">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Tout ce dont vous avez besoin</h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Une suite complète d'outils conçus spécifiquement
                    pour répondre aux exigences des établissements scolaires modernes.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 animate-fade-in-up"
                    style="animation-delay: 0.3s">
                    <div
                        class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Multi-Établissements</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Gérez plusieurs écoles avec un seul compte. Les données de chaque établissement sont isolées et
                        hautement sécurisées.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 animate-fade-in-up"
                    style="animation-delay: 0.4s">
                    <div
                        class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Suivi Scolaire</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Centralisez la gestion des élèves, la configuration des années scolaires, l'affectation aux
                        classes et la saisie des notes.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 animate-fade-in-up"
                    style="animation-delay: 0.5s">
                    <div
                        class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/50 flex items-center justify-center text-amber-600 dark:text-amber-400 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Finances Intégrées</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Gardez un œil sur la trésorerie. Suivez les paiements d'écolages des élèves et gérez la
                        rémunération des enseignants facilement.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-10 text-center text-gray-500 dark:text-gray-400 text-sm">
        <p>&copy; {{ date('Y') }} MyStudi. Tous droits réservés. Construit avec soin pour l'excellence éducative.</p>
    </footer>

</body>

</html>