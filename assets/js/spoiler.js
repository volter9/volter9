/**
 * KISS Spoiler.js and Tabs.js
 * 
 * @author volter9
 * @tags говнокод
 */
window.addEventListener('DOMContentLoaded', function () {
    var div = document.createElement('div'),
        toggleHTML = '<div class="spoiler-toggle">'
            + '<span class="spoiler-icon">»</span>'
            + '</div>';
    
    /** Turn array-like object into Array */
    var toA = function (arrayLike) {
        return Array.prototype.slice.call(arrayLike);
    };
    
    /** querySelectorAll */
    var $ = function (selector, node) {
        node = node || document;
        
        return toA(node.querySelectorAll(selector));
    };
    
    /** Add event listener on DOM node */
    var on = function (node, event, listener) {
        node.addEventListener(event, listener);
    };
    
    /** Create DOM node from html */
    var domNode = function (html) {
        div.innerHTML = html;
        
        return div.firstElementChild;
    };
    
    var hide = function (nodes) {
        nodes.forEach(function (node) {
            node.style.display = 'none';
        });
    };
    
    var show = function (nodes) {
        nodes.forEach(function (node) {
            node.style.display = '';
        });
    };
    
    var removeClass = function (nodes, className) {
        nodes.forEach(function (node) {
            node.classList.remove(className);
        });
    };
    
    var addClass = function (nodes, className) {
        nodes.forEach(function (node) {
            node.classList.add(className);
        });
    };
    
    var prepend = function (container, nodes) {
        nodes.forEach(function (node) {
            container.insertBefore(node, container.children[0]);
        });
    };
    
    var append = function (container, nodes) {
        nodes.forEach(function (node) {
            container.appendChild(node);
        });
    };
    
    /**
     * Spoiler.js
     */
    $('.spoiler').forEach(function (node) {
        var check = domNode(toggleHTML);
        
        on(check, 'click', function () {
            var state = this.classList.contains('spoiler-open');
            
            console.log(state);
            
            this.classList.toggle('spoiler-open', !state);
            node.classList.toggle('spoiler-open', !state);
            node.classList.toggle('spoiler-close', state);
        });
        
        node.appendChild(check);
        node.classList.add('spoiler-close');
    });
    
    /**
     * Tabs.js
     */
    $('.tabs-container').forEach(function (container) {
        var tabs = $('.tab', container),
            cells = $('[data-tab]');
        
        var c = domNode('<div class="tabs clearfix"></div>');
        
        prepend(container, [c]);
        append(c, tabs);
        
        tabs.forEach(function (tab) {
            on(tab, 'click', function () {
                var currentTab = tab.innerText.trim();
                
                removeClass(tabs, 'tab-active');
                addClass([tab], 'tab-active');
                
                hide(cells.filter(function (node) {
                    return node.dataset.tab !== currentTab;
                }));
                show($('[data-tab="' + currentTab + '"]', container));
            });
        });
        
        hide(cells);
        show(cells.slice(0, 1));
        addClass(tabs.slice(0, 1), 'tab-active');
    });
});