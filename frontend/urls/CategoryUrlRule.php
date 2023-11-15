<?php


namespace frontend\urls;


use schedule\entities\Schedule\Category;
use schedule\readModels\Schedule\CategoryReadRepository;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\web\UrlNormalizerRedirectException;
use yii\web\UrlRuleInterface;

class CategoryUrlRule extends BaseObject implements UrlRuleInterface
{

    public $prefix = 'catalog';

    private $repository;

    public function __construct(CategoryReadRepository $repository, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
    }

    public function parseRequest($manager, $request)
    {
        if (preg_match('#^' . $this->prefix . '/(.*[a-z])$#is', $request->pathInfo, $matches)) {
            $path = $matches['1'];
            if (!$category = $this->repository->findBySlug($this->getPathSlug($path))) {
                return false;
            }
            if ($path != $this->getCategoryPath($category)) {
                throw new UrlNormalizerRedirectException(['schedule/catalog/category', 'id' => $category->id], 301);
            }
            return ['schedule/catalog/category', ['id' => $category->id]];
        }
        return false;
    }

    public function createUrl($manager, $route, $params)
    {
        if ($route == 'schedule/catalog/category') {
            if (empty($params['id'])) {
                throw new \InvalidArgumentException('Empty id.');
            }

            if (!$category = $this->repository->find($params['id'])) {
                throw new \InvalidArgumentException('Undefined id.');
            }

            $url = $this->prefix . '/' . $this->getCategoryPath($category);

            unset($params['id']);
            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '?' . $query;
            }

            return $url;
        }
        return false;
    }

    private function getPathSlug($path): string
    {
        $chunks = explode('/', $path);
        return end($chunks);
    }

    private function getCategoryPath(Category $category): string
    {
        $chunks = ArrayHelper::getColumn($category->getParents()->andWhere(['>', 'depth', 0])->all(), 'slug');
        $chunks[] = $category->slug;
        return implode('/', $chunks);
    }
}