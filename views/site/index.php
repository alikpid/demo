<?php

/** @var yii\web\View $this */

$this->title = 'Главная';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <?php
        if (Yii::$app->user->isGuest)
            echo '<h1 class="display-4">Для доступа авторизирутесь!</h1>';
        else
            echo '<h1 class="display-4">Здравствуйте, ' . Yii::$app->user->identity->username . '!</h1>';
        ?>

<!--        <p class="lead"></p>-->

    </div>

    <div class="body-content">

    </div>
</div>
