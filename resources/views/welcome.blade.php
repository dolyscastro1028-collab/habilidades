@php
    // Datos reales del sistema
    $totalCursos      = \App\Models\Curso::count();
    $totalProfesores  = \App\Models\Profesor::count();
    $totalEstudiantes = \App\Models\Estudiante::count();

    $cursos = \App\Models\Curso::with(['profesor.user', 'tematica'])
        ->withCount(['estudiantes', 'lecciones'])
        ->latest()
        ->take(6)
        ->get();

    $acentos = ['pink', 'violet', 'magenta', 'lilac'];
    $iconos  = ['auto_stories', 'calculate', 'science', 'palette', 'code', 'translate', 'history_edu', 'psychology'];
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habilidades | Aprende y enseña lo que te apasiona</title>
    <meta name="description" content="Plataforma de cursos: los profesores publican su contenido y los estudiantes se inscriben para aprender.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,400;8..144,500;8..144,600;8..144,700;8..144,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,500,0..1,0" rel="stylesheet">

    <style>
        /* ============ Material 3 – tokens (tema oscuro rosa/violeta) ============ */
        :root {
            --md-primary: #ffb0cd;
            --md-on-primary: #5e1133;
            --md-primary-container: #7c2a4a;
            --md-on-primary-container: #ffd9e4;

            --md-secondary: #d7baff;
            --md-on-secondary: #42136f;
            --md-secondary-container: #5b2f8c;
            --md-on-secondary-container: #efdbff;

            --md-tertiary: #f6b2f2;
            --md-tertiary-container: #6f2b6c;

            --md-surface: #150f18;
            --md-surface-low: #1d1620;
            --md-surface-container: #231b26;
            --md-surface-high: #2d2431;
            --md-surface-highest: #382f3c;

            --md-on-surface: #eee0ea;
            --md-on-surface-variant: #d3c2cf;
            --md-outline: #9c8c99;
            --md-outline-variant: #4e4350;

            --elev-1: 0 1px 2px rgba(0,0,0,.30), 0 1px 3px 1px rgba(0,0,0,.15);
            --elev-2: 0 1px 2px rgba(0,0,0,.30), 0 2px 6px 2px rgba(0,0,0,.15);
            --elev-3: 0 4px 8px 3px rgba(0,0,0,.15), 0 1px 3px rgba(0,0,0,.30);
            --elev-5: 0 8px 12px 6px rgba(0,0,0,.15), 0 4px 4px rgba(0,0,0,.30);

            --ease: cubic-bezier(.2, 0, 0, 1);
            --radius-xl: 28px;
            --radius-l: 16px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Roboto Flex', system-ui, sans-serif;
            background: var(--md-surface);
            color: var(--md-on-surface);
            line-height: 1.5;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; }

        .material-symbols-rounded {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
            user-select: none;
        }
        .filled { font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24; }

        .container { width: min(1180px, 100% - 32px); margin-inline: auto; }

        /* Fondo ambiental */
        .bg-glow {
            position: fixed; inset: 0; z-index: -1; pointer-events: none;
            background:
                radial-gradient(600px 400px at 10% 0%, rgba(236, 72, 153, .22), transparent 60%),
                radial-gradient(700px 500px at 95% 15%, rgba(147, 51, 234, .22), transparent 60%),
                radial-gradient(600px 500px at 50% 110%, rgba(192, 38, 211, .16), transparent 60%);
        }

        /* ============ Botones Material ============ */
        .btn {
            position: relative; overflow: hidden;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            height: 48px; padding: 0 24px;
            border: none; border-radius: 100px;
            font: 600 15px/1 'Roboto Flex', sans-serif; letter-spacing: .1px;
            cursor: pointer; white-space: nowrap;
            transition: box-shadow .2s var(--ease), transform .2s var(--ease);
        }
        .btn::before {               /* state layer */
            content: ""; position: absolute; inset: 0;
            background: currentColor; opacity: 0;
            transition: opacity .2s var(--ease);
        }
        .btn:hover::before { opacity: .08; }
        .btn:focus-visible { outline: 2px solid var(--md-secondary); outline-offset: 2px; }
        .btn:active { transform: scale(.98); }
        .btn .material-symbols-rounded { font-size: 20px; }

        .btn-filled { background: var(--md-primary); color: var(--md-on-primary); }
        .btn-filled:hover { box-shadow: var(--elev-1); }
        .btn-tonal { background: var(--md-secondary-container); color: var(--md-on-secondary-container); }
        .btn-tonal:hover { box-shadow: var(--elev-1); }
        .btn-outlined { background: transparent; color: var(--md-primary); border: 1px solid var(--md-outline); }
        .btn-text { background: transparent; color: var(--md-primary); padding: 0 14px; }
        .btn-sm { height: 40px; padding: 0 18px; font-size: 14px; }
        .btn-lg { height: 56px; padding: 0 28px; font-size: 16px; }

        .ripple {
            position: absolute; border-radius: 50%;
            background: currentColor; opacity: .25;
            transform: scale(0); pointer-events: none;
            animation: ripple .6s var(--ease) forwards;
        }
        @keyframes ripple { to { transform: scale(4); opacity: 0; } }

        .icon-btn {
            position: relative; overflow: hidden;
            width: 40px; height: 40px; border-radius: 50%;
            display: grid; place-items: center;
            background: transparent; border: none; color: var(--md-on-surface-variant); cursor: pointer;
        }
        .icon-btn::before { content: ""; position: absolute; inset: 0; background: currentColor; opacity: 0; transition: opacity .2s; }
        .icon-btn:hover::before { opacity: .08; }

        /* ============ Top app bar ============ */
        .topbar {
            position: sticky; top: 0; z-index: 50;
            transition: background .3s var(--ease), box-shadow .3s var(--ease);
        }
        .topbar.scrolled {
            background: rgba(29, 22, 32, .85);
            backdrop-filter: blur(16px);
            box-shadow: var(--elev-2);
        }
        .topbar .container { display: flex; align-items: center; justify-content: space-between; height: 72px; gap: 16px; }

        .brand { display: flex; align-items: center; gap: 12px; font-weight: 800; font-size: 21px; letter-spacing: -.4px; }
        .brand-mark {
            width: 42px; height: 42px; border-radius: 14px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, #ec4899, #9333ea);
            color: #fff; box-shadow: 0 6px 20px rgba(236, 72, 153, .35);
        }
        .brand-mark .material-symbols-rounded { font-size: 24px; }
        .brand b { color: var(--md-primary); font-weight: 800; }

        .nav { display: flex; align-items: center; gap: 4px; }
        .nav-link {
            position: relative; padding: 10px 16px; border-radius: 100px;
            font-size: 14px; font-weight: 500; color: var(--md-on-surface-variant);
            transition: color .2s, background .2s;
        }
        .nav-link:hover { color: var(--md-on-surface); background: rgba(238, 224, 234, .06); }

        /* Menú desplegable */
        .menu-wrap { position: relative; }
        .menu {
            position: absolute; right: 0; top: calc(100% + 8px);
            min-width: 260px; padding: 8px 0;
            background: var(--md-surface-high); border-radius: 12px; box-shadow: var(--elev-3);
            opacity: 0; transform: translateY(-8px) scale(.97); transform-origin: top right;
            pointer-events: none; transition: opacity .18s var(--ease), transform .18s var(--ease);
        }
        .menu.open { opacity: 1; transform: none; pointer-events: auto; }
        .menu a { display: flex; align-items: center; gap: 14px; padding: 12px 16px; font-size: 14px; }
        .menu a:hover { background: rgba(238, 224, 234, .08); }
        .menu a .material-symbols-rounded { color: var(--md-on-surface-variant); }
        .menu small { display: block; color: var(--md-on-surface-variant); font-size: 12px; }
        .menu hr { border: none; border-top: 1px solid var(--md-outline-variant); margin: 6px 0; }

        /* ============ Hero ============ */
        .hero { padding: 56px 0 88px; }
        .hero .container { display: grid; grid-template-columns: 1.1fr .9fr; gap: 56px; align-items: center; }

        .chip {
            display: inline-flex; align-items: center; gap: 8px;
            height: 32px; padding: 0 14px 0 10px; border-radius: 8px;
            border: 1px solid var(--md-outline-variant);
            font-size: 13px; font-weight: 500; color: var(--md-on-surface-variant);
            background: rgba(45, 36, 49, .6);
        }
        .chip .material-symbols-rounded { font-size: 18px; color: var(--md-primary); }

        .hero h1 {
            margin: 22px 0 18px;
            font-size: clamp(38px, 5.4vw, 64px); line-height: 1.05; font-weight: 800; letter-spacing: -1.6px;
        }
        .grad {
            background: linear-gradient(90deg, #ffb0cd, #f6b2f2 40%, #d7baff);
            -webkit-background-clip: text; background-clip: text; color: transparent;
        }
        .hero p.lead { font-size: 18px; color: var(--md-on-surface-variant); max-width: 540px; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 32px; }
        .hero-note { display: flex; align-items: center; gap: 8px; margin-top: 22px; font-size: 13px; color: var(--md-on-surface-variant); }
        .hero-note .material-symbols-rounded { font-size: 18px; color: #86efac; }

        /* Maqueta visual del hero */
        .mock { position: relative; height: 470px; }
        .mock-card {
            position: absolute; background: var(--md-surface-container);
            border-radius: var(--radius-xl); box-shadow: var(--elev-5);
            border: 1px solid rgba(255, 255, 255, .06);
        }
        .mock-main { inset: 20px 30px 60px 10px; padding: 22px; animation: floaty 7s ease-in-out infinite; }
        .mock-cover {
            height: 150px; border-radius: 20px; position: relative; overflow: hidden;
            background: linear-gradient(135deg, #ec4899, #9333ea);
            display: flex; align-items: flex-end; padding: 18px;
        }
        .mock-cover::after {
            content: ""; position: absolute; width: 220px; height: 220px; border-radius: 50%;
            right: -60px; top: -90px; background: rgba(255, 255, 255, .14);
        }
        .mock-cover .material-symbols-rounded { position: absolute; right: 24px; bottom: 18px; font-size: 64px; color: rgba(255, 255, 255, .85); }
        .mock-cover span.tag {
            position: relative; z-index: 1;
            background: rgba(0, 0, 0, .25); backdrop-filter: blur(6px);
            padding: 6px 12px; border-radius: 100px; font-size: 12px; font-weight: 600;
        }
        .mock-title { margin: 18px 0 4px; font-size: 20px; font-weight: 700; }
        .mock-sub { font-size: 13px; color: var(--md-on-surface-variant); }
        .mock-progress { margin: 18px 0 8px; height: 6px; border-radius: 10px; background: var(--md-surface-highest); overflow: hidden; }
        .mock-progress i { display: block; height: 100%; width: 0; border-radius: inherit; background: linear-gradient(90deg, var(--md-primary), var(--md-secondary)); animation: fill 2.2s .6s var(--ease) forwards; }
        @keyframes fill { to { width: 68%; } }
        .mock-row { display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: var(--md-on-surface-variant); }
        .lessons { margin-top: 16px; display: grid; gap: 8px; }
        .lesson { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 14px; background: var(--md-surface-high); font-size: 13px; }
        .lesson .material-symbols-rounded { font-size: 20px; color: var(--md-primary); }
        .lesson.done .material-symbols-rounded { color: #86efac; }

        .mock-avatars {
            right: 0; top: 0; padding: 14px 16px; display: flex; align-items: center; gap: 10px;
            animation: floaty 6s -2s ease-in-out infinite;
        }
        .avatars { display: flex; }
        .avatars span {
            width: 32px; height: 32px; border-radius: 50%; border: 2px solid var(--md-surface-container);
            display: grid; place-items: center; font-size: 12px; font-weight: 700; margin-left: -8px;
        }
        .avatars span:first-child { margin-left: 0; }
        .mock-avatars b { font-size: 13px; }
        .mock-avatars small { display: block; font-size: 11px; color: var(--md-on-surface-variant); font-weight: 400; }

        .snackbar {
            position: absolute; left: 0; bottom: 0;
            display: flex; align-items: center; gap: 12px; padding: 14px 18px;
            background: var(--md-on-surface); color: #2b232d;
            border-radius: 12px; box-shadow: var(--elev-3); font-size: 14px; font-weight: 500;
            animation: snack 6s 1.2s var(--ease) infinite;
            opacity: 0;
        }
        .snackbar .material-symbols-rounded { color: #b0186a; }
        @keyframes snack {
            0% { opacity: 0; transform: translateY(16px); }
            8%, 70% { opacity: 1; transform: none; }
            80%, 100% { opacity: 0; transform: translateY(16px); }
        }
        @keyframes floaty { 50% { transform: translateY(-10px); } }

        /* ============ Estadísticas ============ */
        .stats { margin-top: -24px; }
        .stats-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            background: var(--md-surface-low); border-radius: var(--radius-xl);
            border: 1px solid rgba(255, 255, 255, .05); overflow: hidden;
        }
        .stat { display: flex; align-items: center; gap: 18px; padding: 28px 32px; }
        .stat + .stat { border-left: 1px solid var(--md-outline-variant); }
        .stat-icon { width: 56px; height: 56px; border-radius: 16px; display: grid; place-items: center; flex-shrink: 0; }
        .stat-icon .material-symbols-rounded { font-size: 28px; }
        .stat strong { display: block; font-size: 34px; font-weight: 800; line-height: 1; letter-spacing: -1px; }
        .stat span.lbl { font-size: 14px; color: var(--md-on-surface-variant); }

        /* ============ Secciones ============ */
        section { padding: 96px 0; }
        .section-head { text-align: center; max-width: 640px; margin: 0 auto 52px; }
        .overline { font-size: 13px; font-weight: 700; letter-spacing: 1.4px; text-transform: uppercase; color: var(--md-primary); }
        .section-head h2 { margin: 10px 0 12px; font-size: clamp(30px, 4vw, 44px); font-weight: 800; letter-spacing: -1px; line-height: 1.1; }
        .section-head p { color: var(--md-on-surface-variant); font-size: 17px; }

        /* Tarjetas de rol */
        .roles { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .role {
            position: relative; overflow: hidden; padding: 36px;
            border-radius: var(--radius-xl); background: var(--md-surface-container);
            border: 1px solid rgba(255, 255, 255, .06);
            transition: transform .3s var(--ease), box-shadow .3s var(--ease);
        }
        .role:hover { transform: translateY(-6px); box-shadow: var(--elev-5); }
        .role::after {
            content: ""; position: absolute; width: 300px; height: 300px; border-radius: 50%;
            right: -120px; top: -120px; opacity: .35; filter: blur(30px);
        }
        .role.est::after { background: #ec4899; }
        .role.prof::after { background: #9333ea; }
        .role > * { position: relative; z-index: 1; }
        .role-icon { width: 64px; height: 64px; border-radius: 20px; display: grid; place-items: center; margin-bottom: 22px; }
        .role.est .role-icon { background: var(--md-primary-container); color: var(--md-on-primary-container); }
        .role.prof .role-icon { background: var(--md-secondary-container); color: var(--md-on-secondary-container); }
        .role-icon .material-symbols-rounded { font-size: 32px; }
        .role h3 { font-size: 26px; font-weight: 800; letter-spacing: -.5px; margin-bottom: 8px; }
        .role > p { color: var(--md-on-surface-variant); margin-bottom: 22px; }
        .role ul { list-style: none; display: grid; gap: 12px; margin-bottom: 30px; }
        .role li { display: flex; gap: 12px; align-items: flex-start; font-size: 15px; }
        .role li .material-symbols-rounded { font-size: 20px; margin-top: 1px; }
        .role.est li .material-symbols-rounded { color: var(--md-primary); }
        .role.prof li .material-symbols-rounded { color: var(--md-secondary); }
        .role-actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .role.prof .btn-filled { background: var(--md-secondary); color: var(--md-on-secondary); }
        .role.prof .btn-text { color: var(--md-secondary); }

        /* Pasos */
        .steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; counter-reset: paso; position: relative; }
        .step {
            padding: 28px 24px; border-radius: 24px; background: var(--md-surface-low);
            border: 1px solid rgba(255, 255, 255, .05); position: relative;
        }
        .step-num {
            width: 44px; height: 44px; border-radius: 50%;
            display: grid; place-items: center; margin-bottom: 18px;
            background: var(--md-surface-highest); color: var(--md-primary); font-weight: 800;
        }
        .step h4 { font-size: 17px; font-weight: 700; margin-bottom: 6px; }
        .step p { font-size: 14px; color: var(--md-on-surface-variant); }
        .step .material-symbols-rounded.big { position: absolute; right: 20px; top: 26px; font-size: 30px; color: var(--md-outline-variant); }

        /* Cursos */
        .courses { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
        .course {
            display: flex; flex-direction: column;
            border-radius: 24px; overflow: hidden; background: var(--md-surface-container);
            border: 1px solid rgba(255, 255, 255, .05);
            transition: transform .3s var(--ease), box-shadow .3s var(--ease);
        }
        .course:hover { transform: translateY(-4px); box-shadow: var(--elev-3); }
        .course-cover { height: 120px; position: relative; overflow: hidden; display: flex; align-items: flex-end; padding: 16px; }
        .course-cover::after { content: ""; position: absolute; width: 180px; height: 180px; border-radius: 50%; right: -50px; top: -70px; background: rgba(255, 255, 255, .13); }
        .course-cover .material-symbols-rounded { position: absolute; right: 18px; bottom: 14px; font-size: 48px; color: rgba(255, 255, 255, .9); }
        .course-cover .tag { position: relative; z-index: 1; background: rgba(0, 0, 0, .25); padding: 5px 12px; border-radius: 100px; font-size: 12px; font-weight: 600; }
        .acc-pink    { background: linear-gradient(135deg, #ec4899, #be185d); }
        .acc-violet  { background: linear-gradient(135deg, #a855f7, #6d28d9); }
        .acc-magenta { background: linear-gradient(135deg, #d946ef, #9333ea); }
        .acc-lilac   { background: linear-gradient(135deg, #f472b6, #8b5cf6); }

        .course-body { padding: 20px; display: flex; flex-direction: column; gap: 6px; flex: 1; }
        .course-body h4 { font-size: 18px; font-weight: 700; }
        .course-prof { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--md-on-surface-variant); }
        .course-prof .avatar {
            width: 26px; height: 26px; border-radius: 50%;
            display: grid; place-items: center; font-size: 11px; font-weight: 700;
            background: var(--md-secondary-container); color: var(--md-on-secondary-container);
        }
        .course-meta { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
        .meta-chip {
            display: inline-flex; align-items: center; gap: 6px; height: 28px; padding: 0 10px;
            border-radius: 8px; background: var(--md-surface-high); font-size: 12px; color: var(--md-on-surface-variant);
        }
        .meta-chip .material-symbols-rounded { font-size: 16px; }
        .course-foot { padding: 0 20px 20px; }
        .course-foot .btn { width: 100%; }

        .empty {
            grid-column: 1 / -1; text-align: center; padding: 56px 24px;
            border: 1px dashed var(--md-outline-variant); border-radius: 24px; color: var(--md-on-surface-variant);
        }
        .empty .material-symbols-rounded { font-size: 48px; color: var(--md-primary); margin-bottom: 10px; }
        .empty h4 { color: var(--md-on-surface); font-size: 18px; margin-bottom: 6px; }

        /* CTA final */
        .cta {
            position: relative; overflow: hidden; text-align: center;
            padding: 64px 32px; border-radius: 36px;
            background: linear-gradient(135deg, #7c2a4a, #5b2f8c);
            box-shadow: var(--elev-3);
        }
        .cta::before, .cta::after { content: ""; position: absolute; border-radius: 50%; background: rgba(255, 255, 255, .08); }
        .cta::before { width: 340px; height: 340px; left: -120px; top: -160px; }
        .cta::after  { width: 260px; height: 260px; right: -80px; bottom: -140px; }
        .cta > * { position: relative; z-index: 1; }
        .cta h2 { font-size: clamp(28px, 4vw, 42px); font-weight: 800; letter-spacing: -1px; margin-bottom: 12px; }
        .cta p { color: #f3dbe9; max-width: 540px; margin: 0 auto 28px; font-size: 17px; }
        .cta .btn-filled { background: #fff; color: #5e1133; }
        .cta .btn-outlined { color: #fff; border-color: rgba(255, 255, 255, .5); }
        .cta-actions { display: flex; justify-content: center; flex-wrap: wrap; gap: 12px; }

        /* Footer */
        footer { padding: 40px 0 48px; border-top: 1px solid var(--md-outline-variant); margin-top: 40px; }
        footer .container { display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; }
        footer p { font-size: 13px; color: var(--md-on-surface-variant); }
        .foot-links { display: flex; gap: 6px; flex-wrap: wrap; }

        /* FAB (móvil) */
        .fab {
            position: fixed; right: 16px; bottom: 16px; z-index: 40;
            display: none; align-items: center; gap: 10px;
            height: 56px; padding: 0 20px; border-radius: 16px;
            background: var(--md-primary-container); color: var(--md-on-primary-container);
            font-weight: 700; font-size: 15px; box-shadow: var(--elev-3);
            overflow: hidden;
        }

        /* Animación al hacer scroll */
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s var(--ease), transform .7s var(--ease); }
        .reveal.visible { opacity: 1; transform: none; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            .reveal { opacity: 1; transform: none; }
            .snackbar { opacity: 1; }
            .mock-progress i { width: 68%; }
        }

        /* ============ Responsive ============ */
        @media (max-width: 1000px) {
            .hero .container { grid-template-columns: 1fr; gap: 40px; }
            .mock { height: 440px; max-width: 520px; width: 100%; margin: 0 auto; }
            .steps { grid-template-columns: 1fr 1fr; }
            .courses { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 760px) {
            .nav-link { display: none; }
            .hero { padding: 32px 0 72px; }
            .roles { grid-template-columns: 1fr; }
            .role { padding: 28px 24px; }
            .stats-grid { grid-template-columns: 1fr; }
            .stat + .stat { border-left: none; border-top: 1px solid var(--md-outline-variant); }
            .stat { padding: 22px 24px; }
            section { padding: 72px 0; }
            .fab { display: inline-flex; }
            .hero-actions .btn { flex: 1 1 100%; }
        }
        @media (max-width: 560px) {
            .steps, .courses { grid-template-columns: 1fr; }
            .mock { height: 420px; }
            .mock-main { inset: 50px 0 60px 0; }
            .mock-avatars { right: 8px; }
            .cta { padding: 48px 20px; border-radius: 28px; }
            .brand { font-size: 19px; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <!-- ============ Top app bar ============ -->
    <header class="topbar" id="topbar">
        <div class="container">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark"><span class="material-symbols-rounded filled">school</span></span>
                <span>Habili<b>dades</b></span>
            </a>

            <nav class="nav">
                <a href="#roles" class="nav-link">Para ti</a>
                <a href="#como-funciona" class="nav-link">Cómo funciona</a>
                <a href="#cursos" class="nav-link">Cursos</a>

                <div class="menu-wrap">
                    <button class="btn btn-tonal btn-sm" id="menuBtn" aria-haspopup="true" aria-expanded="false">
                        <span class="material-symbols-rounded">login</span> Ingresar
                    </button>
                    <div class="menu" id="menu" role="menu">
                        <a href="{{ url('/estudiante/login') }}" role="menuitem">
                            <span class="material-symbols-rounded">backpack</span>
                            <span>Soy estudiante<small>Ver mis cursos</small></span>
                        </a>
                        <a href="{{ url('/profesor/login') }}" role="menuitem">
                            <span class="material-symbols-rounded">co_present</span>
                            <span>Soy profesor<small>Gestionar mis cursos</small></span>
                        </a>
                        <hr>
                        <a href="{{ url('/admin/login') }}" role="menuitem">
                            <span class="material-symbols-rounded">admin_panel_settings</span>
                            <span>Administración</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- ============ Hero ============ -->
    <main>
        <div class="hero">
            <div class="container">
                <div class="reveal">
                    <span class="chip"><span class="material-symbols-rounded filled">auto_awesome</span> Inscripciones abiertas</span>
                    <h1>Aprende y enseña <span class="grad">lo que te apasiona</span></h1>
                    <p class="lead">
                        Un solo lugar donde los profesores publican sus cursos con módulos y lecciones,
                        y los estudiantes se inscriben para aprender a su ritmo.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ url('/estudiante/register') }}" class="btn btn-filled btn-lg">
                            <span class="material-symbols-rounded">person_add</span> Inscribirme como estudiante
                        </a>
                        <a href="{{ url('/profesor/login') }}" class="btn btn-outlined btn-lg">
                            <span class="material-symbols-rounded">co_present</span> Soy profesor
                        </a>
                    </div>
                    <p class="hero-note"><span class="material-symbols-rounded filled">verified</span> Registro gratis en menos de un minuto</p>
                </div>

                <!-- Maqueta visual -->
                <div class="mock reveal" aria-hidden="true">
                    <div class="mock-card mock-main">
                        <div class="mock-cover">
                            <span class="tag">Matemáticas</span>
                            <span class="material-symbols-rounded filled">calculate</span>
                        </div>
                        <div class="mock-title">Álgebra desde cero</div>
                        <div class="mock-sub">Prof. Carlos · 3 meses</div>
                        <div class="mock-progress"><i></i></div>
                        <div class="mock-row"><span>Tu progreso</span><span>8 de 12 lecciones</span></div>
                        <div class="lessons">
                            <div class="lesson done"><span class="material-symbols-rounded filled">check_circle</span> Ecuaciones lineales</div>
                            <div class="lesson"><span class="material-symbols-rounded filled">play_circle</span> Sistemas de ecuaciones</div>
                        </div>
                    </div>

                    <div class="mock-card mock-avatars">
                        <div class="avatars">
                            <span style="background:#ec4899">A</span>
                            <span style="background:#9333ea">J</span>
                            <span style="background:#d946ef">M</span>
                        </div>
                        <b>+{{ max($totalEstudiantes, 3) }}<small>estudiantes</small></b>
                    </div>

                    <div class="snackbar">
                        <span class="material-symbols-rounded filled">celebration</span>
                        Te inscribiste en Álgebra desde cero
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ Estadísticas en vivo ============ -->
        <div class="stats">
            <div class="container">
                <div class="stats-grid reveal">
                    <div class="stat">
                        <div class="stat-icon" style="background:var(--md-primary-container);color:var(--md-on-primary-container)">
                            <span class="material-symbols-rounded filled">menu_book</span>
                        </div>
                        <div><strong data-count="{{ $totalCursos }}">0</strong><span class="lbl">Cursos publicados</span></div>
                    </div>
                    <div class="stat">
                        <div class="stat-icon" style="background:var(--md-secondary-container);color:var(--md-on-secondary-container)">
                            <span class="material-symbols-rounded filled">co_present</span>
                        </div>
                        <div><strong data-count="{{ $totalProfesores }}">0</strong><span class="lbl">Profesores</span></div>
                    </div>
                    <div class="stat">
                        <div class="stat-icon" style="background:var(--md-tertiary-container);color:#ffd7f7">
                            <span class="material-symbols-rounded filled">groups</span>
                        </div>
                        <div><strong data-count="{{ $totalEstudiantes }}">0</strong><span class="lbl">Estudiantes inscritos</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ Roles ============ -->
        <section id="roles">
            <div class="container">
                <div class="section-head reveal">
                    <span class="overline">Elige tu camino</span>
                    <h2>¿Vienes a aprender o a enseñar?</h2>
                    <p>Cada rol tiene su propio espacio, pensado para lo que necesitas.</p>
                </div>

                <div class="roles">
                    <article class="role est reveal">
                        <div class="role-icon"><span class="material-symbols-rounded filled">backpack</span></div>
                        <h3>Soy estudiante</h3>
                        <p>Crea tu cuenta, explora los cursos y accede al contenido apenas te inscribas.</p>
                        <ul>
                            <li><span class="material-symbols-rounded filled">check_circle</span> Registro rápido con tu identificación</li>
                            <li><span class="material-symbols-rounded filled">check_circle</span> Inscríbete o retírate cuando quieras</li>
                            <li><span class="material-symbols-rounded filled">check_circle</span> Lecciones, videos y archivos en un solo lugar</li>
                        </ul>
                        <div class="role-actions">
                            <a href="{{ url('/estudiante/register') }}" class="btn btn-filled">
                                <span class="material-symbols-rounded">person_add</span> Crear mi cuenta
                            </a>
                            <a href="{{ url('/estudiante/login') }}" class="btn btn-text">Ya tengo cuenta</a>
                        </div>
                    </article>

                    <article class="role prof reveal">
                        <div class="role-icon"><span class="material-symbols-rounded filled">co_present</span></div>
                        <h3>Soy profesor</h3>
                        <p>Publica tus cursos, organiza el contenido y mira cuántos estudiantes se suman.</p>
                        <ul>
                            <li><span class="material-symbols-rounded filled">check_circle</span> Crea y edita tus propios cursos</li>
                            <li><span class="material-symbols-rounded filled">check_circle</span> Sube documentos, enlaces y videos</li>
                            <li><span class="material-symbols-rounded filled">check_circle</span> Ordena las lecciones arrastrándolas</li>
                            <li><span class="material-symbols-rounded filled">check_circle</span> Mira el progreso de cada estudiante</li>
                        </ul>
                        <div class="role-actions">
                            <a href="{{ url('/profesor/login') }}" class="btn btn-filled">
                                <span class="material-symbols-rounded">login</span> Entrar a mi panel
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- ============ Cómo funciona ============ -->
        <section id="como-funciona" style="padding-top:0">
            <div class="container">
                <div class="section-head reveal">
                    <span class="overline">Cómo funciona</span>
                    <h2>De cero a aprendiendo en 4 pasos</h2>
                </div>
                <div class="steps">
                    <div class="step reveal">
                        <span class="material-symbols-rounded big">how_to_reg</span>
                        <div class="step-num">1</div>
                        <h4>Regístrate</h4>
                        <p>Crea tu cuenta de estudiante con tus datos básicos.</p>
                    </div>
                    <div class="step reveal">
                        <span class="material-symbols-rounded big">travel_explore</span>
                        <div class="step-num">2</div>
                        <h4>Explora</h4>
                        <p>Revisa los cursos disponibles, su temática y su profesor.</p>
                    </div>
                    <div class="step reveal">
                        <span class="material-symbols-rounded big">add_task</span>
                        <div class="step-num">3</div>
                        <h4>Inscríbete</h4>
                        <p>Con un clic quedas inscrito en el curso que elijas.</p>
                    </div>
                    <div class="step reveal">
                        <span class="material-symbols-rounded big">auto_stories</span>
                        <div class="step-num">4</div>
                        <h4>Aprende</h4>
                        <p>Accede a las lecciones, videos y archivos del profesor.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ Cursos (datos reales) ============ -->
        <section id="cursos" style="padding-top:0">
            <div class="container">
                <div class="section-head reveal">
                    <span class="overline">Cursos</span>
                    <h2>Lo más reciente</h2>
                    <p>Estos son algunos de los cursos que ya puedes tomar.</p>
                </div>

                <div class="courses">
                    @forelse ($cursos as $curso)
                        @php
                            $acento = $acentos[$loop->index % count($acentos)];
                            $icono  = $iconos[$curso->id % count($iconos)];
                            $inicial = mb_strtoupper(mb_substr($curso->profesor->nombre ?? '?', 0, 1));
                        @endphp
                        <article class="course reveal">
                            <div class="course-cover acc-{{ $acento }}">
                                <span class="tag">{{ $curso->tematica?->nombre }}</span>
                                <span class="material-symbols-rounded filled">{{ $icono }}</span>
                            </div>
                            <div class="course-body">
                                <h4>{{ $curso->nombre }}</h4>
                                <div class="course-prof">
                                    <span class="avatar">{{ $inicial }}</span>
                                    {{ $curso->profesor->nombre ?? 'Sin profesor' }}
                                </div>
                                <div class="course-meta">
                                    <span class="meta-chip"><span class="material-symbols-rounded">schedule</span>{{ $curso->duracion }}</span>
                                    <span class="meta-chip"><span class="material-symbols-rounded">groups</span>{{ $curso->estudiantes_count }} inscritos</span>
                                    <span class="meta-chip"><span class="material-symbols-rounded">library_books</span>{{ $curso->lecciones_count }} lecciones</span>
                                </div>
                            </div>
                            <div class="course-foot">
                                <a href="{{ url('/estudiante/register') }}" class="btn btn-tonal btn-sm">
                                    <span class="material-symbols-rounded">add</span> Inscribirme
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="empty">
                            <span class="material-symbols-rounded filled">rocket_launch</span>
                            <h4>Muy pronto habrá cursos aquí</h4>
                            <p>Los profesores están preparando su contenido. Regístrate y sé de los primeros.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- ============ CTA final ============ -->
        <section style="padding-top:0">
            <div class="container">
                <div class="cta reveal">
                    <h2>Tu próxima habilidad empieza hoy</h2>
                    <p>Únete gratis y empieza a aprender con profesores que comparten lo que saben.</p>
                    <div class="cta-actions">
                        <a href="{{ url('/estudiante/register') }}" class="btn btn-filled btn-lg">
                            <span class="material-symbols-rounded">person_add</span> Crear cuenta de estudiante
                        </a>
                        <a href="{{ url('/profesor/login') }}" class="btn btn-outlined btn-lg">
                            <span class="material-symbols-rounded">co_present</span> Acceso profesores
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark"><span class="material-symbols-rounded filled">school</span></span>
                <span>Habili<b>dades</b></span>
            </a>
            <div class="foot-links">
                <a href="{{ url('/estudiante/login') }}" class="btn btn-text btn-sm">Estudiantes</a>
                <a href="{{ url('/profesor/login') }}" class="btn btn-text btn-sm">Profesores</a>
                <a href="{{ url('/admin/login') }}" class="btn btn-text btn-sm">Administración</a>
            </div>
            <p>© {{ date('Y') }} Habilidades. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- FAB móvil -->
    <a href="{{ url('/estudiante/register') }}" class="fab">
        <span class="material-symbols-rounded">person_add</span> Inscribirme
    </a>

    <script>
        // App bar con sombra al hacer scroll
        const topbar = document.getElementById('topbar');
        const onScroll = () => topbar.classList.toggle('scrolled', window.scrollY > 10);
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        // Menú "Ingresar"
        const menuBtn = document.getElementById('menuBtn');
        const menu = document.getElementById('menu');
        menuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const open = menu.classList.toggle('open');
            menuBtn.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', (e) => {
            if (!menu.contains(e.target)) {
                menu.classList.remove('open');
                menuBtn.setAttribute('aria-expanded', 'false');
            }
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') menu.classList.remove('open');
        });

        // Efecto ripple de Material
        document.querySelectorAll('.btn, .fab, .icon-btn').forEach((el) => {
            el.addEventListener('pointerdown', (e) => {
                const rect = el.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const r = document.createElement('span');
                r.className = 'ripple';
                r.style.width = r.style.height = size + 'px';
                r.style.left = (e.clientX - rect.left - size / 2) + 'px';
                r.style.top = (e.clientY - rect.top - size / 2) + 'px';
                el.appendChild(r);
                setTimeout(() => r.remove(), 650);
            });
        });

        // Contadores animados
        const animateCount = (el) => {
            const target = parseInt(el.dataset.count, 10) || 0;
            const duration = 1200;
            const start = performance.now();
            const step = (now) => {
                const p = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - p, 3);
                el.textContent = Math.round(target * eased).toLocaleString('es-CO');
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        };

        // Aparición al hacer scroll
        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('visible');
                entry.target.querySelectorAll('[data-count]').forEach(animateCount);
                io.unobserve(entry.target);
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.reveal').forEach((el, i) => {
            el.style.transitionDelay = (i % 4) * 70 + 'ms';
            io.observe(el);
        });
    </script>
</body>
</html>