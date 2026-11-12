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

use open20\amos\core\views\DataProviderView;
use open20\amos\core\helpers\Html;
use open20\cms\dashboard\Module;

?>

<div id="listSidebarItems" class="cms-dash-sidebar-item-index">
    <?= DataProviderView::widget([
        'dataProvider' => $dataProvider,
        'currentView' => $currentView,
        'gridView' => [
            'columns' => [
                'position',
                'icon_name' => [
                    'attribute' => 'icon_name',
                    'format' => 'html',
                    'label' => Yii::t('amosdashboards', 'Icon'),
                    'value' => function($model){
                        return '<span class="mdi mdi-' . $model->icon_name . ' icon-sidebar"></span>';
                    }
                ],
                'label',
                'description',
                'link',
                'isVisible' => [
                    'attribute' => 'isVisible',
                    'format' => 'html',
                    //'label' => '',
                    'value' => function($model){
                        return ($model->isVisible) ? Yii::t('amosdashboards', 'Si') : Yii::t('amosdashboards', 'No');
                    }
                ],
                [
                    'class' => 'open20\amos\core\views\grid\ActionColumn',
                    'template' => '{sopra}{sotto}{update}{delete}',
                    'buttons' => [
                        'sopra' => function ($url, $model) {
                            $options = ['id' => 'sidebarItemUp-' . $model->id, 'name' => $model->position, 'title' => Yii::t('amosdashboards', 'Sposta sopra'), 'data-pjax' => '0'];
                            if($model->position > 1)
                                return Html::a('Su', [], $options);
                            else return '';
                        },
                        'sotto' => function ($url, $model) use ($dataProvider){
                            $options = ['id' => 'sidebarItemDown-' . $model->id, 'name' => $model->position, 'title' => Yii::t('amosdashboards', 'Sposta sotto'), 'data-pjax' => '0'];
                            if($model->position < $dataProvider->getCount())
                                return Html::a('Sotto', [], $options);
                            else return '';
                        },
                        'delete' => function($url, $model){
                            return Html::a('<span class="mdi mdi-delete"></span>', Yii::$app->urlManager->createUrl([
                                    '/' . Module::getModuleName() . '/cms-dash-sidebar-item/delete',
                                    'id' => $model->id,
                                ]),
                                [
                                    'title' => Module::t('amosdashboards', 'Elimina'),
                                    'class' => 'btn btn-danger-inverse',
                                    'style' => 'color:#a61919; border-top:1px solid #ccc',
                                    'data-confirm' => Module::t('amosdahboards', '#deleteConfirm')
                                ]);
                        }
                    ]
                ],
            ],
        ],
        /*'listView' => [
        'itemView' => '_item',
        'masonry' => FALSE,

        // Se masonry settato a TRUE decommentare e settare i parametri seguenti
        // nel CSS settare i seguenti parametri necessari al funzionamento tipo
        // .grid-sizer, .grid-item {width: 50&;}
        // Per i dettagli recarsi sul sito http://masonry.desandro.com

        //'masonrySelector' => '.grid',
        //'masonryOptions' => [
        //    'itemSelector' => '.grid-item',
        //    'columnWidth' => '.grid-sizer',
        //    'percentPosition' => 'true',
        //    'gutter' => '20'
        //]
        ],
        'iconView' => [
        'itemView' => '_icon'
        ],
        'mapView' => [
        'itemView' => '_map',
        'markerConfig' => [
        'lat' => 'domicilio_lat',
        'lng' => 'domicilio_lon',
        'icon' => 'iconMarker',
        ]
        ],
        'calendarView' => [
        'itemView' => '_calendar',
        'clientOptions' => [
        //'lang'=> 'de'
        ],
        'eventConfig' => [
        //'title' => 'titleEvent',
        //'start' => 'data_inizio',
        //'end' => 'data_fine',
        //'color' => 'colorEvent',
        //'url' => 'urlEvent'
        ],
        'array' => false,//se ci sono più eventi legati al singolo record
        //'getEventi' => 'getEvents'//funzione da abilitare e implementare nel model per creare un array di eventi legati al record
        ]*/
    ]); ?>

</div>