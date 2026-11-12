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

namespace open20\cms\dashboard\models\base;

use Yii;

/**
 * This is the base-model class for table "cms_dash_sidebar_item".
 *
 * @property integer $id
 * @property string $link
 * @property string $link_shortcut
 * @property string $label
 * @property string $description
 * @property string $shortcut_description
 * @property string $icon_name
 * @property string $id_container
 * @property string $class_container
 * @property integer $isVisible
 * @property integer $isTargetBlank
 * @property integer $position
 * @property integer $isRolesListActive
 * @property integer $rolesListType
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 */
class  CmsDashSidebarItem extends \open20\amos\core\record\Record
{
    public $isSearch = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_dash_sidebar_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link', 'label', 'description', 'icon_name', 'position', 'isRolesListActive', 'rolesListType'], 'required'],
            [['link', 'link_shortcut'], 'string'],
            [['isVisible', 'isTargetBlank', 'position', 'created_by', 'isRolesListActive', 'rolesListType', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['label', 'description', 'id_container', 'class_container', 'shortcut_description'], 'string', 'max' => 255],
            [['icon_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => Yii::t('amosdashboards', 'Link'),
            'link_shortcut' => Yii::t('amosdashboards', 'Link Shortcut'),
            'label' => Yii::t('amosdashboards', 'title'),
            'description' => Yii::t('amosdashboards', 'description'),
            'shortcut_description' => Yii::t('amosdashboards', 'Shortcut Description'),
            'icon_name' => Yii::t('amosdashboards', 'Icon Name'),
            'id_container' => Yii::t('amosdashboards', 'Id Container'),
            'class_container' => Yii::t('amosdashboards', 'Class Container'),
            'isVisible' => Yii::t('amosdashboards', 'Active'),
            'isTargetBlank' => Yii::t('amosdashboards', 'Is Target Blank'),
            'position' => Yii::t('amosdashboards', 'position'),
            'isRolesListActive' => Yii::t('amosdashboards', 'Activate roles list'),
            'rolesListType' => Yii::t('amosdashboards', 'Type of roles list'),
            'created_at' => Yii::t('amosdashboards', 'Created At'),
            'updated_at' => Yii::t('amosdashboards', 'Updated At'),
            'deleted_at' => Yii::t('amosdashboards', 'Deleted At'),
            'created_by' => Yii::t('amosdashboards', 'Created By'),
            'updated_by' => Yii::t('amosdashboards', 'Updated By'),
            'deleted_by' => Yii::t('amosdashboards', 'Deleted By'),
        ];
    }
}
