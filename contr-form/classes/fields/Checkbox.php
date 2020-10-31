<?php
namespace classes\fields;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class Checkbox extends AbstractVariationField
{
    public function renderField()
    {
        // TODO: Implement renderField() method.
        foreach ($this->variants as $elem => $item) : ?>
            <?php if (is_array($this->value) and in_array($elem, $this->value)) : ?>
                <input type="checkbox" name="<?= $this->name ?>[]" value="<?= $elem ?>" checked ><?= $item ?>
            <?php else : ?>
                <input type="checkbox" name="<?= $this->name ?>[]" value="<?= $elem ?>" ><?= $item ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php $this->displayError(); ?>
        <?php
    }

    public function sendField()
    {
        // TODO: Implement send() method.
        $msg = '';
        if (is_array($this->value)) {
            $msg .= $this->send;
            foreach ($this->value as $elem) {
                $msg .= $this->variants[$elem] . ' ';
            }
            $msg .= "\r\n";
        }
        return $msg;
    }

}
