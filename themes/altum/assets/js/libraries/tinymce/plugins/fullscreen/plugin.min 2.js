/**
 * Copyright (c) Tiny Technologies, Inc. All rights reserved.
 * Licensed under the LGPL or a commercial license.
 * For LGPL see License.txt in the project root for license information.
 * For commercial licenses see https://www.tiny.cloud/
 *
 * Version: 5.0.1 (2019-02-21)
 */
!function(g){"use strict";var i=function(e){var n=e,t=function(){return n};return{get:t,set:function(e){n=e},clone:function(){return i(t())}}},e=tinymce.util.Tools.resolve("tinymce.PluginManager"),t=function(e){return{isFullscreen:function(){return null!==e.get()}}},n=tinymce.util.Tools.resolve("tinymce.dom.DOMUtils"),m=function(e,n){e.fire("FullscreenStateChanged",{state:n})},w=n.DOM,r=function(e,n){var t,r,o,i,l,c,u=g.document.body,s=g.document.documentElement,d=n.get(),a=function(){var e,n,t,i;w.setStyle(o,"height",(t=g.window,i=g.document.body,i.offsetWidth&&(e=i.offsetWidth,n=i.offsetHeight),t.innerWidth&&t.innerHeight&&(e=t.innerWidth,n=t.innerHeight),{w:e,h:n}).h-(r.clientHeight-o.clientHeight))},f=function(){w.unbind(g.window,"resize",a)};if(t=(r=e.getContainer()).style,i=(o=e.get_contentAreaContainer().firstChild).style,d)i.width=d.iframeWidth,i.height=d.iframeHeight,d.containerWidth&&(t.width=d.containerWidth),d.containerHeight&&(t.height=d.containerHeight),w.removeClass(u,"tox-fullscreen"),w.removeClass(s,"tox-fullscreen"),w.removeClass(r,"tox-fullscreen"),l=d.scrollPos,g.window.scrollTo(l.x,l.y),w.unbind(g.window,"resize",d.resizeHandler),e.off("remove",d.removeHandler),n.set(null),m(e,!1);else{var h={scrollPos:(c=w.getViewPort(),{x:c.x,y:c.y}),containerWidth:t.width,containerHeight:t.height,iframeWidth:i.width,iframeHeight:i.height,resizeHandler:a,removeHandler:f};i.width=i.height="100%",t.width=t.height="",w.addClass(u,"tox-fullscreen"),w.addClass(s,"tox-fullscreen"),w.addClass(r,"tox-fullscreen"),w.bind(g.window,"resize",a),e.on("remove",f),a(),n.set(h),m(e,!0)}},o=function(e,n){e.addCommand("mceFullScreen",function(){r(e,n)})},l=function(t,i){return function(n){n.setActive(null!==i.get());var e=function(e){return n.setActive(e.state)};return t.on("FullscreenStateChanged",e),function(){return t.off("FullscreenStateChanged",e)}}},c=function(e,n){e.ui.registry.addToggleMenuItem("fullscreen",{text:"Fullscreen",shortcut:"Meta+Shift+F",onAction:function(){return e.execCommand("mceFullScreen")},onSetup:l(e,n)}),e.ui.registry.addToggleButton("fullscreen",{tooltip:"Fullscreen",icon:"fullscreen",onAction:function(){return e.execCommand("mceFullScreen")},onSetup:l(e,n)})};e.add("fullscreen",function(e){var n=i(null);return e.settings.inline||(o(e,n),c(e,n),e.addShortcut("Meta+Shift+F","","mceFullScreen")),t(n)}),function u(){}}(window);
