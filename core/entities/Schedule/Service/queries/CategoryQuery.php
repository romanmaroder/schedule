<?php


namespace core\entities\Schedule\Service\queries;


use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
use NestedSetsQueryTrait;
}