$(function() {

	$.wijets.make(); 	// Make yo Widjit - see docs for more details.
	prettyPrint(); 		//Apply Code Prettifier
	$(".bootstrap-switch").bootstrapSwitch(); // Bootstrap Switches


	// Bootstrap JS
    $('.popovers').popover({container: 'body', trigger: 'hover', placement: 'top'}); //bootstrap's popover
    $('.tooltips').tooltip(); //bootstrap's tooltip

    //Tabdrop
    jQuery.expr[':'].noparents = function(a,i,m){
            return jQuery(a).parents(m[3]).length < 1;
    }; // Only apply .tabdrop() whose parents are not (.tab-right or tab-left)
    $('.nav-tabs').filter(':noparents(.tab-right, .tab-left)').tabdrop();

	// Custom Checkboxes
	$('.icheck input').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue'
	});

	//Demo Background Pattern
	$(".demo-blocks").click(function(){
		$('.layout-boxed').css('background',$(this).css('background'));
		return false;
	});

	// Sparklines
        
        var sparker = function() {
            $('#bigline').sparkline([2,7,6,9,3,6,5], { 
            	type: 'line', 
            	lineColor: '#3f51b5', 
            	fill: 1, 
            	fillColor: '#3f51b5', 
            	height: '100px', 
            	width: '100%',
            	normalRangeMin: 0,
    			normalRangeMax: 10,
    			normalRangeColor: '#fff',
    			spotColor: 'transparent',
			    minSpotColor: 'transparent',
			    maxSpotColor: 'transparent',
			    highlightSpotColor: 'transparent',
			    highlightLineColor: 'transparent',
            	spotRadius: 4
            });
        }
        var sparkResize;
     
        $(window).resize(function(e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparker, 500);
        });
        sparker();
});