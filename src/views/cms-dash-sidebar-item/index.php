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

use open20\amos\core\helpers\Html;
use open20\amos\core\views\DataProviderView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
*/

$this->title = Yii::t('amoscore', 'Index');
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
    // Per spostare in basso l'item della sidebar
    $(document).on('click', 'a[id^="sidebarItemDown-"]', function(event){
        event.preventDefault();
        let idClicked = parseInt($(this).attr('name'));
        let idNeighbor = idClicked + 1;
        callAjax(idClicked, idNeighbor);
    });
    
// Per spostare in alto l'item della sidebar
    $(document).on('click', 'a[id^="sidebarItemUp-"]', function(event){
        event.preventDefault();
        let idClicked = parseInt($(this).attr('name'));
        let idNeighbor = idClicked - 1;
        callAjax(idClicked, idNeighbor);
    });
    
    // Chiamata per effettuare lo scambio di posizione di due item della sidebar
    function callAjax(idClicked, idNeighbor) {
        $.ajax({
            url: '/dashboards/cms-dash-sidebar-item/swap-position',
            type: "POST",
            data: { idClicked: idClicked, idNeighbor: idNeighbor },
            success: function(data){
                $('#listSidebarItems').html(data);
                
                // Scambio dei due item
                let elementClicked = $('.JqueryItem-' + idClicked);
                let elementNeighbor = $('.JqueryItem-' + idNeighbor);
                
                let tmp = elementClicked.html();
                elementClicked.html(elementNeighbor.html());
                elementNeighbor.html(tmp);
            },
            error: function(e){
                console.log(e);
            }
        });
    }
JS;
$this->registerJs($js);
echo $this->render('parts/_updatedListItems', [
        'dataProvider' => $dataProvider,
        'currentView' => $currentView
]);
?>

