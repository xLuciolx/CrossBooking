<?php

namespace App\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;

use App\Entity\Member;

class Mailer
{
    /**
     * @var Registry $doctrine
     */
    private $doctrine;

    public function __construct(
        Registry $doctrine
    ) {
        $this->doctrine = $doctrine;
    }

    /**
     * Create a member
     * @method create member
     * @param $form , $member , $avartarPath
     * @return  $url sucess / error -> where to redirect
     */
    public function resetPassword($form)
    {

        $mail = $form->get('mail')->getData();

        // Check if this mail is registered
        $member = $this ->doctrine
                        ->getRepository(Member::class)
                        ->findOneBy(['mail' => $form->get('mail')->getData()]);
        
        if ($member) {
            // Deal with token
            $token = md5($mail . date('YmdHis'));
            $member->setToken($token);
            $this->doctrine->getEntityManager()->persist($member);
            $this->doctrine->getEntityManager()->flush();

            // // Url for password change
            // $urlReset = $app['url_generator']->generate('livresVoyageurs_home' , array(), $app['url_generator']::ABSOLUTE_URL) . 'mot-de-passe/'.$token ;  // localhost n'apparait pas dans le chemin
            // // Create the Transport
            // $transport = (new Swift_SmtpTransport('smtp.orange.fr', 465, 'ssl'))
            // ->setUsername('livresvoyageurs@orange.fr')
            // ->setPassword('2017lola');
            // // Create the Mailer using created Transport
            // $mailer = new Swift_Mailer($transport);
            // // load template for the message
            // $template = $app['twig']->loadTemplate('resetPasswordMail.html.twig');
            // $message = new Swift_Message();
            // // embed the image for the template
            // $image   = $message->embed(Swift_Image::fromPath(PATH_IMAGES.'/logo-2.png'));
            // // Array for renderBlock
            // // $image = PATH_IMAGES . '/logo-2.png';
            // $parameters  = array(   'url'   => $urlReset,
            //                         'image' => $image
            // );
            // // Create a message
            // $message
            //             ->setFrom('livresvoyageurs@orange.fr')
            //             ->setTo($mail['mail_member'])
            //             ->setSubject($template ->renderBlock('subject', $parameters))
            //             // ->setBody($template    ->renderBlock('body_text', $parameters),'text/plain')
            //             ->addPart($template    ->renderBlock('body_html', $parameters),'text/html')
            //             ;
            // // Send the message
            // $result = $mailer->send($message);
            // if($result) {
                return 'ok';
            // }
        }
    }

    public function contact() {
        // # Create the Transport
        // $transport = (new Swift_SmtpTransport('smtp.orange.fr', 465, 'ssl'))
        // ->setUsername('livresvoyageurs@orange.fr')
        // ->setPassword('2017lola');
        // # Create the Mailer using your created Transport
        // $mailer = new Swift_Mailer($transport);
        // # Load template
        // $template = $app['twig']->loadTemplate('contact.html.twig');
        // # Parameters for renderBlock
        // $parameters = array('name'    => $data['name'],
        //                     'message' => $data['message'],
        //                     'mail'    => $data['mail']
        //                 );
        // # Create a message
        // $message = (new Swift_Message())
        //     ->setFrom($data['mail'])
        //     ->setTo('livresvoyageurs@orange.fr')
        //     ->setSubject($template->renderBlock('subject', $parameters))
        //     ->setBody($template   ->renderBlock('body_text', $parameters), 'text/plain')
        //     // ->addPart($template    ->renderBlock())
        //     ;
        // # Send the message
        // $result = $mailer->send($message);
        // if($result) {
            return 'ok';
        // }
    }

    public function sendMail()
    {

    }
}
