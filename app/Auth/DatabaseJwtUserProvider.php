<?php

namespace App\Auth;

use Illuminate\Auth\DatabaseUserProvider;

class DatabaseJwtUserProvider extends DatabaseUserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $user = $this->connection->table($this->table)->where('user_id', $identifier)->first();

        return $this->getGenericUser($user);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(#[\SensitiveParameter] array $credentials)
    {
        $query = $this->connection->table($this->table);

        foreach ($credentials as $key => $value) {
            if (str_contains($key, 'password')) {
                continue;
            }

            $query->where($key, $value);
        }

        $user = $query->first();

        return $this->getGenericUser($user);
    }

    /**
     * Get the generic user.
     *
     * @param  mixed  $user
     * @return \Illuminate\Auth\GenericUser|null
     */
    protected function getGenericUser($user)
    {
        if (! is_null($user)) {
            return new GenericJwtUser((array) $user);
        }

        return null;
    }
}
