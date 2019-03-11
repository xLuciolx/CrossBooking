<?php
/**
 * User: laura
 * Date: 10/03/19
 * Time: 11:39
 */

namespace App\Util\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Util\Traits\Shortcut;

trait Image {

    use Shortcut;

    /**
     * Move image to /public/assets/images/avatar and return the image name
     * @method moveAndGenerateName
     * @param UploadedFile $file
     * @return $filename
     */
    public function moveAndRenameAvatar(UploadedFile $file = null, string $pseudo, string $avatarPath) {
    
        /**
         * @var string $filename
         */
        $filename;
    
        if($file) {
            $filename = $this->generateSlug($pseudo) . '.' . $file->guessExtension();
            try {
                $file->move(
                    $avatarPath,
                    $filename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
        }
        else {
            $filename = "default.png";
            dump('no image');
        }
        return $filename;
    }
}