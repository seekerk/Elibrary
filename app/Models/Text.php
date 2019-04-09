<?php

namespace App\Models;

use MongoDB\BSON\ObjectId;

class Text extends BaseModel
{
    public function findbyKeyWords($keywords)
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

        $res = $this->findTexts($filter, $options);

        return $res;
    }

    public function findbyID($id)
    {
        $filter = [
            '_id' => new ObjectId($id)
        ];

        $options = [
            'projection' => [
                'text' => 1,
            ]
        ];

        $text = $this->collection->findOne($filter, $options)["text"];
        
        return $text;
    }

    private function findTexts($filter, $options)
    {
        $res = [];

        $cursor = $this->collection->find($filter, $options);

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