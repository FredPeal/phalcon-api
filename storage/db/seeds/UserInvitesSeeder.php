<?php

use Phinx\Seed\AbstractSeed;

class UserInvitesSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'users_id' => 1,
                'company_id' => 0,
                'app_id' => 0,
                'name' => 'users-invite',
                'template' => '{link}',
                'created_at' => date('Y-m-d H:i:s'),
            ], [
                'users_id' => 1,
                'company_id' => 0,
                'app_id' => 0,
                'name' => 'users-registration',
                'template' => '{link}',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $posts = $this->table('email_templates');
        $posts->insert($data)
              ->save();
    }
}
