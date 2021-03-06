<?php defined('SYSPATH') or die('No direct access allowed.');

class PolymorphicRecordListener extends Doctrine_Record_Listener
{
    protected $parent = NULL;

    public function  __construct($parent) {

        $this->parent = $parent;
    }

    public function postValidate($event) {
        $invoker =& $event->getInvoker();

        $conn = Doctrine_Manager::connection();
        $invalid = $conn->transaction->getInvalid();

        if(!empty($invalid)) {
            Kohana::log('debug', 'Initializing foreign_id');
            if (!is_int($invoker['foreign_id'])) {
                $invoker['foreign_id'] = 0;
            }
        } else {
            Kohana::log('debug', 'Leaving foreign_id alone');
        }
    }
}