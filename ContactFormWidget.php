<?php

class ContactFormWidget extends Widget {

   private static $db = array(
      'Title' => 'Varchar(255)',
      'Content' => 'HTMLText',
      'Mailto' => 'Varchar(100)',
      'SubmitText' => 'Text',
   );

   private static $title = "";
   private static $cmsTitle = "Contact Form";
   private static $description = "Add a contact form to the sidebar";

   public function getCMSFields() {
      return new FieldList(
         TextField::create('Title'),
         HTMLEditorField::create('Content'),
         TextField::create('Mailto')->setTitle('To Email Address')->setDescription('Email address to send submissions to'),
         TextField::create('SubmitText')->setTitle('Post Submission Content')->setDescription('Content to show on the website after the form is submitted')
      );
   }

}

class ContactFormWidget_Controller extends Widget_Controller {

  private static $allowed_actions = array('ContactForm');

   public function ContactForm() {
      $fields = new FieldList(
         TextField::create('Name')->setValue('Name')->addExtraClass('full'),
         EmailField::create('Email')->setValue('Email')->addExtraClass('full'),
         TextareaField::create('Message')->setValue('Message'),
         TextField::create('Spam')->setTitle('Is fire hot or cold?')->setValue('Is fire hot or cold?')->addExtraClass('full')
      );
      $actions = new FieldList(new FormAction('SendContactForm', 'Send'));
      $requiredFields = array('Name','Spam','Email','Message');
      $validator = new RequiredFields($requiredFields);
      foreach($requiredFields as $fieldName) {
         $fields->fieldByName($fieldName)->addExtraClass("required");
      }
      return new Form($this, 'ContactForm', $fields, $actions, $validator);
   }

   public function SendContactForm($data, $form) {
      if($this->SubmitText) {
         $SubmitText = $this->SubmitText;
      }
      else {
         $SubmitText = "Your email is on it\'s way. Thanks for contacting us!";
      }
      if(trim(strtolower($data['Spam'])) != 'hot') {
         $form->sessionMessage('Please give that spam question another try.','bad');
         Controller::redirectBack();
      }
      else {
         $From = $data['Email'];
         $To = $this->Mailto;
         $Subject = "Contact form submission from the contact form widget";
         $email = new Email($From, $To, $Subject);
         $email->setTemplate('ContactFormEmail');
         $email->populateTemplate($data);
         $email->send();
         $form->sessionMessage($SubmitText,'success');
         Controller::redirectBack();
      }
   }

   public function Title() {
      if($this->Title){
         return $this->Title;
      }
   }

   public function ContactFormContent() {
      if($this->Content){
         return $this->Content;
      }
   }

}