<?php

namespace App\Models;

use MongoDB\BSON\ObjectId;

class Text
{
    static private $collection;

    static public function init($collection)
    {
        self::$collection = $collection;
    }

    public static function findbyKeyWords($keywords)
    {
        $filter = [
            '$text' => [
                '$search' => $keywords,
            ]
        ];

        $options = [
            'projection' => [
                'meta.title' => 1,
                'meta.author' => 1,
                'bibl' => 1,
                'score' => [
                    '$meta' => 'textScore',
                ],
            ],

            'sort' => [
                'score' => [
                    '$meta' => 'textScore'
                ]
            ],
        ];

        $res = self::findTexts($filter, $options);

        return $res;
    }

    public static function findbyID($id)
    {
        $filter = [
            '_id' => new ObjectId($id)
        ];

        $options = [
            'projection' => [
                'text' => 1,
            ]
        ];

        $text = self::$collection->findOne($filter, $options)["text"];

        return $text;
    }

    private static function findTexts($filter, $options)
    {
        $res = [];

        $cursor = self::$collection->find($filter, $options);

        foreach ($cursor as $text) {
            $res[] = [
                'title' => $text['meta']['title'],
                'id' => $text['_id'],
                'author' => $text['meta']['author'][0]['family'],
                'bibl' => $text['bibl']
            ];
        };

        return $res;
    }
}
