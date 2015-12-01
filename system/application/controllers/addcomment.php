<?php


class Addcomment extends Controller {

    function Addcomment()
    {
        parent::Controller();
    }
    
    function index()
    {
        if ($this->input->post('tweetid'))
        {

            $id = $this->input->post('tweetid');
            $author = $this->input->post('author');
            $message = $this->input->post('message');
            $email = $this->input->post('email');
            
            setcookie('author', $author);
            setcookie('email', $email);
            
            $this->db->select('email');
            $notify = $this->db->get_where('comments', array('id' => $id));

            $data = array(
                'id' => $id,
                'author' => $author,
                'message' => $message,
                'email'=> $email,
                'timestamp' => time()
            );

            $this->db->insert('comments', $data);
            
$nickmessage = <<<BODY
<html>
<body>
<b>Author:</b> $author<br />
<b>Message:</b> $message<br />
</body>
</html>
BODY;
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= "From: Kevinandiarentfriends <no-reply@kevinandiarentfriends.com>" . "\r\n";
            
            $mailit = mail('nickserra@gmail.com, kkrpicak@gmail.com', 'Comment posted on kevinandiarentfriends!', $nickmessage, $headers);
            
/* Turned off for spam
$message = <<<BODY
<html>
<body>
There was a comment posted after yours on kevinandiarentfriends.com!<br /><br />
<b>Author:</b> $author<br />
<b>Message:</b> $message<br />
</body>
</html>
BODY;

            foreach ($notify->result() as $row)
            {
                $mailit = mail($row->email, 'Comment posted on kevinandiarentfriends!', $message, $headers);
            }
*/
            echo '1';
        }
    }
}
