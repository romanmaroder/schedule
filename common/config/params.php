<?php
return [
    'adminEmail' => 'admin@example.com',
    //'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'user.passwordMinLength' => 8,
    'frontendHostInfo' => 'http://example.com',
    'backendHostInfo' => 'http://backend.example.com',
    'staticHostInfo' => 'http://static.example.com',
    'staticPath' => dirname(__DIR__, 2) . '/static',
];
