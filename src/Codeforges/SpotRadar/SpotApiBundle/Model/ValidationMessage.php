<?php

namespace Codeforges\SpotRadar\SpotApiBundle\Model;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ValidationMessage
{
    public static $VALIDATION_ERROR = 'validation_error';
    public static $VALIDATION_SUCCESS = 'validation_success';
    
    private $title;
    private $type;
    private $errors;

    /**
     * ValidationMessage constructor.
     * @param $type
     * @param $errors
     * 
     * @param string $errorTitle
     */
    public function __construct($type, $errors = null, $errorTitle= "There was a validation error")
    {
        $this->type = $type;
        $this->errors = $errors;
        $this->title = $this->getMessageTitle($errorTitle);
    }

    /**
     * @param FormInterface|null $form
     * @return JsonResponse
     */
    public function getResponse(FormInterface $form = null): JsonResponse {
        $response = [
            "title"=> $this->title,
            "type"=> $this->type,
        ];
        
        if($this->hasErrors()) {
            $response["errors"] = $this->getValidationErrorMessages($form);
        }
        
        return new JsonResponse( $response, $this->getStatusCode());
    }
    
    private function getStatusCode(): int {
        if($this->hasErrors()){
            return 400;
        }
        
        return 200;
    }
    
    private function getMessageTitle(string $title): string {
            return  !$this->hasErrors() ? "success" : $title;
    }
    
    private function hasErrors(): bool {
        return $this->type === ValidationMessage::$VALIDATION_ERROR;
    }
    
    private function getValidationErrorMessages(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->all() as $childForm) {
            if (!$childForm->isValid()) {
                $errors []= $this->getFormsError($childForm, $form);
            }
        }

        return $errors;
    }

    private function getFormsError(FormInterface $childForm, FormInterface $mainForm): array
    {
        $errors = [];

        foreach ($mainForm->getErrors(true) as $error) {
            $errors[$childForm->getName()] = $error->getMessage();
        }

        return $errors;
    }
}