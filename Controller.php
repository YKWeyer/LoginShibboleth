<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @category Piwik_Plugins
 * @package LoginLdap
 */
namespace Piwik\Plugins\ShibbolethLogin;

use Exception;
use Piwik\Common;
use Piwik\Config;
use Piwik\Menu\MenuAdmin;
use Piwik\Menu\MenuTop;
use Piwik\Notification;
use Piwik\Piwik;
use Piwik\Plugin\ControllerAdmin;
use Piwik\Plugins\UsersManager\API as APIUsersManager;
use Piwik\Session;
use Piwik\View;

require_once PIWIK_INCLUDE_PATH . '/core/Config.php';

/**
 * Login controller
 *
 * @package Login
 */
class Controller extends \Piwik\Plugins\Login\Controller
{

    /**
     * @param $length
     * @return string
     */
    private function generatePassword($length)
    {
        $chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $i = 0;
        $password = "";
        while ($i <= $length) {
            $password .= $chars{mt_rand(0, strlen($chars) - 1)};
            $i++;
        }
        return $password;
    }

    /**
     * Default function
     */
    public function index()
    {
        return $this->login();
    }


    /**
     * @param $password
     * @throws \Exception
     */
    protected function checkPasswordHash($password)
    {
        // do not check password (Login uses hashed password, LoginLdap uses real passwords)
    }
}