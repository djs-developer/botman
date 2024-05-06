<?php
namespace app\Conversation;

use BotMan\BotMan\Messages\Conversations\Conversation;

class userdataConversation extends Conversation
{
    public function getdata()
    {

        $user = $this->bot->userStorage()->find();
        $message = '-------------------------------------- <br>';
        $message .= 'Name : ' . $user->get('Name') . '<br>';
        $message .= 'Email : ' . $user->get('email') . '<br>';
        $message .= 'Mobile : ' . $user->get('mobile') . '<br>';
        $message .= '---------------------------------------';

        
        $this->say('Great. Your booking has been confirmed. Here is your booking details. <br><br>' . $message);
    }
    public function run()
    {
            $this->getdata();
    }
}