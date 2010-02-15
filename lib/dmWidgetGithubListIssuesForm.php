<?php

class dmWidgetGithubListIssuesForm extends dmWidgetPluginForm
{
  public function configure()
  {
    $this->widgetSchema['user'] = new sfWidgetFormInputText();
    $this->validatorSchema['user'] = new sfValidatorString();

    $this->widgetSchema['repo'] = new sfWidgetFormInputText();
    $this->validatorSchema['repo'] = new sfValidatorString();

    $this->widgetSchema['state'] = new sfWidgetFormSelect(array(
      'choices' => dmArray::valueToKey(array('open', 'closed'))
    ));
    $this->validatorSchema['state'] = new sfValidatorChoice(array(
      'choices' => array('open', 'closed')
    ));

    $this->widgetSchema['nb_issues'] = new sfWidgetFormInputText();
    $this->validatorSchema['nb_issues'] = new sfValidatorInteger(array(
      'min' => 0,
      'max' => 200
    ));

    $this->widgetSchema['life_time'] = new sfWidgetFormInputText();
    $this->validatorSchema['life_time'] = new sfValidatorInteger(array(
      'min' => 0
    ));
    $this->widgetSchema->setHelp('life_time', 'Cache life time in seconds');

    if(!$this->getDefault('nb_issues'))
    {
      $this->setDefault('nb_issues', 10);
    }

    if(!$this->getDefault('life_time'))
    {
      $this->setDefault('life_time', 3600);
    }
    
    parent::configure();
  }
}