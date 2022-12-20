<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * Classes list:
 * - Sign_out extends CI_Controller
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * @todo Description of class Sign_out
 * @author 
 * @version 
 * @package 
 * @subpackage 
 * @category 
 * @link 
 */
class Sign_out extends MY_Controller
{
    
    
    /**
     * @todo Description of function __construct
     * @param 
     * @return 
     */
    function __construct()
    {
        parent::__construct();
    }
    
    
    /**
     * @todo Description of function index
     * @param 
     * @return 
     */
    function index()
    {
        $this->session->sess_destroy();
        redirect(base_url() , 'reload');
    }
}

