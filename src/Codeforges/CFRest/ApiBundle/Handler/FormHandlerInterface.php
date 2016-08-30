<?php

namespace Codeforges\CFRest\ApiBundle\Handler;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface FormHandlerInterface
{
    function processForm(FormInterface $form, Request $request): FormHandlerInterface;
    function validateForm(): FormHandlerInterface;
    function prepareValidationMessage(): FormHandlerInterface;
    function getResponse(array $responseData = null);
}