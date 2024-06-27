<?php



/* @var $this \yii\web\View */
/* @var $title  */
/* @var $url */
/* @var $category */

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

?>
<?php if ($url !== 'site/index'):?>

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= $title ?></h1>
                <?php
                echo Breadcrumbs::widget(
                    [
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'tag' => 'div',
                        'itemTemplate'=>"<p class=\"m-0\">{link}</p>\n<p class=\"m-0 px-2\">-</p>\n",
                        'activeItemTemplate'=>"<p class=\"m-0\">{link}</p>\n",
                        'options' => [
                            'class' => 'd-inline-flex'
                        ]
                    ]
                );
                ?>
        </div>
    </div>
    <!-- Page Header End -->
<?php
endif; ?>