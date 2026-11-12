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

/**
 * @var $form
 * @var $model
 * @var $menuQuery
 * @var $navItemRedirect
 */
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use open20\cms\dashboard\Module;


$hideInternal = '';
$hideExternal = 'display:none';
if($model->redirect_type == 2 ){
    $hideInternal = 'display:none';
    $hideExternal = '';
}
if(empty($model->redirect_target)){
    $model->redirect_target = '_self';
}
?>

<div class="row nop">
    <div class="col-md-12">
        <?= $form->field($model, 'redirect_target')->radioList([
                '_self' => 'Stessa finestra',
                '_blank' => 'Nuova finestra'
            ]
        )->inline(true); ?>
    </div>
</div>
<div class="row nop">
    <div class="col-md-12">
        <div class="col-md-6 nop">
            <?= $form->field($model, 'redirect_type')->widget(Select2::className(), [
                'data' => [
                    1 => "Pagina interna",
                    2 => "Pagina esterna",
                ],
                'options' => [
                    'id' => 'type_of_redirect-id'
                ]
            ]); ?>
        </div>
        <div style="<?= $hideExternal ?>" id="container-external-link" class="col-md-6">
            <?= $form->field($model, 'redirect_value')->textInput(); ?>
        </div>
        <div style="<?= $hideInternal?>" id="container-internal-link" class="col-md-6">
            <?= $form->field($model, 'redirect_value_item_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($menuQuery->all(), 'nav0', 'title', 'container'),
                'options' => ['multiple' => false, 'placeholder' => Module::txt('Nessuna'), 'id' => 'select-redirect-page'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'templateResult' => new \yii\web\JsExpression("function formatState (state) {                                
                                tree = state.text;    
                                    newTree = tree.replace(/\ \ /g, '&nbsp;&nbsp;&nbsp;');
                                    if(newTree == tree){
                                        return tree;
                                    } else {
                                    newTree = '<span class=\" d-flex \">' + tree.replace(/\ \ /g, '&nbsp;&nbsp;&nbsp;@') + '</span>';     
                                    var lastIndex = newTree.lastIndexOf('@');
                                    newTree = newTree.slice(0, lastIndex) + '<span class=\"mdi mdi-subdirectory-arrow-right m-r-10 \"></span>' + newTree.slice(lastIndex + 1);                           
                                    newTree = newTree.replace(/@/g, '&nbsp;&nbsp;&nbsp;')
                                    newTree2 = $(newTree);
                                    return newTree2;
                                }
                              }
                            "),
                ],
            ]) ?>
        </div>
    </div>
</div>
