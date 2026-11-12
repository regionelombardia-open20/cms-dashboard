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

use open20\amos\core\migration\AmosMigrationTableCreation;

class m230315_095500_create_table_cms_dash_sidebar_item extends AmosMigrationTableCreation {

    protected function setTableName() {
        $this->tableName = '{{%cms_dash_sidebar_item}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields() {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'link' => $this->text()->notNull(),
            'link_shortcut' => $this->text()->null(),
            'label' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'shortcut_description' => $this->string()->null(),
            'icon_name' => $this->string(32)->notNull(),
            'id_container' => $this->string()->null(),
            'class_container' => $this->string()->null(),
            'isVisible' => $this->boolean()->notNull()->defaultValue(true),
            'isTargetBlank' => $this->boolean()->notNull()->defaultValue(false),
            'position' => $this->integer()->notNull()
        ];
    }

    protected function beforeTableCreation()
    {
        parent::beforeTableCreation();
        $this->setAddCreatedUpdatedFields(true);
    }
}
