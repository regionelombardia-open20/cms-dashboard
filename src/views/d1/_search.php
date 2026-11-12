<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\community\views\community
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

use open20\cms\dashboard\Module;
use open20\amos\core\helpers\Html;
use kartik\widgets\Select2;
use open20\amos\core\forms\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var open20\amos\community\models\search\CommunitySearch $model
 * @var yii\widgets\ActiveForm $form
 */
$enableAutoOpenSearchPanel = false;
?>
<div class="pagine-search element-to-toggle" data-toggle-element="form-search">

    <?php
    $form = ActiveForm::begin([
        'action' => (isset($originAction) ? [$originAction] : ['pagine']),
        'method' => 'get',
        'id' => 'search-id_page',
    ]);

    echo Html::hiddenInput("enableSearch", $enableAutoOpenSearchPanel);
    ?>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'search')->textInput()->label(Module::txt('Titolo della pagina'))->hint(Module::txt('Inserisci il titolo della pagina da ricercare')); ?>
        </div>
        <div class="col-xs-4">
            <?= $form->field($model, 'status')->widget(Select2::className(), [
                'data' => [
                    1 => Module::txt('Bozza'),
                    2 => Module::txt('In richiesta di pubblicazione'),
                    3 => Module::txt('Pubblicato'),
                ],
                'options' => ['placeholder' => Module::txt('Seleziona...')]
            ])->label(Module::txt('Stato')) ?>
        </div>
        <div class="col-xs-4">
            <?= $form->field($model, 'type')->widget(Select2::className(), [
                'data' => \open20\cms\dashboard\utilities\Utility::getTipologie(),
                'options' => ['placeholder' => Module::txt('Seleziona...')]
            ])->label(Module::txt('Tipologia')) ?>
        </div>
        <div class="col-xs-4">
        <?php
        $creator = '';
        $updated_by = $model->updated_by;
        if (!empty($updated_by)) {
            $user = \luya\admin\models\User::findOne($updated_by);
            if($user){
                $creator =  $user->firstname. ' '.$user->lastname;
            }
        }
        echo $form->field($model, 'updated_by')->widget(Select2::className(), [
                'data' => (!empty($model->updated_by) ? [$model->updated_by => $creator] : []),
                'options' => ['placeholder' => \Yii::t('amosnews', 'Cerca ...')],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['/dashboards/d1/ajax-user-list']),
                        'dataType' => 'json',
                        'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }')
                    ],
                ],
            ]
        )->label(Module::txt('Aggiornato da'));

        echo \yii\helpers\Html::hiddenInput('container', \Yii::$app->request->get('container'));
        ?>

        </div>
        <div class="col-xs-12">
            <div class="pull-right">
                <?=
                Html::a(
                    Module::t('amospages', 'Annulla'),
                    [isset($cancelAction) ? $cancelAction : Yii::$app->controller->action->id, 'currentView' => Yii::$app->request->getQueryParam('currentView')],
                    ['class' => 'btn btn-secondary', 'title' => Module::t('amospages', '#cancel_search')]
                )
                ?>
                <?= Html::submitButton(Module::t('amospages', 'Cerca'), ['class' => 'btn btn-navigation-primary', 'title' => Module::t('amospages', 'Cerca tra le pagine')]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();
    ?>
</div>