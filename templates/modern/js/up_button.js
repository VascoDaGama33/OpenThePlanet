function upButtonHandler() {
    
    var jqueryEnabled = true;
    
    if (typeof(jQuery) == 'undefined') {
        jqueryEnabled = false;
    }
    
    var createElements = '<div id="BackTopWrapper"><div id="BackTopButton"><div></div></div><div id="BackTopFont"></div></div>';
    
    if(jqueryEnabled) {
        $('body').append(createElements);
    } else {
        var container = document.createElement('div');
        container.innerHTML = createElements;
        document.body.appendChild(container.firstChild);
    }
                
    var jqLocker = false;
    
    var jqAnimation = true;
    
    var updownElem = document.getElementById('BackTopButton');
    
    var wrapElem = document.getElementById('BackTopWrapper');
    
    var fontElem = document.getElementById('BackTopFont');
    
    var jqUpdownElem, jqWrapElem, jqFontElem;
    
    if(jqueryEnabled && jqAnimation) {
        
        jqUpdownElem = $('#BackTopButton');
        
        jqWrapElem = $('#BackTopWrapper');
        
        jqFontElem = $('#BackTopFont');
        
    }
    

    var pageYLabel = 0;
    

    wrapElem.onclick = function() {
        var pageY = window.pageYOffset || document.documentElement.scrollTop;
        
        switch(updownElem.className) {
            case 'backUp':
                
                if(jqueryEnabled && jqAnimation) {
                    if(jqLocker == true) {
                        return;
                    }
                    jqLocker = true;
                    $('body,html').animate({
                        scrollTop: 0
                    }, 500, 'linear', function(){
                        pageYLabel = pageY;
                        jqUpdownElem.removeClass().addClass('backDown');
                        jqLocker = false;
                    }); 
                
                } else {
                    pageYLabel = pageY;
                    window.scrollTo(0, 0);
                    updownElem.className = 'backDown';
                }
                break;

            case 'backDown':
                
                if(jqueryEnabled && jqAnimation) {
                    if(jqLocker == true) {
                        return;
                    }
                    jqLocker = true;
                    $('body,html').animate({
                        scrollTop: pageYLabel
                    }, 500, 'linear', function(){
                        jqUpdownElem.removeClass().addClass('backUp');
                        jqLocker = false;
                    }); 
                } else {
                    window.scrollTo(0, pageYLabel);
                    updownElem.className = 'backUp';
                }
                break;
        }

    }

    window.onscroll = function() {
        var pageY = window.pageYOffset || document.documentElement.scrollTop;
        var innerHeight = document.documentElement.clientHeight;

        if(jqLocker) {
            return;
        }

        switch(updownElem.className) {
            case '':
                if (pageY > innerHeight) {
                    showWrap();
                }
                break;

            case 'backUp':
                if (pageY < innerHeight) {
                    hideWrap();
                }
                break;

            case 'backDown':
                if (pageY > pageYLabel) {
                    showWrap();
                } 
                break;

        }
    }
    
    wrapElem.onmouseover = function() {
        if(jqueryEnabled && jqAnimation) {
            jqFontElem.stop(true, true).fadeTo('medium', 0.6);
	     //jqFontElem.stop(true, true).fadeIn();
        } else {
            fontElem.style.display = 'block';
        }
    }
    wrapElem.onmouseout = function() {
        if(jqueryEnabled && jqAnimation) {
            jqFontElem.stop(true, true).fadeOut();
        } else {
            fontElem.style.display = 'none';
        }
    }
    

    
    function showWrap() {
        if(jqueryEnabled && jqAnimation) {
            jqUpdownElem.removeClass().addClass('backUp');
            jqWrapElem.fadeIn('medium');
        } else {
            wrapElem.style.display = 'block';
            updownElem.className = 'backUp';
        }
    }
    
    function hideWrap() {
        if(jqueryEnabled && jqAnimation) {
            jqWrapElem.fadeOut('medium', function() {jqUpdownElem.removeClass();});
        } else {
            wrapElem.style.display = 'none';
            updownElem.className = '';
        }
    }

};

