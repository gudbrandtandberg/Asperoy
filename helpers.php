
function render($name, $data = Array()){
    
    extract($data);
    require($name.".php");
    
}