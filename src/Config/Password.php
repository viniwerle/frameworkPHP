<?php

namespace App\Config;

class Password
{
    public static function generateSalt($length = 22)
    {
        return base64_encode(random_bytes($length));
    }

    public static function hashPassword($password, $salt)
    {
        // Use o algoritmo BCRYPT (recomendado para senhas)
        $options = [
            'cost' => 12, // Ajuste o custo conforme necessário
        ];

        $hash = password_hash($password . $salt, PASSWORD_BCRYPT, $options);

        return $hash;
    }

    public static function verifyPassword($password, $storedHash, $storedSalt): bool
    {
        if (password_verify($password . $storedSalt, $storedHash)) {
            return true;
        }
        return false;
    }
}
