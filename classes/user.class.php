<?php

class User
{

    const TOKEN = '[SENDGRID_API_KEY]';

    /**
     * @param $data
     * @return bool
     */
    public static function Register($data)
    {
        global $db;
        $data['user_password'] = md5($data['user_password']);
        $data['user_token'] = md5(uniqid());
        $data['user_update'] = date('Y-m-d H:i:s');

        $query = $db->prepare('INSERT INTO users SET 
        user_name = :user_name, user_email = :user_email, user_password = :user_password, user_question = :user_question, user_answer = :user_answer, user_token = :user_token, user_update = :user_update');
        $insert = $query->execute($data);

        if ($insert) {
            return $data['user_token'];
        } else {
            return false;
        }

    }

    /**
     * @param $username
     * @param $email
     * @return bool
     */
    public static function Check($username, $email)
    {
        global $db;
        $query = $db->query('SELECT * FROM users WHERE user_name = "' . $username . '" || user_email = "' . $email . '"')->fetch(PDO::FETCH_ASSOC);
        if ($query)
            return true;
        return false;
    }

    /**
     * @param $username
     * @param $email
     * @param $activation
     * @return bool
     * @throws \SendGrid\Mail\TypeException
     */
    public static function SendActivationMail($username, $user_email, $activation)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("tayfunerbilen@gmail.com", "Tayfun Erbilen");
        $email->setSubject("Hesabınızı onaylayın - webso.cool");
        $email->addTo($user_email, $username);
        ob_start();
        require realpath('.') . '/view/email.php';
        $output = ob_get_clean();
        $email->addContent(
            "text/html", $output
        );
        $sendgrid = new \SendGrid(self::TOKEN);
        $response = $sendgrid->send($email);
        if ($response->statusCode() == 202) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     * @throws \SendGrid\Mail\TypeException
     */
    public static function resendActivation()
    {
        self::setActivationCode(session('id'), 0);
        $send = self::SendActivationMail(session('username'), session('email'), session('token'));
        return $send;
    }

    /**
     * @param $userId
     * @return bool
     */
    public static function setActivationCode($userId, $activation)
    {
        global $db;
        $query = $db->prepare('UPDATE users SET user_token = :token, user_activation = :activation, user_update = :user_update WHERE user_id = :user_id');
        $token = md5(uniqid());
        $_SESSION['token'] = $token;
        $date = date('Y-m-d H:i:s', strtotime('+10 minute'));
        $_SESSION['update'] = $date;
        $result = $query->execute([
            'token' => $token,
            'user_id' => $userId,
            'user_update' => $date,
            'activation' => $activation
        ]);
        return $result;
    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    public static function getUserInfo($username, $password)
    {
        global $db;
        $query = $db->prepare('SELECT * FROM users WHERE user_name = :username && user_password = :password');
        $query->execute([
            'username' => $username,
            'password' => md5($password)
        ]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $name_or_email
     * @param $question
     * @param $answer
     * @return mixed
     */
    public static function findForPassword($name_or_email, $question, $answer)
    {
        global $db;
        $query = $db->prepare('SELECT * FROM users WHERE (user_name = :name_or_email || user_email = :name_or_email) && user_question = :question && user_answer = :answer');
        $query->execute([
            'name_or_email' => $name_or_email,
            'question' => $question,
            'answer' => $answer
        ]);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /**
     * @param $user
     * @return bool
     * @throws \SendGrid\Mail\TypeException
     */
    public static function SendForgetPasswordEmail($user)
    {
        global $db;
        $token = md5(uniqid());
        $date = date('Y-m-d H:i:s', strtotime('+10 minute'));
        $db->query('UPDATE users SET user_token = "' . $token . '", user_update = "' . $date . '" WHERE user_id = ' . $user['user_id'])->fetch(PDO::FETCH_ASSOC);
        $_SESSION['token'] = $token;
        $_SESSION['update'] = $date;
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("tayfunerbilen@gmail.com", "Tayfun Erbilen");
        $email->setSubject("Şifrenizi sıfırlayın - webso.cool");
        $email->addTo($user['user_email'], $user['user_name']);
        ob_start();
        require realpath('.') . '/view/forget-password-email.php';
        $output = ob_get_clean();
        $email->addContent(
            "text/html", $output
        );
        $sendgrid = new \SendGrid(self::TOKEN);
        $response = $sendgrid->send($email);
        if ($response->statusCode() == 202) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $data
     */
    public static function Login($data)
    {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $data['user_id'];
        $_SESSION['username'] = $data['user_name'];
        $_SESSION['email'] = $data['user_email'];
        $_SESSION['token'] = $data['user_token'];
        $_SESSION['update'] = $data['user_update'];
        $_SESSION['activation'] = $data['user_activation'];
    }

}