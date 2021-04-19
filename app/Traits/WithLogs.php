<?php
namespace App\Traits;
/**
 * Logging Trait
 */
trait WithLogs
{
    static $authentication = 'Authentication';
    static $authorization = 'Authorization';
    static $create = 'Create';
    static $update = 'Update';
    static $delete = 'Delete';
    static $error = 'Error';
    static $info = 'Info';

    public function logActivity($name = 'Default', $description = '', $properties = []){
        activity($name)->withProperties($properties)->log($description);
    }
    
}

?>