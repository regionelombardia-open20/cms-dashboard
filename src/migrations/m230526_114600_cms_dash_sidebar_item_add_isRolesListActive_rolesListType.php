<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\community\migrations
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
class m230526_114600_cms_dash_sidebar_item_add_isRolesListActive_rolesListType extends \yii\db\Migration {

    private $table = '{{%cms_dash_sidebar_item}}';

    const COLUMN1 = 'isRolesListActive';
    const COLUMN2 = 'rolesListType';

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $table = $this->db->schema->getTableSchema($this->table);

        if (!(isset($table->columns[self::COLUMN1]))) {
            $this->addColumn($this->table, self::COLUMN1, $this->boolean()->notNull()->after('position')->defaultValue(false)->comment('la lista dei ruoli è attiva o meno'));
        }
        if (!(isset($table->columns[self::COLUMN2]))) {
            $this->addColumn($this->table, self::COLUMN2, $this->boolean()->notNull()->after(self::COLUMN1)->comment('lista da trattare come whitelist o blacklist'));
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropColumn($this->table, self::COLUMN2);
        $this->dropColumn($this->table, self::COLUMN1);
        return true;
    }
}
