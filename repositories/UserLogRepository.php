<?php

use Carbon\Carbon;

class UserLogRepository
{
    public function Create(array $inputs)
    {
        return UserLog::query()->create([
            'logging_access_token_id' => $inputs['logging_access_token_id'],
            'subscription_id'         => $inputs['subscription_id'],
            'url'                     => $inputs['url'],
            'ip'                      => $inputs['ip'],
            'method'                  => $inputs['method'],
            'user_agent'              => $inputs['user_agent'],
        ]);
    }

    public function Find($log_id)
    {
        return UserLog::query()->where('id', $log_id)->first();
    }

    public function FindAll($needle, $page, $limit)
    {
        $columns = [
            'logging_access_token_id',
            'subscription_id',
            'url',
            'ip',
            'method',
            'user_agent',
        ];
        $query = UserLog::query();

        foreach ($columns as $column) {
            $query->orWhere("$column", 'LIKE', "%$needle%");
        }

        return $query->orderBy('created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function FindSubscriptionLogs($subscription_id, $needle, $page, $limit)
    {
        $columns = [
            'logging_access_token_id',
            'subscription_id',
            'url',
            'ip',
            'method',
            'user_agent',
        ];

        return UserLog::where('subscription_id', $subscription_id)->where(function ($query) use ($columns, $needle) {
            foreach ($columns as $column) {
                $query->orWhere("$column", 'LIKE', "%$needle%");
            }
        })->orderBy('user_logs.created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function FindSubscriptionLogsCount($subscription_id, $date): int
    {
        return UserLog::where('subscription_id', $subscription_id)
            ->whereMonth('user_logs.created_at', $date->format('m'))
            ->whereYear('user_logs.created_at', $date->format('Y'))
            ->count();
    }

    public function FindSubscriptionUsages($subscription_id, $date)
    {
        $specifiedDate = Carbon::parse($date);

        return UserLog::where('subscription_id', $subscription_id)
            ->whereYear('created_at', $specifiedDate->format('Y'))
            ->whereMonth('created_at', $specifiedDate->format('m'))
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('j'); // grouping by days
            });
    }
}
