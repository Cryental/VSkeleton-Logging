<?php

class AdminLogRepository
{
    public function Create(array $inputs)
    {
        return  AdminLog::query()->create([
            'logging_access_token_id' => $inputs['logging_access_token_id'],
            'access_token_id'         => $inputs['access_token_id'],
            'url'                     => $inputs['url'],
            'ip'                      => $inputs['ip'],
            'method'                  => $inputs['method'],
            'user_agent'              => $inputs['user_agent'],
        ]);
    }

    public function Find($log_id)
    {
        return AdminLog::query()->where('id', $log_id)->first();
    }

    public function FindAll($needle, $page, $limit)
    {
        $columns = [
            'logging_access_token_id',
            'access_token_id',
            'url',
            'ip',
            'method',
            'user_agent',
        ];

        $query = AdminLog::query();

        foreach ($columns as $column) {
            $query->orWhere("$column", 'LIKE', "%$needle%");
        }

        return $query->orderBy('created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page)->toArray();
    }
}
