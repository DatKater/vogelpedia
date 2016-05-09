<?php

require_once('functions.php');

class TemplateRenderer {
    
    private $left_delimiter = '{'; // Beschraenkung des Platzhalters links
    private $right_delimiter = '}'; // Beschraenkung des Platzhalters rechts
    private $function_marker = '%';
    private $function_regex = '\s?(?<name>[a-zA-Z_]+)\s(?<params>(([\w\d]+) )*)\s?';
    
    public function render($template, $context) {
        $file = file_get_contents($template); // Das Template als String laden
        // Durch den Kontext, der $key ist der Name des Platzhalters, $value der Wert, durch den er ersetzt wird
        foreach($context as $key => $value) {
            if(!is_array($value)){
                $pattern = $this->left_delimiter.'(\s)?'.$key.'(\s)?'. $this->right_delimiter; // RegEx, z.B.: {(\s)?name(\s)?} --> {name} bzw. { name }
                $file = mb_ereg_replace($pattern, $value, $file); // RegEx-Suche, alle Platzhalter durch den jeweiligen Wert ersetzen
            } else {
                $pattern = '('.$this->left_delimiter.'(\s)?(?P<name>'.$key.')\.(?P<value>[\w]+)(\s)?'.$this->right_delimiter.')';
                $matches = array();
                preg_match_all($pattern, $file, $matches, PREG_SET_ORDER);
                foreach($matches as $match) {
                    $key = $match['value'];
                    $file = mb_ereg_replace($match[0], $value[$key], $file);
                }
            }
        }
        
        $function_pattern = $this->left_delimiter.$this->function_marker.$this->function_regex.$this->function_marker.$this->right_delimiter; // RegEx, z.B.: {% functionName param1 param2 %}
        $function_matches = array(); // Array fuer in das die Treffer geschrieben werden
        preg_match_all($function_pattern, $file, $function_matches,  PREG_SET_ORDER); // RegEx-Suche durch das Template, Treffer werden in das Array geschrieben, sortiert nach Matches
        
        foreach($function_matches as $match) { // Jeder Match
            $func = $match['name']; // Funktionsname
            $params = explode(" ", trim($match['params'])); // Parameter
            $cleaned_params = array(); // Array fuer kontextbereinigte Parameter
            
            foreach($params as $param) { // Jeder Parameter
                if(isset($context[$param])) { // Wenn der Parameter mit dem selben Namen im kontext steht
                    array_push($cleaned_params, $context[$param]); // Ersetze den Parameter durch den Wert im Kontext (Parameter also als Variable behandeln)
                } else {
                    array_push($cleaned_params, $param); // Sonst den Parameter drin lassen (Ihn also als String behandeln)
                }
            }
            
            $return = call_user_func_array($func, $cleaned_params); // Funktion mit den Parametern aufrufen, Rueckgabewert speichern
            
            $file = mb_ereg_replace($this->left_delimiter.$match[0].$this->right_delimiter, $return, $file); // Den urspruenglichen Match durch den Rueckgabewert der Funktion ersetzen
        }
        return $file; // Template ist nun sauberes HTML
    }
}

?>