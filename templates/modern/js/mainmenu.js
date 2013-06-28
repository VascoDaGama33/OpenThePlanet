Main_Menu = function() {
    
    
    if (typeof(jQuery) == 'undefined') {
        return;
    }
    
    var nav_list = "#nav_menu";
    
    var menu_item = "div.nav-menu-item";
    
    var sub_menu = "div.sub_menu";


    // Позволяет вести mouseout как mouseleave, для кроссбраузерности
    function handleMouseLeave(handler) {
 
        return function(e) {
            e = e || event; // IE
            var toElement = e.relatedTarget || e.toElement; // IE
 
            // проверяем, мышь ушла на элемент внутри текущего?
            while (toElement && toElement !== this) {
                toElement = toElement.parentNode;
            }
 
            if (toElement == this) { // да, мы всё еще внутри родителя
                return; // мы перешли с родителя на потомка, лишнее событие
            }
 
            return handler.call(this, e);
        };
    }
    
    // Позволяет вести mouseover как mouseenter, для кроссбраузерности
    function handleMouseEnter(handler) {
 
        return function(e) {
            e = e || event; // IE
            var toElement = e.relatedTarget || e.srcElement; // IE
 
            // проверяем, мышь пришла с элемента внутри текущего?
            while (toElement && toElement !== this) {
                toElement = toElement.parentNode;
            }
 
            if (toElement == this) { // да, мышь перешла изнутри родителя
                return; // мы перешли на родителя из потомка, лишнее событие
            }
 
            return handler.call(this, e);
        };
    }

    /*
    $(nav_list + ' ' + menu_item).bind("mouseover", handleMouseEnter(function(e) {
        e = e || event;
        var target = e.target || e.srcElement;
        $(this).find(sub_menu + ":first").fadeIn('slow');
    }
    )   
    );
        
    $(nav_list + ' ' + menu_item).bind("mouseout", handleMouseLeave(function(e) {
        e = e || event;
        var target = e.target || e.srcElement;
        $(this).find(sub_menu + ":first").fadeOut('slow');
    }
    )   
    );*/
    
    $(nav_list + ' ' + menu_item).hover(
    function () {
        $(this).find(sub_menu).fadeIn();
    },
    function () {
        $(this).find(sub_menu).stop(true, true).fadeOut();
    }
    );
        
    
}

