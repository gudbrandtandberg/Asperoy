<?php
    require_once("../renderHelpers.php");
    renderHeaderWithTitle("ASPERØY - SUPPORT");
    
?>
    <script type="text/javascript">
        $(document).ready(function(){
           $("#send").click(function(){
                $("#kontaktform").submit();
           });
           
           $("#kontaktform").submit(function(e){
                e.preventDefault();
                $("#spinner").css({display: "inline-block"});
                var url = "/api/sendTilbakemelding.php?tilbakemelding=";
                url += $("#tilbakemelding").val();
                url += "&bruker=<?=$_SESSION["brukernavn"];?>";
                
                $.ajax({
                    type: "POST",
                    url: url,
                    success: function(data){
                        if (data.trim() == "YES") {
                            $("#spinner").css({display: "none"});
                            $("#statusfelt").html("<small>Takk for tilbakemeldingen!</small>");
                        }
                        else {
                            $("#spinner").css({display: "none"});
                            $("#statusfelt").html("<small>Det oppsto en feil, prøv igjen senere..</small>");
                        }
                        
                    }
                });
                
            });
        });
    </script>
    <style type="text/css">
        textarea {
            resize: vertical;
            width: 100%;
            height: 40%;
            margin: 0px;
        }
        #send {
            margin-top: 9px;
            margin-right: 5px;
        }
        #ddlogo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 46px;            
        }
        #spinner {
            width: 20px;
        }
    </style>
    
    
    <div class="col-xs-12 col-md-6">
    <h2>Support</h2>
    
    <p>
        Vi jobber stadig vekk med forbedringer til denne siden.
    </p>
    <p>
        For at siden skal bli best mulig for alle brukerene våre ønsker vi all den tilbakemelding vi kan få. 
    </p>
    <p>
        Om du har idéer til <strong>ny funksjonalitet</strong>, opplever <strong>problemer med eksisterende</strong>
        eller kun ønsker å <strong>rise/rose</strong>,
        fyll ut kontaktskjema så skal vi svare på henvendelsen din så fort som mulig. 
    </p>
    <p>
        <em>Vennlig hilsen</em>
    </p>
    
        <img id="ddlogo" src="/resources/images/ddlogo.png" width="200" />
    
    </div>
    <div class="col-xs-12 col-md-6">
        <h3>Kontaktskjema</h3>
        <form id="kontaktform">
            <textarea name="tilbakemelding" placeholder="Tilbakemelding..." id="tilbakemelding"></textarea>
            <button id="send" class="btn btn-default">Send tilbakemelding</button>
            <span id="statusfelt"><img id="spinner" src="/resources/images/progress.gif" style="display: none;" ></span>
        </form>
    </div>
    
<?php
    renderFooter();
?>