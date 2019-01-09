<?php

return [
    'error' => '<div class="form-control-feedback">{{content}}</div>',
    'label' => '<label class="col-form-label col-lg-3">{{text}}</label>',
    'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
    'formGroup' => '{{label}}<div class="col-lg-9">{{input}}{{error}}</div>',
    'inputContainer' => '<div class="input {{type}}{{required}} form-group m-form__group row">{{content}}</div>',
    'inputContainerError' => '<div class="input {{type}}{{required}} form-group m-form__group has-danger row">{{content}}</div>',
];