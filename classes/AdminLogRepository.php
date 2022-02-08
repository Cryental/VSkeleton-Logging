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

    public function Find($log_id)
    {
        return AdminLog::query()->where('id', $log_id)->first();
    }

    public function FindAll($needle, $page, $limit)
    {
        $columns = [
            'id',
            'access_token_id',
            'url',
            'method',
            'ip',
            'user_agent',
            'created_at'
        ];

        $query = AdminLog::query();

        foreach ($columns as $column) {
            $query->orWhere("$column", 'LIKE', "%$needle%");
        }
        return $query->orderBy('created_at', 'DESC')
            ->get();
    }
}