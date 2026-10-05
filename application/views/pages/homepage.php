<!doctype html>
<html lang="fil">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#12345a">
    <meta name="description" content="Mag-sign in sa Filipino learning portal.">
    <title>FILIPINO DATAHUB</title>
    <link rel="icon" href="<?= base_url('assets/images/favicon.ico'); ?>">
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            color: #1d2e40;
            background: #f4f6f8;
            font-synthesis: none;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 32px 18px;
            background:
                radial-gradient(ellipse at 15% 15%, rgba(240, 170, 32, .12), transparent 34rem),
                #f4f6f8;
        }

        .login-card {
            width: min(100%, 420px);
            overflow: hidden;
            border: 1px solid #e0e6ed;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 18px 55px rgba(18, 52, 90, .12);
        }

        .flag-stripe {
            height: 7px;
            background: linear-gradient(to right, #0038a8 0 40%, #f0aa20 40% 60%, #ce1126 60% 100%);
        }

        .card-content {
            padding: 34px 36px 30px;
        }

        .brand {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-logo {
            display: block;
            width: 160px;
            max-width: 100%;
            height: auto;
            margin: 0 auto;
        }

        .brand-name {
            margin: 0;
            color: #12345a;
            font-size: 14px;
            font-weight: 750;
            letter-spacing: .12em;
        }

        .brand-subtitle {
            margin: 2px 0 0;
            color: #657487;
            font-size: 12px;
        }

        h1 {
            margin: 0;
            color: #12345a;
            font-size: 26px;
            line-height: 1.25;
        }

        .intro {
            margin: 9px 0 24px;
            color: #657487;
            font-size: 14px;
        }

        .alert {
            margin: 0 0 18px;
            padding: 11px 13px;
            border: 1px solid #f1c3c7;
            border-radius: 8px;
            color: #8d1b27;
            background: #fff4f4;
            font-size: 13px;
        }

        .error {
            margin: -10px 0 14px;
            color: #a5222d;
            font-size: 13px;
        }

        .field {
            margin-bottom: 17px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #26384b;
            font-size: 13px;
            font-weight: 650;
        }

        input {
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

        input:focus {
            border-color: #1e679f;
            outline: 3px solid rgba(30, 103, 159, .16);
        }

        .forgot {
            display: inline-block;
            margin: 0 0 20px;
            color: #185487;
            font-size: 13px;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .submit {
            width: 100%;
            min-height: 46px;
            border: 0;
            border-radius: 8px;
            color: #fff;
            background: #12345a;
            cursor: pointer;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
        }

        .submit:hover {
            background: #185487;
        }

        .submit:focus-visible,
        .forgot:focus-visible {
            outline: 3px solid #f0aa20;
            outline-offset: 3px;
        }

        .footer {
            margin: 24px 0 0;
            color: #7a8794;
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .card-content {
                padding: 28px 23px 24px;
            }

            h1 {
                font-size: 23px;
            }
        }
    </style>
</head>
<body>
    <main class="login-card">
        <div class="flag-stripe" aria-hidden="true"></div>
        <div class="card-content">
            <header class="brand">
                <img class="brand-logo" src="<?= base_url('assets/images/filipino-data-hub-emblem.png'); ?>" alt="Filipino Data Hub" width="1254" height="1254">
                <p class="brand-subtitle">Wika · Panitikan · Kultura</p>
            </header>

            <h1>Mag-sign in</h1>
            <p class="intro">Ilagay ang iyong account upang magpatuloy.</p>

            <?php if (!empty($this->session->flashdata('failed'))) : ?>
                <div class="alert" role="alert"><?= html_escape($this->session->flashdata('failed')); ?></div>
            <?php endif; ?>
            <?= validation_errors(); ?>

            <?= form_open('log_in'); ?>
                <div class="field">
                    <label for="username">School ID, username, o email</label>
                    <input id="username" name="username" type="text" value="<?= html_escape(set_value('username')); ?>" autocomplete="username" required autofocus>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required>
                </div>
                <a class="forgot" href="<?= base_url('Pages/forgot_password'); ?>">Nakalimutan ang password?</a>
                <button class="submit" type="submit">Magpatuloy</button>
            <?= form_close(); ?>

        </div>
    </main>
</body>
</html>
