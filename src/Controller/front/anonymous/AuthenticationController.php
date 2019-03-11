<?php

/**
 * User: laura
 * Date: 10/03/19
 * Time: 15:11
 */

namespace App\Controller\front\anonymous;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Member;
use App\Service\Mailer;
use App\Service\Register;
use App\Form\MemberType;
use App\Form\ResetForm;

class AuthenticationController extends AbstractController
{
    /**
     * Render Registration View
     * @Route("/inscription",name="registration")
     * @method  registration
     * @param   Request  $request
     * @return  Response Redirect to Login (inscription=success) OR indicate error (inscription=exist)
     */
    public function registration(Request $request, Register $register)
    {
        /**
         * Create a Member Instance
         * @var Member $member
         */
        $member = new Member();

        # Create Form
        $form = $this->createForm(MemberType::class, $member);

        # Handle request 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            /**
             * Can create a member ?
             * @var boolean $isCreated
             */
            $isCreated = $register->member($form, $member, $this->getParameter('avatar_path'));
            if($isCreated) return $this->redirect('login?inscription=success');
            else return $this->redirect('?inscription=exist');
        }

        # Render Registration View
        return $this->render('front/anonymous/authentication/registration.html.twig', [
            'form' => $form->createView(),
            'inscription' => $request->query->get('inscription')
        ]);
    }

    /**
     * Render Login View
     * @Route("/login",name="login")
     * @method login
     * @param Request   $request
     * @return Response Account validation / redirection done by Security
     */
    public function login(Request $request, AuthenticationUtils $authUtils) : Response
    {
        return $this->render('front/anonymous/authentication/login.html.twig', [
            'inscription'   => $request->query->get('inscription'),
            'mdp'           => $request->query->get('mdp'),
            'error'         => $authUtils->getLastAuthenticationError(),
            'last_username' => $authUtils->getLastUsername()
        ]);
    }

    /**
     * Render Reset Password View
     * @Route("/mot-de-passe",name="reset_password")
     * @method resetPassword
     * @param Request   $request
     * @return Response Send a verification e-mail
     */
    public function resetPassword(Request $request, Mailer $mailer) : Response
    {
        $form = $this->createForm(ResetForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reset = $mailer->resetPassword($form);
            return $this->render('front/anonymous/authentication/reset-password.html.twig', [
                'form' => $form->createView(),
                'reset' => $reset
            ]);
        }

        return $this->render('front/anonymous/authentication/reset-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        /**
     * Render Reset Password View - 2
     * @Route("/mot-de-passe-reinitialisation",name="reset_password2")
     * @method resetPassword2
     * @param Request   $request
     * @return Response Redirect to login ('mdp' => 'success')
     */
    public function resetPassword2(Request $request) : Response
    {
        $form = $this->createForm(ResetForm2::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }
    //     if ($form->isValid()) :
    //         # Connect to DB : Register a new member
    //         $member = $form->getData();
    //         # Get mail_member from DB depending on Token
    //         $mail = $app['idiorm.db']->for_table('members')
    //                                     ->where('token_member', $token)
    //                                     ->find_one();
    //         # Compare address mail in Db and from form data
    //         if($mail['mail_member'] == $member['mail_member'])
    //         {
    //             $memberDb = $app['idiorm.db']->for_table('members')->find_one($mail['id_member']);
    //             $memberDb->token_member  = "";
    //             $memberDb->pass_member   = $app['security.encoder.digest']->encodePassword($member['pass_member'], '');
    //             $memberDb->save();
    //             # Redirection
    //             return $app->redirect( $app['url_generator']->generate('livresVoyageurs_connexion', array( 'mdp' => 'success')));
    //         }
    //     endif;

        return $this->render('front/anonymous/authentication/reset-password2.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
