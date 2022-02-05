<?php

class AdminLogRepository
{
    public function Create(array $inputs)
    {
        AdminLog::query()->create([
            'access_token_id' => $inputs['access_token_id'],
            'url' => $inputs['url'],
            'ip' => $inputs['ip'],
            'method' => $inputs['method'],
            'user_agent' => $inputs['user_agent'],
        ]);
    }
}