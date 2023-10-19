<?php


namespace schedule\entities\Schedule\queries;


use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
use NestedSetsQueryTrait;
}