<?php

/**
 * Listener for the Serializable behavior.
 *
 * @package     sfDoctrineActAsSerializablePlugin
 * @subpackage  listener
 * @since       1.0
 * @author      Tomasz Ducin <tomasz.ducin@gmail.com>
 */
class Doctrine_Template_Listener_Serializable extends Doctrine_Record_Listener
{

  /**
   * Array of Serializable options
   *
   * @var array
   */
  protected $_options = array();

  /**
   * __construct
   *
   * @param array $options
   * @return void
   */
  public function __construct(array $options)
  {
    $this->_options = $options;
  }

  // update Doctrine_Record serializable columns before it's hydrated
  public function preHydrate(Doctrine_Event $event)
  {
    $data = $event->data;
    foreach ($this->_options['fields'] as $field)
    {
      $field_db = $field.$this->_options['column_suffix'];
      $data[$field] = unserialize($data[$field_db]);
      unset($data[$field_db]); // does it make sense?
    }
    $event->data = $data;
  }

  // update serialized database column before Doctrine_Record is being saved
  public function preSave(Doctrine_Event $event)
  {
    $invoker = $event->getInvoker();
    foreach ($this->_options['fields'] as $field)
    {
      $field_db = $field.$this->_options['column_suffix'];
      if ($invoker[$field])
        $invoker->set($field_db, serialize($invoker[$field]), false);
    }
  }
}
