<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


require_once 'modules/ModuleBuilder/parsers/views/SubpanelMetaDataParser.php';

/**
 * Bug #36668
 * Name field is no longer a hyperlink after moving the field from Default to Hidden back to Default 
 * in the Studio subpanel definition for custom module
 * @ticket 36668
 */
class LinkFieldTest extends SubpanelMetaDataParser
{
    function __construct()
    {
        return true;
    }
    
    function makeFieldsAsLink($defs)
    {
        return $this->makeRelateFieldsAsLink($defs);
    }
}

class Bug36668Test extends Sugar_PHPUnit_Framework_TestCase
{
    function fieldDefProvider()
    {
        return array(
            array(true, 'relate', '0'),
            array(true, 'name', '1'),
            array(false, 'name', '0'),
        );
    }

    /**
     * @dataProvider fieldDefProvider
     * @group 36668
     */
    public function testMakeRelateFieldsAsLink($flag, $type, $link)
    {
        $defs = array('name' => array('type' => $type, 'link' => $link));
        
        $lt = new LinkFieldTest();
        $newDefs = $lt->makeFieldsAsLink($defs);

        $this->assertTrue(array_key_exists('widget_class', $newDefs['name']) == $flag);
    }
}
