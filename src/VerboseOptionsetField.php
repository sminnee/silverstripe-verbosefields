<?php

namespace Sminnee\VerboseFields;

use SilverStripe\Forms\OptionsetField;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\ArrayData;

/**
 * Optionset field with a right hand paragraph in the admin, describing the option you are hovering on or have selected
 */
class VerboseOptionsetField extends OptionsetField
{
    function Field($properties = [])
    {
        Requirements::css('sminnee/silverstripe-verbosefields:css/verbosefields.css');
        Requirements::javascript('sminnee/silverstripe-verbosefields:javascript/verbosefields.js');
        return parent::Field($properties);
    }

    /**
     * Provide a map of option value => description
     * Description should be HTML
     * @param array<int|string,string> $sourceDescriptions
     */
    function setSourceDescriptions(array $sourceDescriptions): VerboseOptionsetField
    {
        $this->sourceDescriptions = $sourceDescriptions;
        return $this;
    }

    /**
     * Build a field option for template rendering. Overridden to include source desciprtion
     *
     * @param mixed $value Value of the option
     * @param string $title Title of the option
     * @param boolean $odd True if this should be striped odd. Otherwise it should be striped even
     * @return ArrayData Field option
     */
    protected function getFieldOption($value, $title, $odd)
    {
        $description = DBField::create_field(
            DBHTMLText::class,
            isset($this->sourceDescriptions[$value]) ? $this->sourceDescriptions[$value] : ''
        );

        return new ArrayData(array(
            'ID' => $this->getOptionID($value),
            'Class' => $this->getOptionClass($value, $odd),
            'Name' => $this->getOptionName(),
            'Value' => $value,
            'Description' => $description,
            'Title' => $title,
            'isChecked' => $this->isSelectedValue($value, $this->Value()),
            'isDisabled' => $this->isDisabledValue($value)
        ));
    }
}
