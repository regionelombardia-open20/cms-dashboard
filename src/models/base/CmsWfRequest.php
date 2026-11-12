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
 * This is the base-model class for table "cms_wf_request".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $message
 * @property integer $nav_id
 * @property integer $nav_item_page_id
 * @property integer $nav_item_id
 * @property integer $from_user
 * @property integer $processed
 * @property integer $processed_by_user
 * @property string $hash
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 */
class CmsWfRequest extends \open20\amos\core\record\Record {

    public $isSearch = false;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cms_wf_request';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nav_id', 'nav_item_page_id', 'nav_item_id', 'from_user'], 'required'],
            [['nav_id', 'nav_item_page_id', 'nav_item_id', 'from_user', 'processed', 'processed_by_user', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title', 'hash'], 'string', 'max' => 255],
            [['description', 'message', 'url'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('amosdashboards', 'ID'),
            'title' => Yii::t('amosdashboards', 'Titolo'),
            'description' => Yii::t('amosdashboards', 'Descrizione'),
            'nav_id' => Yii::t('amosdashboards', 'Nav ID'),
            'nav_item_page_id' => Yii::t('amosdashboards', 'Nav Item Page ID'),
            'nav_item_id' => Yii::t('amosdashboards', 'Nav Item ID'),
            'from_user' => Yii::t('amosdashboards', 'From User'),
            'processed' => Yii::t('amosdashboards', 'Processed'),
            'processed_by_user' => Yii::t('amosdashboards', 'Processed By User'),
            'created_at' => Yii::t('amosdashboards', 'Created at'),
            'updated_at' => Yii::t('amosdashboards', 'Updated at'),
            'deleted_at' => Yii::t('amosdashboards', 'Deleted at'),
            'created_by' => Yii::t('amosdashboards', 'Created by'),
            'updated_by' => Yii::t('amosdashboards', 'Updated by'),
            'deleted_by' => Yii::t('amosdashboards', 'Deleted by'),
        ];
    }

    /**
     * 
     * @return type
     */
    public function getNav() {
        return $this->hasOne(\app\modules\cms\models\Nav::class, ['id' => 'nav_id']);
    }

    /**
     * 
     * @return type
     */
    public function getItem() {
        return $this->hasOne(\app\modules\cms\models\NavItem::class, ['id' => 'nav_item_id']);
    }

    /**
     * 
     * @return type
     */
    public function getPage() {
        return $this->hasOne(\app\modules\cms\models\NavItemPage::class, ['id' => 'nav_item_page_id']);
    }

    public function getFromUser() {
        return $this->hasOne('user', ['id' => 'from_user']);
    }

    public function getProcessedUser() {
        return $this->hasOne('user', ['id' => 'processed_by_user']);
    }

}
