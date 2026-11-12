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

namespace open20\cms\dashboard\utilities;

use open20\amos\core\utilities\Email as BaseEmail;
use open20\cms\dashboard\Module;

/**
 * Description of Email
 *
 */
class Email {

    /**
     * 
     * @param \open20\cms\dashboard\models\CmsWfRequest $request
     * @return boolean
     */
    public static function sendRequestPublicationMail($request) {
        $subject = $request->title;
        $message = $request->description;
        $userIds = \Yii::$app->authManager->getUserIdsByRole('CAPOREDATTORECMS');
        foreach ($userIds as $id) {
            $user = \open20\amos\core\user\User::findOne($id);
            if (!empty($user)) {
                $to = $user->email;
                static::sendEmail($to, $subject, $message);
            }
        }
    }

    /**
     * 
     * @param \open20\cms\dashboard\models\CmsWfRequest $request
     */
    public static function sendApprovedMail($request) {
        $subject = $request->title;
        $message = Module::txt('La sua richiesta è stata approvata ed evasa.');

        $user = \open20\amos\core\user\User::findOne($request->from_user);

        if ($user) {
            $to = $user->email;
            static::sendEmail($to, $subject, $message);
        }
    }

    /**
     * 
     * @param \open20\cms\dashboard\models\CmsWfRequest $request
     * @return boolean
     */
    public static function sendRefusedMail($request) {
        $subject = $request->title;
        $message = Module::txt('La sua richiesta non è stata approvata. Qui di seguito la motivazione:') .
                '<br>' . $request->message;

        $user = \open20\amos\core\user\User::findOne($request->from_user);

        if ($user) {
            $to = $user->email;
            static::sendEmail($to, $subject, $message);
        }
    }

    /**
     * 
     * @param type $to
     * @param type $subject
     * @param type $message
     * @param type $files
     * @param type $ccn
     * @param type $params
     * @return boolean
     */
    public static function sendEmail($to, $subject, $message, $files = [], $ccn = [], $params = []) {
        try {
            $from = '';
            if (isset(\Yii::$app->params['email-assistenza'])) {
//use default platform email assistance
                $from = \Yii::$app->params['email-assistenza'];
            }

            /** @var Email $email */
            $email = new BaseEmail();
            $email->sendMail($from, $to, $subject, $message, $files, $ccn, $params);
        } catch (\Exception $ex) {
            \Yii::getLogger()->log($ex->getTraceAsString(), \yii\log\Logger::LEVEL_ERROR);
            return false;
        }
        return true;
    }

}
