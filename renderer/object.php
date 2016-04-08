<?php

class TemplateRenderer {
    
    private $left_delimiter = '{';
    private $right_delimiter = '}';
    
    public function __construct() {
        
    }
    
    public function render($template, $context) {
        $file = file_get_contents($template);
        foreach($context as $key => $value) {
            $pattern = $this->left_delimiter.'(\s)?'.$key.'(\s)?'. $this->right_delimiter;
            $file = mb_ereg_replace($pattern, $value, $file);
        }
        
        return $file;
    }
}

?>