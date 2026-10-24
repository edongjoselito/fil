<?php
$filipino_supervisors = array(
    array('name' => '', 'division' => 'SDO Davao City'),
    array('name' => '', 'division' => 'SDO Davao de Oro'),
    array('name' => '', 'division' => 'SDO Davao del Norte'),
    array('name' => '', 'division' => 'SDO Davao del Sur'),
    array('name' => '', 'division' => 'SDO Davao Occidental'),
    array('name' => 'Geraldine D. Burgos', 'division' => 'SDO Davao Oriental'),
    array('name' => '', 'division' => 'SDO Digos City'),
    array('name' => '', 'division' => 'SDO IGaCoS'),
    array('name' => '', 'division' => 'SDO City of Mati'),
    array('name' => '', 'division' => 'SDO Panabo City'),
    array('name' => '', 'division' => 'SDO Tagum City'),
);
?>
<!doctype html>
<html lang="fil">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b2d4d">
    <meta name="description" content="FILIPINO DATAHUB: datos ng pagkatuto sa Filipino bilang gabay sa mas makabuluhang pagtuturo at suporta sa bawat mag-aaral.">
    <title>FILIPINO DATAHUB | Wika · Panitikan · Kultura</title>
    <link rel="icon" href="<?= base_url('assets/images/favicon.ico'); ?>">
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            color: #1c3045;
            background: #f5f7fa;
            font-synthesis: none;
            --navy: #0b2d4d;
            --blue: #174f7e;
            --gold: #f2b632;
            --muted: #647487;
            --line: #dce4ec;
            --paper: #fff;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 92px;
        }

        body {
            min-width: 320px;
            margin: 0;
            background: #f5f7fa;
        }

        a {
            color: inherit;
        }

        .skip-link {
            position: absolute;
            z-index: 10;
            top: 8px;
            left: 8px;
            padding: 10px 14px;
            transform: translateY(-150%);
            border-radius: 6px;
            color: #fff;
            background: var(--navy);
        }

        .skip-link:focus {
            transform: translateY(0);
        }

        .topline {
            padding: 9px 5.2%;
            color: #eaf2f8;
            background: #082540;
            font-size: 12px;
            letter-spacing: .04em;
        }

        .site-header {
            position: relative;
            z-index: 2;
            display: flex;
            min-height: 90px;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            padding: 12px 5.2%;
            border-bottom: 1px solid #e6ebf0;
            background: var(--paper);
        }

        .brand {
            display: inline-flex;
            min-width: 250px;
            align-items: center;
            gap: 13px;
            color: var(--navy);
            text-decoration: none;
        }

        .brand img {
            display: block;
            width: 62px;
            height: 62px;
            object-fit: contain;
        }

        .brand-copy {
            display: grid;
            gap: 3px;
        }

        .brand-copy strong {
            font-size: 18px;
            letter-spacing: .025em;
        }

        .brand-copy span {
            color: #53718d;
            font-size: 11px;
            font-weight: 750;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .main-nav {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: clamp(16px, 2.2vw, 34px);
        }

        .main-nav a {
            color: #405267;
            font-size: 14px;
            font-weight: 650;
            text-decoration: none;
        }

        .main-nav a:hover {
            color: var(--blue);
        }

        .main-nav .nav-signin {
            padding: 12px 21px;
            border-radius: 8px;
            color: #fff;
            background: var(--blue);
        }

        .main-nav .nav-signin:hover {
            color: #fff;
            background: var(--navy);
        }

        .hero {
            position: relative;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(ellipse at 80% 10%, rgba(74, 126, 166, .38), transparent 38%),
                radial-gradient(circle at 82% 68%, rgba(255, 255, 255, .08) 1px, transparent 1.8px) 0 0 / 22px 22px,
                linear-gradient(118deg, #082540 0%, #103d65 58%, #24577e 100%);
        }

        .hero::after {
            position: absolute;
            top: -220px;
            right: -140px;
            width: 650px;
            height: 650px;
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 50%;
            box-shadow: 0 0 0 60px rgba(255, 255, 255, .025), 0 0 0 120px rgba(255, 255, 255, .02);
            content: "";
            pointer-events: none;
        }

        .hero-inner {
            position: relative;
            z-index: 1;
            display: grid;
            width: min(100% - 10.4%, 1340px);
            min-height: 610px;
            grid-template-columns: minmax(0, 1.05fr) minmax(360px, .95fr);
            align-items: center;
            gap: clamp(48px, 7vw, 110px);
            margin: 0 auto;
            padding: 70px 0 78px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            padding: 10px 16px;
            border: 1px solid rgba(212, 228, 242, .25);
            border-radius: 30px;
            color: #f8d16e;
            background: rgba(255, 255, 255, .07);
            font-size: 12px;
            font-weight: 750;
            letter-spacing: .15em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gold);
            content: "";
        }

        .hero h1 {
            max-width: 720px;
            margin: 27px 0 16px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(43px, 5.6vw, 76px);
            font-weight: 700;
            letter-spacing: -.04em;
            line-height: 1.02;
        }

        .hero h1 span {
            display: block;
            color: #ffd26a;
        }

        .hero-lead {
            max-width: 680px;
            margin: 0;
            color: #bcd3e6;
            font-size: clamp(16px, 1.45vw, 20px);
            font-weight: 750;
            letter-spacing: .06em;
            line-height: 1.55;
            text-transform: uppercase;
        }

        .hero-description {
            max-width: 680px;
            margin: 22px 0 0;
            color: #e1eaf2;
            font-size: 17px;
            line-height: 1.8;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 30px;
        }

        .button {
            display: inline-flex;
            min-height: 50px;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 13px 21px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 750;
            text-decoration: none;
            transition: background .18s ease, transform .18s ease;
        }

        .button:hover {
            transform: translateY(-2px);
        }

        .button-gold {
            color: #133653;
            background: #ffd064;
        }

        .button-gold:hover {
            background: #ffdc88;
        }

        .button-outline {
            border-color: rgba(219, 234, 246, .42);
            color: #fff;
            background: rgba(255, 255, 255, .04);
        }

        .button-outline:hover {
            background: rgba(255, 255, 255, .13);
        }

        .hero-note {
            margin: 24px 0 0;
            color: #bad0e1;
            font-size: 12px;
        }

        .hero-note::before {
            display: inline-block;
            width: 7px;
            height: 7px;
            margin: 0 9px 1px 0;
            border-radius: 50%;
            background: #8ccfae;
            content: "";
        }

        .insight-card {
            position: relative;
            padding: clamp(28px, 3.4vw, 48px);
            border: 1px solid rgba(235, 245, 255, .28);
            border-radius: 24px;
            background: linear-gradient(145deg, rgba(255, 255, 255, .14), rgba(255, 255, 255, .055));
            box-shadow: 0 28px 80px rgba(1, 20, 37, .25);
            backdrop-filter: blur(5px);
        }

        .insight-topline {
            display: flex;
            align-items: center;
            gap: 13px;
            margin: -78px 0 36px -74px;
            padding: 14px 17px;
            border-radius: 13px;
            color: #1d3348;
            background: #fff;
            box-shadow: 0 12px 30px rgba(4, 26, 45, .2);
        }

        .insight-symbol {
            display: grid;
            width: 45px;
            height: 45px;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 12px;
            color: #fff;
            background: var(--blue);
            font-size: 22px;
        }

        .insight-topline strong,
        .insight-topline span {
            display: block;
        }

        .insight-topline strong {
            font-size: 14px;
        }

        .insight-topline span {
            margin-top: 3px;
            color: var(--muted);
            font-size: 12px;
        }

        .insight-label {
            color: #f4cc6a;
            font-size: 12px;
            font-weight: 750;
            letter-spacing: .17em;
            text-transform: uppercase;
        }

        .insight-card h2 {
            max-width: 430px;
            margin: 18px 0 11px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(31px, 3.4vw, 46px);
            line-height: 1.12;
        }

        .insight-card > p {
            margin: 0;
            color: #d2dfeb;
            font-size: 15px;
            line-height: 1.7;
        }

        .cycle {
            display: grid;
            grid-template-columns: 1fr 20px 1fr 20px 1fr;
            align-items: center;
            gap: 7px;
            margin-top: 30px;
        }

        .cycle-step {
            min-height: 91px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 12px;
            border: 1px solid rgba(223, 237, 249, .28);
            border-radius: 12px;
            background: rgba(255, 255, 255, .06);
            text-align: center;
        }

        .cycle-step strong {
            margin-bottom: 7px;
            color: #ffd064;
            font-size: 11px;
            letter-spacing: .1em;
        }

        .cycle-step span {
            font-size: 12px;
            font-weight: 700;
        }

        .cycle-arrow {
            color: #b5cce0;
            text-align: center;
        }

        .insight-footer {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 23px;
            padding-top: 17px;
            border-top: 1px solid rgba(223, 237, 249, .2);
            color: #d0dfec;
            font-size: 12px;
        }

        .insight-footer strong {
            color: #fff;
        }

        .section {
            padding: 86px max(5.2%, calc((100% - 1340px) / 2));
        }

        .section-heading {
            max-width: 770px;
            margin: 0 auto 38px;
            text-align: center;
        }

        .section-kicker {
            margin: 0 0 11px;
            color: #a16d00;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .section-heading h2,
        .portal-copy h2 {
            margin: 0;
            color: var(--navy);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(30px, 3.7vw, 46px);
            letter-spacing: -.025em;
            line-height: 1.15;
        }

        .section-heading > p:last-child {
            margin: 15px 0 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.75;
        }

        .pillars {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .pillar {
            min-height: 220px;
            padding: 28px;
            border: 1px solid var(--line);
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 8px 28px rgba(19, 53, 82, .045);
        }

        .pillar-number {
            display: grid;
            width: 42px;
            height: 42px;
            margin-bottom: 21px;
            place-items: center;
            border-radius: 12px;
            color: #174f7e;
            background: #eaf2f8;
            font-size: 13px;
            font-weight: 800;
        }

        .pillar h3 {
            margin: 0 0 9px;
            color: var(--navy);
            font-size: 18px;
        }

        .pillar p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .process-section {
            background: #eaf0f5;
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0;
            max-width: 1150px;
            margin: 0 auto;
        }

        .process-item {
            position: relative;
            padding: 5px 34px 10px;
            text-align: center;
        }

        .process-item + .process-item::before {
            position: absolute;
            top: 28px;
            left: 0;
            height: 1px;
            width: 100%;
            background: #c7d4df;
            content: "";
        }

        .process-number {
            position: relative;
            z-index: 1;
            display: grid;
            width: 56px;
            height: 56px;
            margin: 0 auto 20px;
            place-items: center;
            border: 5px solid #eaf0f5;
            border-radius: 50%;
            color: #fff;
            background: var(--blue);
            box-shadow: 0 0 0 1px #b8c9d8;
            font-size: 13px;
            font-weight: 800;
        }

        .process-item h3 {
            margin: 0 0 9px;
            color: var(--navy);
            font-size: 17px;
        }

        .process-item p {
            max-width: 300px;
            margin: 0 auto;
            color: #586b7f;
            font-size: 14px;
            line-height: 1.7;
        }

        .governance-section {
            padding-top: 76px;
            padding-bottom: 76px;
            background: #fff;
        }

        .governance-panel {
            display: grid;
            grid-template-columns: .8fr 1.2fr;
            align-items: center;
            gap: 50px;
            max-width: 1120px;
            margin: 0 auto;
            padding: clamp(28px, 5vw, 58px);
            border-radius: 19px;
            color: #fff;
            background:
                radial-gradient(circle at 90% 10%, rgba(255, 255, 255, .1), transparent 25rem),
                var(--navy);
        }

        .governance-title .section-kicker {
            color: #ffd064;
        }

        .governance-title h2 {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(30px, 3.5vw, 43px);
            line-height: 1.15;
        }

        .governance-copy > p {
            margin: 0 0 19px;
            color: #d7e4ef;
            font-size: 15px;
            line-height: 1.8;
        }

        .role-list {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .role-list li {
            padding: 9px 12px;
            border: 1px solid rgba(226, 238, 249, .28);
            border-radius: 30px;
            color: #f2f6fa;
            background: rgba(255, 255, 255, .07);
            font-size: 12px;
            font-weight: 700;
        }

        .authors-section {
            background: #f5f7fa;
        }

        .authors-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .author-card {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 8px 28px rgba(19, 53, 82, .06);
            text-align: center;
        }

        .author-photo-placeholder {
            position: relative;
            display: grid;
            min-height: 185px;
            place-items: center;
            overflow: hidden;
            background:
                radial-gradient(circle at 50% 42%, rgba(255, 255, 255, .78), transparent 31%),
                linear-gradient(145deg, #e7eef5, #d4e0eb);
        }

        .author-photo-placeholder::before {
            position: absolute;
            top: 38px;
            width: 62px;
            height: 62px;
            border: 5px solid rgba(23, 79, 126, .34);
            border-radius: 50%;
            background: rgba(255, 255, 255, .55);
            content: "";
        }

        .author-photo-placeholder::after {
            position: absolute;
            bottom: 14px;
            width: 130px;
            height: 76px;
            border: 5px solid rgba(23, 79, 126, .34);
            border-radius: 70px 70px 18px 18px;
            background: rgba(255, 255, 255, .55);
            content: "";
        }

        .author-photo-placeholder span {
            position: absolute;
            z-index: 1;
            right: 10px;
            bottom: 10px;
            padding: 6px 9px;
            border-radius: 6px;
            color: #174f7e;
            background: rgba(255, 255, 255, .92);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .author-info {
            min-height: 105px;
            padding: 18px 14px;
        }

        .author-info h3 {
            margin: 0;
            color: var(--navy);
            font-size: 15px;
            line-height: 1.45;
        }

        .author-info p {
            margin: 8px 0 0;
            color: #6d7e90;
            font-size: 11px;
            font-weight: 750;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .portal-section {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, 440px);
            align-items: center;
            gap: clamp(35px, 8vw, 110px);
            padding-top: 92px;
            padding-bottom: 92px;
            background:
                radial-gradient(ellipse at 15% 20%, rgba(242, 182, 50, .13), transparent 32rem),
                #f5f7fa;
        }

        .portal-copy {
            max-width: 610px;
        }

        .portal-copy > p:not(.section-kicker) {
            margin: 17px 0 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.8;
        }

        .portal-card {
            overflow: hidden;
            border: 1px solid #e0e6ed;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 18px 55px rgba(18, 52, 90, .12);
        }

        .flag-stripe {
            height: 6px;
            background: linear-gradient(to right, #0038a8 0 40%, #f0aa20 40% 60%, #ce1126 60% 100%);
        }

        .portal-content {
            padding: 30px 32px 32px;
        }

        .portal-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 21px;
        }

        .portal-brand img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .portal-brand strong,
        .portal-brand span {
            display: block;
        }

        .portal-brand strong {
            color: var(--navy);
            font-size: 13px;
            letter-spacing: .05em;
        }

        .portal-brand span {
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .portal-card h3 {
            margin: 0;
            color: var(--navy);
            font-size: 23px;
        }

        .portal-intro {
            margin: 7px 0 20px;
            color: var(--muted);
            font-size: 13px;
        }

        .alert {
            margin: 0 0 16px;
            padding: 11px 13px;
            border: 1px solid #f1c3c7;
            border-radius: 8px;
            color: #8d1b27;
            background: #fff4f4;
            font-size: 13px;
            line-height: 1.5;
        }

        .error {
            margin: -8px 0 14px;
            color: #a5222d;
            font-size: 13px;
        }

        .field {
            margin-bottom: 15px;
        }

        .field label {
            display: block;
            margin-bottom: 7px;
            color: #26384b;
            font-size: 13px;
            font-weight: 700;
        }

        .field input {
            width: 100%;
            min-height: 46px;
            padding: 10px 12px;
            border: 1px solid #cbd5df;
            border-radius: 8px;
            color: #1d2e40;
            background: #fff;
            font: inherit;
            font-size: 14px;
        }

        .field input:focus {
            border-color: #1e679f;
            outline: 3px solid rgba(30, 103, 159, .16);
        }

        .forgot {
            display: inline-block;
            margin: 1px 0 18px;
            color: #185487;
            font-size: 13px;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .submit {
            width: 100%;
            min-height: 47px;
            border: 0;
            border-radius: 8px;
            color: #fff;
            background: var(--navy);
            cursor: pointer;
            font: inherit;
            font-size: 14px;
            font-weight: 750;
        }

        .submit:hover {
            background: var(--blue);
        }

        .signup-note {
            margin: 16px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
            text-align: center;
        }

        .signup-note a {
            color: #185487;
            font-weight: 700;
            text-decoration: none;
        }

        .signup-note a:hover {
            text-decoration: underline;
        }

        :focus-visible {
            outline: 3px solid #f0aa20;
            outline-offset: 3px;
        }

        .site-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px 5.2%;
            color: #d8e4ee;
            background: #082540;
            font-size: 12px;
        }

        .site-footer p {
            margin: 0;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-links a {
            color: #eaf2f8;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 760px) {
            .site-header {
                gap: 14px;
                padding-right: 4%;
                padding-left: 4%;
            }

            .brand {
                min-width: auto;
            }

            .main-nav {
                gap: 14px;
            }

            .main-nav a {
                font-size: 12px;
            }

            .hero-inner {
                width: min(100% - 8%, 700px);
                grid-template-columns: 1fr;
                gap: 66px;
            }

            .insight-card {
                max-width: 600px;
                margin-left: auto;
            }

            .portal-section {
                grid-template-columns: 1fr minmax(320px, 400px);
                gap: 35px;
            }

            .authors-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            html {
                scroll-padding-top: 18px;
            }

            .topline {
                padding: 8px 5%;
                font-size: 10px;
            }

            .site-header {
                min-height: 72px;
                flex-wrap: wrap;
                padding: 9px 5%;
            }

            .brand img {
                width: 49px;
                height: 49px;
            }

            .brand-copy strong {
                font-size: 15px;
            }

            .brand-copy span {
                font-size: 9px;
            }

            .main-nav {
                width: 100%;
                justify-content: space-between;
                gap: 8px;
                padding: 5px 0 2px;
            }

            .main-nav a {
                font-size: 11px;
            }

            .main-nav .nav-signin {
                padding: 9px 12px;
            }

            .hero-inner {
                width: min(100% - 10%, 540px);
                min-height: auto;
                gap: 62px;
                padding: 58px 0 65px;
            }

            .eyebrow {
                padding: 9px 12px;
                font-size: 10px;
                letter-spacing: .1em;
            }

            .hero h1 {
                margin-top: 23px;
            }

            .hero-description {
                font-size: 15px;
            }

            .hero-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .button {
                width: 100%;
            }

            .insight-card {
                padding: 25px 21px;
            }

            .insight-topline {
                margin: -54px 0 26px -7px;
            }

            .insight-topline strong {
                font-size: 12px;
            }

            .cycle {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .cycle-step {
                min-height: 67px;
            }

            .cycle-arrow {
                transform: rotate(90deg);
            }

            .section {
                padding: 65px 5%;
            }

            .pillars,
            .process-grid,
            .authors-grid,
            .governance-panel,
            .portal-section {
                grid-template-columns: 1fr;
            }

            .pillar {
                min-height: auto;
            }

            .process-grid {
                gap: 29px;
            }

            .process-item + .process-item::before {
                display: none;
            }

            .governance-panel {
                gap: 22px;
            }

            .portal-section {
                gap: 30px;
            }

            .portal-card {
                width: 100%;
                max-width: 440px;
                margin: 0 auto;
            }

            .portal-content {
                padding: 25px 22px;
            }

            .site-footer {
                align-items: flex-start;
                flex-direction: column;
                padding: 22px 5%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>
<body>
    <a class="skip-link" href="#main-content">Lumaktaw sa pangunahing nilalaman</a>
    <div class="topline">Kagawaran ng Edukasyon <span aria-hidden="true">·</span> FILIPINO DATAHUB</div>

    <header class="site-header">
        <a class="brand" href="<?= base_url('homepage'); ?>" aria-label="FILIPINO DATAHUB home">
            <img src="<?= base_url('assets/images/filipino-data-hub-emblem-transparent.png'); ?>" alt="" width="1254" height="1254">
            <span class="brand-copy">
                <strong>FILIPINO DATAHUB</strong>
                <span>Wika · Panitikan · Kultura</span>
            </span>
        </a>
        <nav class="main-nav" aria-label="Pangunahing nabigasyon">
            <a href="#about">Tungkol</a>
            <a href="#process">Paraan</a>
            <a href="#governance">Pamamahala</a>
            <a href="#authors">Mga May-akda</a>
            <a class="nav-signin" href="#portal">Mag-sign in</a>
        </nav>
    </header>

    <main id="main-content">
        <section class="hero" aria-labelledby="hero-title">
            <div class="hero-inner">
                <div class="hero-copy">
                    <span class="eyebrow">Asignaturang Filipino · Pagsubaybay sa Pagkatuto</span>
                    <h1 id="hero-title">FILIPINO <span>DATAHUB</span></h1>
                    <p class="hero-lead">Datos ng pagkatuto, gabay sa mas makabuluhang pagtuturo.</p>
                    <p class="hero-description">Isang pinagsasaluhang sistema para sa mga Division Office na mag-encode ng pinagsama-samang datos sa pagkatuto, at para sa Regional Office na sumubaybay sa mga resulta at pangangailangan sa bawat dibisyon.</p>
                    <div class="hero-actions">
                        <a class="button button-gold" href="#about">Kilalanin ang Datahub <span aria-hidden="true">→</span></a>
                        <a class="button button-outline" href="#portal">Mag-sign in sa portal</a>
                    </div>
                    <p class="hero-note">Para sa awtorisadong Division at Regional Office accounts. Division users ang mag-e-encode ng summary; walang direktang school access.</p>
                </div>

                <aside class="insight-card" aria-label="Buod ng paraan ng paggamit ng datos">
                    <div class="insight-topline">
                        <span class="insight-symbol" aria-hidden="true">⌕</span>
                        <span><strong>Mga pangangailangan sa pagkatuto</strong><span>Batayan para sa nakatuong suporta</span></span>
                    </div>
                    <span class="insight-label">Pagkatutong nakasentro sa ebidensya</span>
                    <h2>Mula Datos Tungo sa Pagkilos</h2>
                    <p>Gamitin ang impormasyon sa pagkatuto upang makapagplano ng mas malinaw at angkop na tugon.</p>
                    <div class="cycle" aria-label="Tukuyin, unawain, at tumugon">
                        <div class="cycle-step"><strong>01</strong><span>Tukuyin</span></div>
                        <span class="cycle-arrow" aria-hidden="true">→</span>
                        <div class="cycle-step"><strong>02</strong><span>Unawain</span></div>
                        <span class="cycle-arrow" aria-hidden="true">→</span>
                        <div class="cycle-step"><strong>03</strong><span>Tumugon</span></div>
                    </div>
                    <div class="insight-footer"><span>Wika · Panitikan · Kultura</span><strong>Filipino Datahub</strong></div>
                </aside>
            </div>
        </section>

        <section class="section about-section" id="about" aria-labelledby="about-title">
            <div class="section-heading">
                <p class="section-kicker">Ano ang FILIPINO DATAHUB?</p>
                <h2 id="about-title">Mas malinaw na pagtingin sa pagkatuto sa Filipino</h2>
                <p>Tinutulungan ng Datahub ang mga paaralan at tagapangasiwa na pagsama-samahin ang mahahalagang impormasyon at gawing gabay ito sa pagpapabuti ng pagtuturo.</p>
            </div>
            <div class="pillars">
                <article class="pillar">
                    <span class="pillar-number" aria-hidden="true">01</span>
                    <h3>Subaybayan ang pag-unlad</h3>
                    <p>Itala at balikan ang mga resulta at progreso ng mga mag-aaral sa mga kasanayan sa asignaturang Filipino.</p>
                </article>
                <article class="pillar">
                    <span class="pillar-number" aria-hidden="true">02</span>
                    <h3>Unawain ang pangangailangan</h3>
                    <p>Tukuyin ang mga kasanayang nangangailangan ng higit na atensyon gamit ang datos ng pagkatuto.</p>
                </article>
                <article class="pillar">
                    <span class="pillar-number" aria-hidden="true">03</span>
                    <h3>Magplano ng suporta</h3>
                    <p>Gamitin ang mga natuklasan upang ituon ang mga interbensyon, pagsubaybay, at suportang panturo.</p>
                </article>
            </div>
        </section>

        <section class="section process-section" id="process" aria-labelledby="process-title">
            <div class="section-heading">
                <p class="section-kicker">Mula ebidensya tungo sa pag-unlad</p>
                <h2 id="process-title">Isang malinaw na siklo ng pagkilos</h2>
                <p>Pinag-uugnay ng sistema ang pagtatala, pag-unawa, at pagtugon upang manatiling nakatuon sa pangangailangan ng mga mag-aaral.</p>
            </div>
            <div class="process-grid">
                <article class="process-item">
                    <span class="process-number">01</span>
                    <h3>Itala ang ebidensya</h3>
                    <p>Ilagay ang kinakailangang impormasyon sa pagkatuto at mga kasanayan sa Filipino.</p>
                </article>
                <article class="process-item">
                    <span class="process-number">02</span>
                    <h3>Suriin ang mga pangangailangan</h3>
                    <p>Tingnan ang mga resulta upang maunawaan kung aling mga kasanayan ang nangangailangan ng suporta.</p>
                </article>
                <article class="process-item">
                    <span class="process-number">03</span>
                    <h3>Magbigay at sumubaybay ng suporta</h3>
                    <p>Magplano ng angkop na tugon at balikan ang progreso upang makita ang susunod na hakbang.</p>
                </article>
            </div>
        </section>

        <section class="section governance-section" id="governance" aria-labelledby="governance-title">
            <div class="governance-panel">
                <div class="governance-title">
                    <p class="section-kicker">Iisang layunin, magkakaugnay na antas</p>
                    <h2 id="governance-title">Sama-samang suporta para sa pagkatuto</h2>
                </div>
                <div class="governance-copy">
                    <p>Sinusuportahan ng FILIPINO DATAHUB ang koordinasyon mula paaralan hanggang sa mga antas ng pamamahala. Ang access sa impormasyon ay nakabatay sa tungkulin ng account upang makatulong sa angkop na pagsubaybay at pagpapasya.</p>
                    <ul class="role-list" aria-label="Mga antas na sinusuportahan">
                        <li>Paaralan</li>
                        <li>Distrito</li>
                        <li>Sangay</li>
                        <li>Rehiyon</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="section authors-section" id="authors" aria-labelledby="authors-title">
            <div class="section-heading">
                <p class="section-kicker">Mga May-akda</p>
                <h2 id="authors-title">Mga Filipino Supervisor ng 11 Schools Division Offices</h2>
            </div>
            <div class="authors-grid">
                <?php foreach ($filipino_supervisors as $supervisor) : ?>
                    <article class="author-card">
                        <div class="author-photo-placeholder" role="img" aria-label="Pansamantalang placeholder ng larawan para kay <?= html_escape($supervisor['name']); ?>">
                            <span>Larawan sa susunod</span>
                        </div>
                        <div class="author-info">
                            <h3><?= $supervisor['name'] !== '' ? html_escape($supervisor['name']) : 'Pangalan hindi pa naipasa'; ?></h3>
                            <p><?= html_escape($supervisor['division']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="section portal-section" id="portal" aria-labelledby="portal-title">
            <div class="portal-copy">
                <p class="section-kicker">Portal access</p>
                <h2>Handa nang magpatuloy?</h2>
                <p>Mag-sign in gamit ang iyong Division username o email at password upang buksan ang mga tool na nakatalaga sa iyong account.</p>
            </div>
            <div class="portal-card">
                <div class="flag-stripe" aria-hidden="true"></div>
                <div class="portal-content">
                    <div class="portal-brand">
                        <img src="<?= base_url('assets/images/filipino-data-hub-emblem-transparent.png'); ?>" alt="" width="1254" height="1254">
                        <span><strong>FILIPINO DATAHUB</strong><span>Wika · Panitikan · Kultura</span></span>
                    </div>
                    <h3 id="portal-title">Mag-sign in</h3>
                    <p class="portal-intro">Ilagay ang iyong account upang magpatuloy.</p>

                    <?php if (!empty($this->session->flashdata('failed'))) : ?>
                        <div class="alert" role="alert"><?= html_escape($this->session->flashdata('failed')); ?></div>
                    <?php endif; ?>
                    <?= validation_errors(); ?>

                    <?= form_open('log_in'); ?>
                        <div class="field">
                            <label for="username">Division username o email</label>
                            <input id="username" name="username" type="text" value="<?= html_escape(set_value('username')); ?>" autocomplete="username" required>
                        </div>
                        <div class="field">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required>
                        </div>
                        <a class="forgot" href="<?= base_url('Pages/forgot_password'); ?>">Nakalimutan ang password?</a>
                        <button class="submit" type="submit">Magpatuloy</button>
                    <?= form_close(); ?>
                    <p class="signup-note">Para sa account access, makipag-ugnayan sa iyong Division Office administrator.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; <?= date('Y'); ?> FILIPINO DATAHUB <span aria-hidden="true">·</span> Wika · Panitikan · Kultura</p>
        <nav class="footer-links" aria-label="Footer">
            <a href="#about">Tungkol</a>
            <a href="#process">Paraan</a>
            <a href="#authors">Mga May-akda</a>
            <a href="<?= base_url('Pages/data_privacy'); ?>">Data Privacy</a>
            <a href="#portal">Portal access</a>
        </nav>
    </footer>
</body>
</html>
