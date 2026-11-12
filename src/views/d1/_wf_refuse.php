<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\cms-dashboard
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

use open20\amos\core\forms\ActiveForm;
use open20\amos\core\forms\CloseSaveButtonWidget;
use open20\amos\core\forms\CreatedUpdatedWidget;
use open20\amos\sondaggi\AmosSondaggi;
use open20\amos\core\helpers\Html;
use open20\cms\dashboard\Module;
use open20\amos\core\forms\TextEditorWidget;
use open20\cms\dashboard\utilities\Utility;
use yii\helpers\ArrayHelper;
use open20\amos\core\views\AmosGridView;
use open20\amos\core\icons\AmosIcons;

$model->processed = 1;
$model->processed_by_user = \Yii::$app->user->id;
?>
<div class="dashboards-page-create">
    <div class="dashboards-page-form">
        <?php
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
        ?>
        <h3><?= $model->title ?></h3>
        <h4><?= Module::txt('Si è scelto di respingere la richiesta. Inserire qui di seguito la motivazione del respingimento che verrà inviato al richiedente. Finché non si preme invia la richiesta rimane pendente.') ?></h4>
        <div class="row">

            <div class="col-lg-12">
                <?=
                $form->field($model, 'message')->textArea(['rows' => 5])
                ?>
                <?= $form->field($model, 'processed', ['options' => ['style' => 'display:none;']])->hiddenInput()->label(false); ?>        
                <?= $form->field($model, 'processed_by_user', ['options' => ['style' => 'display:none;']])->hiddenInput()->label(false); ?>        

            </div>

        </div>

        <div class="clearfix"></div>
        <div class="col-xs-12 note_asterisk nop">
            <p><?= Module::txt('I campi <span class="red">*</span> sono obbligatori.') ?></p>
        </div>

        <?=
        CloseSaveButtonWidget::widget([
            'model' => $model,
            'buttonNewSaveLabel' => Module::txt('Invia'),
            'closeButtonLabel' => Module::txt('Chiudi'),
            'urlClose' => ['/' . \open20\cms\dashboard\Module::getModuleName() . '/d1/pagine'],
        ]);
        ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>