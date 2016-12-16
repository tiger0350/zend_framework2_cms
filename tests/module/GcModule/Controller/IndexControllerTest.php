<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category Gc_Tests
 * @package  ZfModules
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace GcModule\Controller;

use Gc\Module\Model as ModuleModel;
use Gc\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Db\Sql;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-14 at 19:50:22.
 *
 * @group    ZfModules
 * @category Gc_Tests
 * @package  ZfModules
 */
class IndexControllerTest extends AbstractHttpControllerTestCase
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $this->init();
    }

    /**
     * Test
     *
     * @return void
     */
    public function testIndexAction()
    {
        $this->dispatch('/admin/module');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('GcModule');
        $this->assertControllerName('ModuleController');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('module');
    }

    /**
     * Test
     *
     * @return void
     */
    public function testInstallAction()
    {
        $this->dispatch('/admin/module/install');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('GcModule');
        $this->assertControllerName('ModuleController');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('module/install');
    }

    /**
     * Test
     *
     * @return void
     */
    public function testInstallActionWithInvalidPostData()
    {
        $this->dispatch(
            '/admin/module/install',
            'POST',
            array(
                'module' => ''
            )
        );
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('GcModule');
        $this->assertControllerName('ModuleController');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('module/install');
    }

    /**
     * Test
     *
     * @return void
     */
    public function testInstallActionWithValidPostData()
    {
        $this->dispatch(
            '/admin/module/install',
            'POST',
            array(
                'module' => 'Sitemap'
            )
        );
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('GcModule');
        $this->assertControllerName('ModuleController');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('module/install');

        ModuleModel::fromName('Sitemap')->delete();
    }

    /**
     * Test
     *
     * @return void
     */
    public function testUninstallActionWithInvalidData()
    {
        $this->dispatch(
            '/admin/module/uninstall/99999'
        );
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('GcModule');
        $this->assertControllerName('ModuleController');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('module/uninstall');
    }

    /**
     * Test
     *
     * @return void
     */
    public function testUninstallAction()
    {
        $moduleModel = ModuleModel::fromArray(
            array(
                'name' => 'Sitemap'
            )
        );

        $moduleModel->save();

        $this->dispatch(
            '/admin/module/uninstall/' . $moduleModel->getId()
        );
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('GcModule');
        $this->assertControllerName('ModuleController');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('module/uninstall');

        $moduleModel->delete();
    }
}