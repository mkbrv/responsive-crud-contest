<?php
/**
 * User: mcsere
 * Date: 2/13/15
 * Time: 1:12 PM
 * Contact: miki@softwareengineer.ro
 */

namespace MikiBrv\Controllers;



class IndexController extends BaseController
{

    public function index()
    {
        return $this->renderView("index", array());
    }

} 