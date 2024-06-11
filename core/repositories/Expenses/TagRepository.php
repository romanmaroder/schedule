<?php


namespace core\repositories\Expenses;



use core\entities\Expenses\Expenses\Tag;
use core\repositories\NotFoundException;

class TagRepository
{
    /**
     * @param $id
     * @return Tag
     */
    public function get($id): Tag
    {
        if (!$tag = Tag::findOne($id)) {
            throw new NotFoundException('Tag is not found.');
        }
        return $tag;
    }

    public function findByName($name): ?Tag
    {
        return Tag::findOne(['name' => $name]);
    }

    /**
     * @param Tag $tag
     * @throws \yii\db\Exception
     */
    public function save(Tag $tag): void
    {
        if (!$tag->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Tag $tag
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Tag $tag): void
    {
        if (!$tag->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}