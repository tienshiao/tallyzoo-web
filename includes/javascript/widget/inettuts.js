/*
 * Script from NETTUTS.com [by James Padolsey]
 * @requires jQuery($), jQuery UI & sortable/draggable UI modules
 */

var iNettuts = {
    
    jQuery : $,
    /* Specify selectors */  
    settings : {
        columns : '.column',/// Main div
        widgetSelector: '.widget',//Subdiv
        handleSelector: '.widget-head',///Subdiv header
        contentSelector: '.widget-content',///Subdiv Content

		 /* Settings for the Widgets: */  
        widgetDefault : {
            movable: true,
            removable: false,
            collapsible: false,
            editable: false,
            colorClasses : ['color-yellow', 'color-red', 'color-blue', 'color-white', 'color-orange', 'color-green','color-violate']
        },///Default Setting for all div
        widgetIndividual : {
            intro : {
                movable: false,
                removable: false,
                collapsible: false,
                editable: false
            }
        }///Individual Settings
    },

    init : function () {
        this.attachStylesheet('inettuts.js.css');
        this.addWidgetControls();
        this.makeSortable();
    },
    
    getWidgetSettings : function (id) {
        var $ = this.jQuery,
            settings = this.settings;
        return (id&&settings.widgetIndividual[id]) ? $.extend({},settings.widgetDefault,settings.widgetIndividual[id]) : settings.widgetDefault;
    },
    
	// This function will add controls to each widget
    addWidgetControls : function () {
        var iNettuts = this,
            $ = this.jQuery,
            settings = this.settings;
            
        $(settings.widgetSelector, $(settings.columns)).each(function () {
			 var thisWidgetSettings = iNettuts.getWidgetSettings(this.id);
            if (thisWidgetSettings.removable)
				{  
                $('<a href="#" class="remove"></a>').mousedown(function (e) {
                    e.stopPropagation();    
                }).click(function () {
                    if(confirm('This widget will be removed, ok?')) { 
                        $(this).parents(settings.widgetSelector).animate({
                            opacity: 0    
                        },function () { 
							obj = $(this)[0].getElementsByTagName('DIV');
							len = obj.length;
							for(i=0;i<len;i++)
							{
								id = obj[i].id;
								if(id.indexOf("mod_") != -1)
								{
									arr = id.split('_');
									//alert(arr[1]);
								}
								
							}

                            $(this).wrap('<div/>').parent().slideUp(function () {
							 $(this).remove();
                            });
                        });
                    }
                    return false;
                }).appendTo($(settings.handleSelector, this));
            }
            
            if (thisWidgetSettings.editable) {
              $('<a href="#" class="edit"></a>').mousedown(function (e) {
                    e.stopPropagation();    
                }).toggle(function () {
                    $(this).css({backgroundPosition: '-66px 0', width: '55px'})
                        .parents(settings.widgetSelector)
                            .find('.edit-box').show().find('input').focus();
                    return false;
                },function () {
                    $(this).css({backgroundPosition: '', width: ''})
                        .parents(settings.widgetSelector)
                            .find('.edit-box').hide();
                    return false;
                }).appendTo($(settings.handleSelector,this));
               $('<div class="edit-box" style="display:none;"/>')
                    .append('<ul><li class="item"><label>Change the title?</label><input value="' + $('h3',this).text() + '"/></li>')
                    .append((function(){
                        var colorList = '<li class="item"><label>Available colors:</label><ul class="colors">';
                        $(thisWidgetSettings.colorClasses).each(function () {
                            colorList += '<li class="' + this + '"/>';
                        });
                        return colorList + '</ul>';
                    })())
                    .append('</ul>')
                    .insertAfter($(settings.handleSelector,this));
            }
            
            if (thisWidgetSettings.collapsible) {
                $('<a href="#" class="collapse"></a>').mousedown(function (e) {
                    e.stopPropagation();    
                }).toggle(function () {
                    $(this).css({backgroundPosition: '-38px 0'})
                        .parents(settings.widgetSelector)
                            .find(settings.contentSelector).hide();
                    return false;
                },function () { 
                    $(this).css({backgroundPosition: '-52px 0'})
                        .parents(settings.widgetSelector)
                            .find(settings.contentSelector).show();
                    return false;
                }).prependTo($(settings.handleSelector,this));
            }
        });
        
        $('.edit-box').each(function () {
            $('input',this).keyup(function () {
                $(this).parents(settings.widgetSelector).find('h3').text( $(this).val().length>20 ? $(this).val().substr(0,20)+'...' : $(this).val() );
            });
            $('ul.colors li',this).click(function () {
                
                var colorStylePattern = /\bcolor-[\w]{1,}\b/,
                    thisWidgetColorClass = $(this).parents(settings.widgetSelector).attr('class').match(colorStylePattern)
                if (thisWidgetColorClass) {
                    $(this).parents(settings.widgetSelector)
                        .removeClass(thisWidgetColorClass[0])
                        .addClass($(this).attr('class').match(colorStylePattern)[0]);
					//swap class names  
                }
                return false;
                
            });
        });
        
    },
    
    attachStylesheet : function (href) {
        var $ = this.jQuery;
        return $('<link href="' + href + '" rel="stylesheet" type="text/css" />').appendTo('head');
    },
    
    makeSortable : function () {
        var iNettuts = this,
            $ = this.jQuery,
            settings = this.settings,
            $sortableItems = (function ()
			{
			// Define an empty string which can add to within the loop: 
                var notSortable = '';

				// Loop through each widget within the columns: 
                $(settings.widgetSelector,$(settings.columns)).each(function (i) {

					  // If the 'movable' property is set to false:  
                    if (!iNettuts.getWidgetSettings(this.id).movable) {

						// If this widget has NO ID:   
                        if(!this.id) {

							 // Give it an automatically generated ID:  
                            this.id = 'widget-no-id-' + i;
                        }

						// Add the ID to the 'notSortable' string: 
                        notSortable += '#' + this.id + ',';
                    }
                });

			/* 
			* This function will return a jQuery object containing 
			* those widgets which are movable. 
			*/ 
                return $('> li:not(' + notSortable + ')', settings.columns);
            })();
        
        $sortableItems.find(settings.handleSelector).css({
            cursor: 'move'
        }).mousedown(function (e) {
            $sortableItems.css({width:''});
            $(this).parent().css({
                width: $(this).parent().width() + 'px'
            });
        }).mouseup(function () {
            if(!$(this).parent().hasClass('dragging')) {
                $(this).parent().css({width:''});
            } else {
                $(settings.columns).sortable('disable');
            }
        });

        $(settings.columns).sortable({
            items: $sortableItems,
            connectWith: $(settings.columns),
            handle: settings.handleSelector,
            placeholder: 'widget-placeholder',
            forcePlaceholderSize: true,
            revert: 500,
            delay: 100,
            opacity: 0.8,
            containment: 'document',
            start: function (e,ui) {
                $(ui.helper).addClass('dragging');
            },
            stop: function (e,ui) {
                $(ui.item).css({width:''}).removeClass('dragging');
                $(settings.columns).sortable('enable');
				//this function added by deepak
				saveCloumn();
            }
        });
    }
  
};

iNettuts.init();