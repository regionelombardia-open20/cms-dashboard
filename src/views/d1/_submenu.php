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
 * @var int $lvl
 * @var string $container
 * @var bool $canPublish
 * @var \yii\data\ActiveDataProvider $dataProvider
 */
use open20\amos\core\views\AmosGridView;
use open20\cms\dashboard\utilities\Utility;
use open20\cms\dashboard\Module;
use open20\amos\core\helpers\Html;
use open20\amos\core\icons\AmosIcons;

echo AmosGridView::widget([
    'dataProvider' => $dataProvider,
    'showHeader' => false,
    'showPageSummary' => false,
    // 'rowOptions' => function ($model) {
    //     if ($model['offline']) {
    //         return ['class' => 'danger'];
    //     }
    //     return '';
    // },
    'columns' => [
        //   ['class' => 'yii\grid\SerialColumn'],
//        [
//            'width' => '4%;',
//            'value' => function ($model) {
//                return '';
//            },
//        ],
        [
            'width' => '4%;',
            'class' => 'kartik\grid\ExpandRowColumn',
            'value' => function ($model, $key, $index) {
                $children = Utility::getAdminMenuLuya('default', $model['nav_id'], true);
                if ($children->count() > 0) {
                    return AmosGridView::ROW_COLLAPSED;
//                                   return AmosGridView::ROW_EXPANDED;
                }
                return '';
            },
            'extraData' => [
                'container' => $container,
                'canPublish' => $canPublish,
                'lvl' => ($lvl + 1)
            ],
            'detailUrl' => '/dashboards/d1/luya-admin-menu?view=_submenu',
            'disabled' => function ($model, $key, $index, $column) use ($container) {
                $children = Utility::getAdminMenuLuya($container, $model['nav_id'], true);

                if ($children->count() > 0) {
                    return false;
                }
                return true;
            },
            'expandOneOnly' => false,
            'detailRowCssClass' => '',
        //'options' => ['id' => 'exandrow' . $model['nav_id']]
        ],
        [
            'width' => '6%;',
            'attribute' => 'offline',
            'label' => Module::txt('Stato'),
            'value' => function ($model) {
                $statusOnline = Module::txt('Pubblicato');
                $statusOffline = Module::txt('Bozza');
                if ($model['offline']) {
                    return ('<span class="mdi mdi-cloud-off-outline mdi-24px text-muted" title="' . $statusOffline . '" data-toggle="tooltip"></span>');
                }
                return ('<span class="mdi mdi-cloud mdi-24px text-primary" title="' . $statusOnline . '" data-toggle="tooltip"></span>');
            },
            'format' => 'raw',
        ],
        [
            'width' => '50%;',
            'attribute' => 'title',
            'label' => Module::txt('Pagina'),
            'value' => function ($model) use ($lvl) {
//$spaces = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $lvl); //'<span class="mdi mdi-subdirectory-arrow-right"></span>';

                return '<div class="d-flex"><span class="mdi mdi-subdirectory-arrow-right m-r-10"></span><strong>' . $model['title'] . '</strong></div>';
            },
            'format' => 'html',
        ],
        [
            'width' => '15%;',
            'attribute' => 'hidden',
            'label' => Module::txt('Visibile nel menu'),
            'value' => function ($model) {
                return ($model['hidden'] ? Module::txt('No') : Module::txt('Si'));
            },
        ],
        [
            'width' => '6%;',
            'attribute' => 'ordina',
            'label' => 'Ordina',
            'value' => function ($model) use ($lvl) {
                return Html::a('<span class="mdi mdi-arrow-split-horizontal"></span>',
                        ['/' . Module::getModuleName() . '/d1/new-sort', 'id' => $model['nav_id'], 'lvl' => $lvl],
                        ['class' => 'btn btn-default',
                            'onclick' => 'newSortRows(' . $model['nav_id'] . ', "' . $model['title'] . '")',
                            'id' => 'createNewSort' . $model['nav_id'],
                ]);
            },
            'format' => 'raw'
        ],
        [
            'class' => 'open20\amos\core\views\grid\ActionColumn',
            'template' => '{preview}{visibility}',
            'buttons' => [
                'preview' => function ($url, $model) {
                    $url = '/' . Module::getModuleName() . '/d1/menu';
                    $link = Utility::getLinkTarget($model);
                    $onlineVersion = Utility::getOnlineVersion($model['id0']);
                    $target = ['/cms-page-preview', 'itemId' => $model['id0'], 'version' => (!empty($onlineVersion['id']) ? $onlineVersion['id'] : 1)];
                    if (!empty($link)) {
                        $target = $link;
                    }
                    return Html::a('<span class="mdi mdi-eye"></span>', $target
                            , [
                        'title' => Module::txt('Visualizza l\'anteprima'),
                        'class' => 'btn btn-tool-secondary',
                        'target' => '_blank',
                    ]);
                },
                'visibility' => function ($url, $model) {
                    $url = '/' . Module::getModuleName() . '/d1/menu';
                    if ($model['hidden']) {
                        return Html::a('<span class="mdi mdi-eye"></span>', ['/' . Module::getModuleName() . '/d1/set-visibility-menu', 'id' => $model['nav_id'], 'value' => 0]
                                        , [
                                    'title' => Module::txt('Rendi visibile nel menu'),
                                    'class' => 'btn btn-tool-secondary',
                        ]);
                    }
                    return Html::a('<span class="mdi mdi-eye"></span>', ['/' . Module::getModuleName() . '/d1/set-visibility-menu', 'id' => $model['nav_id'], 'value' => 1]
                            , [
                        'title' => Module::txt('Nascondi nel menu'),
                        'class' => 'btn btn-tool-secondary',
                    ]);
                },
            ],
        ],
    ]
]);
