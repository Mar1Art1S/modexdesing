<!doctype html>
<html lang="uk" data-theme="paper" data-layout="side" data-nav="bar" data-copy="where" data-reel="all" data-morph="fly" data-pencil="0" data-tempo="normal">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Тестова Анімація 3D Ліній (Xplore AI Engine) | Modex Design</title>
    <meta name="description" content="Тестова сторінка з інтерактивною 3D-анімацією морфінгу складних інженерних машин у векторному стилі xplore.ai.">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

    <!-- Preload Three.js & ES Module Importmap -->
    <script type="importmap">
    {
        "imports": {
            "three": "/vendor/three/build/three.module.min.js",
            "three/addons/": "/vendor/three/addons/"
        }
    }
    </script>
    <link rel="modulepreload" href="/vendor/three/build/three.module.min.js">

    <!-- Xplore Engine Stylesheets -->
    <link rel="stylesheet" href="/xplore/css/site.css">
    <link rel="stylesheet" href="/xplore/css/home.css">

    <!-- Google Fonts for Modex Integration -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Unbounded:wght@600;800;900&display=swap" rel="stylesheet">

    <!-- Xplore Options Handler -->
    <script src="/xplore/js/options.js"></script>

    <script>
        (function () {
            var d = document.documentElement;
            // Parse options from search query or defaults
            var o = window.XV_PAGE = XV.resolve(new URLSearchParams(location.search));
            XV.AXES.forEach(function (a) { d.dataset[a.key] = o[a.key]; });
            var t = XV.axis('theme').options.filter(function (x) { return x.v === o.theme; })[0];
            if (t) {
                var m = document.querySelector('meta[name="theme-color"]');
                if (m) m.content = t.bg;
            }
        })();
    </script>

    <style>
        /* Modex Control Dock Styling */
        .modex-dock {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(56, 189, 248, 0.3);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5), 0 0 25px rgba(14, 165, 233, 0.2);
            border-radius: 20px;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e2e8f0;
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 13px;
            max-width: 95vw;
            overflow-x: auto;
        }

        .dock-group {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(30, 41, 59, 0.7);
            padding: 4px 8px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .dock-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #38bdf8;
            font-family: monospace;
            padding-right: 2px;
        }

        .dock-btn {
            background: rgba(255, 255, 255, 0.06);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            white-space: nowrap;
        }

        .dock-btn:hover {
            background: rgba(14, 165, 233, 0.25);
            color: #ffffff;
            border-color: #38bdf8;
        }

        .dock-btn.active {
            background: #0284c7;
            color: #ffffff;
            border-color: #38bdf8;
            box-shadow: 0 0 12px rgba(14, 165, 233, 0.5);
        }

        .top-badge-modex {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background: rgba(2, 132, 199, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.4);
            border-radius: 9999px;
            font-family: monospace;
            font-size: 11px;
            font-weight: 700;
            color: #0284c7;
            margin-bottom: 12px;
        }

        [data-theme='blueprint'] .top-badge-modex,
        [data-theme='noir'] .top-badge-modex,
        [data-theme='graphite'] .top-badge-modex {
            color: #38bdf8;
            background: rgba(14, 165, 233, 0.2);
            border-color: rgba(56, 189, 248, 0.5);
        }

        /* Return link button */
        .btn-back-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #0f172a;
            color: #ffffff;
            border: 1px solid rgba(56, 189, 248, 0.5);
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
        }
        .btn-back-home:hover {
            background: #0284c7;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(14, 165, 233, 0.35);
        }
    </style>

    <!-- Mount Animation Reel -->
    <script type="module">
        import { mountReel } from '/xplore/js/reel.js';
        
        let currentStage = null;

        async function initReel() {
            const el = document.getElementById('reel');
            if (!el) return;
            
            // Clean previous stage if reinitializing
            if (currentStage) {
                try {
                    currentStage.dispose();
                } catch (e) {
                    console.warn('Dispose stage:', e);
                }
                el.innerHTML = '';
                el.classList.remove('is-live');
            }

            const o = window.XV_PAGE;
            currentStage = await mountReel(el, {
                pencil: Number(o.pencil),
                morph: o.morph,
                tempo: XV.TEMPO[o.tempo],
                machines: XV.REELS[o.reel] || [o.reel],
            });
            window.__reelStage = currentStage;
        }

        // Global switcher function for the dock controls
        window.switchOption = function(key, val) {
            const url = new URL(window.location);
            url.searchParams.set(key, val);
            window.history.replaceState({}, '', url);

            // Update document dataset
            document.documentElement.dataset[key] = val;
            window.XV_PAGE = XV.resolve(url.searchParams);

            // Update UI dock buttons active state
            document.querySelectorAll(`[data-opt-key="${key}"]`).forEach(btn => {
                if (btn.dataset.optVal === val) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // If machine, morph, tempo, or pencil changed, reinitialize stage
            if (['reel', 'morph', 'tempo', 'pencil'].includes(key)) {
                initReel();
            }
        };

        window.addEventListener('DOMContentLoaded', initReel);
    </script>
</head>
<body>

    <!-- SVG filter for hand-drawn sketch style -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
        <filter id="rough" x="-2%" y="-2%" width="104%" height="104%">
            <feTurbulence type="fractalNoise" baseFrequency="0.035" numOctaves="2" seed="7" result="n"/>
            <feDisplacementMap in="SourceGraphic" in2="n" scale="1.2" xChannelSelector="R" yChannelSelector="G"/>
        </filter>
    </svg>

    <!-- Technical Drawing Grid & Zone Frame -->
    <div class="sheet" aria-hidden="true">
        <div class="zones">
            <div class="h t">
                <span>01</span><span>02</span><span>03</span><span>04</span><span>05</span><span>06</span><span>07</span><span>08</span>
            </div>
            <div class="h b">
                <span>01</span><span>02</span><span>03</span><span>04</span><span>05</span><span>06</span><span>07</span><span>08</span>
            </div>
            <div class="v l">
                <span>A</span><span>B</span><span>C</span><span>D</span>
            </div>
            <div class="v r">
                <span>A</span><span>B</span><span>C</span><span>D</span>
            </div>
        </div>
        <div class="inner"></div>
    </div>

    <!-- Header Navigation -->
    <header class="top">
        <a class="brand" href="{{ route('home') }}" aria-label="Modex Design" style="display:flex; align-items:center; gap:12px; text-decoration:none;">
            <img src="{{ asset('images/modex4.png') }}" alt="Modex Logo" style="height:32px; width:auto;" />
            <span style="font-family:'Unbounded', sans-serif; font-weight:800; font-size:16px; letter-spacing:-0.03em;">MODEX // LAB</span>
        </a>

        <nav aria-label="Main" style="display:flex; align-items:center; gap:14px;">
            <span style="font-family:monospace; font-size:11px; opacity:0.6; display:none; @media(min-width:640px){display:inline;}">XPLORE 3D MORPH REEL</span>
            <a href="{{ route('home') }}" class="btn-back-home">
                &larr; На головну Modex
            </a>
        </nav>
    </header>

    <!-- Main Layout with Copy & 3D Interactive Reel -->
    <main>
        <div class="copy">
            <div class="hl">
                <div class="top-badge-modex">
                    <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#0284c7; animation:pulse 1.5s infinite;"></span>
                    <span>3D VECTOR REEL // CAD VISUALIZATION</span>
                </div>

                <h1 id="hl-title">
                    Інженерна 3D Анімація.
                    <span class="soft" style="display:block; opacity:0.65; font-size:0.85em; margin-top:8px;">
                        Векторний морфінг механічних вузлів
                    </span>
                </h1>

                <p class="sub" id="hl-sub" style="margin-top:16px; font-size:15px; line-height:1.6; max-width:480px;">
                    Точні математичні розрахунки, параметричні лінії креслень та динамічний морфінг поверхонь у реальному часі за допомогою WebGL та Three.js.
                </p>
            </div>

            <div class="actions" style="margin-top:24px; display:flex; flex-wrap:wrap; gap:10px;">
                <button type="button" onclick="switchOption('morph', 'fly')" class="dock-btn active" data-opt-key="morph" data-opt-val="fly">
                    ✈️ Політ ребер (Fly)
                </button>
                <button type="button" onclick="switchOption('morph', 'draw')" class="dock-btn" data-opt-key="morph" data-opt-val="draw">
                    ✏️ Креслення (Draw)
                </button>
                <button type="button" onclick="switchOption('morph', 'fade')" class="dock-btn" data-opt-key="morph" data-opt-val="fade">
                    🌫️ Плавне згасання (Fade)
                </button>
            </div>

            <!-- Active Specs Card -->
            <div style="margin-top:28px; padding:16px; border-radius:14px; border:1px solid rgba(120,120,120,0.2); background:rgba(120,120,120,0.05); font-family:monospace; font-size:11px; line-height:1.8; max-width:440px;">
                <div><strong style="color:#0284c7;">ТЕХНОЛОГІЯ:</strong> Procedural LineSegments2 (Three.js)</div>
                <div><strong style="color:#0284c7;">МАТЕРІАЛ:</strong> Hidden-Line GPU Wireframe Shader</div>
                <div><strong style="color:#0284c7;">ОБ'ЄКТИ:</strong> 7 машин (Турбіна, Міст, Двигун V12, Габбл, PCB, F-1, Обмінник)</div>
                <div><strong style="color:#0284c7;">РЕНДЕР:</strong> 60 FPS чистий WebGL (без зовнішніх 3D файлів)</div>
            </div>
        </div>

        <!-- 3D Canvas Stagebox -->
        <div class="stagebox">
            <div id="reel" role="img" aria-label="3D Line drawings of engineering machines, morphing into one another."></div>
        </div>
    </main>

    <!-- ============================================================ -->
    <!-- INTERACTIVE CONTROL DOCK (SWITCH MACHINES, THEMES, STYLES)   -->
    <!-- ============================================================ -->
    <div class="modex-dock">
        
        <!-- Machines selector -->
        <div class="dock-group">
            <span class="dock-label">Об'єкт:</span>
            <button type="button" onclick="switchOption('reel', 'all')" class="dock-btn active" data-opt-key="reel" data-opt-val="all">Усі 7</button>
            <button type="button" onclick="switchOption('reel', 'turbine')" class="dock-btn" data-opt-key="reel" data-opt-val="turbine">Турбіна</button>
            <button type="button" onclick="switchOption('reel', 'bridge')" class="dock-btn" data-opt-key="reel" data-opt-val="bridge">Міст</button>
            <button type="button" onclick="switchOption('reel', 'engine')" class="dock-btn" data-opt-key="reel" data-opt-val="engine">V12 Двигун</button>
            <button type="button" onclick="switchOption('reel', 'pcb')" class="dock-btn" data-opt-key="reel" data-opt-val="pcb">Плата PCB</button>
            <button type="button" onclick="switchOption('reel', 'rocket')" class="dock-btn" data-opt-key="reel" data-opt-val="rocket">Двигун F-1</button>
            <button type="button" onclick="switchOption('reel', 'telescope')" class="dock-btn" data-opt-key="reel" data-opt-val="telescope">Габбл</button>
        </div>

        <!-- Themes selector -->
        <div class="dock-group">
            <span class="dock-label">Тема:</span>
            <button type="button" onclick="switchOption('theme', 'paper')" class="dock-btn active" data-opt-key="theme" data-opt-val="paper">Папір</button>
            <button type="button" onclick="switchOption('theme', 'blueprint')" class="dock-btn" data-opt-key="theme" data-opt-val="blueprint">Blueprint CAD</button>
            <button type="button" onclick="switchOption('theme', 'noir')" class="dock-btn" data-opt-key="theme" data-opt-val="noir">Нуар</button>
            <button type="button" onclick="switchOption('theme', 'graphite')" class="dock-btn" data-opt-key="theme" data-opt-val="graphite">Графіт</button>
            <button type="button" onclick="switchOption('theme', 'sketch')" class="dock-btn" data-opt-key="theme" data-opt-val="sketch">Скетч</button>
        </div>

        <!-- Speed selector -->
        <div class="dock-group">
            <span class="dock-label">Темп:</span>
            <button type="button" onclick="switchOption('tempo', 'calm')" class="dock-btn" data-opt-key="tempo" data-opt-val="calm">Спокійний</button>
            <button type="button" onclick="switchOption('tempo', 'normal')" class="dock-btn active" data-opt-key="tempo" data-opt-val="normal">Нормальний</button>
            <button type="button" onclick="switchOption('tempo', 'brisk')" class="dock-btn" data-opt-key="tempo" data-opt-val="brisk">Швидкий</button>
        </div>

    </div>

</body>
</html>

