<?php

/**
 * Class providing minor functionalities missing in Doctrine.
 */
class Doctrine_Auxiliary_Tools
{
  /**
   * Maps custom serializable fields to a newly constructed object.
   *
   * @param Doctrine_Record $record
   * @return void
   */
  static public function postConstruct(Doctrine_Record $record)
  {
    $templates = $record->getListener();
    for ($ind = 0; $templates->get($ind) != null && $templates->get($ind) != 'Doctrine_Template_Listener_Serializable'; $ind++)
      $template = $templates->get($ind);
    if ($template == null)
      throw new sfException('The '.get_class($record).' class doesn\'t have the Serializable behavior.');
    else $options = $template->getOptions();
    foreach ($options['fields'] as $field)
      $record->mapValue($field, null);
  }
}
