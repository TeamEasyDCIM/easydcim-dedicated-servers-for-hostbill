<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use Illuminate\Database\Capsule\Manager as DB;

class EmailNotifications
{
    public function getAdminEmailTemplates()
    {
        return DB::table('hb_email_templates')->select('id','tplname')->where('group','=','Product')->where('for','=','Admin')->get();
    }

    public function getTemplate($id)
    {
        return DB::table('hb_email_templates')->where('id','=',$id)->first();
    }

    public function getClientEmailTemplates()
    {
        return DB::table('hb_email_templates')->select('id','tplname')->where('group','=','Product')->where('for','=','Client')->get();
    }

    public function getAdmins()
    {
        return DB::table('hb_admin_details')->get();
    }
    public function getAdminEmail($id)
    {
        return DB::table('hb_admin_details')->where('id','=',$id)->first()->email;
    }
}