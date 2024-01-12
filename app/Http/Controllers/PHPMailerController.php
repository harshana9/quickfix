<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

class PHPMailerController extends Controller {

    // ============== [ Test Email Using API call ] ==============
    public function testEmail(Request $request){
        //return $this->composeEmail($request->to, $request->cc, $request->bcc, $request->subject, $request->body);

        $data = ['title'=>"Hello", 'user'=>'Test User'];
        return $this->composeEmail($request->to, $request->cc, $request->bcc, $request->subject, view("test_email", $data));
    }

    // =============== [ Email ] ===================
    public function email() {
        return view("email");
    }
 
    // ========== [ Compose Email ] ================
    public function composeEmail($to, $cc, $bcc, $subject, $body) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
 
        try {
            // Add signature image as inline attachment
            $imagePath = public_path('images/sig.jpg'); // Signature Image
            $cid = 'SIGNATURE_CID'; // Use a unique CID for each image
            $mail->addEmbeddedImage($imagePath, $cid, 'sig.jpg');
            //$cid = $mail->addEmbeddedImage($imagePath);
            //str_replace("SIGNATURE_CID",$cid,$body);
 
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // encryption - ssl/tls (ssl REQUIRED for Gmail)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->Username = 'aps.cc.peoplesbank@gmail.com';   //  sender username
            $mail->Password = 'wwjgihkgqxaqprdx';       // sender password              // 
            $mail->Port = 465;                          // port - 587/465
 
            $mail->setFrom('aps.cc.peoplesbank@gmail.com', 'PCC QuickFix System');
            $mail->addAddress($to);
            
            if(! is_null($cc)){
                foreach($cc as $address){
                    if(! is_null($address)){
                        $mail->addCC($address);
                    }
                }
            }
            
            if(! is_null($bcc)){
                foreach($bcc as $address){
                    if(! is_null($address)){
                        $mail->addBCC($address);
                    }
                }
            }
 
            $mail->addReplyTo('noreply@peoplesbank.lk', 'NoReply');
 
            /*if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }*/
 
 
            $mail->isHTML(true);                // Set email content format to HTML
 
            $mail->Subject = $subject;
            $mail->Body    = $body;
 
            // $mail->AltBody = plain text version of email body;
 
            if( !$mail->send() ) {
                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            }
            
            else {
                return back()->with("success", "Email has been sent.");
            }
 
        } catch (Exception $e) {
             return back()->with('error','Message could not be sent.');
        }
    }
}