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
 * Handles the creation of table `log_cookie`.
 */
class m230112_120004_create_table_wf extends AmosMigrationTableCreation {

    protected function setTableName() {
        $this->tableName = '{{%cms_wf_request}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields() {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'title' => $this->string()->null(),
            'description' => $this->text()->null(),
            'message' => $this->text()->null(),
            'nav_id' => $this->integer()->notNull(),
            'nav_item_page_id' => $this->integer()->notNull(),
            'nav_item_id' => $this->integer()->notNull(),
            'from_user' => $this->integer()->notNull(),
            'processed' => $this->integer()->defaultValue(0),
            'processed_by_user' => $this->integer()->null(),
            'hash' => $this->string()->null(),
            'url' => $this->text()->null(),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function beforeTableCreation() {
        parent::beforeTableCreation();
        $this->setAddCreatedUpdatedFields(true);
    }

}
