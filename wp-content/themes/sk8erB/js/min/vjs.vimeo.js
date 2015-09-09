// Vimeo Video.js Support
        var VimeoState={UNSTARTED:-1,ENDED:0,PLAYING:1,PAUSED:2,BUFFERING:3};videojs.Vimeo=videojs.MediaTechController.extend({init:function(a,b,c){if(videojs.MediaTechController.call(this,a,b,c),"undefined"!=typeof b.source)for(var d in b.source)a.options()[d]=b.source[d];if(this.player_=a,this.player_el_=document.getElementById(this.player_.id()),"undefined"!=typeof b.source)for(var d in b.source)a.options()[d]=b.source[d];this.player_.controls(!1),this.id_=this.player_.id()+"_vimeo_api",this.el_=videojs.Component.prototype.createEl("iframe",{id:this.id_,className:"vjs-tech",scrolling:"no",marginWidth:0,marginHeight:0,frameBorder:0,webkitAllowFullScreen:"true",mozallowfullscreen:"true",allowFullScreen:"true"}),this.player_el_.insertBefore(this.el_,this.player_el_.firstChild),this.baseUrl=document.location.protocol+"//player.vimeo.com/video/",this.vimeo={},this.vimeoInfo={};var e=this;this.el_.onload=function(){e.onLoad()},this.startMuted=a.options().muted,this.src(a.options().src)}}),videojs.Vimeo.prototype.dispose=function(){this.vimeo.api("unload"),delete this.vimeo,this.el_.parentNode.removeChild(this.el_),videojs.MediaTechController.prototype.dispose.call(this)},videojs.Vimeo.prototype.src=function(a){this.isReady_=!1;var b=/^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/,c=a.match(b);c&&(this.videoId=c[5]);var d={api:1,byline:0,portrait:0,show_title:0,show_byline:0,show_portait:0,fullscreen:1,player_id:this.id_,autoplay:this.player_.options().autoplay?1:0,loop:this.player_.options().loop?1:0};this.el_.src=this.baseUrl+this.videoId+"?"+videojs.Vimeo.makeQueryString(d)},videojs.Vimeo.prototype.load=function(){},videojs.Vimeo.prototype.play=function(){this.vimeo.api("play")},videojs.Vimeo.prototype.pause=function(){this.vimeo.api("pause")},videojs.Vimeo.prototype.paused=function(){return this.vimeoInfo.state!==VimeoState.PLAYING&&this.vimeoInfo.state!==VimeoState.BUFFERING},videojs.Vimeo.prototype.currentTime=function(){return this.vimeoInfo.time||0},videojs.Vimeo.prototype.setCurrentTime=function(a){this.vimeo.api("seekTo",a),this.player_.trigger("timeupdate")},videojs.Vimeo.prototype.duration=function(){return this.vimeoInfo.duration||0},videojs.Vimeo.prototype.buffered=function(){return videojs.createTimeRange(0,this.vimeoInfo.buffered*this.vimeoInfo.duration||0)},videojs.Vimeo.prototype.volume=function(){return this.vimeoInfo.muted?this.vimeoInfo.muteVolume:this.vimeoInfo.volume},videojs.Vimeo.prototype.setVolume=function(a){this.vimeo.api("setvolume",a),this.vimeoInfo.volume=a,this.player_.trigger("volumechange")},videojs.Vimeo.prototype.muted=function(){return this.vimeoInfo.muted||!1},videojs.Vimeo.prototype.setMuted=function(a){a?(this.vimeoInfo.muteVolume=this.vimeoInfo.volume,this.setVolume(0)):this.setVolume(this.vimeoInfo.muteVolume),this.vimeoInfo.muted=a,this.player_.trigger("volumechange")},videojs.Vimeo.prototype.onReady=function(){this.isReady_=!0,this.triggerReady(),this.startMuted&&(this.setMuted(!0),this.startMuted=!1)},videojs.Vimeo.prototype.onLoad=function(){this.vimeo.api&&(this.vimeo.api("unload"),delete this.vimeo),this.vimeo=$f(this.el_),this.vimeoInfo={state:VimeoState.UNSTARTED,volume:1,muted:!1,muteVolume:1,time:0,duration:0,buffered:0,url:this.baseUrl+this.videoId,error:null};var a=this;this.vimeo.addEvent("ready",function(){a.onReady(),a.vimeo.addEvent("loadProgress",function(b){a.onLoadProgress(b)}),a.vimeo.addEvent("playProgress",function(b){a.onPlayProgress(b)}),a.vimeo.addEvent("play",function(){a.onPlay()}),a.vimeo.addEvent("pause",function(){a.onPause()}),a.vimeo.addEvent("finish",function(){a.onFinish()}),a.vimeo.addEvent("seek",function(b){a.onSeek(b)})})},videojs.Vimeo.prototype.onLoadProgress=function(a){var b=!this.vimeoInfo.duration;this.vimeoInfo.duration=a.duration,this.vimeoInfo.buffered=a.percent,this.player_.trigger("progress"),b&&this.player_.trigger("durationchange")},videojs.Vimeo.prototype.onPlayProgress=function(a){this.vimeoInfo.time=a.seconds,this.player_.trigger("timeupdate")},videojs.Vimeo.prototype.onPlay=function(){this.vimeoInfo.state=VimeoState.PLAYING,this.player_.trigger("play")},videojs.Vimeo.prototype.onPause=function(){this.vimeoInfo.state=VimeoState.PAUSED,this.player_.trigger("pause")},videojs.Vimeo.prototype.onFinish=function(){this.vimeoInfo.state=VimeoState.ENDED,this.player_.trigger("ended")},videojs.Vimeo.prototype.onSeek=function(a){this.vimeoInfo.time=a.seconds,this.player_.trigger("timeupdate"),this.player_.trigger("seeked")},videojs.Vimeo.prototype.onError=function(a){this.player_.error=a,this.player_.trigger("error")},videojs.Vimeo.isSupported=function(){return!0},videojs.Vimeo.prototype.supportsFullScreen=function(){return!1},videojs.Vimeo.canPlaySource=function(a){return"video/vimeo"==a.type},videojs.Vimeo.makeQueryString=function(a){var b=[];for(var c in a)a.hasOwnProperty(c)&&b.push(encodeURIComponent(c)+"="+encodeURIComponent(a[c]));return b.join("&")};var Froogaloop=function(){function a(b){return new a.fn.init(b)}function g(a,b,c){if(!c.contentWindow.postMessage)return!1;var d=c.getAttribute("src").split("?")[0],e=JSON.stringify({method:a,value:b});"//"===d.substr(0,2)&&(d=window.location.protocol+d),c.contentWindow.postMessage(e,d)}function h(a){var b,c;try{b=JSON.parse(a.data),c=b.event||b.method}catch(e){}if("ready"!=c||d||(d=!0),a.origin!=f)return!1;var g=b.value,h=b.data,i=""===i?null:b.player_id,k=j(c,i),l=[];return k?(void 0!==g&&l.push(g),h&&l.push(h),i&&l.push(i),l.length>0?k.apply(null,l):k.call()):!1}function i(a,c,d){d?(b[d]||(b[d]={}),b[d][a]=c):b[a]=c}function j(a,c){return c?b[c][a]:b[a]}function k(a,c){if(c&&b[c]){if(!b[c][a])return!1;b[c][a]=null}else{if(!b[a])return!1;b[a]=null}return!0}function l(a){"//"===a.substr(0,2)&&(a=window.location.protocol+a);for(var b=a.split("/"),c="",d=0,e=b.length;e>d&&3>d;d++)c+=b[d],2>d&&(c+="/");return c}function m(a){return!!(a&&a.constructor&&a.call&&a.apply)}var b={},d=!1,f=(Array.prototype.slice,"");return a.fn=a.prototype={element:null,init:function(a){return"string"==typeof a&&(a=document.getElementById(a)),this.element=a,f=l(this.element.getAttribute("src")),this},api:function(a,b){if(!this.element||!a)return!1;var c=this,d=c.element,e=""!==d.id?d.id:null,f=m(b)?null:b,h=m(b)?b:null;return h&&i(a,h,e),g(a,f,d),c},addEvent:function(a,b){if(!this.element)return!1;var c=this,e=c.element,f=""!==e.id?e.id:null;return i(a,b,f),"ready"!=a?g("addEventListener",a,e):"ready"==a&&d&&b.call(null,f),c},removeEvent:function(a){if(!this.element)return!1;var b=this,c=b.element,d=""!==c.id?c.id:null,e=k(a,d);"ready"!=a&&e&&g("removeEventListener",a,c)}},a.fn.init.prototype=a.fn,window.addEventListener?window.addEventListener("message",h,!1):window.attachEvent("onmessage",h),window.Froogaloop=window.$f=a}();