<?php


namespace schedule\entities\Expenses\queries;


use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
use NestedSetsQueryTrait;
}