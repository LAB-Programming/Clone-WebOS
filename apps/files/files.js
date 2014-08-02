$(document).ready(function(){
    var DirName = '';
    var DropDir = '';
    var GETobject = new URL(document.URL);
    var keyToggle = 0;

    $('#tools').css("height", $( document ).height());
    $('#tools').css("left", -$('#tools').width());

    $(".del").hide();
    $("#UpDir").hide();
    $("#downDir").hide();
    $(".iconHolder").hover(
        function(){
            $(this).find(".del").show();
            //DirName = $(this).find("p").text();
        }, function(){
            $(this).find(".del").hide();
        }
    );
    /*
    * this is for copying files in to other files
    * */
    $(function() {
        //turns all of the .iconHolder's in to a draggable
        $(".iconHolder").draggable({ revert: true , stack: "div",
            start: function( event, ui ) {
                DirName = $(this).find("p").text();
                $("#UpDir").show();
                $("#downDir").show();  
            },
            stop: function( event, ui ) {
                $("#UpDir").hide();
                $("#downDir").hide();
            }
        });
        $(".iconHolder").droppable({ accept: ".iconHolder", tolerance: "touch",//only lets other iconHolder's be dropped
            drop: function(event, ui){//function is triggered when draggable of iconHolder is dragged over
                DropDir = $(this).find("p").text();
                var currentDirectory = GETobject.findGET("Dir", GETobject.getGETs());
                if(currentDirectory === false) currentDirectory = '';
                var finalURL = GETobject.sendGET([
                        ['Dir', currentDirectory], 
                        ['cpDir', currentDirectory+'/'+DirName],
                        ['cpDest', currentDirectory+'/'+DropDir]
                    ]);
                window.location.href = finalURL;
            }
        });
        $("#UpDir").droppable({ accept: ".iconHolder", tolerance: "touch",
            drop: function(event, ui){
                var getArray = GETobject.findGET("Dir", GETobject.getGETs());
                if(getArray != false && getArray != '' && getArray != '/'){
                	var CurrentURL = getArray;
                	var preveiusURL = GETobject.removeLastSegment(CurrentURL);
                	var finalURL = GETobject.sendGET([
                			['Dir', CurrentURL], 
                			['cpDir', CurrentURL+'/'+DirName],
                			['cpDest', preveiusURL]
                		]);
                	window.location.href = finalURL;
                }
            }
        });
        $("#downDir").droppable({ accept: ".iconHolder", tolerance: "touch",
            drop: function(event, ui){
                var getArray = GETobject.findGET("Dir", GETobject.getGETs());
                if(getArray === false) getArray = '';
                var CurrentURL = getArray;
                var finalGet = GETobject.sendGET([
                        ['dir', CurrentURL],
                        ['rmdir', CurrentURL+'/'+DirName]
                    ]);
                if(confirm("Deleat this file?")){
                    window.location.href = finalGet;
                }
            }
        });
    });

    //this is for the sliding mecanic of the tool bar
    $('#tools').hover(function() {

        var $lefty = $('#tools');

        $(".appIcon").css( "-webkit-filter", "blur(5px)" );
        $(".appIcon").css( "filter", "blur(5px)" );

        $("h1").css( "-webkit-filter", "blur(5px)" );
        $("h1").css( "filter", "blur(5px)" );

        /*$lefty.animate({
          left: parseInt($lefty.css('left'),10) == 0 ?
            -$lefty.outerWidth() :
            0
        });*/
        $lefty.animate({
            left: 0
        });

    }, function() {

        var $lefty = $('#tools');

        $(".appIcon").css( "-webkit-filter", "blur(0px)" );
        $(".appIcon").css( "filter", "blur(0px)" );

        $("h1").css( "-webkit-filter", "blur(0px)" );;
        $("h1").css( "filter", "blur(0px)" );

        $lefty.animate({
            left: -$lefty.outerWidth()
        });

    });

    window.onkeyup = function(e){

        var key = e.keyCode ? e.keyCode : e.which;

        if(key == 190 && keyToggle == 0){

            var $lefty = $('#tools');

            $(".appIcon").css( "-webkit-filter", "blur(5px)" );
            $(".appIcon").css( "filter", "blur(5px)" );

            $("h1").css( "-webkit-filter", "blur(5px)" );
            $("h1").css( "filter", "blur(5px)" );

            $lefty.animate({
                left: 0
            });

            keyToggle = 1;

        }else if(key == 188 && keyToggle == 1){

            var $lefty = $('#tools');

            $(".appIcon").css( "-webkit-filter", "blur(0px)" );
            $(".appIcon").css( "filter", "blur(0px)" );

            $("h1").css( "-webkit-filter", "blur(0px)" );;
            $("h1").css( "filter", "blur(0px)" );

            $lefty.animate({
                left: -$lefty.outerWidth()
            });

            keyToggle = 0;

        }else if(key == 37){
            window.location.href = $('#navLink').attr('href');;
        }
    }
});