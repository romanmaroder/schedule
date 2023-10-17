<?php


namespace schedule\repositories\Schedule;


use schedule\entities\Schedule\Tag;
use schedule\repositories\NotFoundException;

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

    /**
     * @param Tag $tag
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