<?php

namespace App\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\Bundle\DoctrineBundle\Registry;

use App\Util\Traits\Image;
use App\Entity\Member;

class Register
{
    /**
     * Trait Image
     * Access moveAndRenameAvatar()
     */
    use Image;

    /**
     * @var Registry $doctrine
     */
    private $doctrine;
    /**
     * @var UserPasswordEncoderInterface $encoder
     */
    private $encoder;

    public function __construct(
        Registry $doctrine, 
        UserPasswordEncoderInterface $encoder
    ) {
        $this->doctrine = $doctrine;
        $this->encoder = $encoder;
    }

    /**
     * Register a member
     * @method member
     * @param $form , $member , $avartarPath
     * @return boolean success / error -> created OR already exist
     */
    public function member($form, Member $member, string $avartarPath)
    {

        /**
         * Store the client avatar
         * @var Symfony\Component\HttpFoundation\File\UploadedFile $avatar
         */
        $avatar;
        /**
         * Store the avatar name
         * @var string $avatarName
         */
        $avatarName;

        /**
         * @var $isRegistered 
         */
        $isRegistered = $this->doctrine
                            ->getRepository(Member::class)
                            ->findOneBy(['pseudo' => $form->get('pseudo')->getData()]);
        
        if(!$isRegistered) {
            // Move and rename the avatar
            $avatar = $form->get('avatar')->getData();
            $avatarName = $this->moveAndRenameAvatar($avatar, $member->getPseudo(), $avartarPath);
            $member->setAvatar($avatarName);

            // Encode the password
            $plainPassword = $form->get('password')->getData();
            $encoded = $this->encoder->encodePassword($member, $plainPassword);
            $member->setPassword($encoded);

            // Persist / Flush data
            $this->doctrine->getEntityManager()->persist($member);
            $this->doctrine->getEntityManager()->flush();

            // Member registered
            return true;
        }
        else {
            // Member already exist - not registered
            return false;
        }
    }
}