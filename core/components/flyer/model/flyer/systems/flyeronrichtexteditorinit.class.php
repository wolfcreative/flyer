<?php

class flyerOnRichTextEditorInit extends flyerPlugin
{
    public function run()
    {
        if (!$this->flyer->initEditor) {
            return;
        }

        $output = $this->flyer->loadControllerJsCss($this->modx->controller, array(
            'css'      => true,
            'config'   => true,
            'tools'    => true,
            'ckeditor' => true,
        ), $this->scriptProperties);

        $this->modx->event->output($output);
    }

}