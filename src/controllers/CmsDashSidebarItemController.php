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
 
namespace open20\cms\dashboard\controllers;

use open20\cms\dashboard\Module;
use open20\cms\dashboard\models\CmsDashSidebarItem;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Html;

/**
 * Class CmsDashSidebarItemController 
 * This is the class for controller "CmsDashSidebarItemController".
 * @package controllers 
 */
class CmsDashSidebarItemController extends \open20\cms\dashboard\controllers\base\CmsDashSidebarItemController
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $get = Yii::$app->request->get();

        if (\Yii::$app->user->isGuest) {
            $titleSection = Module::t('amosdashboards', 'Sidebar');
            $urlLinkAll   = '';

            $labelSigninOrSignup = Module::t('amosdashboards', '#beforeActionCtaLoginRegister');
            $titleSigninOrSignup = Module::t(
                'amosdashboards',
                '#beforeActionCtaLoginRegisterTitle',
                ['platformName' => \Yii::$app->name]
            );
            $labelSignin = Module::t('amosdashboards', '#beforeActionCtaLogin');
            $titleSignin = Module::t(
                'amosdashboards',
                '#beforeActionCtaLoginTitle',
                ['platformName' => \Yii::$app->name]
            );
            /*
            $labelLink = $labelSigninOrSignup;
            $titleLink = $titleSigninOrSignup;
            $socialAuthModule = Yii::$app->getModule('socialauth');
            if ($socialAuthModule && ($socialAuthModule->enableRegister == false)) {
                $labelLink = $labelSignin;
                $titleLink = $titleSignin;
            }

            $ctaLoginRegister = Html::a(
                $labelLink,
                isset(\Yii::$app->params['linkConfigurations']['loginLinkCommon']) ? \Yii::$app->params['linkConfigurations']['loginLinkCommon']
                    : \Yii::$app->params['platform']['backendUrl'] . '/' . AmosAdmin::getModuleName() . '/security/login',
                [
                    'title' => $titleLink
                ]
            );
            $subTitleSection  = Html::tag(
                'p',
                Module::t(
                    'amosdashboards',
                    '#beforeActionSubtitleSectionGuest',
                    ['platformName' => \Yii::$app->name, 'ctaLoginRegister' => $ctaLoginRegister]
                )
            );*/
        } else {
            $titleSection = Module::t('amosdashboards', 'Sidebar');

            /*
            $labelLinkAll = AmosNews::t('amosdashboards', 'Tutti i bookmark');
            $urlLinkAll   = '/community/bookmarks/index';
            $titleLinkAll = AmosNews::t('amosdashboards', 'Visualizza la lista dei bookmark');
*/
            $subTitleSection = Html::tag(
                'p',
                Module::t(
                    'amosdashboards',
                    '#beforeActionSubtitleSectionLogged'
                )
            );
        }

        $labelCreate = Module::t('amosdashboards', 'Nuovo');
        $titleCreate = Module::t('amosdashboards', 'Crea nuovo elemento');
        $labelManage = Module::t('amosdashboards', 'Gestisci');
        $titleManage = Module::t('amosdashboards', 'Gestisci la sidebar');
        $urlCreate   = 'create';
        $urlManage   = null;

        $this->view->params = [
            #'breadcrumbs' => $test,
            'isGuest' => \Yii::$app->user->isGuest,
            #'modelLabel' => 'Sidebar',
            'titleSection' => $titleSection,
            #'hideCreate' => true,
            'subTitleSection' => $subTitleSection,
            #'urlLinkAll' => $urlLinkAll,
            #'labelLinkAll' => $labelLinkAll,
            #'titleLinkAll' => $titleLinkAll,
            'labelCreate' => $labelCreate,
            'titleCreate' => $titleCreate,
            'labelManage' => $labelManage,
            'titleManage' => $titleManage,
            'urlCreate' => $urlCreate,
            'urlManage' => $urlManage,
        ];

        // Lasciare qui questo if e return perché se no va in loop...
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'swap-position',
                        ],
                        'allow' => true,
                        'roles' => ['ADMIN'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Funzione per scambiare due item della sidebar tra loro
     * @return false|string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSwapPosition() {
        if(!\Yii::$app->request->isAjax) return false;

        /**
         * idClicked: id dell'item che si vuole spostare
         * idNeighbor: id dell'item adiacente da spostare
         */
        $idClicked = \Yii::$app->request->post('idClicked');
        $idNeighbor = \Yii::$app->request->post('idNeighbor');
        $modelClicked = CmsDashSidebarItem::find()
            ->where(['position' => $idClicked])
            ->andWhere(['deleted_at' => null])
            ->one();
        $modelNeighbor = CmsDashSidebarItem::find()
            ->where(['position' => $idNeighbor])
            ->andWhere(['deleted_at' => null])
            ->one();
        if($modelClicked && $modelNeighbor){
            // Scambio la posizione
            $tmp = $modelClicked->position;
            $modelClicked->position = $modelNeighbor->position;
            $modelNeighbor->position = $tmp;
            $modelClicked->save();
            $modelNeighbor->save();
            $dataProvider = $this->modelSearch->search(\Yii::$app->request->getQueryParams());
            return $this->renderPartial('parts/_updatedListItems',[
                'dataProvider' => $dataProvider,
                'currentView' => $this->getCurrentView('grid')
            ]);
        }
        return false;
    }
}
