<?php

namespace App\Models;

class User extends BaseModel
{
    public function create($user)
    {
        $this->collection->insertOne($user);
    }

    public function exist($user)
    {
        $filter = [
            '$or' => [
                ['name' => $user['name']],
                ['email' => $user['email']]
            ]
        ];
        $user = $this->collection->findOne($filter);
        return !empty($user);
    }
}
