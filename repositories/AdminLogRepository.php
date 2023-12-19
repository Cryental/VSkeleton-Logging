<?php

use Illuminate\Database\Capsule\Manager as DB;

class AdminLogRepository
{
    public function Create(array $inputs)
    {
        return AdminLog::query()->create([
            'id' => ULIDHelper::GetULID(),
            'logging_access_token_id' => $inputs['logging_access_token_id'],
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

    public function FindAll($search, $page, $limit)
    {
        //handle empty search
        if ($search === '') {
            $search = 'id:';
        }

        if (!str_contains($search, ':')) {
            return null;
        }

        $columns = DB::schema('default')->getColumnListing('admin_logs');

        $values = explode(':', $search, 2);
        $columnName = strtolower(trim($values[0]));

        if (!in_array($columnName, $columns)) {
            return null;
        }

        $searchValue = strtolower(trim($values[1]));

        return AdminLog::query()
            ->where($values[0], 'LIKE', "%$searchValue%")
            ->orderBy('created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);
    }
}
