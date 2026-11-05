<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#171735">
    <title>Habilidades | Tu talento, tu espacio</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap");
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --white: #ffffff;
            --lavender: #c4b5fd;
            --blue: #60a5fa;
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            font-family: "Outfit", "Segoe UI", sans-serif;
            color: var(--white);
            background: linear-gradient(
                -45deg,
                #10132f,
                #29205e,
                #173c70,
                #59358a,
                #172554,
                #30205f
            );
            background-size: 400% 400%;
            animation: gradientMove 16s ease infinite;
        }

        /* Luces difuminadas en movimiento */
        .background-effects {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .orb {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.55;
            will-change: transform;
        }

        .orb-one {
            top: -130px;
            left: -100px;
            background: #7861ff;
            animation: floatOne 12s ease-in-out infinite alternate;
        }

        .orb-two {
            top: 25%;
            right: -150px;
            background: #268bff;
            animation: floatTwo 15s ease-in-out infinite alternate;
        }

        .orb-three {
            bottom: -200px;
            left: 25%;
            background: #a855f7;
            animation: floatThree 13s ease-in-out infinite alternate;
        }

        .orb-four {
            top: 55%;
            left: 5%;
            width: 250px;
            height: 250px;
            background: #3478f6;
            animation: floatTwo 18s ease-in-out infinite alternate;
        }

        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            padding: 28px 7%;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            animation: appear 1s ease both;
        }

        .logo {
            font-family: 'Space Grotesk', sans-serif;
            display: inline-block;
            font-size: clamp(34px, 5vw, 58px);
            font-weight: 900;
            letter-spacing: 3px;
            line-height: 1.2;
            text-transform: uppercase;
            background: linear-gradient(
                100deg,
                #ffffff 0%,
                #93c5fd 20%,
                #c4b5fd 45%,
                #818cf8 65%,
                #ffffff 85%,
                #60a5fa 100%
            );
            background-size: 300% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            filter: drop-shadow(0 0 9px rgba(96, 165, 250, .8))
                    drop-shadow(0 0 24px rgba(139, 92, 246, .65));
            animation: textGlow 5s linear infinite;
        }

        .logo span {
            color: inherit;
        }

        .nav-label {
            color: #e0e7ff;
            font-size: 14px;
            letter-spacing: 1px;
        }

        main {
            min-height: calc(100vh - 100px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 65px 0;
        }

        .content {
            width: 100%;
            max-width: 950px;
            text-align: center;
            animation: appear 1.2s ease both;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 11px 18px;
            margin-bottom: 28px;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 50px;
            background: rgba(255,255,255,.09);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            color: #e0e7ff;
            font-size: 13px;
            letter-spacing: 1.2px;
        }

        .tag-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #a5f3fc;
            box-shadow: 0 0 14px #60a5fa;
        }

        h1 {
            font-family: 'Space Grotesk', sans-serif;
            max-width: 850px;
            margin: 0 auto 22px;
            font-size: clamp(38px, 6vw, 72px);
            line-height: 1.12;
            letter-spacing: -2.5px;
            font-weight: 800;
        }

        h1 span {
            display: inline-block;
            background: linear-gradient(
                90deg,
                #c4b5fd,
                #93c5fd,
                #e9d5ff,
                #93c5fd
            );
            background-size: 250% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: textGlow 7s linear infinite;
        }

        .description {
            max-width: 620px;
            margin: 0 auto;
            color: #e0e7ff;
            font-size: 17px;
            line-height: 1.8;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
            max-width: 750px;
            margin: 48px auto 0;
        }

        .card {
            position: relative;
            overflow: hidden;
            padding: 30px 25px;
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 25px;
            background: rgba(255,255,255,.10);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 15px 45px rgba(8, 10, 45, .15);
            text-align: left;
            transition: transform .35s ease,
                        background .35s ease,
                        border-color .35s ease;
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: -120%;
            width: 70%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.10),
                transparent
            );
            transform: skewX(-20deg);
            transition: left .7s ease;
        }

        .card:hover {
            transform: translateY(-9px);
            background: rgba(255,255,255,.16);
            border-color: rgba(196,181,253,.75);
        }

        .card:hover::before {
            left: 150%;
        }

        .card-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 76px;
            height: 76px;
            margin-bottom: 24px;
            border: 1px solid rgba(255,255,255,.45);
            border-radius: 23px;
            font-size: 36px;
            box-shadow: 0 10px 30px rgba(0,0,0,.22);
            transition: transform .35s ease, border-radius .35s ease;
        }

        .professional-icon {
            background: linear-gradient(135deg, #6366f1, #a855f7);
        }

        .learner-icon {
            background: linear-gradient(135deg, #0284c7, #6366f1);
        }

        .card:hover .card-icon {
            transform: translateY(-5px) rotate(-5deg) scale(1.08);
            border-radius: 28px;
        }

        .card h2 {
            font-family: 'Space Grotesk', sans-serif;
            margin-bottom: 10px;
            font-size: 21px;
        }

        .card p {
            min-height: 48px;
            margin-bottom: 23px;
            color: #e0e7ff;
            font-size: 14px;
            line-height: 1.7;
        }

        .button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 9px;
            padding: 12px 18px;
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 12px;
            background: linear-gradient(
                110deg,
                #7164e8,
                #4388e8
            );
            color: white;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 5px 20px rgba(89, 100, 232, .2);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .button:hover {
            transform: translateY(-3px);
            box-shadow: 0 9px 27px rgba(110, 140, 255, .35);
        }

        footer {
            padding: 18px 0 10px;
            color: #d1d5f9;
            text-align: center;
            font-size: 12px;
            letter-spacing: .5px;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes floatOne {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(180px, 130px) scale(1.25); }
        }

        @keyframes floatTwo {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(-150px, 100px) scale(1.2); }
        }

        @keyframes floatThree {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(130px, -130px) scale(1.3); }
        }

        @keyframes textGlow {
            to { background-position: 250% center; }
        }

        @keyframes appear {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            .page { padding: 22px 5%; }
            .nav-label { font-size: 11px; }
            .logo {
            font-family: 'Space Grotesk', sans-serif; font-size: 23px; }
            main { padding: 55px 0 35px; }
            h1 {
            font-family: 'Space Grotesk', sans-serif; letter-spacing: -1.4px; }
            .description { font-size: 15px; }
            .cards { grid-template-columns: 1fr; margin-top: 35px; }
            .card { padding: 25px; }
            .card p { min-height: auto; }
            .orb { width: 280px; height: 280px; filter: blur(70px); }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>
<body>
    <div class="background-effects" aria-hidden="true">
        <div class="orb orb-one"></div>
        <div class="orb orb-two"></div>
        <div class="orb orb-three"></div>
        <div class="orb orb-four"></div>
    </div>

    <div class="page">
        <nav>
            <div class="logo">HABILIDADES<span>.</span></div>
            <div class="nav-label">APRENDE · COMPARTE · CRECE</div>
        </nav>

        <main>
            <section class="content">
                <div class="tag">
                    <span class="tag-dot"></span>
                    Tu talento tiene un lugar
                </div>

                <h1>
                    Descubre todo lo que puedes lograr con tus
                    <span>habilidades.</span>
                </h1>

                <p class="description">
                    Un espacio para descubrir lo que sabes hacer,
                    compartir tus talentos y encontrar nuevas oportunidades
                    para seguir creciendo.
                </p>

                <div class="cards">
                    <article class="card">
                        <div class="card-icon professional-icon">💼</div>
                        <h2>Soy profesional</h2>
                        <p>
                            Comparte tus conocimientos y muestra al mundo
                            las habilidades que te hacen especial.
                        </p>
                        <a class="button" href="{{ url('/registro/profesional') }}">
                            Compartir mi talento <span>→</span>
                        </a>
                    </article>

                    <article class="card">
                        <div class="card-icon learner-icon">🚀</div>
                        <h2>Quiero aprender</h2>
                        <p>
                            Explora nuevas habilidades, descubre tus intereses
                            y encuentra inspiración para aprender.
                        </p>
                        <a class="button" href="{{ url('/registro/aprendiz') }}">
                            Comenzar a aprender <span>→</span>
                        </a>
                    </article>
                </div>
            </section>
        </main>

        <footer>
            © {{ date('Y') }} Habilidades · Aprende, comparte y crece.
        </footer>
    </div>
</body>
</html>




