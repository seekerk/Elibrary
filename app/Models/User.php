<?php

namespace App\Models;

class User
{
    static private $collection;

    public static function init($collection)
    {
        self::$collection = $collection;
    }

    public static function create($user)
    {
        self::$collection->insertOne($user);
    }

    public static function exist($user)
    {
        $filter = [
            '$or' => [
                ['name' => $user['name']],
                ['email' => $user['email']]
            ]
        ];
        $user = self::$collection->findOne($filter);

        return !empty($user);
    }
}
