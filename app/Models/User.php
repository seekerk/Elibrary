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

    public static function isExist($user)
    {
        $filter = [
            '$or' => [
                ['name' => $user['name']],
                ['email' => $user['email']]
            ]
        ];
        $user = self::findUser($filter);

        return !empty($user);
    }

    public static function findByName($name)
    {
        $filter = [
            'name' => $name
        ];

        return self::findUser($filter);
    }

    public static function findByID($id)
    {
        $filter = [
            '_id' => $id
        ];
        
        return self::findUser($filter);
    }

    private static function findUser($filter)
    {
        return self::$collection->findOne($filter);
    }
}
