<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class UserLogRepository
{
    public function Create(array $inputs)
    {
        return UserLog::query()->create([
            'logging_access_token_id' => $inputs['logging_access_token_id'],
            'subscription_id' => $inputs['subscription_id'],
            'url' => $inputs['url'],
            'user_id' => $inputs['user_id'],
            'ip' => $inputs['ip'],
            'method' => $inputs['method'],
            'user_agent' => $inputs['user_agent'],
        ]);
    }

    public function Find($log_id)
    {
        return UserLog::query()->where('id', $log_id)->first();
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

        $columns = DB::schema('default')->getColumnListing('user_logs');

        $values = explode(':', $search, 2);
        $columnName = strtolower(trim($values[0]));

        if (!in_array($columnName, $columns)) {
            return null;
        }

        $searchValue = strtolower(trim($values[1]));

        return UserLog::query()
            ->where($values[0], 'LIKE', "%$searchValue%")
            ->orderBy('created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function FindSubscriptionLogs($user_id, $subscription_id, $search, $page, $limit)
    {
        //handle empty search
        if ($search === '') {
            $search = 'id:';
        }

        if (!str_contains($search, ':')) {
            return null;
        }

        $columns = DB::schema('default')->getColumnListing('user_logs');

        $values = explode(':', $search, 2);
        $columnName = strtolower(trim($values[0]));

        if (!in_array($columnName, $columns)) {
            return null;
        }

        $searchValue = strtolower(trim($values[1]));

        return UserLog::query()
            ->where('subscription_id', $subscription_id)
            ->where('user_id', $user_id)
            ->where($values[0], 'LIKE', "%$searchValue%")
            ->orderBy('created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function FindSubscriptionLogsCount($user_id, $subscription_id, $date): int
    {
        return UserLog::where('subscription_id', $subscription_id)
            ->where('user_id', $user_id)
            ->whereMonth('user_logs.created_at', $date->format('m'))
            ->whereYear('user_logs.created_at', $date->format('Y'))
            ->count();
    }

    public function FindSubscriptionUsages($user_id, $subscription_id, $date)
    {
        $specifiedDate = Carbon::parse($date);

        return UserLog::where('subscription_id', $subscription_id)
            ->where('user_id', $user_id)
            ->whereYear('created_at', $specifiedDate->format('Y'))
            ->whereMonth('created_at', $specifiedDate->format('m'))
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('j'); // grouping by days
            });
    }
}
