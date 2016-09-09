<?php

namespace Codeforges\CFRest\ApiBundle\Model;

use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
    
    public function getValidationResponse(FormInterface $form = null, array $responseData = null)
    {
        $response = [
            "title"=> $this->title,
            "type"=> $this->type,
        ];
        
        if($this->hasErrors() && $form) {
            $response["errors"] = $this->getValidationErrorMessages($form);
        } else if($responseData){
            $response["data"] = $responseData;
        } else if(!$responseData && !$this->hasErrors()){
            $response["type"] = "accepted";
        } else {
            $response = [
                "error" => Response::HTTP_BAD_REQUEST
            ];
        }
        
        return View::create($response, $this->getStatusCode());
    }
    
    private function getStatusCode(): int {
        if($this->hasErrors()){
            return Response::HTTP_BAD_REQUEST;
        }

        return Response::HTTP_ACCEPTED;
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