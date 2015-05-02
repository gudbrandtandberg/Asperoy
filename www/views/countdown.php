<script type="text/javascript">
    
    $(document).ready(function(){
       
       //Bruker GMT+00 tror jeg tralala
        var releaseDate = new Date("May 3, 2015 12:00:00").getTime()/1000;
        
        var seconds = 1;
        var minutes = seconds*60;
        var hours = minutes*60;
        var days = hours*24;
        
        setInterval(function(){
                
                var now = new Date().getTime()/1000.0;    
                
                var secondsLeft = releaseDate - now;
                if (secondsLeft <= 0) {
                    window.location.href = "/login";
                }
                
                var daysLeft = Math.floor(secondsLeft / days);
                var hoursLeft = Math.floor((secondsLeft % days) / hours);
                var minutesLeft = ((secondsLeft % days) % hours) / minutes;
                var secondsLeft = (((secondsLeft % days) % hours) % minutes) / seconds;
                
                $("#counter").html(daysLeft.toFixed(0) + " d "
                                   + hoursLeft.toFixed(0) + "t "
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