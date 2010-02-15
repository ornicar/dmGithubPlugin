<?php

class dmWidgetGithubListCommitsForm extends dmWidgetPluginForm
{
  public function configure()
  {
    $this->widgetSchema['user'] = new sfWidgetFormInputText();
    $this->validatorSchema['user'] = new sfValidatorString();

    $this->widgetSchema['repo'] = new sfWidgetFormInputText();
    $this->validatorSchema['repo'] = new sfValidatorString();

    $this->widgetSchema['branch'] = new sfWidgetFormInputText();
    $this->validatorSchema['branch'] = new sfValidatorString();

    $this->widgetSchema['nb_commits'] = new sfWidgetFormInputText();
    $this->validatorSchema['nb_commits'] = new sfValidatorInteger(array(
      'min' => 0,
      'max' => 200
    ));

    $this->widgetSchema['life_time'] = new sfWidgetFormInputText();
    $this->validatorSchema['life_time'] = new sfValidatorInteger(array(
      'min' => 0
    ));
    $this->widgetSchema->setHelp('life_time', 'Cache life time in seconds');

    if(!$this->getDefault('branch'))
    {
      $this->setDefault('branch', 'master');
    }

    if(!$this->getDefault('nb_commits'))
    {
      $this->setDefault('nb_commits', 10);
    }

    if(!$this->getDefault('life_time'))
    {
      $this->setDefault('life_time', 3600);
    }
    
    parent::configure();
  }
}