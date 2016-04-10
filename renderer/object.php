<?php

class TemplateRenderer {
    
    private $left_delimiter = '{'; // Beschraenkung des Platzhalters links
    private $right_delimiter = '}'; // Beschraenkung des Platzhalters rechts
    
    public function render($template, $context) {
        $file = file_get_contents($template); // Das Template als String laden
        // Durch den Kontext, der $key ist der Name des Platzhalters, $value der Wert, durch den er ersetzt wird
        foreach($context as $key => $value) {
            $pattern = $this->left_delimiter.'(\s)?'.$key.'(\s)?'. $this->right_delimiter; // RegEx, z.B.: {(\s)?name(\s)?} --> {name} bzw. { name }
            $file = mb_ereg_replace($pattern, $value, $file); // RegEx-Suche, alle Platzhalter durch den jeweiligen Wert ersetzen
        }
        
        return $file; // Template ist nun sauberes HTML
    }
}

?>