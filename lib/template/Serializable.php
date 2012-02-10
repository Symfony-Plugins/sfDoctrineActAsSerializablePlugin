<?php

/**
 * Template for Serializable behavior.
 *
 * @package     sfDoctrineActAsSerializablePlugin
 * @subpackage  template
 * @since       1.0
 * @author      Tomasz Ducin <tomasz.ducin@gmail.com>
 */
class Doctrine_Template_Serializable extends Doctrine_Template
{

  /**
   * Array of Serializable options
   *
   * @var Array
   */
  protected $_options = array(
    'fields' => array(),
    'column_suffix' => '_serialized',
  );

  /**
   * __construct
   *
   * @param string $array
   * @return void
   */
  public function __construct(array $options = array())
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
  }

  /**
   * Set table definition for Serializable behavior.
   *
   * @return void
   */
  public function setTableDefinition()
  {
    foreach ($this->_options['fields'] as $field)
      $this->hasColumn($field.$this->_options['column_suffix'], 'string');
    $this->addListener(new Doctrine_Template_Listener_Serializable($this->_options));
  }
}
