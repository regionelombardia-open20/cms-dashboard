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

use yii\db\Migration;

/**
 * Class m230405_104600_reset_table_cms_dash_sidebar_item_default_values
 */
class m230405_104600_reset_table_cms_dash_sidebar_item_default_values extends Migration
{

    private $table = '{{%cms_dash_sidebar_item}}';

    public function safeUp()
    {

        $this->delete($this->table, [
            'label' => 'Report'
        ]);
        $this->delete($this->table, [
            'label' => 'Gestione portali'
        ]);
    }

    public function safeDown()
    {
        $this->insert($this->table, [
            'link' => '/metrics/operators',
            'link_shortcut' => null,
            'label' => 'Report',
            'description' => 'Report',
            'icon_name' => 'chart-pie',
            'isVisible' => 1,
            'isTargetBlank' => 1,
            'position' => 8
        ]);
        $this->insert($this->table, [
            'link' => 'javascript:void(0);',
            'link_shortcut' => null,
            'label' => 'Gestione portali',
            'description' => 'Gestione portali',
            'icon_name' => 'layers-triple',
            'isVisible' => 1,
            'isTargetBlank' => 0,
            'position' => 10
        ]);
    }
}