<?php

namespace Gewaer\Cli\Tasks;

use Phalcon\Cli\Task as PhTask;
use Gewaer\Models\FileSystem;

/**
 * Class AclTask
 *
 * @package Gewaer\Cli\Tasks;
 *
 * @property \Gewaer\Acl\Manager $acl
 */
class FileSystemTask extends PhTask
{
    /**
     * Create the default roles of the system
     *
     * @return void
     */
    public function mainAction()
    {
        echo 'Main action for FileSystem Task';
    }

    /**
     * Default roles for the crm system
     *
     * @return void
     */
    public function purgeImagesAction(array $params):void
    {
        //Option to fully delete or softdelete an image
        $fullDelete = $params[0];

        // Specify the filisystem from which to erase
        $fileSystem = $params[1];

        $detachedImages = FileSystem::find([
            'conditions' => 'users_id = 0 and is_deleted = 0'
        ]);

        if ($fullDelete == 0 && is_object($detachedImages)) {
            foreach ($detachedImages as $detachedImage) {
                //Get the file name
                $filePathArray = explode('/', $detachedImage->path);
                $fileName = end($filePathArray);

                //Soft Delete file
                $detachedImage->is_deleted = 1;

                if ($detachedImage->update()) {
                    $this->di->get('filesystem', $fileSystem)->delete($fileName);
                    echo 'Image with id ' . $detachedImage->id . " has been soft deleted \n";
                }
            }
        } else {
            foreach ($detachedImages as $detachedImage) {
                //Get the file name
                $filePathArray = explode('/', $detachedImage->path);
                $fileName = end($filePathArray);

                echo 'Image with id ' . $detachedImage->id . " has been fully deleted \n";
                $detachedImage->delete();
                $this->di->get('filesystem', $fileSystem)->delete($fileName);
            }
        }
    }
}
