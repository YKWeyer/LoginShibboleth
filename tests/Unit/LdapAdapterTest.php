<?php


/**
 * Part of Piwik Shibboleth Login Plug-in. (Test).
 */

namespace Piwik\Plugins\LoginShibboleth\tests;

use Piwik\Plugins\LoginShibboleth\LdapAdapter;

/**
 * Test cases for LdapAdapter class.
 *
 * Here the test cases for LdapAdpater class can be written. Make sure that the the plug-in is
 * configured appropriately. This is also a good place to test changes to plug-in LDAP functionalities
 * before going to production.
 * The test can be run using Piwik test through the console.
 *
 * @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
 * @license MIT
 * @copyright 2014-2016 University of Wuerzburg
 * @copyright 2014-2016 Pouyan Azari
 */
class LdapAdapaterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Placeholder for Piwik\Plugins\LoginShibboleth\LdapAdapter.
     *
     * @var
     */
    private $la;

    /**
     * Setup the adapter first.
     */
    public function setUp()
    {
        parent::setUp();
        $this->la = new LdapAdapter();
    }

    /**
     * Test the connections to the LDAP server.
     *
     * @excpectedException \Exception
     */
    public function testCheckConnections()
    {
        $result = $this->la->checkConnection();
        $this->assertTrue($result);
    }

    /**
     * Test LDAP binding.
     *
     * @excpectedException \Exception
     */
    public function testLdapBind()
    {
        $result = $this->la->checkBind();
        $this->assertTrue($result);
    }

    /**
     * Test the create View Filter creator.
     *
     * @excpectedException \Exception
     */
    public function testViewFilter()
    {
        $testFilter = $this->la->getAdminFilterAttr(
            'username',
            '(manager=?)',
            'Domain|path',
            '|',
            true,
            array('ldapView')
        );
        $this->assertEquals($testFilter['filter'], '(manager=username)');
        $this->assertEquals($testFilter['attrs'], array('domain', 'path'));
    }

    /**
    * Test the get getManagedUrls with the mocked LDAP.
    */
    public function testGetManagedUrls()
    {
        $manageUrl = $this->la->getManagedUrls('s225274', 'View');
        $this->assertEquals(
            array(
                array('domain' => 'test-piwik.rz.uni-wuerzburg.de', 'path' => ''),
                array('domain' => 'www.rz.uni-wuerzburg.de', 'path' => '/piwik-test'),
            ),
            $manageUrl
        );
    }

    /**
     * Test getSuperUser status from LDAP.
     */
    public function testGetSuperUserStatus()
    {
        $superStatus = $this->la->getUserSuperUserStatus('poa32kc');
        $this->assertTrue($superStatus);
    }

    /**
     * Test get Mail for a given user.
     */
    public function testGetUserEmail()
    {
        $mail = $this->la->getMail('poa32kc');
        $this->assertEquals('pouyan.azari@uni-wuerzburg.de', $mail);
    }

    /**
     * Test get user alias from LDAP.
     */
    public function testGetUserAlias()
    {
        $alias = $this->la->getAlias('poa32kc');
        $this->assertEquals('Pouyan Azari', $alias);
    }
}
