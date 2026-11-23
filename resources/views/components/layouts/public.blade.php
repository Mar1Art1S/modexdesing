@props([
    'title' => null,
    'description' => null,
])

@php
    $seo = \App\Models\SiteSetting::current();
    $currentLocale = app()->getLocale();
    $defaultTitle = ($currentLocale === 'uk' || $currentLocale === 'ua')
        ? ($seo->meta_title_ua ?? 'Modex - Фулстек 3D Друк та Технічне Проектування')
        : ($seo->meta_title_en ?? 'Modex - Full-Stack 3D Printing & Technical Hardware Engineering');
    $pageTitle = filled($title) ? $title . ' | Modex' : $defaultTitle;
    $defaultDesc = ($currentLocale === 'uk' || $currentLocale === 'ua')
        ? ($seo->meta_description_ua ?? 'Фулстек інженерне проектування, параметричне 3D CAD моделювання та високоточний 3D-друк деталей.')
        : ($seo->meta_description_en ?? 'From concept to physical reality: Full-Stack Hardware Engineering, 3D CAD Prototyping & Precision 3D Printing.');
    $pageDesc = $description ?? $defaultDesc;
    $ogImage = $seo->og_image ? (str_starts_with($seo->og_image, 'http') ? $seo->og_image : url($seo->og_image)) : url('/apple-touch-icon.png');
    $canonicalUrl = $seo->canonical_url ?? url()->current();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $pageDesc }}">
        @if ($seo->meta_keywords)
            <meta name="keywords" content="{{ $seo->meta_keywords }}">
        @endif

        @if ($seo->is_indexed)
            <meta name="robots" content="index, follow">
        @else
            <meta name="robots" content="noindex, nofollow">
        @endif

        <link rel="canonical" href="{{ $canonicalUrl }}">

        <!-- Google Site Verification (Google Search Console) -->
        @if ($seo->google_site_verification)
            <meta name="google-site-verification" content="{{ $seo->google_site_verification }}" />
        @endif

        <!-- Open Graph / Facebook / LinkedIn / Telegram -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ $canonicalUrl }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $pageDesc }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:site_name" content="Modex">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ $canonicalUrl }}">
        <meta name="twitter:title" content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $pageDesc }}">
        <meta name="twitter:image" content="{{ $ogImage }}">

        <!-- Google Analytics 4 (GA4 - gtag.js) -->
        @if ($seo->google_analytics_id)
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seo->google_analytics_id }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ $seo->google_analytics_id }}');
            </script>
        @endif

        <!-- Google Tag Manager (GTM) -->
        @if ($seo->google_tag_manager_id)
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $seo->google_tag_manager_id }}');</script>
        @endif

        <!-- Custom Head Scripts -->
        @if ($seo->custom_head_scripts)
            {!! $seo->custom_head_scripts !!}
        @endif

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Google Fonts: Unbounded (Headings), Inter (Body), Caveat (Logo script) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Inter:wght@300;400;500;600;700&family=Unbounded:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Three.js Native ES Module Import Map for 3D Background Reel -->
        <script type="importmap">
        {
            "imports": {
                "three": "/vendor/three/build/three.module.min.js",
                "three/addons/": "/vendor/three/addons/"
            }
        }
        </script>
        <link rel="modulepreload" href="/vendor/three/build/three.module.min.js">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .bg-blueprint-grid {
                background-color: #ffffff;
                background-image: 
                    radial-gradient(circle at 50% 0%, rgba(14, 165, 233, 0.08) 0%, transparent 60%),
                    linear-gradient(to right, rgba(14, 165, 233, 0.05) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(14, 165, 233, 0.05) 1px, transparent 1px);
                background-size: 100% 100%, 36px 36px, 36px 36px;
            }

            .font-heading {
                font-family: 'Unbounded', system-ui, sans-serif;
            }

            .font-body {
                font-family: 'Inter', system-ui, sans-serif;
            }

            .btn-cyan-glow {
                background: linear-gradient(180deg, #10263c 0%, #0c1c2e 100%);
                border: 1px solid rgba(56, 189, 248, 0.85);
                box-shadow: 0 0 18px rgba(14, 165, 233, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .btn-cyan-glow:hover {
                border-color: #38bdf8;
                box-shadow: 0 0 28px rgba(14, 165, 233, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.25);
                transform: translateY(-1px);
            }
            .btn-cyan-glow:active {
                transform: translateY(1px);
            }

            .card-tech-glow {
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .card-tech-glow:hover {
                border-color: rgba(14, 165, 233, 0.6);
                box-shadow: 0 16px 36px -8px rgba(14, 165, 233, 0.2), 0 0 0 1px rgba(14, 165, 233, 0.25);
                transform: translateY(-3px);
            }

            .nav-active-glow {
                position: relative;
                color: #0284c7;
                font-weight: 600;
            }
            .nav-active-glow::after {
                content: '';
                position: absolute;
                bottom: -6px;
                left: 0;
                right: 0;
                height: 2.5px;
                background-color: #0ea5e9;
                border-radius: 9999px;
                box-shadow: 0 0 10px #0ea5e9, 0 0 16px rgba(14, 165, 233, 0.7);
            }

            /* 3D Morphing Background Reel in Hero */
            #hero-morph-stage {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                background: transparent !important;
                --canvas-filter: invert(1) hue-rotate(180deg) saturate(0.9);
                --canvas-blend: multiply;
                --canvas-opacity: 0.95;
            }
            #hero-morph-stage canvas {
                opacity: 0;
                filter: invert(1) hue-rotate(180deg) saturate(0.9) !important;
                mix-blend-mode: multiply !important;
                transition: opacity 1.8s cubic-bezier(0.16, 1, 0.3, 1);
                display: block;
                width: 100%;
                height: 100%;
            }
            #hero-morph-stage.is-live canvas {
                opacity: 0.95 !important;
            }

            /* 4-Step Engineering Pipeline Tab & Stage Styling */
            .pipeline-tab-btn.active {
                background: #0284c7;
                color: #ffffff !important;
                box-shadow: 0 0 10px rgba(14, 165, 233, 0.4);
            }
            .pipeline-tab-btn.active span {
                color: #ffffff !important;
            }
            #hero-pipeline-stage canvas {
                display: block;
                width: 100%;
                height: 100%;
            }

            /* Floating Quick Contact Widget (Facebook & Instagram) */
            .floating-contact-btn {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 9999px !important;
                color: #ffffff !important;
                text-decoration: none !important;
                transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease !important;
                outline: none !important;
            }
            .floating-contact-btn:active {
                transform: scale(0.92) !important;
            }
            .floating-btn-facebook {
                background: #1877f2 !important;
                box-shadow: 0 10px 25px -3px rgba(24, 119, 242, 0.55), 0 4px 10px rgba(0, 0, 0, 0.2) !important;
            }
            .floating-btn-facebook:hover {
                background: #166fe5 !important;
                box-shadow: 0 16px 32px -2px rgba(24, 119, 242, 0.7), 0 6px 16px rgba(0, 0, 0, 0.25) !important;
                transform: scale(1.08) !important;
            }
            .floating-btn-whatsapp {
                background: #25D366 !important;
                box-shadow: 0 10px 25px -3px rgba(37, 211, 102, 0.55), 0 4px 10px rgba(0, 0, 0, 0.2) !important;
            }
            .floating-btn-whatsapp:hover {
                background: #20bd5a !important;
                box-shadow: 0 16px 32px -2px rgba(37, 211, 102, 0.7), 0 6px 16px rgba(0, 0, 0, 0.25) !important;
                transform: scale(1.08) !important;
            }
            .floating-btn-instagram {
                background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285aeb 90%),
                            linear-gradient(45deg, #f09433 0%, #dc2743 50%, #bc1888 100%) !important;
                box-shadow: 0 10px 25px -3px rgba(220, 39, 67, 0.55), 0 4px 10px rgba(0, 0, 0, 0.2) !important;
            }
            .floating-btn-instagram:hover {
                box-shadow: 0 16px 32px -2px rgba(220, 39, 67, 0.7), 0 6px 16px rgba(0, 0, 0, 0.25) !important;
                transform: scale(1.08) !important;
            }
        </style>
    </head>
    <body class="bg-blueprint-grid text-slate-800 font-body min-h-screen flex flex-col antialiased selection:bg-sky-500 selection:text-white"
          x-data="{ 
              lang: localStorage.getItem('modex_lang') || 'ua',
              setLang(l) {
                  this.lang = l;
                  localStorage.setItem('modex_lang', l);
              },
              activeSection: 'hero',
              orderModalOpen: false, 
              selectedService: '3D Printing & Prototyping',
              mobileMenuOpen: false,
              submitted: false,
              previewHero: null,
              previewCard1: null,
              previewCard2: null,
              previewCard3: null,
              handleImageUpload(event, key) {
                  const file = event.target.files[0];
                  if (file) {
                      this[key] = URL.createObjectURL(file);
                  }
              },
              init() {
                  const sections = ['hero', 'projects', 'printing', 'engineering', 'about', 'contacts'];
                  const onScroll = () => {
                      const scrollPos = window.scrollY + 140;
                      for (const id of sections) {
                          const el = document.getElementById(id);
                          if (el) {
                              const top = el.offsetTop;
                              const height = el.offsetHeight;
                              if (scrollPos >= top && scrollPos < top + height) {
                                  this.activeSection = id;
                              }
                          }
                      }
                  };
                  window.addEventListener('scroll', onScroll, { passive: true });
                  onScroll();
              }
          }">

        <!-- ============================================================ -->
        <!-- NAVIGATION HEADER (ONE-PAGE SMOOTH SCROLL)                   -->
        <!-- ============================================================ -->
        <x-navigation.navbar />

        <!-- MAIN PAGE CONTENT -->
        <main class="grow">
            {{ $slot }}
        </main>

        <!-- ============================================================ -->
        <!-- CONTACT & FOOTER SECTION                                     -->
        <!-- ============================================================ -->
        <x-navigation.footer />

        <!-- ============================================================ -->
        <!-- UNIVERSAL "ORDER A PROJECT" MODAL DIALOG                     -->
        <!-- ============================================================ -->
        <x-modals.order-modal />

        <!-- ============================================================ -->
        <!-- FLOATING QUICK CONTACT WIDGET (WHATSAPP, FACEBOOK, INSTAGRAM) -->
        <!-- ============================================================ -->
        <x-navigation.floating-contacts />

        <!-- Google Tag Manager (noscript) -->
        @if ($seo->google_tag_manager_id)
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $seo->google_tag_manager_id }}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        @endif

        <!-- Custom Body Scripts -->
        @if ($seo->custom_body_scripts)
            {!! $seo->custom_body_scripts !!}
        @endif
    </body>
</html>
