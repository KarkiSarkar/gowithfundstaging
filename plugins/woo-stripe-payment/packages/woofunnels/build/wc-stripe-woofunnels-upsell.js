(()=>{var e,t,n,r,o,i,a,c,u,s,l,d,p={427:(e,t,n)=>{"use strict";n.r(t),n.d(t,{loadStripe:()=>s});var r="https://js.stripe.com/v3",o=/^https:\/\/js\.stripe\.com\/v3\/?(\?.*)?$/,i="loadStripe.setLoadParameters was called but an existing Stripe.js script already exists in the document; existing script parameters will be used",a=null,c=Promise.resolve().then((function(){return e=null,null!==a||(a=new Promise((function(t,n){if("undefined"!=typeof window&&"undefined"!=typeof document)if(window.Stripe&&e&&console.warn(i),window.Stripe)t(window.Stripe);else try{var a=function(){for(var e=document.querySelectorAll('script[src^="'.concat(r,'"]')),t=0;t<e.length;t++){var n=e[t];if(o.test(n.src))return n}return null}();a&&e?console.warn(i):a||(a=function(e){var t=e&&!e.advancedFraudSignals?"?advancedFraudSignals=false":"",n=document.createElement("script");n.src="".concat(r).concat(t);var o=document.head||document.body;if(!o)throw new Error("Expected document.body not to be null. Stripe.js requires a <body> element.");return o.appendChild(n),n}(e)),a.addEventListener("load",(function(){window.Stripe?t(window.Stripe):n(new Error("Stripe.js not available"))})),a.addEventListener("error",(function(){n(new Error("Failed to load Stripe.js"))}))}catch(e){return void n(e)}else t(null)}))),a;var e})),u=!1;c.catch((function(e){u||console.warn(e)}));var s=function(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];u=!0;var r=Date.now();return c.then((function(e){return function(e,t,n){if(null===e)return null;var r=e.apply(void 0,t);return function(e,t){e&&e._registerWrapper&&e._registerWrapper({name:"stripe-js",version:"1.54.2",startTime:t})}(r,n),r}(e,t,r)}))}},428:e=>{"use strict";e.exports=window.jQuery},994:e=>{e.exports=function(e){return e&&e.__esModule?e:{default:e}},e.exports.__esModule=!0,e.exports.default=e.exports}},f={};function w(e){var t=f[e];if(void 0!==t)return t.exports;var n=f[e]={exports:{}};return p[e](n,n.exports,w),n.exports}w.d=(e,t)=>{for(var n in t)w.o(t,n)&&!w.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},w.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),w.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t=w(994),n=w(427),r=t(w(428)),o={},i=function(){(0,r.default)(document).on("wfocu_external",a),window.addEventListener("hashchange",c),wfocuCommons.addFilter("wfocu_front_charge_data",u),(0,n.loadStripe)(s("publishableKey"),s("account")?{stripeAccount:s("account")}:{}).then((function(t){e=t})).catch((function(e){console.log(e)}))},a=function(e,t){l("bucket",t)},c=function(t){var n=t.newURL.match(/response=(.*)/);if(n){var r,o=JSON.parse(window.atob(decodeURIComponent(n[1])));null===(r=s("bucket"))||void 0===r||null===(r=r.swal)||void 0===r||r.hide(),l("paymentIntent",o.payment_intent),history.pushState({},"",window.location.pathname+window.location.search),e.confirmCardPayment(o.client_secret).then((function(e){e.error?d():(l("paymentComplete",!0),s("bucket").sendBucket())})).catch((function(e){console.log(e)}))}},u=function(e){return e._payment_intent=s("paymentIntent"),e},s=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null;return o.hasOwnProperty(e)||(o[e]=t),o[e]},l=function(e,t){o[e]=t},d=function(){s("bucket").inOfferTransaction=!1,s("bucket").EnableButtonState(),s("bucket").HasEventRunning=!1},(0,r.default)(document).on("wfocuBucketCreated",(function(e,t){var n;o=null===(n=window)||void 0===n||null===(n=n.wfocu_vars)||void 0===n?void 0:n.stripeData,l("bucket",t),i()})),(this.wc_stripe=this.wc_stripe||{})["wc-stripe-woofunnels-upsell"]={}})();
//# sourceMappingURL=wc-stripe-woofunnels-upsell.js.map