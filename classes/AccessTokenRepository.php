<?php

class AccessTokenRepository
{
    public function Create(array $inputs)
    {
        $hasher = new SHA256Hasher();

        return AccessToken::query()->create([
            'key'             => substr($inputs['key'], 0, 32),
            'secret'          => $hasher->make(substr($inputs['key'], 32), ['salt' => $inputs['salt']]),
            'secret_salt'     => $inputs['salt'],
            'permissions'     => $inputs['permissions'],
            'whitelist_range' => $inputs['whitelist_range'],
            'product_id'      => $inputs['product_id'],
        ]);
    }

    public function Find($token_id)
    {
        return AccessToken::query()->where('id', $token_id)->first();
    }

    public function Delete($token_id)
    {
        $toBeDeletedToken = $this->Find($token_id);

        if (!$toBeDeletedToken) {
            return null;
        }

        $toBeDeletedToken->delete();

        return [
            'result' => 'true',
        ];
    }

    public function AuthAccessToken($token)
    {
        $hasher = new SHA256Hasher();

        return AccessToken::query()->where('key', substr($token, 0, 32))
            ->get()->filter(function ($v) use ($hasher, $token) {
                return $hasher->check(substr($token, 32), $v->secret, ['salt' => $v->secret_salt]);
            })->first();
    }
}
