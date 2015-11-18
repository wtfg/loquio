<?php
/**
 * Created by PhpStorm.
 * User: Mauro
 * Date: 18/11/15
 * Time: 14.19
 *
 * 3637390c-a746-48e9-a1d7-b2bda91b6736
 */
class PostmarkMail{
    private $response;
    private $http_code;
    private $POSTMARK_API_KEY = '3637390c-a746-48e9-a1d7-b2bda91b6736';

    private function send_email($email) {

        $json = json_encode(array(
            'From' => $email['from'],
            'To' => $email['to'],
            //'Cc' => $email['cc'],
            //'Bcc' => $email['bcc'],
            'Subject' => $email['subject'],
            //'Tag' => $email['tag'],
            'HtmlBody' => $email['html_body'],
            'TextBody' => $email['text_body'],
            //'ReplyTo' => $email['reply_to'],
            //'Headers' => $email['headers'],
            //'Attachments' => $email['attachments']
        ));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'X-Postmark-Server-Token: ' . $this->POSTMARK_API_KEY
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $this->response = json_decode(curl_exec($ch), true);
        $this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $this->http_code === 200;
    }

    function send($to,$subject, $text,$html){
        $sent = $this->send_email(array(
            'to' => $to,
            'from' => 'Loquio No-Reply <info@loquio.it>',
            'subject' => $subject,
            'text_body' => $text,
            'html_body' => $html
        ));
        // Did it send successfully?
        if( $sent ) {
            echo 'The email was sent!';
        } else {
            echo 'The email could not be sent!';
        }
        // Show the response and HTTP code
        echo '<pre>';
        echo 'The JSON response from Postmark:<br />';
        print_r($this->response);
        echo 'The HTTP code was: ' . $this->http_code;
        echo '</pre>';

    }

}

/*
$a = new PostmarkMail();
$a->send("loquio.official@gmail.com", "ciao", "testo", "<html><body>Ciaociao</body></html>");
*/