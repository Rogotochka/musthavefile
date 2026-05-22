<?php
date_default_timezone_set('Europe/Moscow');

$serverInfo = [
    'PHP Version' => phpversion(),
    'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    'Server Name' => $_SERVER['SERVER_NAME'] ?? 'urtk.local',
    'Document Root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
    'Current Time' => date('d.m.Y H:i:s'),
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URTK.local — Радиоколледж</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #e2e8f0;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .hero {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        h1 {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 30px;
        }

        .status {
            display: inline-block;
            background: #16a34a;
            color: white;
            padding: 10px 18px;
            border-radius: 999px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background: rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .card h3 {
            margin-bottom: 15px;
            color: #60a5fa;
        }

        .server-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .server-info td {
            padding: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #94a3b8;
            font-size: 14px;
        }

        code {
            background: rgba(255,255,255,0.08);
            padding: 2px 6px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="hero">
        <h1>📻 URTK.local</h1>
        <p class="subtitle">
            Тестовая страница радиоколледжа для проверки PHP, Nginx и локального хоста
        </p>

        <div class="status">
            ✅ PHP успешно работает
        </div>

        <div class="grid">

            <div class="card">
                <h3>О сервере</h3>
                <p>
                    Если вы видите эту страницу — значит:
                </p>
                <br>
                <ul style="padding-left:20px; text-align:left;">
                    <li>Nginx отвечает</li>
                    <li>PHP обработчик подключён</li>
                    <li>Virtual Host работает</li>
                    <li><code>urtk.local</code> открывается</li>
                </ul>
            </div>

            <div class="card server-info">
                <h3>Информация PHP</h3>
                <table>
                    <?php foreach ($serverInfo as $key => $value): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($key) ?></strong></td>
                            <td><?= htmlspecialchars($value) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>

        <div style="margin-top:30px;">
            <form method="post">
                <button type="submit" name="check"
                    style="padding:12px 20px; border:none; border-radius:12px;
                    background:#2563eb; color:white; cursor:pointer; font-size:16px;">
                    Проверить POST-запрос
                </button>
            </form>

            <?php if (isset($_POST['check'])): ?>
                <div style="margin-top:20px; color:#4ade80; font-weight:bold;">
                    ✅ POST работает! PHP обработал форму.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        URTK.local • <?= date('Y') ?> • Test Environment
    </div>
</div>

</body>
</html>
