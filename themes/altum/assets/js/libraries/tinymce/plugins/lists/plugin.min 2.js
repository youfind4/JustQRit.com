/**
 * Copyright (c) Tiny Technologies, Inc. All rights reserved.
 * Licensed under the LGPL or a commercial license.
 * For LGPL see License.txt in the project root for license information.
 * For commercial licenses see https://www.tiny.cloud/
 *
 * Version: 5.0.1 (2019-02-21)
 */
!function(u){"use strict";var e,n,t,r,o,i,s,a,c=tinymce.util.Tools.resolve("tinymce.PluginManager"),f=tinymce.util.Tools.resolve("tinymce.dom.RangeUtils"),d=tinymce.util.Tools.resolve("tinymce.dom.TreeWalker"),l=tinymce.util.Tools.resolve("tinymce.util.VK"),p=tinymce.util.Tools.resolve("tinymce.dom.BookmarkManager"),v=tinymce.util.Tools.resolve("tinymce.util.Tools"),m=tinymce.util.Tools.resolve("tinymce.dom.DOMUtils"),g=function(e){return e&&"BR"===e.nodeName},h=function(e){return e&&3===e.nodeType},y=function(e){return e&&/^(OL|UL|DL)$/.test(e.nodeName)},N=function(e){return e&&/^(OL|UL)$/.test(e.nodeName)},S=function(e){return e&&/^(DT|DD)$/.test(e.nodeName)},O=function(e){return e&&/^(LI|DT|DD)$/.test(e.nodeName)},C=function(e){return e&&/^(TH|TD)$/.test(e.nodeName)},b=g,T=function(e,n){return n&&!!e.schema.getTextBlockElements()[n.nodeName]},L=function(e,n){return e&&e.nodeName in n},D=function(e,n){return!!g(n)&&!(!e.isBlock(n.nextSibling)||g(n.previousSibling))},E=function(e,n,t){var r=e.isEmpty(n);return!(t&&0<e.select("span[data-mce-type=bookmark]",n).length)&&r},w=function(e,n){return e.isChildOf(n,e.getRoot())},k=function(e,n){if(h(e))return{container:e,offset:n};var t=f.getNode(e,n);return h(t)?{container:t,offset:n>=e.childNodes.length?t.data.length:0}:t.previousSibling&&h(t.previousSibling)?{container:t.previousSibling,offset:t.previousSibling.data.length}:t.nextSibling&&h(t.nextSibling)?{container:t.nextSibling,offset:0}:{container:e,offset:n}},A=function(e){var n=e.cloneRange(),t=k(e.startContainer,e.startOffset);n.setStart(t.container,t.offset);var r=k(e.endContainer,e.endOffset);return n.setEnd(r.container,r.offset),n},x=m.DOM,R=function(o){var i={},e=function(e){var n,t,r;t=o[e?"startContainer":"endContainer"],r=o[e?"startOffset":"endOffset"],1===t.nodeType&&(n=x.create("span",{"data-mce-type":"bookmark"}),t.hasChildNodes()?(r=Math.min(r,t.childNodes.length-1),e?t.insertBefore(n,t.childNodes[r]):x.insertAfter(n,t.childNodes[r])):t.appendChild(n),t=n,r=0),i[e?"startContainer":"endContainer"]=t,i[e?"startOffset":"endOffset"]=r};return e(!0),o.collapsed||e(),i},I=function(o){function e(e){var n,t,r;n=r=o[e?"startContainer":"endContainer"],t=o[e?"startOffset":"endOffset"],n&&(1===n.nodeType&&(t=function(e){for(var n=e.parentNode.firstChild,t=0;n;){if(n===e)return t;1===n.nodeType&&"bookmark"===n.getAttribute("data-mce-type")||t++,n=n.nextSibling}return-1}(n),n=n.parentNode,x.remove(r),!n.hasChildNodes()&&x.isBlock(n)&&n.appendChild(x.create("br"))),o[e?"startContainer":"endContainer"]=n,o[e?"startOffset":"endOffset"]=t)}e(!0),e();var n=x.createRng();return n.setStart(o.startContainer,o.startOffset),o.endContainer&&n.setEnd(o.endContainer,o.endOffset),A(n)},_=function(e){return function(){return e}},B=function(t){return function(){for(var e=[],n=0;n<arguments.length;n++)e[n]=arguments[n];return!t.apply(null,e)}},P=_(!1),M=_(!0),U=P,F=M,j=function(){return H},H=(r={fold:function(e,n){return e()},is:U,isSome:U,isNone:F,getOr:t=function(e){return e},getOrThunk:n=function(e){return e()},getOrDie:function(e){throw new Error(e||"error: getOrDie called on none.")},getOrNull:function(){return null},getOrUndefined:function(){return undefined},or:t,orThunk:n,map:j,ap:j,each:function(){},bind:j,flatten:j,exists:U,forall:F,filter:j,equals:e=function(e){return e.isNone()},equals_:e,toArray:function(){return[]},toString:_("none()")},Object.freeze&&Object.freeze(r),r),$=function(t){var e=function(){return t},n=function(){return o},r=function(e){return e(t)},o={fold:function(e,n){return n(t)},is:function(e){return t===e},isSome:F,isNone:U,getOr:e,getOrThunk:e,getOrDie:e,getOrNull:e,getOrUndefined:e,or:n,orThunk:n,map:function(e){return $(e(t))},ap:function(e){return e.fold(j,function(e){return $(e(t))})},each:function(e){e(t)},bind:r,flatten:e,exists:r,forall:r,filter:function(e){return e(t)?o:H},equals:function(e){return e.is(t)},equals_:function(e,n){return e.fold(U,function(e){return n(t,e)})},toArray:function(){return[t]},toString:function(){return"some("+t+")"}};return o},q={some:$,none:j,from:function(e){return null===e||e===undefined?H:$(e)}},W=function(n){return function(e){return function(e){if(null===e)return"null";var n=typeof e;return"object"===n&&Array.prototype.isPrototypeOf(e)?"array":"object"===n&&String.prototype.isPrototypeOf(e)?"string":n}(e)===n}},z=W("string"),K=W("boolean"),V=W("function"),X=W("number"),Q=function(e,n){for(var t=e.length,r=new Array(t),o=0;o<t;o++){var i=e[o];r[o]=n(i,o,e)}return r},Y=function(e,n){for(var t=0,r=e.length;t<r;t++)n(e[t],t,e)},G=function(e,n){for(var t=[],r=0,o=e.length;r<o;r++){var i=e[r];n(i,r,e)&&t.push(i)}return t},J=function(e,n,t){return Y(e,function(e){t=n(t,e)}),t},Z=function(e,n){for(var t=0,r=e.length;t<r;t++){var o=e[t];if(n(o,t,e))return q.some(o)}return q.none()},ee=Array.prototype.push,ne=function(e,n){return function(e){for(var n=[],t=0,r=e.length;t<r;++t){if(!Array.prototype.isPrototypeOf(e[t]))throw new Error("Arr.flatten item "+t+" was not an array, input: "+e);ee.apply(n,e[t])}return n}(Q(e,n))},te=Array.prototype.slice,re=function(e){return 0===e.length?q.none():q.some(e[0])},oe=function(e){return 0===e.length?q.none():q.some(e[e.length-1])},ie=(V(Array.from)&&Array.from,"undefined"!=typeof window?window:Function("return this;")()),ue=function(e,n){return function(e,n){for(var t=n!==undefined&&null!==n?n:ie,r=0;r<e.length&&t!==undefined&&null!==t;++r)t=t[e[r]];return t}(e.split("."),n)},se=function(e,n){var t=ue(e,n);if(t===undefined||null===t)throw e+" not available on this browser";return t},ae=function(e){var n,t=ue("ownerDocument.defaultView",e);return(n=t,se("HTMLElement",n)).prototype.isPrototypeOf(e)},ce=tinymce.util.Tools.resolve("tinymce.dom.DomQuery"),fe=function(e){var n=e.selection.getStart(!0);return e.dom.getParent(n,"OL,UL,DL",le(e,n))},de=function(e){var t,n,r,o=e.selection.getSelectedBlocks();return v.grep((t=e,n=o,r=v.map(n,function(e){var n=t.dom.getParent(e,"li,dd,dt",le(t,e));return n||e}),ce.unique(r)),function(e){return O(e)})},le=function(e,n){var t=e.dom.getParents(n,"TD,TH");return 0<t.length?t[0]:e.getBody()},me=function(e,n){var t=e.dom.getParents(n,"ol,ul",le(e,n));return oe(t)},ge=function(n,e){var t=Q(e,function(e){return me(n,e).getOr(e)});return ce.unique(t)},pe={isList:function(e){var n=fe(e);return ae(n)},getParentList:fe,getSelectedSubLists:function(e){var n,t,r,o=fe(e),i=e.selection.getSelectedBlocks();return r=i,(t=o)&&1===r.length&&r[0]===t?(n=o,v.grep(n.querySelectorAll("ol,ul,dl"),function(e){return y(e)})):v.grep(i,function(e){return y(e)&&o!==e})},getSelectedListItems:de,getClosestListRootElm:le,getSelectedDlItems:function(e){return G(de(e),S)},getSelectedListRoots:function(e){var n,t,r,o=(t=me(n=e,n.selection.getStart()),r=G(n.selection.getSelectedBlocks(),N),t.toArray().concat(r));return ge(e,o)}},ve=function(e){if(null===e||e===undefined)throw new Error("Node cannot be null or undefined");return{dom:_(e)}},he={fromHtml:function(e,n){var t=(n||u.document).createElement("div");if(t.innerHTML=e,!t.hasChildNodes()||1<t.childNodes.length)throw u.console.error("HTML does not have a single root node",e),new Error("HTML must have a single root node");return ve(t.childNodes[0])},fromTag:function(e,n){var t=(n||u.document).createElement(e);return ve(t)},fromText:function(e,n){var t=(n||u.document).createTextNode(e);return ve(t)},fromDom:ve,fromPoint:function(e,n,t){var r=e.dom();return q.from(r.elementFromPoint(n,t)).map(ve)}},ye=function(e,n){for(var t=[],r=0;r<e.length;r++){var o=e[r];if(!o.isSome())return q.none();t.push(o.getOrDie())}return q.some(n.apply(null,t))},Ne=Object.keys,Se=function(){return se("Node")},Oe=function(e,n,t){return 0!=(e.compareDocumentPosition(n)&t)},Ce=function(e,n){return Oe(e,n,Se().DOCUMENT_POSITION_CONTAINED_BY)},be=function(e,n){var t=function(e,n){for(var t=0;t<e.length;t++){var r=e[t];if(r.test(n))return r}return undefined}(e,n);if(!t)return{major:0,minor:0};var r=function(e){return Number(n.replace(t,"$"+e))};return Le(r(1),r(2))},Te=function(){return Le(0,0)},Le=function(e,n){return{major:e,minor:n}},De={nu:Le,detect:function(e,n){var t=String(n).toLowerCase();return 0===e.length?Te():be(e,t)},unknown:Te},Ee="Firefox",we=function(e,n){return function(){return n===e}},ke=function(e){var n=e.current;return{current:n,version:e.version,isEdge:we("Edge",n),isChrome:we("Chrome",n),isIE:we("IE",n),isOpera:we("Opera",n),isFirefox:we(Ee,n),isSafari:we("Safari",n)}},Ae={unknown:function(){return ke({current:undefined,version:De.unknown()})},nu:ke,edge:_("Edge"),chrome:_("Chrome"),ie:_("IE"),opera:_("Opera"),firefox:_(Ee),safari:_("Safari")},xe="Windows",Re="Android",Ie="Solaris",_e="FreeBSD",Be=function(e,n){return function(){return n===e}},Pe=function(e){var n=e.current;return{current:n,version:e.version,isWindows:Be(xe,n),isiOS:Be("iOS",n),isAndroid:Be(Re,n),isOSX:Be("OSX",n),isLinux:Be("Linux",n),isSolaris:Be(Ie,n),isFreeBSD:Be(_e,n)}},Me={unknown:function(){return Pe({current:undefined,version:De.unknown()})},nu:Pe,windows:_(xe),ios:_("iOS"),android:_(Re),linux:_("Linux"),osx:_("OSX"),solaris:_(Ie),freebsd:_(_e)},Ue=function(e,n){var t=String(n).toLowerCase();return Z(e,function(e){return e.search(t)})},Fe=function(e,t){return Ue(e,t).map(function(e){var n=De.detect(e.versionRegexes,t);return{current:e.name,version:n}})},je=function(e,t){return Ue(e,t).map(function(e){var n=De.detect(e.versionRegexes,t);return{current:e.name,version:n}})},He=function(e,n){return-1!==e.indexOf(n)},$e=/.*?version\/\ ?([0-9]+)\.([0-9]+).*/,qe=function(n){return function(e){return He(e,n)}},We=[{name:"Edge",versionRegexes:[/.*?edge\/ ?([0-9]+)\.([0-9]+)$/],search:function(e){return He(e,"edge/")&&He(e,"chrome")&&He(e,"safari")&&He(e,"applewebkit")}},{name:"Chrome",versionRegexes:[/.*?chrome\/([0-9]+)\.([0-9]+).*/,$e],search:function(e){return He(e,"chrome")&&!He(e,"chromeframe")}},{name:"IE",versionRegexes:[/.*?msie\ ?([0-9]+)\.([0-9]+).*/,/.*?rv:([0-9]+)\.([0-9]+).*/],search:function(e){return He(e,"msie")||He(e,"trident")}},{name:"Opera",versionRegexes:[$e,/.*?opera\/([0-9]+)\.([0-9]+).*/],search:qe("opera")},{name:"Firefox",versionRegexes:[/.*?firefox\/\ ?([0-9]+)\.([0-9]+).*/],search:qe("firefox")},{name:"Safari",versionRegexes:[$e,/.*?cpu os ([0-9]+)_([0-9]+).*/],search:function(e){return(He(e,"safari")||He(e,"mobile/"))&&He(e,"applewebkit")}}],ze=[{name:"Windows",search:qe("win"),versionRegexes:[/.*?windows\ nt\ ?([0-9]+)\.([0-9]+).*/]},{name:"iOS",search:function(e){return He(e,"iphone")||He(e,"ipad")},versionRegexes:[/.*?version\/\ ?([0-9]+)\.([0-9]+).*/,/.*cpu os ([0-9]+)_([0-9]+).*/,/.*cpu iphone os ([0-9]+)_([0-9]+).*/]},{name:"Android",search:qe("android"),versionRegexes:[/.*?android\ ?([0-9]+)\.([0-9]+).*/]},{name:"OSX",search:qe("os x"),versionRegexes:[/.*?os\ x\ ?([0-9]+)_([0-9]+).*/]},{name:"Linux",search:qe("linux"),versionRegexes:[]},{name:"Solaris",search:qe("sunos"),versionRegexes:[]},{name:"FreeBSD",search:qe("freebsd"),versionRegexes:[]}],Ke={browsers:_(We),oses:_(ze)},Ve=function(e){var n,t,r,o,i,u,s,a,c,f,d,l=Ke.browsers(),m=Ke.oses(),g=Fe(l,e).fold(Ae.unknown,Ae.nu),p=je(m,e).fold(Me.unknown,Me.nu);return{browser:g,os:p,deviceType:(t=g,r=e,o=(n=p).isiOS()&&!0===/ipad/i.test(r),i=n.isiOS()&&!o,u=n.isAndroid()&&3===n.version.major,s=n.isAndroid()&&4===n.version.major,a=o||u||s&&!0===/mobile/i.test(r),c=n.isiOS()||n.isAndroid(),f=c&&!a,d=t.isSafari()&&n.isiOS()&&!1===/safari/i.test(r),{isiPad:_(o),isiPhone:_(i),isTablet:_(a),isPhone:_(f),isTouch:_(c),isAndroid:n.isAndroid,isiOS:n.isiOS,isWebView:_(d)})}},Xe={detect:(o=function(){var e=u.navigator.userAgent;return Ve(e)},s=!1,function(){for(var e=[],n=0;n<arguments.length;n++)e[n]=arguments[n];return s||(s=!0,i=o.apply(null,e)),i})},Qe=(u.Node.ATTRIBUTE_NODE,u.Node.CDATA_SECTION_NODE,u.Node.COMMENT_NODE,u.Node.DOCUMENT_NODE,u.Node.DOCUMENT_TYPE_NODE,u.Node.DOCUMENT_FRAGMENT_NODE,u.Node.ELEMENT_NODE),Ye=(u.Node.TEXT_NODE,u.Node.PROCESSING_INSTRUCTION_NODE,u.Node.ENTITY_REFERENCE_NODE,u.Node.ENTITY_NODE,u.Node.NOTATION_NODE,Qe),Ge=function(e,n){return e.dom()===n.dom()},Je=Xe.detect().browser.isIE()?function(e,n){return Ce(e.dom(),n.dom())}:function(e,n){var t=e.dom(),r=n.dom();return t!==r&&t.contains(r)},Ze=function(e,n){var t=e.dom();if(t.nodeType!==Ye)return!1;if(t.matches!==undefined)return t.matches(n);if(t.msMatchesSelector!==undefined)return t.msMatchesSelector(n);if(t.webkitMatchesSelector!==undefined)return t.webkitMatchesSelector(n);if(t.mozMatchesSelector!==undefined)return t.mozMatchesSelector(n);throw new Error("Browser lacks native selectors")},en=function(e){var n=e.dom();return q.from(n.parentNode).map(he.fromDom)},nn=function(e){var n=e.dom();return Q(n.childNodes,he.fromDom)},tn=function(e,n){var t=e.dom().childNodes;return q.from(t[n]).map(he.fromDom)},rn=function(e){return tn(e,0)},on=function(e){return tn(e,e.dom().childNodes.length-1)},un=(function(){for(var e=[],n=0;n<arguments.length;n++)e[n]=arguments[n]}("element","offset"),function(n,t){en(n).each(function(e){e.dom().insertBefore(t.dom(),n.dom())})}),sn=function(e,n){e.dom().appendChild(n.dom())},an=function(n,e){Y(e,function(e){sn(n,e)})},cn=function(e){var n=e.dom();null!==n.parentNode&&n.parentNode.removeChild(n)},fn=function(e){return e.dom().nodeName.toLowerCase()},dn=function(e,n){var t=e.dom();!function(e,n){for(var t=Ne(e),r=0,o=t.length;r<o;r++){var i=t[r];n(e[i],i,e)}}(n,function(e,n){!function(e,n,t){if(!(z(t)||K(t)||X(t)))throw u.console.error("Invalid call to Attr.set. Key ",n,":: Value ",t,":: Element ",e),new Error("Attribute value was not simple");e.setAttribute(n,t+"")}(t,n,e)})},ln=function(e){return J(e.dom().attributes,function(e,n){return e[n.name]=n.value,e},{})},mn=function(e,n,t){if(!z(t))throw u.console.error("Invalid call to CSS.set. Property ",n,":: Value ",t,":: Element ",e),new Error("CSS value must be a string: "+t);e.style!==undefined&&e.style.setProperty(n,t)},gn=function(e){return n=e,t=!0,he.fromDom(n.dom().cloneNode(t));var n,t},pn=function(e,n){var t,r,o,i,u=(t=e,r=n,o=he.fromTag(r),i=ln(t),dn(o,i),o);un(e,u);var s=nn(e);return an(u,s),cn(e),u},vn=function(e,n){sn(e.item,n.list)},hn=function(f,e,d){var n=e.slice(0,d.depth);return oe(n).each(function(e){var n,t,r,o,i,u,s,a,c=(n=f,t=d.itemAttributes,r=d.content,o=he.fromTag("li",n),dn(o,t),an(o,r),o);u=c,sn((i=e).list,u),i.item=u,a=d,fn((s=e).list)!==a.listType&&(s.list=pn(s.list,a.listType)),dn(s.list,a.listAttributes)}),n},yn=function(e,n,t){var r,o=function(e,n,t){for(var r,o,i,u=[],s=0;s<t;s++)u.push((r=e,o=n.listType,i={list:he.fromTag(o,r),item:he.fromTag("li",r)},sn(i.list,i.item),i));return u}(e,t,t.depth-n.length);return function(e){for(var n=1;n<e.length;n++)vn(e[n-1],e[n])}(o),function(e,n){for(var t=0;t<e.length-1;t++)r=e[t].item,o="list-style-type",i="none",u=r.dom(),mn(u,o,i);var r,o,i,u;oe(e).each(function(e){dn(e.list,n.listAttributes),dn(e.item,n.itemAttributes),an(e.item,n.content)})}(o,t),r=o,ye([oe(n),re(r)],vn),n.concat(o)},Nn=function(e){return Ze(e,"OL,UL")},Sn=function(e){return rn(e).map(Nn).getOr(!1)},On=function(e){return 0<e.depth},Cn=function(e){return e.isSelected},bn=function(e){var n=nn(e),t=on(e).map(Nn).getOr(!1)?n.slice(0,-1):n;return Q(t,gn)},Tn=Object.prototype.hasOwnProperty,Ln=(a=function(e,n){return n},function(){for(var e=new Array(arguments.length),n=0;n<e.length;n++)e[n]=arguments[n];if(0===e.length)throw new Error("Can't merge zero objects");for(var t={},r=0;r<e.length;r++){var o=e[r];for(var i in o)Tn.call(o,i)&&(t[i]=a(t[i],o[i]))}return t}),Dn=function(n){Y(n,function(r,e){(function(e,n){for(var t=e[n].depth,r=n-1;0<=r;r--){if(e[r].depth===t)return q.some(e[r]);if(e[r].depth<t)break}return q.none()})(n,e).each(function(e){var n,t;t=e,(n=r).listType=t.listType,n.listAttributes=Ln({},t.listAttributes)})})},En=function(e){var n=e,t=function(){return n};return{get:t,set:function(e){n=e},clone:function(){return En(t())}}},wn=function(i,u,s,a){return rn(a).filter(Nn).fold(function(){u.each(function(e){Ge(e.start,a)&&s.set(!0)});var n,t,r,e=(n=a,t=i,r=s.get(),en(n).map(function(e){return{depth:t,isSelected:r,content:bn(n),itemAttributes:ln(n),listAttributes:ln(e),listType:fn(e)}}));u.each(function(e){Ge(e.end,a)&&s.set(!1)});var o=on(a).filter(Nn).map(function(e){return kn(i,u,s,e)}).getOr([]);return e.toArray().concat(o)},function(e){return kn(i,u,s,e)})},kn=function(n,t,r,e){return ne(nn(e),function(e){return(Nn(e)?kn:wn)(n+1,t,r,e)})},An=tinymce.util.Tools.resolve("tinymce.Env"),xn=function(e,n){var t,r,o,i,u=e.dom,s=e.schema.getBlockElements(),a=u.createFragment();if(e.settings.forced_root_block&&(o=e.settings.forced_root_block),o&&((r=u.create(o)).tagName===e.settings.forced_root_block&&u.setAttribs(r,e.settings.forced_root_block_attrs),L(n.firstChild,s)||a.appendChild(r)),n)for(;t=n.firstChild;){var c=t.nodeName;i||"SPAN"===c&&"bookmark"===t.getAttribute("data-mce-type")||(i=!0),L(t,s)?(a.appendChild(t),r=null):o?(r||(r=u.create(o),a.appendChild(r)),r.appendChild(t)):a.appendChild(t)}return e.settings.forced_root_block?i||An.ie&&!(10<An.ie)||r.appendChild(u.create("br",{"data-mce-bogus":"1"})):a.appendChild(u.create("br")),a},Rn=function(e,n,t){return e.fire("ListMutation",{action:n,element:t})},In=function(i,e){return Q(e,function(e){var n,t,r,o=(n=e.content,r=(t||u.document).createDocumentFragment(),Y(n,function(e){r.appendChild(e.dom())}),he.fromDom(r));return he.fromDom(xn(i,o.dom()))})},_n=function(e,n){return Dn(n),(t=e.contentDocument,r=n,o=J(r,function(e,n){return n.depth>e.length?yn(t,e,n):hn(t,e,n)},[]),re(o).map(function(e){return e.list})).toArray();var t,r,o},Bn=function(e){var n,t,r=Q(pe.getSelectedListItems(e),he.fromDom);return ye([Z(r,B(Sn)),Z((n=r,t=te.call(n,0),t.reverse(),t),B(Sn))],function(e,n){return{start:e,end:n}})},Pn=function(s,e,a){var n,t,r,o=(n=e,t=Bn(s),r=En(!1),Q(n,function(e){return{sourceList:e,entries:kn(0,t,r,e)}}));Y(o,function(e){var n,t;n=e.entries,t=a,Y(G(n,Cn),function(e){return function(e,n){switch(e){case"Indent":n.depth++;break;case"Outdent":n.depth--;break;case"Flatten":n.depth=0}}(t,e)});var r,o,i,u=(r=s,o=e.entries,ne(function(e,n){if(0===e.length)return[];for(var t=n(e[0]),r=[],o=[],i=0,u=e.length;i<u;i++){var s=e[i],a=n(s);a!==t&&(r.push(o),o=[]),t=a,o.push(s)}return 0!==o.length&&r.push(o),r}(o,On),function(e){return re(e).map(On).getOr(!1)?_n(r,e):In(r,e)}));Y(u,function(e){Rn(s,"Indent"===a?"IndentList":"OutdentList",e.dom())}),i=e.sourceList,Y(u,function(e){un(i,e)}),cn(e.sourceList)})},Mn=m.DOM,Un=function(e,n,t){var r,o,i,u,s,a;for(i=Mn.select('span[data-mce-type="bookmark"]',n),s=xn(e,t),(r=Mn.createRng()).setStartAfter(t),r.setEndAfter(n),u=(o=r.extractContents()).firstChild;u;u=u.firstChild)if("LI"===u.nodeName&&e.dom.isEmpty(u)){Mn.remove(u);break}e.dom.isEmpty(o)||Mn.insertAfter(o,n),Mn.insertAfter(s,n),E(e.dom,t.parentNode)&&(a=t.parentNode,v.each(i,function(e){a.parentNode.insertBefore(e,t.parentNode)}),Mn.remove(a)),Mn.remove(t),E(e.dom,n)&&Mn.remove(n)},Fn=function(e){Ze(e,"DT")&&pn(e,"DD")},jn=function(r,e,n){Y(n,"Indent"===e?Fn:function(e){return n=r,void(Ze(t=e,"DD")?pn(t,"DT"):Ze(t,"DT")&&en(t).each(function(e){return Un(n,e.dom(),t.dom())}));var n,t})},Hn=function(e,n){var t=Q(pe.getSelectedListRoots(e),he.fromDom),r=Q(pe.getSelectedDlItems(e),he.fromDom),o=!1;if(t.length||r.length){var i=e.selection.getBookmark();Pn(e,t,n),jn(e,n,r),e.selection.moveToBookmark(i),e.selection.setRng(A(e.selection.getRng())),e.nodeChanged(),o=!0}return o},$n=function(e){return Hn(e,"Indent")},qn=function(e){return Hn(e,"Outdent")},Wn=function(e){return Hn(e,"Flatten")},zn=function(e){return/\btox\-/.test(e.className)},Kn=function(e){switch(e){case"UL":return"ToggleUlList";case"OL":return"ToggleOlList";case"DL":return"ToggleDLList"}},Vn=function(t,e){v.each(e,function(e,n){t.setAttribute(n,e)})},Xn=function(e,n,t){var r,o,i,u,s,a,c;r=e,o=n,u=(i=t)["list-style-type"]?i["list-style-type"]:null,r.setStyle(o,"list-style-type",u),s=e,Vn(a=n,(c=t)["list-attributes"]),v.each(s.select("li",a),function(e){Vn(e,c["list-item-attributes"])})},Qn=function(e,n,t,r){var o,i;for(o=n[t?"startContainer":"endContainer"],i=n[t?"startOffset":"endOffset"],1===o.nodeType&&(o=o.childNodes[Math.min(i,o.childNodes.length-1)]||o),!t&&b(o.nextSibling)&&(o=o.nextSibling);o.parentNode!==r;){if(T(e,o))return o;if(/^(TD|TH)$/.test(o.parentNode.nodeName))return o;o=o.parentNode}return o},Yn=function(f,d,l){void 0===l&&(l={});var e,n=f.selection.getRng(!0),m="LI",t=pe.getClosestListRootElm(f,f.selection.getStart(!0)),g=f.dom;"false"!==g.get_contentEditable(f.selection.getNode())&&("DL"===(d=d.toUpperCase())&&(m="DT"),e=R(n),v.each(function(t,e,r){for(var o,i=[],u=t.dom,n=Qn(t,e,!0,r),s=Qn(t,e,!1,r),a=[],c=n;c&&(a.push(c),c!==s);c=c.nextSibling);return v.each(a,function(e){if(T(t,e))return i.push(e),void(o=null);if(u.isBlock(e)||b(e))return b(e)&&u.remove(e),void(o=null);var n=e.nextSibling;p.isBookmarkNode(e)&&(T(t,n)||!n&&e.parentNode===r)?o=null:(o||(o=u.create("p"),e.parentNode.insertBefore(o,e),i.push(o)),o.appendChild(e))}),i}(f,n,t),function(e){var n,t,r,o,i,u,s,a,c;(t=e.previousSibling)&&y(t)&&t.nodeName===d&&(r=t,o=l,i=g.getStyle(r,"list-style-type"),u=o?o["list-style-type"]:"",i===(u=null===u?"":u))?(n=t,e=g.rename(e,m),t.appendChild(e)):(n=g.create(d),e.parentNode.insertBefore(n,e),n.appendChild(e),e=g.rename(e,m)),s=g,a=e,c=["margin","margin-right","margin-bottom","margin-left","margin-top","padding","padding-right","padding-bottom","padding-left","padding-top"],v.each(c,function(e){var n;return s.setStyle(a,((n={})[e]="",n))}),Xn(g,n,l),Jn(f.dom,n)}),f.selection.setRng(I(e)))},Gn=function(e,n,t){return a=t,(s=n)&&a&&y(s)&&s.nodeName===a.nodeName&&(i=n,u=t,(o=e).getStyle(i,"list-style-type",!0)===o.getStyle(u,"list-style-type",!0))&&(r=t,n.className===r.className);var r,o,i,u,s,a},Jn=function(e,n){var t,r;if(t=n.nextSibling,Gn(e,n,t)){for(;r=t.firstChild;)n.appendChild(r);e.remove(t)}if(t=n.previousSibling,Gn(e,n,t)){for(;r=t.lastChild;)n.insertBefore(r,n.firstChild);e.remove(t)}},Zn=function(n,e,t,r,o){if(e.nodeName!==r||et(o)){var i=R(n.selection.getRng(!0));v.each([e].concat(t),function(e){!function(e,n,t,r){if(n.nodeName!==t){var o=e.dom.rename(n,t);Xn(e.dom,o,r),Rn(e,Kn(t),o)}else Xn(e.dom,n,r),Rn(e,Kn(t),n)}(n,e,r,o)}),n.selection.setRng(I(i))}else Wn(n)},et=function(e){return"list-style-type"in e},nt={toggleList:function(e,n,t){var r=pe.getParentList(e),o=pe.getSelectedSubLists(e);t=t||{},r&&0<o.length?Zn(e,r,o,n,t):function(e,n,t,r){if(n!==e.getBody())if(n)if(n.nodeName!==t||et(r)||zn(n)){var o=R(e.selection.getRng(!0));Xn(e.dom,n,r);var i=e.dom.rename(n,t);Jn(e.dom,i),e.selection.setRng(I(o)),Rn(e,Kn(t),i)}else Wn(e);else Yn(e,t,r),Rn(e,Kn(t),n)}(e,r,n,t)},mergeWithAdjacentLists:Jn},tt=m.DOM,rt=function(e,n){var t,r=n.parentNode;"LI"===r.nodeName&&r.firstChild===n&&((t=r.previousSibling)&&"LI"===t.nodeName?(t.appendChild(n),E(e,r)&&tt.remove(r)):tt.setStyle(r,"listStyleType","none")),y(r)&&(t=r.previousSibling)&&"LI"===t.nodeName&&t.appendChild(n)},ot=function(n,e){v.each(v.grep(n.select("ol,ul",e)),function(e){rt(n,e)})},it=function(e,n,t,r){var o,i,u=n.startContainer,s=n.startOffset;if(3===u.nodeType&&(t?s<u.data.length:0<s))return u;for(o=e.schema.getNonEmptyElements(),1===u.nodeType&&(u=f.getNode(u,s)),i=new d(u,r),t&&D(e.dom,u)&&i.next();u=i[t?"next":"prev2"]();){if("LI"===u.nodeName&&!u.hasChildNodes())return u;if(o[u.nodeName])return u;if(3===u.nodeType&&0<u.data.length)return u}},ut=function(e,n){var t=n.childNodes;return 1===t.length&&!y(t[0])&&e.isBlock(t[0])},st=function(e,n,t){var r,o,i,u;if(o=ut(e,t)?t.firstChild:t,ut(i=e,u=n)&&i.remove(u.firstChild,!0),!E(e,n,!0))for(;r=n.firstChild;)o.appendChild(r)},at=function(n,e,t){var r,o,i=e.parentNode;if(w(n,e)&&w(n,t)){y(t.lastChild)&&(o=t.lastChild),i===t.lastChild&&b(i.previousSibling)&&n.remove(i.previousSibling),(r=t.lastChild)&&b(r)&&e.hasChildNodes()&&n.remove(r),E(n,t,!0)&&n.$(t).empty(),st(n,e,t),o&&t.appendChild(o);var u=Je(he.fromDom(t),he.fromDom(e))?n.getParents(e,y,t):[];n.remove(e),Y(u,function(e){E(n,e)&&e!==n.getRoot()&&n.remove(e)})}},ct=function(e,n,t,r){var o,i,u,s=e.dom;if(s.isEmpty(r))i=t,u=r,(o=e).dom.$(u).empty(),at(o.dom,i,u),o.selection.setCursorLocation(u);else{var a=R(n);at(s,t,r),e.selection.setRng(I(a))}},ft=function(e,n){var t,r,o,i=e.dom,u=e.selection,s=u.getStart(),a=pe.getClosestListRootElm(e,s),c=i.getParent(u.getStart(),"LI",a);if(c){if((t=c.parentNode)===e.getBody()&&E(i,t))return!0;if(r=A(u.getRng(!0)),(o=i.getParent(it(e,r,n,a),"LI",a))&&o!==c)return n?ct(e,r,o,c):function(e,n,t,r){var o=R(n);at(e.dom,t,r);var i=I(o);e.selection.setRng(i)}(e,r,c,o),!0;if(!o&&!n)return Wn(e),!0}return!1},dt=function(e,n){return ft(e,n)||function(o,i){var u=o.dom,e=o.selection.getStart(),s=pe.getClosestListRootElm(o,e),a=u.getParent(e,u.isBlock,s);if(a&&u.isEmpty(a)){var n=A(o.selection.getRng(!0)),c=u.getParent(it(o,n,i,s),"LI",s);if(c)return o.undoManager.transact(function(){var e,n,t,r;n=a,t=s,r=(e=u).getParent(n.parentNode,e.isBlock,t),e.remove(n),r&&e.isEmpty(r)&&e.remove(r),nt.mergeWithAdjacentLists(u,c.parentNode),o.selection.select(c,!0),o.selection.collapse(i)}),!0}return!1}(e,n)},lt=function(e,n){return e.selection.isCollapsed()?dt(e,n):(r=(t=e).selection.getStart(),o=pe.getClosestListRootElm(t,r),!!(t.dom.getParent(r,"LI,DT,DD",o)||0<pe.getSelectedListItems(t).length)&&(t.undoManager.transact(function(){t.execCommand("Delete"),ot(t.dom,t.getBody())}),!0));var t,r,o},mt=function(n){n.on("keydown",function(e){e.keyCode===l.BACKSPACE?lt(n,!1)&&e.preventDefault():e.keyCode===l.DELETE&&lt(n,!0)&&e.preventDefault()})},gt=lt,pt=function(n){return{backspaceDelete:function(e){gt(n,e)}}},vt=function(n,t){return function(){var e=n.dom.getParent(n.selection.getStart(),"UL,OL,DL");return e&&e.nodeName===t}},ht=function(t){t.on("BeforeExecCommand",function(e){var n=e.command.toLowerCase();"indent"===n?$n(t):"outdent"===n&&qn(t)}),t.addCommand("InsertUnorderedList",function(e,n){nt.toggleList(t,"UL",n)}),t.addCommand("InsertOrderedList",function(e,n){nt.toggleList(t,"OL",n)}),t.addCommand("InsertDefinitionList",function(e,n){nt.toggleList(t,"DL",n)}),t.addCommand("RemoveList",function(){Wn(t)}),t.addQueryStateHandler("InsertUnorderedList",vt(t,"UL")),t.addQueryStateHandler("InsertOrderedList",vt(t,"OL")),t.addQueryStateHandler("InsertDefinitionList",vt(t,"DL"))},yt=function(e){return e.getParam("lists_indent_on_tab",!0)},Nt=function(e){var n;yt(e)&&(n=e).on("keydown",function(e){e.keyCode!==l.TAB||l.metaKeyPressed(e)||n.undoManager.transact(function(){(e.shiftKey?qn(n):$n(n))&&e.preventDefault()})}),mt(e)},St=function(n,i){return function(o){var e=function(e){var n=function(e,n){for(var t=0;t<e.length;t++)if(n(e[t]))return t;return-1}(e.parents,C),t=-1!==n?e.parents.slice(0,n):e.parents,r=v.grep(t,y);o.setActive(0<r.length&&r[0].nodeName===i&&!zn(r[0]))};return n.on("NodeChange",e),function(){return n.off("NodeChange",e)}}},Ot=function(n){var e,t,r,o=function(e){return function(){return n.execCommand(e)}};t="advlist",r=(e=n).settings.plugins?e.settings.plugins:"",-1===v.inArray(r.split(/[ ,]/),t)&&(n.ui.registry.addToggleButton("numlist",{icon:"ordered-list",active:!1,tooltip:"Numbered list",onAction:o("InsertOrderedList"),onSetup:St(n,"OL")}),n.ui.registry.addToggleButton("bullist",{icon:"unordered-list",active:!1,tooltip:"Bullet list",onAction:o("InsertUnorderedList"),onSetup:St(n,"UL")}))};c.add("lists",function(e){return Nt(e),Ot(e),ht(e),pt(e)}),function Ct(){}}(window);
