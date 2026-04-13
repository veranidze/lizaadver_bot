<?php
// Конфигурация
$botToken = "8407528405:AAGFPx_yiSp2IYG3A-ZNA2_0t2efZBTs_wg";
$chatId = "5187725238"; // Куда придет отчет
$redirectUrl = "https://t.me/lizaadver_bot"; // Куда уйдет пользователь после сбора данных

// 1. Сбор данных из URL
$username = isset($_GET['user']) ? $_GET['user'] : 'unknown';
$chain = isset($_GET['chain']) ? $_GET['chain'] : 'not_specified';
$ip = $_SERVER['REMOTE_ADDR']; // Дополнительно: IP пользователя

// 2. Формирование сообщения
$message = "🔔 *Новый переход из Telegram*\n\n";
$message .= "👤 Пользователь: @$username\n";
$message .= "🔗 Цепочка: $chain\n";
$message .= "🌐 IP: $ip\n";
$message .= "⏰ Время: " . date("H:i:s d.m.Y");

// 3. Отправка данных в Telegram бот (через cURL)
$url = "https://api.telegram.org/bot$botToken/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
curl_close($ch);

// 4. Редирект пользователя
header("Location: $redirectUrl");
exit;
?>