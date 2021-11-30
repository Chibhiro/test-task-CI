<?php

namespace Model;

use App;
use Exception;
use http\Client\Curl\User;
use System\Core\CI_Model;

class Login_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

    }

    public static function logout()
    {
        App::get_ci()->session->unset_userdata('id');
    }

    /**
     * @return User_model
     * @throws Exception
     */
    public static function login($form_email, $form_password): User_model
    {
        // TODO: task 1, аутентификация
        $user_data_from_db = App::get_s()->from(User_model::CLASS_TABLE)
            ->where(['email' => $form_email])
            ->select(['id','password'])
            ->one();

        if($form_password === $user_data_from_db['password']){
            self::start_session($user_data_from_db['id']);
            return new User_model($user_data_from_db['id']);
        }else{
            return new User_model();
        }
    }

    public static function start_session(int $user_id)
    {
        // если перенедан пользователь
        if (empty($user_id))
        {
            throw new Exception('No id provided!');
        }

        App::get_ci()->session->set_userdata('id', $user_id);
    }
}
