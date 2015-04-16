<script type="text/javascript">
    
    $(document).ready(function(){
       
        var releaseDate = new Date(2015, 5, 1, 12, 0, 0, 0).getTime()/1000;
        
        var seconds = 1;
        var minutes = seconds*60;
        var hours = minutes*60;
        var days = hours*24;
        
        setInterval(function(){
                
                var now = new Date().getTime()/1000.0;
                
                var secondsLeft = releaseDate - now;
                
                var daysLeft = secondsLeft / days;
                var hoursLeft = (secondsLeft % days) / hours;
                var minutesLeft = ((secondsLeft % days) % hours) / minutes;
                var secondsLeft = (((secondsLeft % days) % hours) % minutes) / seconds;
                
                $("#counter").html(daysLeft.toFixed(0) + " d "
                                   + hoursLeft.toFixed(0) + "h "
                                   + minutesLeft.toFixed(0) + "m "
                                   + secondsLeft.toFixed(0) + "s ");
            }, 1000);
     
        
    });
    
</script>

<div class="cd_intro">
    Velkommen til asperøy.no <br>
    Siden åpner om:
</div>

<div id="counter">    

</div>