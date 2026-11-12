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

use app\modules\cms\models\Nav;
use open20\cms\dashboard\utilities\Utility;
use open20\design\utility\DateUtility;
use open20\cms\dashboard\Module;
use yii\helpers\Url;

$today = DateUtility::getDate();

if (!empty($model)) {
    if ($model instanceof \open20\amos\news\models\News) {
        $title = $model->titolo;
        $url = $model->getFullViewUrl();
        $modelLabel = strtolower($model->getGrammar()->getModelLabel());
        $status = $model->getWorkflowStatus()->getLabel();

        $dataCreazione = DateUtility::getDate($model->created_at);
        $oraCreazione = DateUtility::getHour($model->created_at, 'php:H:i');
        $creatore = $model->createdUserProfile->nomeCognome;

        $dataOraPubblicazione = '';
        if (empty($model->data_pubblicazione)) {
            $dataOraPubblicazione = Module::txt('IMMEDIATA');
        } else {
            $dataPubblicazione = DateUtility::getDate($model->data_pubblicazione);
            $oraPubblicazione = DateUtility::getHour($model->data_pubblicazione, 'php:H:i');

            if ($dataPubblicazione == $today) {
                $dataOraPubblicazione = Module::txt('programmata') . ' ' . '<strong>' . Module::txt('OGGI') . '</strong>';
            } else {
                $dataOraPubblicazione = Module::txt('programmata in data') . ' ' . '<strong>' . $dataPubblicazione . '</strong>' . ' ' . Module::txt('alle') . ' <strong>' . $oraPubblicazione . '</strong>';
            }
        }
    }else{
        $title = $model['title'];
        $link = Utility::getLinkTarget($model);
        $onlineVersion = Utility::getOnlineVersion($model['id']);
        $url = Url::to(['/cms-page-preview', 'itemId' => $model['id'], 'version' => (!empty($onlineVersion['id']) ? $onlineVersion['id'] : 1)]);
        if (!empty($link)) {
            $url = $link;
        }
        $modelLabel = strtolower(Module::txt('pagina'));
        $status = Utility::getStatusPage($model['nav_id'], $model['id'], $model['nav']['is_offline'] , true);

        $dataOraPubblicazione = '';
        if (empty($model['nav']['publish_from'])) {
            $dataOraPubblicazione = Module::txt('IMMEDIATA');
        } else {
            $dataPubblicazione = DateUtility::getDate($model['nav']['publish_from']);
            $oraPubblicazione = DateUtility::getHour($model['nav']['publish_from'], 'php:H:i');

            if ($dataPubblicazione == $today) {
                $dataOraPubblicazione = Module::txt('programmata') . ' ' . '<strong>' . Module::txt('OGGI') . '</strong>';
            } else {
                $dataOraPubblicazione = Module::txt('programmata in data') . ' ' . '<strong>' . $dataPubblicazione . '</strong>' . ' ' . Module::txt('alle') . ' <strong>' . $oraPubblicazione . '</strong>';
            }
        }

        $user = \open20\amos\core\user\User::find()->andWhere(['id' => $model['from_user']])->one();
        $creatore = Module::txt('N.d.');
        if (!empty($user)) {
            $user_profile = \open20\amos\admin\models\UserProfile::find()->andWhere(['user_id' => $user->id])->one();
            $creatore = $user_profile->nome . ' ' . $user_profile->cognome;
        }
    }
}
?>
<div class="row itemRowDashboard">
    <div class="col">
        <span class="title small">
            <span class="badge badge-secondary"><?= $modelLabel ?></span>
            <a class="text-black" href="<?= $url ?>" title="<?= 'Visualizza' . ' ' . $title . ' ' . '[Apre in nuova finestra]' ?>" target="_blank"><?= $title ?></a>
            <span class="status">
                <em><?= '(' . $status . ')' ?></em>
            </span>
        </span>
    </div>
    <div class="col-md-6 text-md-right">
        <small>
            <?= Module::txt('Creato da') . ' ' . '<strong>' . $creatore . '</strong>' . ',' . ' pubblicazione ' . $dataOraPubblicazione ?>
        </small>
    </div>
</div>