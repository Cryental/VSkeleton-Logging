<?php

class SHA256Hasher
{
    public function info($hashedValue)
    {
        return password_get_info($hashedValue);
    }

    public function make($value, array $options = [])
    {
        $salt = $options['salt'] ?? '';

        return hash('sha256', $value.$salt);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        $salt = $options['salt'] ?? '';

        if (strlen($hashedValue) === 0) {
            return false;
        }

        return $hashedValue === hash('sha256', $value.$salt);
    }
}
