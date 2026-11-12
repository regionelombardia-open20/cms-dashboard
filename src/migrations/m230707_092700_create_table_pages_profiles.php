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

/**
 * Handles the creation of table `cms_page_profiles`.
 */
class m230707_092700_create_table_pages_profiles extends AmosMigrationTableCreation {

    protected function setTableName() {
        $this->tableName = '{{%cms_page_profiles}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields() {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'nav_id' => $this->integer()->notNull(),
            'user_profile_classes_id' => $this->integer()->notNull(),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function beforeTableCreation() {
        parent::beforeTableCreation();
        $this->setAddCreatedUpdatedFields(true);
    }

    protected function addForeignKeys() {
        $this->addForeignKey('fk_cms_nav_id0', $this->tableName, 'nav_id', '{{%cms_nav}}', 'id');
        $this->addForeignKey('fk_userprofclasses_id0', $this->tableName, 'user_profile_classes_id', '{{%user_profile_classes}}', 'id');
    }
}
