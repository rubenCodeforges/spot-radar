<?php

namespace Codeforges\CFRest\ApiBundle\Handler;

use Codeforges\CFRest\ApiBundle\Model\ValidationMessage;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormHandler implements FormHandlerInterface
{
    private $dm;

    private $isValid;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var ValidationMessage
     */
    private $validationMessage;
    
    public function __construct(DocumentManager $manager)
    {
        $this->dm = $manager;
    }

    public function validateForm(): FormHandlerInterface
    {

        if ($this->form->isValid()) {
            $formData = $this->form->getData();

            $this->dm->persist($formData);
            $this->dm->flush();

            $this->isValid = true;
        } else {
            $this->isValid = false;
        }
        
        return $this;
    }

    public function processForm(FormInterface $form, Request $request): FormHandlerInterface
    {
        $this->form = $form;
        $this->form->submit($request);
        
        return  $this->validateForm()
            ->prepareValidationMessage();
    }

    public function prepareValidationMessage(): FormHandlerInterface
    {
        $this->validationMessage = new ValidationMessage($this->getValidationMessage());

        return $this;
    }

    public function getResponse(array $responseData = null)
    {
        return $this->validationMessage->getValidationResponse($this->form, $responseData);
    }

    private function getValidationMessage(): string {
        return  $this->isValid ?
            ValidationMessage::$VALIDATION_SUCCESS : ValidationMessage::$VALIDATION_ERROR;
    }
}