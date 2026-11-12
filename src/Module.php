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

namespace open20\cms\dashboard;

use open20\amos\core\interfaces\BreadcrumbInterface;
use open20\amos\core\module\AmosModule;

/**
 * Description of Module
 *
 */
class Module extends AmosModule implements BreadcrumbInterface {

    /**
     * 
     * @var int
     */
    public $defaultLayoutId = 1;

    /**
     * 
     * @var int
     */
    public $defaultContainerId;

    /**
     * 
     * @var type
     */
    public $enableContainerFilterForEditor = true;

    /**
     *  Elenco dei record che non permettono modifiche nei link (nemmeno dall'admin), nella sidebar redattore
     * @var int[]
     */
    public $sidebarItemBlacklist = [2, 10]; // Dashboard, Gestione portali

    /**
     * 
     * @var bool $enableProfile
     */
    public $enableProfile = false;

    /**
     * @var array[] $mapPermissionContainer
     */
    public $mapPermissionContainer = [
        'REDATTORECMS' => ['default', 'footer'],
        'CAPOREDATTORECMS' => ['default', 'footer', 'system'],
    ];

    /**
     * @var int $maxCmsPageLevel
     */
    public $maxCmsPageLevel = 5;

    /**
     * @var int $defaultTitlePageLength
     */
    public $defaultTitlePageLength = 175;

    /**
     * 
     * @return string
     */
    public static function getModuleName() {
        return 'dashboards';
    }

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        \Yii::setAlias('@open20/cms-dashboard/src/controllers/', __DIR__ . '/controllers/');
        // custom initialization code goes here
        \Yii::configure($this, require(__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php'));
    }

    /**
     * @inheritdoc
     */
    public function getWidgetIcons() {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function getWidgetGraphics() {
        return null;
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultModels() {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getModelClassName() {
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function getModelSearchClassName() {
        return null;
    }

    /**
     * @param type $message
     * @param type $params
     * @return type
     */
    public static function txt($message, $params = []) {
        return \Yii::t('amosdashboards', $message, $params);
    }

    public function getDefaultContainerId() {
        if (empty($this->defaultContainerId)) {
            $container = \luya\cms\models\NavContainer::find()->andWhere(['alias' => 'default'])->andWhere(['is_deleted' => 0])->one();
            $this->defaultContainerId = $container->id;
        }
        return $this->defaultContainerId;
    }

    /**
     * @return array
     */
    public function getIndexActions() {
        return [
            'dashboards/cms-dash-sidebar-item/index',
        ];
    }

    /**
     * @return array
     */
    public function getControllerNames() {
        $names = [
            'cms-dash-sidebar-item' => self::t('amosdashboards', "Sidebar"),
        ];

        return $names;
    }
}
