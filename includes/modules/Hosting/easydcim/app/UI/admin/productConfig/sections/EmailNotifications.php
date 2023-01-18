<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use Illuminate\Database\Connection;

class EmailNotifications
{

    /**
     * @var Connection
     */
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAdminEmailTemplates()
    {
        return $this->db->table('hb_email_templates')->select('id','tplname')->where('group','=','Product')->where('for','=','Admin')->get();
    }

    public function getTemplate($id)
    {
        return $this->db->table('hb_email_templates')->where('id','=',$id)->first();
    }

    public function getClientEmailTemplates()
    {
        return $this->db->table('hb_email_templates')->select('id','tplname')->where('group','=','Product')->where('for','=','Client')->get();
    }

    public function getAdmins()
    {
        return $this->db->table('hb_admin_details')->get();
    }
    public function getAdminEmail($id)
    {
        return $this->db->table('hb_admin_details')->where('id','=',$id)->first()->email;
    }
}