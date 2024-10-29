<?php

use rnadvanceemailingwc\Utilities\Sanitizer;

$advancedEmailId=Sanitizer::GetStringValueFromPath($args,['email','settings','advanced_email']);

if($advancedEmailId=='')
    throw new Exception('Email template was not found');


$renderer=RNADEM()->GetEmailRenderedByTemplateId($advancedEmailId,$order);
echo $renderer->Render();

