<?php

namespace miranj\autotranslator\fieldtranslators;

use Craft;
use craft\base\Field;
use craft\ckeditor\Field as CKEditor;
use miranj\autotranslator\Plugin;

/**
* CKEditor Field Translator
*/
class CKEditorFieldTranslator extends TextFieldTranslator
{
    public const FIELD_TYPES = [
        CKEditor::class,
    ];
    
    public static function displayName(): string
    {
        return Craft::t('auto-translator', 'CKEditor Field Translator');
    }
    
    // Returns the translated value of a supported field
    public static function translate(Field $field, $sourceElement, $targetElementOwner, $sourceElementOwner)
    {
        // sanity check
        $value = $sourceElement->getFieldValue($field->handle);
        if (!$value || !static::canTranslate($field)) {
            return $value;
        }
        
        // extract the raw content
        $value = $value->rawContent;
        
        return Plugin::getInstance()->translator->translate(
            $value,
            $targetElementOwner->site->language,
            $sourceElementOwner->site->language,
        );
    }
}
