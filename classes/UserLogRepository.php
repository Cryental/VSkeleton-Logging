<?php

class UserLogRepository
{
    public function Create(array $inputs)
    {
        UserLog::query()->create([
            'personal_token_id' => $inputs['personal_token_id'],
            'url' => $inputs['url'],
            'ip' => $inputs['ip'],
            'method' => $inputs['method'],
            'user_agent' => $inputs['user_agent'],
        ]);
    }
}